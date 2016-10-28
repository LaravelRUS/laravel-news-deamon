News Daemon
-----

Async bot based on Laravel 5.3 components and ReactPHP core.

This is PHP microservice which publishes news 
from [vk.com](https://vk.com/laravel_rus) 
to [gitter.im](https://gitter.im/LaravelRUS/chat) 

## Requirements

- PHP 7.0+
- PHP Socket extension
- PHP Curl extension
- PHP Multibyte extension
- Composer

## Installation

- `composer install`

## Usage

- Setting up a `.env` variables (see example)
- Run:
  - Windows: `composer run-windows` or `start php -f ./news-service`
  - Linux: `composer run-linux` or `nohup php -f ./news-service > /dev/null 2>&1 &`
  - Others: `php news-service`
