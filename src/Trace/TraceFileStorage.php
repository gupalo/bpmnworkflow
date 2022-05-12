<?php

namespace Gupalo\BpmnWorkflow\Trace;

use Gupalo\BpmnWorkflow\Context\ContextInterface;

class TraceFileStorage implements TraceStorageInterface
{
    private const TRACE_FILE_EXTENSION = 'trace';

    public function __construct(private string $dirPath)
    {
        $this->dirPath = rtrim($this->dirPath, '/') . '/';
    }

    public function write(Tracer $tracer, ContextInterface $contextBefore, ContextInterface $contextAfter): void
    {
        $filename = microtime(true) . '.' . self::TRACE_FILE_EXTENSION;
        $data = [
            'trace' => $tracer->getUidsIndexedProcess(),
            'contextBefore' => $contextBefore->getData(),
            'contextAfter' => $contextAfter->getData()
        ];
        file_put_contents($this->dirPath . $filename, serialize($data));
    }

    public function getTrace(?\DateTimeInterface $dateStart = null, ?\DateTimeInterface $dateEnd = null): array
    {
        $traces = [];
        $files = scandir($this->dirPath);
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..' && str_ends_with($file, '.' . self::TRACE_FILE_EXTENSION)) {
                $dateFile = (new \DateTime())
                    ->setTimestamp((int)str_replace('.' . self::TRACE_FILE_EXTENSION, '', $file));
                if ($dateStart && $dateStart > $dateFile) {
                    continue;
                }
                if ($dateEnd && $dateEnd < $dateFile) {
                    continue;
                }
                $traces[] = unserialize(file_get_contents($this->dirPath . $file));
            }
        }

        return $traces;
    }
}
