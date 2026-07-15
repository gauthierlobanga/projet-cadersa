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

    // Contact information for the organisation (optional)
    public ?string $contact_email = null;

    public ?string $contact_phone = null;

    public ?string $address = null;

    public string $impact_subtitle = 'Programme de Résilience au Kasaï Central, avec le soutien du PAM.';

    public mixed $impact_description = null;

    public string $impact_highlight_heading = 'Renforcement de la chaîne de valeur agricole';

    public mixed $impact_highlight_text = null;

    public string $impact_highlight_cta_label = 'Lire le rapport complet';

    public string $impact_highlight_cta_url = '#';

    /**
     * Repeater items for impact content.
     *
     * Each item is an associative array with keys like
     * 'impact_heading', 'impact_subtitle', etc.
     *
     * @var string[]
     */
    public array $impact_content = [];

    /**
     * Builder blocks for impact stats.
     *
     * Each item may be a raw block array or a wrapper array with a 'data' key,
     * so elements are mixed at runtime.
     *
     * @var string[]
     */
    public array $impact_stats = [];

    /**
     * Content blocks for the About section (Builder blocks).
     *
     * @var string[]
     */
    public array $about_blocks = [];

    /**
     * @var string[]
     */
    public array $vision_blocks = [];

    /**
     * @var string[]
     */
    public array $mission_blocks = [];

    public ?string $hero_image_url = null;

    /**
     * @return string[]
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
     * @return string[]
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
     * Normalize builder payloads into plain block arrays.
     *
     * @param  string[]  $blocks
     * @return string[]
     */
    public static function normalizeBlocks(array $blocks): array
    {
        return collect($blocks)
            ->map(function ($block) {
                if (! is_array($block)) {
                    return [];
                }

                if (array_key_exists('data', $block) && is_array($block['data'])) {
                    return $block['data'];
                }

                return $block;
            })
            ->toArray();
    }

    /**
     * Return about blocks, or fallback to legacy `about_text`.
     *
     * @return string[]
     */
    public function aboutBlocks(): array
    {
        if (! empty($this->about_blocks)) {
            return self::normalizeBlocks($this->about_blocks);
        }

        if ($this->about_text !== null) {
            return [[
                'title' => null,
                'description' => $this->about_text,
                'image_url' => $this->about_image_url,
            ]];
        }

        return [];
    }

    /**
     * Return the primary about description (first block or legacy field).
     */
    public function aboutText(): ?string
    {
        $block = $this->aboutBlocks()[0] ?? null;

        return is_array($block) ? ($block['description'] ?? null) : $this->about_text;
    }

    /**
     * Return the primary about title.
     */
    public function aboutTitle(): ?string
    {
        $block = $this->aboutBlocks()[0] ?? null;

        return is_array($block) ? ($block['title'] ?? null) : null;
    }

    /**
     * Return vision blocks, or fallback to legacy `vision_text`.
     *
     * @return string[]
     */
    public function visionBlocks(): array
    {
        if (! empty($this->vision_blocks)) {
            return self::normalizeBlocks($this->vision_blocks);
        }

        if ($this->vision_text !== null) {
            return [[
                'title' => null,
                'description' => $this->vision_text,
                'image_url' => $this->about_image_url,
            ]];
        }

        return [];
    }

    /**
     * Return the primary vision description.
     *
     * @return string[]|string|null
     */
    public function visionText(): array|string|null
    {
        $block = $this->visionBlocks()[0] ?? null;

        return is_array($block) ? ($block['description'] ?? null) : $this->vision_text;
    }

    /**
     * Return mission blocks, or fallback to legacy `mission_text`.
     *
     * @return string[]
     */
    public function missionBlocks(): array
    {
        if (! empty($this->mission_blocks)) {
            return self::normalizeBlocks($this->mission_blocks);
        }

        if ($this->mission_text !== null) {
            return [[
                'title' => null,
                'description' => $this->mission_text,
                'image_url' => $this->about_image_url,
            ]];
        }

        return [];
    }

    /**
     * Return the primary mission description.
     *
     * @return string[]|string|null
     */
    public function missionText(): array|string|null
    {
        $block = $this->missionBlocks()[0] ?? null;

        return is_array($block) ? ($block['description'] ?? null) : $this->mission_text;
    }

    /**
     * @return string[]
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

    /**
     * @param  array<int, mixed>|null  $value
     */
    public function setImpactContentAttribute(?array $value): void
    {
        $this->impact_content = is_array($value) ? $value : [];
    }

    /**
     * @param  array<int, mixed>|null  $value
     */
    public function setImpactStatsAttribute(?array $value): void
    {
        $this->impact_stats = is_array($value) ? $value : [];
    }

    public function setAboutBlocksAttribute(?array $value): void
    {
        $this->about_blocks = self::normalizeBlocks($value ?? []);
    }

    public function setVisionBlocksAttribute(?array $value): void
    {
        $this->vision_blocks = self::normalizeBlocks($value ?? []);
    }

    public function setMissionBlocksAttribute(?array $value): void
    {
        $this->mission_blocks = self::normalizeBlocks($value ?? []);
    }

    public ?string $about_image_url = null;

    public static function group(): string
    {
        return 'about';
    }
}
