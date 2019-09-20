<?php

namespace Envant\Fireable\Tests\Events;

use Envant\Fireable\Tests\Models\User;
use Illuminate\Queue\SerializesModels;

class StatusApproved
{
    use SerializesModels;

    /** @var User */
    public $user;

    /** @param User $user */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
