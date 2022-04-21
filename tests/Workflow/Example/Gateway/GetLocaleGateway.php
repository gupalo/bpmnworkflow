<?php

namespace Gupalo\BpmnWorkflow\Tests\Workflow\Example\Gateway;

use Gupalo\BpmnWorkflow\Context\Context;
use Gupalo\BpmnWorkflow\Gateway\GatewayInterface;
use Gupalo\BpmnWorkflow\Tests\Workflow\Example\Cart\Cart;

class GetLocaleGateway implements GatewayInterface
{
    public function execute(array $params, Context $context): string
    {
        /** @var Cart $cart */
        $cart = $context->getData();
        
        return $cart->getLocale();
    }
}
