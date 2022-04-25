<?php

namespace Gupalo\BpmnWorkflow\Bpmn\XmlSymbol;

class XmlSymbolType
{
    public const SUPPORTED_TYPES = [
        XmlSymbolType::START_EVENT_TYPE,
        XmlSymbolType::END_EVENT_TYPE,
        XmlSymbolType::LINK_THROW_TYPE,
        XmlSymbolType::LINK_CATCH_TYPE,
        XmlSymbolType::EXCLUSIVE_GATEWAY_TYPE,
        XmlSymbolType::TASK_TYPE,
        XmlSymbolType::CALL_ACTIVITY_TYPE,
        XmlSymbolType::SEQUENCE_FLOW_TYPE,
    ];
    public const SKIP_TYPES = [
        self::PROCESS_TYPE,
        self::ASSOCIATION_TYPE,
        self::TEXT_ANNOTATION_TYPE,
    ];

    // event
    public const START_EVENT_TYPE = 'startEvent';
    public const END_EVENT_TYPE = 'endEvent';
    public const LINK_THROW_TYPE = 'intermediateThrowEvent';
    public const LINK_CATCH_TYPE = 'intermediateCatchEvent';

    // gateway
    public const EXCLUSIVE_GATEWAY_TYPE = 'exclusiveGateway';

    // activity
    public const TASK_TYPE = 'task';
    public const CALL_ACTIVITY_TYPE = 'callActivity';

    // flow
    public const SEQUENCE_FLOW_TYPE = 'sequenceFlow';

    // skip
    public const PROCESS_TYPE = 'process';
    public const ASSOCIATION_TYPE = 'association';
    public const TEXT_ANNOTATION_TYPE = 'textAnnotation';
}
