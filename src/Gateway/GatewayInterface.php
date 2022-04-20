<?php

namespace Gupalo\BpmWorkflow\Gateway;

use Gupalo\BpmWorkflow\Context\Context;

interface GatewayInterface
{
    public function execute(array $params, Context $context): string;
}
