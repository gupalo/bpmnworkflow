<?php

namespace Gupalo\BpmnWorkflow\Exception\Process;

use Exception;
use JetBrains\PhpStorm\Pure;

class ComparisonNotFoundException extends Exception
{
    private const MESSAGE_TEMPLATE = 'Condition "%s" not found';

    #[Pure]
    public function __construct(string $identity)
    {
        parent::__construct(sprintf(self::MESSAGE_TEMPLATE, $identity));
    }
}

