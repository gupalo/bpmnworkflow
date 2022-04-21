<?php

namespace Gupalo\BpmnWorkflow\Bpmn\BpmnElement;

use SimpleXMLElement;

class BpmnElementBuilder
{
    public function getBpmnElements(SimpleXMLElement $bpmn): BpmnElementContainer
    {
        $bpmnElementContainer = new BpmnElementContainer();
        $elements = (array)$bpmn->process;
        foreach ($elements as $type => $element) {
            if ($element instanceof SimpleXMLElement) {
                if ($element->getName() === 'process') {
                    continue;
                }
                $bpmnItem = $this->getOneBpmnItem($element);
                $bpmnElementContainer->{'add' . ucfirst($type)}($bpmnItem);
            }
            if (is_array($element)) {
                foreach ($element as $item) {
                    $bpmnItem = $this->getOneBpmnItem($item);
                    $bpmnElementContainer->{'add' . ucfirst($bpmnItem->getType())}($bpmnItem);
                }
            }
        }

        return $bpmnElementContainer;
    }

    private function getOneBpmnItem(SimpleXMLElement $element): BpmnElement
    {
        $incoming = $element->incoming;
        $outgoings = $element->outgoing;
        $outgoingElements = [];
        if (count($outgoings) > 1) {
            foreach ($outgoings as $outgoing) {
                $outgoingElements[] = (string)$outgoing;
            }
        }
        if (count($outgoings) === 1) {
            $outgoingElements[] = (string)$outgoings;
        }

        return new BpmnElement(
            $element->getName(),
            (string)$element->attributes()->id,
            (string)$element->attributes()->name,
            (string)$element->attributes()->sourceRef,
            (string)$element->attributes()->targetRef,
            (string)$element->attributes()->default,
            $outgoingElements,
            $incoming ? (string)$incoming : null,
        );
    }
}
