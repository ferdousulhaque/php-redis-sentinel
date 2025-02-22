<?php

namespace Ferdous\PhpRedis\Connection;

class FlushOut
{
    public static function now(): void {
        $cachedConfigPath = app()->getCachedConfigPath();

        if (file_exists($cachedConfigPath)) {
            @unlink($cachedConfigPath);
        }
    }
}
