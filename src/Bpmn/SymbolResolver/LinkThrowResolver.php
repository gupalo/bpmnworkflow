<?php

namespace Gupalo\BpmnWorkflow\Bpmn\SymbolResolver;

use Gupalo\BpmnWorkflow\Bpmn\Symbol\Event\LinkThrow;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\SymbolInterface;
use Gupalo\BpmnWorkflow\Bpmn\XmlSymbol\XmlSymbol;
use JetBrains\PhpStorm\Pure;

class LinkThrowResolver implements SymbolResolverInterface
{
    #[Pure]
    public function resolve(SymbolInterface $symbol, XmlSymbol $xmlSymbol): SymbolInterface
    {
        return (new LinkThrow($xmlSymbol->getData()))->setUid($xmlSymbol->getUid());
    }
}
