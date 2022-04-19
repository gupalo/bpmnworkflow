<?php

namespace Gupalo\BpmWorkflow\Bpmn\ElementResolver;

use Gupalo\BpmWorkflow\Bpmn\BpmnElement\BpmnElement;
use Gupalo\BpmWorkflow\Bpmn\FlowElement\ElementInterface;

interface ElementResolverInterface
{
    public function resolve (ElementInterface $ruleElement, BpmnElement $bpmnElement): ElementInterface;
}