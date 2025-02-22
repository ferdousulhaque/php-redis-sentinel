# Laravel PHPRedis Sentinel Support
For Laravel, it supports Redis and Redis Sentinel with phpredis. However, when the master switches it does not move automatically. Hence, it impacts the application and throws exceptions.

For this reason, I worked on setting the Redis master IP Dynamically with each requests. Making the application work even the master switchover happens.

## Usages

If you are using `api` then in the middleware for `RateLimiter`, disable it and enable the new `ResilientRateLimiter` as middleware.

For internal application, just register the new provider for `Redis`

## Contributors

- A S Md Ferdousul Haque
- Moniruzzaman Shovon

## License - Open Source

- MIT
