<?php

namespace App\Concerns\Traits;

trait HasTiptapContent
{
    public function initializeHasTiptapContent()
    {
        // S'assure que même les attributs par défaut sont bien initialisés
        if (empty($this->attributes['content'])) {
            $this->attributes['content'] = '{"type":"doc","content":[]}';
        }
        if (empty($this->attributes['excerpt'])) {
            $this->attributes['excerpt'] = '{"type":"doc","content":[]}';
        }
    }

    public function getContentAttribute($value): array
    {
        return $this->normalizeTiptap($value);
    }

    public function setContentAttribute($value): void
    {
        $this->attributes['content'] = $this->prepareTiptapForDb($value);
    }

    public function getExcerptAttribute($value): array
    {
        return $this->normalizeTiptap($value);
    }

    public function setExcerptAttribute($value): void
    {
        $this->attributes['excerpt'] = $this->prepareTiptapForDb($value);
    }

    protected function normalizeTiptap($value): array
    {
        if (empty($value)) {
            return ['type' => 'doc', 'content' => []];
        }

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return [
                    'type' => 'doc',
                    'content' => [['type' => 'paragraph', 'content' => [['type' => 'text', 'text' => $value]]]],
                ];
            }
            $value = $decoded;
        }

        if (! is_array($value)) {
            return ['type' => 'doc', 'content' => []];
        }

        if (! isset($value['type'])) {
            $value['type'] = 'doc';
        }
        if (! isset($value['content'])) {
            $value['content'] = [];
        }

        return $value;
    }

    protected function prepareTiptapForDb($value): string
    {
        if (is_null($value) || $value === '') {
            return '{"type":"doc","content":[]}';
        }
        if (is_array($value)) {
            if (! isset($value['type'])) {
                $value['type'] = 'doc';
            }
            if (! isset($value['content'])) {
                $value['content'] = [];
            }

            return json_encode($value);
        }
        // Si c'est déjà une chaîne JSON valide, on la garde, sinon on l'encapsule
        $decoded = json_decode($value, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $value;
        }

        return json_encode(['type' => 'doc', 'content' => [['type' => 'paragraph', 'content' => [['type' => 'text', 'text' => $value]]]]]);
    }
}
