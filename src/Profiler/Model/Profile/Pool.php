<?php
namespace Mirasvit\Profiler\Model\Profile;

class Pool
{
    protected $profiles;

    public function __construct(
        $profiles = array()
    ) {
        $this->profiles = $profiles;
    }

    public function getProfiles()
    {
        return $this->profiles;
    }
}