# CADERSA-ASBL — Documentation complète

Ce document décrit l'architecture, l'installation, la configuration, les tests, la sécurité et les points importants pour le projet CADERSA-ASBL (application Laravel + Livewire/Volt + Vite).

---

## Table des matières

1. Vue d'ensemble
2. Structure du dépôt
3. Installation et configuration locale
4. Commandes courantes
5. Tests et analyses statiques
6. Sécurité (en-têtes, secrets, CSP)
7. Frontend (Vite, Livewire, Alpine, GSAP)
8. Composant cookie-consent
9. Déploiement
10. Surveillance et collecte de rapports CSP
11. Bonnes pratiques et checklist avant production
12. Contacts / Ressources

---

## 1) Vue d'ensemble

Application Laravel moderne (v13) utilisant:

- PHP 8.4
- Livewire (volt/livewire) pour composants côté serveur
- Vite pour bundling JS/CSS
- Tailwind pour le style
- Spatie MediaLibrary pour médias
- Spatie Laravel Settings pour configuration persistée

Objectif: site institutionnel avec contenu éditable (posts, projects, services), gestion médias (PDFs/images) et consentement cookies.

---

## 2) Structure du dépôt (points clés)

- app/ : code applicatif (Models, Http/Middleware, Settings, etc.)
  - app/Http/Middleware/SecurityHeaders.php — middleware de sécurité (CSP, HSTS, X-Frame-Options...) — patché pour séparer local/production et supporter report-only
  - app/Models/ — modèles Eloquent (Post, Project, Service, User...)
  - app/Settings/ — classes Spatie\LaravelSettings
- resources/js/ — point d'entrée JS (Vite)
- resources/views/ — vues Blade et composants
  - resources/views/components/cookie-consent.blade.php — composant cookie
- routes/ — routes web/api
- bootstrap/app.php — enregistrement du middleware SecurityHeaders
- storage/logs/browser.log — logs d'erreurs frontend collectés par le runtime

---

## 3) Installation & configuration locale

Pré-requis:

- PHP 8.4 + extensions usuelles
- Composer
- Node.js (version compatible avec le fichier package.json)
- Redis / MySQL/Postgres selon config .env

Étapes de base:

1. Copier .env.example -> .env et configurer DB et clés
2. composer install
3. npm ci
4. php artisan key:generate
5. php artisan migrate --seed (si requis)
6. npm run dev (pour développement) ou npm run build (production)
7. php artisan serve ou démarrer via votre serveur (nginx/apache)

Fichiers de config utiles à vérifier:

- config/app.php — ajouter la clé `'csp_report_uri' => env('CSP_REPORT_URI', null),` si vous souhaitez centraliser la config CSP

---

## 4) Commandes courantes

- Installer dépendances PHP: `composer install`
- Installer dépendances JS: `npm ci`
- Lancer dev server Vite: `npm run dev`
- Builder pour prod: `npm run build`
- Lancer tests: `php artisan test --compact` (Pest/PHPUnit)
- Lancer PHPStan: `vendor/bin/phpstan analyse`
- Lancer Pint (format): `vendor/bin/pint --parallel --format=agent`
- Exécuter Pint et PHPStan avant commit

---

## 5) Tests & analyses statiques

- Pest/PHPUnit: la suite de tests se trouve sous tests/ (Feature, Unit). Exécuter `php artisan test`.
- PHPStan (via vendor/bin/phpstan) pour l'analyse statique; corriger les erreurs plutôt que de les ignorer.
- Laravel Pint pour formatage automatique.

A noter: des corrections récentes ont été appliquées pour fixer des erreurs PHPStan liées à des collections/retours non typés et à Spatie\LaravelSettings.

---

## 6) Sécurité (en-têtes, secrets, CSP)

Résumé des modifications / recommandations:

- Middleware: `app/Http/Middleware/SecurityHeaders.php`
  - Environnement local/testing: politique CSP relâchée (permet Vite/HMR et développement rapide)
  - Environnement production: CSP stricte (suppression de 'unsafe-inline' et 'unsafe-eval') et génération d'un nonce par requête exposé via l'en-tête `X-CSP-Nonce`.
  - Report-only: si `config('app.csp_report_uri')` (défini via .env CSP_REPORT_URI) est présent, le middleware envoie aussi `Report-To` et `Content-Security-Policy-Report-Only` pour collecter les violations en phase de test.
  - Remplacement des appels `env()` par `config()` pour être compatible avec le cache de configuration (évite erreurs Larastan/PHPStan).

