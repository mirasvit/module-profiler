<?php
namespace Mirasvit\Profiler\Model\Profile;

class Magento implements ProfileInterface
{
    /**
     * {@inheritdoc}
     */
    public function dump()
    {
        $dump = [];
        foreach ($this->getStat()->getFilteredTimerIds() as $timerId) {
            $dump[$timerId] = $this->getStat()->get($timerId);
        }

        return $dump;
    }

    /**
     * @return \Magento\Framework\Profiler\Driver\Standard\Stat
     */
    public function getStat()
    {
        return $GLOBALS['MAGE_PROFILER_STAT'];
    }
}