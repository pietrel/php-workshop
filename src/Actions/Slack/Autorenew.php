<?php

namespace Workshop\Actions\Slack;

use Workshop\Services\Slack;
use Workshop\Actions\ActionContract;
use GuzzleHttp\Exception\GuzzleException;
use Workshop\Actions\Traits\WithAttributes;

class AutoRenew implements ActionContract
{
    use WithAttributes;

    public function execute(): void
    {
        if ($this->validator($this->attributes)) {
            $uid = $this->attributes['uid'];
            $status = $this->attributes['status'] ? 'aktivert' : 'deaktivert';
            $message = "Automatisk fornyelse $status av bruker (uid: $uid)";

            $service = new Slack\Service();
            $sender = new Slack\Sender($service);
            try {
                $sender->sendToSlack($message);
            } catch (GuzzleException $e) {
                // Log error
            }
        }
    }

    private function validator($attributes): bool
    {
        return $this->arrayHasFields(
            $attributes,
            [
                'uid',
                'status',
            ],
        );
    }
}