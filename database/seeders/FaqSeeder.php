<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'Qu’est-ce que CADERSA ?',
                'answer' => 'CADERSA (Centre d’Appui au Développement Rural et à la Sécurité Alimentaire) est une ONG congolaise qui œuvre pour renforcer la résilience des communautés rurales et périurbaines à travers des actions de sécurité alimentaire, nutrition, agriculture durable, élevage, formation et protection de l’environnement.',
                'sort_order' => 1,
            ],
            [
                'question' => 'Quelles sont les principales zones d’intervention de CADERSA ?',
                'answer' => 'CADERSA intervient dans six provinces de la RDC : Sud-Kivu, Nord-Kivu, Tanganyika, Ituri, Kasaï Central et Sud-Ubangi. Nous avons des bureaux dans les chefs-lieux et des bases dans les zones rurales pour être au plus proche des communautés.',
                'sort_order' => 2,
            ],
            [
                'question' => 'Comment CADERSA lutte-t-il contre la malnutrition ?',
                'answer' => 'Nous menons des programmes de nutrition directe (prise en charge de la malnutrition aiguë modérée et sévère) et de nutrition sensible (démonstrations culinaires, sensibilisation à l’alimentation équilibrée, promotion des 1000 premiers jours, jardinage potager, petits élevages).',
                'sort_order' => 3,
            ],
            [
                'question' => 'Quels sont les partenaires techniques et financiers de CADERSA ?',
                'answer' => 'CADERSA travaille avec le Programme Alimentaire Mondial (PAM), la FAO, l’USAID, la MONUSCO, le gouvernement congolais (ministères de l’Agriculture, de la Santé, du Développement rural) et d’autres ONG locales et internationales.',
                'sort_order' => 4,
            ],
            [
                'question' => 'Comment puis-je bénéficier des programmes de CADERSA ?',
                'answer' => 'Les bénéficiaires sont généralement identifiés à travers les organisations paysannes (OP) locales, les comités de développement ou les relais communautaires. Si vous êtes dans une zone d’intervention, rapprochez-vous de votre chef de village ou de votre coopérative agricole.',
                'sort_order' => 5,
            ],
            [
                'question' => 'CADERSA propose-t-il des formations ?',
                'answer' => 'Oui, nous organisons des formations en alphabétisation fonctionnelle, en gestion post-récolte, en techniques agricoles durables, en élevage, en entrepreneuriat, en nutrition et en gouvernance locale. Nous formons également les organisations paysannes à la gestion administrative et financière.',
                'sort_order' => 6,
            ],
            [
                'question' => 'Qu’est-ce que l’approche 4B de CADERSA ?',
                'answer' => 'L’approche 4B est notre méthode phare : Bonne cuisson, Bonne alimentation, Bonne planification familiale pour la Bonne santé. Elle vise à améliorer les pratiques domestiques pour une meilleure nutrition et hygiène, en lien avec les Objectifs de Développement Durable.',
                'sort_order' => 7,
            ],
            [
                'question' => 'CADERSA mène-t-il des actions de reboisement ?',
                'answer' => 'Absolument. Nous plantons des arbres fruitiers et des essences agroforestières, nous construisons des foyers améliorés et nous fabriquons des briquettes combustibles pour réduire la pression sur les forêts et lutter contre le changement climatique.',
                'sort_order' => 8,
            ],
            [
                'question' => 'Comment CADERSA soutient-il les femmes ?',
                'answer' => 'Nous avons des programmes spécifiques d’autonomisation des femmes : activités génératrices de revenus (AGR), savonnerie, panification, petit élevage, accès aux machines agricoles, formations en alphabétisation et en leadership. Nous luttons également contre les violences basées sur le genre.',
                'sort_order' => 9,
            ],
            [
                'question' => 'Qu’est-ce que la gestion post-récolte ?',
                'answer' => 'C’est un ensemble de techniques pour réduire les pertes après la récolte : séchage, stockage hermétique, lutte contre les ravageurs, transformation, commercialisation groupée. CADERSA forme les paysans à ces pratiques pour améliorer leurs revenus et leur sécurité alimentaire.',
                'sort_order' => 10,
            ],
            [
                'question' => 'Puis-je faire un don ou devenir bénévole chez CADERSA ?',
                'answer' => 'Nous accueillons volontiers les dons et le bénévolat. Contactez-nous à cadersa.asbl@gmail.com ou par téléphone au +243 997 780 281 pour discuter des possibilités de collaboration.',
                'sort_order' => 11,
            ],
            [
                'question' => 'CADERSA intervient-il en situation d’urgence ?',
                'answer' => 'Oui, nous menons des actions d’aide humanitaire : distributions générales de vivres (GFD), transferts monétaires, soutien nutritionnel dans les zones touchées par les conflits ou les catastrophes naturelles (ex. éruptions volcaniques, inondations).',
                'sort_order' => 12,
            ],
            [
                'question' => 'Quels types d’agriculture CADERSA promeut-il ?',
                'answer' => 'Nous promouvons l’agroécologie paysanne, l’agriculture durable et le Plan Intégré du Paysan (PIP) qui associe cultures, élevage et gestion des ressources naturelles pour une production résiliente et respectueuse de l’environnement.',
                'sort_order' => 13,
            ],
            [
                'question' => 'Comment CADERSA implique-t-il les communautés locales ?',
                'answer' => 'Nous utilisons une approche participative : les bénéficiaires sont associés à toutes les phases des projets (diagnostic, planification, mise en œuvre, suivi-évaluation). Nous renforçons les organisations paysannes et les mutuelles de solidarité (MUSO) pour une appropriation durable.',
                'sort_order' => 14,
            ],
            [
                'question' => 'Quels sont les critères pour être bénéficiaire des projets de CADERSA ?',
                'answer' => 'Les critères varient selon les projets, mais nous ciblons généralement les ménages vulnérables (femmes, enfants, personnes âgées, handicapés) vivant dans les zones d’intervention et membres d’organisations paysannes ou de groupements communautaires.',
                'sort_order' => 15,
            ],
            [
                'question' => 'CADERSA travaille-t-il avec les écoles ?',
                'answer' => 'Oui, nous mettons en place des jardins scolaires, des cantines scolaires et des séances de sensibilisation à la nutrition et à l’hygiène dans les écoles de nos zones d’intervention.',
                'sort_order' => 16,
            ],
            [
                'question' => 'Comment puis-je obtenir plus d’informations sur les activités de CADERSA ?',
                'answer' => 'Vous pouvez consulter notre site web www.cadersa.org, suivre notre page Facebook (@cadersaasbl) ou nous contacter directement par email ou téléphone. Nous publions régulièrement des rapports d’activités et des actualités.',
                'sort_order' => 17,
            ],
            [
                'question' => 'CADERSA contribue-t-il à l’accès aux marchés pour les petits producteurs ?',
                'answer' => 'Oui, nous organisons des foires agricoles, nous facilitons la vente groupée et le warrantage, et nous mettons en relation les producteurs avec des acheteurs pour garantir des prix rémunérateurs.',
                'sort_order' => 18,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }

        $this->command->info('✅ '.count($faqs).' FAQs créées avec succès.');
    }
}
