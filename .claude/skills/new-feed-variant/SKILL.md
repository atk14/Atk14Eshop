---
name: new-feed-variant
description: This skill should be used when the user wants to "add a new feed", "add a feed variant", "create a feed for another country", "add a Slovak feed", "add an English feed", "přidat feed", "přidat variantu feedy", or needs to add a new language/region/currency variant of an existing product feed in an ATK14 e-shop project.
version: 1.1.0
---

# New Feed Variant

Přidá novou jazykovou/regionální variantu produktového feedy do ATK14 projektu.

## Mapování srovnávacích služeb na generátory

| Srovnávací služba | Generátor |
|---|---|
| Google Shopping | `GoogleShoppingGenerator` |
| Google Merchants | `GoogleMerchantsGenerator` |
| Heureka | `HeurekaCzGenerator` |
| Zboží.cz / Zboži | `ZboziCzGenerator` |

Pokud uživatel zadá službu, která v tabulce není, podívej se na existující generátory v `$feeds_config` a nabídni nejbližší alternativu, nebo se zeptej.

## Postup

1. Najdi soubor robota pro generování feedů. Hledej glob `robots/*feed*robot.php` nebo `robots/product_feed_generator_robot.php`. Pokud existuje více souborů, zeptej se uživatele který použít.

2. Přečti soubor robota a zjisti:
   - Název projektového base readeru (třída dědící z `Atk14EshopReader` nebo `ProductFeedGenerator\Reader\Atk14EshopReader`) — typicky `XxxReader`
   - Existující klíče v `$feeds_config` (např. `google_shopping`, `heureka_cz`, ...)
   - Existující readery instanciované v `run()`

3. Zeptej se uživatele na tyto parametry:
   - **Název nového feedy** — klíč do `$feeds_config`, např. `google_shopping_sk`
   - **Srovnávací služba** — podle ní urči generátor z tabulky výše
   - **Jazyk** (`lang`) — např. `sk`, `en`, `cs`; pokud není zadán, použij výchozí
   - **Měna** — např. `EUR`, `CZK`; pokud není zadána, použij výchozí (CZK)
   - **Hostname** — produkční doména (např. `kmitex.sk`); jen pokud se liší od výchozí; dev hostname odvoď přidáním `.localhost` místo TLD

4. Urči reader:
   - Pokud jsou jazyk, měna i hostname výchozí, hledej existující instanciovaný reader bez parametrů (typicky `$reader = new XxxReader()`) — použij ho přímo, bez vytváření nové třídy.
   - Pokud kombinace jazyk+měna+hostname odpovídá některému existujícímu readeru v `run()`, použij jeho proměnnou.
   - Jinak vytvoř novou Reader třídu (viz krok 5a).

5. Implementuj změny v souboru robota:

   a) Pokud je potřeba nový reader, přidej jeho třídu na konec souboru:

   ```php
   /**
    * Reader pro [popis] feed - jazyk [LANG], mena [CURRENCY], domena [HOSTNAME]
    */
   class [Prefix]Reader extends [BaseReader] {

       function __construct() {
           parent::__construct([
               "lang"     => "[lang]",
               "currency" => "[CURRENCY]",
               "hostname" => PRODUCTION ? "[hostname.tld]" : "[hostname.localhost]",
           ]);
       }
   }
   ```

   Pozor: pokud je jazyk, měna i hostname výchozí, žádná nová třída ani instanciace není potřeba.
   Pokud je měna výchozí (CZK), vynech `"currency"`.
   Pokud je hostname výchozí, vynech `"hostname"`.

   b) Pokud byl vytvořen nový reader, přidej jeho instanciaci do metody `run()` spolu s ostatními readery:
   ```php
   $reader_[suffix] = new [Prefix]Reader();
   ```

   c) Přidej záznam do `$feeds_config`:
   ```php
   "[feed_name]" => [
       "class"  => \ProductFeedGenerator\Generator\[GeneratorClass]::class,
       "reader" => $reader_[proměnná],
       "output" => "product_feeds/[feed_name].xml",
   ],
   ```

6. Zkontroluj výsledný soubor — ověř že:
   - Případná nová třída readeru syntakticky správně dědí z base readeru
   - `$feeds_config` obsahuje nový záznam
   - Proměnná readeru je definována před `$feeds_config`

7. Aktivace feedy v local_scripts:

   a) Prohledej adresář `local_scripts/` a najdi soubory volající `product_feed_generator`. Typicky je to `robots_daily`.

   b) Zeptej se uživatele: **„Chceš nový feed aktivovat přidáním do [nalezený soubor]?"** Ukaž mu aktuální podobu příslušného řádku.

   c) Pokud ano, přidej název nového feedy jako další argument na stejný řádek kde jsou ostatní feedy:
   ```
   ./scripts/robot_runner product_feed_generator heureka_cz zbozi_cz google_shopping google_shopping_sk
   ```

   d) Pokud `local_scripts/` neexistuje nebo volání `product_feed_generator` v žádném souboru není, informuj uživatele a přeskoč tento krok.

8. Informuj uživatele o tom, co bylo přidáno, a uveď příkaz pro ruční otestování feedy:
   ```
   ./scripts/robot_runner product_feed_generator [feed_name]
   ```
