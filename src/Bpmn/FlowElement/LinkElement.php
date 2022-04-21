<?php

namespace Gupalo\BpmnWorkflow\Bpmn\FlowElement;

class LinkElement implements ElementInterface
{
    public function __construct(private string $name)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }
}
