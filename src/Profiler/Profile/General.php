<?php

namespace Mirasvit\Profiler\Profile;

use Mirasvit\Profiler\Api\Data\ProfileInterface;
use Magento\Framework\App\ResourceConnection;

class General implements ProfileInterface
{
    const EXECUTION_TIME = 'EXECUTION_TIME';
    const IP = 'IP';
    const URI = 'URI';
    const IS_CLI = 'IS_CLI';
    const CLI_ARGS = 'CLI_ARGS';
    const DB_QUERIES = 'DB_QUERIES';
    const DB_TIME = 'DB_TIME';

    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    /**
     * @var Context
     */
    private $context;

    public function __construct(
        ResourceConnection $resourceConnection,
        Context $context
    ) {
        $this->resourceConnection = $resourceConnection;
        $this->context = $context;
    }

    /**
     * {@inheritdoc}
     */
    public function dump()
    {
        /** @var  \Zend_Db_Profiler $db */
        $db = $this->resourceConnection->getConnection('read')
            ->getProfiler();

        $dump = [
            self::EXECUTION_TIME => $this->context->getExecutionTime(),
            self::IP             => $this->context->getClientIP(),
            self::URI            => $this->context->getURI(),
            self::IS_CLI         => $this->context->isCLI(),
            self::CLI_ARGS       => $this->context->getCliArgs(),
            self::DB_QUERIES     => $db->getTotalNumQueries(),
            self::DB_TIME        => round($db->getTotalElapsedSecs() * 1000),
        ];


        return $dump;
    }

}