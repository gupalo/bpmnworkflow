<?php

namespace Gupalo\BpmnWorkflow\Tests\Workflow;

use Gupalo\BpmnWorkflow\Context\Context;
use Gupalo\BpmnWorkflow\Gateway\GatewayContainer;
use Gupalo\BpmnWorkflow\Task\TaskContainer;
use Gupalo\BpmnWorkflow\Tests\Workflow\Example\Gateway\GetLocaleGateway;
use Gupalo\BpmnWorkflow\Tests\Workflow\Example\Gateway\GetPriceGateway;
use Gupalo\BpmnWorkflow\Tests\Workflow\Example\Task\DiscountTask;
use Gupalo\BpmnWorkflow\Tests\Workflow\Example\Task\WithoutDiscount;
use Gupalo\BpmnWorkflow\Tests\Workflow\Example\Transition\EqValueCondition;
use Gupalo\BpmnWorkflow\Tests\Workflow\Example\Transition\LessValueCondition;
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
        $conditionContainer->addCondition(new LessValueCondition());
        $conditionContainer->addCondition(new MoreValueCondition());

        $taskContainer = new TaskContainer();
        $taskContainer->addTask('discount', new DiscountTask());
        $taskContainer->addTask('withoutDiscount', new WithoutDiscount());

        $gatewayContainer = new GatewayContainer();
        $gatewayContainer->addGateway('getPrice', new GetPriceGateway());
        $gatewayContainer->addGateway('getUserLocale', new GetLocaleGateway());

        $cart = new Example\Cart\Cart(
            ['name' => 'cola', 'price' => 800],
            'en',
            800,
            0
        );

        $context = new Context($cart);

        $workflow = new Workflow($conditionContainer, $gatewayContainer, $taskContainer);
        $link = $workflow->walkFlow(file_get_contents(__DIR__ . '/../bpmnDiagrams/cartDiscount.bpmn'), $context);

        self::assertEquals(360, $cart->getPrice());
        self::assertNull($link);

        $cart = new Example\Cart\Cart(
            ['name' => 'cola', 'price' => 5000],
            'en',
            5000,
            0
        );
        $context = new Context($cart);
        $link = $workflow->walkFlow(file_get_contents(__DIR__ . '/../bpmnDiagrams/cartDiscount.bpmn'), $context);

        self::assertEquals(2500, $cart->getPrice());
        self::assertEquals($link, 'flowBigPrice');
    }
}
