<?php

namespace Gupalo\BpmWorkflow\Bpmn\ElementResolver;

use JetBrains\PhpStorm\Pure;
use Gupalo\BpmWorkflow\Bpmn\FlowElement\FlowElementInterface;
use Gupalo\BpmWorkflow\Bpmn\FlowElement\TaskFlowElement;

class TaskElementResolver implements ElementResolverInterface
{
    #[Pure]
    public function resolve(
        FlowElementInterface $ruleElement,
        array                $bpmnElement,
        array                $allElements
    ): FlowElementInterface {
        return  new TaskFlowElement($bpmnElement['data']);
    }
}
