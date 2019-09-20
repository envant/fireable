<?php

namespace Envant\Fireable\Tests;

use Envant\Fireable\Tests\Events\EmailUpdated;
use Envant\Fireable\Tests\Events\StatusApproved;
use Envant\Fireable\Tests\Models\User;
use Envant\Fireable\Tests\TestCase;

class FireableAttributesTest extends TestCase
{
    public function testSetAnyValue()
    {
        $this->expectsEvents(EmailUpdated::class);

        $this->testUser->update([
            'email' => 'appleseed@example.net',
        ]);
    }

    public function testSetExpectedValue()
    {
        $this->expectsEvents(StatusApproved::class);

        $this->testUser->update([
            'status' => User::STATUS_APPROVED,
        ]);
    }
}
