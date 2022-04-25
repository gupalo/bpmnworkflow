<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Converter;

use Gupalo\BpmnWorkflow\Exception\Validation\InvalidXmlException;
use SimpleXMLElement;

class XmlLoader
{
    public function load(string $content): SimpleXMLElement
    {
        return simplexml_load_string(
            data: $content,
            class_name: SimpleXMLElement::class,
            namespace_or_prefix: $this->detectNamespace($content),
            is_prefix: true
        );
    }

    private function detectNamespace(string $content): string
    {
        $beginning = substr($content, 0, 1000);
        if (str_contains($beginning, '<bpmn2:process')) {
            return 'bpmn2';
        }
        if (str_contains($beginning, '<bpmn:process')) {
            return 'bpmn';
        }

        throw new InvalidXmlException('Cannot detect XML namespace');
    }
}
