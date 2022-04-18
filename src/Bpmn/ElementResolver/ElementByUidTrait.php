<?php

namespace Gupalo\BpmWorkflow\Bpmn\ElementResolver;

trait ElementByUidTrait
{
    public function getBpmElementByUid(string $uidElement, array $allElements): ?array
    {
        foreach ($allElements as $elements) {
            foreach ($elements as $key => $element) {
                if ($key === $uidElement) {
                    return $element;
                }
            }
        }

        return null;
    }
}
