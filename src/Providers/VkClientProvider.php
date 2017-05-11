<?php
/**
 * This file is part of LaravelNewsBot package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace LaravelNews\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;
use LaravelNews\Services\VkClient;

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
        $this->app->singleton(VkClient::class, function(Container $app) use ($config) {
            $client = new VkClient('', '');
            $client->version('5.59');

            return $client;
        });

        $this->registerWallMethod($config);
    }

    /**
     * @param Repository $config
     * @throws \RuntimeException
     */
    private function registerWallMethod(Repository $config)
    {
        // Last Wall News
        $this->app->bind('news-service', function (Container $app) use ($config) {
            $vk = $app->make(VkClient::class);

            $response = $vk->request('wall.get', [
                'count'    => $config->get('vk.has_attachment') ? 2 : 1,
                'filter'   => 'owner',
                'owner_id' => $config->get('vk.community_id')
            ]);

            return array_pop($response);
        });
    }
}
