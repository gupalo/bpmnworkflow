<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Exception;

use Exception;
use JetBrains\PhpStorm\Pure;

class BpmnElementNotFoundException  extends Exception
{
    private const MESSAGE_TEMPLATE = 'Bpmn element by uid %s not found';

    #[Pure]
    public function __construct(string $uid)
    {
        parent::__construct(sprintf(self::MESSAGE_TEMPLATE, $uid));
    }
}
