<?php

namespace Gupalo\BpmnWorkflow\Bpmn\XmlSymbol;

use SimpleXMLElement;

class XmlSymbolContainerBuilder
{
    public function build(SimpleXMLElement $xmlElement): XmlSymbolContainer
    {
        return new XmlSymbolContainer($this->getXmlElements($xmlElement));
    }

    /** @return XmlSymbol[] */
    private function getXmlElements(SimpleXMLElement $xmlElement): array
    {
        $elements = [];
        foreach ((array)$xmlElement->process as $items) {
            if (!is_array($items)) {
                $items = [$items];
            }
            foreach ($items as $item) {
                $elements[] = $this->getXmlSymbol($item);
            }
        }

        return $elements;
    }

    private function getXmlSymbol(SimpleXMLElement $xmlElement): XmlSymbol
    {
        $attributes = $xmlElement->attributes() ?? new SimpleXMLElement('');
        $this->getDefinition($xmlElement);

        return new XmlSymbol(
            type: $xmlElement->getName(),
            uid: (string)$attributes->id,
            data: (string)$attributes->name,
            sourceRefUid: (string)$attributes->sourceRef,
            targetRefUid: (string)$attributes->targetRef,
            defaultUid: (string)$attributes->default,
            outgoingUids: $this->getUids($xmlElement->outgoing ?? null),
            incoimngUids: $this->getUids($xmlElement->incoming ?? null),
            definition: $this->getDefinition($xmlElement)
        );
    }
    
    private function getDefinition(SimpleXMLElement $xmlElement): ?string
    {
        foreach ($xmlElement as $name => $child) {
            if (strstr(strtolower($name), 'definition')) {
                return $name;
            }
        }
        
        return null;
    }

    /**
     * @param SimpleXMLElement|SimpleXMLElement[]|null $elements
     * @return string[]
     */
    private function getUids(SimpleXMLElement|array|null $elements): array
    {
        if ($elements === null) {
            return [];
        }

        if (!is_iterable($elements)) {
            $elements = [$elements];
        }

        $uids = [];
        foreach ($elements as $element) {
            $uids[] = (string)$element;
        }

        return $uids;
    }
}
