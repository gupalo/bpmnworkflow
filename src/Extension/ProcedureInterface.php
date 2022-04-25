<?php

namespace Gupalo\BpmnWorkflow\Extension;

use Gupalo\BpmnWorkflow\Context\ContextInterface;

interface ProcedureInterface
{
    public function execute(array $params, ContextInterface $context): void;
}
