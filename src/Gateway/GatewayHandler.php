<?php

namespace Gupalo\BpmnWorkflow\Gateway;

use Gupalo\BpmnWorkflow\Bpmn\FlowElement\GatewayElement;
use Gupalo\BpmnWorkflow\Context\Context;
use Gupalo\BpmnWorkflow\Task\TaskGatewayNamingStrategyTrait;

class GatewayHandler
{
    use TaskGatewayNamingStrategyTrait;

    public function __construct(private GatewayContainer $gatewayContainer)
    {
    }

    public function execute(GatewayElement $gatewayElement, Context $context): string
    {
        $nameGateway = $this->getName($gatewayElement->getName());
        $params = $this->getParams($gatewayElement->getName());

        $gateway = $this->gatewayContainer->getGateway($nameGateway);

        if (!$gateway instanceof GatewayInterface) {
            // @todo handle error
            throw  new \RuntimeException();
        }

        return $gateway->execute($params, $context);
    }
}
