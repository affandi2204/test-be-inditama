
# SAMPLE LARAVEL REST API

Powered by LARAVEL and MYSQL

## Installation

Make sure PHP 8 or above, MySQL, and composer is installed in your machine.
Clone the app :

```sh
git clone https://github.com/affandi2204/test-be-inditama.git
cd test-be-inditama
```

Install the composer library

```sh
composer install
```

Or you can use this instead, if library doesn't installed

```sh
composer install --ignore-platform-reqs
```

Copy the .env.example file in your root folder, name it .env
you also change the value of variable environment 

```sh
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=test_be_inditama
DB_USERNAME=root
DB_PASSWORD=
```

Generate jwt secret

```sh
php artisan jwt:secret
```

Storage link

```sh
php artisan storage:link
```

migration and Seed the tables

```sh
php artisan migrate
php artisan db:seed
```

to make sure can running helper class

```sh
composer dump-autoload
```

Run the server

```sh
php artisan serve
```

It will listen for the port 8000, make sure your API consumer is directing to it.
