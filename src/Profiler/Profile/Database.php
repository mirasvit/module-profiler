<?php

namespace Mirasvit\Profiler\Profile;

use Magento\Framework\App\ResourceConnection;
use Mirasvit\Profiler\Api\Data\ProfileInterface;

class Database implements ProfileInterface
{
    const TOTAL_ELAPSED = 'totalElapsedSecs';
    const TOTAL_QUERIES = 'totalNumQueries';

    const QUERY = 'query';
    const QUERY_TYPE = 'queryType';
    const QUERY_PARAMS = 'queryParams';
    const QUERY_ELAPSED = 'elapsedSecs';
    const QUERY_STARTED = 'startedMicrotime';
    const QUERY_COUNT = 'queryCount';

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
        $queryCountBucket = [];
        $dump = [
            self::TOTAL_ELAPSED => $this->getProfiler()->getTotalElapsedSecs() * 1000,
            self::TOTAL_QUERIES => $this->getProfiler()->getTotalNumQueries(),
            'profiles'          => [],
        ];

        $profiles = $this->getProfiler()->getQueryProfiles();
        if (is_array($profiles)) {
            /** @var \Zend_Db_Profiler_Query $profile */
            foreach ($profiles as $profile) {
                if (!isset($queryCountBucket[$profile->getQuery()])) {
                    $queryCountBucket[$profile->getQuery()] = 0;
                }

                $queryCountBucket[$profile->getQuery()]++;

                $dump['profiles'][] = [
                    self::QUERY         => $profile->getQuery(),
                    self::QUERY_TYPE    => $profile->getQueryType(),
                    self::QUERY_PARAMS  => $profile->getQueryParams(),
                    self::QUERY_ELAPSED => $profile->getElapsedSecs() * 1000,
                    self::QUERY_STARTED => $profile->getStartedMicrotime(),
                    self::QUERY_COUNT   => $queryCountBucket[$profile->getQuery()]
                ];
            }
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