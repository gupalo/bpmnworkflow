<?php

namespace Gupalo\BpmnWorkflow\Tests\Workflow\Example\Transition;

use Gupalo\BpmnWorkflow\Transition\ConditionInterface;

class LessValueCondition implements ConditionInterface
{
    public function execute($gatewayResult, string $condition): bool
    {
        $identity = trim($condition);
        $valueMore = str_replace('<', '', $identity);

        if ((float)$gatewayResult < (float)$valueMore) {
            return true;
        }

        return false;
    }

    public function match(string $identity): bool
    {
        $identity = trim($identity);
        if ($identity[0] === '<') {
            return true;
        }

        return false;
    }
}
