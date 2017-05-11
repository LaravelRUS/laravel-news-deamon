<?php
namespace {

    use LaravelNews\Application;
    use Psr\Log\LoggerInterface;
    use React\EventLoop\LoopInterface;
    use LaravelNews\Services\GitterNotify;
    use Illuminate\Contracts\Config\Repository;

    $app = new Application();

    $config = $app->make(Repository::class);
    $logger = $app->make(LoggerInterface::class);
    $gitterNotification = $app->make(GitterNotify::class);

    $app->make(LoopInterface::class)
        ->addPeriodicTimer($config->get('vk.delay', 60), function () use ($app, $logger, $gitterNotification) {
            $gitterNotification
                ->notify(function () use ($app) {
                    return $app->make('news-service');
                })
                ->then(function ($response) use ($logger) {
                    $logger->info('Successfully response: ' . json_encode($response));
                });
        });
}
