<?php
/**
 * Copyright (C) 2025 Pixel Développement
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace PixelOpen\Sucuri\Cron\Log;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use PixelOpen\Sucuri\Api\LogRepositoryInterface;

class Clean
{
    public const CONFIG_CRON_RETENTION_PERIOD = 'pixel_open_sucuri/cron/retention_period';

    public function __construct(
        protected LogRepositoryInterface $logRepository,
        protected ScopeConfigInterface $scopeConfig,
        protected StoreManagerInterface $storeManager,
    ) {
    }

    /**
     * @throws CouldNotSaveException
     * @throws LocalizedException
     */
    public function execute(): void
    {
        $retentionPeriod = $this->getRetentionPeriodInDays();
        if (!$retentionPeriod) {
            return;
        }

        $this->logRepository->clean(date('Y-m-d H:i:s', strtotime('-' . $retentionPeriod . ' days')));
    }

    protected function getRetentionPeriodInDays(): int
    {
        return (int)$this->scopeConfig->getValue(self::CONFIG_CRON_RETENTION_PERIOD);
    }
}
