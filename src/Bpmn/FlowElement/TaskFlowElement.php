<?php

namespace Gupalo\BpmWorkflow\Bpmn\FlowElement;

class TaskFlowElement implements FlowElementInterface, NextFlowElementAwareInterface
{
    use NextFlowElementTrait;

    public function __construct(private string $name)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }
}
