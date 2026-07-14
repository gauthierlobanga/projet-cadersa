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

    public string $impact_heading = 'Des résultats concrets sur le terrain';

    public string $impact_subtitle = 'Programme de Résilience au Kasaï Central, avec le soutien du PAM.';

    public mixed $impact_description = null;

    public string $impact_highlight_heading = 'Renforcement de la chaîne de valeur agricole';

    public mixed $impact_highlight_text = null;

    public string $impact_highlight_cta_label = 'Lire le rapport complet';

    public string $impact_highlight_cta_url = '#';

    public array $impact_content = [];

    public array $impact_stats = [];

    public ?string $hero_image_url = null;

    /**
     * @return array
     */
    public static function defaultImpactStats(): array
    {
        return [
            [
                'value' => '5 000',
                'label' => 'Ménages Agricoles Soutenus',
                'description' => 'Producteurs et familles dont les moyens de subsistance ont été renforcés.',
                'image_url' => null,
                'icon' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z',
            ],
            [
                'value' => '1 500',
                'label' => 'Foyers Améliorés Confectionnés',
                'description' => 'Bénéficiaires d’espaces de vie plus sains et plus résistants.',
                'image_url' => null,
                'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
            ],
            [
                'value' => '18 ha',
                'label' => 'Reboisés par la Communauté',
                'description' => 'Terres replantées pour restaurer la biodiversité et capter le carbone.',
                'image_url' => null,
                'icon' => 'M12 14l9-5-9-5-9 5 9 5z',
            ],
            [
                'value' => '44',
                'label' => 'Unions Paysannes (UOP) Formées',
                'description' => 'Coopératives structurées et capables de négocier de meilleurs prix.',
                'image_url' => null,
                'icon' => 'M12 14l9-5-9-5-9 5 9 5z',
            ],
        ];
    }

    /**
     * @return array
     */
    public function getImpactStats(): array
    {
        if (empty($this->impact_stats)) {
            return self::defaultImpactStats();
        }

        return collect($this->impact_stats)
            ->map(function ($item) {
                if (is_array($item) && array_key_exists('data', $item)) {
                    return $item['data'];
                }

                return is_array($item) ? $item : [];
            })
            ->map(function ($data) {
                return array_merge([
                    'value' => $data['value'] ?? '',
                    'label' => $data['label'] ?? '',
                    'description' => $data['description'] ?? '',
                    'image_url' => $data['image_url'] ?? null,
                    'icon' => $data['icon'] ?? 'M12 14l9-5-9-5-9 5 9 5z',
                ], $data);
            })
            ->toArray();
    }

    /**
     * @return array
     */
    public function impactContent(): array
    {
        $item = $this->impact_content[0] ?? null;

        if (! is_array($item)) {
            return [
                'impact_heading' => $this->impact_heading,
                'impact_subtitle' => $this->impact_subtitle,
                'impact_description' => $this->impact_description,
                'impact_highlight_heading' => $this->impact_highlight_heading,
                'impact_highlight_text' => $this->impact_highlight_text,
                'impact_highlight_cta_label' => $this->impact_highlight_cta_label,
                'impact_highlight_cta_url' => $this->impact_highlight_cta_url,
            ];
        }

        return array_merge([
            'impact_heading' => $this->impact_heading,
            'impact_subtitle' => $this->impact_subtitle,
            'impact_description' => $this->impact_description,
            'impact_highlight_heading' => $this->impact_highlight_heading,
            'impact_highlight_text' => $this->impact_highlight_text,
            'impact_highlight_cta_label' => $this->impact_highlight_cta_label,
            'impact_highlight_cta_url' => $this->impact_highlight_cta_url,
        ], $item);
    }

    public function impactHeading(): string
    {
        return $this->impactContent()['impact_heading'] ?? $this->impact_heading;
    }

    public function impactSubtitle(): ?string
    {
        return $this->impactContent()['impact_subtitle'] ?? $this->impact_subtitle;
    }

    public function impactDescription(): mixed
    {
        return $this->impactContent()['impact_description'] ?? $this->impact_description;
    }

    public function impactHighlightHeading(): string
    {
        return $this->impactContent()['impact_highlight_heading'] ?? $this->impact_highlight_heading;
    }

    public function impactHighlightText(): mixed
    {
        return $this->impactContent()['impact_highlight_text'] ?? $this->impact_highlight_text;
    }

    public function impactHighlightCtaLabel(): string
    {
        return $this->impactContent()['impact_highlight_cta_label'] ?? $this->impact_highlight_cta_label;
    }

    public function impactHighlightCtaUrl(): string
    {
        return $this->impactContent()['impact_highlight_cta_url'] ?? $this->impact_highlight_cta_url;
    }

    public ?string $about_image_url = null;

    public static function group(): string
    {
        return 'about';
    }
}
