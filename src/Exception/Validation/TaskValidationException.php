<?php

namespace Gupalo\BpmnWorkflow\Exception\Validation;

use Exception;
use JetBrains\PhpStorm\Pure;

class TaskValidationException extends Exception
{
    #[Pure]
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
