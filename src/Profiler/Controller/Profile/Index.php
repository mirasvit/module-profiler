<?php
namespace Mirasvit\Profiler\Controller\Profile;

use Mirasvit\Profiler\Controller\Profile;
use Magento\Framework\Controller\ResultFactory;

class Index extends Profile
{
    public function execute()
    {
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE, [
            'template' => 'Mirasvit_Profiler::root.phtml',
        ]);

        $resultPage->getConfig()->getTitle()->set(__('Profiler'));

        return $resultPage;
    }
}