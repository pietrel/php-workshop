<?php

namespace Workshop\Actions\Traits;

trait WithAttributes
{
    private array $attributes;

    public function withAttributes(array $attributes): static
    {
        $this->attributes = $attributes;

        return $this;
    }
}
