<?php
namespace Mirasvit\Profiler\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\DeploymentConfig\Writer as DeploymentConfigWriter;
use Magento\Framework\App\DeploymentConfig\Reader as DeploymentConfigReader;
use Magento\Framework\Config\File\ConfigFilePool;
use Magento\Config\Model\Config\Factory as ConfigFactory;

class Config
{
    CONST HTACCESS_ENV = 'SetEnv MAGE_PROFILER Mirasvit\Profiler\Model\Driver\Standard\Output\Html';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var DeploymentConfigWriter
     */
    protected $deploymentConfigWriter;

    /**
     * @var DeploymentConfigWriter
     */
    protected $deploymentConfigReader;

    /**
     * @var ConfigFactory
     */
    protected $configFactory;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param DeploymentConfigWriter $deploymentConfigWriter
     * @param DeploymentConfigReader $deploymentConfigReader
     * @param ConfigFactory $configFactory
     */
    public function __construct(
        DeploymentConfigWriter $deploymentConfigWriter,
        DeploymentConfigReader $deploymentConfigReader,
        ScopeConfigInterface $scopeConfig,
        ConfigFactory $configFactory
    ) {
        $this->deploymentConfigWriter = $deploymentConfigWriter;
        $this->deploymentConfigReader = $deploymentConfigReader;
        $this->scopeConfig = $scopeConfig;
        $this->configFactory = $configFactory;
    }

    public function isEnabled()
    {
        return (bool)$this->scopeConfig->getValue('profiler/general/enable');
    }

    public function enableProfiler()
    {
        $config = $this->configFactory->create();
        $config->setDataByPath('profiler/general/enable', true);
        $config->save();

        $this->enableDbProfiler();
        $this->enableMageProfiler();

        return true;
    }

    public function disableProfiler()
    {
        $config = $this->configFactory->create();
        $config->setDataByPath('profiler/general/enable', false);
        $config->save();

        $this->disableDbProfiler();
        $this->disableMageProfiler();

        return true;
    }

    /**
     * @return bool
     */
    public function enableMageProfiler()
    {
        $this->disableMageProfiler();

        $path = BP . DIRECTORY_SEPARATOR . '.htaccess';
        if (file_exists($path)) {
            $content = file_get_contents($path);
            $content .= PHP_EOL . self::HTACCESS_ENV;
            file_put_contents($path, $content);
        }

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
     */
    public function disableMageProfiler()
    {
        $path = BP . DIRECTORY_SEPARATOR . '.htaccess';
        if (file_exists($path)) {
            $content = file_get_contents($path);
            $content = str_replace(self::HTACCESS_ENV, '', $content);
            file_put_contents($path, $content);
        }

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
}