<?php

namespace Gupalo\BpmWorkflow\Bpmn\FlowElement;

class Flow implements FlowElementInterface, NextFlowElementAwareInterface
{
    use NextFlowElementTrait;
}
