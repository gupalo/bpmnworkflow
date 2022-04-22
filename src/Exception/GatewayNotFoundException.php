<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Exception;

use Exception;
use JetBrains\PhpStorm\Pure;

class GatewayNotFoundException  extends Exception
{
    private const MESSAGE_TEMPLATE = 'Gateway by name %s not found';

    #[Pure]
    public function __construct(string $name)
    {
        parent::__construct(sprintf(self::MESSAGE_TEMPLATE, $name));
    }
}

