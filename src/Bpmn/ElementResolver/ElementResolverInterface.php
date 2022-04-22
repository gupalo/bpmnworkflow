<?php

namespace Gupalo\BpmnWorkflow\Bpmn\ElementResolver;

use Gupalo\BpmnWorkflow\Bpmn\BpmnElement\BpmnElement;
use Gupalo\BpmnWorkflow\Bpmn\FlowElement\ElementInterface;

interface ElementResolverInterface
{
    public function resolve (ElementInterface $element, BpmnElement $bpmnElement): ElementInterface;
}