<?php

namespace Gupalo\BpmWorkflow\Bpmn\FlowElement;

use JetBrains\PhpStorm\Pure;

class GatewayFlowElement implements FlowElementInterface
{
    /**
     * @var array|GatewayTransitionFlowElement[]
     */
    private array $transitions = [];

    public function __construct(private string $name)
    {
    }

    public function getTransitions(): array
    {
        return $this->transitions;
    }

    public function setTransitions(array $transitions): void
    {
        $this->transitions = $transitions;
    }

    public function getName(): string
    {
        return $this->name;
    }

    private function sortTransition(array $transitions): array
    {
        $transitionWithKey = [];
        /** @var GatewayTransitionFlowElement $transition */
        foreach ($transitions as $transition) {
            if ($transition->isDefault()) {
                continue;
            }
            $transitionWithKey[$transition->getCondition()] = $transition;
        }
        ksort($transitionWithKey);

        return $transitionWithKey;
    }

    #[Pure]
    private function getDefaultTransition(): ?GatewayTransitionFlowElement
    {
        foreach ($this->transitions as $transition) {
            if ($transition->isDefault()) {
                return $transition;
            }
        }

        return null;
    }
}
