<?php

namespace Gupalo\BpmWorkflow\Gateway;

class GatewayContainer
{
    private array $gateways;

    public function getGateways(): array
    {
        return $this->gateways;
    }

    public function getGateway(string $key): ?TransitionInterface
    {
        return $this->tasks[$key] ?? null;
    }

    public function setGateways(array $gateways): void
    {
        $this->gateways = $gateways;
    }

    public function addGateway(string $key, TransitionInterface $gateway): void
    {
        $this->gateways[$key] = $gateway;
    }
}
