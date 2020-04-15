<?php
namespace Wimil\Invoices;

use Illuminate\Support\ServiceProvider as BaseProvider;

class Provider extends BaseProvider
{

    public function boot()
    {
        $this->registerResources();

        
        $this->publishes([
            __DIR__ . '/../config/invoices.php' => config_path('invoices.php'),

        ], 'invoices.config');

        $this->publishes([
            __DIR__ . '/../resources/views' => base_path('resources/views/vendor/invoices'),
        ], 'invoices.views');

        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/invoices'),
        ], 'invoices.translations');

    }

    public function register()
    {
        //combinar configuracion de usuario y paquete
        $this->mergeConfigFrom(
            __DIR__ . '/../config/invoices.php',
            'invoices'
        );
    }

    protected function registerResources()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'invoices');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'invoices');
    }
    

}
