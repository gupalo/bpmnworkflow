<?php

namespace Gupalo\BpmnWorkflow\Bpmn\ElementResolver;

use Gupalo\BpmnWorkflow\Bpmn\BpmnElement\BpmnElement;
use JetBrains\PhpStorm\Pure;
use Gupalo\BpmnWorkflow\Bpmn\FlowElement\ElementInterface;
use Gupalo\BpmnWorkflow\Bpmn\FlowElement\EndElement;

class EndElementResolver implements ElementResolverInterface
{
    #[Pure]
    public function resolve(ElementInterface $element, BpmnElement $bpmnElement): ElementInterface
    {
        return new EndElement();
    }
}
