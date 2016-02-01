<?php
namespace Mirasvit\Profiler\Block\Tab;

use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\Template;
use Magento\Framework\App\ResourceConnection;

class Sql extends Template implements TabInterface
{
    protected $_template = 'tab/sql.phtml';

    /**
     * @var ResourceConnection
     */
    protected $resourceConnection;

    public function __construct(
        ResourceConnection $resourceConnection,
        Context $context,
        array $data = []
    ) {
        $this->resourceConnection = $resourceConnection;

        parent::__construct($context, $data);
    }

    public function getLabel()
    {
        return __('Sql');
    }

    public function isEnabled()
    {
        return is_array($this->getDbProfiler()->getQueryProfiles());
    }

    /**
     * @return \Zend_Db_Profiler
     */
    public function getDbProfiler()
    {
        return $this->resourceConnection->getConnection('read')
            ->getProfiler();
    }

    /**
     * @return array
     */
    public function getSlowQueries()
    {
        $queries = [];

        /** @var  \Zend_Db_Profiler_Query $query */
        foreach ($this->getDbProfiler()->getQueryProfiles() as $queryId => $query) {
            $queries[$queryId] = $query->getElapsedSecs();
        }

        arsort($queries);
        $queries = array_slice($queries, 0, 5, true);

        return $queries;
    }
}