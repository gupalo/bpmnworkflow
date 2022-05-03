<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Validator;

use Gupalo\BpmnWorkflow\Bpmn\XmlSymbol\XmlSymbol;
use Gupalo\BpmnWorkflow\Exception\Validation\ExclusiveGatewayValidationException;

class ExclusiveGatewayValidator
{
    /**
     * @param XmlSymbol[] $exclusiveGateways
     */
    public function validate(array $exclusiveGateways): void
    {
        foreach ($exclusiveGateways as $exclusiveGateway) {
            $this->validateOne($exclusiveGateway);
        }
    }

    private function validateOne(XmlSymbol $bpmnElement): void
    {
        if (!$bpmnElement->getDefaultUid()) {
            throw new ExclusiveGatewayValidationException('Default transition for gateway must exist');
        }

        if (!$bpmnElement->getIncomingUids()) {
            throw new ExclusiveGatewayValidationException(sprintf(
                'There should be at least one incoming for exclusive gateway "%s" (%s)', $bpmnElement->getData(), $bpmnElement->getUid()
            ));
        }
    }
}
