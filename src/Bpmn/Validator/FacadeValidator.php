<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Validator;

use Gupalo\BpmnWorkflow\Bpmn\BpmnElement\BpmnElementContainer;
use Gupalo\BpmnWorkflow\Bpmn\Exception\Validation\CommonElementValidationException;

class FacadeValidator
{
    public function validate(BpmnElementContainer $bpmnElementContainer): void
    {
        (new EndEventValidator())->validate($bpmnElementContainer->getEndEvents());
        (new StartEventValidator())->validate($bpmnElementContainer->getStartEvents());
        (new IntermediateThrowEventValidator())->validate($bpmnElementContainer->getIntermediateThrowEvents());
        (new TaskValidator())->validate($bpmnElementContainer->getTasks());
        (new SequenceFlowValidator())->validate($bpmnElementContainer->getsSquenceFlows());
        (new ExclusiveGatewayValidator())->validate($bpmnElementContainer->getExclusiveGateways());

        if (count(array_merge(
            $bpmnElementContainer->getEndEvents(),
            $bpmnElementContainer->getIntermediateThrowEvents()
        )) === 0) {
            throw new CommonElementValidationException('end or link element must be');
        }
    }
}
