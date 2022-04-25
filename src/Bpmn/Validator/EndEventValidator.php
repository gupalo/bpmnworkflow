<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Validator;

use Gupalo\BpmnWorkflow\Bpmn\XmlSymbol\XmlSymbol;
use Gupalo\BpmnWorkflow\Exception\Validation\EndEventValidationException;

class EndEventValidator
{
    public function validate(array $endEvents): void
    {
        foreach ($endEvents as $endEvent) {
            $this->validateOne($endEvent);
        }
    }

    private function validateOne(XmlSymbol $xmlSymbol): void
    {
        if (count($xmlSymbol->getOutgoingUids()) !== 0) {
            throw new EndEventValidationException('Outgoings for end elements must be empty');
        }

        if (!$xmlSymbol->getIncomingUids()) {
            throw new EndEventValidationException('Incoming for end elements must be');
        }
    }
}
