<?php
/**
 * Copyright (C) 2025 Pixel Développement
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace PixelOpen\Sucuri\Block\Adminhtml\Log\Grid;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class RefreshButton implements ButtonProviderInterface
{
    protected UrlInterface $urlBuilder;

    public function __construct(
        Context $context,
        protected RequestInterface $request,
    ) {
        $this->urlBuilder = $context->getUrlBuilder();
    }

    public function getButtonData(): array
    {
        $websiteId = (int)$this->request->getParam('website', 0);

        return [
            'label' => __('Refresh'),
            'class' => 'primary',
            'url' => $this->getUrl('*/*/refresh', ['website_id' => $websiteId]),
            'sort_order' => 10,
        ];
    }

    public function getUrl($route = '', $params = []): string
    {
        return $this->urlBuilder->getUrl($route, $params);
    }
}
