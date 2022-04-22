<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Exception;

use Exception;
use JetBrains\PhpStorm\Pure;

class NextElementNotFoundException  extends Exception
{
    private const MESSAGE_TEMPLATE = 'Next element not found';

    #[Pure]
    public function __construct()
    {
        parent::__construct(self::MESSAGE_TEMPLATE);
    }
}
