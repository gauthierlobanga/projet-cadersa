<?php

use Livewire\Component;
use App\Models\Service;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;

new #[Layout('layouts::main')] class extends Component {
    #[Computed]
    public function services()
    {
        return Service::query()->with('media')->where('is_active', true)->orderBy('sort_order')->get();
    }

    #[Computed]
    public function stats()
    {
        return [
            'services' => Service::active()->count(),
            'categories' => 7, // à adapter selon votre contexte
            'projets' => \App\Models\Project::active()->count(),
        ];
    }
};
?>

<div class="min-h-screen bg-zinc-50 dark:bg-zinc-950">
    {{-- Header (même style que Blog) --}}
    <section wire:cloak class="relative overflow-hidden bg-[#fafaf9] py-18 sm:py-24 lg:py-28 dark:bg-zinc-950"
        x-data="{ shown: false }" x-intersect.once="shown = true">
        <div class="pointer-events-none absolute inset-0 z-0">
            <div
                class="absolute -top-40 right-0 h-150 w-150 rounded-full bg-linear-to-br from-emerald-200/20 to-teal-100/0 blur-3xl dark:from-emerald-500/5 dark:to-transparent">
            </div>
            <div
                class="absolute -bottom-20 -left-20 h-125 w-125 rounded-full bg-linear-to-tr from-zinc-200/40 to-emerald-100/0 blur-3xl dark:from-zinc-900/50 dark:to-transparent">
            </div>
            <div
                class="absolute inset-0 bg-[linear-gradient(to_right,#8080800a_1px,transparent_1px),linear-gradient(to_bottom,#8080800a_1px,transparent_1px)] bg-size-[14px_24px] mask-[radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)]">
            </div>
        </div>

        <div class="relative z-10 mx-auto max-w-7xl px-6 lg:px-8">
            <div class="grid grid-cols-1 items-start gap-16 lg:grid-cols-12 lg:gap-24">
                <div class="flex flex-col items-start gap-6 lg:col-span-7">
                    <div class="inline-flex items-center gap-2.5 rounded-full border border-zinc-200 bg-white/80 px-3.5 py-1 text-[11px] font-medium uppercase tracking-[0.15em] text-zinc-500 backdrop-blur-md transition-all duration-300 ease-[cubic-bezier(0.16,1,0.3,1)] dark:border-zinc-800 dark:bg-zinc-900/80 dark:text-zinc-400"
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-3'">
                        <span class="relative flex h-1.5 w-1.5">
                            <span
                                class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                            <span
                                class="relative inline-flex h-1.5 w-1.5 rounded-full bg-emerald-500 dark:bg-emerald-400"></span>
                        </span>
                        Services
                    </div>
                    <h1 class="text-pretty text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold tracking-tight text-zinc-950 font-serif dark:text-zinc-50 transition-all duration-500 delay-100 ease-[cubic-bezier(0.16,1,0.3,1)]"
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                        <span>
                            Mes services dans différents
                        </span>
                        <span
                            class="relative inline-block bg-linear-to-r from-emerald-600 via-emerald-500 to-teal-600 bg-clip-text text-transparent dark:from-emerald-400 dark:via-emerald-300 dark:to-teal-400">
                            domaines
                        </span>
                    </h1>
                    <p class="max-w-2xl text-lg leading-relaxed text-zinc-600/90 dark:text-zinc-400 font-sans transition-all duration-500 delay-200 ease-[cubic-bezier(0.16,1,0.3,1)]"
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                        Découvrez mes services dans différents domaines, allant du développement web à la conception
                        graphique, en passant par le marketing digital et bien plus encore. Je m'engage à fournir des
                        solutions de qualité pour répondre à vos besoins spécifiques.
                    </p>
                </div>
                <div class="w-full lg:col-span-5 lg:pt-4 transition-all duration-500 delay-300 ease-[cubic-bezier(0.16,1,0.3,1)]"
                    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'">
                    <div
                        class="group relative overflow-hidden bg-white/40 p-8 transition-all duration-500 dark:border-zinc-800 dark:bg-zinc-900/40">
                        <div class="relative z-10 flex flex-col gap-8">
                            <div class="grid grid-cols-2 gap-x-8 gap-y-10 sm:grid-cols-3 lg:grid-cols-2">
                                @foreach ($this->stats as $label => $value)
                                    <div x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false"
                                        class="group relative min-w-24 px-4 py-3 text-center xs:min-w-27 transition-all duration-300 delay-{{ 300 + $loop->index * 100 }}"
                                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                                        <div class="absolute inset-0 rounded-xl bg-emerald-50/80 transition duration-300 ease-out group-hover:bg-emerald-100 dark:bg-white/5 dark:group-hover:bg-emerald-500/10"
                                            aria-hidden="true"></div>
                                        <div class="relative z-10 flex flex-col items-center">
                                            <span
                                                class="text-xs font-semibold uppercase tracking-widest text-zinc-500 group-hover:text-emerald-700 transition-colors duration-300 dark:text-zinc-400 dark:group-hover:text-emerald-300">{{ $label }}</span>
                                            <span
                                                class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $value }}</span>
                                        </div>
                                        {{-- Coins décoratifs --}}
                                        <svg class="absolute top-0 left-0 h-2.5 text-emerald-400 transition-transform duration-300 ease-out"
                                            :class="{ '-translate-x-1 -translate-y-1': hover }" viewBox="0 0 11 11"
                                            fill="none">
                                            <path d="M9.5 0.5H0.5V9.5" stroke="currentColor" stroke-linecap="round" />
                                        </svg>
                                        <svg class="absolute bottom-0 left-0 h-2.5 -scale-y-100 text-emerald-400 transition-transform duration-300 ease-out"
                                            :class="{ '-translate-x-1 translate-y-1': hover }" viewBox="0 0 11 11"
                                            fill="none">
                                            <path d="M9.5 0.5H0.5V9.5" stroke="currentColor" stroke-linecap="round" />
                                        </svg>
                                        <svg class="absolute top-0 right-0 h-2.5 -scale-x-100 text-emerald-400 transition-transform duration-300 ease-out"
                                            :class="{ 'translate-x-1 -translate-y-1': hover }" viewBox="0 0 11 11"
                                            fill="none">
                                            <path d="M9.5 0.5H0.5V9.5" stroke="currentColor" stroke-linecap="round" />
                                        </svg>
                                        <svg class="absolute bottom-0 right-0 h-2.5 -scale-x-100 -scale-y-100 text-emerald-400 transition-transform duration-300 ease-out"
                                            :class="{ 'translate-x-1 translate-y-1': hover }" viewBox="0 0 11 11"
                                            fill="none">
                                            <path d="M9.5 0.5H0.5V9.5" stroke="currentColor" stroke-linecap="round" />
                                        </svg>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        {{-- Coins graphiques --}}
                        <div
                            class="absolute top-3 left-3 size-1.5 border-t border-l border-zinc-300 opacity-40 dark:border-zinc-700">
                        </div>
                        <div
                            class="absolute top-3 right-3 size-1.5 border-t border-r border-zinc-300 opacity-40 dark:border-zinc-700">
                        </div>
                        <div
                            class="absolute bottom-3 left-3 size-1.5 border-b border-l border-zinc-300 opacity-40 dark:border-zinc-700">
                        </div>
                        <div
                            class="absolute bottom-3 right-3 size-1.5 border-b border-r border-zinc-300 opacity-40 dark:border-zinc-700">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Grille des services (style carte inspiré du blog) --}}
    <section class="px-5 py-8 xs:px-8 md:p-10 mx-auto max-w-7xl lg:px-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
            @forelse ($this->services as $service)
                <a href="{{ route('services.show', $service) }}" wire:navigate
                    class="gsap-reveal group relative flex flex-col border border-zinc-200/50 bg-white transition-all duration-500 ease-out
                           hover:-translate-y-1 hover:border-emerald-300 hover:shadow hover:shadow-emerald-100/30
                           dark:border-zinc-700/60 dark:bg-zinc-900 dark:hover:border-emerald-700 dark:hover:shadow-emerald-900/20">
                    {{-- Image --}}
                    @if ($service->hasMedia('image'))
                        <div
                            class="overflow-hidden ring-1 ring-zinc-200 transition duration-500 ease-out group-hover:ring-emerald-300 dark:ring-zinc-700 dark:group-hover:ring-emerald-700">
                            <img loading="eager" decoding="async" src="{{ $service->getFirstMediaUrl('image', 'card') }}"
                                alt="{{ $service->title }}"
                                class="aspect-video w-full object-cover transition duration-300 ease-out group-hover:scale-105"
                                loading="eager" />
                        </div>
                    @else
                        <div
                            class="flex aspect-video w-full items-center justify-center bg-zinc-100 text-zinc-400 dark:bg-zinc-800">
                            <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                    <div class="flex flex-1 flex-col gap-2 p-4">
                        <p
                            class="line-clamp-1 font-outfit font-medium text-zinc-900 transition-colors duration-300 group-hover:text-emerald-600 dark:text-white dark:group-hover:text-emerald-400">
                            {{ $service->title }}
                        </p>
                        <p class="line-clamp-2 text-sm text-zinc-500 dark:text-zinc-400">
                            {{ $service->short_excerpt ?? $service->getPlainTextContent(120) }}</p>
                        <div class="mt-5 flex items-center justify-between gap-3">
                            <div
                                class="flex shrink-0 items-center gap-1 text-sm font-medium text-emerald-600 opacity-0 transition-all duration-300 group-hover:opacity-100 group-hover:gap-2 dark:text-emerald-400">
                                Découvrir
                                <svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 12h14m-6-6l6 6-6 6" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-16 text-center text-zinc-500">Aucun service disponible pour le moment.
                </div>
            @endforelse
        </div>

    </section>

    <div class="grid grid-cols-1 gap-7 md:grid-cols-2 lg:grid-cols-3">
        @php $colors = ['orange', 'emerald', 'blue', 'purple', 'rose', 'teal']; @endphp
        @foreach ($this->services as $service)
            @php $color = $colors[$loop->index % count($colors)]; @endphp
            <div x-cloak x-data="cspState" x-intersect="shown = true"
                :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                class="transition-all duration-300 ease-out" style="transition-delay: {{ $loop->index * 75 }}ms">
                <a href="{{ $service->url }}" wire:navigate
                    class="group relative flex h-full flex-col border border-zinc-200/50 bg-white transition-all duration-500 ease-out
                                   hover:-translate-y-1 hover:border-emerald-300 hover:shadow hover:shadow-emerald-100/30
                                   dark:border-zinc-700/60 dark:bg-zinc-900 dark:hover:border-emerald-700 dark:hover:shadow-emerald-900/20">
                    {{-- corps de la carte inchangé --}}
                    <div class="flex flex-1 flex-col gap-3 p-5">
                        <div class="flex items-center gap-3">
                            <div
                                class="relative transition duration-300 ease-out will-change-transform group-hover:translate-x-4.5">
                                <div
                                    class="flex h-20 w-20 items-center justify-center bg-{{ $color }}-50 text-{{ $color }}-600 transition-all duration-300 group-hover:scale-110 dark:bg-{{ $color }}-900/20 dark:text-{{ $color }}-400">
                                    @if ($service->hasMedia('service_icon'))
                                        <img loading="eager" decoding="async"
                                            src="{{ $service->getFirstMediaUrl('service_icon') }}"
                                            alt="{{ $service->title }}" class="h-20 w-20 object-contain" />
                                        {{-- @else
                                                <flux:icon name="service.{{ $service->icon }}" variant="solid" class="h-10 w-10" /> --}}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <h3
                            class="text-lg font-semibold text-zinc-900 transition-colors duration-300 group-hover:text-emerald-600 dark:text-white dark:group-hover:text-emerald-400">
                            {{ $service->title }}
                        </h3>
                        <p class="flex-1 text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">
                            {!! $service->short_excerpt !!}
                        </p>
                    </div>

                    <div class="flex h-11 items-stretch text-sm font-medium">
                        <div
                            class="inline-flex grow items-center justify-between gap-3 px-4 bg-emerald-50 text-emerald-700 transition-all duration-300 ease-out group-hover:bg-emerald-100 dark:bg-emerald-900/20 dark:text-emerald-300 dark:group-hover:bg-emerald-900/30">
                            <span>En savoir plus</span>
                            <span class="transition duration-300 ease-out group-hover:translate-x-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 28 22"
                                    fill="none">
                                    <path class="fill-current"
                                        d="M1 10H5.96046e-08V12H1V10ZM27 12C27.5523 12 28 11.5523 28 11C28 10.4477 27.5523 10 27 10V12ZM18 1V5.96046e-08H16V1H18ZM26.4207 11.7774C26.9055 12.0419 27.5129 11.8632 27.7774 11.3783C28.0419 10.8935 27.8632 10.286 27.3783 10.0216L26.4207 11.7774ZM15.9999 20.8995V21.8995H17.9999V20.8995H15.9999ZM1 12H26.8994V10H1V12ZM26.8994 12H27V10H26.8994V12ZM16 1C16 2.47241 16.7953 3.87873 17.7716 5.0769C18.7678 6.29956 20.0716 7.44977 21.3383 8.42854C22.6109 9.41186 23.8784 10.2469 24.825 10.835C25.2993 11.1295 25.6952 11.3635 25.9738 11.5245C26.1131 11.605 26.2233 11.6674 26.2993 11.71C26.3374 11.7314 26.3669 11.7478 26.3873 11.7591C26.3975 11.7647 26.4055 11.7691 26.411 11.7721C26.4138 11.7737 26.416 11.7749 26.4176 11.7758C26.4184 11.7762 26.4191 11.7765 26.4196 11.7768C26.4199 11.777 26.4201 11.7771 26.4202 11.7772C26.4205 11.7773 26.4207 11.7774 26.8995 10.8995C27.3783 10.0216 27.3784 10.0217 27.3785 10.0217C27.3785 10.0217 27.3785 10.0217 27.3785 10.0217C27.3784 10.0216 27.3781 10.0215 27.3777 10.0213C27.3769 10.0208 27.3756 10.0201 27.3736 10.019C27.3697 10.0168 27.3634 10.0134 27.3549 10.0087C27.3378 9.99926 27.3118 9.98479 27.2773 9.96547C27.2084 9.92682 27.1058 9.86878 26.9745 9.79288C26.7117 9.64102 26.3342 9.41799 25.8804 9.13606C24.9708 8.57104 23.7635 7.77501 22.5612 6.84596C21.353 5.91235 20.182 4.86894 19.322 3.81356C18.4422 2.73371 18 1.77759 18 1H16ZM26.8994 11C26.5248 10.0728 26.5245 10.0729 26.5242 10.0731C26.524 10.0731 26.5237 10.0733 26.5234 10.0734C26.5228 10.0736 26.522 10.0739 26.5211 10.0743C26.5193 10.0751 26.5169 10.076 26.5138 10.0773C26.5078 10.0797 26.4994 10.0832 26.4888 10.0876C26.4674 10.0964 26.4369 10.1091 26.3979 10.1257C26.3199 10.1587 26.2077 10.2071 26.0662 10.2703C25.7834 10.3967 25.3826 10.5825 24.903 10.824C23.9463 11.3055 22.6639 12.0142 21.3751 12.919C20.0914 13.8201 18.7665 14.94 17.7546 16.2535C16.7415 17.5685 15.9999 19.1342 15.9999 20.8995H17.9999C17.9999 19.715 18.4958 18.5685 19.3389 17.4742C20.1831 16.3784 21.333 15.3922 22.5242 14.5559C23.7103 13.7232 24.9028 13.0632 25.8022 12.6104C26.2507 12.3846 26.6233 12.2119 26.8818 12.0965C27.011 12.0388 27.1115 11.9955 27.1785 11.967C27.212 11.9528 27.2371 11.9424 27.2533 11.9357C27.2613 11.9324 27.2671 11.93 27.2706 11.9286C27.2724 11.9279 27.2735 11.9274 27.2741 11.9271C27.2744 11.927 27.2745 11.927 27.2745 11.927C27.2745 11.927 27.2744 11.927 27.2744 11.927C27.2742 11.9271 27.274 11.9272 26.8994 11Z" />
                                </svg>
                            </span>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
