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

            $momo = new MomoPayment(
                $config['api_endpoint'],
                $config['partner_code'],
                $config['access_key'],
                $config['secret_key']
            );

            $momo->setNotifyUrl($config['notify_url'])
                 ->setReturnUrl($config['return_url']);

            return $momo;
        });

        $this->app->alias('momo', MomoPayment::class);
    }
}
