<?php

namespace Extension;

use Gupalo\BpmnWorkflow\Extension\NamingStrategy;
use PHPUnit\Framework\TestCase;

class NamingStrategyTest extends TestCase
{
    public function testUnderscore(): void
    {
        self::assertSame('naming_strategy', NamingStrategy::underscore(NamingStrategy::class));
    }
}
