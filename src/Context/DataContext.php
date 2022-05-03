<?php

namespace Gupalo\BpmnWorkflow\Context;

class DataContext implements ContextInterface
{
    public function __construct(private $data)
    {
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data): void
    {
        $this->data = $data;
    }
}
