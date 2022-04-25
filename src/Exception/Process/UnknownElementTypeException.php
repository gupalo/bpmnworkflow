<?php

namespace Gupalo\BpmnWorkflow\Exception\Process;

use Exception;
use JetBrains\PhpStorm\Pure;

class UnknownElementTypeException extends Exception
{
    private const MESSAGE_TEMPLATE = 'Unknown element type "%s"';

    #[Pure]
    public function __construct(string $name)
    {
        parent::__construct(sprintf(self::MESSAGE_TEMPLATE, $name));
    }
}

