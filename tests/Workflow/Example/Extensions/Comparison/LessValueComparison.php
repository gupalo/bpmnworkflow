<?php

namespace Gupalo\BpmnWorkflow\Tests\Workflow\Example\Extensions\Comparison;

use Gupalo\BpmnWorkflow\Extension\ComparisonInterface;

class LessValueComparison implements ComparisonInterface
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
