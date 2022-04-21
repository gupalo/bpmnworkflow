<?php

namespace Gupalo\BpmnWorkflow\Tests\Workflow\Example\Task;

use Gupalo\BpmnWorkflow\Context\Context;
use Gupalo\BpmnWorkflow\Task\TaskInterface;

class withoutDiscount implements TaskInterface
{
    public function execute(array $params, Context $context): void
    {
    }
}
