<?php

use App\Models\PostCategory;

it('generates a valid posts index URL for the category', function () {
    $category = PostCategory::create([
        'nom' => 'Actualités',
        'slug' => 'actualites',
    ]);

    expect($category->url)
        ->toBe(route('posts.index', ['cat' => 'actualites']));
});

it('generates a sitemap tag using the posts index route with the category slug', function () {
    $category = PostCategory::create([
        'nom' => 'Actualités',
        'slug' => 'actualites',
    ]);

    $sitemapTag = $category->toSitemapTag();

    expect($sitemapTag->url)
        ->toBe(route('posts.index', ['cat' => 'actualites']));
});
