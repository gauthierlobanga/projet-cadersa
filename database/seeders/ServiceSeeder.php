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
            ['title' => 'Appui au développement rural', 'excerpt' => 'Un accompagnement de proximité construit avec les communautés et les acteurs locaux.', 'content' => 'CADERSA accompagne les initiatives locales en tenant compte des priorités exprimées par les communautés, des ressources disponibles et des réalités propres à chaque territoire.', 'icon' => 'fa-solid fa-people-group'],
            ['title' => 'Sécurité alimentaire et agriculture durable', 'excerpt' => 'Des pratiques agricoles durables pour renforcer les moyens d’existence des familles.', 'content' => 'Nos activités soutiennent la production familiale, la diversification alimentaire et l’adoption de pratiques adaptées aux sols, aux saisons et aux savoirs locaux.', 'icon' => 'fa-solid fa-seedling'],
            ['title' => 'Nutrition et santé communautaire', 'excerpt' => 'Information et mobilisation autour de la nutrition et du bien-être des familles.', 'content' => 'Nous menons des actions d’information et de sensibilisation qui favorisent de meilleures pratiques alimentaires et une approche communautaire de la santé.', 'icon' => 'fa-solid fa-heart-pulse'],
            ['title' => 'Eau, hygiène et assainissement', 'excerpt' => 'Des actions locales pour améliorer les pratiques d’hygiène et l’accès aux services essentiels.', 'content' => 'CADERSA soutient les communautés dans l’identification de solutions adaptées à l’eau, à l’hygiène et à l’assainissement, en lien avec les partenaires concernés.', 'icon' => 'fa-solid fa-droplet'],
            ['title' => 'Formation et renforcement des capacités', 'excerpt' => 'Des formations pratiques pour les producteurs, les familles et les organisations locales.', 'content' => 'Les sessions de formation s’appuient sur les besoins identifiés sur le terrain et privilégient la participation, la mise en pratique et le partage d’expérience.', 'icon' => 'fa-solid fa-chalkboard-user'],
        ];

        foreach ($services as $index => $service) {
            Service::updateOrCreate(
                ['slug' => Str::slug($service['title'])],
                [...$service, 'is_active' => true, 'sort_order' => $index + 1]
            );
        }
    }
}
