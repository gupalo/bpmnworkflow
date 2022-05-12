<?php

namespace Gupalo\BpmnWorkflow\Trace;

use Gupalo\BpmnWorkflow\Context\ContextInterface;

interface TraceStorageInterface
{
    public function write(Tracer $tracer, ContextInterface $contextBefore, ContextInterface $contextAfter): void;

    public function getTrace(?\DateTimeInterface $dateStart = null, ?\DateTimeInterface $dateEnd = null): array;
}
