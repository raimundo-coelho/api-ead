<?php

namespace IDEALE\Providers;

use Code\Validator\Cpf;
use IDEALE\Tenant\TenantManager;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Validator::extend('cpf', function ($attribute, $value, $parameters, $validator) {
            return (new Cpf())->isValid($value);
        });

        // Resource::withoutWrapping();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TenantManager::class, function(){
            return new TenantManager();
        });
/*
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }*/
    }
}
