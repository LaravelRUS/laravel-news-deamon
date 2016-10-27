<?php
/**
 * This file is part of LaravelNewsBot package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace LaravelNews\Services;

/**
 * Class VkClient
 * @package LaravelNews\Services
 */
class VkClient
{
    const API_URI = 'api.vk.com/method';

    /**
     * @var int
     */
    private $appId;

    /**
     * @var string
     */
    private $secret;

    /**
     * @var string
     */
    private $version = '5.59';

    /**
     * VkClient constructor.
     * @param int $appId
     * @param string $secret
     */
    public function __construct(int $appId, string $secret)
    {
        $this->appId = $appId;
        $this->secret = $secret;
    }

    /**
     * @param string $version
     * @return $this
     */
    public function version(string $version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @param $action
     * @param array $params
     * @return mixed
     * @throws \RuntimeException
     */
    public function request($action, array $params)
    {
        $uri = sprintf('https://%s/%s?%s', static::API_URI, $action, http_build_query($params));

        $response = file_get_contents($uri);

        $data = json_decode($response);

        if (($answer = $data->response[1]) ?? false) {
            return $answer;
        } else {
            throw new \RuntimeException('Invalid api response: ' . $response);
        }
    }
}