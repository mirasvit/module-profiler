<?php

namespace Mirasvit\Profiler\Profile;

use Mirasvit\Profiler\Api\Data\ProfileInterface;

class Code implements ProfileInterface
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
    private function getStat()
    {
        return $_SERVER['MAGE_PROFILER_STAT'];
    }
}