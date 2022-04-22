<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Validator;

use Gupalo\BpmnWorkflow\Bpmn\BpmnElement\BpmnElement;
use Gupalo\BpmnWorkflow\Bpmn\Exception\Validation\IntermediateThrowEventVlidationException;
use Gupalo\BpmnWorkflow\Bpmn\Exception\Validation\TaskValidationException;

class TaskValidator
{
    public function validate(array $tasks): void
    {
        foreach ($tasks as $task) {
            $this->validOne($task);
        }
    }

    private function validOne(BpmnElement $bpmnElement): void
    {
        if (!$bpmnElement->getData()) {
            throw new IntermediateThrowEventVlidationException('Name for task elements must be');
        }

        if (count($bpmnElement->getOutgoingUids()) !== 1) {
            throw new TaskValidationException('Outgoings for task elements must be only one');
        }

        if (!$bpmnElement->getIncomingUid()) {
            throw new TaskValidationException('Incoming must be');
        }
    }
}
