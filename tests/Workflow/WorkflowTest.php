<?php

namespace Gupalo\BpmnWorkflow\Tests\Workflow;

use Gupalo\BpmnWorkflow\Bpmn\Loader\BpmnDirLoader;
use Gupalo\BpmnWorkflow\Context\DataContext;
use Gupalo\BpmnWorkflow\Extension\ExtensionHandler;
use Gupalo\BpmnWorkflow\Process\Workflow;
use Gupalo\BpmnWorkflow\Process\ProcessWalker;
use Gupalo\BpmnWorkflow\Tests\Workflow\Example\Extensions\Comparison\EqValueComparison;
use Gupalo\BpmnWorkflow\Tests\Workflow\Example\Extensions\Comparison\LessValueComparison;
use Gupalo\BpmnWorkflow\Tests\Workflow\Example\Extensions\Comparison\MoreValueComparison;
use Gupalo\BpmnWorkflow\Tests\Workflow\Example\Extensions\Functions\LocaleFunction;
use Gupalo\BpmnWorkflow\Tests\Workflow\Example\Extensions\Functions\PriceFunction;
use Gupalo\BpmnWorkflow\Tests\Workflow\Example\Extensions\Procedure\DiscountProcedure;
use Gupalo\BpmnWorkflow\Tests\Workflow\Example\Extensions\Procedure\WithoutDiscountProcedure;
use PHPUnit\Framework\TestCase;

class WorkflowTest extends TestCase
{
    private Workflow $workflow;

    protected function setUp(): void
    {
        $walker = new ProcessWalker(new ExtensionHandler([
            new DiscountProcedure(),
            new WithoutDiscountProcedure(),

            new PriceFunction(),
            new LocaleFunction(),

            new EqValueComparison(),
            new LessValueComparison(),
            new MoreValueComparison(),
        ]));

        $this->workflow = new Workflow((new BpmnDirLoader(__DIR__ . '/../BpmnDiagrams')), $walker);
    }

    public function testWalkFlow(): void
    {
        $cart = new Example\Cart\Cart(
            items: ['name' => 'cola', 'price' => 800],
            locale: 'en',
            price: 800,
        );
        $context = new DataContext($cart);

        $this->workflow->walk('cart_discount', $context);

        self::assertEquals(360, $cart->getPrice());
    }

    public function testWalkFlow_BigPrice(): void
    {
        $cart = new Example\Cart\Cart(
            ['name' => 'cola', 'price' => 5000],
            'en',
            5000,
        );
        $context = new DataContext($cart);
        $this->workflow->walk('cart_discount', $context);

        self::assertEquals(2000, $cart->getPrice());
    }
}
