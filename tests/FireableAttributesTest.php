<?php

namespace Envant\Fireable\Tests;

use Envant\Fireable\Tests\Events\EmailUpdated;
use Envant\Fireable\Tests\Events\StatusApproved;
use Envant\Fireable\Tests\Models\User;
use Illuminate\Support\Facades\Event;

class FireableAttributesTest extends TestCase
{
    public function testSetAnyValue()
    {
        Event::fake(EmailUpdated::class);

        $this->testUser->update([
            'email' => 'appleseed@example.net',
        ]);

        Event::assertDispatched(EmailUpdated::class);
    }

    public function testSetExpectedValue()
    {
        Event::fake(StatusApproved::class);

        $this->testUser->update([
            'status' => User::STATUS_APPROVED,
        ]);

        Event::assertDispatched(StatusApproved::class);
    }
}
