<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Validator;

use Gupalo\BpmnWorkflow\Bpmn\XmlSymbol\XmlSymbolContainer;
use Gupalo\BpmnWorkflow\Exception\Validation\CommonSymbolValidationException;

class FacadeValidator
{
    public function validate(XmlSymbolContainer $container): void
    {
        (new EndEventValidator())->validate($container->getEndEvents());
        (new StartEventValidator())->validate($container->getStartEvents());
        (new LinkThrowValidator())->validate($container->getLinkThrows());
        (new TaskValidator())->validate($container->getTasks());
        (new SequenceFlowValidator())->validate($container->getSequenceFlows());
        (new ExclusiveGatewayValidator())->validate($container->getExclusiveGateways());

        $endSymbols = array_merge($container->getEndEvents(), $container->getLinkThrows());
        if (!$endSymbols) {
            throw new CommonSymbolValidationException('end or link element must be');
        }
    }
}
