<?php

namespace Gupalo\BpmnWorkflow\Exception;

use Exception;
use JetBrains\PhpStorm\Pure;

class MaxExecutionCountException extends Exception
{
    private const MESSAGE_TEMPLATE = 'Max execution count process';

    #[Pure]
    public function __construct()
    {
        parent::__construct(self::MESSAGE_TEMPLATE);
    }
}
