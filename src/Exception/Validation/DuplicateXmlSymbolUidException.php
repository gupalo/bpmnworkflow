<?php

namespace Gupalo\BpmnWorkflow\Exception\Validation;

use Exception;
use JetBrains\PhpStorm\Pure;

class DuplicateXmlSymbolUidException extends Exception
{
    private const MESSAGE_TEMPLATE = 'XmlSymbol with uid "%s" already exists';

    #[Pure]
    public function __construct(string $uid)
    {
        parent::__construct(sprintf(self::MESSAGE_TEMPLATE, $uid));
    }
}
