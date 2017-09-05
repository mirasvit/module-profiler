<?php

namespace Mirasvit\Profiler\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Format extends AbstractHelper
{
    /**
     * @param float $number
     * @param bool $isSeconds
     * @return string
     */
    public function formatTime($number, $isSeconds = false)
    {
        if ($isSeconds) {
            $number *= 1000;
        }

        return number_format($number, 1, '.', ' ');
    }

    /**
     * @param array|object $any
     * @return string
     */
    public function any($any)
    {
        if (is_array($any)) {
            if (count($any)) {
                return '<pre>' . print_r($any, true) . '</pre>';
            }
        } else {
            return json_encode($any);
        }

        return '';
    }
}