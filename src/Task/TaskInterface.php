<?php

namespace Gupalo\BpmnWorkflow\Task;

use Gupalo\BpmnWorkflow\Context\Context;

interface TaskInterface
{
    public function execute(array $params, Context $context): void;
}
