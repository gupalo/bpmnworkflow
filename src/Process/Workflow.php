<?php

namespace Gupalo\BpmnWorkflow\Process;

use Gupalo\BpmnWorkflow\Bpmn\Converter\XmlToProcessConverter;
use Gupalo\BpmnWorkflow\Bpmn\Loader\BpmnLoaderInterface;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\Process\Process;
use Gupalo\BpmnWorkflow\Context\DataContext;
use Gupalo\BpmnWorkflow\Exception\ProcessNotFoundException;

class Workflow
{
    private const DEFAULT_MAX_ITERATIONS = 100;

    /** @var array [name => Process] */
    private array $items = [];

    /**
     * @param BpmnLoaderInterface $bpmnLoader
     * @param ProcessWalker $walker
     */
    public function __construct(
        BpmnLoaderInterface $bpmnLoader,
        private readonly ProcessWalker $walker
    ) {
        $processes = $bpmnLoader->load();
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
