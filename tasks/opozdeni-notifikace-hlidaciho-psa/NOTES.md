# Implementační poznámky — Opoždění notifikace hlídacího psa

## Výchozí stav

- `WatchedProduct` (`app/models/watched_product.php`) — záznam zájmu o naskladnění (`product_id`, `user_id`/`email`, `notified`, `notified_at`).
- `WatchedProduct::GetWatchedProductsToNotify()` — vrací vše s `notified=false`, kde je produkt aktuálně skladem (sklady `applicable_to_eshop` minus blokace), viditelný a nesmazaný.
- `WatchdogNotifierRobot` (`robots/watchdog_notifier_robot.php`), spouštěný `local_scripts/robots_regular` každých 5 minut, pro každý záznam z `GetWatchedProductsToNotify()` hned pošle mail a zavolá `markAsNotified()`.
- Watchlist vzniká jen u produktů, které aktuálně nejde objednat (`!$product->canBeOrdered()`), takže typicky se při naskladnění najednou stane "eligible" celá fronta zájemců nahromaděná za dobu nedostupnosti.

## Dohodnutý návrh

### 1. Nový sloupec `watched_products.notify_at` (TIMESTAMP, nullable)

Nahrazuje přímé "je skladem → pošli hned" rozhodování třístavovým plánováním:

- `NULL` — zájemce čeká na naskladnění, zatím nebyl naplánován.
- vyplněno, v budoucnosti — naplánováno, čeká se na čas odeslání.
- vyplněno, `<= NOW()` — má se odeslat.

### 2. Tři kroky v `WatchedProduct`, volané v tomto pořadí z `WatchdogNotifierRobot::run()`

1. **`ScheduleNotifications()`** — najde `notified=false` záznamy produktů, které jsou aktuálně skladem/viditelné/nesmazané, seřadí je `product_id, created_at, id` a pro každý produkt postupně očísluje pořadí (rank 1,2,3,…) mezi **všemi** takto nalezenými (i už naplánovanými — kvůli správnému pořadí nových zájemců), ale `notify_at` nastaví jen těm, které ho ještě nemají (`NULL`):
   - `effective_rank = min(rank, NOTIFICATION_STAGGER_LIMIT)` (pokud limit 0 → bez omezení, vždy rank 1)
   - `notify_at = NOW() + NOTIFICATION_DELAY_MINUTES minut + (effective_rank-1) * NOTIFICATION_STAGGER_MINUTES minut`
2. **`CancelStaleSchedules()`** — záznamy s `notified=false` a nastaveným `notify_at`, jejichž produkt mezitím přestal být dostupný (vyprodán/skryt/smazán), dostanou `notify_at = NULL` zpět. Tím padá naplánované opožděné odeslání (bod 1 ze zadání) a zájemce čeká na další naskladnění, kdy dostane nové (čerstvé) pořadí.
3. **`GetWatchedProductsToNotify()`** (ponechaný název kvůli robotovi/testům) — vrátí `notified=false`, `notify_at IS NOT NULL AND notify_at <= NOW()`, a produkt stále dostupný (obranná kontrola proti race condition mezi kroky 2 a 3). Robot jako dosud pošle e-mail a zavolá `markAsNotified()`.

Edge-case ze zadání bodu 2 ("vyprodáno hned po první odeslané notifikaci") řeší se sám: zbylí zájemci mají `notified=false`, jejich `notify_at` buď ještě nenastal, nebo je zrušen krokem 2 při příštím běhu — hlídání jim zůstává aktivní, nic navíc se implementovat nemusí.

### 3. Konfigurace přes `SystemParameter` (vzor `orders.withdrawals.*`)

Nové kódy (typ integer, `mandatory=true`), načtené v `config/after_initialize.php` do statických property `WatchedProduct`:

| code | default | property |
|---|---|---|
| `watchdog.notification_delay_minutes` | `0` | `WatchedProduct::$NOTIFICATION_DELAY_MINUTES` |
| `watchdog.notification_stagger_minutes` | `10` | `WatchedProduct::$NOTIFICATION_STAGGER_MINUTES` |
| `watchdog.notification_stagger_limit` | `10` | `WatchedProduct::$NOTIFICATION_STAGGER_LIMIT` |

Admin je pak může kdykoliv změnit přes `admin/system_parameters` bez deploye.

### 4. Migrace

- `db/migrations/0341_zz02_adding_notify_at_to_watched_products.sql` — `ALTER TABLE watched_products ADD notify_at TIMESTAMP;` (navazuje na `0341_zz01_altering_watched_products.sql` jako další korekce tabulky `watched_products`)
- `db/migrations/0131_zz04_adding_watchdog_system_parameters_migration.php` — vloží 3 řádky do `system_parameters` (vzor `Zz03AddingOrderWithdrawalsSystemParametersMigration`, navazuje na `0131_zz01`–`zz03`).

### 5. Testy

- Upravit `test/models/tc_watched_product.php` tak, aby volal `ScheduleNotifications()` před `GetWatchedProductsToNotify()` (odpovídá reálnému běhu robota), a přidat případy pro:
  - delay > 0 (notifikace se nevrátí hned, i když je skladem),
  - stagger (2. zájemce nedostane `notify_at` tak brzy jako 1.),
  - cancel (vyprodání před uplynutím delay zruší `notify_at`),
  - stagger limit (zájemci nad limit dostanou stejný `notify_at` jako poslední "čekající" pozice).
- Otestovat `WatchdogNotifierRobot` (pokud má test) nebo přidat nový `test/models/tc_watched_product.php` scénář end-to-end.

## Implementační poznámka: timezone

PHP (`date()`, projektový helper `now()`) běží v `Europe/Prague`, zatímco Postgres session timezone je `Etc/UTC` — `date("Y-m-d H:i:s")` tedy vrací jiný čas než SQL `NOW()`. Aby byl čas odvozen konzistentně na straně PHP aplikace (ne databáze), `notify_at` se počítá v `ScheduleNotifications()` v PHP (`strtotime("+N minutes")`) a `GetWatchedProductsToNotify()` porovnává `notify_at<=:now` s `:now` svázaným na `now()` (PHP), místo SQL `NOW()` — vzor převzatý z `OneTimePassword::GetActiveInstanceFor()` (`expires_at>:now`, `"bind_ar" => [":now" => now()]`). Obě strany porovnání tak používají stejný (PHP) zdroj času.

## Otevřené drobnosti k doladění při psaní kódu

- Název metody/sloupce ponechán `notify_at` / `GetWatchedProductsToNotify()`, `ScheduleNotifications()`, `CancelStaleSchedules()` — lze změnit, pokud při psaní kódu padne lepší název.
- `NOTIFICATION_STAGGER_LIMIT = 0` bude znamenat "bez stagger limitu" (nikdy nepřestat čekat) — nutno ošetřit dělení/`min()` tak, aby `0` nezpůsobilo `effective_rank = 0`.
