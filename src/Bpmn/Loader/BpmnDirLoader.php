<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Loader;

class BpmnDirLoader implements BpmnLoaderInterface
{
    public function __construct(private string $dirPath, private string $extension = 'bpmn')
    {
    }

    public function load(): array
    {
        $result = [];
        $files = scandir($this->dirPath);
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..' && strstr($file, $this->extension)) {
                $result[explode('.', $file)[0]] = file_get_contents(rtrim($this->dirPath, '/') . '/' . $file);
            }
        }

        return $result;
    }
}
