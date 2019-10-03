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
     * Match updated attributes with fireable ones and trigger events.
     *
     * @param \Envant\Fireable\FireableAttributes|Model $model
     * @return void
     */
    public function processAttributes(Model $model): void
    {
        $this->model = $model;
        $this->fireableAttributes = $this->model->getFireableAttributes();
        $this->updatedAttributes = $this->getUpdatedFireableAttributes();

        $this->dispatchEvents();
    }

    /**
     * Get a list of the attributes that were updated and have specified events.
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
     * Dispatch events for matched attributes.
     *
     * @return void
     */
    private function dispatchEvents(): void
    {
        foreach ($this->updatedAttributes as $attribute => $value) {
            if ($eventName = $this->getEventName($attribute, $value)) {
                event(new $eventName($this->model));
            }
        }
    }

    /**
     * Get event name for specified attribute and assigned value pair.
     *
     * @param string $attribute
     * @param mixed $value
     * @return string|null
     */
    private function getEventName(string $attribute, $value): ?string
    {
        return $this->getEventNameForAttribute($attribute)
            ?? $this->getEventNameForExactValue($attribute, $value);
    }

    /**
     * Get event name if values are not specified.
     *
     * @param string $attribute
     * @return string|null
     */
    private function getEventNameForAttribute(string $attribute): ?string
    {
        return is_string($this->fireableAttributes[$attribute])
            && class_exists($this->fireableAttributes[$attribute])
            ? $this->fireableAttributes[$attribute]
            : null;
    }

    /**
     * Get event name if there are specified values.
     *
     * @param string $attribute
     * @param mixed $value
     * @return string|null
     */
    private function getEventNameForExactValue(string $attribute, $value): ?string
    {
        return is_array($this->fireableAttributes[$attribute])
            && isset($this->fireableAttributes[$attribute][$value])
            ? $this->fireableAttributes[$attribute][$value]
            : null;
    }
}
