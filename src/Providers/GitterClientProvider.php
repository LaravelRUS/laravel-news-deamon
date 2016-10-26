<?php
/**
 * This file is part of LaravelNewsBot package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace LaravelNews\Providers;

use Gitter\Client;
use Psr\Log\LoggerInterface;
use React\EventLoop\LoopInterface;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;

/**
 * Class GitterClientProvider
 * @package LaravelNews\Providers
 */
class GitterClientProvider extends ServiceProvider
{
    /**
     * @param Repository $config
     * @param LoggerInterface $logger
     */
    public function register(Repository $config, LoggerInterface $logger)
    {
        // Gitter client
        $this->app->singleton(Client::class, function(Container $app) use ($config, $logger) {
            return new Client($config->get('gitter.token'), $logger);
        });

        // Event Loop
        $this->app->singleton(LoopInterface::class, function(Container $app) {
            return $app->make(Client::class)->loop;
        });
    }
}