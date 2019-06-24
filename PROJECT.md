###Installation

- Run composer install to install all dependancies
- Create empty database (mws by default) 
- Change .env.example to .env and populate information to connect to the MySQL server
- in Terminal run, in project root `php artisan key:generate` to generate application security key
php artisan ide-helper:generate
- Run `php artisan migrate --seed` to create database tables and populate them with some sample data. 

### Info
- make sure all `storage` directory and `bootstrap/cache` are writable

###Plugins