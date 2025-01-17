<?php

namespace Tests\Feature\Actions\Slack;

use Tests\BaseTestCase;
use Workshop\Actions\ActionContract;
use Workshop\Actions\Subject\Subject;

class SubjectTest extends BaseTestCase
{
    public function testSubjectContract()
    {
        $class = new Subject();
        $this->assertInstanceOf(ActionContract::class, $class);
    }

    public function testSubjectTrait()
    {
        $traits = class_uses(Subject::class);
        $this->assertContains('Workshop\Actions\Traits\WithAttributes', $traits);
    }

    public static function parameterProvider(): array
    {
        return [
            [
                [2, 3,],
                [3, 4,],
                [4, 5,],
            ],
        ];
    }

    /**
     * @dataProvider parameterProvider
     */
    public function testSubjectExecution($parameter): void
    {
        $subject = new Subject();
        $subject->attributes($parameter);
        $result = $subject->execute();
        $this->assertEquals($parameter[1], $result);
    }


}
