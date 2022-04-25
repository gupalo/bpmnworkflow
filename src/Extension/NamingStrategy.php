<?php

namespace Gupalo\BpmnWorkflow\Extension;

class NamingStrategy
{
    public static function underscore(string $className): string
    {
        $s = preg_replace('#^.*[\\\\/]#', '', $className);
        $s = preg_replace('#(Function|Procedure|Comparison)$#', '', $s);

        $result = '';

        $len = mb_strlen($s);
        for ($i = 0; $i < $len; $i++) {
            $c = mb_substr($s, $i, 1);
            if ($i === 0) {
                $c = mb_strtolower($c);
            }
            $result .= (!preg_match('#^[A-Z]$#', $c)) ? $c : '_' . mb_strtolower($c);
        }

        return $result;
    }
}
