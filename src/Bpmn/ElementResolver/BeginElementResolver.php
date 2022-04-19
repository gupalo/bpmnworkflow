<?php

namespace Gupalo\BpmWorkflow\Bpmn\ElementResolver;

use Gupalo\BpmWorkflow\Bpmn\FlowElement\BeginElement;
use JetBrains\PhpStorm\Pure;
use Gupalo\BpmWorkflow\Bpmn\FlowElement\ElementInterface;

class BeginElementResolver implements ElementResolverInterface
{
    #[Pure]
    public function resolve(
        ElementInterface $ruleElement,
        array            $bpmnElement,
        array            $allElements
    ): ElementInterface {
        return new BeginElement();
    }
}
