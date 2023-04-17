<?php
namespace Mirasvit\Profiler\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\DeploymentConfig\Writer as DeploymentConfigWriter;
use Magento\Framework\App\DeploymentConfig\Reader as DeploymentConfigReader;
use Magento\Framework\Config\File\ConfigFilePool;
use Magento\Config\Model\Config\Factory as ConfigFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\ResourceConnection;

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
    private $_configWriter;

    protected $resourceConnection;

    public function __construct(
        DeploymentConfigWriter $deploymentConfigWriter,
        DeploymentConfigReader $deploymentConfigReader,
        ScopeConfigInterface $scopeConfig,
        ConfigFactory $configFactory,
        DirectoryList $directoryList,
        \Magento\Framework\App\Config\Storage\WriterInterface $configWriter,
        ResourceConnection $resourceConnection
    ) {
        $this->deploymentConfigWriter = $deploymentConfigWriter;
        $this->deploymentConfigReader = $deploymentConfigReader;
        $this->scopeConfig = $scopeConfig;
        $this->configFactory = $configFactory;
        $this->directoryList = $directoryList;
        $this->_configWriter = $configWriter;
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT;
        $scopeId = 0;
        
        $connection = $this->resourceConnection->getConnection();
        $table = $connection->getTableName('core_config_data');
        $query = sprintf("SELECT value FROM `%s` WHERE path = 'profiler/general/enable' and scope = '%s' and scope_id = '%d'", $table, $scope, $scopeId);
        $result = $connection->fetchOne($query);

        return (bool)$result;
    }

    /**
     * @return bool
     */
    public function enableProfiler()
    {        
        $this->_configWriter->save('profiler/general/enable', '1', $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeId = 0);
        $this->enableDbProfiler();

        return true;
    }

    /**
     * @return bool
     */
    public function disableProfiler()
    {     
        $this->_configWriter->save('profiler/general/enable', '0', $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeId = 0);
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

        return array_filter(explode(',', $addresses ?? ''));
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