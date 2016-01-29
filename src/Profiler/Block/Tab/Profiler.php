<?php
namespace Mirasvit\Profiler\Block\Tab;

use Magento\Framework\View\Element\Template\Context as TemplateContext;
use Magento\Framework\View\Element\Template;
use Mirasvit\Profiler\Block\Context;

class Profiler extends Template implements TabInterface
{
    protected $_template = 'tab/profiler.phtml';

    /**
     * @var Context
     */
    protected $context;

    public function __construct(
        Context $context,
        TemplateContext $templateContext,
        array $data = []
    ) {
        $this->context = $context;

        parent::__construct($templateContext, $data);
    }

    public function getLabel()
    {
        return __('Profiler');
    }

    /**
     * @return \Magento\Framework\Profiler\Driver\Standard\Stat
     */
    public function getStat()
    {
        return $this->context->getProfilerStat();
    }

    public function renderTimerId($timerId)
    {
        $nestingSep = preg_quote('->', '/');
        return preg_replace('/.+?' . $nestingSep . '/', '', $timerId);
    }

    public function getParentTimerId($timerId)
    {
        $timerId = explode('->', $timerId);
        array_pop($timerId);

        return implode('->', $timerId);
    }

    public function getTimerLength($timerId)
    {
        $total = microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'];
        return round($this->getStat()->fetch($timerId, 'sum') / $total * 100, 2);
    }
}