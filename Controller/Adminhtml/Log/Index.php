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
use Magento\Framework\View\Result\PageFactory;
use Magento\Store\Api\WebsiteRepositoryInterface;

class Index extends Action
{
    public const ADMIN_RESOURCE = 'PixelOpen_Sucuri::management_log';

    public function __construct(
        protected PageFactory $resultPageFactory,
        protected WebsiteRepositoryInterface $websiteRepository,
        Context $context
    ) {
        parent::__construct($context);
    }

    public function execute(): ResultInterface
    {
        $resultPage = $this->resultPageFactory->create();

        $websiteName = '';
        $websiteId = (int)$this->getRequest()->getParam('website');
        if ($websiteId) {
            try {
                $website = $this->websiteRepository->getById($websiteId);
                $websiteName = $website->getName();
            } catch (Exception) {
                $websiteName = __('Unknown Website');
            }
        }

        $this->_setActiveMenu('Magento_Backend::system');
        $resultPage->getConfig()->getTitle()->prepend(
            __('Sucuri Logs') . ($websiteName ? ' - ' . $websiteName : '')
        );

        return $resultPage;
    }
}
