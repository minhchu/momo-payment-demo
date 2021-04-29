<?php

namespace App\Providers;

use App\Services\MomoPayment;
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
        $this->app->bind('momo', function($app) {
            /** @var \Illuminate\Contracts\Config\Repository */
            $config = $app['config']['momo'];

            return new MomoPayment(
                $config['api_endpoint'],
                $config['partner_code'],
                $config['access_key'],
                $config['secret_key']
            );
        });

        $this->app->alias('momo', MomoPayment::class);
    }
}
