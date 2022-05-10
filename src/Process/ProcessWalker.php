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
use Gupalo\BpmnWorkflow\Exception\Process\UnknownElementTypeException;
use Gupalo\BpmnWorkflow\Exception\ProcessNotFoundException;
use Gupalo\BpmnWorkflow\Extension\ExtensionHandler;

class ProcessWalker
{
    private array $allProcess = [];

    public function __construct(
        private readonly ExtensionHandler $handler,
    ) {
    }

    /**
     * @return string|null String if there is finished linking to another workflow
     */
    public function walk(Process $process, ContextInterface $context): ?string
    {
        $currentElement = $process->getNextSymbol();
        while ($currentElement) {
            if ($currentElement instanceof StartEvent) {
                $currentElement = $currentElement->getNextSymbol();
            } elseif ($currentElement instanceof LinkCatch) {
                $currentElement = $currentElement->getNextSymbol();
            } elseif ($currentElement instanceof CallActivity) {
                $subProcess = $this->getProcess($currentElement->getName());
                $this->walk($subProcess, $context);
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
                return $currentElement->getName();
            } elseif ($currentElement instanceof EndEvent) {
                return null;
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
