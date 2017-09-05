<?php

namespace Mirasvit\Profiler\Block\Tab;

use Magento\Framework\View\Element\Template\Context as TemplateContext;
use Magento\Framework\View\Element\Template;
use Magento\Framework\App\ResourceConnection;
use Mirasvit\Profiler\Block\Context;

class Sql extends Template implements TabInterface
{
    /**
     * @var string
     */
    protected $_template = 'tab/sql.phtml';

    /**
     * @var Context
     */
    private $context;

    public function __construct(
        Context $context,
        TemplateContext $templateContext
    ) {
        $this->context = $context;

        parent::__construct($templateContext);
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return __('Database');
    }

    /**
     * {@inheritdoc}
     */
    public function getIcon()
    {
        return 'database';
    }

    /**
     * @return array
     */
    public function getDump()
    {
        return $this->context->getProfile()['database'];
    }

    /**
     * @return array
     */
    public function getSlowQueries()
    {
        $queries = [];

        /** @var  \Zend_Db_Profiler_Query $query */
        foreach ($this->getDbProfiler()->getQueryProfiles() as $queryId => $query) {
            $queries[$queryId] = $query->getElapsedSecs();
        }

        arsort($queries);
        $queries = array_slice($queries, 0, 5, true);

        return $queries;
    }
}