<?php

namespace Gupalo\BpmnWorkflow\Exception\Process;

use Exception;
use JetBrains\PhpStorm\Pure;

class BeginElementNotFoundException extends Exception
{
    private const MESSAGE_TEMPLATE = 'Begin element not found';

    #[Pure]
    public function __construct()
    {
        parent::__construct(self::MESSAGE_TEMPLATE);
    }
}
