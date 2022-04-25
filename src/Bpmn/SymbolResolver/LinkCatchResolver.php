<?php

namespace Gupalo\BpmnWorkflow\Bpmn\SymbolResolver;

use Gupalo\BpmnWorkflow\Bpmn\Symbol\Event\LinkCatch;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\SymbolInterface;
use Gupalo\BpmnWorkflow\Bpmn\XmlSymbol\XmlSymbol;
use JetBrains\PhpStorm\Pure;

class LinkCatchResolver implements SymbolResolverInterface
{
    #[Pure]
    public function resolve(SymbolInterface $symbol, XmlSymbol $xmlSymbol): SymbolInterface
    {
        return new LinkCatch($xmlSymbol->getData());
    }
}
