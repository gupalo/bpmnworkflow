<?php

namespace Gupalo\BpmnWorkflow\Trace;

use Gupalo\BpmnWorkflow\Context\ContextInterface;

class TraceFileWriter implements TraceWriterInterface
{
    public function __construct(private string $dirPath)
    {
    }

    public function write(Tracer $tracer, ContextInterface $context): void
    {
        $filename = microtime(true);
        $data = ['trace' => $tracer->getUidsIndexedProcess(), 'context' => $context];
        file_put_contents(rtrim($this->dirPath, '/') . '/' . $filename, json_encode($data));
    }
}
