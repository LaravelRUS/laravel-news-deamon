<?php
if (!function_exists('env')) {
    /**
     * @param string $name
     * @param null $default
     * @return mixed
     */
    function env(string $name, $default = null)
    {
        return $_ENV[$name] ?? (
            $_SERVER[$name] ?? (
                getenv($name) ?: $default
            )
        );
    }
}


if (!function_exists('app')) {
    /**
     * @param null $service
     * @return \LaravelNews\Application|mixed
     */
    function app($service = null)
    {
        $instance = \LaravelNews\Application::getInstance();

        return $service === null ? $instance : $instance->make($instance);
    }
}

if (!function_exists('message_title')) {
    /**
     * @param string $message
     * @return string
     */
    function message_title(string $message): string
    {
        $parts = explode("\n", str_replace("\r", '', $message));
        return \Illuminate\Support\Str::limit(array_shift($parts));
    }
}