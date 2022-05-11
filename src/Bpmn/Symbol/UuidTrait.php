<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Symbol;

trait UuidTrait
{
    private string $uid;

    public function getUid(): string
    {
        return $this->uid;
    }

    public function setUid(string $uid): self
    {
        $this->uid = $uid;

        return $this;
    }
}
