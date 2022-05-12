<?php

namespace Gupalo\BpmnWorkflow\Trace;

use Gupalo\BpmnWorkflow\Context\ContextInterface;

interface TraceWriterInterface
{
    public function write(Tracer $tracer, ContextInterface $contextBefore, ContextInterface $contextAfter): void;
}
