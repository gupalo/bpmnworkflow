<?php

namespace Gupalo\BpmWorkflow\Bpmn\ElementResolver;

use JetBrains\PhpStorm\Pure;
use Gupalo\BpmWorkflow\Bpmn\FlowElement\ElementInterface;
use Gupalo\BpmWorkflow\Bpmn\FlowElement\TaskElement;

class TaskElementResolver implements ElementResolverInterface
{
    #[Pure]
    public function resolve(
        ElementInterface $ruleElement,
        array            $bpmnElement,
        array            $allElements
    ): ElementInterface {
        return  new TaskElement($bpmnElement['data']);
    }
}
