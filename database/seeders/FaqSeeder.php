<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'Qui est Gauthier Lobanga ?',
                'answer' => 'Je suis développeur web full‑stack spécialisé Laravel, TALL stack (Tailwind, Alpine.js, Livewire, Laravel), Filament, React et Inertia.js. Je crée des applications web modernes, des APIs robustes et des panneaux d’administration sur mesure.',
                'sort_order' => 1,
            ],
            [
                'question' => 'Quelles technologies maîtrisez‑vous ?',
                'answer' => 'Mes technologies de prédilection sont Laravel, Livewire, Alpine.js, Tailwind CSS, FilamentPHP, React, Inertia.js, MySQL, PostgreSQL, Docker et Git. Je travaille également avec des outils comme Power BI pour l’analyse de données.',
                'sort_order' => 2,
            ],
            [
                'question' => 'Proposez‑vous des services de développement sur mesure ?',
                'answer' => 'Oui, je développe des applications web personnalisées : sites vitrines, plateformes e‑commerce, dashboards, APIs, applications monopages (SPA). Chaque projet est conçu pour répondre exactement à vos besoins.',
                'sort_order' => 3,
            ],
            [
                'question' => 'Comment se déroule une collaboration type ?',
                'answer' => 'Après un premier échange pour comprendre votre besoin, je rédige un cahier des charges et un devis. Le développement suit une méthodologie agile avec des points réguliers. Je livre le projet testé, documenté et prêt à être déployé.',
                'sort_order' => 4,
            ],
            [
                'question' => 'Travaillez‑vous à distance ?',
                'answer' => 'Tout à fait. Je collabore avec des clients en RDC et à l’international via des outils comme Slack, Trello, GitHub et des réunions en visioconférence. La communication est fluide quel que soit le fuseau horaire.',
                'sort_order' => 5,
            ],
            [
                'question' => 'Qu’est‑ce que le TALL stack ?',
                'answer' => 'Le TALL stack désigne l’association de Tailwind CSS, Alpine.js, Laravel et Livewire. Cet ensemble permet de construire rapidement des applications web modernes, réactives et élégantes, sans quitter l’écosystème Laravel.',
                'sort_order' => 6,
            ],
            [
                'question' => 'Pourquoi choisir FilamentPHP pour l’administration ?',
                'answer' => 'FilamentPHP est un outil incroyablement productif pour créer des panneaux d’administration. Il permet de gérer les ressources, les utilisateurs, les tableaux de bord et bien plus, avec une interface intuitive et un code propre.',
                'sort_order' => 7,
            ],
            [
                'question' => 'Proposez‑vous des formations en développement web ?',
                'answer' => 'Oui, je donne des formations en présentiel ou à distance sur Laravel, Livewire, Tailwind CSS, Filament, React, ainsi que sur la suite bureautique (Word, Excel, Power BI). Les formations sont adaptées à tous les niveaux.',
                'sort_order' => 8,
            ],
            [
                'question' => 'Pouvez‑vous intervenir sur un projet existant ?',
                'answer' => 'Absolument. Je réalise des audits de code, des optimisations de performances, des migrations de versions, des ajouts de fonctionnalités ou des refontes d’interfaces sur des projets Laravel ou React existants.',
                'sort_order' => 9,
            ],
            [
                'question' => 'Quels sont vos tarifs ?',
                'answer' => 'Mes tarifs varient en fonction de la complexité et de la durée du projet. Je propose un devis détaillé après une analyse de votre besoin. Pour les petits projets, je peux également travailler au forfait. Contactez‑moi pour en discuter.',
                'sort_order' => 10,
            ],
            [
                'question' => 'Comment garantissez‑vous la sécurité des applications ?',
                'answer' => 'La sécurité est au cœur de mes développements. J’applique les bonnes pratiques OWASP, j’utilise les mécanismes d’authentification intégrés de Laravel (Sanctum, Passport), je protège contre les injections SQL, XSS, CSRF et je configure des pipelines CI/CD avec tests automatisés.',
                'sort_order' => 11,
            ],
            [
                'question' => 'Utilisez‑vous le versionnement de code ?',
                'answer' => 'Oui, tous mes projets sont versionnés avec Git. J’utilise GitHub ou GitLab pour l’hébergement et la collaboration. Je mets en place une stratégie de branches claire (Git Flow) et des revues de code régulières.',
                'sort_order' => 12,
            ],
            [
                'question' => 'Proposez‑vous la maintenance après livraison ?',
                'answer' => 'Je propose des contrats de maintenance mensuels incluant la correction de bugs, les mises à jour de sécurité, l’hébergement (si nécessaire) et des évolutions mineures. Tout est défini dans une convention claire.',
                'sort_order' => 13,
            ],
            [
                'question' => 'Pouvez‑vous déployer une application en production ?',
                'answer' => 'Oui, je m’occupe du déploiement sur votre serveur ou sur des services cloud (DigitalOcean, AWS, Heroku). Je configure également Docker pour garantir un environnement stable et reproductible.',
                'sort_order' => 14,
            ],
            [
                'question' => 'Comment puis‑je vous contacter ?',
                'answer' => 'Vous pouvez me joindre par email à gauthier@example.com, via le formulaire de contact de ce site, ou sur LinkedIn. Je réponds généralement dans les 24 heures.',
                'sort_order' => 15,
            ],
            [
                'question' => 'Travaillez‑vous en équipe ou en solo ?',
                'answer' => 'Je travaille principalement en solo, mais je peux m’intégrer dans une équipe existante. J’ai l’habitude de collaborer avec d’autres développeurs, designers et chefs de projet.',
                'sort_order' => 16,
            ],
            [
                'question' => 'Quels types de projets avez‑vous déjà réalisés ?',
                'answer' => 'J’ai conçu des portfolios, des dashboards de gestion, des APIs REST, des sites e‑commerce, des blogs techniques, des systèmes de gestion de formations et des applications de suivi de projet freelance. Consultez la section “Projets” pour des exemples concrets.',
                'sort_order' => 17,
            ],
            [
                'question' => 'Acceptez‑vous les missions urgentes ?',
                'answer' => 'Oui, selon ma disponibilité. Je peux intervenir rapidement pour des corrections critiques ou des petits projets à délai court. N’hésitez pas à me contacter avec votre urgence.',
                'sort_order' => 18,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }

        $this->command->info('✅ '.count($faqs).' FAQs créées avec succès.');
    }
}
