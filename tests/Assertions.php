<?php

namespace Tests;

use Carbon\Carbon;

trait Assertions
{
    public function assertArrayContains($expected, $array): void
    {
        foreach ($expected as $key => $value) {
            if (is_array($value)) {
                $this->assertArrayContains($expected[$key], $array[$key]);
            } elseif ($this->isAssoc($array)) {
                $this->assertEquals($expected[$key], $array[$key]);
            } else {
                $this->assertContains($value, $array);
            }
        }
    }

    public function assertSameDay($expected, $actual, $message = ''): void
    {
        $this->assertEquals(
            Carbon::make($expected)->toDateString(),
            Carbon::make($actual)->toDateString(),
            $message,
        );
    }

    public function assertSameDate($expected, $actual, $message = ''): void
    {
        $this->assertEquals(
            Carbon::make($expected)->toDateTimeString(),
            Carbon::make($actual)->toDateTimeString(),
            $message,
        );
    }

    private function isAssoc(array $array): bool
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }
}
