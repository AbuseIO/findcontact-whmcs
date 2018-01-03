<?php

namespace AbuseIO\Findcontact\Whmcs;

use Illuminate\Support\ServiceProvider;

class WhmcsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     * merge the config
     *
     * @return void
     */
    public function boot()
    {
        // Publish config
        $this->mergeConfigFrom(base_path('vendor/abuseio/findcontact-whmcs').'/config/Whmcs.php', 'Findcontact');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}