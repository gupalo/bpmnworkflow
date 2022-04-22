<?php

namespace Gupalo\BpmnWorkflow\Bpmn\ElementResolver;

use Gupalo\BpmnWorkflow\Bpmn\BpmnElement\BpmnElement;
use Gupalo\BpmnWorkflow\Bpmn\BpmnElement\BpmnElementContainer;
use Gupalo\BpmnWorkflow\Bpmn\Exception\NextElementNotFoundException;
use Gupalo\BpmnWorkflow\Bpmn\Exception\ResolverNotFoundException;
use Gupalo\BpmnWorkflow\Bpmn\FlowElement\ElementInterface;
use Gupalo\BpmnWorkflow\Bpmn\FlowElement\NextElementAwareInterface;
use Gupalo\BpmnWorkflow\Bpmn\Mapping\ElementResolveMapping;

class Resolver
{
    public function __construct(private BpmnElementContainer $bpmnElementContainer)
    {
    }

    public function resolve(ElementInterface $element, BpmnElement $bpmnElement): void
    {
        if (!$element instanceof NextElementAwareInterface) {
            throw new NextElementNotFoundException();
        }
        $resolverClass = ElementResolveMapping::getResolver($bpmnElement->getType());
        $resolver = ($resolverClass === GatewayElementResolver::class) ?
            new $resolverClass($this->bpmnElementContainer) :
            new $resolverClass();
        if (!$resolver instanceof ElementResolverInterface) {
            throw new ResolverNotFoundException($bpmnElement->getType());
        }

        $next = $resolver->resolve($element, $bpmnElement);
        $element->setNextElement($next);
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