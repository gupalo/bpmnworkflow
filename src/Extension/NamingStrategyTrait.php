<?php

namespace Gupalo\BpmnWorkflow\Extension;

trait NamingStrategyTrait
{
    public function getName(string $data): string
    {
        // some_alias(param1, param2)
        if (str_contains($data, '(') && str_contains($data, ')')) {
            return explode('(', $data)[0];
        }

        return $data;
    }

    public function getParams(string $data): array
    {
        // some_alias(param1, param2)
        if (str_contains($data, '(') && str_contains($data, ')')) {
            return explode(',', str_replace([$this->getName($data), '(', ')'], ['','',''], $data));
        }

        return [];
    }
}
