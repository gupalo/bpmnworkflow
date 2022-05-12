<?php

namespace Gupalo\BpmnWorkflow\Process;

use Gupalo\BpmnWorkflow\Bpmn\Symbol\Activity\CallActivity;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\Activity\Task;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\Event\EndEvent;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\Event\LinkCatch;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\Event\LinkThrow;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\Event\StartEvent;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\Gateway\ExclusiveGateway;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\Process\Process;
use Gupalo\BpmnWorkflow\Context\ContextInterface;
use Gupalo\BpmnWorkflow\Exception\ProcessMaxExecutionCountException;
use Gupalo\BpmnWorkflow\Exception\Process\UnknownElementTypeException;
use Gupalo\BpmnWorkflow\Exception\ProcessNotFoundException;
use Gupalo\BpmnWorkflow\Extension\ExtensionHandler;
use Gupalo\BpmnWorkflow\Trace\Tracer;

class ProcessWalker
{
    private const MAX_PROCESS_EXECUTE = 100;

    private array $allProcess = [];

    private static int $countProcess = 0;

    public function __construct(
        private readonly ExtensionHandler $handler,
    ) {
    }

    /**
     * @param string $processName
     * @param ContextInterface $context
     * @param Tracer|null $tracer
     * @return EndEvent|null
     * @throws ProcessNotFoundException
     * @throws UnknownElementTypeException
     * @throws ProcessMaxExecutionCountException
     */
    public function walk(string $processName, ContextInterface $context, ?Tracer $tracer = null): ?EndEvent
    {
        self::$countProcess++;
        if (self::$countProcess > self::MAX_PROCESS_EXECUTE) {
            throw new ProcessMaxExecutionCountException();
        }
        $process = $this->getProcess($processName);
        $currentElement = $process->getNextSymbol();
        while ($currentElement) {
            if ($tracer instanceof Tracer) {
                $tracer->addUidForProcess($processName, $currentElement->getUid());
            }
            if ($currentElement instanceof StartEvent) {
                $currentElement = $currentElement->getNextSymbol();
            } elseif ($currentElement instanceof LinkCatch) {
                $currentElement = $currentElement->getNextSymbol();
            } elseif ($currentElement instanceof CallActivity) {
                $end = $this->walk($currentElement->getName(), $context, $tracer);

                if ($end instanceof EndEvent && $end->isDie()) {
                    return null;
                }
                $currentElement = $currentElement->getNextSymbol();
            } elseif ($currentElement instanceof Task) {
                $this->handler->executeProcedure($currentElement, $context);
                $currentElement = $currentElement->getNextSymbol();
            } elseif ($currentElement instanceof ExclusiveGateway) {
                $gatewayResult = $this->handler->executeFunction($currentElement, $context);
                $transitionElements = $currentElement->getFlows();
                $currentElement = $currentElement->getDefaultFlow()?->getNextSymbol();
                foreach ($transitionElements as $transitionElement) {
                    if ($this->handler->matchFlow($gatewayResult, $transitionElement)) {
                        $currentElement = $transitionElement->getNextSymbol();
                        break;
                    }
                }
            } elseif ($currentElement instanceof LinkThrow) {
                $this->walk($currentElement->getName(), $context, $tracer);

                return null;
            } elseif ($currentElement instanceof EndEvent) {
                return $currentElement;
            } else {
                throw new UnknownElementTypeException(get_class($currentElement));
            }
        }

        return null;
    }

    public function getProcess(string $name): Process
    {
        if (!isset($this->allProcess[$name])) {
            throw new ProcessNotFoundException($name);
        }

        return $this->allProcess[$name];
    }

    public function setAllProcess(array $allProcess): void
    {
        $this->allProcess = $allProcess;
    }
}
