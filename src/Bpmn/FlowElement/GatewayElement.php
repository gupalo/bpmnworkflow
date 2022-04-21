<?php

namespace Gupalo\BpmnWorkflow\Bpmn\FlowElement;

use JetBrains\PhpStorm\Pure;

class GatewayElement implements ElementInterface
{
    /**
     * @var array|GatewayTransitionElement[]
     */
    private array $transitions = [];

    public function __construct(private string $name)
    {
    }

    public function getTransitions(): array
    {
        return $this->sortTransition($this->transitions);
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
        /** @var GatewayTransitionElement $transition */
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
    public function getDefaultTransition(): ?GatewayTransitionElement
    {
        foreach ($this->transitions as $transition) {
            if ($transition->isDefault()) {
                return $transition;
            }
        }

        return null;
    }
}
