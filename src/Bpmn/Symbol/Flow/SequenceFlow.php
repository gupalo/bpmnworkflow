<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Symbol\Flow;

use Gupalo\BpmnWorkflow\Bpmn\Symbol\NextSymbolAwareInterface;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\NextSymbolTrait;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\SymbolInterface;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\UuidAwareInterface;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\UuidTrait;

class SequenceFlow implements SymbolInterface, NextSymbolAwareInterface, UuidAwareInterface
{
    private const DEFAULT_ORDER = 10000;

    use NextSymbolTrait;
    use UuidTrait;

    private ?string $condition;

    private int $order;

    /**
     * @param bool $isDefault
     * @param string|null $condition without order like '> 0' or with order like '7) > 0'
     */
    public function __construct(
        private readonly bool $isDefault,
        ?string $condition,
    ) {
        $this->order = self::DEFAULT_ORDER + abs(crc32($condition ?? ''));
        $this->condition = $condition;

        if (preg_match('#^(\d+\))\s*(.*)$#', $condition, $m)) {
            $this->order = $m[1];
            $this->condition = $m[2];
        }
    }

    public function isDefault(): bool
    {
        return $this->isDefault;
    }

    public function getCondition(): ?string
    {
        return $this->condition;
    }

    public function getOrder(): int
    {
        return $this->order;
    }
}
