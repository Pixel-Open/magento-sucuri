<?php
/**
 * Copyright (C) 2025 Pixel Développement
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace PixelOpen\Sucuri\Ui\Component\Listing\Columns;

use Magento\Ui\Component\Listing\Columns\Column;

class ResourcePath extends Column
{
    public const MAX_LENGTH = 100;

    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (!isset($item[$this->getData('name')])) {
                    continue;
                }
                $value = $item[$this->getData('name')];
                $value = htmlspecialchars_decode(rawurldecode($value));
                if (strlen($value) > self::MAX_LENGTH) {
                    $value = substr($value, 0, self::MAX_LENGTH) . '...';
                }
                $item[$this->getData('name')] = $value;
            }
        }

        return $dataSource;
    }
}
