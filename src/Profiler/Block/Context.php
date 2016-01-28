<?php
namespace Mirasvit\Profiler\Block;

class Context
{
    /**
     * @var \Magento\Framework\Profiler\Driver\Standard\Stat
     */
    protected $profilerStat;

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
}