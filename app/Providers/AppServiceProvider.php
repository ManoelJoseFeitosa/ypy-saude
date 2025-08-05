<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\EHR\EHRIntegrationInterface;
use App\Adapters\EHR\FakeEHRAdapter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
{
    // ... pode já ter outras coisas aqui

    $this->app->bind(EHRIntegrationInterface::class, FakeEHRAdapter::class);
}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
