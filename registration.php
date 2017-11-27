<?php
$_SERVER['MAGE_PROFILER_STAT'] = new \Magento\Framework\Profiler\Driver\Standard\Stat();

$canEnable = true;

if (PHP_SAPI == 'cli') {
    global $argv;
    if (isset($argv[1]) && substr($argv[1], 0, strlen('setup')) == 'setup') {
        $canEnable = false;
    }
}

if ($canEnable) {
    \Magento\Framework\Profiler::applyConfig([
        'drivers' => [
            [
                'output' => 'Mirasvit\Profiler\Model\Driver\Output\Html',
                'stat'   => $_SERVER['MAGE_PROFILER_STAT'],
            ],
        ],
    ], 'BP', false);
}

\Magento\Framework\Component\ComponentRegistrar::register(
    \Magento\Framework\Component\ComponentRegistrar::MODULE,
    'Mirasvit_Profiler',
    __DIR__ . '/src/Profiler'
);
