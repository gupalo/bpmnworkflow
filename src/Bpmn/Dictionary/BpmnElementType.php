<?php

namespace Gupalo\BpmWorkflow\Bpmn\Dictionary;

class BpmnElementType
{
    public const GATEWAY_TYPE = 'exclusiveGateway';
    public const END_TYPE = 'endEvent';
    public const BEGIN_TYPE = 'beginEvent';
    public const TASK_TYPE = 'task';
    public const LINK_TYPE = 'intermediateThrowEvent';
}
