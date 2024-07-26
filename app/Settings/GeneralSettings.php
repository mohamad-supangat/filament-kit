<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $name;

    // public ?array $excelDeliveryColumns;

    public static function group(): string
    {
        return 'general';
    }
}
