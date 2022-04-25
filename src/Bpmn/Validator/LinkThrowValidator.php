<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Validator;

use Gupalo\BpmnWorkflow\Bpmn\XmlSymbol\XmlSymbol;
use Gupalo\BpmnWorkflow\Exception\Validation\LinkThrowValidationException;

class LinkThrowValidator
{
    public function validate(array $linkThrows): void
    {
        foreach ($linkThrows as $linkThrow) {
            $this->validateOne($linkThrow);
        }
    }

    private function validateOne(XmlSymbol $xmlSymbol): void
    {
        if (!$xmlSymbol->getData()) {
            throw new LinkThrowValidationException('Name for link elements must be');
        }

        if ($xmlSymbol->getOutgoingUids()) {
            throw new LinkThrowValidationException('Outgoings for link elements must be empty');
        }

        if (!$xmlSymbol->getIncomingUids()) {
            throw new LinkThrowValidationException('Incoming for link elements must be');
        }
    }
}
