<?php

namespace Gupalo\BpmWorkflow\Transition;

use Gupalo\BpmWorkflow\Bpmn\FlowElement\GatewayTransitionElement;

class TransitionResolver
{
    public function __construct(private ConditionExecuteContainer $conditionExecuteContainer)
    {
    }

    public function matchTransition(string $gatewayResult, GatewayTransitionElement $gatewayTransitionElement): bool
    {
        $execute = $this->getConditionExecute($gatewayTransitionElement->getCondition());

        return $execute->execute($gatewayResult, $gatewayTransitionElement->getCondition());
    }

    private function getConditionExecute(string $condition): ConditionExecuteInterface
    {
        return $this->conditionExecuteContainer->getConditionExecute($condition);
    }
}