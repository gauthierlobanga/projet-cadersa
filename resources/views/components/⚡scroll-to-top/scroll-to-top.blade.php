<div 
    x-data="{
        show: false,
        init() {
            // Afficher le bouton après 300px de scroll
            window.addEventListener('scroll', () => {
                this.show = window.pageYOffset > 300;
            });
            this.show = window.pageYOffset > 300;
            
            // Animation GSAP au survol
            const button = $el.querySelector('button');
            const textWrapper = button.querySelector('[data-text]');
            const arrow = button.querySelector('svg');
            
            if (typeof SplitText !== 'undefined' && typeof gsap !== 'undefined') {
                const split = new SplitText(textWrapper, { type: 'chars' });
                const chars = split.chars;
                const tl = gsap.timeline({ paused: true });
                tl.to(chars, { keyframes: [{ y: -10, opacity: 0, duration: 0.2, ease: 'power2.in' }, { y: 10, opacity: 0, duration: 0 }, { y: 0, opacity: 1, duration: 0.2, ease: 'power2.out' }], stagger: 0.02 });
                tl.to(arrow, { keyframes: [{ y: -30, duration: 0.25, ease: 'power2.in' }, { y: 30, duration: 0 }, { y: 0, duration: 0.25, ease: 'power2.out' }] }, 0.1);
                button.addEventListener('mouseenter', () => tl.play());
                button.addEventListener('mouseleave', () => tl.reverse());
            }
        }
    }"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-8 scale-90"
    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
    x-transition:leave-end="opacity-0 translate-y-8 scale-90"
    class="fixed bottom-6 right-6 z-50 sm:bottom-8 sm:right-8"
    style="display: none;"
>
    <button data-button-pulse type="button" aria-label="Remonter en haut de la page"
        x-on:click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        class="inline-flex h-12 items-center gap-2 rounded-full bg-emerald-50 dark:bg-zinc-800 pr-5 pl-1.5 font-medium text-sm text-zinc-900 dark:text-zinc-100 shadow-xl shadow-emerald-500/10 transition-all duration-300 ease-out will-change-transform hover:scale-105 hover:bg-emerald-100 dark:hover:bg-emerald-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500/50">
        <div
            class="relative isolate grid size-9 place-items-center overflow-hidden rounded-full bg-zinc-900 dark:bg-emerald-600 text-white">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
            </svg>
        </div>
        <div class="overflow-hidden whitespace-nowrap text-sm" data-text>
            Retour en haut
        </div>
    </button>
</div>