<?php

namespace Gupalo\BpmnWorkflow\Bpmn\SymbolResolver;

use Gupalo\BpmnWorkflow\Bpmn\Symbol\Event\StartEvent;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\SymbolInterface;
use Gupalo\BpmnWorkflow\Bpmn\XmlSymbol\XmlSymbol;
use JetBrains\PhpStorm\Pure;

class StartEventResolver implements SymbolResolverInterface
{
    #[Pure]
    public function resolve(SymbolInterface $symbol, XmlSymbol $xmlSymbol): SymbolInterface
    {
        return (new StartEvent())->setUid($xmlSymbol->getUid());
    }
}
