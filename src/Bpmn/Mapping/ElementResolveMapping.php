<?php

namespace Gupalo\BpmWorkflow\Bpmn\Mapping;

use Gupalo\BpmWorkflow\Bpmn\Dictionary\BpmnElementType;
use Gupalo\BpmWorkflow\Bpmn\ElementResolver\BeginElementResolver;
use Gupalo\BpmWorkflow\Bpmn\ElementResolver\EndElementResolver;
use Gupalo\BpmWorkflow\Bpmn\ElementResolver\GatewayElementResolver;
use Gupalo\BpmWorkflow\Bpmn\ElementResolver\LinkElementResolver;
use Gupalo\BpmWorkflow\Bpmn\ElementResolver\TaskElementResolver;

class ElementResolveMapping
{
    private const MAP = [
         BpmnElementType::GATEWAY_TYPE => GatewayElementResolver::class,
         BpmnElementType::END_TYPE => EndElementResolver::class,
         BpmnElementType::LINK_TYPE => LinkElementResolver::class,
         BpmnElementType::TASK_TYPE => TaskElementResolver::class,
         BpmnElementType::BEGIN_TYPE => BeginElementResolver::class,
    ];

    public static function getResolver(string $type): ?string
    {
        return self::MAP[$type] ?? null;
    }
}
