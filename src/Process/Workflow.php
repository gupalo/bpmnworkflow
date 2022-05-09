<?php

namespace Gupalo\BpmnWorkflow\Process;

use Gupalo\BpmnWorkflow\Bpmn\Converter\XmlToProcessConverter;
use Gupalo\BpmnWorkflow\Bpmn\Loader\BpmnLoaderInterface;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\Process\Process;
use Gupalo\BpmnWorkflow\Context\ContextInterface;
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
        $processesLoaded = $bpmnLoader->load();
        foreach ($processesLoaded as $name => $process) {
            if (is_string($process)) {
                $processes = (new XmlToProcessConverter())->process($process);
                foreach ($processes as $key => $processOne) {
                    $this->items[$key === 'default' ? $name : $key] = $processOne;
                }
            } else {
                $this->items[$name] = $process;
            }
        }
    }

    public function walk(string $name, ContextInterface $context, int $maxIterations = self::DEFAULT_MAX_ITERATIONS): void
    {
        $nextProcess = $name;
        do {
            $nextProcess = $this->walkOne($nextProcess, $context);
        } while ($nextProcess !== null && --$maxIterations > 0);
    }

    public function walkOne(string $nextProcess, ContextInterface $context): ?string
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
