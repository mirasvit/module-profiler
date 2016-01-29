<?php
namespace Mirasvit\Profiler\Block;

use Magento\Framework\App\ResourceConnection;

class Context
{
    /**
     * @var \Magento\Framework\Profiler\Driver\Standard\Stat
     */
    protected $profilerStat;

    /**
     * @var ResourceConnection
     */
    protected $resourceConnection;

    public function __construct(
        ResourceConnection $resourceConnection
    ) {
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * @param \Magento\Framework\Profiler\Driver\Standard\Stat $stat
     * @return $this
     */
    public function setProfilerStat($stat)
    {
        $this->profilerStat = $stat;

        return $this;
    }

    /**
     * @return \Magento\Framework\Profiler\Driver\Standard\Stat
     */
    public function getProfilerStat()
    {
        return $this->profilerStat;
    }

    /**
     * @return \Zend_Db_Profiler
     */
    public function getDbProfiler()
    {
        return $this->resourceConnection->getConnection('read')
            ->getProfiler();
    }
}