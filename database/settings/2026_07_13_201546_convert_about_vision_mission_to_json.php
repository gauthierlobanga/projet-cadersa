<?php

use Illuminate\Support\Facades\DB;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        // Convert existing string values to Tiptap JSON format
        $fields = ['about.vision_text', 'about.mission_text'];

        foreach ($fields as $field) {
            $row = DB::table('settings')
                ->where('group', 'about')
                ->where('name', str_replace('about.', '', $field))
                ->first();

            if ($row) {
                $currentValue = json_decode($row->payload, true);

                // If it's already an array/JSON with 'type' => 'doc', skip
                if (is_array($currentValue) && isset($currentValue['type'])) {
                    continue;
                }

                // Convert string (possibly HTML) to Tiptap JSON
                $text = is_string($currentValue) ? $currentValue : '';

                if (empty($text)) {
                    $tiptap = ['type' => 'doc', 'content' => []];
                } else {
                    // Wrap existing HTML content in a Tiptap doc structure
                    $tiptap = [
                        'type' => 'doc',
                        'content' => [
                            [
                                'type' => 'paragraph',
                                'content' => [
                                    ['type' => 'text', 'text' => strip_tags($text)],
                                ],
                            ],
                        ],
                    ];
                }

                DB::table('settings')
                    ->where('group', 'about')
                    ->where('name', str_replace('about.', '', $field))
                    ->update(['payload' => json_encode($tiptap)]);
            }
        }
    }
};
