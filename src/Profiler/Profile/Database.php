<?php

namespace Mirasvit\Profiler\Profile;

use Magento\Framework\App\ResourceConnection;
use Mirasvit\Profiler\Api\Data\ProfileInterface;

class Database implements ProfileInterface
{
    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    public function __construct(
        ResourceConnection $resourceConnection
    ) {
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * {@inheritdoc}
     */
    public function dump()
    {
        $dump = [
            'totalElapsedSecs' => $this->getProfiler()->getTotalElapsedSecs(),
            'totalNumQueries'  => $this->getProfiler()->getTotalNumQueries(),
            'profiles'         => [],
        ];

        /** @var \Zend_Db_Profiler_Query $profile */
        foreach ($this->getProfiler()->getQueryProfiles() as $profile) {
            $dump['profiles'][] = [
                'query'            => $profile->getQuery(),
                'queryType'        => $profile->getQueryType(),
                'queryParams'      => $profile->getQueryParams(),
                'elapsedSecs'      => $profile->getElapsedSecs(),
                'startedMicrotime' => $profile->getStartedMicrotime(),
            ];
        }

        return $dump;
    }

    /**
     * @return \Zend_Db_Profiler
     */
    private function getProfiler()
    {
        return $this->resourceConnection->getConnection('read')
            ->getProfiler();
    }
}