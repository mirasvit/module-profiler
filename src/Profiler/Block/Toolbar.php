<?php

namespace Mirasvit\Profiler\Block;

use Magento\Framework\View\Element\Template\Context as TemplateContext;
use Magento\Framework\View\Element\Template;
use Magento\Framework\Url;

/**
 * @method string getProfileId()
 */
class Toolbar extends Template
{
    /**
     * @var string
     */
    protected $_template = 'toolbar.phtml';

    /**
     * @var Context
     */
    private $context;

    /**
     * @var Url
     */
    private $urlHelper;

    public function __construct(
        TemplateContext $templateContext,
        Url $urlHelper,
        Context $context
    ) {
        $this->context = $context;
        $this->urlHelper = $urlHelper;

        parent::__construct($templateContext);
    }

    /**
     * @return array
     */
    public function getDump()
    {
        return $this->context->getProfile($this->getProfileId());
    }

    /**
     * @return string
     */
    public function getProfileUrl()
    {
        return $this->urlHelper->getUrl('profiler/profile/view', ['id' => $this->getProfileId()]);
    }
}