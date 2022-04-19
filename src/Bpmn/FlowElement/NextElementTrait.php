<?php

namespace Gupalo\BpmWorkflow\Bpmn\FlowElement;

trait NextElementTrait
{
    private ElementInterface $nextElement;

    public function getNextElement(): ElementInterface
    {
        return $this->nextElement;
    }

    public function setNextElement(ElementInterface $nextElement): void
    {
        $this->nextElement = $nextElement;
    }
}
