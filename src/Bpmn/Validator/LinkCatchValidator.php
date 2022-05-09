<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Validator;

use Gupalo\BpmnWorkflow\Bpmn\XmlSymbol\XmlSymbol;
use Gupalo\BpmnWorkflow\Exception\Validation\LinkCatchValidationException;

class LinkCatchValidator
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
            throw new LinkCatchValidationException('Name for link catch elements must be');
        }

        if (!$xmlSymbol->getOutgoingUids()) {
            throw new LinkCatchValidationException('Outgoings for link catch elements must be');
        }

        if ($xmlSymbol->getIncomingUids()) {
            throw new LinkCatchValidationException('Incoming for link elements must be empty');
        }
    }
}
