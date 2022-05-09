<?php

namespace Gupalo\BpmnWorkflow\Bpmn\SymbolResolver;

use Gupalo\BpmnWorkflow\Bpmn\XmlSymbol\XmlSymbolType;

class SymbolResolverMapping
{
    private const MAP = [
        XmlSymbolType::EXCLUSIVE_GATEWAY_TYPE => ExclusiveGatewayResolver::class,
        XmlSymbolType::END_EVENT_TYPE => EndEventResolver::class,
        XmlSymbolType::LINK_THROW_TYPE => LinkThrowResolver::class,
        XmlSymbolType::LINK_CATCH_TYPE => LinkCatchResolver::class,
        XmlSymbolType::TASK_TYPE => TaskResolver::class,
        XmlSymbolType::START_EVENT_TYPE => StartEventResolver::class,
    ];

    public static function getResolver(string $type): ?string
    {
        return self::MAP[$type] ?? null;
    }
}
