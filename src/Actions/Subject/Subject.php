<?php

namespace Workshop\Actions\Subject;

use Workshop\Actions\ActionContract;
use Workshop\Services\Operator\Operator;
use Workshop\Actions\Traits\WithAttributes;

class Subject implements ActionContract
{
    use WithAttributes;

    public function execute(): int
    {
        $service = new Operator();
        return $service->operation($this->attributes[0]);
    }
}