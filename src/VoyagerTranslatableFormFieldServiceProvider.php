<?php

namespace Mattrabe\VoyagerTranslatableFormField;

use Illuminate\Support\ServiceProvider;
use TCG\Voyager\Facades\Voyager as VoyagerFacade;

class VoyagerTranslatableFormFieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__. '/../resources/views/' => config('view.paths')[0].'/voyager-translatable-formfield',
        ]);

        // Load views from published dir (if developer publishes and alters view files) or vendor package dir
        $this->loadViewsFrom(config('view.paths')[0].'/voyager-translatable-formfield', 'translatableformfield');
        $this->loadViewsFrom(__DIR__. '/../resources/views/', 'translatableformfield');

        // Add FormField
        VoyagerFacade::addFormField("Mattrabe\\VoyagerTranslatableFormField\\FormFields\\TranslatableHandler");
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
