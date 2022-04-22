<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Validator;

use Gupalo\BpmnWorkflow\Bpmn\Exception\Validation\StartEventValidationException;

class StartEventValidator
{
    public function validate(array $startEvents): void
    {
        if (count($startEvents) !== 1) {
            throw new StartEventValidationException('Starts elements must be only one');
        }

        if (count($startEvents[0]->getOutgoingUids()) !== 1) {
            throw new StartEventValidationException('Outgoings for start element must be only one');
        }
    }
}
