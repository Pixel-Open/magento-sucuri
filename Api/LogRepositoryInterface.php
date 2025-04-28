<?php
/**
 * Copyright (C) 2025 Pixel Développement
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace PixelOpen\Sucuri\Api;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use PixelOpen\Sucuri\Api\Data\LogInterface;

interface LogRepositoryInterface
{
    /**
     * Save Log
     *
     * @param \PixelOpen\Sucuri\Api\Data\LogInterface $log
     * @return \PixelOpen\Sucuri\Api\Data\LogInterface
     * @throws CouldNotSaveException
     */
    public function save(LogInterface $log): LogInterface;

    /**
     * Refresh logs
     *
     * @param int $websiteId
     * @return int
     * @throws LocalizedException|CouldNotSaveException
     */
    public function refresh(int $websiteId): int;
}
