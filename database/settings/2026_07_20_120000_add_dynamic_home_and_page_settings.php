<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $properties = [
            // Home page section titles and dynamic content
            'about.service_title' => '',
            'about.service_subtitle' => 'À travers notre approche 4B (Bonne cuisson, Bonne alimentation, Bonne planification familiale pour la Bonne santé), nous développons des solutions durables.',
            'about.formation_title' => 'Plongez au cœur de mes formations',
            'about.formation_subtitle' => 'En présentiel ou à distance, je vous accompagne dans la maîtrise du développement web moderne.',
            'about.partner_title' => 'Ensemble pour un impact durable',
            'about.partner_subtitle' => 'C’est grâce à la confiance et à l’engagement de nos partenaires que nous pouvons concrétiser nos actions sur le terrain.',
            'about.team_title' => 'Notre équipe',
            'about.team_subtitle' => 'Nous réunissons des talents passionnés, animés par l’envie de créer de la valeur et d’accompagner nos clients vers le succès.',

            'about.project_hero_badge' => 'Projets',
            'about.project_hero_title' => 'Des projets qui parlent d’eux-mêmes',
            'about.project_hero_subtitle' => 'De la conception à la mise en ligne, chaque réalisation illustre mon expertise en développement web full‑stack.',
            'about.project_content_title' => 'Nos réalisations',
            'about.project_content_subtitle' => 'Applications modernes, API robustes et interfaces soignées : voici un aperçu de notre savoir-faire.',
            'about.project_banner_title' => 'Projets sélectionnés',
            'about.project_banner_subtitle' => 'Des cas concrets qui mettent en lumière des solutions pensées pour le terrain.',

            'about.blog_hero_badge' => 'Blog & Actualités',
            'about.blog_hero_title' => 'Le pouls de CADERSA ASBL',
            'about.blog_hero_subtitle' => 'Retrouvez des articles, des nouvelles et des ressources pour mieux comprendre nos actions et nos engagements.',
            'about.blog_content_title' => 'Actualités et savoir-faire',
            'about.blog_content_subtitle' => 'Des contenus pensés pour partager nos retours d’expérience et nos apprentissages.',
            'about.blog_banner_title' => 'Ressources utiles',
            'about.blog_banner_subtitle' => 'Des billets et des guides pour appuyer vos projets de développement et d’agriculture durable.',

            'about.author_home' => 'Full-Stack Web Developer',
            'about.auteur_about' => 'Gauthier Lobanga',
            'about.citation_footer' => 'Vivre c’est reconnaître ses semblables créés à l’image de Dieu. — Prof. Dr Bernard HANGI',

            // Contact page dynamic content
            'app.contact_hero_badge' => 'Nous contacter',
            'app.contact_hero_title' => 'Parlons de votre projet',
            'app.contact_hero_subtitle' => 'Notre équipe est disponible pour répondre à toutes vos questions et vous accompagner dans vos projets de développement rural.',
            'app.contact_form_heading' => 'Envoyez-nous un message',
            'app.contact_form_description' => 'Remplissez le formulaire ci-dessous, nous vous répondrons dans les plus brefs délais.',
            'app.contact_support_title' => 'Un accompagnement sur mesure',
            'app.contact_support_description' => 'Notre équipe traite chaque demande avec attention. Réponse rapide, suivi personnalisé et solutions adaptées à vos besoins.',
            'app.contact_offices_title' => 'Nos bureaux',

            // Static policy and legal page headers
            'cookie.hero_badge' => 'Confidentialité',
            'cookie.hero_title' => 'Gestion des Cookies',
            'cookie.hero_subtitle' => 'Comment nous utilisons les cookies pour améliorer votre expérience de navigation.',

            'legal.hero_badge' => 'Informations Juridiques',
            'legal.hero_title' => 'Mentions Légales',
            'legal.hero_subtitle' => 'Transparence et conformité concernant l’édition et l’hébergement du site de CADERSA ASBL.',

            'privacy.hero_badge' => 'Données Personnelles',
            'privacy.hero_title' => 'Politique de Confidentialité',
            'privacy.hero_subtitle' => 'Nous accordons une importance primordiale à la protection et au respect de vos données personnelles.',

            'terms.hero_badge' => 'Règles d’Usage',
            'terms.hero_title' => 'Conditions d’Utilisation',
            'terms.hero_subtitle' => 'Les règles régissant l’utilisation de la plateforme web de CADERSA ASBL.',
        ];

        foreach ($properties as $key => $value) {
            if (! $this->migrator->exists($key)) {
                $this->migrator->add($key, $value);
            }
        }
    }
};
