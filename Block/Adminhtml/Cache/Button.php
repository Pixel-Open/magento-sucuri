<?php
/**
 * Copyright (C) 2025 Pixel Développement
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace PixelOpen\Sucuri\Block\Adminhtml\Cache;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Directory\Helper\Data as DirectoryHelper;
use Magento\Framework\Json\Helper\Data as JsonHelper;
use Magento\Store\Model\StoreManagerInterface;

class Button extends Template
{
    public function __construct(
        protected StoreManagerInterface $storeManager,
        Context $context,
        array $data = [],
        ?JsonHelper $jsonHelper = null,
        ?DirectoryHelper $directoryHelper = null
    ) {
        parent::__construct($context, $data, $jsonHelper, $directoryHelper);
    }

    public function getWebsites(): array
    {
        return $this->storeManager->getWebsites();
    }
}
