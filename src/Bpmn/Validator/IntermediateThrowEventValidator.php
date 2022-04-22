<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Validator;

use Gupalo\BpmnWorkflow\Bpmn\BpmnElement\BpmnElement;
use Gupalo\BpmnWorkflow\Bpmn\Exception\Validation\IntermediateThrowEventVlidationException;

class IntermediateThrowEventValidator
{
    public function validate(array $intermediateThrowEvents): void
    {
        foreach ($intermediateThrowEvents as $intermediateThrowEvent) {
            $this->validOne($intermediateThrowEvent);
        }
    }

    private function validOne(BpmnElement $bpmnElement): void
    {
        if (!$bpmnElement->getData()) {
            throw new IntermediateThrowEventVlidationException('Name for link elements must be');
        }

        if (count($bpmnElement->getOutgoingUids()) !== 0) {
            throw new IntermediateThrowEventVlidationException('Outgoings for link elements must be empty');
        }

        if (!$bpmnElement->getIncomingUid()) {
            throw new IntermediateThrowEventVlidationException('Incoming for link elements must be');
        }
    }
}
