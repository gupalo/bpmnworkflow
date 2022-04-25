<?php

namespace Gupalo\BpmnWorkflow\Extension;

use Gupalo\BpmnWorkflow\Context\ContextInterface;

interface FunctionInterface
{
    public function execute(array $params, ContextInterface $context);
}
