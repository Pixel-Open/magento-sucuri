<?php
/**
 * Copyright (C) 2025 Pixel Développement
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace PixelOpen\Sucuri\Api\Data;

interface LogInterface
{
    public const ENTITY_ID = 'entity_id';
    public const CHECKSUM = 'checksum';
    public const FULL_DATE = 'full_date';
    public const REQUEST_DATE = 'request_date';
    public const REQUEST_TIME = 'request_time';
    public const REMOTE_ADDR = 'remote_addr';
    public const REQUEST_METHOD = 'request_method';
    public const RESOURCE_PATH = 'resource_path';
    public const HTTP_PROTOCOL = 'http_protocol';
    public const HTTP_STATUS = 'http_status';
    public const HTTP_USER_AGENT = 'http_user_agent';
    public const SUCURI_IS_ALLOWED = 'sucuri_is_allowed';
    public const SUCURI_IS_BLOCKED = 'sucuri_is_blocked';
    public const SUCURI_BLOCK_REASON = 'sucuri_block_reason';
    public const REQUEST_COUNTRY_NAME = 'request_country_name';
    public const WEBSITE_ID = 'website';

    public function getEntityId(): int;

    public function getChecksum(): string;

    public function getFullDate(): ?string;

    public function getRequestDate(): ?string;

    public function getRequestTime(): ?string;

    public function getRemoteAddr(): ?string;

    public function getRequestMethod(): ?string;

    public function getResourcePath(): ?string;

    public function getHttpProtocol(): ?string;

    public function getHttpStatus(): ?string;

    public function getHttpUserAgent(): ?string;

    public function getSucuriIsAllowed(): ?string;

    public function getSucuriIsBlocked(): ?string;

    public function getSucuriBlockReason(): ?string;

    public function getRequestCountryName(): ?string;

    public function getWebsite(): int;

    public function setWebsite(int $websiteId): LogInterface;
}
