<?php

namespace Gupalo\BpmnWorkflow\Exception\Process;

use Exception;
use JetBrains\PhpStorm\Pure;

class MaxStepsExceededException extends Exception
{
    private const MESSAGE_TEMPLATE = 'Max steps exceeded';

    #[Pure]
    public function __construct()
    {
        parent::__construct(self::MESSAGE_TEMPLATE);
    }
}

