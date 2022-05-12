<?php

namespace Gupalo\BpmnWorkflow\Trace;

class Tracer
{
    private array $uidsByProcess = [];

    public function __construct()
    {
    }

    public function addUidForProcess(string $nameProcess, string $uid): void
    {
        $this->uidsByProcess[$nameProcess][] = $uid;
    }

    public function getUidsIndexedProcess(): array
    {
        return $this->uidsByProcess;
    }
}
