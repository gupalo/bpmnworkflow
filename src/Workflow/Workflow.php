<?php

namespace Gupalo\BpmWorkflow\Workflow;

use Gupalo\BpmWorkflow\Bpmn\BpmnToFlowElementConverter;
use Gupalo\BpmWorkflow\Bpmn\FlowElement\BeginElement;
use Gupalo\BpmWorkflow\Bpmn\FlowElement\EndElement;
use Gupalo\BpmWorkflow\Bpmn\FlowElement\GatewayElement;
use Gupalo\BpmWorkflow\Bpmn\FlowElement\LinkElement;
use Gupalo\BpmWorkflow\Bpmn\FlowElement\TaskElement;
use Gupalo\BpmWorkflow\Context\Context;
use Gupalo\BpmWorkflow\Gateway\GatewayContainer;
use Gupalo\BpmWorkflow\Gateway\GatewayHandler;
use Gupalo\BpmWorkflow\Task\TaskContainer;
use Gupalo\BpmWorkflow\Task\TaskHandler;
use Gupalo\BpmWorkflow\Transition\ConditionExecuteContainer;
use Gupalo\BpmWorkflow\Transition\TransitionResolver;

class Workflow
{
    private TaskHandler $taskHandler;
    private GatewayHandler $gatewayHandler;
    private TransitionResolver $transitionResolver;

    public function __construct(
        ConditionExecuteContainer $conditionExecuteContainer,
        GatewayContainer $gatewayContainer,
        TaskContainer $taskContainer,
    ) {
        $this->taskHandler = new TaskHandler($taskContainer);
        $this->gatewayHandler = new GatewayHandler($gatewayContainer);
        $this->transitionResolver = new TransitionResolver($conditionExecuteContainer);
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