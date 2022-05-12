<?php

/** @noinspection PhpPropertyCanBeReadonlyInspection */

namespace Gupalo\BpmnWorkflow\Context;

class ParameterBagContext implements ContextInterface
{
    public function __construct(
        private array $items = [],
    ) {
    }
    
    public function getData()
    {
        return $this->items;
    }

    public function get(string $key): mixed
    {
        return $this->items[$key] ?? null;
    }

    public function set(string $key, mixed $value): void
    {
        $this->items[$key] = $value;
    }
}
