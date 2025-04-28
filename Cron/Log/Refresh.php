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

class Refresh
{
    public const CONFIG_CRON_ENABLED_PATH = 'pixel_open_sucuri/cron/enabled';

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
        foreach ($this->storeManager->getWebsites() as $website) {
            if ($this->isEnabled((int)$website->getId())) {
                $this->logRepository->refresh((int)$website->getId());
            }
        }
    }

    protected function isEnabled(int $websiteId): bool
    {
        return $this->scopeConfig->isSetFlag(self::CONFIG_CRON_ENABLED_PATH, ScopeInterface::SCOPE_WEBSITE, $websiteId);
    }
}
