<?php

namespace Gupalo\BpmnWorkflow\Transition;

use Gupalo\BpmnWorkflow\Bpmn\FlowElement\GatewayTransitionElement;

class TransitionResolver
{
    public function __construct(private ConditionContainer $conditionContainer)
    {
    }

    public function matchTransition($gatewayResult, GatewayTransitionElement $gatewayTransitionElement): bool
    {
        $execute = $this->getCondition($gatewayTransitionElement->getCondition());

        return $execute->execute($gatewayResult, $gatewayTransitionElement->getCondition());
    }

    private function getCondition(string $condition): ConditionInterface
    {
        return $this->conditionContainer->getCondition($condition);
    }
}