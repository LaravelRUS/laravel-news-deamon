<?php
/**
 * This file is part of LaravelNewsBot package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace LaravelNews;


use Gitter\Client;
use Illuminate\Container\Container;
use LaravelNews\Providers\LogProvider;
use LaravelNews\Providers\ConfigProvider;
use LaravelNews\Providers\VkClientProvider;
use LaravelNews\Providers\GitterClientProvider;

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