<?php

use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Dashboard\DashboardOverviewController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\Reports\ReportFileController;
use App\Http\Controllers\site\SitemapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
// ==================== Routes principales ====================
Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])
    ->middleware('throttle:10,1')
    ->name('auth.google.redirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])
    ->middleware('throttle:10,1')
    ->name('auth.google.callback');
Route::livewire('/', 'pages::site.home')->name('home');
Route::livewire('/about', 'pages::site.about')->name('about');
Route::livewire('/contact', 'pages::site.contact')->name('contact');
Route::livewire('/gallery', 'pages::site.gallery')->name('gallery');
Route::get('/rapports/{report}/aperçu', [ReportFileController::class, 'preview'])->middleware(['auth', 'verified'])->name('reports.preview');
Route::get('/rapports/{report}/télécharger', [ReportFileController::class, 'download'])->middleware(['auth', 'verified'])->name('reports.download');

// ==================== Services ====================
Route::livewire('/services', 'pages::services.index')->name('services.index');
Route::livewire('/services/{service}', 'pages::services.show')->name('services.show');

// ==================== Formations ====================
Route::livewire('/formations', 'pages::formations.index')->name('formations.index');
Route::livewire('/formations/{formation:slug}', 'pages::formations.show')->name('formations.show');

// ==================== Projets ====================
Route::livewire('/projects', 'pages::projets.index')->name('projects.index');
Route::livewire('/projects/{project}', 'pages::projets.show')->name('projects.show');

// ==================== Articles / Actualités ====================
Route::livewire('/posts', 'pages::posts.index')->name('posts.index');
Route::livewire('/posts/{post:slug}', 'pages::posts.show')->name('posts.show');

// // ==================== Newsletter ====================
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/newsletter/confirm/{token}', [NewsletterController::class, 'confirm'])->name('newsletter.confirm');
Route::get('/newsletter/unsubscribe/{token}', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

// ==================== Pages légales ====================
Route::view('/mentions-legales', 'pages.legal')->name('legal');
Route::view('/politique-confidentialite', 'pages.privacy')->name('privacy');
Route::view('/conditions-utilisation', 'pages.terms')->name('terms');
Route::view('/cookies', 'pages.cookies')->name('cookies');

// ==================== Plan du site ====================
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::livewire('/search', 'pages::site.search')->name('search');

// Tableau de bord
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardOverviewController::class)->name('dashboard');
    Route::view('dashboard/rapports', 'dashboard.reports')->name('dashboard.reports');
});

Route::feeds();

require __DIR__.'/settings.php';
