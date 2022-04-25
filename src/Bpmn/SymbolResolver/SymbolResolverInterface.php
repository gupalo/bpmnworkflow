<?php

namespace Gupalo\BpmnWorkflow\Bpmn\SymbolResolver;

use Gupalo\BpmnWorkflow\Bpmn\XmlSymbol\XmlSymbol;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\SymbolInterface;

interface SymbolResolverInterface
{
    public function resolve(SymbolInterface $symbol, XmlSymbol $xmlSymbol): SymbolInterface;
}
