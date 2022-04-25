<?php

namespace Gupalo\BpmnWorkflow\Tests\BpmnDiagrams;

use Gupalo\BpmnWorkflow\Bpmn\Converter\XmlLoader;
use SimpleXMLElement;

class TestBpmnDiagramLoader
{
    public static function filename(string $basename): string
    {
        return __DIR__ . '/' . $basename;
    }

    public static function xmlString(string $basename): string
    {
        return file_get_contents(self::filename($basename));
    }

    public static function xml(string $basename): SimpleXMLElement
    {
        return (new XmlLoader())->load(self::xmlString($basename));
    }
}
