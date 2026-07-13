<x-layouts::main title="Politique de confidentialité">
    <div class="relative min-h-[50vh] overflow-hidden bg-zinc-50 py-24 dark:bg-zinc-900">
        {{-- Décoration d'arrière-plan --}}
        <div class="pointer-events-none absolute inset-0 z-0 flex justify-center">
            <div
                class="absolute -top-[20%] left-1/2 aspect-square w-[800px] -translate-x-1/2 rounded-full bg-linear-to-br from-blue-100/40 to-emerald-50/10 blur-[100px] dark:from-blue-500/10 dark:to-transparent">
            </div>
            <div
                class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 mix-blend-overlay dark:opacity-10">
            </div>
        </div>

        <div class="relative z-10 mx-auto max-w-4xl px-6 lg:px-8">
            <div class="text-center">
                <flux:badge color="blue" class="mb-4">Données Personnelles</flux:badge>
                <h1 class="text-4xl font-bold tracking-tight text-zinc-900 sm:text-5xl dark:text-white">
                    Politique de Confidentialité
                </h1>
                <p class="mt-6 text-lg leading-8 text-zinc-600 dark:text-zinc-400">
                    Nous accordons une importance primordiale à la protection et au respect de vos données personnelles.
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
                prose-li:text-zinc-600 dark:prose-li:text-zinc-400
                prose-a:text-emerald-600 hover:prose-a:text-emerald-500 prose-a:no-underline hover:prose-a:underline dark:prose-a:text-emerald-400">
                
                <h2>1. Collecte des Données Personnelles</h2>
                <p>
                    Lors de votre navigation sur notre site, CADERSA ASBL peut être amenée à collecter certaines données personnelles vous concernant, notamment lorsque :
                </p>
                <ul>
                    <li>Vous vous inscrivez à notre newsletter.</li>
                    <li>Vous remplissez le formulaire de contact.</li>
                    <li>Vous naviguez sur notre site (données de navigation anonymisées).</li>
                </ul>

                <h2>2. Utilisation des Données</h2>
                <p>
                    Les informations que nous recueillons sont utilisées dans les buts suivants :
                </p>
                <ul>
                    <li>Répondre à vos demandes de renseignements ou de partenariat.</li>
                    <li>Vous envoyer des actualités et informations sur nos projets (uniquement si vous y avez consenti).</li>
                    <li>Améliorer l'expérience utilisateur et les performances de notre site web.</li>
                </ul>

                <h2>3. Partage des Informations</h2>
                <p>
                    CADERSA ASBL s'engage à ne jamais vendre, échanger ou transférer vos informations personnelles identifiables à des tiers. Cela ne comprend pas les tierces parties de confiance qui nous aident à exploiter notre site web ou à mener nos affaires, tant que ces parties conviennent de garder ces informations confidentielles.
                </p>

                <h2>4. Protection des Informations</h2>
                <p>
                    Nous mettons en œuvre une variété de mesures de sécurité pour préserver la sécurité de vos informations personnelles. Le site utilise un certificat SSL pour garantir le chiffrement des données transitant entre votre navigateur et notre serveur.
                </p>

                <h2>5. Vos Droits</h2>
                <p>
                    Conformément aux normes internationales en matière de protection des données, vous disposez d'un droit d'accès, de rectification, de suppression et d'opposition aux données personnelles vous concernant. Vous pouvez exercer ce droit en nous contactant directement à : 
                    <a href="mailto:contact@cadersa.org">contact@cadersa.org</a>.
                </p>

                <h2>6. Modification de la Politique</h2>
                <p>
                    Nous nous réservons le droit de modifier cette politique de confidentialité à tout moment. Toute modification sera publiée sur cette page avec une date de mise à jour révisée.
                </p>
                <p class="text-sm italic mt-8 text-zinc-500">
                    Dernière mise à jour : Février 2026
                </p>
            </div>
        </div>
    </div>
</x-layouts.main>
