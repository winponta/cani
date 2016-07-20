# Cani (Can I)

Cani, or "Can I" project, is a Laravel 5 project that implement a simple ACL based on
noSql databases. The first implementation is focused on MongoDB, 
using [jenssegers/mongodb](https://github.com/jenssegers/laravel-mongodb) driver.

This project is fully based on https://github.com/spatie/laravel-permission package.

## Warning

**WIP -- this project is in its initial development, please come back in a few days**

** This project is tested on Laravel 5.2 version, not sure if all features work on 5.1. **

## Installation

In `composer.json`

```php
"require": {
        ...
        "winponta/cani": "0.0.*",
        ...
    },
```

Then run `composer update`.

In `config/app.path` at providers section

`Winponta\Cani\Providers\CaniServiceProvider::class,`
