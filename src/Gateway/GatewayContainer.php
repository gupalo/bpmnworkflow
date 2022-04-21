<?php

namespace Gupalo\BpmnWorkflow\Gateway;

class GatewayContainer
{
    private array $gateways;

    public function getGateways(): array
    {
        return $this->gateways;
    }

    public function getGateway(string $key): ?GatewayInterface
    {
        return $this->gateways[$key] ?? null;
    }

    public function setGateways(array $gateways): void
    {
        $this->gateways = $gateways;
    }

    public function addGateway(string $key, GatewayInterface $gateway): void
    {
        $this->gateways[$key] = $gateway;
    }
}
