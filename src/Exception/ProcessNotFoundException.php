<?php

namespace Gupalo\BpmnWorkflow\Exception;

use Exception;
use JetBrains\PhpStorm\Pure;

class ProcessNotFoundException extends Exception
{
    private const MESSAGE_TEMPLATE = 'Workflow "%s" not found';

    #[Pure]
    public function __construct(string $name)
    {
        parent::__construct(sprintf(self::MESSAGE_TEMPLATE, $name));
    }
}

