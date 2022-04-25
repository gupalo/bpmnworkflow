<?php

namespace Gupalo\BpmnWorkflow\Bpmn\XmlSymbol;

class XmlSymbol
{
    public function __construct(
        private readonly string $type,
        private readonly string $uid,
        private readonly string $data,
        private readonly string $sourceRefUid,
        private readonly string $targetRefUid,
        private readonly string $defaultUid,
        /** @var string[] */ private readonly array $outgoingUids,
        /** @var string[] */ private readonly array $incoimngUids,
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

    /** @return string[] */
    public function getIncomingUids(): array
    {
        return $this->incoimngUids;
    }

    public function getFirstOutgoingUid(): ?string
    {
        return $this->outgoingUids[0] ?? null;
    }

    /** @return string[] */
    public function getOutgoingUids(): array
    {
        return $this->outgoingUids;
    }
}
