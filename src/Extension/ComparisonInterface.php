<?php

namespace Gupalo\BpmnWorkflow\Extension;

interface ComparisonInterface
{
    public function execute($gatewayResult, string $condition): bool;

    public function match(string $name): bool;
}
