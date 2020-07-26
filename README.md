## About Business Classic Directory Service

* The application shows an approach to build a Laravel API to provide access to CRUD operations for books storage. 

* It also shows how to access an external api within the laravel application. 

* Tests was write in PHP Codeception. 

## Environment Setup

```
php 7.2.5
apache 2.4
mysql 5.7
```

## Project Setup
```sh
git clone https://github.com/olawolemoses/aureole_api.git aurole_api
cd aurole_api
```

Install PHP dependencies:

```sh
composer install
```

Setup configuration:

```sh
cp .env.example .env
```

Generate application key:

```sh
php artisan key:generate
```

Setup a (MySQL, Postgres), database accordingly & Run database migrations:

```sh
create database `aurole_db`
```

```sh
php artisan migrate:refresh
```

Run the dev server (the output will give the address):

```sh
php artisan serve
```

You're ready to go! Access Postman:


```sh
Routes
http://localhost:8000/api/external-books
POST http://localhost:8000/api/v1/books
GET http://localhost:8000/api/v1/books
PATCH http://localhost:8000/api/v1/books/:id
DELETE http://localhost:8000/api/v1/books/:id
SHOW http://localhost:8000/api/v1/books/:id
```

YTo run Tests:


```sh
Tests
php vendor/bin/codecept run tests/api/CreateBookCest.php
```