<?php

namespace Mirasvit\Profiler\Profile;

class Context
{

    /**
     * @return float
     */
    public function getExecutionTime()
    {
        return (microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']) * 1000;
    }

    /**
     * @return string|false
     */
    public function getClientIP()
    {
        if (isset($_SERVER['REMOTE_ADDR'])) {
            return $_SERVER['REMOTE_ADDR'];
        }

        return false;
    }

    /**
     * @return string|false
     */
    public function getURI()
    {
        if (isset($_SERVER['REQUEST_URI'])) {
            return $_SERVER['REQUEST_URI'];
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isCLI()
    {
        return PHP_SAPI == 'cli';
    }

    /**
     * @return false|string
     */
    public function getCliArgs()
    {
        if ($this->isCLI()) {
            global $argv;
            return implode(' ', $argv);
        }

        return false;
    }
}