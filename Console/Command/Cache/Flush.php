<?php
/**
 * Copyright (C) 2025 Pixel Développement
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace PixelOpen\Sucuri\Console\Command\Cache;

use Exception;
use Magento\Framework\Console\Cli;
use Magento\Store\Model\StoreManagerInterface;
use PixelOpen\Sucuri\Model\Cache;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Flush extends Command
{
    public function __construct(
        protected Cache $cache,
        protected StoreManagerInterface $storeManager,
        ?string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->setName('sucuri:cache:flush')
            ->setDescription('Flush Sucuri cache')
            ->addOption('website_id', null, InputOption::VALUE_OPTIONAL, 'The website id', 0);
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $websiteId = (int)$input->getOption('website_id');

        try {
            foreach ($this->storeManager->getWebsites() as $website) {
                if ($websiteId && (int)$website->getId() !== $websiteId) {
                    continue;
                }
                $result = $this->cache->flush((int)$website->getId());
                foreach (($result['messages'] ?? []) as $message) {
                    $output->writeln((string)$message);
                }
            }
            return Cli::RETURN_SUCCESS;
        } catch (Exception $exception) {
            $output->writeln($exception->getMessage());
            return Cli::RETURN_FAILURE;
        }
    }
}
