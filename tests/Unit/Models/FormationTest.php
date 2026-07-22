<?php

use App\Models\Formation;

it('can be created', function () {
    $formation = Formation::factory()->create([
        'title' => 'Test Formation',
    ]);

    expect($formation)->toBeInstanceOf(Formation::class)
        ->and($formation->title)->toBe('Test Formation')
        ->and($formation->slug)->not->toBeEmpty();
});

it('can render rich content for excerpt and content', function () {
    $formation = Formation::factory()->create();

    expect(method_exists($formation, 'renderRichContent'))->toBeTrue();
    expect($formation->renderRichContent('content'))->toBeString();
    expect($formation->renderRichContent('excerpt'))->toBeString();
});

it('returns plain text excerpt from tiptap structure', function () {
    $formation = Formation::factory()->create([
        'excerpt' => [
            'type' => 'doc',
            'content' => [
                [
                    'type' => 'paragraph',
                    'content' => [
                        ['type' => 'text', 'text' => 'Id vero nesciunt.'],
                    ],
                ],
            ],
        ],
    ]);

    expect($formation->getPlainTextExcerpt())->toBe('Id vero nesciunt.');
});
