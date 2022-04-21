<?php

namespace Gupalo\BpmnWorkflow\Bpmn\ElementResolver;

use Gupalo\BpmnWorkflow\Bpmn\BpmnElement\BpmnElement;
use Gupalo\BpmnWorkflow\Bpmn\BpmnElement\BpmnElementContainer;
use Gupalo\BpmnWorkflow\Bpmn\FlowElement\ElementInterface;
use Gupalo\BpmnWorkflow\Bpmn\FlowElement\NextElementAwareInterface;
use Gupalo\BpmnWorkflow\Bpmn\Mapping\ElementResolveMapping;

class Resolver
{
    public function __construct(private BpmnElementContainer $bpmnElementContainer)
    {
    }

    public function resolve(ElementInterface $ruleElement, BpmnElement $bpmnElement): void
    {
        if (!$ruleElement instanceof NextElementAwareInterface) {
            // @todo
            throw new \RuntimeException();
        }
        $resolverClass = ElementResolveMapping::getResolver($bpmnElement->getType());
        $resolver = ($resolverClass === GatewayElementResolver::class) ?
            new $resolverClass($this->bpmnElementContainer) :
            new $resolverClass();
        if (!$resolver instanceof ElementResolverInterface) {
            // @todo
            throw new \RuntimeException();
        }

        $next = $resolver->resolve($ruleElement, $bpmnElement);
        $ruleElement->setNextElement($next);
        if (!$resolver instanceof GatewayElementResolver) {
            if ($bpmnElement->getOutgoingUids()[0] ?? []) {
                $flow = $this->bpmnElementContainer->getElementByUid($bpmnElement->getOutgoingUids()[0]);
                $nextBpmnElement = $this->bpmnElementContainer->getElementByUid($flow->getTargetRefUid());
            }

            if (isset($nextBpmnElement) && $nextBpmnElement) {
                $this->resolve($next, $nextBpmnElement);
            }
        }
    }
}