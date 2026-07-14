<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class LegalSettings extends Settings
{
    /**
     * Legal content items
     *
     * @var string[]
     */
    public array $content = [];

    public static function group(): string
    {
        return 'legal';
    }
}
