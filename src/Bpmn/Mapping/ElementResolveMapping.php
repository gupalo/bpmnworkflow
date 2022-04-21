<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Mapping;

use Gupalo\BpmnWorkflow\Bpmn\Dictionary\BpmnElementType;
use Gupalo\BpmnWorkflow\Bpmn\ElementResolver\BeginElementResolver;
use Gupalo\BpmnWorkflow\Bpmn\ElementResolver\EndElementResolver;
use Gupalo\BpmnWorkflow\Bpmn\ElementResolver\GatewayElementResolver;
use Gupalo\BpmnWorkflow\Bpmn\ElementResolver\LinkElementResolver;
use Gupalo\BpmnWorkflow\Bpmn\ElementResolver\TaskElementResolver;

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
