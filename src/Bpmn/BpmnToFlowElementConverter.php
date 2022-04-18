<?php

namespace Gupalo\BpmWorkflow\Bpmn;

use Gupalo\BpmWorkflow\Bpmn\FlowElement\Flow;
use JetBrains\PhpStorm\ArrayShape;
use Gupalo\BpmWorkflow\Bpmn\FlowElement\BeginFlowElement;
use Gupalo\BpmWorkflow\Bpmn\ElementResolver\Resolver;
use Gupalo\BpmWorkflow\Bpmn\Validator\CommonValidator;
use SimpleXMLElement;

class BpmnToFlowElementConverter
{
    public function process(string $content): ?Flow
    {
        $bpmn = $this->load($content);
        $allElements = $this->groupByType($bpmn);
        if (!$allElements) {
            return null;
        }
        $this->validate($allElements);
        $flow = new Flow();
        (new Resolver())->resolve($flow, array_shift($allElements['startEvent']), $allElements);

        return $flow;
    }

    private function load(string $content): SimpleXMLElement
    {
        return simplexml_load_string(
            $content,
            SimpleXMLElement::class,
            0,
            'bpmn2',
            true
        );
    }

    private function groupByType(SimpleXMLElement $bpmn): array
    {
        $result = [];
        $elements = (array)$bpmn->process;
        foreach ($elements as $type => $element) {
            if ($element instanceof SimpleXMLElement) {
                if ($element->getName() === 'process') {
                    continue;
                }
                $itemArray = $this->getOneBpmnItem($element);
                $result[$type][$itemArray['uid']] = $itemArray;
            }
            if (is_array($element)) {
                foreach ($element as $item) {
                    $itemArray = $this->getOneBpmnItem($item);
                    $result[$itemArray['type']][$itemArray['uid']] = $itemArray;
                }
            }
        }

        return $result;
    }

    private function validate(array $allElements): void
    {
        (new CommonValidator())->validate($allElements);
    }

    #[ArrayShape([
        'type' => "string",
        'uid' => "string",
        'data' => "string",
        'sourceRef' => "string",
        'targetRef' => "string",
        'default' => "string",
        'outgoings' => "array",
        'incoming' => "null|string"
    ])]
    private function getOneBpmnItem(SimpleXMLElement $element): array
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

        return [
            'type' => $element->getName(),
            'uid' => (string)$element->attributes()->id,
            'data' => (string)$element->attributes()->name,
            'sourceRef' => (string)$element->attributes()->sourceRef,
            'targetRef' => (string)$element->attributes()->targetRef,
            'default' => (string)$element->attributes()->default,
            'outgoings' => $outgoingElements,
            'incoming' => $incoming ? (string)$incoming : null
        ];
    }
}
