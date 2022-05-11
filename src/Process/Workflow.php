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
                    $this->items[$key === 0 ? $name : $key] = $processOne;
                }
            } else {
                $this->items[$name] = $process;
            }
        }
        
        $this->walker->setAllProcess($this->items);
    }

    public function walk(string $name, ContextInterface $context): void
    {
        $this->walker->walk($name, $context);
    }
}
