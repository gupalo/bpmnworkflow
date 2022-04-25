<?php

namespace Gupalo\BpmnWorkflow\Bpmn\SymbolResolver;

use Gupalo\BpmnWorkflow\Bpmn\Symbol\Flow\SequenceFlow;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\Gateway\ExclusiveGateway;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\NextSymbolAwareInterface;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\SymbolInterface;
use Gupalo\BpmnWorkflow\Bpmn\XmlSymbol\XmlSymbol;
use Gupalo\BpmnWorkflow\Bpmn\XmlSymbol\XmlSymbolContainer;
use Gupalo\BpmnWorkflow\Exception\Process\NextElementNotFoundException;

class ExclusiveGatewayResolver implements SymbolResolverInterface
{
    public function __construct(
        private readonly XmlSymbolContainer $container,
    ) {
    }

    public function resolve(SymbolInterface $symbol, XmlSymbol $xmlSymbol): SymbolInterface
    {
        if (!$symbol instanceof NextSymbolAwareInterface) {
            throw new NextElementNotFoundException();
        }
        $gateway = new ExclusiveGateway($xmlSymbol->getData());
        $flows = [];
        foreach ($xmlSymbol->getOutgoingUids() as $outgoing) {
            $outgoingXmlSymbol = $this->container->getXmlSymbolByUid($outgoing);
            $isDefault = ($xmlSymbol->getDefaultUid() === $outgoing);

            $flow = new SequenceFlow($isDefault, $outgoingXmlSymbol->getData());
            $flows[] = $flow;

            $nextXmlSymbol = $this->container->getXmlSymbolByUid($outgoingXmlSymbol->getTargetRefUid());

            (new Resolver($this->container))->resolve($flow, $nextXmlSymbol);
        }

        $gateway->setFlows($flows);
        $symbol->setNextSymbol($gateway);

        return $gateway;
    }
}
