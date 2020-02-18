# Laravel Probe Detection
Log and ban known website probing attacks and eliminate wasted site resources

## Minimum Requirements

Laravel 6.0 and PHP 7.2

## Installation

You can install the package via composer:

``` bash
composer require seanhayes-com/laravel-probe-detection
```

The package will automatically register itself.

You can publish the migration with:
```bash
php artisan vendor:publish --provider="SeanHayes\Probe\ProbeServiceProvider" --tag="migrations"
```

After the migration has been published you can create the `prob_log` table by running the migrations:

```bash
php artisan migrate
```

You can optionally publish the config file with:
```bash
php artisan vendor:publish --provider="SeanHayes\Probe\ProbeServiceProvider" --tag="config"
```

## Configuration

Change settings in config/probe.php

Add routes to handle certain common attack vectors or URIs added to watch_uris in config/probe.php

```php
Route::get('/wp-login.php', function () {
	\SeanHayes\Probe\Probe::logRequest();
});
Route::get('/{name}/wp-login.php', function () {
	\SeanHayes\Probe\Probe::logRequest();
});
Route::get('/wp-admin/', function () {
	\SeanHayes\Probe\Probe::logRequest();
});
Route::get('/wp-content/', function () {
	\SeanHayes\Probe\Probe::logRequest();
});
Route::get('/{name}/wp-admin/', function () {
	\SeanHayes\Probe\Probe::logRequest();
});
Route::get('/xmlrpc.php', function () {
	\SeanHayes\Probe\Probe::logRequest();
});
Route::get('/wp-cron.php', function () {
	\SeanHayes\Probe\Probe::logRequest();
});
Route::post('/wp-login.php', function () {
	\SeanHayes\Probe\Probe::logRequest();
});
Route::post('/{name}/wp-login.php', function () {
	\SeanHayes\Probe\Probe::logRequest();
});
Route::post('/wp-admin/', function () {
	\SeanHayes\Probe\Probe::logRequest();
});
Route::post('/{name}/wp-admin/', function () {
	\SeanHayes\Probe\Probe::logRequest();
});
Route::post('/xmlrpc.php', function () {
	\SeanHayes\Probe\Probe::logRequest();
});
Route::post('/wp-cron.php', function () {
	\SeanHayes\Probe\Probe::logRequest();
});
```

## Usage
Include the path in your Controller or AppServiceProvider

```php
use SeanHayes\Probe\Probe;
```
And the call to process the request in your method

```php
Probe::logRequest();
```

## Troubleshooting

If you experience file cache errors, you can change your CACHE_DRIVER to array in your .env file.

```bash
CACHE_DRIVER=array
```
