<?php
/**
 * This file is part of LaravelNewsBot package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace LaravelNews\Providers;

use josegonzalez\Dotenv\Loader;
use Illuminate\Config\Repository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Config\Repository as RepositoryInterface;

/**
 * Class ConfigProvider
 * @package LaravelNews\Providers
 */
class ConfigProvider extends ServiceProvider
{
    const DOT_ENV_PATH = __DIR__ . '/../../.env';
    const CONFIG_PATH = __DIR__ . '/../../config.php';

    /**
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Repository::class, function() {
            $this->shareDotEnv();

            return new Repository(require static::CONFIG_PATH);
        });

        $this->app->alias(Repository::class, RepositoryInterface::class);
        $this->app->alias(Repository::class, 'config');
    }

    /**
     * @return void
     */
    private function shareDotEnv()
    {
        (new Loader(static::DOT_ENV_PATH))
            ->parse()
            ->toEnv();
    }
}