<?php

namespace Gupalo\BpmnWorkflow\Bpmn\XmlSymbol;

use Gupalo\BpmnWorkflow\Exception\Process\BeginElementNotFoundException;
use Gupalo\BpmnWorkflow\Exception\Process\UnknownElementTypeException;
use Gupalo\BpmnWorkflow\Exception\Process\XmlSymbolNotFoundException;
use Gupalo\BpmnWorkflow\Exception\Validation\DuplicateXmlSymbolUidException;

class XmlSymbolContainer
{
    /** @var XmlSymbol[] */
    private array $items = [];

    private array $typeItemUids = [];

    /**
     * @param XmlSymbol[] $items
     */
    public function __construct(array $items) {
        foreach ($items as $item) {
            $this->add($item);
        }
    }

    private function add(XmlSymbol $item): void
    {
        $uid = $item->getUid();
        $type = $item->getType();

        if (in_array($type, XmlSymbolType::SKIP_TYPES, true)) {
            return;
        }
        if (!in_array($type, XmlSymbolType::SUPPORTED_TYPES, true)) {
            throw new UnknownElementTypeException($type);
        }
        if (isset($this->items[$uid])) {
            throw new DuplicateXmlSymbolUidException($uid);
        }

        $this->items[$uid] = $item;

        if (!isset($this->typeItemUids[$type])) {
            $this->typeItemUids[$type] = [];
        }
        $this->typeItemUids[$type][] = $uid;
    }

    public function getXmlSymbolByUid(string $uid): XmlSymbol
    {
        $result = $this->items[$uid] ?? null;

        if (!$result) {
            throw new XmlSymbolNotFoundException($uid);
        }

        return $result;
    }

    private function getXmlSymbolsByType(string $type): array
    {
        $uids = $this->typeItemUids[$type] ?? [];

        $result = [];
        foreach ($uids as $uid) {
            $result[] = $this->items[$uid];
        }

        return $result;
    }

    public function getFirstStartEvent(): XmlSymbol
    {
        $startEvents = $this->getStartEvents();

        if (!$startEvents || !isset($startEvents[0])) {
            throw new BeginElementNotFoundException();
        }

        return $startEvents[0];
    }

    public function getStartEvents(): array
    {
        return $this->getXmlSymbolsByType(XmlSymbolType::START_EVENT_TYPE);
    }
    
    public function getEndEvents(): array
    {
        return $this->getXmlSymbolsByType(XmlSymbolType::END_EVENT_TYPE);
    }
    
    public function getExclusiveGateways(): array
    {
        return $this->getXmlSymbolsByType(XmlSymbolType::EXCLUSIVE_GATEWAY_TYPE);
    }
    
    public function getTasks(): array
    {
        return $this->getXmlSymbolsByType(XmlSymbolType::TASK_TYPE);
    }
    
    public function getLinkThrows(): array
    {
        return $this->getXmlSymbolsByType(XmlSymbolType::LINK_THROW_TYPE);
    }

    public function getLinksCatch(): array
    {
        return $this->getXmlSymbolsByType(XmlSymbolType::LINK_CATCH_TYPE);
    }

    public function getCallActivities(): array
    {
        return $this->getXmlSymbolsByType(XmlSymbolType::CALL_ACTIVITY_TYPE);
    }

    public function getSequenceFlows(): array
    {
        return $this->getXmlSymbolsByType(XmlSymbolType::SEQUENCE_FLOW_TYPE);
    }
}
