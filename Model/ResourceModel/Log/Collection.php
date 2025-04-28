<?php
/**
 * Copyright (C) 2025 Pixel Développement
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace PixelOpen\Sucuri\Model\ResourceModel\Log;

use PixelOpen\Sucuri\Model\Log;
use PixelOpen\Sucuri\Model\ResourceModel\Log as LogResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string $_idFieldName
     */
    protected $_idFieldName = 'entity_id';

    /**
     * @phpcs:disable
     */
    protected function _construct(): void
    {
        $this->_init(Log::class, LogResourceModel::class);
    }
}
