<?php

use function Pest\Laravel\get;

beforeEach(function (): void {
    $this->withoutVite();
});

it('renders stable Livewire result updates for posts filtering and sorting', function (): void {
    get('/posts')
        ->assertOk()
        ->assertSee('wire:model.live.debounce.250ms.preserve-scroll="search"', false)
        ->assertSee('wire:model.live.preserve-scroll="category"', false)
        ->assertSee('wire:click.preserve-scroll="$set(\'sort\',', false)
        ->assertSee('wire:target="search,category,sort,clearFilters,gotoPage,nextPage,previousPage"', false)
        ->assertSee('wire:loading.delay', false)
        ->assertSee('min-h-[34rem]', false)
        ->assertDontSee('autoAnimate($el', false);
});
