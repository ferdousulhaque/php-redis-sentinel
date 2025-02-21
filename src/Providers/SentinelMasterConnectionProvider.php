<?php

declare(strict_types=1);

namespace Ferdous\PhpRedis\Providers;

use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class SentinelMasterConnectionProvider extends ServiceProvider
{
    function boot(): void
    {
        if(env('APP_ENV') == 'production'){
            $master = $this->getCurrentMaster();
            $this->clearConfigCache();
            Config::set('database.redis.cache', [
                'url' => env('REDIS_URL'),
                'host' => $master['host'],
                'username' => env('REDIS_USERNAME'),
                'password' => env('REDIS_SENTINEL_PASSWORD'),
                'port' => $master['port'],
                'database' => env('REDIS_DB', '2'),
            ]);
        }
    }

    /**
     * @throws Exception
     */
    function getCurrentMaster()
    {
        try {
            // Get Sentinels
            $env_sentinels = explode(',',env('REDIS_SENTINELS',''));
            $port = env('REDIS_SENTINEL_PORT',26379);
            $sentinels = [];
            if(count($env_sentinels) > 0){
                foreach($env_sentinels as $sentinel){
                    $sentinels[] = ['host' => $sentinel, 'port' => $port];
                }
            }

            foreach ($sentinels as $sentinel) {
                $redis = new Redis();
                $redis->connect($sentinel['host'], $sentinel['port']);

                // Ask Redis Sentinel for the current master
                $master = $redis->rawCommand('SENTINEL', 'get-master-addr-by-name', 'mymaster');

                if ($master) {
                    return ['host' => $master[0], 'port' => $master[1]];
                }
            }
        } catch (\Exception $ex) {
            // Unable to determine the master
            throw new Exception('Unable to determine the current master Redis instance.');
        }


    }

    private function clearConfigCache(): void
    {
        $cachedConfigPath = app()->getCachedConfigPath();

        if (file_exists($cachedConfigPath)) {
            @unlink($cachedConfigPath);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //TODO:
    }
}
