<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Loader;

class BpmnDirLoader implements BpmnLoaderInterface
{
    public function __construct(
        private readonly string $dirPath,
        private readonly string $extension = 'bpmn'
    ) {
    }

    public function load(): array
    {
        $result = [];
        $files = scandir($this->dirPath);
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..' && str_ends_with($file, '.' . $this->extension)) {
                $result[basename($file, '.' . $this->extension)] = file_get_contents(rtrim($this->dirPath, '/').'/'.$file);
            }
        }

        return $result;
    }
}
