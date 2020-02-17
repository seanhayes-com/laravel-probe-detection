# Laravel Probe Detection
A package to log known website probing attacks

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

```bash
Route::get('/wp-login.php', function () {
	\SeanHayes\Probe\Probe::logRequest();
});
Route::get('/{name}/wp-login.php', function () {
	\SeanHayes\Probe\Probe::logRequest();
});
Route::get('/wp-admin/', function () {
	\SeanHayes\Probe\Probe::logRequest();
});
Route::get('/{name}/wp-admin/', function () {
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
```

## Usage
Include the path in your Controller or AppServiceProvider

```bash
use SeanHayes\Probe\Probe;
```

```bash
Probe::logRequest();
```
