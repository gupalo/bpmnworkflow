<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Symbol\Event;

use Gupalo\BpmnWorkflow\Bpmn\Symbol\SymbolInterface;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\UuidAwareInterface;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\UuidTrait;

class EndEvent implements SymbolInterface, UuidAwareInterface
{
    use UuidTrait;

    public function __construct(private bool $isDie = false)
    {
    }

    public function isDie(): bool
    {
        return $this->isDie;
    }
}
