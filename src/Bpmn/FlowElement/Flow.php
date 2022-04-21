<?php

namespace Gupalo\BpmnWorkflow\Bpmn\FlowElement;

class Flow implements ElementInterface, NextElementAwareInterface
{
    use NextElementTrait;
}
