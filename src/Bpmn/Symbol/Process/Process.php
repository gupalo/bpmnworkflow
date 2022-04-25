<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Symbol\Process;

use Gupalo\BpmnWorkflow\Bpmn\Symbol\NextSymbolAwareInterface;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\NextSymbolTrait;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\SymbolInterface;

class Process implements SymbolInterface, NextSymbolAwareInterface
{
    use NextSymbolTrait;
}
