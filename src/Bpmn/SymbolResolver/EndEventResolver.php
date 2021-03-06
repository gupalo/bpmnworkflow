<?php

namespace Gupalo\BpmnWorkflow\Bpmn\SymbolResolver;

use Gupalo\BpmnWorkflow\Bpmn\Symbol\Event\EndEvent;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\SymbolInterface;
use Gupalo\BpmnWorkflow\Bpmn\XmlSymbol\XmlSymbol;
use JetBrains\PhpStorm\Pure;

class EndEventResolver implements SymbolResolverInterface
{
    #[Pure]
    public function resolve(SymbolInterface $symbol, XmlSymbol $xmlSymbol): SymbolInterface
    {
        return (new EndEvent($xmlSymbol->getDefinition() === 'terminateEventDefinition'))
            ->setUid($xmlSymbol->getUid());
    }
}
