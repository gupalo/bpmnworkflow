<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Symbol;

trait NextSymbolTrait
{
    private SymbolInterface $nextSymbol;

    public function getNextSymbol(): SymbolInterface
    {
        return $this->nextSymbol;
    }

    public function setNextSymbol(SymbolInterface $nextSymbol): void
    {
        $this->nextSymbol = $nextSymbol;
    }
}
