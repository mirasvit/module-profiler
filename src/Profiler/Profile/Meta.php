<?php

namespace Mirasvit\Profiler\Profile;

use Mirasvit\Profiler\Api\Data\ProfileInterface;

class Meta implements ProfileInterface
{
    const RESPONSE_CODE = 'RESPONSE_CODE';
    const IP = 'IP';
    const METHOD = 'METHOD';
    const TIME = 'TIME';
    const EXECUTION_TIME = 'EXECUTION_TIME';
    const URL = 'URL';

    private $context;

    public function __construct(
        Context $context
    ) {
        $this->context = $context;
    }

    /**
     * {@inheritdoc}
     */
    public function dump()
    {
        if ($this->context->isCLI()) {
            $url = $this->context->getCliArgs();
        } else {
            $url = $this->context->getURI();
        }
        $dump = [
            'RESPONSE_CODE'  => http_response_code(),
            'METHOD'         => $this->context->isCLI() ? 'CLI' : $_SERVER['REQUEST_METHOD'],
            'TIME'           => microtime(true),
            'EXECUTION_TIME' => $this->context->getExecutionTime(),
            'URL'            => $url,
            'IP'             => $this->context->getClientIP(),
        ];

        return $dump;
    }
}