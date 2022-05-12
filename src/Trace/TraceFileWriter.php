<?php

namespace Gupalo\BpmnWorkflow\Trace;

use Gupalo\BpmnWorkflow\Context\ContextInterface;

class TraceFileWriter implements TraceWriterInterface
{
    public function __construct(private string $dirPath)
    {
    }

    public function write(Tracer $tracer, ContextInterface $contextBefore, ContextInterface $contextAfter): void
    {
        $filename = microtime(true);
        $data = [
            'trace' => $tracer->getUidsIndexedProcess(),
            'contextBefore' => $contextBefore->getData(),
            'contextAfter' => $contextAfter->getData()
        ];
        file_put_contents(rtrim($this->dirPath, '/') . '/' . $filename, serialize($data));
    }
}
