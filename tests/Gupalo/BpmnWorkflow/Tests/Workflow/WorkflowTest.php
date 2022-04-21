<?php

namespace Gupalo\BpmnWorkflow\Tests\Workflow;

use Gupalo\BpmnWorkflow\Context\Context;
use Gupalo\BpmnWorkflow\Gateway\GatewayContainer;
use Gupalo\BpmnWorkflow\Task\TaskContainer;
use Gupalo\BpmnWorkflow\Tests\Workflow\Example\Gateway\GetPriceGateway;
use Gupalo\BpmnWorkflow\Tests\Workflow\Example\Task\DiscountTask;
use Gupalo\BpmnWorkflow\Tests\Workflow\Example\Task\withoutDiscount;
use Gupalo\BpmnWorkflow\Tests\Workflow\Example\Transition\EqValueCondition;
use Gupalo\BpmnWorkflow\Tests\Workflow\Example\Transition\MoreValueCondition;
use Gupalo\BpmnWorkflow\Transition\ConditionContainer;
use Gupalo\BpmnWorkflow\Workflow\Workflow;
use PHPUnit\Framework\TestCase;

class WorkflowTest extends TestCase
{
    public function testWalkFlow(): void
    {
        $conditionContainer = new ConditionContainer();
        $conditionContainer->addCondition(new EqValueCondition());
        $conditionContainer->addCondition(new MoreValueCondition());

        $taskContainer = new TaskContainer();
        $taskContainer->addTask('discount', new DiscountTask());
        $taskContainer->addTask('withoutDiscount', new withoutDiscount());

        $gatewayContainer = new GatewayContainer();
        $gatewayContainer->addGateway('getPrice', new GetPriceGateway());
        $gatewayContainer->addGateway('getUserLocale', new GetPriceGateway());

        $cart = new Example\Cart\Cart(
            ['name' => 'cola', 'price' => 9876],
            'en',
            9876,
            0
        );

        $context = new Context($cart);

        $workflow = new Workflow($conditionContainer, $gatewayContainer, $taskContainer);
        $workflow->walkFlow(file_get_contents(__DIR__ . '/../BpmnDiagrams/cartDiscount.Bpmn'), $context);
    }
}
