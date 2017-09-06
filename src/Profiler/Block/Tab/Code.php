<?php

namespace Mirasvit\Profiler\Block\Tab;

use Magento\Framework\View\Element\Template\Context as TemplateContext;
use Magento\Framework\View\Element\Template;
use Mirasvit\Profiler\Block\Context;

class Code extends Template implements TabInterface
{
    /**
     * @var string
     */
    protected $_template = 'tab/code.phtml';

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

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'Performance';
    }

    /**
     * {@inheritdoc}
     */
    public function getIcon()
    {
        return 'clock-o';
    }

    /**
     * @return array
     */
    public function getCodeDump()
    {
        return $this->context->getProfile()['code'];
    }

    /**
     * @return array
     */
    public function getGeneralDump()
    {
        return $this->context->getProfile()['general'];
    }

    public function getLevel($timerId)
    {
        return substr_count($timerId, '->');
    }

    /**
     * @param int $timerId
     * @return string
     */
    public function renderTimerId($timerId)
    {
        $nestingSep = preg_quote('->', '/');

        return preg_replace('/.+?' . $nestingSep . '/', '', $timerId);
    }

    /**
     * @param int $timerId
     * @return string
     */
    public function getParentTimerId($timerId)
    {
        $timerId = explode('->', $timerId);
        array_pop($timerId);

        return implode('->', $timerId);
    }

    /**
     * @param int $timerId
     * @return float
     */
    public function getTimerLength($timerId)
    {
        return 0;
        $total = microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'];

        return round($this->getStat()->fetch($timerId, 'sum') / $total * 100, 2);
    }

    /**
     * @return float
     */
    public function getTotalTime()
    {
        return microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'];
    }
}