<?php

namespace Gupalo\BpmnWorkflow\Bpmn\ElementResolver;

use Gupalo\BpmnWorkflow\Bpmn\BpmnElement\BpmnElement;
use Gupalo\BpmnWorkflow\Bpmn\BpmnElement\BpmnElementContainer;
use Gupalo\BpmnWorkflow\Bpmn\FlowElement\ElementInterface;
use Gupalo\BpmnWorkflow\Bpmn\FlowElement\GatewayElement;
use Gupalo\BpmnWorkflow\Bpmn\FlowElement\GatewayTransitionElement;
use Gupalo\BpmnWorkflow\Bpmn\FlowElement\NextElementAwareInterface;

class GatewayElementResolver implements ElementResolverInterface
{
    public function __construct(private BpmnElementContainer $bpmnElementContainer)
    {
    }

    public function resolve(ElementInterface $ruleElement, BpmnElement $bpmnElement): ElementInterface
    {
        if (!$ruleElement instanceof NextElementAwareInterface) {
            // @todo
            throw new \RuntimeException();
        }
        $gateway = new GatewayElement($bpmnElement->getData());
        $transitions = [];
        foreach ($bpmnElement->getOutgoingUids() as $outgoing) {
            $flow = $this->bpmnElementContainer->getElementByUid($outgoing);
            $transition = new GatewayTransitionElement($bpmnElement->getDefaultUid() === $outgoing, $flow->getData());
            $transitions[] = $transition;
            $nextBpmnElement = $this->bpmnElementContainer->getElementByUid($flow->getTargetRefUid());

            (new Resolver($this->bpmnElementContainer))->resolve($transition, $nextBpmnElement);
        }

        $gateway->setTransitions($transitions);
        $ruleElement->setNextElement($gateway);

        return $gateway;
    }
}
