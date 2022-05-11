<?php

namespace Gupalo\BpmnWorkflow\Trace;

class Tracer
{
    private array $uidsByProcess = [];

    public function __construct(private array $process)
    {
    }

    public function addUidForProcess(string $nameProcess, string $uid): void
    {
        $this->uidsByProcess[$nameProcess][] = $uid;
    }

    public function getTrace(): array
    {
        $trace = [];
        foreach ($this->process as $name => $xml) {
            if (is_string($xml)) {
                $trace[$name] = [
                    'xml' => $xml,
                    'uids' => $this->uidsByProcess[$name]
                ];
            }
        }

        return $trace;
    }
}
