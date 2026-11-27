# TODO

- [x] Migrace `0341_zz02_adding_notify_at_to_watched_products.sql`: přidat sloupec `watched_products.notify_at` (TIMESTAMP, nullable)
- [x] Migrace `0131_zz04_adding_watchdog_system_parameters_migration.php`: přidat `system_parameters` řádky `watchdog.notification_delay_minutes` (0), `watchdog.notification_stagger_minutes` (10), `watchdog.notification_stagger_limit` (10)
- [x] `config/after_initialize.php`: načíst nové parametry do `WatchedProduct::$NOTIFICATION_DELAY_MINUTES` / `$NOTIFICATION_STAGGER_MINUTES` / `$NOTIFICATION_STAGGER_LIMIT`
- [x] `app/models/watched_product.php`:
  - [x] přidat statické property s defaulty
  - [x] `ScheduleNotifications()` — naplánuje `notify_at` pro nově dostupné/nenaplánované zájemce, s ohledem na pořadí (`created_at`) a stagger limit
  - [x] `CancelStaleSchedules()` — zruší `notify_at` u zájemců, jejichž produkt mezitím přestal být dostupný
  - [x] upravit `GetWatchedProductsToNotify()` na finální výběr (`notify_at <= NOW()` + stále dostupné)
- [x] `robots/watchdog_notifier_robot.php`: zavolat `ScheduleNotifications()` a `CancelStaleSchedules()` před hlavní smyčkou
- [x] `test/models/tc_watched_product.php`: upravit stávající test + přidat scénáře pro delay, stagger, stagger limit, cancel-při-vyprodání
- [x] ověřit `./scripts/run_unit_tests tc_watched_product` po změně (5 testů, 15 assertions, OK)
- [x] zkontrolovat, zda `admin/system_parameters` správně zobrazí/edituje nové parametry (bez nutnosti úpravy admin controlleru, pokud je sekce obecná) — nebylo ověřeno v prohlížeči
