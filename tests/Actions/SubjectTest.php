<?php

namespace Tests\Feature\Actions\Slack;

use Tests\BaseTestCase;
use Workshop\Actions\ActionContract;
use Workshop\Actions\Subject\Subject;

class SubjectTest extends BaseTestCase
{
    public function testSubjectContract(): void
    {
        $class = new Subject();
        $this->assertInstanceOf(ActionContract::class, $class);
    }

    public function testSubjectTrait(): void
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
        $result = $subject->withAttributes($parameter)->execute();
        $this->assertEquals($parameter[1], $result);
    }


}
