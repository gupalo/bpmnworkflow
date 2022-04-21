<?php

namespace Gupalo\BpmnWorkflow\Tests\Workflow\Example\Task;

use Gupalo\BpmnWorkflow\Context\Context;
use Gupalo\BpmnWorkflow\Task\TaskInterface;
use Gupalo\BpmnWorkflow\Tests\Workflow\Example\Cart\Cart;

class DiscountTask implements TaskInterface
{
    public function execute(array $params, Context $context): void
    {
        /** @var Cart $cart */
        $cart = $context->getData();
        
        $cart->setPrice($cart->getPrice()*((100-$params[0])/100));
    }
}
