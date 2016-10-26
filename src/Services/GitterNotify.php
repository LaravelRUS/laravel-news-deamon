<?php
/**
 * This file is part of LaravelNewsBot package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace LaravelNews\Services;

use Gitter\Client;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;
use Psr\Log\LoggerInterface;
use React\Promise\Deferred;
use React\Promise\Promise;

/**
 * Class GitterNotify
 * @package LaravelNews\Services
 */
class GitterNotify
{
    private $lastPostId = null;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var Client
     */
    private $gitter;

    /**
     * @var string
     */
    private $hookId;

    /**
     * GitterNotify constructor.
     * @param LoggerInterface $logger
     * @param Client $gitter
     * @param Repository $config
     */
    public function __construct(LoggerInterface $logger, Client $gitter, Repository $config)
    {
        $this->logger = $logger;
        $this->gitter = $gitter;
        $this->hookId = $config->get('gitter.hook');
    }

    /**
     * @param \Closure $factory
     * @return Promise
     */
    public function notify(\Closure $factory): Promise
    {
        $deferred = new Deferred();

        try {
            $message = $factory();

            $this->logger->info('VK Response: ' . json_encode($message));

            if ($this->lastPostId !== null && $this->lastPostId !== $message->id) {
                $notification =
                    '**Новости LaravelRUS**' . "\n" .
                    '[' . message_title($message->text) . ']' .
                    sprintf('(https://vk.com/laravel_rus?w=wall%s_%s)', $message->owner_id, $message->id);

                $this->send($this->hookId, $notification)->then(function($response) use ($deferred) {
                    $deferred->resolve($response);
                });
            }

            $this->lastPostId = $message->id;

        } catch (\Throwable $e) {

            $this->logger->alert($e->getMessage());
            $deferred->reject($e);
        }

        return $deferred->promise();
    }

    /**
     * @param string $hookId
     * @param string $message
     * @return Promise
     */
    private function send(string $hookId, string $message): Promise
    {
        return $this->gitter->notify($hookId)
            ->info()
            ->async
            ->send($message);
    }
}
