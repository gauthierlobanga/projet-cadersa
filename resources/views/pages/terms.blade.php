<x-layouts::main title="Conditions Générales d'Utilisation">
    <div class="relative min-h-[50vh] overflow-hidden bg-zinc-50 py-24 dark:bg-zinc-900">
        {{-- Décoration d'arrière-plan --}}
        <div class="pointer-events-none absolute inset-0 z-0 flex justify-center">
            <div
                class="absolute -top-[20%] left-1/2 aspect-square w-[800px] -translate-x-1/2 rounded-full bg-linear-to-br from-zinc-200/50 to-zinc-100/10 blur-[100px] dark:from-zinc-700/20 dark:to-transparent">
            </div>
            <div
                class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 mix-blend-overlay dark:opacity-10">
            </div>
        </div>

        <div class="relative z-10 mx-auto max-w-4xl px-6 lg:px-8">
            <div class="text-center">
                <flux:badge color="zinc" class="mb-4">Règles d'Usage</flux:badge>
                <h1 class="text-4xl font-bold tracking-tight text-zinc-900 sm:text-5xl dark:text-white">
                    Conditions d'Utilisation
                </h1>
                <p class="mt-6 text-lg leading-8 text-zinc-600 dark:text-zinc-400">
                    Les règles régissant l'utilisation de la plateforme web de CADERSA ASBL.
                </p>
            </div>
        </div>
    </div>

    <div class="relative z-20 mx-auto -mt-12 max-w-4xl px-6 pb-24 lg:px-8">
        <div
            class="overflow-hidden rounded-3xl border border-zinc-200/60 bg-white/80 p-8 shadow-xl shadow-zinc-200/20 backdrop-blur-xl sm:p-12 dark:border-zinc-800/60 dark:bg-zinc-900/80 dark:shadow-none">

            <div class="w-full max-w-none
                text-zinc-700 dark:text-zinc-300 text-base leading-relaxed
                [&>p]:mb-5 [&>p]:leading-relaxed
                [&>h1]:text-4xl [&>h1]:font-extrabold [&>h1]:tracking-tight [&>h1]:text-zinc-900 dark:[&>h1]:text-white [&>h1]:mb-8
                [&>h2]:text-3xl [&>h2]:font-extrabold [&>h2]:tracking-tight [&>h2]:text-zinc-900 dark:[&>h2]:text-white [&>h2]:mt-12 [&>h2]:mb-6 [&>h2]:border-b [&>h2]:border-emerald-100 dark:[&>h2]:border-emerald-900/30 [&>h2]:pb-4
                [&>h3]:text-2xl [&>h3]:font-bold [&>h3]:text-zinc-800 dark:[&>h3]:text-zinc-100 [&>h3]:mt-10 [&>h3]:mb-4
                [&_a]:font-medium [&_a]:text-emerald-600 dark:[&_a]:text-emerald-400 [&_a]:underline [&_a]:underline-offset-4 [&_a]:decoration-emerald-200 dark:[&_a]:decoration-emerald-900 hover:[&_a]:decoration-emerald-600 dark:hover:[&_a]:decoration-emerald-400 [&_a]:transition-colors
                [&>blockquote]:pl-6 [&>blockquote]:py-4 [&>blockquote]:my-8 [&>blockquote]:border-l-4 [&>blockquote]:border-emerald-500 [&>blockquote]:bg-gradient-to-r [&>blockquote]:from-emerald-50 [&>blockquote]:to-transparent dark:[&>blockquote]:from-emerald-900/20 [&>blockquote]:rounded-r-2xl [&>blockquote]:text-xl [&>blockquote]:italic [&>blockquote]:text-emerald-900 dark:[&>blockquote]:text-emerald-100 [&>blockquote]:font-serif
                [&>ul]:list-disc [&>ul]:pl-6 [&>ul]:mb-6 [&>ul]:space-y-3 [&>ul>li]:pl-2 [&>ul>li::marker]:text-emerald-500
                [&>ol]:list-decimal [&>ol]:pl-6 [&>ol]:mb-6 [&>ol]:space-y-3 [&>ol>li]:pl-2 [&>ol>li::marker]:text-emerald-500
                [&_img]:rounded-3xl [&_img]:shadow-2xl [&_img]:my-10 [&_img]:border [&_img]:border-zinc-100 dark:[&_img]:border-zinc-800 [&_img]:mx-auto
                [&_strong]:font-semibold [&_strong]:text-zinc-900 dark:[&_strong]:text-white">
                @php
                    $content = app(\App\Settings\TermsSettings::class)->content;
                @endphp
                @if(!empty($content) && isset($content['type']))
                    {!! (new \Tiptap\Editor)->setContent($content)->getHTML() !!}
                @else
                    <p>Contenu en cours de rédaction...</p>
                @endif
            </div>
        </div>
    </div>
</x-layouts::main>
