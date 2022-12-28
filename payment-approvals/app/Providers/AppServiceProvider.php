<?php

namespace App\Providers;

use App\Repositories\PaymentRepository;
use App\Repositories\TravelPaymentRepository;
use App\Repositories\Interfaces\PaymentInterface;
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
        $this->app->bind(
            PaymentInterface::class,
            PaymentRepository::class
        );

        $this->app->bind(
            PaymentInterface::class,
            TravelPaymentRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
