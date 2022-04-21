<?php

namespace Gupalo\BpmnWorkflow\Task;

use Gupalo\BpmnWorkflow\Bpmn\FlowElement\TaskElement;
use Gupalo\BpmnWorkflow\Context\Context;

class TaskHandler
{
    use TaskGatewayNamingStrategyTrait;

    public function __construct(private TaskContainer $taskContainer)
    {
    }

    public function execute(TaskElement $taskElement, Context $context): void
    {
        $nameTask = $this->getName($taskElement->getName());
        $params = $this->getParams($taskElement->getName());

        $task = $this->taskContainer->getTask($nameTask);

        if (!$task instanceof TaskInterface) {
            // @todo handle error
            throw  new \RuntimeException();
        }

        $task->execute($params, $context);
    }
}
