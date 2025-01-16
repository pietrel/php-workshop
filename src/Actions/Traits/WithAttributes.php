<?php

namespace Workshop\Actions\Traits;

trait WithAttributes
{
    private array $attributes;

    public function attributes(array $attributes): static
    {
        $this->attributes = $attributes;

        return $this;
    }

    function arrayHasFields(array $array, array $requiredFields): bool
    {
        foreach ($requiredFields as $field) {
            if (!array_key_exists($field, $array)) {
                return false;
            }
        }
        return true;
    }
}
