<?php

namespace Mirasvit\Profiler\Block;

use Magento\Framework\View\Element\Template\Context as TemplateContext;
use Magento\Framework\View\Element\Template;

class Iframe extends Template
{
    /**
     * @var string
     */
    protected $_template = 'iframe.phtml';

    /**
     * @var TemplateContext
     */
    protected $context;

    public function __construct(
        TemplateContext $templateContext,
        Context $context,
        array $data = []
    ) {
        $this->context = $context;

        parent::__construct($templateContext, $data);
    }
}