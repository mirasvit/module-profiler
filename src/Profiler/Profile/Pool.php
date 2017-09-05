<?php

namespace Mirasvit\Profiler\Profile;

use Mirasvit\Profiler\Api\Data\ProfileInterface;

class Pool
{
    /**
     * @var ProfileInterface[]
     */
    private $profiles;

    public function __construct(
        $profiles = []
    ) {
        $this->profiles = $profiles;
    }

    /**
     * @return ProfileInterface[]
     */
    public function getProfiles()
    {
        return $this->profiles;
    }
}