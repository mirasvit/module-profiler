<?php

namespace Mirasvit\Profiler\Controller;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

abstract class Profile extends Action
{
    public function __construct(
        Context $context
    ) {

        parent::__construct($context);
    }
}
