<?php

namespace Gupalo\BpmnWorkflow\Tests\Workflow\Example\Extensions\Procedure;

use Gupalo\BpmnWorkflow\Context\ContextInterface;
use Gupalo\BpmnWorkflow\Extension\ProcedureInterface;

class WithoutDiscountProcedure implements ProcedureInterface
{
    public function execute(array $params, ContextInterface $context): void
    {
    }
}
