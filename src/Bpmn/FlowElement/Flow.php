<?php

namespace Gupalo\BpmWorkflow\Bpmn\FlowElement;

class Flow implements ElementInterface, NextElementAwareInterface
{
    use NextElementTrait;
}
