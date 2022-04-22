<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Exception\Validation;

use Exception;
use JetBrains\PhpStorm\Pure;

class CommonElementValidationException  extends Exception
{
    #[Pure]
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
