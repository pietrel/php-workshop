<?php

namespace Workshop\Actions\Subject;

use Workshop\Actions\ActionContract;
use Workshop\Actions\Traits\WithAttributes;

class Subject implements ActionContract
{
    use WithAttributes;

    public function execute(): int
    {
        return 1;
    }
}
