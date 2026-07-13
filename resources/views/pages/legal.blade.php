<x-layouts.main title="Mentions Légales">
    <div class="relative min-h-[50vh] overflow-hidden bg-zinc-50 py-24 dark:bg-zinc-900">
        {{-- Décoration d'arrière-plan --}}
        <div class="pointer-events-none absolute inset-0 z-0 flex justify-center">
            <div
                class="absolute -top-[20%] left-1/2 aspect-square w-[800px] -translate-x-1/2 rounded-full bg-linear-to-br from-emerald-100/40 to-teal-50/10 blur-[100px] dark:from-emerald-500/10 dark:to-transparent">
            </div>
            <div
                class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 mix-blend-overlay dark:opacity-10">
            </div>
        </div>

        <div class="relative z-10 mx-auto max-w-4xl px-6 lg:px-8">
            <div class="text-center">
                <flux:badge color="emerald" class="mb-4">Informations Juridiques</flux:badge>
                <h1 class="text-4xl font-bold tracking-tight text-zinc-900 sm:text-5xl dark:text-white">
                    Mentions Légales
                </h1>
                <p class="mt-6 text-lg leading-8 text-zinc-600 dark:text-zinc-400">
                    Transparence et conformité concernant l'édition et l'hébergement du site de CADERSA ASBL.
                </p>
            </div>
        </div>
    </div>

    <div class="relative z-20 mx-auto -mt-12 max-w-4xl px-6 pb-24 lg:px-8">
        <div
            class="overflow-hidden rounded-3xl border border-zinc-200/60 bg-white/80 p-8 shadow-xl shadow-zinc-200/20 backdrop-blur-xl sm:p-12 dark:border-zinc-800/60 dark:bg-zinc-900/80 dark:shadow-none">
            
            <div class="prose prose-lg prose-emerald max-w-none dark:prose-invert
                prose-headings:font-bold prose-headings:tracking-tight prose-headings:text-zinc-900 dark:prose-headings:text-zinc-100
                prose-h2:mt-10 prose-h2:mb-4 prose-h2:border-b prose-h2:border-zinc-200 prose-h2:pb-2 dark:prose-h2:border-zinc-800
                prose-h3:mt-8 prose-h3:mb-3
                prose-p:leading-relaxed prose-p:text-zinc-600 dark:prose-p:text-zinc-400
                prose-a:text-emerald-600 hover:prose-a:text-emerald-500 prose-a:no-underline hover:prose-a:underline dark:prose-a:text-emerald-400">
                
                <h2>1. Éditeur du Site</h2>
                <p>
                    Le présent site web est édité par <strong>CADERSA ASBL</strong> (Comité d'Action pour le Développement Rural et la Sécurité Alimentaire).<br>
                    Association Sans But Lucratif enregistrée conformément aux lois en vigueur en République Démocratique du Congo.
                </p>
                <ul>
                    <li><strong>Siège Social :</strong> Goma, Nord-Kivu, République Démocratique du Congo</li>
                    <li><strong>Téléphone :</strong> <a href="tel:+243997125301">+243 997 125 301</a></li>
                    <li><strong>Email :</strong> <a href="mailto:contact@cadersa.org">contact@cadersa.org</a></li>
                    <li><strong>Directeur de la publication :</strong> Prof. Dr Bernard HANGI</li>
                </ul>

                <h2>2. Hébergement</h2>
                <p>
                    L'hébergement de ce site est assuré par une structure professionnelle garantissant la sécurité et la disponibilité des données.
                </p>

                <h2>3. Propriété Intellectuelle</h2>
                <p>
                    L'ensemble de ce site relève de la législation congolaise et internationale sur le droit d'auteur et la propriété intellectuelle. 
                    Tous les droits de reproduction sont réservés, y compris pour les documents téléchargeables et les représentations iconographiques et photographiques.
                </p>
                <p>
                    La reproduction de tout ou partie de ce site sur un support électronique quel qu'il soit est formellement interdite sauf autorisation expresse du directeur de la publication.
                </p>

                <h2>4. Limitation de Responsabilité</h2>
                <p>
                    CADERSA ASBL s'efforce de fournir sur le site des informations aussi précises que possible. Toutefois, l'association ne pourra être tenue responsable des omissions, des inexactitudes et des carences dans la mise à jour, qu'elles soient de son fait ou du fait des tiers partenaires qui lui fournissent ces informations.
                </p>

                <h2>5. Réalisation du Site</h2>
                <p>
                    Site conçu et développé par <strong>Gauthier Lobanga</strong>.<br>
                    Profil GitHub : <a href="https://github.com/gauthierlobanga" target="_blank" rel="noopener noreferrer">github.com/gauthierlobanga</a>
                </p>
            </div>
        </div>
    </div>
</x-layouts.main>
