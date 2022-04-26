<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Loader;

class BpmnFileLoader implements BpmnLoaderInterface
{
    public function __construct(private string $filePath)
    {
    }

    public function load(): array
    {
        $filePathPart = explode('/', $this->filePath);
        $fileNameWithExtension = $filePathPart[count($filePathPart) - 1];
        $fileName = explode('.', $fileNameWithExtension)[0];

        return [$fileName => file_get_contents($this->filePath)];
    }
}
