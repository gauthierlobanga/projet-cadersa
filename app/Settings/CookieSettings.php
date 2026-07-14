<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class CookieSettings extends Settings
{
    /**
     * Cookie content items
     *
     * @var string[]
     */
    public array $content = [];

    public static function group(): string
    {
        return 'cookie';
    }
}
