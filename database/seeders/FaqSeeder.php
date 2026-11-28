<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            ['question' => 'Qu’est-ce que CADERSA ASBL ?', 'answer' => 'CADERSA ASBL est une organisation engagée dans le développement rural, la sécurité alimentaire et l’amélioration des conditions de vie des communautés.'],
            ['question' => 'Quels sont les domaines d’intervention de CADERSA ?', 'answer' => 'Nos actions portent notamment sur l’agriculture durable, la nutrition communautaire, la santé, l’accès à l’eau et le renforcement des capacités locales.'],
            ['question' => 'Comment prendre part aux activités ?', 'answer' => 'Les personnes et organisations intéressées peuvent nous écrire via la page Contact en précisant leur localité et le type de collaboration envisagé.'],
            ['question' => 'CADERSA propose-t-elle des formations ?', 'answer' => 'Oui. Les formations et séances de sensibilisation sont adaptées aux besoins des communautés et des acteurs locaux.'],
            ['question' => 'Comment soutenir les actions de CADERSA ?', 'answer' => 'Vous pouvez nous contacter pour discuter d’un partenariat, d’un appui technique ou d’une contribution à nos initiatives.'],
            ['question' => 'Comment joindre l’équipe ?', 'answer' => 'Utilisez le formulaire de contact du site ou les coordonnées officielles affichées dans la rubrique Contact.'],
        ];

        foreach ($faqs as $index => $faq) {
            Faq::updateOrCreate(
                ['question' => $faq['question']],
                [...$faq, 'sort_order' => $index + 1, 'is_active' => true]
            );
        }
    }
}
