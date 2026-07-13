<?php

namespace App\Support\Branding;

use App\Settings\SettingApp;
use Throwable;

/**
 * Classe utilitaire pour la gestion des favicons dynamiques.
 * Gère la résolution des favicons en fonction du contexte (Central ou editeur/Tenant).
 */
final class Favicon
{
    /**
     * Récupère l'URL absolue du favicon pour le contexte actuel.
     * Si un tenant est actif (ex: boutique editeur), retourne le favicon du tenant.
     * Sinon (ex: marketplace centrale), retourne le favicon de l'application centrale.
     *
     * @return string L'URL absolue du favicon.
     */
    public static function currentUrl(): string
    {
        return self::centralUrl();
    }

    /**
     * Récupère l'URL absolue du favicon pour l'application centrale.
     * Utilise les paramètres Spatie (SettingApp) pour trouver le logo global.
     * En cas d'absence, retourne le favicon.ico par défaut.
     *
     * @return string L'URL absolue du favicon central.
     */
    public static function centralUrl(): string
    {
        try {
            $logoUrl = app(SettingApp::class)->logoUrl();
        } catch (Throwable) {
            $logoUrl = null;
        }

        return $logoUrl ? asset($logoUrl) : asset('favicon.ico');
    }
}
