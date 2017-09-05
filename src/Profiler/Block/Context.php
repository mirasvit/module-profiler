<?php

namespace Mirasvit\Profiler\Block;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResourceConnection;
use Mirasvit\Profiler\Model\Storage;

class Context
{
    private $request;

    private $storage;

    public function __construct(
        RequestInterface $request,
        Storage $storage
    ) {
        $this->request = $request;
        $this->storage = $storage;
    }

    public function getProfile()
    {
        return $this->storage->load($this->request->getParam('id'));
    }


    //    /**
    //     * @param \Magento\Framework\Profiler\Driver\Standard\Stat $stat
    //     * @return $this
    //     */
    //    public function setProfilerStat($stat)
    //    {
    //        $this->profilerStat = $stat;
    //
    //        return $this;
    //    }
    //
    //    /**
    //     * @return \Magento\Framework\Profiler\Driver\Standard\Stat
    //     */
    //    public function getProfilerStat()
    //    {
    //        return $this->profilerStat;
    //    }
    //
    //    /**
    //     * @return \Zend_Db_Profiler
    //     */
    //    public function getDbProfiler()
    //    {
    //        return $this->resourceConnection->getConnection('read')
    //            ->getProfiler();
    //    }
}