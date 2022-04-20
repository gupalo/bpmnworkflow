<?php

namespace Gupalo\BpmWorkflow\Gateway;

use Gupalo\BpmWorkflow\Bpmn\FlowElement\GatewayElement;
use Gupalo\BpmWorkflow\Context\Context;
use Gupalo\BpmWorkflow\Task\TaskGatewayNamingStrategyTrait;

class GatewayHandler
{
    use TaskGatewayNamingStrategyTrait;

    public function __construct(private TransitionContainer $gatewayContainer)
    {
    }

    public function execute(GatewayElement $gatewayElement, Context $context): string
    {
        $nameGateway = $this->getName($gatewayElement->getName());
        $params = $this->getParams($gatewayElement->getName());

        $gateway = $this->gatewayContainer->getGateway($nameGateway);

        if (!$gateway instanceof TransitionInterface) {
            // @todo handle error
            throw  new \RuntimeException();
        }

        return $gateway->execute($params, $context);
    }
}
