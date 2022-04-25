<?php

namespace Gupalo\BpmnWorkflow\Tests\Workflow;

use Gupalo\BpmnWorkflow\Context\DataContext;
use Gupalo\BpmnWorkflow\Extension\ExtensionHandler;
use Gupalo\BpmnWorkflow\Process\Workflow;
use Gupalo\BpmnWorkflow\Process\ProcessWalker;
use Gupalo\BpmnWorkflow\Tests\BpmnDiagrams\TestBpmnDiagramLoader;
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

        $this->workflow = new Workflow([
            'cart_discount' => TestBpmnDiagramLoader::xmlString('cart_discount.bpmn'),
        ], $walker);
    }

    public function testWalkFlow(): void
    {
        $cart = new Example\Cart\Cart(
            items: ['name' => 'cola', 'price' => 800],
            locale: 'en',
            price: 800,
        );
        $context = new DataContext($cart);

        $link = $this->workflow->walkOne('cart_discount', $context);

        self::assertEquals(360, $cart->getPrice());
        self::assertNull($link);
    }

    public function testWalkFlow_BigPrice(): void
    {
        $cart = new Example\Cart\Cart(
            ['name' => 'cola', 'price' => 5000],
            'en',
            5000,
        );
        $context = new DataContext($cart);
        $link = $this->workflow->walkOne('cart_discount', $context);

        self::assertEquals(2500, $cart->getPrice());
        self::assertEquals($link, 'flowBigPrice');
    }
}
