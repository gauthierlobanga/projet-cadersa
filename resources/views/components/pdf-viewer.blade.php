{{-- resources/views/components/pdf-viewer.blade.php --}}
@props([
    'pdfUrl' => null,
    'label' => 'Lire le document',
    'modalTitle' => 'Document PDF',
    'buttonClass' => 'inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300 font-medium transition-colors',
    'icon' => null,
])

@php
    $__pdfViewerId = 'pdf-viewer-'.\Illuminate\Support\Str::random(8);
@endphp

<div id="{{ $__pdfViewerId }}" wire:ignore x-data="pdfViewer(@json($pdfUrl))" data-pdf-url="{{ $pdfUrl }}">
    @if ($pdfUrl)
        {{-- Bouton d'ouverture --}}
        <button type="button" data-pdf-open-button
                @click="openModal()"
                class="{{ $buttonClass }}"
                aria-label="{{ $label }}">
            @if ($icon)
                {{ $icon }}
            @else
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            @endif
            <span>{{ $label }}</span>
        </button>

        {{-- ===== MODALE ===== --}}
        <div data-pdf-modal x-show="open"
             x-cloak
             x-transition:enter.duration.300.opacity
             x-transition:leave.duration.200.opacity
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-zinc-900/70 backdrop-blur-sm"
             @click.self="closeModal()"
             @keydown.escape.window="closeModal()"
             role="dialog"
             aria-modal="true"
             aria-labelledby="pdf-modal-title">

            <div class="relative w-full max-w-6xl max-h-[95vh] bg-white dark:bg-zinc-900 shadow-2xl overflow-hidden flex flex-col"
                 x-transition:enter.duration.500.scale.90
                 x-transition:leave.duration.300.scale.95
                 @click.stop>

                {{-- En-tête --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900/50 shrink-0">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span id="pdf-modal-title" class="font-semibold text-zinc-900 dark:text-white">{{ $modalTitle }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ $pdfUrl }}"
                           download
                           class="p-2 text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200 transition-colors rounded hover:bg-zinc-100 dark:hover:bg-zinc-800"
                           aria-label="Télécharger le PDF"
                           title="Télécharger">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                        </a>
                        <button type="button" data-pdf-close-button
                                @click="closeModal()"
                                class="p-2 text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200 transition-colors rounded hover:bg-zinc-100 dark:hover:bg-zinc-800"
                                aria-label="Fermer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Contenu PDF --}}
                <div class="flex-1 p-2 bg-zinc-100 dark:bg-zinc-800 overflow-hidden relative min-h-[60vh]">
                    {{-- État de chargement --}}
                    <div x-show="loading"
                         x-transition.opacity.duration.300
                         class="absolute inset-0 flex items-center justify-center bg-zinc-100 dark:bg-zinc-800 z-10">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-12 h-12 border-4 border-emerald-500 border-t-transparent rounded-full animate-spin"></div>
                            <span class="text-sm text-zinc-500 dark:text-zinc-400">Chargement du document...</span>
                        </div>
                    </div>

                    {{-- Message d'erreur --}}
                    <div x-show="error"
                         x-transition.opacity.duration.300
                         class="absolute inset-0 flex items-center justify-center bg-zinc-100 dark:bg-zinc-800 z-10">
                        <div class="text-center max-w-md px-6">
                            <svg class="w-16 h-16 text-red-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-zinc-800 dark:text-zinc-200 font-medium">Impossible d'afficher le document</p>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Veuillez réessayer ou télécharger le fichier.</p>
                            <div class="mt-4 flex items-center justify-center gap-3">
                                <button type="button"
                                        @click="retry()"
                                        class="px-4 py-2 bg-emerald-600 text-white hover:bg-emerald-700 transition">
                                    Réessayer
                                </button>
                                <a x-bind:href="pdfUrl"
                                   target="_blank"
                                   rel="noopener"
                                   class="px-4 py-2 border border-zinc-300 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition">
                                    Ouvrir dans un nouvel onglet
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Lecteur PDF (iframe) --}}
                    <iframe x-ref="pdfIframe"
                                                x-bind:src="pdfUrl"
                            class="w-full h-full min-h-[60vh]"
                            frameborder="0"
                            x-on:load="handleIframeLoad()"
                            x-on:error="handleIframeError()">
                    </iframe>
                </div>

                {{-- Pied de page --}}
                <div class="flex items-center justify-between px-6 py-3 border-t border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900/50 shrink-0 text-xs text-zinc-500 dark:text-zinc-400">
                    <span>Lisez le document directement dans votre navigateur.</span>
                    <span>PDF · <span x-text="pdfUrl ? '✓' : 'Indisponible'"></span></span>
                </div>
            </div>
        </div>
    @else
        <span class="text-sm text-zinc-400 dark:text-zinc-600">Aucun document PDF</span>
    @endif
</div>

@once
    <script>
        (function() {
            const register = () => {
                Alpine.data('pdfViewer', (initialUrl) => ({
                    open: false,
                    pdfUrl: initialUrl ?? null,
                    loading: true,
                    error: false,
                    iframeLoaded: false,

                    init() {
                        if (!this.pdfUrl) return;
                        const link = document.createElement('link');
                        link.rel = 'prefetch';
                        link.href = this.pdfUrl;
                        document.head.appendChild(link);
                    },

                    openModal() {
                        this.open = true;
                        this.loading = true;
                        this.error = false;
                        this.iframeLoaded = false;
                        this.$nextTick(() => {
                            const iframe = this.$refs.pdfIframe;
                            if (iframe) iframe.src = this.pdfUrl;
                        });
                    },

                    closeModal() {
                        this.open = false;
                        this.loading = false;
                        this.error = false;
                        this.iframeLoaded = false;
                        this.$nextTick(() => {
                            const iframe = this.$refs.pdfIframe;
                            if (iframe) iframe.src = '';
                        });
                    },

                    handleIframeLoad() {
                        this.loading = false;
                        this.error = false;
                        this.iframeLoaded = true;
                    },

                    handleIframeError() {
                        this.loading = false;
                        this.error = true;
                    },

                    retry() {
                        this.loading = true;
                        this.error = false;
                        this.iframeLoaded = false;
                        const iframe = this.$refs.pdfIframe;
                        if (iframe) iframe.src = this.pdfUrl;
                    },

                    openPdfExternal() {
                        if (!this.pdfUrl) return;
                        window.open(this.pdfUrl, '_blank', 'noopener');
                    },
                }));
            };

            if (window.Alpine) {
                register();
            } else {
                document.addEventListener('alpine:init', register);
            }
        })();
    </script>
@endonce

<script>
    (function(){
        const root = document.getElementById("{{ $__pdfViewerId }}");
        if (!root) return;
        const openBtn = root.querySelector('[data-pdf-open-button]');
        const closeBtn = root.querySelector('[data-pdf-close-button]');
        const modal = root.querySelector('[data-pdf-modal]');
        const iframe = root.querySelector('iframe');
        const pdfUrl = root.dataset.pdfUrl;

        // Fallback handlers — run even if Alpine is present to ensure modal works when Alpine/Livewire is broken
        if (openBtn) {
            openBtn.addEventListener('click', function (e) {
                try {
                    if (modal) {
                        modal.style.display = 'flex';
                    }
                    if (iframe && pdfUrl) {
                        iframe.src = pdfUrl;
                    }
                } catch (err) {
                    // silent
                }
            });
        }

        if (closeBtn) {
            closeBtn.addEventListener('click', function () {
                try {
                    if (modal) modal.style.display = 'none';
                    if (iframe) iframe.src = '';
                } catch (err) {}
            });
        }

        if (modal) {
            modal.addEventListener('click', function (e) {
                if (e.target === modal) {
                    try {
                        modal.style.display = 'none';
                        if (iframe) iframe.src = '';
                    } catch (err) {}
                }
            });
        }
    })();
</script>