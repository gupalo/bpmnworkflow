<?php

namespace Gupalo\BpmnWorkflow\Workflow;

use Gupalo\BpmnWorkflow\Bpmn\BpmnToFlowElementConverter;
use Gupalo\BpmnWorkflow\Bpmn\FlowElement\BeginElement;
use Gupalo\BpmnWorkflow\Bpmn\FlowElement\EndElement;
use Gupalo\BpmnWorkflow\Bpmn\FlowElement\GatewayElement;
use Gupalo\BpmnWorkflow\Bpmn\FlowElement\LinkElement;
use Gupalo\BpmnWorkflow\Bpmn\FlowElement\TaskElement;
use Gupalo\BpmnWorkflow\Context\Context;
use Gupalo\BpmnWorkflow\Gateway\GatewayContainer;
use Gupalo\BpmnWorkflow\Gateway\GatewayHandler;
use Gupalo\BpmnWorkflow\Task\TaskContainer;
use Gupalo\BpmnWorkflow\Task\TaskHandler;
use Gupalo\BpmnWorkflow\Transition\ConditionContainer;
use Gupalo\BpmnWorkflow\Transition\TransitionResolver;

class Workflow
{
    private TaskHandler $taskHandler;
    private GatewayHandler $gatewayHandler;
    private TransitionResolver $transitionResolver;

    public function __construct(
        ConditionContainer $conditionContainer,
        GatewayContainer   $gatewayContainer,
        TaskContainer      $taskContainer,
    ) {
        $this->taskHandler = new TaskHandler($taskContainer);
        $this->gatewayHandler = new GatewayHandler($gatewayContainer);
        $this->transitionResolver = new TransitionResolver($conditionContainer);
    }

    public function walkFlow(string $xml, Context $context): Context
    {
        $flow = (new BpmnToFlowElementConverter())->process($xml);
        $currentElement = $flow->getNextElement();
        while ($currentElement) {
            if ($currentElement instanceof TaskElement) {
                $this->taskHandler->execute($currentElement, $context);
                $currentElement = $currentElement->getNextElement();
                continue;
            }

            if ($currentElement instanceof GatewayElement) {
                $gatewayResult = $this->gatewayHandler->execute($currentElement, $context);
                $transitionElements = $currentElement->getTransitions();
                foreach ($transitionElements as $transitionElement) {
                    if ($this->transitionResolver->matchTransition($gatewayResult, $transitionElement)) {
                        $currentElement = $transitionElement->getNextElement();
                        break;

                    }
                }
                $currentElement = $currentElement->getDefaultTransition()->getNextElement();
                continue;
            }

            if ($currentElement instanceof LinkElement) {
                return $currentElement->getName();
            }

            if ($currentElement instanceof EndElement) {
                return $context;
            }

            if ($currentElement instanceof BeginElement) {
                $currentElement = $currentElement->getNextElement();
            }

            if (!$currentElement) {
                return $context;
            }
        }

        return $context;
    }
}