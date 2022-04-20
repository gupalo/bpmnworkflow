<?php

namespace Gupalo\BpmWorkflow\Transition;

class ConditionExecuteContainer
{
    /** @var array | ConditionExecuteInterface[] */
    private array $conditionExecutes;

    public function getConditionExecutes(): array
    {
        return $this->conditionExecutes;
    }

    public function getConditionExecute(string $identity): ?ConditionExecuteInterface
    {
        foreach ($this->conditionExecutes as $conditionExecute) {
            if ($conditionExecute->match($identity)) {
                return $conditionExecute;
            }
        }

        // @todo handle error
        throw new \RuntimeException();
    }

    public function setConditionExecutes(array $conditionExecutes): void
    {
        $this->conditionExecutes = $conditionExecutes;
    }

    public function addConditionExecute(ConditionExecuteInterface $conditionExecute): void
    {
        $this->conditionExecutes[] = $conditionExecute;
    }
}
