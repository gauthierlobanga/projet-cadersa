<?php

namespace Database\Seeders;

use App\Settings\CookieSettings;
use App\Settings\LegalSettings;
use App\Settings\PrivacySettings;
use App\Settings\TermsSettings;
use Illuminate\Database\Seeder;
use Tiptap\Editor;

class LegalPagesSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedTerms();
        $this->seedPrivacy();
        $this->seedLegal();
        $this->seedCookies();
    }

    private function seedTerms(): void
    {
        $html = <<<'HTML'
        <h1>CONDITIONS GÉNÉRALES D'UTILISATION (CGU)</h1>
        <p><em>Date de dernière mise à jour : 13 juillet 2026</em></p>

        <h2>1. Objet</h2>
        <p>Les présentes Conditions Générales d'Utilisation (ci-après « CGU ») ont pour objet de définir les modalités et conditions d'utilisation du site internet de CADERSA ASBL (ci-après « le Site »), accessible à l'adresse <a href="https://www.cadersa.org">www.cadersa.org</a>, ainsi que les droits et obligations des parties dans ce cadre.</p>
        <p>Le Site a pour vocation de présenter les activités, projets, domaines d'intervention et actualités de CADERSA, ainsi que de faciliter la prise de contact avec l'organisation.</p>

        <h2>2. Acceptation des CGU</h2>
        <p>En accédant et en utilisant le Site, l'utilisateur accepte pleinement et sans réserve les présentes CGU. Si l'utilisateur n'accepte pas ces conditions, il est invité à ne pas utiliser le Site.</p>
        <p>CADERSA se réserve le droit de modifier les présentes CGU à tout moment. Les modifications entrent en vigueur dès leur publication sur le Site. Il est recommandé à l'utilisateur de consulter régulièrement les CGU pour prendre connaissance des éventuelles mises à jour.</p>

        <h2>3. Description de CADERSA</h2>
        <p>Le Centre d'Appui au Développement Rural et à la Sécurité Alimentaire (CADERSA) est une ASBL de droit congolais créée en 2010, régie par la Loi n° 004/2001 du 20 juillet 2001 portant dispositions générales applicables aux Associations Sans But Lucratif et aux Établissements d'Utilité Publique.</p>
        <p>Sa mission est d'assurer une coopération pour la réalisation et la promotion des activités de développement rural et agricole alignées au Plan National Stratégique de Développement (PNSD) du Gouvernement congolais, afin de permettre aux communautés locales de participer activement à la vie de la société qui s'adapte, protège, et assure une sécurité alimentaire et une nutrition saine.</p>

        <h2>4. Propriété intellectuelle</h2>
        <p>Tous les contenus présents sur le Site (textes, images, photographies, vidéos, logos, etc.) sont la propriété exclusive de CADERSA ou de ses partenaires et sont protégés par les lois relatives à la propriété intellectuelle.</p>
        <p>Toute reproduction, représentation, modification, publication, adaptation de tout ou partie des éléments du Site, quel que soit le moyen ou le procédé utilisé, est interdite, sauf autorisation écrite préalable de CADERSA.</p>

        <h2>5. Liens hypertextes</h2>
        <p>Le Site peut contenir des liens hypertextes vers d'autres sites internet. CADERSA n'exerce aucun contrôle sur ces sites et décline toute responsabilité quant à leur contenu, leur accessibilité ou leur fonctionnement.</p>

        <h2>6. Limitation de responsabilité</h2>
        <p>CADERSA s'efforce de fournir des informations aussi précises et à jour que possible sur le Site. Toutefois, CADERSA ne peut garantir l'exactitude, la complétude ou l'actualité des informations diffusées.</p>
        <p>L'utilisateur utilise le Site sous sa seule responsabilité. CADERSA ne pourra être tenu responsable des dommages directs ou indirects résultant de l'utilisation du Site ou de l'impossibilité d'y accéder.</p>

        <h2>7. Données personnelles</h2>
        <p>CADERSA accorde une importance particulière à la protection des données personnelles. La collecte et le traitement des données à caractère personnel sont régis par notre <strong>Politique de Confidentialité</strong>.</p>

        <h2>8. Droit applicable et juridiction compétente</h2>
        <p>Les présentes CGU sont régies par le droit de la <strong>République Démocratique du Congo</strong>.</p>
        <p>Tout litige relatif à l'interprétation ou à l'exécution des présentes CGU sera de la compétence exclusive des tribunaux de la ville de <strong>Bukavu</strong>, République Démocratique du Congo.</p>

        <h2>9. Contact</h2>
        <p>Pour toute question relative aux présentes CGU, l'utilisateur peut contacter CADERSA à l'adresse suivante :</p>
        <ul>
            <li><strong>Adresse :</strong> N°041, Av. Mbaki, C/Ibanda, Bukavu/RDC</li>
            <li><strong>Téléphone :</strong> <a href="tel:+243997780281">+243 997 780 281</a></li>
            <li><strong>E-mail :</strong> <a href="mailto:cadersa.asbl@gmail.com">cadersa.asbl@gmail.com</a></li>
        </ul>
        HTML;

        app(TermsSettings::class)->content = (new Editor)->setContent($html)->getDocument();
        app(TermsSettings::class)->save();
    }

    private function seedPrivacy(): void
    {
        $html = <<<'HTML'
        <h1>POLITIQUE DE CONFIDENTIALITÉ</h1>
        <p><em>Date de dernière mise à jour : 13 juillet 2026</em></p>

        <h2>1. Introduction</h2>
        <p>CADERSA ASBL (ci-après « CADERSA », « nous », « notre ») accorde une importance primordiale à la protection de votre vie privée et de vos données personnelles.</p>
        <p>La présente Politique de Confidentialité a pour objectif de vous informer de manière transparente sur la collecte, l'utilisation, la conservation et la protection de vos données personnelles lorsque vous visitez notre Site internet <a href="https://www.cadersa.org">www.cadersa.org</a> ou que vous interagissez avec nous.</p>
        <p>CADERSA est une ASBL de droit congolais, régie par la Loi n° 004/2001 du 20 juillet 2001.</p>

        <h2>2. Données collectées</h2>
        <p>Nous sommes susceptibles de collecter les catégories de données suivantes :</p>
        <ul>
            <li><strong>Données d'identification :</strong> nom, prénom, adresse e-mail, numéro de téléphone.</li>
            <li><strong>Données de navigation :</strong> adresse IP, type de navigateur, pages visitées, durée de la visite, etc. (via les cookies).</li>
            <li><strong>Données de correspondance :</strong> lorsque vous nous contactez par e-mail ou via le formulaire de contact, nous conservons vos messages et nos réponses.</li>
            <li><strong>Données de don :</strong> si vous effectuez un don en ligne, nous collectons les informations nécessaires au traitement de la transaction (nom, montant, moyen de paiement). Les données bancaires sont traitées par notre prestataire de paiement sécurisé et ne sont pas conservées par CADERSA.</li>
        </ul>

        <h2>3. Finalités du traitement</h2>
        <p>Vos données personnelles sont collectées et traitées pour les finalités suivantes :</p>
        <ul>
            <li><strong>Gestion des demandes de contact :</strong> répondre à vos questions, demandes d'information ou de collaboration.</li>
            <li><strong>Gestion des dons :</strong> traiter et suivre vos dons, émettre des reçus fiscaux.</li>
            <li><strong>Information et communication :</strong> vous envoyer des informations sur nos activités, projets, appels à dons et actualités (uniquement si vous y avez consenti).</li>
            <li><strong>Amélioration du Site :</strong> analyser la fréquentation et l'utilisation du Site pour en améliorer le contenu et la navigation.</li>
            <li>Respect des obligations légales et réglementaires.</li>
        </ul>

        <h2>4. Base légale du traitement</h2>
        <p>Nous traitons vos données personnelles sur les bases légales suivantes :</p>
        <ul>
            <li><strong>Votre consentement :</strong> pour l'envoi de communications électroniques, le dépôt de certains cookies.</li>
            <li><strong>L'exécution de mesures précontractuelles ou contractuelles :</strong> pour répondre à vos demandes de contact.</li>
            <li><strong>L'intérêt légitime de CADERSA :</strong> pour améliorer nos services et assurer la sécurité du Site.</li>
            <li><strong>Le respect d'une obligation légale :</strong> pour la gestion des dons et la tenue de la comptabilité.</li>
        </ul>

        <h2>5. Destinataires des données</h2>
        <p>Vos données personnelles sont destinées au personnel habilité de CADERSA et, le cas échéant, à nos prestataires techniques (hébergeur du Site, prestataire de paiement, etc.) qui agissent en qualité de sous-traitants et sont tenus de respecter la confidentialité et la sécurité des données.</p>
        <p><strong>CADERSA ne vend, ni ne loue vos données personnelles à des tiers.</strong></p>

        <h2>6. Durée de conservation</h2>
        <p>Nous conservons vos données personnelles pendant la durée nécessaire à la réalisation des finalités pour lesquelles elles ont été collectées, conformément aux exigences légales et réglementaires en vigueur en République Démocratique du Congo.</p>
        <ul>
            <li><strong>Données de contact :</strong> 3 ans à compter du dernier contact.</li>
            <li><strong>Données de don :</strong> 10 ans (conformément aux obligations comptables et fiscales).</li>
            <li><strong>Données de navigation (cookies) :</strong> 13 mois maximum.</li>
        </ul>

        <h2>7. Vos droits</h2>
        <p>Conformément à la Loi n° 004/2001 et aux principes généraux applicables en RDC, vous disposez des droits suivants sur vos données personnelles :</p>
        <ul>
            <li><strong>Droit d'accès :</strong> obtenir la confirmation que vos données sont traitées et y accéder.</li>
            <li><strong>Droit de rectification :</strong> faire rectifier vos données si elles sont inexactes ou incomplètes.</li>
            <li><strong>Droit à l'effacement :</strong> demander la suppression de vos données, sous réserve des obligations légales de conservation.</li>
            <li><strong>Droit d'opposition :</strong> vous opposer au traitement de vos données pour des motifs légitimes.</li>
            <li><strong>Droit à la limitation :</strong> demander la limitation du traitement de vos données.</li>
        </ul>
        <p>Pour exercer ces droits, vous pouvez nous contacter à l'adresse suivante :</p>
        <ul>
            <li><strong>E-mail :</strong> <a href="mailto:cadersa.asbl@gmail.com">cadersa.asbl@gmail.com</a></li>
            <li><strong>Adresse postale :</strong> N°041, Av. Mbaki, C/Ibanda, Bukavu/RDC</li>
        </ul>
        <p>Nous nous engageons à répondre à votre demande dans un délai raisonnable.</p>

        <h2>8. Sécurité des données</h2>
        <p>CADERSA met en œuvre des mesures techniques et organisationnelles appropriées pour garantir la sécurité et la confidentialité de vos données personnelles et les protéger contre tout accès non autorisé, perte, destruction ou divulgation.</p>

        <h2>9. Transfert de données</h2>
        <p>CADERSA s'engage à ne pas transférer vos données personnelles en dehors de la République Démocratique du Congo, sauf si cela est nécessaire pour l'exécution de nos services et avec des garanties appropriées.</p>

        <h2>10. Cookies</h2>
        <p>Le Site utilise des cookies pour améliorer votre expérience de navigation. Pour en savoir plus, veuillez consulter notre <strong>Politique relative aux cookies</strong>.</p>

        <h2>11. Modification de la Politique de Confidentialité</h2>
        <p>CADERSA se réserve le droit de modifier la présente Politique de Confidentialité à tout moment. Les modifications entrent en vigueur dès leur publication sur le Site. Nous vous invitons à consulter régulièrement cette page.</p>

        <h2>12. Contact</h2>
        <p>Pour toute question concernant la présente Politique de Confidentialité, vous pouvez nous contacter :</p>
        <ul>
            <li><strong>Adresse :</strong> N°041, Av. Mbaki, C/Ibanda, Bukavu/RDC</li>
            <li><strong>Téléphone :</strong> <a href="tel:+243997780281">+243 997 780 281</a></li>
            <li><strong>E-mail :</strong> <a href="mailto:cadersa.asbl@gmail.com">cadersa.asbl@gmail.com</a></li>
        </ul>
        HTML;

        app(PrivacySettings::class)->content = (new Editor)->setContent($html)->getDocument();
        app(PrivacySettings::class)->save();
    }

    private function seedLegal(): void
    {
        $html = <<<'HTML'
        <h1>MENTIONS LÉGALES</h1>

        <h2>1. Éditeur du site</h2>
        <p>Le site internet <a href="https://www.cadersa.org">www.cadersa.org</a> est édité par :</p>
        <p><strong>CADERSA ASBL</strong><br>Centre d'Appui au Développement Rural et à la Sécurité Alimentaire</p>
        <ul>
            <li><strong>Forme juridique :</strong> Association Sans But Lucratif (ASBL) de droit congolais</li>
            <li><strong>Date de création :</strong> 2010</li>
            <li><strong>Numéro d'impôt :</strong> A1720064D</li>
            <li><strong>Siège social :</strong> N°041, Av. Mbaki, Q. Ndedere, Commune d'Ibanda, Ville de Bukavu, République Démocratique du Congo</li>
            <li><strong>Téléphone :</strong> <a href="tel:+243997780281">+243 997 780 281</a></li>
            <li><strong>E-mail :</strong> <a href="mailto:cadersa.asbl@gmail.com">cadersa.asbl@gmail.com</a></li>
        </ul>

        <h2>2. Directeur de la publication</h2>
        <ul>
            <li><strong>Nom :</strong> Prof. Bernard HALIMANA HANGI</li>
            <li><strong>Fonction :</strong> Président du Conseil d'Administration</li>
        </ul>

        <h2>3. Hébergement</h2>
        <p>Le site est hébergé par :</p>
        <ul>
            <li><strong>Nom de l'hébergeur :</strong> <em>[À compléter par l'équipe technique]</em></li>
            <li><strong>Adresse :</strong> <em>[À compléter]</em></li>
            <li><strong>Téléphone :</strong> <em>[À compléter]</em></li>
        </ul>

        <h2>4. Propriété intellectuelle</h2>
        <p>L'ensemble des éléments composant le Site (textes, photographies, vidéos, logos, marques, etc.) sont la propriété exclusive de CADERSA ASBL, sauf mention contraire.</p>
        <p>Toute reproduction, distribution, modification, adaptation, retransmission ou publication, même partielle, de ces différents éléments est strictement interdite sans l'accord exprès et préalable de CADERSA.</p>

        <h2>5. Crédits photographiques</h2>
        <p>Les photographies utilisées sur le Site sont la propriété de CADERSA ASBL ou proviennent de sources libres de droits.</p>

        <h2>6. Responsabilité</h2>
        <p>CADERSA s'efforce de fournir des informations aussi précises que possible. Toutefois, elle ne peut garantir l'exactitude, la complétude ou l'actualité des informations diffusées sur le Site.</p>
        <p>CADERSA décline toute responsabilité en cas d'erreur, d'omission ou d'indisponibilité du Site.</p>

        <h2>7. Droit applicable</h2>
        <p>Les présentes Mentions Légales sont régies par le droit de la <strong>République Démocratique du Congo</strong>.</p>
        HTML;

        app(LegalSettings::class)->content = (new Editor)->setContent($html)->getDocument();
        app(LegalSettings::class)->save();
    }

    private function seedCookies(): void
    {
        $html = <<<'HTML'
        <h1>POLITIQUE RELATIVE AUX COOKIES</h1>
        <p><em>Date de dernière mise à jour : 13 juillet 2026</em></p>

        <h2>1. Qu'est-ce qu'un cookie ?</h2>
        <p>Un cookie est un petit fichier texte déposé sur votre ordinateur, tablette ou smartphone lors de votre visite sur un site internet. Il permet de reconnaître votre appareil, de mémoriser certaines informations relatives à votre navigation et d'améliorer votre expérience utilisateur.</p>

        <h2>2. Utilisation des cookies sur le Site CADERSA</h2>
        <p>Le Site <a href="https://www.cadersa.org">www.cadersa.org</a> utilise des cookies pour :</p>
        <ul>
            <li><strong>Assurer le bon fonctionnement du Site :</strong> cookies nécessaires à la navigation.</li>
            <li><strong>Analyser la fréquentation du Site :</strong> cookies de mesure d'audience (ex. Google Analytics) pour comprendre comment les visiteurs utilisent le Site et améliorer son contenu.</li>
            <li><strong>Mémoriser vos préférences :</strong> cookies fonctionnels pour personnaliser votre expérience.</li>
            <li><strong>Permettre le partage sur les réseaux sociaux :</strong> cookies tiers (ex. Facebook, Twitter) lorsque vous utilisez les boutons de partage.</li>
        </ul>

        <h2>3. Types de cookies utilisés</h2>
        <table>
            <thead>
                <tr>
                    <th>Type de cookie</th>
                    <th>Finalité</th>
                    <th>Durée de conservation</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Cookies essentiels</td>
                    <td>Nécessaires au fonctionnement du Site</td>
                    <td>Session</td>
                </tr>
                <tr>
                    <td>Cookies de performance (statistiques)</td>
                    <td>Analyser le trafic et la navigation</td>
                    <td>13 mois maximum</td>
                </tr>
                <tr>
                    <td>Cookies fonctionnels</td>
                    <td>Mémoriser vos préférences</td>
                    <td>13 mois maximum</td>
                </tr>
                <tr>
                    <td>Cookies de partage social</td>
                    <td>Permettre le partage sur les réseaux sociaux</td>
                    <td>Variable selon le tiers</td>
                </tr>
            </tbody>
        </table>

        <h2>4. Gestion de vos préférences</h2>
        <p>Lors de votre première visite sur le Site, un bandeau vous informe de l'utilisation des cookies et vous permet de paramétrer vos préférences.</p>
        <p>Vous pouvez à tout moment modifier vos préférences en matière de cookies en utilisant l'outil de gestion des cookies disponible sur le Site.</p>
        <p>Vous pouvez également configurer votre navigateur pour :</p>
        <ul>
            <li>Accepter ou refuser tous les cookies.</li>
            <li>Être averti avant qu'un cookie soit déposé.</li>
            <li>Supprimer les cookies déjà installés.</li>
        </ul>
        <p>Les paramètres de gestion des cookies varient selon les navigateurs. Vous trouverez généralement ces options dans les menus « Outils », « Préférences » ou « Paramètres » de votre navigateur.</p>

        <h2>5. Cookies tiers</h2>
        <p>Certains cookies sont déposés par des tiers (réseaux sociaux, services d'analyse). CADERSA n'a pas de contrôle sur ces cookies. Nous vous invitons à consulter les politiques de confidentialité de ces tiers pour en savoir plus.</p>

        <h2>6. Consentement</h2>
        <p>En continuant à naviguer sur le Site après avoir accepté le bandeau de dépôt de cookies, vous consentez à l'utilisation de cookies conformément à la présente Politique.</p>
        <p>Vous pouvez à tout moment retirer votre consentement en modifiant vos préférences via l'outil de gestion des cookies.</p>

        <h2>7. Contact</h2>
        <p>Pour toute question relative à la présente Politique de cookies, vous pouvez nous contacter :</p>
        <ul>
            <li><strong>E-mail :</strong> <a href="mailto:cadersa.asbl@gmail.com">cadersa.asbl@gmail.com</a></li>
            <li><strong>Adresse :</strong> N°041, Av. Mbaki, C/Ibanda, Bukavu/RDC</li>
        </ul>
        HTML;

        app(CookieSettings::class)->content = (new Editor)->setContent($html)->getDocument();
        app(CookieSettings::class)->save();
    }
}
