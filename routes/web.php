<?php

use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\site\SitemapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
// ==================== Routes principales ====================
// Rediriger l'ancienne URL de connexion Filament vers la page de connexion publique
Route::redirect('/admin/login', '/login');
Route::livewire('/', 'pages::site.home')->name('home');
Route::livewire('/about', 'pages::site.about')->name('about');
Route::livewire('/contact', 'pages::site.contact')->name('contact');
Route::livewire('/gallery', 'pages::site.gallery')->name('gallery');

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
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::feeds();

require __DIR__.'/settings.php';
