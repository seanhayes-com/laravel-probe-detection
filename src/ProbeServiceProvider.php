<?php

namespace SeanHayes\Probe;

use Illuminate\Support\ServiceProvider;
use SeanHayes\Probe\Exceptions\InvalidConfiguration;

class ProbeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            if (! class_exists('CreateProbeLogTables')) {
                $timestamp = date('Y_m_d_His', time());
                $this->publishes([
                    __DIR__.'/../database/migrations/create_probe_log_tables.php.stub' => database_path('migrations/'.$timestamp.'_create_probe_log_tables.php'),
                ], 'migrations');
            }

            $this->publishes([
                __DIR__.'/../config/probe.php' => config_path('probe.php'),
            ], 'config');
        }
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
      
    }
}