<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Basic Marketplace API Service

API Services that contain list of products, carts, orders and their processes.
This is monolith service for client and admin with specific authentication.

## Table Of Contents

[[_TOC_]]


## Requirements
- Laravel 10.x (PHP 8.1)
- Composer 2.4.3


## Installation

### Clone The Project
Open your terminal, go to the directory that you will install this project, then run the following command:

```bash
git clone https://github.com/taufiktop/Basic-Marketplace-API.git
```

### Package Installation
```bash
composer install
```

### Configure Environment and Databases

```bash
cp .env.example .env
```

create database

edit .env, set according to database name, user and password

```bash
php artisan key:generate

php artisan config:cache
```

### Run Migration and Seeder

```bash
php artisan migrate

php artisan db:seed
```

### Run Application

```bash
php artisan serve
```

## API Collection Postman

https://api.postman.com/collections/13003053-a9db0cd0-ef37-48cf-8699-efda028407f7?access_key=PMAT-01HNKZDBB1RY5YAT5VNK2RCQAW

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
