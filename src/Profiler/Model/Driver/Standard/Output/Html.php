<?php
namespace Mirasvit\Profiler\Model\Driver\Standard\Output;

use Magento\Framework\Profiler\Driver\Standard\Stat;
use Magento\Framework\Profiler\Driver\Standard\OutputInterface;
use Magento\Framework\App\ObjectManager;

class Html implements OutputInterface
{
    /**
     * {@inheritdoc}
     */
    public function display(Stat $stat)
    {
        $objectManager = ObjectManager::getInstance();

        /** @var \Magento\Framework\View\LayoutInterface $layout */
        $layout = $objectManager->create('\Magento\Framework\View\LayoutInterface');

        $context = $objectManager->get('\Mirasvit\Profiler\Block\Context');
        $context->setProfilerStat($stat);

        echo $layout->createBlock('\Mirasvit\Profiler\Block\Container')
            ->toHtml();

    }
}