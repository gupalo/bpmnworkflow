<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Exception;

use Exception;
use JetBrains\PhpStorm\Pure;

class ResolverNotFoundException  extends Exception
{
    private const MESSAGE_TEMPLATE = 'Resolver for %s not found';

    #[Pure]
    public function __construct(string $type)
    {
        parent::__construct(sprintf(self::MESSAGE_TEMPLATE, $type));
    }
}
