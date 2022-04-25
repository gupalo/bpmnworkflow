<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Symbol;

interface NextSymbolAwareInterface
{
    public function getNextSymbol(): SymbolInterface;

    public function setNextSymbol(SymbolInterface $nextSymbol): void;
}
