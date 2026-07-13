<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Planification de la génération du sitemap XML
use Illuminate\Support\Facades\Schedule;

Schedule::command('sitemap:generate')->daily();
