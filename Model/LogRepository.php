<?php
/**
 * Copyright (C) 2025 Pixel Développement
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace PixelOpen\Sucuri\Model;

use Exception;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use PixelOpen\Sucuri\Api\Data\LogInterface;
use PixelOpen\Sucuri\Api\Data\LogInterfaceFactory;
use PixelOpen\Sucuri\Api\LogRepositoryInterface;
use PixelOpen\Sucuri\Model\ResourceModel\LogFactory as LogResourceFactory;

class LogRepository implements LogRepositoryInterface
{
    protected const REQUEST_LIMIT = 100;

    public function __construct(
        protected LogResourceFactory $logResourceFactory,
        protected LogInterfaceFactory $logInterfaceFactory,
        protected Client $client,
    ) {
    }

    /**
     * @throws CouldNotSaveException
     */
    public function save(LogInterface $log): LogInterface
    {
        $resource = $this->logResourceFactory->create();

        try {
            $resource->save($log);
        } catch (AlreadyExistsException) {
            // Ignore checksum already exists
        } catch (Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the log: %1', $exception->getMessage()),
                $exception
            );
        }

        return $log;
    }

    /**
     * @throws LocalizedException|CouldNotSaveException
     */
    public function refresh(int $websiteId): int
    {
        return $this->doRefresh($websiteId);
    }

    /**
     * @throws LocalizedException|CouldNotSaveException
     */
    protected function doRefresh(int $websiteId, int $offset = 0): int
    {
        $result = $this->client->execute(
            'audit_trails',
            [
                'offset' => $offset,
                'limit' => self::REQUEST_LIMIT,
                'format' => 'json'
            ],
            $websiteId
        );

        if (isset($result['status']) && $result['status'] !== 1) {
            foreach (($result['messages'] ?? []) as $message) {
                throw new LocalizedException(__($message));
            }
            throw new LocalizedException(__('The API request failed. Please check the configuration settings.'));
        }

        $total = 0;

        foreach ($result as $request) {
            $log = $this->logInterfaceFactory->create();
            $log->setData($request);
            $log->setWebsite($websiteId);

            $this->save($log);

            if ($log->getId()) {
                $total++;
            }
        }

        if (count($result) >= self::REQUEST_LIMIT) {
            $total += $this->doRefresh($websiteId, $offset + self::REQUEST_LIMIT);
        }

        return $total;
    }
}
