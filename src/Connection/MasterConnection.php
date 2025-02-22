<?php

namespace Ferdous\PhpRedis\Connection;

use Exception;
use Redis;

class MasterConnection
{
    /**
     * @return array
     * @throws Exception
     */
    function getActiveIpPort(): array
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
                FlushOut::now();
            }
        } catch (\Exception $ex) {
            // Unable to determine the master
            throw new Exception('Unable to determine the current master Redis instance.');
        }
        return [];
    }
}
