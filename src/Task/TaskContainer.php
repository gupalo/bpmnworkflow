<?php

namespace Gupalo\BpmnWorkflow\Task;

class TaskContainer
{
    private array $tasks;

    public function getTasks(): array
    {
        return $this->tasks;
    }

    public function getTask(string $key): ?TaskInterface
    {
        return $this->tasks[$key] ?? null;
    }

    public function setTasks(array $tasks): void
    {
        $this->tasks = $tasks;
    }

    public function addTask(string $key, TaskInterface $task): void
    {
        $this->tasks[$key] = $task;
    }
}