- Autres en-têtes présents: `X-Frame-Options`, `X-Content-Type-Options`, `Referrer-Policy`, `Permissions-Policy`, HSTS (activé uniquement en production HTTPS).

- CSP & Nonces:
  - Pour scripts inline autorisés de manière sûre: `<script nonce="{{ request()->header('X-CSP-Nonce') }}">...</script>`
  - Préférence: bundle les scripts avec Vite pour éviter les inline.

- Secrets:
  - NE JAMAIS committer `.env`. Si `.env` a été poussé, retirer du Git (`git rm --cached .env`) et rotater `APP_KEY` et toutes API keys exposées.
  - Utiliser un secret manager en production.

---

## 7) Frontend: Livewire, Alpine, GSAP, Vite

Points importants:

- Ordre de chargement: Livewire doit être disponible avant d'évaluer certains bindings `@entangle`. Les erreurs "Cannot read properties of undefined (reading 'entangle')" viennent souvent d'une initialisation Alpine/Livewire trop tôt.
- Correction appliquée: exposition des plugins GSAP/SplitText/globales dans `resources/js/app.js` et déplacement des initialisations Alpine délicates dans du JS qui s'attache après l'événement `livewire:load`.
- Vite (dev) nécessite souvent des CSP plus permissives; en production CSP stricte sans unsafe-* est appliquée.

---

## 8) Composant cookie-consent

Fichiers clés:

- resources/views/components/cookie-consent.blade.php
- Logic in resources/js/app.js (registering Alpine data safely)

Problèmes résolus:

- Modal restait ouvert: causé par initialisation Alpine inline avec `@entangle` évalué avant Livewire. Solution: rendre l'affichage côté serveur (conditions `@if($showBanner)` / `@if($showPreferences)`) et déplacer l'init Alpine dans JS qui s'exécute après `livewire:load`.
- Vérifier les classes utilitaires CSS du wrapper (pointer-events) — corrigées pour permettre le clic sur le bouton de fermeture.

Guide rapide pour tests manuels:

1. Ouvrir la page d'accueil en mode dev
2. Vérifier le banner/modal cookie apparaît
3. Cliquer sur fermer / accepter / preferences — confirmer que le modal se ferme et que l'état est persistant (via cookie ou Livewire)

---

## 9) Déploiement (checklist)

Avant déploiement en production:

- Supprimer les fichiers sensibles du repo, rotater les clés si exposées
- `composer install --no-dev --optimize-autoloader`
- `npm ci && npm run build`
- `php artisan config:cache && php artisan route:cache && php artisan view:cache`
- S'assurer que `APP_ENV=production`, `APP_DEBUG=false`
- Vérifier CSP_REPORT_URI en staging pour collecter violations
- Activer HSTS uniquement si l'app est derrière HTTPS
- Mettre en place un monitoring d'erreurs (Sentry, LogRocket, etc.)

---

## 10) Collecte des rapports CSP

- Définir `CSP_REPORT_URI` dans .env (ou config/app.php via csp_report_uri) pour envoyer les rapports.
- En staging, le middleware enverra `Content-Security-Policy-Report-Only` + `Report-To` afin de collecter info sans bloquer les utilisateurs.
- Après observation, passer en enforcement en production (retirer report-only).

---

## 11) Bonnes pratiques & checklist rapide avant mise en prod

- Lancer: `vendor/bin/phpstan analyse` et corriger toutes les erreurs.
- Lancer: `vendor/bin/pint --parallel --format=agent` pour formater.
- Lancer: `php artisan test --compact` et corriger les tests échoués.
- Revoir CSP pour éviter unsafe-* en production; utiliser nonces ou hashs.
- Retirer `APP_DEBUG` (mettre false) et vérifier logs.
- Vérifier que Livewire/Alpine initialisations n'utilisent pas `@entangle` avant `livewire:load`.

---

## 12) Contacts / ressources

- Mainteneur principal: [@gauthierlobanga]
- Docs utiles:
  - Laravel: <https://laravel.com/docs>
  - Livewire: <https://laravel-livewire.com/docs>
  - Vite + Laravel: <https://laravel.com/docs/vite>
  - Spatie Laravel Settings: <https://spatie.be/docs/laravel-settings>
  - OWASP CSP guide: <https://owasp.org/www-project-cheat-sheets/cheatsheets/Content_Security_Policy_Cheat_Sheet.html>
  - Filament v5: <https://filamentphp.com/>

---
