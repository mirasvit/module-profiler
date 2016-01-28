<?php
namespace Mirasvit\Profiler\Console\Command;

use Magento\Framework\App\DeploymentConfig;
use Magento\Framework\App\State;
use Symfony\Component\Console\Command\Command;

abstract class AbstractCommand extends Command
{
    /**
     * App state
     *
     * @var \Magento\Framework\App\State
     */
    protected $appState;

    /**
     * {@inheritdoc}
     *
     * @param State $appState
     */
    public function __construct(
        State $appState
    ) {
        $this->appState = $appState;

        parent::__construct();
    }
}
