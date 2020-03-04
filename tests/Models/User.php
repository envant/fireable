<?php

namespace Envant\Fireable\Tests\Models;

use Envant\Fireable\FireableAttributes;
use Envant\Fireable\Tests\Events\EmailUpdated;
use Envant\Fireable\Tests\Events\StatusApproved;
use Envant\Fireable\Tests\Events\StatusRejected;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use FireableAttributes;

    /** @var array */
    protected $fillable = [
        'id', 'email', 'status',
    ];

    /** @var array */
    protected $fireableAttributes = [
        'email' => EmailUpdated::class,
        'status' => [
            self::STATUS_APPROVED => StatusApproved::class,
            self::STATUS_REJECTED => StatusRejected::class,
        ],
    ];

    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';
}
