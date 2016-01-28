<?php
namespace Mirasvit\Profiler\Block;

use Magento\Framework\View\Element\Template\Context as TemplateContext;
use Magento\Framework\View\Element\Template;

class Container extends Template
{
    protected $_template = 'container.phtml';

    protected $tabs = [];

    public function __construct(
        TemplateContext $context,
        Tab\Profiler $tabProfiler,
        Tab\Sql $tabSql,
        array $data = [],
        array $tabs = []
    ) {

        $this->tabs = [
            $tabProfiler,
            $tabSql
        ];

        parent::__construct($context, $data);
    }

    /**
     * @return Tab\TabInterface[]
     */
    public function getTabs()
    {
        return $this->tabs;
    }



//    public function setStat(Stat $stat)
//    {
//        $this->stat = $stat;
//    }
//
//    /**
//     * @return \Magento\Framework\Profiler\Driver\Standard\Stat
//     */
//    public function getStat()
//    {
//        return $this->stat;
//    }
}