<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Marie Dupont',
                'role' => 'CEO',
                'company' => 'TechStart RDC',
                'content' => 'Gauthier a réalisé notre plateforme e-commerce avec une précision remarquable. Le résultat dépasse nos attentes : une interface moderne, rapide et très facile à utiliser. Je recommande vivement ses services.',
                'is_active' => true,
            ],
            [
                'name' => 'Jean-Pierre Mutombo',
                'role' => 'Directeur Digital',
                'company' => 'Agence Innovate',
                'content' => 'Collaboration exceptionnelle pour la refonte de notre site institutionnel. Gauthier a su comprendre nos besoins et proposer des solutions créatives tout en respectant les délais et le budget.',
                'is_active' => true,
            ],
            [
                'name' => 'Sophie Kimba',
                'role' => 'Fondatrice',
                'company' => 'Kimba Design Studio',
                'content' => 'Un développeur full-stack vraiment compétent. Il maîtrise parfaitement Laravel et Livewire. Notre dashboard de gestion fonctionne à merveille et nos équipes l\'adorent.',
                'is_active' => true,
            ],
            [
                'name' => 'Patrick Luzolo',
                'role' => 'Product Manager',
                'company' => 'FinTech Congo',
                'content' => 'Gauthier a développé notre application de microfinance avec un niveau de qualité professionnel. Le code est propre, bien documenté et très maintenable. Un vrai plaisir de travailler avec lui.',
                'is_active' => true,
            ],
            [
                'name' => 'Amina Bongo',
                'role' => 'Responsable Marketing',
                'company' => 'AfroMedia Group',
                'content' => 'Notre site web a été entièrement repensé par Gauthier. Les résultats sont spectaculaires : +60% de trafic organique en 3 mois. Son souci du détail en matière de SEO et de performance est impressionnant.',
                'is_active' => true,
            ],
            [
                'name' => 'Christophe Mankenda',
                'role' => 'CTO',
                'company' => 'LogiTech Africa',
                'content' => 'Nous avons fait appel à Gauthier pour intégrer des APIs complexes dans notre système de gestion logistique. Il a livré un travail impeccable dans les temps. Très professionnel et réactif.',
                'is_active' => true,
            ],
            [
                'name' => 'Nathalie Mbeki',
                'role' => 'Professeure',
                'company' => 'Université de Kinshasa',
                'content' => 'Gauthier a créé une plateforme e-learning pour notre département. L\'interface est intuitive, les fonctionnalités de quiz et de suivi des étudiants sont parfaitement réalisées. Excellent travail !',
                'is_active' => true,
            ],
            [
                'name' => 'Éric Nkutu',
                'role' => 'Entrepreneur',
                'company' => 'NkutuStore',
                'content' => 'Ma boutique en ligne tourne parfaitement grâce à Gauthier. De la conception à la mise en ligne, tout était fluide et bien communiqué. Je le contacte dès que j\'ai un nouveau projet.',
                'is_active' => true,
            ],
            [
                'name' => 'Claudine Fula',
                'role' => 'Directrice Générale',
                'company' => 'Santé Plus Clinic',
                'content' => 'Notre système de gestion des rendez-vous médicaux a été développé avec beaucoup de soin. Gauthier comprend les enjeux métier et traduit les besoins en fonctionnalités précises et efficaces.',
                'is_active' => true,
            ],
            [
                'name' => 'Samuel Kalala',
                'role' => 'Développeur Senior',
                'company' => 'DevHub Africa',
                'content' => 'En tant que développeur moi-même, j\'ai été impressionné par la qualité du code de Gauthier : architecture SOLID, tests unitaires, performances optimisées. C\'est le genre de collaborateur qu\'on souhaite avoir dans son équipe.',
                'is_active' => true,
            ],
            [
                'name' => 'Grace Lukusa',
                'role' => 'Consultante RH',
                'company' => 'TalentRDC',
                'content' => 'Gauthier a livré notre portail de recrutement en avance sur le planning. L\'outil est robuste, bien sécurisé et très agréable à utiliser. Nos candidats et recruteurs sont unanimes.',
                'is_active' => true,
            ],
            [
                'name' => 'Thierry Nsanda',
                'role' => 'Gérant',
                'company' => 'Hôtel La Palme',
                'content' => 'Notre site de réservation en ligne a complètement transformé notre activité. Gauthier a intégré un système de paiement sécurisé et une interface de gestion intuitive. Le retour sur investissement est excellent.',
                'is_active' => true,
            ],
        ];

        foreach ($testimonials as $data) {
            Testimonial::create($data);
        }
    }
}
