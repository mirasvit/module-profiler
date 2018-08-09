<?php

namespace Mirasvit\Profiler\Model\Driver\Output;

use Magento\Framework\Profiler\Driver\Standard\Stat;
use Magento\Framework\Profiler\Driver\Standard\OutputInterface;
use Magento\Framework\App\ObjectManager;
use Mirasvit\Profiler\Model\Storage;

class Html implements OutputInterface
{
    /**
     * {@inheritdoc}
     */
    public function display(Stat $stat)
    {
        $objectManager = ObjectManager::getInstance();

        /** @var \Mirasvit\Profiler\Model\Config $config */
        $config = $objectManager->get('Mirasvit\Profiler\Model\Config');

        if (!$config->isEnabled()) {
            return;
        }

        $addresses = $config->getAddressInfo();

        if (count($addresses) && isset($_SERVER['REMOTE_ADDR']) && !in_array($_SERVER['REMOTE_ADDR'], $addresses)) {
            return;
        }

        if (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], 'profiler') !== false) {
            return;
        }
        
        /** @var \Mirasvit\Profiler\Model\Storage $storage */
        $storage = $objectManager->get('Mirasvit\Profiler\Model\Storage');

        $profileId = $storage->dump();

        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';

        if (!$isAjax && PHP_SAPI != 'cli' && strpos($_SERVER['HTTP_ACCEPT'], 'text/html') !== false) {
            /** @var \Magento\Framework\View\LayoutInterface $layout */
            $layout = $objectManager->create('Magento\Framework\View\LayoutInterface');

            echo $layout->createBlock('Mirasvit\Profiler\Block\Toolbar')
                ->setProfileId($profileId)
                ->toHtml();
        }
    }
}
