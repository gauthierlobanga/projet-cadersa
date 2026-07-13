<?php

use function Pest\Laravel\get;

it('loads the home page', function () {
    get('/')->assertOk();
});

it('loads the about page', function () {
    get('/about')->assertOk();
});

it('loads the contact page', function () {
    get('/contact')->assertOk();
});

it('loads the gallery page', function () {
    get('/gallery')->assertOk();
});

it('loads the services page', function () {
    get('/services')->assertOk();
});

it('loads the projects page', function () {
    get('/projects')->assertOk();
});

it('loads the posts page', function () {
    get('/posts')->assertOk();
});

it('loads the legal pages', function () {
    get('/mentions-legales')->assertOk();
    get('/politique-confidentialite')->assertOk();
    get('/conditions-utilisation')->assertOk();
    get('/cookies')->assertOk();
});
