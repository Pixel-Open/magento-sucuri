<?php
/**
 * Copyright (C) 2025 Pixel Développement
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace PixelOpen\Sucuri\Controller\Adminhtml\Log;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Store\Model\StoreManagerInterface;
use PixelOpen\Sucuri\Api\LogRepositoryInterface;

class Refresh extends Action
{
    public const ADMIN_RESOURCE = 'PixelOpen_Sucuri::management_log';

    public function __construct(
        protected LogRepositoryInterface $logRepository,
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
                $total = $this->logRepository->refresh((int)$website->getId());
                $this->messageManager->addSuccessMessage(
                    __('%1 log(s) have been added for website %2.', $total, $website->getName())
                );
            }
        } catch (Exception $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
        }

        return $resultRedirect->setPath('*/*/', $websiteId ? ['website' => $websiteId] : []);
    }
}
