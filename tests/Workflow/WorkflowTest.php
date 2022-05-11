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
    private ProcessWalker $walker;

    protected function setUp(): void
    {
        $this->walker = new ProcessWalker(new ExtensionHandler([
            new DiscountProcedure(),
            new WithoutDiscountProcedure(),

            new PriceFunction(),
            new LocaleFunction(),

            new EqValueComparison(),
            new LessValueComparison(),
            new MoreValueComparison(),
        ]));
    }

    public function testWalkFlow(): void
    {
        $workflow = new Workflow((new BpmnDirLoader(__DIR__ . '/../BpmnDiagrams')), $this->walker);
        $cart = new Example\Cart\Cart(
            items: ['name' => 'cola', 'price' => 800],
            locale: 'en',
            price: 800,
        );
        $context = new DataContext($cart);

        $workflow->walk('cart_discount', $context);

        self::assertEquals(360, $cart->getPrice());
    }

    public function testWalkFlow_BigPrice(): void
    {
        $workflow = new Workflow((new BpmnDirLoader(__DIR__ . '/../BpmnDiagrams')), $this->walker);
        $cart = new Example\Cart\Cart(
            ['name' => 'cola', 'price' => 5000],
            'en',
            5000,
        );
        $context = new DataContext($cart);
        $workflow->walk('cart_discount', $context);

        self::assertEquals(2000, $cart->getPrice());
    }

    public function testWalkFlow_BigPriceGoTo(): void
    {
        $workflow = new Workflow((new BpmnDirLoader(__DIR__ . '/../BpmnDiagramsGoto')), $this->walker);
        $cart = new Example\Cart\Cart(
            ['name' => 'cola', 'price' => 5000],
            'en',
            5000,
        );
        $context = new DataContext($cart);
        $workflow->walk('goto', $context);

        self::assertEquals(1250, $cart->getPrice());
    }

    public function testWalkFlow_BigPriceCallActivity(): void
    {
        $workflow = new Workflow((new BpmnDirLoader(__DIR__ . '/../BpmnDiagramsCallActivity')), $this->walker);
        $cart = new Example\Cart\Cart(
            ['name' => 'cola', 'price' => 5000],
            'en',
            5000,
        );
        $context = new DataContext($cart);
        $workflow->walk('call_activity', $context);

        self::assertEquals(1125, $cart->getPrice());
    }

    public function testWalkFlow_BigPriceCallActivityDie(): void
    {
        $workflow = new Workflow((new BpmnDirLoader(__DIR__ . '/../BpmnDiagramsCallActivityDie')), $this->walker);
        $cart = new Example\Cart\Cart(
            ['name' => 'cola', 'price' => 5000],
            'en',
            5000,
        );
        $context = new DataContext($cart);
        $workflow->walk('call_activity', $context);

        self::assertEquals(2500, $cart->getPrice());
    }
}
