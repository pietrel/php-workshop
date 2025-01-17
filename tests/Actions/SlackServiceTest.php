<?php

namespace Tests\Feature\Actions\Slack;

use Tests\BaseTestCase;
use Workshop\Actions\Slack\AutoRenew;
use Workshop\Services\Slack\Sender;
use Workshop\Services\Slack\Service;

class SlackServiceTest extends BaseTestCase
{
    public function testSendToSlackClient()
    {
        $client = $this->createMock(Service::class);
        $client->expects($this->once())
            ->method('send')
            ->willReturn(true);

        $sender = new Sender($client);
        $sender->sendToSlack('Test message');
    }

    public function testAutoRenewValidationRules()
    {
        $submitContactAction = new AutoRenew();

        $validator = $this->invokeMethod($submitContactAction, 'validator', [[
            'uid'    => 1,
            'status' => true,
        ]]);

        $this->assertTrue($validator);

        $validator = $this->invokeMethod($submitContactAction, 'validator', [[
            'uid' => 1,
        ]]);

        $this->assertFalse($validator);
    }
}
