
#	Strona blogowa/kalkulator/sklep

Projekt w trakcie realizacji !!!

## Struktura strony

1. Strona główna
	- prezentacja autora i bloga
	- kalkulator
	  - 2 etapowy formularz
	  - prezentacja wyników
	  - możliwość zapisu wyników na koncie użytkownika / możliwość eksportu do pdf
	- formularz kontaktowy
2. Blog z wyszukiwarką
3. Panel użytkownika
	- edycja danych użytkownika
	- przegląd zapisanych raportów
	- ulubione artykuły
4. Panel administratora
	- przegląd wszystkich raportów i użytkowników
	- możliwość usunięcia użytkownika, jego danych i raportów
	- przegląd postów blogowych
	- kreator postów (dodawanie tekstu, zdjęć, video)
	- edycja istniejących postów
	- przegląd zamówień / faktur
5. Sprzedaż e-booka
	- prezentacja produktów
	- koszyk
	- płatności online PayU / faktura

## Instalacja

1. Install [PHP ver. 8.2](https://www.php.net/downloads)
2. Install [Composer](https://getcomposer.org/download/)
3. Linux users:  
	Install PHP extensions:  
	```
	sudo apt-get install php8.2-mbstring
	sudo apt-get install php8.2-xml
	sudo apt-get install php8.2-sqlite3
	```
4. Windows users:  
	Enable mbstring, xml and sqlite3 extensions in php.ini file
5. Clone repository `git clone `
6. Install php dependencies `composer install`
7. Create a Copy of the Environment File `cp .env.example .env`
8. Generate Application Key `php artisan key:generate`
9. Run Migrations and Seeders `php artisan migrate:fresh --seed`
10. Install node modules `npm install`
11. run dev server `composer run dev`