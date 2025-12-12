#	Moja JDG (laravel training project)
Blog page with custom CMS to manage posts.  
Small online shop with customer shopping cart, order creation and PayU online payments.

This app is my __training project__ (for educational purpose) made in __Laravel__ + __Livewire__.

## Project scope

#### 1. Web page (accesible by anyone)

	1. Home Page
		- hero section with presentation of last added post
		- taxation calculator for sole proprietorship
		- contact form
		- slider - products presentation
	2. Blog Page (Wszystko o JDG | Blog)
	3. Shop Page (Nasze produkty | Sklep)
		- products presentation
		- shopping cart
		- order form
		- PayU integration for online payments
	4. AboutUs Page (O nas)

#### 2. User panel

	1. User orders list

#### 3. Administrator panel

	1. Blog posts management
	2. Products management
	3. Orders management

## Local instalation
	1. Make sure you have installed PHP (ver. 8.2 or higher) and Composer
		- Install [PHP ver. 8.2](https://www.php.net/downloads)
		- Install [Composer](https://getcomposer.org/download/)
	2. Install or enable PHP extensions:
		- Linux users:  
			Install PHP extensions:  
			```
			sudo apt-get install php8.2-mbstring
			sudo apt-get install php8.2-xml
			sudo apt-get install php8.2-sqlite3
			```
		- Windows users:  
			Enable mbstring, xml and sqlite3 extensions in php.ini file
	3. Clone repository `git clone`
	4. Install PHP dependencies `composer install`
	5. Create a Copy of the Environment Variable File `cp .env.example .env` and provide required variables
	6. Generate Application Key `php artisan key:generate`
	7. Run Migrations and Seeders `php artisan migrate:fresh --seed`
	8. Install node modules `npm install`
	9. Run developer server localy 'run dev server `composer run dev`

## Online preview

You can see working app here: [jdg.seeuinweb.pl](https://jdg.seeuinweb.pl)  
To try out Administrator Panel use credentials:  
login: admin@jdg.com  
password: #SuperSecret123