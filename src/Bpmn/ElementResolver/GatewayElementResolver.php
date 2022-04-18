<?php

namespace Gupalo\BpmWorkflow\Bpmn\ElementResolver;

use Gupalo\BpmWorkflow\Bpmn\FlowElement\FlowElementInterface;
use Gupalo\BpmWorkflow\Bpmn\FlowElement\GatewayFlowElement;
use Gupalo\BpmWorkflow\Bpmn\FlowElement\GatewayTransitionFlowElement;
use Gupalo\BpmWorkflow\Bpmn\FlowElement\NextFlowElementAwareInterface;

class GatewayElementResolver implements ElementResolverInterface
{
    use ElementByUidTrait;

    public function resolve(
        FlowElementInterface $ruleElement,
        array                $bpmnElement,
        array                $allElements
    ): FlowElementInterface {
        if (!$ruleElement instanceof NextFlowElementAwareInterface) {
            // @todo
            throw new \RuntimeException();
        }
        $gateway = new GatewayFlowElement($bpmnElement['data']);
        $transitions = [];
        foreach ($bpmnElement['outgoings'] as $outgoing) {
            $flow = $allElements['sequenceFlow'][$outgoing];
            $transition = new GatewayTransitionFlowElement($bpmnElement['default'] === $outgoing, $flow['data']);
            $transitions[] = $transition;
            $nextBpmnElement = $this->getBpmElementByUid($flow['targetRef'], $allElements);

            (new Resolver)->resolve($transition, $nextBpmnElement, $allElements);
        }

        $gateway->setTransitions($transitions);
        $ruleElement->setNextElement($gateway);

        return $gateway;
    }
}
