<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            [
                'name' => 'Jean Dupont',
                'role' => 'Directeur Général',
                'bio' => 'Passionné par l’innovation et le leadership, Jean pilote la stratégie globale de l’entreprise.',
                'email' => 'jean.dupont@example.com',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/jeandupont',
                    'twitter' => 'https://twitter.com/jeandupont',
                ],
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Marie Durand',
                'role' => 'Responsable Marketing',
                'bio' => 'Créative et stratégique, Marie conçoit les campagnes qui font rayonner notre marque.',
                'email' => 'marie.durand@example.com',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/mariedurand',
                    'facebook' => 'https://facebook.com/mariedurand.pro',
                ],
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Lucas Martin',
                'role' => 'Développeur Senior',
                'bio' => 'Expert en Laravel et Vue.js, Lucas code des solutions robustes et élégantes.',
                'email' => 'lucas.martin@example.com',
                'social_links' => [
                    'github' => 'https://github.com/lucasmartin',
                    'twitter' => 'https://twitter.com/lucasmartin',
                    'linkedin' => 'https://linkedin.com/in/lucasmartin',
                ],
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Sophie Bernard',
                'role' => 'Support Client',
                'bio' => 'Toujours à l’écoute, Sophie assure un support réactif et personnalisé à nos utilisateurs.',
                'email' => 'sophie.bernard@example.com',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/sophiebernard',
                ],
                'is_active' => false,
                'sort_order' => 4,
            ],
            [
                'name' => 'Thomas Petit',
                'role' => 'Commercial',
                'bio' => 'Doté d’un excellent relationnel, Thomas développe de nouveaux partenariats.',
                'email' => 'thomas.petit@example.com',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/thomaspetit',
                    'twitter' => 'https://twitter.com/thomaspetit',
                ],
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Camille Leroy',
                'role' => 'Chef de Projet',
                'bio' => 'Organisée et méthodique, Camille veille au respect des délais et à la satisfaction client.',
                'email' => 'camille.leroy@example.com',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/camilleleroy',
                    'twitter' => 'https://twitter.com/camilleleroy',
                ],
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'Antoine Moreau',
                'role' => 'Designer UI/UX',
                'bio' => 'Créatif et minutieux, Antoine imagine des interfaces intuitives qui enchantent nos utilisateurs.',
                'email' => 'antoine.moreau@example.com',
                'social_links' => [
                    'dribbble' => 'https://dribbble.com/antoinemor',
                    'linkedin' => 'https://linkedin.com/in/antoinemor',
                    'twitter' => 'https://twitter.com/antoinemor',
                ],
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'Émilie Roux',
                'role' => 'Data Analyst',
                'bio' => 'Émilie transforme les données brutes en insights stratégiques pour guider nos décisions.',
                'email' => 'emilie.roux@example.com',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/emilieroux',
                ],
                'is_active' => true,
                'sort_order' => 8,
            ],
            [
                'name' => 'Nicolas Lefèvre',
                'role' => 'SysAdmin',
                'bio' => 'Garant de la stabilité de notre infrastructure, Nicolas veille au grain 24/7.',
                'email' => 'nicolas.lefevre@example.com',
                'social_links' => [
                    'github' => 'https://github.com/nicolaslefevre',
                    'linkedin' => 'https://linkedin.com/in/nicolaslefevre',
                ],
                'is_active' => true,
                'sort_order' => 9,
            ],
            [
                'name' => 'Julie Fontaine',
                'role' => 'Community Manager',
                'bio' => 'Julie anime nos communautés avec bienveillance et créativité, créant un lien fort avec nos utilisateurs.',
                'email' => 'julie.fontaine@example.com',
                'social_links' => [
                    'twitter' => 'https://twitter.com/juliefontaine',
                    'linkedin' => 'https://linkedin.com/in/juliefontaine',
                    'facebook' => 'https://facebook.com/juliefontaine.pro',
                ],
                'is_active' => true,
                'sort_order' => 10,
            ],
            [
                'name' => 'Pierre Gauthier',
                'role' => 'Responsable RH',
                'bio' => 'À l’écoute des équipes, Pierre cultive un environnement de travail épanouissant et inclusif.',
                'email' => 'pierre.gauthier@example.com',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/pierregauthier',
                ],
                'is_active' => false,
                'sort_order' => 11,
            ],
            [
                'name' => 'Chloé Mercier',
                'role' => 'Stagiaire Développement',
                'bio' => 'Curieuse et motivée, Chloé apprend vite et apporte un regard neuf sur nos projets.',
                'email' => 'chloe.mercier@example.com',
                'social_links' => [
                    'github' => 'https://github.com/chloemercier',
                    'linkedin' => 'https://linkedin.com/in/chloemercier',
                ],
                'is_active' => true,
                'sort_order' => 12,
            ],
        ];

        foreach ($members as $data) {
            TeamMember::create($data);
        }
    }
}
