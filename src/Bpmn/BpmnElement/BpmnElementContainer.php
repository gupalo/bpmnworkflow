<?php

namespace Gupalo\BpmWorkflow\Bpmn\BpmnElement;

use RuntimeException;

class BpmnElementContainer
{
    /** @var array | BpmnElement[] */
    private array $startEvents;

    /** @var array | BpmnElement[] */
    private array $endEvents;

    /** @var array | BpmnElement[] */
    private array $exclusiveGateways;

    /** @var array | BpmnElement[] */
    private array $tasks;

    /** @var array | BpmnElement[] */
    private array $intermediateThrowEvents;

    /** @var array | BpmnElement[] */
    private array $sequenceFlows;

    public function getStartEvents(): array
    {
        return $this->startEvents;
    }
    
    public function setStartEvents(array $startEvents): void
    {
        $this->startEvents = $startEvents;
    }

    public function addStartEvent(BpmnElement $bpmnElement): void
    {
        $this->startEvents[] = $bpmnElement;
    }
    
    public function getEndEvents(): array
    {
        return $this->endEvents;
    }
    
    public function setEndEvents(array $endEvents): void
    {
        $this->endEvents = $endEvents;
    }

    public function addEndEvent(BpmnElement $bpmnElement): void
    {
        $this->endEvents[] = $bpmnElement;
    }
    
    public function getExclusiveGateways(): array
    {
        return $this->exclusiveGateways;
    }
    
    public function setExclusiveGateways(array $exclusiveGateways): void
    {
        $this->exclusiveGateways = $exclusiveGateways;
    }

    public function addExclusiveGateway(BpmnElement $bpmnElement): void
    {
        $this->exclusiveGateways[] = $bpmnElement;
    }
    
    public function getTasks(): array
    {
        return $this->tasks;
    }
    
    public function setTasks(array $tasks): void
    {
        $this->tasks = $tasks;
    }

    public function addTask(BpmnElement $bpmnElement): void
    {
        $this->tasks[] = $bpmnElement;
    }
    
    public function getIntermediateThrowEvents(): array
    {
        return $this->intermediateThrowEvents;
    }
    
    public function setIntermediateThrowEvents(array $intermediateThrowEvents): void
    {
        $this->intermediateThrowEvents = $intermediateThrowEvents;
    }

    public function addIntermediateThrowEvent(BpmnElement $bpmnElement): void
    {
        $this->intermediateThrowEvents[] = $bpmnElement;
    }

    public function getsSquenceFlows(): array
    {
        return $this->sequenceFlows;
    }

    public function setSequenceFlows(array $sequenceFlows): void
    {
        $this->sequenceFlows = $sequenceFlows;
    }

    public function addSequenceFlow(BpmnElement $bpmnElement): void
    {
        $this->sequenceFlows[] = $bpmnElement;
    }
    
    public function getElementByUid(string $uid): BpmnElement
    {
        $all = array_merge(
            $this->tasks,
            $this->startEvents,
            $this->endEvents,
            $this->exclusiveGateways,
            $this->intermediateThrowEvents,
            $this->sequenceFlows
        );
        
        foreach ($all as $element) {
            if ($element->getUid() === $uid) {
                return $element;
            }
        }
        
        // @todo
        throw new RuntimeException();
    }
}