<?php

namespace Gupalo\BpmnWorkflow\Extension;

use Gupalo\BpmnWorkflow\Bpmn\Symbol\Flow\SequenceFlow;

class ComparisonResolver
{
    public function __construct(
        private readonly ExtensionContainer $container,
    ) {
    }

    public function matchFlow($gatewayResult, SequenceFlow $sequenceFlow): bool
    {
        $condition = $sequenceFlow->getCondition();

        return $this->getCondition($condition)->execute($gatewayResult, $condition);
    }

    private function getCondition(string $condition): ComparisonInterface
    {
        return $this->container->getComparison($condition);
    }
}
