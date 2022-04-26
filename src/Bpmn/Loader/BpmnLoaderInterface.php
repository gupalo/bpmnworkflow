<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Loader;

interface BpmnLoaderInterface
{
    /**
     * @return array $processes [name => xml_string|Process]
     */
    public function load(): array;
}
