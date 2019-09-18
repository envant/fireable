<?php

namespace Envant\Fireable;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;

class Fireable
{
    /** @var array */
    protected $fireableAttributes = [];

    /** @var array */
    protected $updatedAttributes = [];

    /** @var Model */
    protected $model;

    /**
     * Match updated attributes with fireable ones and trigger events
     *
     * @param Model $model
     * @return void
     */
    public function processAttributes(Model $model): void
    {
        $this->model = $model;
        $this->fireableAttributes = $this->model->getFireableAttributes();
        $this->updatedAttributes = $this->getUpdatedFireableAttributes($this->model);

        $this->fireEvents();
    }

    /**
     * Get a list of the attributes that were updated and have specified events
     *
     * @return array
     */
    private function getUpdatedFireableAttributes(): array
    {
        // get a list of updated attributes
        $updatedAttributes = $this->model->getDirty();

        // get a list of updated attributes that should trigger events
        $updatedFireableAttributes = Arr::only($updatedAttributes, array_keys($this->fireableAttributes));

        return $updatedFireableAttributes;
    }

    /**
     * Trigger events for matched attributes
     *
     * @return void
     */
    private function fireEvents(): void
    {
        foreach ($this->updatedAttributes as $attribute => $value) {
            if (is_array($this->fireableAttributes[$attribute]) && isset($this->fireableAttributes[$attribute][$value])) {
                $eventName = $this->fireableAttributes[$attribute][$value];
            } elseif (is_string($this->fireableAttributes[$attribute]) && class_exists($this->fireableAttributes[$attribute])) {
                $eventName = $this->fireableAttributes[$attribute];
            } else {
                continue;
            }

            event(new $eventName($this->model));
        }
    }
}
