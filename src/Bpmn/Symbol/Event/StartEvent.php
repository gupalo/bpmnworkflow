<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Symbol\Event;

use Gupalo\BpmnWorkflow\Bpmn\Symbol\NextSymbolAwareInterface;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\NextSymbolTrait;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\SymbolInterface;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\UuidAwareInterface;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\UuidTrait;

class StartEvent implements SymbolInterface, NextSymbolAwareInterface, UuidAwareInterface
{
    use NextSymbolTrait;
    use UuidTrait;
}
