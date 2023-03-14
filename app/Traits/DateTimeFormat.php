<?php
namespace App\Traits;


trait DateTimeFormat
{
    /**
     * Prepare a date for array / JSON serialization.
     *
     * @return string
     */
    protected function serializeDate (\DateTimeInterface $date)
    {
        return $date->format ('Y-m-d H:i:s');
    }
}
