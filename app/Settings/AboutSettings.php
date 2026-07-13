<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class AboutSettings extends Settings
{
    public string $hero_title = 'Bâtir des villages durables en RDC.';

    public string $hero_subtitle = 'Paix, Sympathie et Mieux-être.';

    public string $hero_badge = 'Depuis 2010';

    public string $about_text = '';

    public string $vision_text = '';

    public string $mission_text = '';

    public ?string $hero_image_url = null;

    public ?string $about_image_url = null;

    public static function group(): string
    {
        return 'about';
    }
}
