<?php
namespace Mirasvit\Profiler\Block\Tab;

interface TabInterface
{
    /**
     * @return string
     */
    public function getIcon();

    /**
     * @return string
     */
    public function getLabel();
}