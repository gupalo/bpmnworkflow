<?php

namespace Gupalo\BpmnWorkflow\Gateway;

use Gupalo\BpmnWorkflow\Context\Context;

interface GatewayInterface
{
    public function execute(array $params, Context $context);
}
