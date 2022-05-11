<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Symbol\Gateway;

use Gupalo\BpmnWorkflow\Bpmn\Symbol\Flow\SequenceFlow;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\SymbolInterface;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\UuidAwareInterface;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\UuidTrait;
use JetBrains\PhpStorm\Pure;

class ExclusiveGateway implements SymbolInterface, UuidAwareInterface
{
    use UuidTrait;

    /** @var array|SequenceFlow[] */
    private array $flows = [];

    public function __construct(
        private readonly string $name,
    ) {
    }

    /** @return SequenceFlow[] */
    public function getFlows(): array
    {
        return $this->sortFlows($this->flows);
    }

    /** @param SequenceFlow[] $flows */
    public function setFlows(array $flows): void
    {
        $this->flows = $flows;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /** @return SequenceFlow[] */
    private function sortFlows(array $flows): array
    {
        $result = $this->getNotDefaultFlows($flows);

        uasort(
            $result,
            static fn(SequenceFlow $a, SequenceFlow $b) => $a->getOrder() <=> $b->getOrder()
        );

        return $result;
    }

    #[Pure]
    public function getDefaultFlow(): ?SequenceFlow
    {
        foreach ($this->flows as $flow) {
            if ($flow->isDefault()) {
                return $flow;
            }
        }

        // if there is no real default transition then any empty transition will count as default
        foreach ($this->flows as $flow) {
            if ($flow->getCondition() === null || $flow->getCondition() === '') {
                return $flow;
            }
        }

        return null;
    }

    /** @param SequenceFlow[] $flows */
    private function getNotDefaultFlows(array $flows): array
    {
        $result = [];
        foreach ($flows as $flow) {
            if ($flow->isDefault()) {
                continue;
            }
            $result[] = $flow;
        }

        return $result;
    }
}
