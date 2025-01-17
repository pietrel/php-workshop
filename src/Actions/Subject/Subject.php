<?php

namespace Workshop\Actions\Subject;

use Workshop\Actions\ActionContract;
use Workshop\Actions\Traits\WithAttributes;
use Workshop\Services\Operator\Operator;

class Subject implements ActionContract
{
    use WithAttributes;

    public function execute(): int
    {
        $service = new Operator();
        return $service->operation($this->attributes[0]);
    }
}
