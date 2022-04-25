<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Symbol\Event;

use Gupalo\BpmnWorkflow\Bpmn\Symbol\NextSymbolAwareInterface;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\NextSymbolTrait;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\SymbolInterface;

class StartEvent implements SymbolInterface, NextSymbolAwareInterface
{
    use NextSymbolTrait;
}
