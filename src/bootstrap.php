<?php
namespace {
    use Gitter\Client;
    use LaravelNews\Application;
    use LaravelNews\Services\GitterNotify;
    use Psr\Log\LoggerInterface;
    use React\EventLoop\LoopInterface;
    use Illuminate\Contracts\Config\Repository;

    $app = new Application();

    $logger = $app->make(LoggerInterface::class);
    $gitterNotification = $app->make(GitterNotify::class);

    $app->make(LoopInterface::class)
        ->addPeriodicTimer(60, function () use ($app, $logger, $gitterNotification) {
            $gitterNotification
                ->notify(function() use ($app) {
                    return $app->make('laravel.news');
                })
                ->then(function($response) use ($logger) {
                    $logger->info('Successfully response: ' . json_encode($response));
                });
        });
}