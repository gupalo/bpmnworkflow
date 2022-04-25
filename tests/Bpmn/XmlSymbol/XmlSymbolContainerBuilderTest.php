<?php

namespace Bpmn\XmlSymbol;

use Gupalo\BpmnWorkflow\Bpmn\XmlSymbol\XmlSymbolContainerBuilder;
use Gupalo\BpmnWorkflow\Tests\BpmnDiagrams\TestBpmnDiagramLoader;
use PHPUnit\Framework\TestCase;

class XmlSymbolContainerBuilderTest extends TestCase
{
    public function testBuild(): void
    {
        $xml = TestBpmnDiagramLoader::xml('simplest.bpmn');
        $container = (new XmlSymbolContainerBuilder())->build($xml);

        self::assertSame('StartEvent_1', $container->getFirstStartEvent()->getUid());
        self::assertSame('EndEvent_1', $container->getEndEvents()[0]->getUid());
        self::assertCount(1, $container->getSequenceFlows());
        self::assertCount(0, $container->getTasks());
    }
}
