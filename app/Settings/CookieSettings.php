<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class CookieSettings extends Settings
{
    public string $hero_badge = '';

    public string $hero_title = '';

    public string $hero_subtitle = '';

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
