# Google Adsense Ads for Laravel 6.0+

[![License](https://poser.pugx.org/crypto-technology/laravel-adsense/license.svg)](https://packagist.org/packages/crypto-technology/laravel-adsense)
[![Latest Stable Version](https://poser.pugx.org/crypto-technology/laravel-adsense/v/stable.svg)](https://packagist.org/packages/crypto-technology/laravel-adsense)
[![Total Downloads](https://poser.pugx.org/crypto-technology/laravel-adsense/d/total.svg)](https://packagist.org/packages/crypto-technology/laravel-adsense)

Package for easily including Google Adsense Ad units in [Laravel 6.0+](https://laravel.com/) and [Lumen](https://lumen.laravel.com/). For use it with Laravel 5.x use original [Mastergalen/Adsense-Ads package](https://github.com/Mastergalen/Adsense-Ads).

## Installation

### 1 - Dependency

In your project root run

The first step is using composer to install the package and automatically update your `composer.json` file, you can do this by running:

```shell
composer require crypto-technology/laravel-adsense
```

> **Note**: If you are using Laravel 5.5+, the steps 3 and 4, for providers and aliases, are unnecessaries. Google Adsense Ads supports Laravel new [Package Discovery](https://laravel.com/docs/5.5/packages#package-discovery).

### 2 - Set up config file

Run `php artisan config:publish crypto-technology/laravel-adsense`.

Edit the generated config file in `/config/adsense.php` to add your ad units

```php
return [
    'client_id' => 'YOUR_CLIENT_ID', //Your Adsense client ID e.g. ca-pub-9508939161510421
    'ads' => [
        'responsive' => [
            'ad_unit_id' => 12345678901,
            'ad_format' => 'auto'
        ],
        'rectangle' => [
            'ad_unit_id' => 1234567890,
            'ad_style' => 'display:inline-block;width:300px;height:250px',
            'ad_format' => 'auto'
        ]
    ]
];
```

### 3 - Register the provider with Laravel

You need to update your application configuration in order to register the package so it can be loaded by Laravel, just update your `config/app.php` file adding the following code at the end of your `'providers'` section:

> `config/app.php`

```php
<?php

return [
    // ...
    'providers' => [
        CryptoTech\Laravel\Adsense\Providers\AdsenseServiceProvider::class,
        // ...
    ],
    // ...
];
```

#### Lumen

Go to `bootstrap/app.php` file and add this line:

```php
<?php
// ...

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

// ...

$app->register(CryptoTech\Laravel\Adsense\Providers\AdsenseServiceProvider::class);

// ...

return $app;
```

### 4 - Register the alias with Laravel

> Note: facades are not supported in Lumen.

You may get access to the Google Adsense Ads services using following facades:

- `CryptoTech\Laravel\Adsense\Facades\Adsense`

You can setup a short-version aliases for these facades in your `config/app.php` file. For example:

```php
<?php

return [
    // ...
    'aliases' => [
        'Adsense' => CryptoTech\Laravel\Adsense\Facades\Adsense::class,
        // ...
    ],
    // ...
];
```

### 5 - Configuration

#### Publish config

In your terminal type

```shell
php artisan vendor:publish
```

or

```shell
php artisan vendor:publish --provider="CryptoTech\Laravel\Adsense\Providers\AdsenseServiceProvider"
```

> Lumen does not support this command, for it you should copy the file `src/resources/config/adsense.php` to `config/adsense.php` of your project

In `adsense.php` configuration file you can determine the properties of the default values and some behaviors.

## Usage
Add `{!! Adsense::javascript() !!}` in your `<head>` tag.

To show ads, add `{!! Adsense::ads('ads_unit') !!}`, where `ads_unit` is one of your ads units in your config file (for example `{!! Adsense::ads('responsive') !!}`).

Use `{!! Adsense::ads('ads_unit') !!}` every time you want to show an ad.

## License

The Google Adsense Ads is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
