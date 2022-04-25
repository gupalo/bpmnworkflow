<?php

namespace Gupalo\BpmnWorkflow\Extension;

use Gupalo\BpmnWorkflow\Bpmn\Symbol\Activity\Task;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\Flow\SequenceFlow;
use Gupalo\BpmnWorkflow\Bpmn\Symbol\Gateway\ExclusiveGateway;
use Gupalo\BpmnWorkflow\Context\ContextInterface;

class ExtensionHandler
{
    private ExtensionContainer $container;

    private ProcedureHandler $procedureHandler;

    private FunctionHandler $functionHandler;

    private ComparisonResolver $ComparisonResolver;

    public function __construct(
        array $extensions = [],
    ) {
        $this->container = new ExtensionContainer();
        $this->procedureHandler = new ProcedureHandler($this->container);
        $this->functionHandler = new FunctionHandler($this->container);
        $this->ComparisonResolver = new ComparisonResolver($this->container);

        foreach ($extensions as $extension) {
            $this->add($extension);
        }
    }

    public function add(ProcedureInterface|FunctionInterface|ComparisonInterface $extension): void
    {
        if ($extension instanceof CustomNameExtensionInterface) {
            $name = $extension->getName();
        } else {
            $name = NamingStrategy::underscore(get_class($extension));
        }

        if ($extension instanceof ProcedureInterface) {
            $this->container->addProcedure($name, $extension);
        }
        if ($extension instanceof FunctionInterface) {
            $this->container->addFunction($name, $extension);
        }
        if ($extension instanceof ComparisonInterface) {
            $this->container->addComparison($extension);
        }
    }

    public function executeProcedure(Task $taskElement, ContextInterface $context): void
    {
        $this->procedureHandler->execute($taskElement, $context);
    }

    public function executeFunction(ExclusiveGateway $gateway, ContextInterface $context): string
    {
        return $this->functionHandler->execute($gateway, $context);
    }

    public function matchFlow($gatewayResult, SequenceFlow $sequenceFlow): bool
    {
        return $this->ComparisonResolver->matchFlow($gatewayResult, $sequenceFlow);
    }
}
