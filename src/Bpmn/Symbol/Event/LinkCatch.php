<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Symbol\Event;

use Gupalo\BpmnWorkflow\Bpmn\Symbol\SymbolInterface;

class LinkCatch implements SymbolInterface
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
