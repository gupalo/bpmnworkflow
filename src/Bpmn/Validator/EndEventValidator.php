<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Validator;

use Gupalo\BpmnWorkflow\Bpmn\BpmnElement\BpmnElement;
use Gupalo\BpmnWorkflow\Bpmn\Exception\Validation\EndEventValidationException;

class EndEventValidator
{
    public function validate(array $endEvents): void
    {
        foreach ($endEvents as $endEvent) {
            $this->validOne($endEvent);
        }
    }

    private function validOne(BpmnElement $bpmnElement): void
    {
        if (count($bpmnElement->getOutgoingUids()) !== 0) {
            throw new EndEventValidationException('Outgoings for end elements must be empty');
        }

        if (!$bpmnElement->getIncomingUid()) {
            throw new EndEventValidationException('Incoming for end elements must be');
        }
    }
}
