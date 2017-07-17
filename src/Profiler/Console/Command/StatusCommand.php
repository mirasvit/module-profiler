<?php
namespace Mirasvit\Profiler\Console\Command;

use Magento\Framework\App\State;
use Magento\Framework\Exception\LocalizedException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Mirasvit\Profiler\Model\Config;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class StatusCommand extends AbstractCommand
{
    /**
     * @var Config
     */
    protected $config;

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
        $this->setName('mirasvit:profiler:status')
            ->setDescription('Profiler status')
            ->setDefinition([]);

        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try{
            $this->appState->setAreaCode('empty');
        }catch (LocalizedException $e){}

        $output->writeln('<info>Status: ' . ($this->config->isEnabled() ? 'Enabled' : 'Disabled') . '</info>');
        $output->writeln('<info>IPs: ' . implode(', ', $this->config->getAddressInfo()) . '</info>');
    }
}
