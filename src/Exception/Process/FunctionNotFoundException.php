<?php

namespace Gupalo\BpmnWorkflow\Exception\Process;

use Exception;
use JetBrains\PhpStorm\Pure;

class FunctionNotFoundException extends Exception
{
    private const MESSAGE_TEMPLATE = 'Gateway by name %s not found';

    #[Pure]
    public function __construct(string $name)
    {
        parent::__construct(sprintf(self::MESSAGE_TEMPLATE, $name));
    }
}

