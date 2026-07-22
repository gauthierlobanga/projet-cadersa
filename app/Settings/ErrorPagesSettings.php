<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class ErrorPagesSettings extends Settings
{
    public array $pages = [];

    public static function group(): string
    {
        return 'error_pages';
    }
}
