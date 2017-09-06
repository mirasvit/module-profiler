<?php

namespace Mirasvit\Profiler\Block\Tab;

use Magento\Framework\View\Element\Template\Context as TemplateContext;
use Magento\Framework\View\Element\Template;
use Mirasvit\Profiler\Block\Context;

class IO extends Template implements TabInterface
{
    /**
     * @var string
     */
    protected $_template = 'tab/io.phtml';

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
        return 'Request / Response';
    }

    /**
     * {@inheritdoc}
     */
    public function getIcon()
    {
        return 'globe';
    }

    /**
     * @return array
     */
    public function getDump()
    {
        return $this->context->getProfile();
    }
}