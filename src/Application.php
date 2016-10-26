<?php
/**
 * This file is part of LaravelNewsBot package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace LaravelNews;

use getjump\Vk\Core;
use Gitter\Client;
use josegonzalez\Dotenv\Loader;
use Illuminate\Config\Repository;
use Illuminate\Container\Container;
use LaravelNews\Providers\ConfigProvider;

use LaravelNews\Providers\GitterClientProvider;
use LaravelNews\Providers\LogProvider;
use LaravelNews\Providers\VkClientProvider;
use React\EventLoop\LoopInterface;

/**
 * Class Application
 * @package LaravelNews
 */
class Application extends Container
{
    /**
     * @var array
     */
    private $providers = [];

    /**
     * Application constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $providers = [
            ConfigProvider::class,
            LogProvider::class,
            GitterClientProvider::class,
            VkClientProvider::class,
        ];

        foreach ($providers as $provider) {
            $this->register($provider);
        }
    }

    /**
     * @param string $provider
     * @return $this
     */
    private function register(string $provider)
    {
        $instance = new $provider($this);

        $this->call([$instance, 'register']);

        $this->providers[] = $instance;

        return $this;
    }

    /**
     * @return void
     */
    public function run()
    {
        $client = $this->make(Client::class);
        $client->connect();
    }
}