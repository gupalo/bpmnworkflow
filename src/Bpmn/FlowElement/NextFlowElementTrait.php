<?php

namespace Gupalo\BpmWorkflow\Bpmn\FlowElement;

trait NextFlowElementTrait
{
    private FlowElementInterface $nextElement;

    public function getNextElement(): FlowElementInterface
    {
        return $this->nextElement;
    }

    public function setNextElement(FlowElementInterface $nextElement): void
    {
        $this->nextElement = $nextElement;
    }
}
