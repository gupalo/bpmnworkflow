<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Symbol\Activity;

use Gupalo\BpmnWorkflow\Bpmn\Symbol\NextSymbolAwareInterface;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\NextSymbolTrait;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\SymbolInterface;

class Task implements SymbolInterface, NextSymbolAwareInterface
{
    use NextSymbolTrait;

    public function __construct(
        private readonly string $name,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }
}
