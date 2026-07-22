<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $properties = [
            'sections.service' => ['title' => null, 'subtitle' => null],
            'sections.formation' => ['title' => null, 'subtitle' => null],
            'sections.partner' => ['title' => null, 'subtitle' => null],
            'sections.project_hero' => [
                'title' => null,
                'subtitle' => null,
                'badge' => null,
                'content' => ['title' => null, 'subtitle' => null],
                'bandeau' => ['title' => null, 'subtitle' => null],
            ],
            'sections.team' => [
                'title' => null,
                'subtitle' => null,
                'content' => ['title' => null, 'subtitle' => null],
                'bandeau' => ['title' => null, 'subtitle' => null],
            ],
            'sections.blog_hero' => [
                'title' => null,
                'subtitle' => null,
                'badge' => null,
                'content' => ['title' => null, 'subtitle' => null],
                'bandeau' => ['title' => null, 'subtitle' => null],
            ],
            'sections.impact' => ['title' => null, 'subtitle' => null],
            'site.citation_footer' => null,
            'site.author_home' => null,
            'site.author_about' => null,
            'contact.hero' => [
                'title' => null,
                'subtitle' => null,
                'email' => null,
                'phone' => null,
            ],
            'contact.content' => [
                'title' => null,
                'subtitle' => null,
                'body' => null,
            ],
        ];

        foreach ($properties as $key => $value) {
            if (! $this->migrator->exists($key)) {
                $this->migrator->add($key, $value);
            }
        }
    }
};
