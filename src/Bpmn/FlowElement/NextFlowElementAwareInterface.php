<?php

namespace Gupalo\BpmWorkflow\Bpmn\FlowElement;

interface NextFlowElementAwareInterface
{
    public function getNextElement(): FlowElementInterface;

    public function setNextElement(FlowElementInterface $nextElement): void;
}
