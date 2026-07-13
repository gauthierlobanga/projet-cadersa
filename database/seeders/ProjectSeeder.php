<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        // Créer quelques tags (ou s'assurer qu'ils existent)
        $tags = [
            'Sécurité alimentaire',
            'Développement rural',
            'Entrepreneuriat',
            'Autonomisation des femmes',
            'Cohésion sociale',
            'Protection',
            'Éducation',
            'Environnement',
            'Agroforesterie',
            'Réduction des risques',
            'Aide humanitaire',
            'Résilience',
            'Gouvernance foncière',
            'Formation',
        ];

        foreach ($tags as $name) {
            Tag::findOrCreate($name, 'project');
        }

        // Projet 1 : Renforcement des capacités et relèvement communautaire post-conflit (USAID/MSI)
        $project1 = Project::create([
            'title' => 'Renforcement des capacités et relèvement communautaire post-conflit',
            'slug' => Str::slug('Renforcement des capacités et relèvement communautaire post-conflit'),
            'excerpt' => 'Appui technique et financier de l’USAID via MSI pour le renforcement des capacités et le relèvement communautaire post-conflit dans les territoires de Kalehe et Masisi.',
            'content' => 'En 2018, le CADERSA a bénéficié des appuis techniques et financiers de l’USAID via MSI pour la mise en œuvre d’un projet de renforcement des capacités et de relèvement communautaire post-conflit. Ce projet a touché les villages de Kasheke, Tchofi, Bushushu, Nyabibwe, Mukwidja, Minova et Butumba au Sud-Kivu, ainsi que Bweremana et Masisi centre au Nord-Kivu. Il visait à restaurer la cohésion sociale, à réinsérer les ex-combattants et à relancer les activités économiques.',
            'location' => 'Sud-Kivu, Nord-Kivu',
            'status' => 'completed',
            'start_date' => '2018-03-01',
            'end_date' => '2019-02-28',
            'is_active' => true,
        ]);
        $project1->attachTags(['Sécurité alimentaire', 'Développement rural', 'Cohésion sociale', 'Résilience']);

        // Projet 2 : Entrepreneuriat solidaire des femmes, ex-combattants et jeunes (MONUSCO)
        $project2 = Project::create([
            'title' => 'Appui à l’entrepreneuriat solidaire des femmes, ex-combattants et jeunes désœuvrés',
            'slug' => Str::slug('Appui à l’entrepreneuriat solidaire des femmes, ex-combattants et jeunes désœuvrés'),
            'excerpt' => 'Projet soutenu par la MONUSCO pour l’insertion socio-économique des femmes vulnérables, ex-combattants et jeunes dans les zones minières et post-conflit.',
            'content' => 'Financé par la MONUSCO, ce projet a ciblé les femmes professionnelles de sexe, les veuves, les ex-combattants, les jeunes désœuvrés et les creuseurs miniers artisanaux. Il a permis de mettre en place des activités génératrices de revenus (AGR), des formations professionnelles et un accompagnement psychosocial dans les villages de Bushushu, Minova, Butumba et Nyabibwe.',
            'location' => 'Sud-Kivu (Kalehe, Idjwi)',
            'status' => 'completed',
            'start_date' => '2018-06-01',
            'end_date' => '2019-05-31',
            'is_active' => true,
        ]);
        $project2->attachTags(['Entrepreneuriat', 'Autonomisation des femmes', 'Formation']);

        // Projet 3 : Réduction des violences communautaires (CVR) – paix et cohésion sociale
        $project3 = Project::create([
            'title' => 'Réduction des violences communautaires pour la paix et la cohésion sociale',
            'slug' => Str::slug('Réduction des violences communautaires pour la paix et la cohésion sociale'),
            'excerpt' => 'Projet CVR de la MONUSCO visant à encourager le dépôt des armes, la réinsertion et le dialogue communautaire dans le groupement Mbinga Nord.',
            'content' => 'Ce projet a consisté à sensibiliser les populations du Groupement Mbinga Nord (Kalehe) sur la réduction des violences communautaires. Il a encouragé les combattants à quitter les groupes armés, facilité leur réinsertion, offert des alternatives économiques aux jeunes à risque, renforcé la cohésion sociale et organisé des cadres de concertation et de réconciliation.',
            'location' => 'Sud-Kivu (Kalehe)',
            'status' => 'completed',
            'start_date' => '2018-09-01',
            'end_date' => '2019-03-31',
            'is_active' => true,
        ]);
        $project3->attachTags(['Cohésion sociale', 'Protection', 'Résilience']);

        // Projet 4 : Intervention PAM/FAO 2019 – Sécurité alimentaire & renforcement des ménages agricoles
        $project4 = Project::create([
            'title' => 'Sécurité alimentaire et renforcement des ménages agricoles (PAM/FAO)',
            'slug' => Str::slug('Sécurité alimentaire et renforcement des ménages agricoles PAM/FAO'),
            'excerpt' => 'Extension des interventions du CADERSA avec l’appui du PAM et de la FAO pour améliorer la sécurité alimentaire et la nutrition dans les zones rurales du Sud-Kivu et Nord-Kivu.',
            'content' => 'Depuis 2019, le PAM et la FAO ont permis au CADERSA d’étendre ses actions de sécurité alimentaire et d’appui aux ménages agricoles. Les zones couvertes incluent Bweremana, Katebe, Nyakariba, Mweso au Nord-Kivu, ainsi que de nombreux villages du Sud-Kivu (Butumba, Minova, Kalungu, Numbi, Bushushu, etc.). Des distributions de vivres, des formations aux techniques agroécologiques et la réhabilitation de pistes rurales ont été réalisées.',
            'location' => 'Nord-Kivu, Sud-Kivu',
            'status' => 'ongoing',
            'start_date' => '2019-01-15',
            'end_date' => null,
            'is_active' => true,
        ]);
        $project4->attachTags(['Sécurité alimentaire', 'Développement rural', 'Agroforesterie']);

        // Projet 5 : Extension au Sud-Ubangi et Tanganyika (2022)
        $project5 = Project::create([
            'title' => 'Assistance alimentaire et résilience des communautés du Sud-Ubangi et du Tanganyika',
            'slug' => Str::slug('Assistance alimentaire et résilience des communautés du Sud-Ubangi et du Tanganyika'),
            'excerpt' => 'Avec l’appui du PAM, le CADERSA étend ses activités de résilience et de sécurité alimentaire aux provinces du Sud-Ubangi et du Tanganyika.',
            'content' => 'À partir de 2022, le PAM a permis au CADERSA d’intervenir dans les territoires de Kabalo (Tanganyika) et de nombreuses localités du Sud-Ubangi (Mbari, Bongbadaswa, Gbete, etc.). Les activités portent sur la distribution de vivres, l’appui aux cantines scolaires et la mise en place de champs communautaires.',
            'location' => 'Sud-Ubangi, Tanganyika',
            'status' => 'ongoing',
            'start_date' => '2022-03-01',
            'end_date' => null,
            'is_active' => true,
        ]);
        $project5->attachTags(['Sécurité alimentaire', 'Aide humanitaire', 'Éducation']);

        // Projet 6 : Développement des chaînes de valeur agricoles au Kasaï Central (2024)
        $project6 = Project::create([
            'title' => 'Chaînes de valeur agricoles résilientes au Kasaï Central',
            'slug' => Str::slug('Chaînes de valeur agricoles résilientes au Kasaï Central'),
            'excerpt' => 'Projet financé par le PAM pour renforcer la production agricole, la transformation et l’accès au marché dans le Kasaï Central.',
            'content' => 'Depuis 2024, le CADERSA met en œuvre un projet de développement des chaînes de valeur agricoles dans les territoires de Demba, Dimbelenge et Kazumba. Il vise à améliorer la productivité, faciliter l’accès aux intrants et aux marchés, et structurer les organisations paysannes. Les localités de Bena Leka, Mutoto, Luiza et Tshikaji sont concernées.',
            'location' => 'Kasaï Central',
            'status' => 'ongoing',
            'start_date' => '2024-01-10',
            'end_date' => null,
            'is_active' => true,
        ]);
        $project6->attachTags(['Développement rural', 'Entrepreneuriat', 'Sécurité alimentaire']);

        // Projet 7 : Reprise des interventions au Nord-Kivu (Masisi & Lubero) en 2026
        $project7 = Project::create([
            'title' => 'Relance des activités de sécurité alimentaire et de cohésion sociale au Nord-Kivu',
            'slug' => Str::slug('Relance des activités de sécurité alimentaire et de cohésion sociale au Nord-Kivu'),
            'excerpt' => 'Nouveau cycle d’interventions du CADERSA dans les territoires de Masisi et Lubero avec le soutien du PAM.',
            'content' => 'En 2026, le CADERSA a repris ses actions au Nord-Kivu, ciblant les populations vulnérables des territoires de Masisi et Lubero. Le projet combine distribution alimentaire, réhabilitation de routes de desserte agricole et activités génératrices de revenus pour les femmes et les jeunes.',
            'location' => 'Nord-Kivu (Masisi, Lubero)',
            'status' => 'planned',
            'start_date' => '2026-07-01',
            'end_date' => '2027-06-30',
            'is_active' => true,
        ]);
        $project7->attachTags(['Sécurité alimentaire', 'Cohésion sociale', 'Autonomisation des femmes']);

        // Projet 8 : Agroécologie et conservation de l’environnement (fictif mais inspiré du document)
        $project8 = Project::create([
            'title' => 'Agroécologie paysanne et conservation des écosystèmes',
            'slug' => Str::slug('Agroécologie paysanne et conservation des écosystèmes'),
            'excerpt' => 'Promotion des pratiques agroécologiques pour une sécurité alimentaire durable et la préservation des ressources naturelles.',
            'content' => 'Ce projet vise à former les communautés rurales aux techniques d’agroécologie, d’agroforesterie et de gestion durable des terres. Il couvre plusieurs villages du Sud-Kivu et du Kasaï Central, en lien avec la vision du CADERSA de bâtir des villages durables.',
            'location' => 'Sud-Kivu, Kasaï Central',
            'status' => 'planned',
            'start_date' => '2026-09-01',
            'end_date' => '2028-08-31',
            'is_active' => true,
        ]);
        $project8->attachTags(['Environnement', 'Agroforesterie', 'Formation', 'Sécurité alimentaire']);

        // Projet 9 : Gouvernance foncière et sécurisation des terres rurales
        $project9 = Project::create([
            'title' => 'Sécurisation foncière et gouvernance des terres rurales',
            'slug' => Str::slug('Sécurisation foncière et gouvernance des terres rurales'),
            'excerpt' => 'Appui à la reconnaissance des droits fonciers coutumiers et à la résolution des conflits fonciers en milieu rural.',
            'content' => 'En collaboration avec les autorités locales et les organisations paysannes, le CADERSA accompagne les communautés dans la cartographie participative, la médiation foncière et la sécurisation des terres agricoles. Le projet est actif dans le Tanganyika et le Sud-Ubangi.',
            'location' => 'Tanganyika, Sud-Ubangi',
            'status' => 'ongoing',
            'start_date' => '2025-05-01',
            'end_date' => null,
            'is_active' => true,
        ]);
        $project9->attachTags(['Gouvernance foncière', 'Développement rural', 'Cohésion sociale']);

        // Projet 10 : Éducation et formation des jeunes ruraux
        $project10 = Project::create([
            'title' => 'Éducation de qualité et insertion professionnelle des jeunes ruraux',
            'slug' => Str::slug('Éducation de qualité et insertion professionnelle des jeunes ruraux'),
            'excerpt' => 'Programme de formation professionnelle et d’alphabétisation fonctionnelle pour les jeunes déscolarisés en milieu rural.',
            'content' => 'Ce projet vise à réduire l’exode rural en offrant aux jeunes des formations techniques (agriculture, élevage, mécanique) et un accompagnement à la création de microentreprises. Il est mis en œuvre dans les provinces du Sud-Kivu et du Kasaï Central.',
            'location' => 'Sud-Kivu, Kasaï Central',
            'status' => 'ongoing',
            'start_date' => '2024-06-01',
            'end_date' => null,
            'is_active' => true,
        ]);
        $project10->attachTags(['Éducation', 'Entrepreneuriat', 'Formation']);
    }
}
