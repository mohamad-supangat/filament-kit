<?php

namespace App\Helpers;

class Alert
{
    public static function make(bool $success, ?string $message)
    {
        session()->flash('success', $success);
        session()->flash('message', $message);
    }

    public static function makeThrowable($throwable)
    {
        session()->flash('success', false);
        session()->flash('message', $throwable->getMessage());
    }
}
