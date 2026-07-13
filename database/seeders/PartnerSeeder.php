<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        $partners = [
            [
                'name' => 'USAID',
                'url' => 'https://www.usaid.gov/democratic-republic-congo',
                'sort_order' => 1,
            ],
            [
                'name' => 'MSI (Management Systems International)',
                'url' => 'https://www.msi-inc.com',
                'sort_order' => 2,
            ],
            [
                'name' => 'MONUSCO',
                'url' => 'https://monusco.unmissions.org',
                'sort_order' => 3,
            ],
            [
                'name' => 'Programme Alimentaire Mondial (PAM)',
                'url' => 'https://fr.wfp.org/countries/republique-democratique-du-congo',
                'sort_order' => 4,
            ],
            [
                'name' => 'FAO (Organisation des Nations Unies pour l\'alimentation et l\'agriculture)',
                'url' => 'https://www.fao.org/democratic-republic-of-the-congo/fr/',
                'sort_order' => 5,
            ],
            [
                'name' => 'Ministère du Développement Rural (RDC)',
                'url' => 'https://www.developpement-rural.gouv.cd',
                'sort_order' => 6,
            ],
            [
                'name' => 'Ministère de l\'Agriculture et Sécurité Alimentaire (RDC)',
                'url' => 'https://www.agriculture.gouv.cd',
                'sort_order' => 7,
            ],
            [
                'name' => 'Ministère de la Santé Publique, Hygiène et Prévention (RDC)',
                'url' => 'https://www.sante.gouv.cd',
                'sort_order' => 8,
            ],
            [
                'name' => 'Ministère du Plan (RDC)',
                'url' => 'https://www.plan.gouv.cd',
                'sort_order' => 9,
            ],
            [
                'name' => 'Gouvernement Provincial du Sud-Kivu',
                'url' => 'https://www.sudkivu.cd',
                'sort_order' => 10,
            ],
            [
                'name' => 'Gouvernement Provincial du Nord-Kivu',
                'url' => 'https://www.nordkivu.cd',
                'sort_order' => 11,
            ],
            [
                'name' => 'Gouvernement Provincial du Tanganyika',
                'url' => 'https://www.tanganyika.cd',
                'sort_order' => 12,
            ],
            [
                'name' => 'Gouvernement Provincial du Sud-Ubangi',
                'url' => 'https://www.sudubangi.cd',
                'sort_order' => 13,
            ],
            [
                'name' => 'Gouvernement Provincial du Kasaï Central',
                'url' => 'https://www.kasaicentral.cd',
                'sort_order' => 14,
            ],
            [
                'name' => 'Gouvernement Provincial du Kasaï Oriental',
                'url' => 'https://www.kasaioriental.cd',
                'sort_order' => 15,
            ],
            [
                'name' => 'Direction Générale des Impôts (DGI)',
                'url' => 'https://www.dgi.gouv.cd',
                'sort_order' => 16,
            ],
            [
                'name' => 'Caisse Nationale de Sécurité Sociale (CNSS)',
                'url' => 'https://www.cnss.cd',
                'sort_order' => 17,
            ],
            [
                'name' => 'Office National de l\'Emploi (ONEM)',
                'url' => 'https://www.onem.cd',
                'sort_order' => 18,
            ],
        ];

        foreach ($partners as $partner) {
            Partner::create([
                'name' => $partner['name'],
                'url' => $partner['url'],
                'is_active' => true,
                'sort_order' => $partner['sort_order'],
            ]);
        }
    }
}
