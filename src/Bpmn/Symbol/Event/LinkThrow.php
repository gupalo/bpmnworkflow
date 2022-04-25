<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Symbol\Event;

use Gupalo\BpmnWorkflow\Bpmn\Symbol\SymbolInterface;

class LinkThrow implements SymbolInterface
{
    public function __construct(
        private readonly string $name,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }
}
