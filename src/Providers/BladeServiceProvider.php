<?php

namespace Agenciafmd\Addresses\Providers;

//use Agenciafmd\Addresses\Http\Components\Address;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Form;

class BladeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadBladeComponents();

        $this->loadBladeDirectives();

        $this->loadBladeComposers();

        $this->setMenu();

        $this->loadViews();

        $this->loadTranslations();

        $this->publish();
    }

    public function register()
    {
        //
    }

    protected function loadBladeComponents()
    {
//        Blade::component('banner', Address::class);

        Form::component('bsAddressText', 'agenciafmd/addresses::components.form.text', [
            'label',
            'collection',
            'name',
            'value' => null,
            'attributes' => [],
            'helper' => null,
        ]);
    }

    protected function loadBladeComposers()
    {
        //
    }

    protected function loadBladeDirectives()
    {
        //
    }

    protected function setMenu()
    {
        //
    }

    protected function loadViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'agenciafmd/addresses');
    }

    protected function loadTranslations()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'agenciafmd/addresses');
    }

    protected function publish()
    {
        $this->publishes([
            __DIR__ . '/../resources/views' => base_path('resources/views/vendor/agenciafmd/addresses'),
        ], 'admix-addresses:views');
    }
}
