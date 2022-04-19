<?php

namespace Gupalo\BpmWorkflow\Bpmn\ElementResolver;

use Gupalo\BpmWorkflow\Bpmn\BpmnElement\BpmnElement;
use JetBrains\PhpStorm\Pure;
use Gupalo\BpmWorkflow\Bpmn\FlowElement\ElementInterface;
use Gupalo\BpmWorkflow\Bpmn\FlowElement\LinkElement;

class LinkElementResolver implements ElementResolverInterface
{
    #[Pure]
    public function resolve(ElementInterface $ruleElement, BpmnElement $bpmnElement): ElementInterface
    {
        return new LinkElement($bpmnElement->getData());
    }
}
