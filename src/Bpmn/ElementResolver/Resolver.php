<?php

namespace Gupalo\BpmWorkflow\Bpmn\ElementResolver;

use Gupalo\BpmWorkflow\Bpmn\FlowElement\FlowElementInterface;
use Gupalo\BpmWorkflow\Bpmn\FlowElement\NextFlowElementAwareInterface;
use Gupalo\BpmWorkflow\Bpmn\Mapping\ElementResolveMapping;

class Resolver
{
    use ElementByUidTrait;

    public function resolve(FlowElementInterface $ruleElement, array $bpmnElement, array $allElements): void
    {
        if (!$ruleElement instanceof NextFlowElementAwareInterface) {
            // @todo
            throw new \RuntimeException();
        }
        $resolver = new (ElementResolveMapping::getResolver($bpmnElement['type']));
        if (!$resolver instanceof ElementResolverInterface) {
            // @todo
            throw new \RuntimeException();
        }

        $next = $resolver->resolve($ruleElement, $bpmnElement, $allElements);
        $ruleElement->setNextElement($next);
        if (!$resolver instanceof GatewayElementResolver) {
            if ($bpmnElement['outgoings'][0] ?? []) {
                $flow = $allElements['sequenceFlow'][$bpmnElement['outgoings'][0]];
                $nextBpmnElement = $this->getBpmElementByUid($flow['targetRef'], $allElements);
            }

            if (isset($nextBpmnElement) && $nextBpmnElement) {
                $this->resolve($next, $nextBpmnElement, $allElements);
            }
        }
    }
}