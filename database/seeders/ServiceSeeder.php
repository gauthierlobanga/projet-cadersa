<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'Sécurité Alimentaire, Nutrition & Enfance Vulnérable',
                'excerpt' => 'Agriculture, pêche et élevage pour une sécurité alimentaire durable.',
                'content' => 'Ce domaine regroupe l’ensemble des actions menées pour améliorer la sécurité alimentaire et la nutrition des populations, en particulier les enfants vulnérables. Il couvre la production agricole vivrière et maraîchère, la pêche continentale, l’élevage de petits ruminants et la volaille. Des formations aux techniques agroécologiques sont dispensées pour accroître les rendements tout en préservant les ressources naturelles. La sensibilisation à une alimentation équilibrée et diversifiée est également au cœur du programme, avec un suivi nutritionnel des enfants de moins de cinq ans.',
                'icon' => 'fa-solid fa-wheat-awn',
                'sort_order' => 1,
            ],
            [
                'title' => 'Développement Rural, Villages Durables & Gouvernance Foncière',
                'excerpt' => 'Aménagement du territoire, sécurisation foncière et gouvernance locale.',
                'content' => 'L’objectif est de bâtir des villages durables et désirables en République Démocratique du Congo. Les actions portent sur l’aménagement de pistes rurales, l’accès à l’eau potable, l’électrification solaire, la construction d’infrastructures communautaires (écoles, centres de santé) et la promotion d’un habitat décent. La sécurisation foncière est abordée via la cartographie participative, la médiation des conflits et l’accompagnement juridique des communautés. Le volet gouvernance renforce les capacités des comités locaux de développement.',
                'icon' => 'fa-solid fa-tree-city',
                'sort_order' => 2,
            ],
            [
                'title' => 'Entrepreneuriat, Économie Sociale & Autonomisation des Femmes',
                'excerpt' => 'Appui aux micro-entreprises, AVEC et leadership féminin.',
                'content' => 'Ce domaine vise à stimuler l’économie locale en soutenant la création et le développement de micro-entreprises agricoles et artisanales. Les Associations Villageoises d’Épargne et de Crédit (AVEC) sont mises en place pour faciliter l’accès au financement. Une attention particulière est portée à l’autonomisation des femmes à travers des formations en gestion, en leadership et en techniques de commercialisation. L’économie sociale et solidaire est promue comme levier de résilience communautaire.',
                'icon' => 'fa-solid fa-hand-holding-heart',
                'sort_order' => 3,
            ],
            [
                'title' => 'Éducation, Recherches Appliquées & Renforcement des Capacités',
                'excerpt' => 'Formations professionnelles, alphabétisation et appui aux OP.',
                'content' => 'L’éducation est un pilier transversal du CADERSA. Le volet éducation comprend l’alphabétisation fonctionnelle des adultes, la formation professionnelle des jeunes (agriculture, élevage, mécanique) et le renforcement des capacités des Organisations Paysannes (OP). Des recherches appliquées sont conduites pour adapter les techniques culturales au contexte local. Des partenariats avec les universités et les instituts de recherche permettent de diffuser les innovations agricoles.',
                'icon' => 'fa-solid fa-book-open',
                'sort_order' => 4,
            ],
            [
                'title' => 'Droits Humains, Protection, Abris & Cohésion Sociale',
                'excerpt' => 'Lutte contre les VSB-HS, abris d’urgence et cohésion communautaire.',
                'content' => 'Dans les zones affectées par les conflits, le CADERSA met en œuvre des programmes de protection des civils, avec un accent sur la lutte contre les violences sexuelles et basées sur le genre (VSB-HS). Des abris d’urgence sont construits pour les déplacés et les retournés. La cohésion sociale est renforcée par des activités de dialogue intercommunautaire, de réconciliation et de médiation. Des espaces sûrs pour les femmes et les enfants sont aménagés.',
                'icon' => 'fa-solid fa-shield-heart',
                'sort_order' => 5,
            ],
            [
                'title' => 'Santé, Eau, Hygiène & Assainissement',
                'excerpt' => 'Accès aux soins de base, eau potable et hygiène.',
                'content' => 'Ce domaine couvre la construction et la réhabilitation de centres de santé, la formation du personnel soignant communautaire, la distribution de moustiquaires imprégnées, la sensibilisation à la santé maternelle et infantile. L’accès à l’eau potable est amélioré par le forage de puits, la protection des sources et l’installation de systèmes d’adduction d’eau. Des latrines améliorées sont construites dans les écoles et les lieux publics, accompagnées de campagnes de promotion de l’hygiène.',
                'icon' => 'fa-solid fa-droplet',
                'sort_order' => 6,
            ],
            [
                'title' => 'Environnement, Agroforesterie & Réduction des Risques de Catastrophes',
                'excerpt' => 'Conservation des écosystèmes, agroforesterie et aide humanitaire.',
                'content' => 'La protection de l’environnement et la lutte contre le changement climatique sont intégrées dans tous les projets. L’agroforesterie est encouragée pour restaurer les sols dégradés et diversifier les revenus des ménages. Des pépinières villageoises produisent des plants d’arbres fruitiers et forestiers. En cas de catastrophe naturelle ou de conflit, le CADERSA apporte une aide humanitaire d’urgence : distribution de vivres, de biens non alimentaires et de semences.',
                'icon' => 'fa-solid fa-leaf',
                'sort_order' => 7,
            ],
        ];

        foreach ($services as $data) {
            Service::create([
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'excerpt' => $data['excerpt'],
                'content' => $data['content'],
                'icon' => $data['icon'],
                'is_active' => true,
                'sort_order' => $data['sort_order'],
            ]);
        }
    }
}
