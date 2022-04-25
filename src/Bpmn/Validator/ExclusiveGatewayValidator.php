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

        if (!$bpmnElement->getData()) {
            // TODO: VL: it's ok for gateway to be empty - it is used to combine several incoming to one outgoing
            //throw new ExclusiveGatewayValidationException('Name for gateway elements must have');
        }

        if (count($bpmnElement->getOutgoingUids()) < 2) {
            // TODO: VL: it's ok for gateway to have one outgoing - it is used to combine several incoming to one outgoing
            //throw new ExclusiveGatewayValidationException('Outgoings for gateway element must be more 2');
        }

        if (!$bpmnElement->getIncomingUids()) {
            throw new ExclusiveGatewayValidationException(sprintf(
                'There should be at least one incoming for exclusive gateway "%s" (%s)', $bpmnElement->getData(), $bpmnElement->getUid()
            ));
        }
    }
}
