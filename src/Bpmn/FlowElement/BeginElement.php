<?php

namespace Gupalo\BpmWorkflow\Bpmn\FlowElement;

class BeginElement implements ElementInterface, NextElementAwareInterface
{
    use NextElementTrait;
}
