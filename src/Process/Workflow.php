<?php

namespace Gupalo\BpmnWorkflow\Process;

use Gupalo\BpmnWorkflow\Bpmn\Converter\XmlToProcessConverter;
use Gupalo\BpmnWorkflow\Bpmn\Loader\BpmnLoaderInterface;
use Gupalo\BpmnWorkflow\Context\ContextInterface;
use Gupalo\BpmnWorkflow\Exception\MaxExecutionCountException;
use Gupalo\BpmnWorkflow\Exception\ProcessNotFoundException;
use Gupalo\BpmnWorkflow\Exception\Process\UnknownElementTypeException;
use Gupalo\BpmnWorkflow\Trace\Tracer;

class Workflow
{
    /** @var array [name => Process] */
    private array $items = [];

    private Tracer $tracer;

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

        $this->tracer = new Tracer($processesLoaded);
        $this->walker->setAllProcess($this->items);
    }

    /**
     * @param string $name
     * @param ContextInterface $context
     * @return void
     * @throws ProcessNotFoundException
     * @throws UnknownElementTypeException
     * @throws MaxExecutionCountException
     */
    public function walk(string $name, ContextInterface $context): void
    {
        $this->walker->walk($name, $context, $this->tracer);
    }

    public function getTracer(): Tracer
    {
        return $this->tracer;
    }
}
