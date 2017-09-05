<?php

namespace Mirasvit\Profiler\Block\Profile;

use Magento\Framework\View\Element\Template\Context as TemplateContext;
use Magento\Framework\View\Element\Template;
use Mirasvit\Profiler\Model\Storage;

class Listing extends Template
{
    /**
     * @var Storage
     */
    private $storage;

    public function __construct(
        Storage $storage,
        Template\Context $context,
        array $data = []
    ) {
        $this->storage = $storage;

        parent::__construct($context, $data);
    }

    public function getList()
    {
        return $this->storage->getList();
    }
}