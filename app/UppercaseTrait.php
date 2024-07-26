<?php

namespace App;

trait UppercaseTrait
{
    /**
     * Set the name to uppercase.
     *
     * @param string $value
     *
     * @return void
     */
    public function setNameAttribute($value)
    {
        return $this->attributes['name'] = strtoupper($value);
    }
}
