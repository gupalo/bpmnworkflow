<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Exception;

use Exception;
use JetBrains\PhpStorm\Pure;

class ConditionNotFoundException  extends Exception
{
    private const MESSAGE_TEMPLATE = 'Condition by identity %s not found';

    #[Pure]
    public function __construct(string $identity)
    {
        parent::__construct(sprintf(self::MESSAGE_TEMPLATE, $identity));
    }
}

