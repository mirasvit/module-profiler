<?php
if (PHP_SAPI != 'cli') {
    $_SERVER['MAGE_PROFILER_STAT'] = new \Magento\Framework\Profiler\Driver\Standard\Stat();
    \Magento\Framework\Profiler::applyConfig(
        [
            'drivers' => [
                [
                    'output' => 'Mirasvit\Profiler\Model\Driver\Output\Html',
                    'stat'   => $_SERVER['MAGE_PROFILER_STAT'],
                ]
            ]
        ],
        BP,
        false
    );
}

\Magento\Framework\Component\ComponentRegistrar::register(
    \Magento\Framework\Component\ComponentRegistrar::MODULE,
    'Mirasvit_Profiler',
    __DIR__
);