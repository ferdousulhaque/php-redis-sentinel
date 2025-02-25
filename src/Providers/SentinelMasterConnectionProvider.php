<?php

declare(strict_types=1);

namespace Ferdous\PhpRedis\Providers;

use Exception;
use Ferdous\PhpRedis\Connection\MasterConnection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class SentinelMasterConnectionProvider extends ServiceProvider
{
    function boot(): void
    {
        //TODO: Add to Middleware for api
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(MasterConnection::class, function ($app) {
            return new MasterConnection();
        });
    }
}
