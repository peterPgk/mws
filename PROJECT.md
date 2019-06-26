###Installation

- Run composer install to install all dependancies
- Create empty database (mws by default) 
- Change .env.example to .env and populate information to connect to the MySQL server
- in Terminal run, in project root `php artisan key:generate` to generate application security key
php artisan ide-helper:generate
- Run `php artisan migrate --seed` to create database tables and populate them with some sample data. 

- npm install
- npm run dev

### Info
- make sure all `storage` directory and `bootstrap/cache` are writable

###Plugins
- Form Requests
- CanEdit Middleware

### TODO
- Because of use of VueCloneya plugin, need a little tweak to work correctly with error messages and old inputs. 
- Customize error messages in Form Requests for fields of type `value[]`, to return name different then default `value.0`.
This depends from the above one. 
