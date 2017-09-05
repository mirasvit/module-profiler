<?php

namespace Mirasvit\Profiler\Console\Command;

use Magento\Framework\App\State;
use Magento\Framework\Exception\LocalizedException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Mirasvit\Profiler\Model\Config;

class EnableCommand extends AbstractCommand
{
    /**
     * @var Config
     */
    private $config;

    public function __construct(
        Config $config,
        State $appState
    ) {
        $this->config = $config;

        parent::__construct($appState);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('mirasvit:profiler:enable')
            ->setDescription('Enable profiler')
            ->setDefinition([]);

        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->appState->setAreaCode('empty');
        } catch (LocalizedException $e) {
        }

        $this->config->enableProfiler();

        $output->writeln('<info>Status: ' . ($this->config->isEnabled() ? 'Enabled' : 'Disabled') . '</info>');
    }
}
