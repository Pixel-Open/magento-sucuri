<?php
/**
 * Copyright (C) 2025 Pixel Développement
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace PixelOpen\Sucuri\Model;

class Cache
{
    public function __construct(
        private Client $client
    ) {
    }

    public function flush(?int $websiteId = null): array
    {
        return $this->client->execute('clear_cache', [], $websiteId);
    }
}
