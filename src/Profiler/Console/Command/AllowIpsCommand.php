<?php
namespace Mirasvit\Profiler\Console\Command;

use Magento\Framework\App\State;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Mirasvit\Profiler\Model\Config;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class AllowIpsCommand extends AbstractCommand
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
        $arguments = [
            new InputArgument(
                'ip',
                InputArgument::OPTIONAL | InputArgument::IS_ARRAY,
                'Allowed IP addresses'
            ),
        ];
        $options = [
            new InputOption(
                'none',
                null,
                InputOption::VALUE_NONE,
                'Clear allowed IP addresses'
            ),
        ];

        $this->setName('mirasvit:profiler:allow-ips')
            ->setDescription('Enable profiler only for specified IPs')
            ->setDefinition(array_merge($arguments, $options));

        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->appState->setAreaCode('empty');

        if (!$input->getOption('none')) {
            $addresses = $input->getArgument('ip');

            if (!empty($addresses)) {
                $this->config->setAddresses(implode(',', $addresses));
                $output->writeln(
                    '<info>Set exempt IP-addresses: ' . implode(', ', $this->config->getAddressInfo()) .
                    '</info>'
                );
            }
        } else {
            $this->config->setAddresses('');
            $output->writeln('<info>Set exempt IP-addresses: none</info>');
        }
    }
}
