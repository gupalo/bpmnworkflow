<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Symbol\Event;

use Gupalo\BpmnWorkflow\Bpmn\Symbol\SymbolInterface;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\UuidAwareInterface;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\UuidTrait;

class LinkThrow implements SymbolInterface, UuidAwareInterface
{
    use UuidTrait;

    public function __construct(
        private readonly string $name,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }
}
