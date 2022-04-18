<?php

namespace Gupalo\BpmWorkflow\Bpmn\FlowElement;

class GatewayTransitionFlowElement implements FlowElementInterface, NextFlowElementAwareInterface
{
    use NextFlowElementTrait;

    public function __construct(private bool $isDefault, private ?string $condition)
    {
    }

    public function isDefault(): bool
    {
        return $this->isDefault;
    }

    public function getCondition(): ?string
    {
        return $this->condition;
    }
}
