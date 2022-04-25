<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Validator;

use Gupalo\BpmnWorkflow\Bpmn\XmlSymbol\XmlSymbol;
use Gupalo\BpmnWorkflow\Exception\Validation\LinkThrowValidationException;
use Gupalo\BpmnWorkflow\Exception\Validation\TaskValidationException;

class TaskValidator
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
            throw new LinkThrowValidationException('Name for task elements must be');
        }

        if (count($xmlSymbol->getOutgoingUids()) !== 1) {
            throw new TaskValidationException('Outgoings for task elements must be only one');
        }

        if (!$xmlSymbol->getIncomingUids()) {
            throw new TaskValidationException('Incoming must be');
        }
    }
}
