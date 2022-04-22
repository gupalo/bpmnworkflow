<?php

namespace Gupalo\BpmnWorkflow\Bpmn;

use Gupalo\BpmnWorkflow\Bpmn\BpmnElement\BpmnElementBuilder;
use Gupalo\BpmnWorkflow\Bpmn\FlowElement\Flow;
use Gupalo\BpmnWorkflow\Bpmn\ElementResolver\Resolver;
use Gupalo\BpmnWorkflow\Bpmn\Validator\FacadeValidator;
use SimpleXMLElement;

class BpmnToFlowElementConverter
{
    public function process(string $content): ?Flow
    {
        $bpmn = $this->load($content);
        $bpmnElementContainer = (new BpmnElementBuilder())->getBpmnElements($bpmn);
        (new FacadeValidator())->validate($bpmnElementContainer);
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
