<?php

namespace teusbarros\CurrencyExchange;

use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class CurrencyExchangeServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerResources();
    }

    public function register(): void
    {
    }

    public function registerResources(): void
    {
        $this->registerRoutes();
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    protected function registerRoutes(): void
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        });
    }

    /**
     * Get the Press route group configuration array.
     *
     * @return array
     */
    private function routeConfiguration(): array
    {
        return [
            'prefix' => 'api/v1/',
            'namespace' => 'teusbarros\CurrencyExchange\Http\Controllers',
        ];
    }
}
