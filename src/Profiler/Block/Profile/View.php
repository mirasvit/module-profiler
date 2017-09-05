<?php

namespace Mirasvit\Profiler\Block\Profile;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\Template;
use Mirasvit\Profiler\Block\Tab\TabInterface;
use Mirasvit\Profiler\Model\Storage;

class View extends Template
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var Storage
     */
    private $storage;

    /**
     * @var array
     */
    private $tabs;

    public function __construct(
        RequestInterface $request,
        Storage $storage,
        Template\Context $context,
        array $tabs = []
    ) {
        $this->request = $request;
        $this->storage = $storage;
        $this->tabs = $tabs;

        parent::__construct($context);
    }

    public function getProfile()
    {
        return $this->storage->load($this->getRequest()->getParam('id'));
    }

    /**
     * @return TabInterface[]
     */
    public function getTabs()
    {
        return $this->tabs;
    }
}