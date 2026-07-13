<?php

use App\Models\Post;
use App\Models\Project;

return [
    'feeds' => [
        'posts' => [
            'items' => [Post::class, 'getFeedItems'],
            'url' => '/feed/posts',
            'title' => 'CADERSA ASBL - Articles et Actualités',
            'description' => 'Toutes les actualités et publications de CADERSA.',
            'language' => 'fr-FR',
            'image' => '',
            'format' => 'rss',
            'view' => 'feed::rss',
            'type' => 'application/rss+xml',
            'contentType' => '',
        ],
        'projects' => [
            'items' => [Project::class, 'getFeedItems'],
            'url' => '/feed/projects',
            'title' => 'CADERSA ASBL - Projets',
            'description' => 'Découvrez les projets récents de CADERSA.',
            'language' => 'fr-FR',
            'image' => '',
            'format' => 'rss',
            'view' => 'feed::rss',
            'type' => 'application/rss+xml',
            'contentType' => '',
        ],
    ],
];
