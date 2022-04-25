<?php

namespace Gupalo\BpmnWorkflow\Process;

use Gupalo\BpmnWorkflow\Bpmn\Converter\XmlToProcessConverter;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\Process\Process;
use Gupalo\BpmnWorkflow\Context\DataContext;
use Gupalo\BpmnWorkflow\Exception\ProcessNotFoundException;

class Workflow
{
    private const DEFAULT_MAX_ITERATIONS = 100;

    /** @var array [name => Process] */
    private array $items = [];

    /**
     * @param array $processes [name => xml_string|Process]
     */
    public function __construct(
        array $processes,
        private readonly ProcessWalker $walker
    ) {
        foreach ($processes as $name => $process) {
            if (is_string($process)) {
                $process = (new XmlToProcessConverter())->process($process);
            }

            $this->items[$name] = $process;
        }
    }

    public function walk(string $name, DataContext $context, int $maxIterations = self::DEFAULT_MAX_ITERATIONS): void
    {
        $nextProcess = $name;
        do {
            $nextProcess = $this->walkOne($nextProcess, $context);
        } while ($nextProcess !== null && --$maxIterations > 0);
    }

    public function walkOne(string $nextProcess, DataContext $context): ?string
    {
        $process = $this->getProcessByName($nextProcess);

        return $this->walker->walk($process, $context);
    }

    private function getProcessByName(string $name): Process
    {
        $process = $this->items[$name] ?? null;
        if ($process === null) {
            throw new ProcessNotFoundException($name);
        }

        return $process;
    }
}
