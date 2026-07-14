<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class AboutSettings extends Settings
{
    public string $hero_title = 'Bâtir des villages durables en RDC.';

    public string $hero_subtitle = 'Paix, Sympathie et Mieux-être.';

    public string $hero_badge = 'Depuis 2010';

    // Content can be a Tiptap document array or a plain string.
    public mixed $about_text = null;

    // Content can be a Tiptap document array or a plain string.
    public mixed $vision_text = null;

    // Content can be a Tiptap document array or a plain string.
    public mixed $mission_text = null;

    public ?string $hero_image_url = null;

    public ?string $about_image_url = null;

    public static function group(): string
    {
        return 'about';
    }
}
