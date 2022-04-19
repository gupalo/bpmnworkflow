<?php

namespace Gupalo\BpmWorkflow\Bpmn\ElementResolver;

use Gupalo\BpmWorkflow\Bpmn\BpmnElement\BpmnElement;
use Gupalo\BpmWorkflow\Bpmn\BpmnElement\BpmnElementContainer;
use Gupalo\BpmWorkflow\Bpmn\FlowElement\ElementInterface;
use Gupalo\BpmWorkflow\Bpmn\FlowElement\GatewayElement;
use Gupalo\BpmWorkflow\Bpmn\FlowElement\GatewayTransitionElement;
use Gupalo\BpmWorkflow\Bpmn\FlowElement\NextElementAwareInterface;

class GatewayElementResolver implements ElementResolverInterface
{
    public function resolve(ElementInterface $ruleElement, BpmnElement $bpmnElement): ElementInterface
    {
        if (!$ruleElement instanceof NextElementAwareInterface) {
            // @todo
            throw new \RuntimeException();
        }
        $bpmnElementContainer = BpmnElementContainer::getInstance();
        $gateway = new GatewayElement($bpmnElement->getData());
        $transitions = [];
        foreach ($bpmnElement->getOutgoingUids() as $outgoing) {
            $flow = $bpmnElementContainer->getElementByUid($outgoing);
            $transition = new GatewayTransitionElement($bpmnElement->getDefaultUid() === $outgoing, $flow->getData());
            $transitions[] = $transition;
            $nextBpmnElement = $bpmnElementContainer->getElementByUid($flow->getTargetRefUid());

            (new Resolver)->resolve($transition, $nextBpmnElement);
        }

        $gateway->setTransitions($transitions);
        $ruleElement->setNextElement($gateway);

        return $gateway;
    }
}
