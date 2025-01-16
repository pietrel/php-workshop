<?php

namespace Tests;

trait Assertions
{
    public function assertArrayContains($expected, $array)
    {
        foreach ($expected as $key => $value) {
            if (is_array($value)) {
                $this->assertArrayContains($expected[$key], $array[$key]);
            } elseif (Arr::isAssoc($expected)) {
                $this->assertEquals($expected[$key], $array[$key]);
            } else {
                $this->assertContains($value, $array);
            }
        }
    }

    public function assertSameDay($expected, $actual, $message = '')
    {
        $this->assertEquals(
            Carbon::make($expected)->toDateString(),
            Carbon::make($actual)->toDateString(),
            $message
        );
    }

    public function assertSameDate($expected, $actual, $message = '')
    {
        $this->assertEquals(
            Carbon::make($expected)->toDateTimeString(),
            Carbon::make($actual)->toDateTimeString(),
            $message
        );
    }
}
