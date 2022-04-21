<?php

namespace Gupalo\BpmnWorkflow\Context;

class Context
{
    public function __construct(private $data)
    {
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data): void
    {
        $this->data = $data;
    }
}
