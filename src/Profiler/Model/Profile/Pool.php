<?php
namespace Mirasvit\Profiler\Model\Profile;

class Pool
{
    /**
     * @var array
     */
    private $profiles;

    public function __construct(
        $profiles = []
    ) {
        $this->profiles = $profiles;
    }

    /**
     * @return array
     */
    public function getProfiles()
    {
        return $this->profiles;
    }
}