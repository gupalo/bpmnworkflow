<?php

namespace Gupalo\BpmnWorkflow\Process;

use Gupalo\BpmnWorkflow\Bpmn\Converter\XmlToProcessConverter;
use Gupalo\BpmnWorkflow\Bpmn\Loader\BpmnLoaderInterface;
use Gupalo\BpmnWorkflow\Context\ContextInterface;
use Gupalo\BpmnWorkflow\Exception\ProcessMaxExecutionCountException;
use Gupalo\BpmnWorkflow\Exception\ProcessNotFoundException;
use Gupalo\BpmnWorkflow\Exception\Process\UnknownElementTypeException;
use Gupalo\BpmnWorkflow\Trace\Tracer;
use Gupalo\BpmnWorkflow\Trace\TraceStorageInterface;

class Workflow
{
    /** @var array [name => Process] */
    private array $items = [];

    private ?TraceStorageInterface $traceStorage;

    /**
     * @param BpmnLoaderInterface $bpmnLoader
     * @param ProcessWalker $walker
     * @param bool $saveTrace
     * @param TraceStorageInterface|null $traceStorage
     */
    public function __construct(
        BpmnLoaderInterface $bpmnLoader,
        private readonly ProcessWalker $walker,
        private readonly bool $saveTrace = false,
        ?TraceStorageInterface $traceStorage = null
    ) {
        $this->traceStorage = $traceStorage;
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

    /**
     * @param string $name
     * @param ContextInterface $context
     * @return void
     * @throws ProcessNotFoundException
     * @throws UnknownElementTypeException
     * @throws ProcessMaxExecutionCountException
     */
    public function walk(string $name, ContextInterface $context): void
    {
        $data = $context->getData();
        $dataBefore = is_object($data) ? clone $data : $data ;
        $tracer = $this->saveTrace ? new Tracer() : null;
        $this->walker->walk($name, $context, $tracer);
        if ($this->saveTrace && $this->traceStorage instanceof TraceStorageInterface) {
            $this->traceStorage->write($tracer, $dataBefore, $data);
        }
    }
}
