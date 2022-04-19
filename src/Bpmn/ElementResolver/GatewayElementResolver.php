<?php

namespace Gupalo\BpmWorkflow\Bpmn\ElementResolver;

use Gupalo\BpmWorkflow\Bpmn\FlowElement\ElementInterface;
use Gupalo\BpmWorkflow\Bpmn\FlowElement\GatewayElement;
use Gupalo\BpmWorkflow\Bpmn\FlowElement\GatewayTransitionElement;
use Gupalo\BpmWorkflow\Bpmn\FlowElement\NextElementAwareInterface;

class GatewayElementResolver implements ElementResolverInterface
{
    use ElementByUidTrait;

    public function resolve(
        ElementInterface $ruleElement,
        array            $bpmnElement,
        array            $allElements
    ): ElementInterface {
        if (!$ruleElement instanceof NextElementAwareInterface) {
            // @todo
            throw new \RuntimeException();
        }
        $gateway = new GatewayElement($bpmnElement['data']);
        $transitions = [];
        foreach ($bpmnElement['outgoings'] as $outgoing) {
            $flow = $allElements['sequenceFlow'][$outgoing];
            $transition = new GatewayTransitionElement($bpmnElement['default'] === $outgoing, $flow['data']);
            $transitions[] = $transition;
            $nextBpmnElement = $this->getBpmElementByUid($flow['targetRef'], $allElements);

            (new Resolver)->resolve($transition, $nextBpmnElement, $allElements);
        }

        $gateway->setTransitions($transitions);
        $ruleElement->setNextElement($gateway);

        return $gateway;
    }
}
