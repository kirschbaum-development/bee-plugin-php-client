<?php

namespace KirschbaumDevelopment\Bee\Laravel;

use GuzzleHttp\Client;
use KirschbaumDevelopment\Bee\Bee;
use KirschbaumDevelopment\Bee\BeeAuth;
use Illuminate\Support\ServiceProvider;

class BeePluginServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind(Bee::class, function () {
            $client = new Bee(resolve(Client::class));

            if (config('services.bee.api_token')) {
                $client->setApiToken(config('services.bee.api_token'));
            }

            return $client;
        });

        $this->app->bind(BeeAuth::class, function () {
            $client = new BeeAuth(resolve(Client::class));

            if (config('services.bee.client_id')) {
                $client->setClientId(config('services.bee.client_id'));
            }

            if (config('services.bee.client_secret')) {
                $client->setClientSecret(config('services.bee.client_secret'));
            }

            return $client;
        });
    }
}
