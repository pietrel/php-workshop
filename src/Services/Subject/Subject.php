<?php

namespace Workshop\Services\Subject;

class Subject
{
    private array $history = [];

    public function operation(int $parameter): int
    {
        if ($parameter === 0) {
            throw new \InvalidArgumentException('Invalida argument.');
        }

        $result = $parameter + 1;
        $this->logHistory('operation-1', $parameter, $result);
        return $result;
    }

    public function getHistory(): array
    {
        return $this->history;
    }

    private function logHistory(string $operation, int $parameter, int $result): void
    {
        $this->history[] = [
            'operation' => $operation,
            'parameter' => $parameter,
            'result'    => $result,
        ];
    }
}
