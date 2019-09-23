<?php

namespace Envant\Fireable;

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
            (new Fireable)->processAttributes($model);
        });
    }

    /**
     * Get a list of model's "fireable" attributes
     * @return array
     */
    public function getFireableAttributes()
    {
        return $this->fireableAttributes;
    }
}
