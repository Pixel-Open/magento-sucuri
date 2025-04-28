<?php
/**
 * Copyright (C) 2025 Pixel Développement
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace PixelOpen\Sucuri\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\VersionControl\AbstractDb;
use PixelOpen\Sucuri\Api\Data\LogInterface;

class Log extends AbstractDb
{
    protected $_uniqueFields = [['field' => 'checksum', 'title' => 'Checksum']];

    /**
     * @phpcs:disable
     */
    protected function _construct(): void
    {
        $this->_init('sucuri_log', 'entity_id');
    }

    public function _beforeSave(AbstractModel $object): void
    {
        if ($object->getData(LogInterface::REQUEST_DATE)) {
            $date = explode('/', (string)$object->getData(LogInterface::REQUEST_DATE));
            if (isset($date[0], $date[1], $date[2])) {
                $timestamp = strtotime($date[0] . $date[1] . $date[2]);
                if ($timestamp) {
                    $object->setData(
                        LogInterface::FULL_DATE,
                        date('Y-m-d', $timestamp) . ' ' . $object->getData(LogInterface::REQUEST_TIME)
                    );
                }
            }
        }

        parent::_beforeSave($object);
    }
}
