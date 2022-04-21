<?php

namespace Gupalo\BpmnWorkflow\Tests\Workflow\Example\Transition;

use Gupalo\BpmnWorkflow\Transition\ConditionInterface;

class EqValueCondition implements ConditionInterface
{
    public function execute($gatewayResult, string $condition): bool
    {
        $identity = trim($condition);
        $valueEqual = str_replace('=', '', $identity);
        
        if ((string)$valueEqual == (string)$gatewayResult) {
            return true;
        }
        
        return false;
    }

    public function match(string $identity): bool
    {
        $identity = trim($identity);
        if ($identity[0] === '=') {
            return true;
        }
        
        return false;
    }
}
