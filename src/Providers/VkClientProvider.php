<?php
/**
 * This file is part of LaravelNewsBot package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace LaravelNews\Providers;

use getjump\Vk\Core;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;

/**
 * Class VkClientProvider
 * @package LaravelNews\Providers
 */
class VkClientProvider extends ServiceProvider
{
    /**
     * @param Repository $config
     * @throws \RuntimeException
     */
    public function register(Repository $config)
    {
        // VK API Core
        $this->app->singleton(Core::class, function(Container $app) {
            return Core::getInstance()->apiVersion('5.58');
        });

        $this->registerWallMethod($config);
    }

    /**
     * @param Repository $config
     * @throws \RuntimeException
     */
    private function registerWallMethod(Repository $config)
    {
        // Last LaravelRus Wall News
        $this->app->bind('laravel.news', function (Container $app) use ($config) {
            $vk = $app->make(Core::class);

            $request = $vk->request('wall.get', [
                'count'    => 2, // Ignore attached message
                'filter'   => 'owner',
                'owner_id' => $config->get('vk.community')
            ]);

            /** @var array $response */
            $response = $request->fetchData()->getResponse();

            if (!is_array($response)) {
                throw new \RuntimeException('Response data is not an array');
            }

            return array_pop($response);
        });
    }
}