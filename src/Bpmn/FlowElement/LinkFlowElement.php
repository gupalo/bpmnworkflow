<?php

namespace Gupalo\BpmWorkflow\Bpmn\FlowElement;

class LinkFlowElement implements FlowElementInterface
{
    public function __construct(private string $name)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }
}
