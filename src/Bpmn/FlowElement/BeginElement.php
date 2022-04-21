<?php

namespace Gupalo\BpmnWorkflow\Bpmn\FlowElement;

class BeginElement implements ElementInterface, NextElementAwareInterface
{
    use NextElementTrait;
}
