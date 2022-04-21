<?php

namespace Gupalo\BpmnWorkflow\Transition;

use Gupalo\BpmnWorkflow\Context\Context;

interface ConditionInterface
{
    public function execute($gatewayResult, string $condition): bool;

    public function match(string $identity): bool;
}
