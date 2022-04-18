<?php

namespace Gupalo\BpmWorkflow\Bpmn\FlowElement;

class BeginFlowElement implements FlowElementInterface, NextFlowElementAwareInterface
{
    use NextFlowElementTrait;
}
