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

In the same file, under the aliases array, you may want to add the Cani Facade.

`'Cani'  =>  Winponta\Cani\Facades\Cani::class,`

Save the file and then run:

`php artisan vendor:publish --provider="Winponta\Cani\Providers\CaniServiceProvider"`

This command will publish the cani's config file inside your config directory.

## Configuration

Inside the `config/cani.php` you'll have the following options:

### Models

#### Permission
Which Eloquent Model should be used to retrieve your permissions. Your model must implement the `Winponta\Cani\Contracts\Permission` contract.

#### Role
Which model should be used to retrieve your roles. Your model must implement the `Winponta\Cani\Contracts\Role` contract.

### Collections

#### Users
The collection your application uses for users. This collection's model will be using the `CanHavePermissions` and `CanHaveRoles` traits.

#### Roles
The collection your application uses for roles. When using the `CanHaveRoles` trait we need to know which collection should be used to retrieve your roles.

#### Permissions 
The collection your application uses for permissions. When using the `CanHavePermissions` trait we need to know which collection should be used to retrieve your permissions.

