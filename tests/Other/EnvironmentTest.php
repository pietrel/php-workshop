<?php

namespace Tests\Other;

use PHPUnit\Framework\TestCase;

class EnvironmentTest extends TestCase
{
    public function testEnvironment(): void
    {
        $this->assertEquals('http://localhost:8081', $_ENV['SLACK_URL']);
        $this->assertEquals('testing', $GLOBALS['APP_ENV']);
    }
}
