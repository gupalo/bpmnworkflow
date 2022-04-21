<?php

namespace Gupalo\BpmnWorkflow\Bpmn\FlowElement;

interface NextElementAwareInterface
{
    public function getNextElement(): ElementInterface;

    public function setNextElement(ElementInterface $nextElement): void;
}
