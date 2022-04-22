<?php

namespace Gupalo\BpmnWorkflow\Transition;

use Gupalo\BpmnWorkflow\Bpmn\Exception\ConditionNotFoundException;

class ConditionContainer
{
    /** @var array | ConditionInterface[] */
    private array $conditions;

    public function getConditions(): array
    {
        return $this->conditions;
    }

    public function getCondition(string $identity): ?ConditionInterface
    {
        foreach ($this->conditions as $condition) {
            if ($condition->match($identity)) {
                return $condition;
            }
        }

        throw new ConditionNotFoundException($identity);
    }

    public function setConditions(array $conditions): void
    {
        $this->conditions = $conditions;
    }

    public function addCondition(ConditionInterface $condition): void
    {
        $this->conditions[] = $condition;
    }
}
