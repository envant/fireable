<?php

namespace Envant\Fireable;

use Envant\Fireable\Facades\Fireable as FireableFacade;

trait FireableAttributes
{
    /**
     * Process attributes on model update.
     *
     * @return void
     */
    protected static function bootFireableAttributes()
    {
        static::updated(function ($model) {
            FireableFacade::processAttributes($model);
        });
    }

    /**
     * @return array
     */
    public function getFireableAttributes()
    {
        return $this->fireableAttributes;
    }
}
