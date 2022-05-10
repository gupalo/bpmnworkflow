<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Validator;

use Gupalo\BpmnWorkflow\Bpmn\XmlSymbol\XmlSymbol;
use Gupalo\BpmnWorkflow\Exception\Validation\CallActivityValidationException;

class CallActitityValidator
{
    public function validate(array $tasks): void
    {
        foreach ($tasks as $task) {
            $this->validateOne($task);
        }
    }

    private function validateOne(XmlSymbol $xmlSymbol): void
    {
        if (!$xmlSymbol->getData()) {
            throw new CallActivityValidationException('Name for call activity elements must be');
        }

        if (count($xmlSymbol->getOutgoingUids()) !== 1) {
            throw new TaskValidationException('Outgoings for call activity elements must be only one');
        }

        if (!$xmlSymbol->getIncomingUids()) {
            throw new TaskValidationException('Incoming for call activity must be');
        }
    }
}
