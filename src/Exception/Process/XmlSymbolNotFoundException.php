<?php

namespace Gupalo\BpmnWorkflow\Exception\Process;

use Exception;
use JetBrains\PhpStorm\Pure;

class XmlSymbolNotFoundException extends Exception
{
    private const MESSAGE_TEMPLATE = 'Bpmn element by uid %s not found';

    #[Pure]
    public function __construct(string $uid)
    {
        parent::__construct(sprintf(self::MESSAGE_TEMPLATE, $uid));
    }
}
