<?php

namespace Gupalo\BpmWorkflow\Bpmn;

use Gupalo\BpmWorkflow\Bpmn\BpmnElement\BpmnElementBuilder;
use Gupalo\BpmWorkflow\Bpmn\FlowElement\Flow;
use Gupalo\BpmWorkflow\Bpmn\ElementResolver\Resolver;
use Gupalo\BpmWorkflow\Bpmn\Validator\CommonValidator;
use SimpleXMLElement;

class BpmnToFlowElementConverter
{
    public function process(string $content): ?Flow
    {
        $bpmn = $this->load($content);
        $bpmnElementContainer = (new BpmnElementBuilder())->getBpmnElements($bpmn);
        (new CommonValidator())->validate($bpmnElementContainer);
        $flow = new Flow();
        (new Resolver($bpmnElementContainer))->resolve($flow, $bpmnElementContainer->getStartEvents()[0]);
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

}
