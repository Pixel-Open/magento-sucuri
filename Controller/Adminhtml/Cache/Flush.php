<?php
/**
 * Copyright (C) 2025 Pixel Développement
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace PixelOpen\Sucuri\Controller\Adminhtml\Cache;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Store\Model\StoreManagerInterface;
use PixelOpen\Sucuri\Model\Cache;

class Flush extends Action implements HttpGetActionInterface
{
    public const ADMIN_RESOURCE = 'PixelOpen_Sucuri::settings';

    public function __construct(
        protected Cache $cache,
        protected StoreManagerInterface $storeManager,
        Context $context
    ) {
        parent::__construct($context);
    }

    public function execute(): ResultInterface
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        $websiteId = (int)$this->getRequest()->getParam('website_id', 0);

        try {
            foreach ($this->storeManager->getWebsites() as $website) {
                if ($websiteId && (int)$website->getId() !== $websiteId) {
                    continue;
                }
                $result = $this->cache->flush((int)$website->getId());
                foreach (($result['messages'] ?? []) as $message) {
                    if (($result['status'] ?? 0) === 1) {
                        $this->messageManager->addSuccessMessage($message);
                    } else {
                        $this->messageManager->addErrorMessage($message);
                    }
                }
            }
        } catch (Exception $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
        }

        return $resultRedirect->setPath('adminhtml/cache/index');
    }
}
