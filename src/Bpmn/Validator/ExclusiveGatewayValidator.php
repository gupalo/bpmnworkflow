<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Validator;

use Gupalo\BpmnWorkflow\Bpmn\BpmnElement\BpmnElement;
use Gupalo\BpmnWorkflow\Bpmn\Exception\Validation\ExclusiveGatewayValidationException;

class ExclusiveGatewayValidator
{
    public function validate(array $exclusiveGateways): void
    {
        foreach ($exclusiveGateways as $exclusiveGateway) {
            $this->validOne($exclusiveGateway);
        }
    }

    private function validOne(BpmnElement $bpmnElement): void
    {
        if (!$bpmnElement->getDefaultUid()) {
            throw new ExclusiveGatewayValidationException('Default transition for gateway must be');
        }

        if (!$bpmnElement->getData()) {
            throw new ExclusiveGatewayValidationException('Name for gateway elements must have');
        }

        if (count($bpmnElement->getOutgoingUids()) < 2) {
            throw new ExclusiveGatewayValidationException('Outgoings for gateway element must be more 2');
        }

        if (!$bpmnElement->getIncomingUid()) {
            throw new ExclusiveGatewayValidationException('Incoming for gateway elements must be');
        }
    }
}
