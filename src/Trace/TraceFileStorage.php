<?php

namespace Gupalo\BpmnWorkflow\Trace;

use Gupalo\BpmnWorkflow\Context\ContextInterface;

class TraceFileStorage implements TraceStorageInterface
{
    private const TRACE_FILE_EXTENSION = 'trace';

    public function __construct(private string $dirPath)
    {
        $this->dirPath = rtrim($this->dirPath, '/') . '/';

        if (!file_exists($this->dirPath)) {
            mkdir($this->dirPath, 0777, true);
        }
    }

    public function write(Tracer $tracer, $dataBefore, $dataAfter): void
    {
        $mictotime = microtime(true);
        $filename = microtime(true) . '.' . self::TRACE_FILE_EXTENSION;
        $dateFile = (new \DateTime())->setTimestamp($mictotime);
        $data = [
            'trace' => $tracer->getUidsIndexedProcess(),
            'dataBefore' => $dataBefore,
            'dataAfter' => $dataAfter,
            'date' => $dateFile
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
                $traces[str_replace('.' . self::TRACE_FILE_EXTENSION, '', $file)] =
                    unserialize(file_get_contents($this->dirPath . $file));
            }
        }

        return $traces;
    }
}
