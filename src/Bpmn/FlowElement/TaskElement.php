<?php

namespace Gupalo\BpmnWorkflow\Bpmn\FlowElement;

class TaskElement implements ElementInterface, NextElementAwareInterface
{
    use NextElementTrait;

    public function __construct(private string $name)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }
}
