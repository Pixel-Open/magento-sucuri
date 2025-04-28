<?php
/**
 * Copyright (C) 2025 Pixel Développement
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace PixelOpen\Sucuri\Model;

use Magento\Framework\Exception\LocalizedException;
use PixelOpen\Sucuri\Api\Data\LogInterface;
use PixelOpen\Sucuri\Model\ResourceModel\Log as LogResourceModel;
use Magento\Framework\Model\AbstractModel;

class Log extends AbstractModel implements LogInterface
{
    /**
     * @var string $_eventPrefix
     */
    protected $_eventPrefix = 'sucuri_log';

    public const CACHE_TAG = 'sucuri_log';

    /**
     * @throws LocalizedException
     */
    protected function _construct(): void
    {
        $this->_init(LogResourceModel::class);
    }

    public function getEntityId(): int
    {
        return (int)$this->getData(LogInterface::ENTITY_ID);
    }

    public function getChecksum(): string
    {
        return (string)$this->getData(LogInterface::CHECKSUM);
    }

    public function getFullDate(): ?string
    {
        return $this->getData(LogInterface::FULL_DATE);
    }

    public function getRequestDate(): ?string
    {
        return $this->getData(LogInterface::REQUEST_DATE);
    }

    public function getRequestTime(): ?string
    {
        return $this->getData(LogInterface::REQUEST_TIME);
    }

    public function getRemoteAddr(): ?string
    {
        return $this->getData(LogInterface::REMOTE_ADDR);
    }

    public function getRequestMethod(): ?string
    {
        return $this->getData(LogInterface::REQUEST_METHOD);
    }

    public function getResourcePath(): ?string
    {
        return $this->getData(LogInterface::RESOURCE_PATH);
    }

    public function getHttpProtocol(): ?string
    {
        return $this->getData(LogInterface::HTTP_PROTOCOL);
    }

    public function getHttpStatus(): ?string
    {
        return $this->getData(LogInterface::HTTP_STATUS);
    }

    public function getHttpUserAgent(): ?string
    {
        return $this->getData(LogInterface::HTTP_USER_AGENT);
    }

    public function getSucuriIsAllowed(): ?string
    {
        return $this->getData(LogInterface::SUCURI_IS_ALLOWED);
    }

    public function getSucuriIsBlocked(): ?string
    {
        return $this->getData(LogInterface::SUCURI_IS_BLOCKED);
    }

    public function getSucuriBlockReason(): ?string
    {
        return $this->getData(LogInterface::SUCURI_BLOCK_REASON);
    }

    public function getRequestCountryName(): ?string
    {
        return $this->getData(LogInterface::REQUEST_COUNTRY_NAME);
    }

    public function getWebsite(): int
    {
        return (int)$this->getData(LogInterface::WEBSITE_ID);
    }

    public function setWebsite(int $websiteId): LogInterface
    {
        $this->setData(LogInterface::WEBSITE_ID, $websiteId);

        return $this;
    }
}
