<?php

namespace Gupalo\BpmnWorkflow\Bpmn\BpmnElement;

class BpmnElement
{
    public function __construct(
        private string $type,
        private string $uid,
        private string $data,
        private string $sourceRefUid,
        private string $targetRefUid,
        private string $defaultUid,
        private array $outgoingUids,
        private ?string $incomingUid = null,
    ) {
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getUid(): string
    {
        return $this->uid;
    }

    public function getData(): string
    {
        return $this->data;
    }

    public function getSourceRefUid(): string
    {
        return $this->sourceRefUid;
    }

    public function getTargetRefUid(): string
    {
        return $this->targetRefUid;
    }

    public function getDefaultUid(): string
    {
        return $this->defaultUid;
    }

    public function getIncomingUid(): string
    {
        return $this->incomingUid;
    }

    public function getOutgoingUids(): array
    {
        return $this->outgoingUids;
    }
}
