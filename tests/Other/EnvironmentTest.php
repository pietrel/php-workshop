<?php

namespace Tests\Other;

use Tests\BaseTestCase;

class EnvironmentTest extends BaseTestCase
{
    public function testEnvironment()
    {
        $this->assertEquals('http://localhost:8081', $_ENV['SLACK_URL']);
        $this->assertEquals('testing', $GLOBALS['APP_ENV']);
    }

}