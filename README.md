# Laravel Probe Detection
A package to log known website probing attacks

## Installation

You can install the package via composer:

``` bash
composer require seanhayes-com/laravel-probe-detection=dev-master
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
