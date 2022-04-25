<?php

namespace Gupalo\BpmnWorkflow\Extension;

use Gupalo\BpmnWorkflow\Bpmn\Symbol\Activity\Task;
use Gupalo\BpmnWorkflow\Context\ContextInterface;
use Gupalo\BpmnWorkflow\Exception\Process\ProcedureNotFoundException;

class ProcedureHandler
{
    use NamingStrategyTrait;

    public function __construct(private readonly ExtensionContainer $container)
    {
    }

    public function execute(Task $taskElement, ContextInterface $context): void
    {
        $nameTask = $this->getName($taskElement->getName());
        $params = $this->getParams($taskElement->getName());

        $procedure = $this->container->getProcedure($nameTask);

        if (!$procedure instanceof ProcedureInterface) {
            throw new ProcedureNotFoundException($nameTask);
        }

        $procedure->execute($params, $context);
    }
}
