# Laravel PHPRedis Sentinel Support
For Laravel, it supports Redis and Redis Sentinel with phpredis. However, when the master switches it does not move automatically. Hence, it impacts the application and throws exceptions.

For this reason, I worked on setting the Redis master IP Dynamically with each requests. Making the application work even the master switchover happens.

## Usages

When your API have write operation to Redis, then add the following middleware `auto-redis-master` like this:

```php
use Illuminate\Support\Facades\Route;
use Ferdous\PhpRedis\Connection\MasterConnection;

Route::middleware(['auto-redis-master'])->group(function () {
    Route::get('/redis-write-api', function () {
        // Write to Redis Master
    });
});
```

If you only want to get the current master redis information and will connect based on your need.abstract 

```php
use App\Services\MyCustomService;

class SomeController
{
    protected $masterConnection;

    public function __construct(MasterConnection $masterConnection)
    {
        dd($this->masterConnection->getActiveIpPort());
    }
}
```



## Contributors

- A S Md Ferdousul Haque
- Moniruzzaman Shovon

## License - Open Source

- MIT
