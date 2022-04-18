<?php

namespace Gupalo\BpmWorkflow\Bpmn\ElementResolver;

use Gupalo\BpmWorkflow\Bpmn\FlowElement\FlowElementInterface;

interface ElementResolverInterface
{
    public function resolve (
        FlowElementInterface $ruleElement,
        array                $bpmnElement,
        array                $allElements
    ): FlowElementInterface;
}