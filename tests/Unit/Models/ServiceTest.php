<?php

use App\Models\Service;

it('can be created', function () {
    $service = Service::factory()->create([
        'title' => 'Test Service',
    ]);

    expect($service)->toBeInstanceOf(Service::class)
        ->and($service->title)->toBe('Test Service')
        ->and($service->slug)->not->toBeEmpty();
});

it('has a renderRichContent method', function () {
    $service = Service::factory()->create();

    expect(method_exists($service, 'renderRichContent'))->toBeTrue();
    expect($service->renderRichContent('content'))->toBeString();
});
