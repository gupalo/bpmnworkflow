<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Validator;

use Gupalo\BpmnWorkflow\Bpmn\XmlSymbol\XmlSymbol;
use Gupalo\BpmnWorkflow\Exception\Validation\SequenceFlowValidationException;

class SequenceFlowValidator
{
    public function validate(array $sequenceFlows): void
    {
        foreach ($sequenceFlows as $sequenceFlow) {
            $this->validateOne($sequenceFlow);
        }
    }

    private function validateOne(XmlSymbol $xmlSymbol): void
    {
        if (!$xmlSymbol->getTargetRefUid()) {
            throw new SequenceFlowValidationException('Target ref uid for transition elements must be');
        }

        if (!$xmlSymbol->getSourceRefUid()) {
            throw new SequenceFlowValidationException('Source ref uid for transition elements must be');
        }
    }
}
