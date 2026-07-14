<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class TermsSettings extends Settings
{
    /**
     * Terms content items
     *
     * @var string[]
     */
    public array $content = [];

    public static function group(): string
    {
        return 'terms';
    }
}
