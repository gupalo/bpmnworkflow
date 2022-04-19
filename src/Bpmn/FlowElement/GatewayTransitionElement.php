<?php

namespace Gupalo\BpmWorkflow\Bpmn\FlowElement;

class GatewayTransitionElement implements ElementInterface, NextElementAwareInterface
{
    use NextElementTrait;

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
