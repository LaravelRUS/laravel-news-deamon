<?php
/**
 * This file is part of LaravelNewsBot package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace LaravelNews\Providers;

use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Monolog\Handler\StreamHandler;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;

/**
 * Class LogProvider
 * @package LaravelNews\Providers
 */
class LogProvider extends ServiceProvider
{
    /**
     * @param Repository $config
     */
    public function register(Repository $config)
    {
        $this->app->singleton(Logger::class, function(Container $app) use ($config) {
            return new Logger('laravel-news', [ $this->handler($config) ]);
        });

        $this->app->alias(Logger::class, LoggerInterface::class);
        $this->app->alias(Logger::class, 'log');
    }

    /**
     * @param Repository $config
     * @return StreamHandler
     * @throws \Exception
     */
    private function handler(Repository $config)
    {
        return new StreamHandler($config->get('log.out'), $config->get('log.level'));
    }
}