<?php
namespace Mirasvit\Profiler\Model\Profile;

use Magento\Framework\App\ResourceConnection;

class Database implements ProfileInterface
{
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
     * {@inheritdoc}
     */
    public function dump()
    {
        $dump = [];

        /** @var \Zend_Db_Profiler_Query $profile */
        foreach ($this->getProfiler()->getQueryProfiles() as $profile) {
            $dump [] = [
                'query'             => $profile->getQuery(),
                'query_type'        => $profile->getQueryType(),
                'query_params'      => $profile->getQueryParams(),
                'elapsed_secs'      => $profile->getElapsedSecs(),
                'started_microtime' => $profile->getStartedMicrotime(),
            ];
        }

        return $dump;
    }

    /**
     * @return \Zend_Db_Profiler
     */
    public function getProfiler()
    {
        return $this->resourceConnection->getConnection('read')
            ->getProfiler();
    }
}