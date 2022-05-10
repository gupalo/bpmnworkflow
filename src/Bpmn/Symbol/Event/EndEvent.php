<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Symbol\Event;

use Gupalo\BpmnWorkflow\Bpmn\Symbol\SymbolInterface;

class EndEvent implements SymbolInterface
{
    public function __construct(private bool $isDie = false)
    {
    }
    
    public function isDie(): bool
    {
        return $this->isDie;
    }
}
