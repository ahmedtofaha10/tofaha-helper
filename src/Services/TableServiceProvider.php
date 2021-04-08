<?php


namespace Tofaha\Helper\Services;


use Illuminate\Support\ServiceProvider;
use Tofaha\Helper\Table;

class TableServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind('table',function ($app){
            return new Table();
        });
    }
    public function boot()
    {

    }

}
