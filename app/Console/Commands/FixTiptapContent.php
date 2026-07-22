<?php

namespace App\Console\Commands;

use App\Models\Formation;
use App\Models\Project;
use Illuminate\Console\Command;

class FixTiptapContent extends Command
{
    protected $signature = 'fix:tiptap-content';

    protected $description = 'Re-encode proprement les contenus Tiptap des projets et formations';

    public function handle()
    {
        $this->fixModel(Project::class, ['content', 'excerpt', 'problematic', 'solution', 'results']);
        $this->fixModel(Formation::class, ['content']);

        $this->info('Contenus corrigés.');
    }

    private function fixModel(string $modelClass, array $fields): void
    {
        $modelClass::all()->each(function ($record) use ($fields) {
            foreach ($fields as $field) {
                $raw = $record->getRawOriginal($field);
                if (is_string($raw)) {
                    $decoded = json_decode($raw, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        $record->setAttribute($field, $decoded); // le mutator ré-encode correctement
                    } else {
                        // Chaîne simple : on la transforme en document Tiptap minimal
                        $record->setAttribute($field, [
                            'type' => 'doc',
                            'content' => [
                                ['type' => 'paragraph', 'content' => [['type' => 'text', 'text' => $raw]]],
                            ],
                        ]);
                    }
                }
            }
            $record->saveQuietly();
        });
    }
}
