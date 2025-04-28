<?php
/**
 * Copyright (C) 2025 Pixel Développement
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace PixelOpen\Sucuri\Model;

use Exception;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\HTTP\Client\Curl as CurlClient;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Store\Model\ScopeInterface;

class Client
{
    public const CONFIG_API_URL_PATH = 'pixel_open_sucuri/api/url';

    public const CONFIG_API_KEY_PATH = 'pixel_open_sucuri/api/key';

    public const CONFIG_API_SECRET_PATH = 'pixel_open_sucuri/api/secret';

    public function __construct(
        protected CurlClient $curl,
        protected Json $json,
        protected ScopeConfigInterface $scopeConfig
    ) {
    }

    protected function init(): CurlClient
    {
        $this->curl->setTimeout(5);
        $this->curl->setOption(CURLOPT_RETURNTRANSFER, true);

        return $this->curl;
    }

    public function execute(string $method, array $params = [], ?int $websiteId = null): array
    {
        if (!($this->getUrl() && $this->getKey($websiteId) && $this->getSecret($websiteId))) {
            return ['messages' => [__('Please check the configuration settings')], 'status' => 0];
        }

        $params = array_merge(
            $params,
            [
                'k' => $this->getKey($websiteId),
                's' => $this->getSecret($websiteId),
                'a' => $method
            ]
        );

        try {
            $this->init()->post($this->getUrl(), $params);
            return $this->json->unserialize($this->curl->getBody());
        } catch (Exception $exception) {
            return ['messages' => [$exception->getMessage()], 'status' => 0];
        }
    }

    protected function getUrl(): string
    {
        return (string)$this->scopeConfig->getValue(self::CONFIG_API_URL_PATH);
    }

    protected function getKey(?int $websiteId = null): string
    {
        return (string)$this->scopeConfig->getValue(
            self::CONFIG_API_KEY_PATH,
            ScopeInterface::SCOPE_WEBSITE,
            $websiteId
        );
    }

    protected function getSecret(?int $websiteId = null): string
    {
        return (string)$this->scopeConfig->getValue(
            self::CONFIG_API_SECRET_PATH,
            ScopeInterface::SCOPE_WEBSITE,
            $websiteId
        );
    }
}
