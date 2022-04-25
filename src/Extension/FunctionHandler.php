<?php

namespace Gupalo\BpmnWorkflow\Extension;

use Gupalo\BpmnWorkflow\Bpmn\Symbol\Gateway\ExclusiveGateway;
use Gupalo\BpmnWorkflow\Context\ContextInterface;
use Gupalo\BpmnWorkflow\Exception\Process\FunctionNotFoundException;

class FunctionHandler
{
    use NamingStrategyTrait;

    public function __construct(
        private readonly ExtensionContainer $container,
    ) {
    }

    public function execute(ExclusiveGateway $gateway, ContextInterface $context): string
    {
        $name = $this->getName($gateway->getName());
        $params = $this->getParams($gateway->getName());

        $function = $this->container->getFunction($name);

        if (!$function instanceof FunctionInterface) {
            throw new FunctionNotFoundException($name);
        }

        return $function->execute($params, $context);
    }
}
