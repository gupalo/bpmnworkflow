<?php

namespace Gupalo\BpmnWorkflow\Extension;

use Gupalo\BpmnWorkflow\Exception\Process\ComparisonNotFoundException;

class ExtensionContainer
{
    /** @var ProcedureInterface[] */
    private array $procedures;

    /** @var FunctionInterface[] */
    private array $functions = [];

    /** @var ComparisonInterface[] */
    private array $Comparisons;

    public function getProcedures(): array
    {
        return $this->procedures;
    }

    public function getProcedure(string $key): ?ProcedureInterface
    {
        return $this->procedures[$key] ?? null;
    }

    public function setProcedures(array $procedures): void
    {
        $this->procedures = $procedures;
    }

    public function addProcedure(string $key, ProcedureInterface $procedure): void
    {
        $this->procedures[$key] = $procedure;
    }

    public function getFunctions(): array
    {
        return $this->functions;
    }

    public function getFunction(string $key): ?FunctionInterface
    {
        return $this->functions[$key] ?? null;
    }

    public function setFunctions(array $functions): void
    {
        $this->functions = $functions;
    }

    public function addFunction(string $key, FunctionInterface $function): void
    {
        $this->functions[$key] = $function;
    }

    public function getComparisons(): array
    {
        return $this->Comparisons;
    }

    public function getComparison(string $name): ?ComparisonInterface
    {
        foreach ($this->Comparisons as $condition) {
            if ($condition->match($name)) {
                return $condition;
            }
        }

        throw new ComparisonNotFoundException($name);
    }

    public function setComparisons(array $procedures): void
    {
        $this->Comparisons = $procedures;
    }

    public function addComparison(ComparisonInterface $condition): void
    {
        $this->Comparisons[] = $condition;
    }
}
