<?php

namespace Gupalo\BpmWorkflow\Bpmn\Mapping;

use Gupalo\BpmWorkflow\Bpmn\ElementResolver\BeginElementResolver;
use Gupalo\BpmWorkflow\Bpmn\ElementResolver\EndElementResolver;
use Gupalo\BpmWorkflow\Bpmn\ElementResolver\GatewayElementResolver;
use Gupalo\BpmWorkflow\Bpmn\ElementResolver\LinkElementResolver;
use Gupalo\BpmWorkflow\Bpmn\ElementResolver\TaskElementResolver;

class ElementResolveMapping
{
    private const MAP = [
        'exclusiveGateway' => GatewayElementResolver::class,
        'endEvent' => EndElementResolver::class,
        'intermediateThrowEvent' => LinkElementResolver::class,
        'task' => TaskElementResolver::class,
    ];

    public static function getResolver(string $type): ?string
    {
        return self::MAP[$type] ?? null;
    }
}
