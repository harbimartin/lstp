<?php

namespace App\Providers;

use App\View\Components\Add;
use App\View\Components\EditComponent;
use App\View\Components\Table;
use App\View\Components\Update;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::component('add-record', Add::class);
        Blade::component('table', Table::class);
        Blade::component('edit', EditComponent::class);
        Blade::component('update', Update::class);
    }
}
