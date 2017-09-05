<?php
namespace Mirasvit\Profiler\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\DeploymentConfig\Writer as DeploymentConfigWriter;
use Magento\Framework\App\DeploymentConfig\Reader as DeploymentConfigReader;
use Magento\Framework\Config\File\ConfigFilePool;
use Magento\Config\Model\Config\Factory as ConfigFactory;
use Magento\Framework\App\Filesystem\DirectoryList;

class Config
{
    CONST HTACCESS_ENV = 'SetEnv MAGE_PROFILER Mirasvit\Profiler\Model\Driver\Standard\Output\Html';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var DeploymentConfigWriter
     */
    private $deploymentConfigWriter;

    /**
     * @var DeploymentConfigWriter
     */
    private $deploymentConfigReader;

    /**
     * @var ConfigFactory
     */
    private $configFactory;

    /**
     * @var DirectoryList
     */
    private $directoryList;

    public function __construct(
        DeploymentConfigWriter $deploymentConfigWriter,
        DeploymentConfigReader $deploymentConfigReader,
        ScopeConfigInterface $scopeConfig,
        ConfigFactory $configFactory,
        DirectoryList $directoryList
    ) {
        $this->deploymentConfigWriter = $deploymentConfigWriter;
        $this->deploymentConfigReader = $deploymentConfigReader;
        $this->scopeConfig = $scopeConfig;
        $this->configFactory = $configFactory;
        $this->directoryList = $directoryList;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return (bool)$this->scopeConfig->getValue('profiler/general/enable');
    }

    /**
     * @return bool
     */
    public function enableProfiler()
    {
        $config = $this->configFactory->create();
        $config->setDataByPath('profiler/general/enable', true);
        $config->save();

        $this->enableDbProfiler();

        return true;
    }

    /**
     * @return bool
     */
    public function disableProfiler()
    {
        $config = $this->configFactory->create();
        $config->setDataByPath('profiler/general/enable', false);
        $config->save();

        $this->disableDbProfiler();

        return true;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function enableDbProfiler()
    {
        $env = $this->deploymentConfigReader->load(ConfigFilePool::APP_ENV);

        $env['db']['connection']['default']['profiler'] = [
            'class'   => '\\Magento\\Framework\\DB\\Profiler',
            'enabled' => true,
        ];
        $this->deploymentConfigWriter->saveConfig([ConfigFilePool::APP_ENV => $env], true);

        return true;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function disableDbProfiler()
    {
        $env = $this->deploymentConfigReader->load(ConfigFilePool::APP_ENV);

        unset($env['db']['connection']['default']['profiler']);

        $this->deploymentConfigWriter->saveConfig([ConfigFilePool::APP_ENV => $env], true);

        return true;
    }

    /**
     * @param string $addresses
     * @return bool
     */
    public function setAddresses($addresses)
    {
        $config = $this->configFactory->create();
        $config->setDataByPath('profiler/general/addresses', $addresses);
        $config->save();

        return true;
    }

    /**
     * @return array
     */
    public function getAddressInfo()
    {
        $addresses = $this->scopeConfig->getValue('profiler/general/addresses');

        return array_filter(explode(',', $addresses));
    }

    public function getDumpPath()
    {
        $path = $this->directoryList->getPath('var').'/profiler/';
        if (!file_exists($path)) {
            mkdir($path);
        }

        return $path;
    }
}