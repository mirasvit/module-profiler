<?php
namespace Mirasvit\Profiler\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Format extends AbstractHelper
{
    /**
     * @param float $number
     * @param bool  $isSeconds
     * @return string
     */
    public function formatTime($number, $isSeconds = true)
    {
        if ($isSeconds) {
            $number *= 1000;
        }

        return number_format($number, 1);
    }
}