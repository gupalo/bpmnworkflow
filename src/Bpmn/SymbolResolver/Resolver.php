<?php

namespace Gupalo\BpmnWorkflow\Bpmn\SymbolResolver;

use Gupalo\BpmnWorkflow\Bpmn\Symbol\NextSymbolAwareInterface;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\SymbolInterface;
use Gupalo\BpmnWorkflow\Bpmn\XmlSymbol\XmlSymbol;
use Gupalo\BpmnWorkflow\Bpmn\XmlSymbol\XmlSymbolContainer;
use Gupalo\BpmnWorkflow\Exception\Process\MaxStepsExceededException;
use Gupalo\BpmnWorkflow\Exception\Process\NextElementNotFoundException;
use Gupalo\BpmnWorkflow\Exception\ResolverNotFoundException;

class Resolver
{
    private const DEFAULT_MAX_STEPS = 10000;

    public function __construct(
        private readonly XmlSymbolContainer $xmlSymbolContainer,
    ) {
    }

    public function resolve(
        SymbolInterface $element,
        XmlSymbol $xmlSymbol,
        int $maxSteps = self::DEFAULT_MAX_STEPS
    ): void {
        if (!$element instanceof NextSymbolAwareInterface) {
            throw new NextElementNotFoundException();
        }

        $resolver = $this->getResolver($xmlSymbol);
        $next = $resolver->resolve($element, $xmlSymbol);
        $element->setNextSymbol($next);
        if (!$resolver instanceof ExclusiveGatewayResolver) {
            $nextBpmnElement = null;
            if ($xmlSymbol->getFirstOutgoingUid()) {
                $flow = $this->xmlSymbolContainer->getXmlSymbolByUid($xmlSymbol->getFirstOutgoingUid());
                $nextBpmnElement = $this->xmlSymbolContainer->getXmlSymbolByUid($flow->getTargetRefUid());
            }

            if ($nextBpmnElement) {
                if ($maxSteps <= 0) {
                    throw new MaxStepsExceededException();
                }
                $this->resolve($next, $nextBpmnElement, $maxSteps - 1);
            }
        }
    }

    private function getResolver(XmlSymbol $bpmnElement): SymbolResolverInterface
    {
        $resolverClass = SymbolResolverMapping::getResolver($bpmnElement->getType());
        if (!$resolverClass || !class_exists($resolverClass)) {
            throw new ResolverNotFoundException($bpmnElement->getType());
        }

        $arguments = [];
        if ($resolverClass === ExclusiveGatewayResolver::class) {
            $arguments = [$this->xmlSymbolContainer];
        }
        $resolver = new $resolverClass(...$arguments);
        if (!$resolver instanceof SymbolResolverInterface) {
            throw new ResolverNotFoundException($bpmnElement->getType());
        }

        return $resolver;
    }
}
