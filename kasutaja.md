# Kasutaja

See dokumentatsioon kirjeldab `kasutaja.php` skripti funktsionaalsust.

## Kirjeldus

See PHP skript toob ja kuvab andmeid andmebaasist konsultatsioonide kohta. See võimaldab kasutajatel filtreerida konsultatsioone õpetaja nime ja perioodi järgi.

## Kasutamine

Selle skripti kasutamiseks lisage see oma projekti ja veenduge, et järgmised failid oleksid olemas:

- `navi.php`: Navigeerimisfail
- `conf.php`: Konfiguratsioonifail
- `kasutaja.css`: CSS-fail 


## Funktsioonid

### `printTable($data)`

See funktsioon trükib HTML-tabeli antud andmejada põhjal.

- Parameetrid:
  - `$data`: Konsultatsioonide andmete massiiv

## Sõltuvused

- PHP (koos MySQLi laiendusega)

## Paigaldamine

1. Kloonida repositoorium.
2. Paigutage vajalikud failid (`navi.php`, `conf.php`, `kasutaja.css`) vastavatesse kohtadesse.
3. Konfigureerida andmebaasiühendus `conf.php` failis.
4. Päästa skriptile juurde veebiserveri kaudu koos PHP-toega.

## Konsultatsioonide filtreerimine õpetaja nime järgi
include('kasutaja.php?opetaja=OpetajaNimi');

## Konsultatsioonide filtreerimine perioodi järgi
include('kasutaja.php?periood=PerioodiNumber');

