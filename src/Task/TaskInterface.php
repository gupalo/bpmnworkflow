<?php

namespace Gupalo\BpmWorkflow\Task;

use Gupalo\BpmWorkflow\Context\Context;

interface TaskInterface
{
    public function execute(array $params, Context $context): void;
}
