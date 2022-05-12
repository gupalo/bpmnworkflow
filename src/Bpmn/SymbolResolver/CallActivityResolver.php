<?php

namespace Gupalo\BpmnWorkflow\Bpmn\SymbolResolver;

use Gupalo\BpmnWorkflow\Bpmn\Symbol\Activity\CallActivity;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\SymbolInterface;
use Gupalo\BpmnWorkflow\Bpmn\XmlSymbol\XmlSymbol;
use JetBrains\PhpStorm\Pure;

class CallActivityResolver implements SymbolResolverInterface
{
    #[Pure]
    public function resolve(SymbolInterface $symbol, XmlSymbol $xmlSymbol): SymbolInterface
    {
        return (new CallActivity($xmlSymbol->getData()))->setUid($xmlSymbol->getUid());
    }
}
