<?php

namespace Gupalo\BpmWorkflow\Transition;

use Gupalo\BpmWorkflow\Context\Context;

interface ConditionExecuteInterface
{
    public function execute(string $gatewayResult, string $condition): bool;

    public function match(string $identity): bool;
}
