<?php

namespace Ferdous\PhpRedis\Middleware;

use Closure;
use Ferdous\PhpRedis\Connection\FlushOut;
use Ferdous\PhpRedis\Connection\MasterConnection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Response;

class ResilientRedisMasterMiddleware
{
    /**
     * Handle an incoming request.
     * @throws \Exception
     */
    public function handle(Request $request, Closure $next): Response
    {
        $masterConnection = new MasterConnection();
        $cacheConfig = $masterConnection->getActiveIpPort();
        FlushOut::now();
        Config::set('database.redis.cache', [
            'url' => env('REDIS_URL'),
            'host' => $cacheConfig['host'],
            'username' => env('REDIS_USERNAME',""),
            'password' => env('REDIS_SENTINEL_PASSWORD',""),
            'port' => $cacheConfig['port'],
            'database' => env('REDIS_DB', '0'),
        ]);
        return $next($request);
    }
}
