<?php

namespace Gupalo\BpmWorkflow\Bpmn\ElementResolver;

use Gupalo\BpmWorkflow\Bpmn\BpmnElement\BpmnElement;
use Gupalo\BpmWorkflow\Bpmn\BpmnElement\BpmnElementContainer;
use Gupalo\BpmWorkflow\Bpmn\FlowElement\ElementInterface;
use Gupalo\BpmWorkflow\Bpmn\FlowElement\NextElementAwareInterface;
use Gupalo\BpmWorkflow\Bpmn\Mapping\ElementResolveMapping;

class Resolver
{
    public function resolve(ElementInterface $ruleElement, BpmnElement $bpmnElement): void
    {
        if (!$ruleElement instanceof NextElementAwareInterface) {
            // @todo
            throw new \RuntimeException();
        }
        $bpmnElementContainer = BpmnElementContainer::getInstance();
        $resolverClass = ElementResolveMapping::getResolver($bpmnElement->getType());
        $resolver = new $resolverClass();
        if (!$resolver instanceof ElementResolverInterface) {
            // @todo
            throw new \RuntimeException();
        }

        $next = $resolver->resolve($ruleElement, $bpmnElement);
        $ruleElement->setNextElement($next);
        if (!$resolver instanceof GatewayElementResolver) {
            if ($bpmnElement->getOutgoingUids()[0] ?? []) {
                $flow = $bpmnElementContainer->getElementByUid($bpmnElement->getOutgoingUids()[0]);
                $nextBpmnElement = $bpmnElementContainer->getElementByUid($flow->getTargetRefUid());
            }

            if (isset($nextBpmnElement) && $nextBpmnElement) {
                $this->resolve($next, $nextBpmnElement);
            }
        }
    }
}