<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Validator;

use Gupalo\BpmnWorkflow\Bpmn\BpmnElement\BpmnElement;
use Gupalo\BpmnWorkflow\Bpmn\Exception\Validation\SequenceFlowValidationException;

class SequenceFlowValidator
{
    public function validate(array $sequenceFlows): void
    {
        foreach ($sequenceFlows as $sequenceFlow) {
            $this->validOne($sequenceFlow);
        }
    }

    private function validOne(BpmnElement $bpmnElement): void
    {
        if (!$bpmnElement->getTargetRefUid()) {
            throw new SequenceFlowValidationException('Target ref uid for transition elements must be');
        }

        if (!$bpmnElement->getSourceRefUid()) {
            throw new SequenceFlowValidationException('Source ref uid for transition elements must be');
        }
    }
}
