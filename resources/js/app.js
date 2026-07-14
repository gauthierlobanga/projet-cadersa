import { gsap } from "gsap";
import autoAnimate from "@formkit/auto-animate";

import { CustomEase } from "gsap/CustomEase";
// CustomBounce requires CustomEase
import { CustomBounce } from "gsap/CustomBounce";
// CustomWiggle requires CustomEase
import { CustomWiggle } from "gsap/CustomWiggle";
import { RoughEase, ExpoScaleEase, SlowMo } from "gsap/EasePack";

import { Draggable } from "gsap/Draggable";
import { DrawSVGPlugin } from "gsap/DrawSVGPlugin";
import { EaselPlugin } from "gsap/EaselPlugin";
import { Flip } from "gsap/Flip";
import { GSDevTools } from "gsap/GSDevTools";
import { MotionPathHelper } from "gsap/MotionPathHelper";
import { MotionPathPlugin } from "gsap/MotionPathPlugin";
import { MorphSVGPlugin } from "gsap/MorphSVGPlugin";
import { Observer } from "gsap/Observer";
import { Physics2DPlugin } from "gsap/Physics2DPlugin";
import { PixiPlugin } from "gsap/PixiPlugin";
import { ScrambleTextPlugin } from "gsap/ScrambleTextPlugin";
import { ScrollTrigger } from "gsap/ScrollTrigger";
// ScrollSmoother requires ScrollTrigger
import { ScrollSmoother } from "gsap/ScrollSmoother";
import { ScrollToPlugin } from "gsap/ScrollToPlugin";
import { SplitText } from "gsap/SplitText";
import { TextPlugin } from "gsap/TextPlugin";

globalThis.gsap = globalThis.gsap || gsap;
globalThis.SplitText = globalThis.SplitText || SplitText;
globalThis.ScrollTrigger = globalThis.ScrollTrigger || ScrollTrigger;
globalThis.autoAnimate = globalThis.autoAnimate || autoAnimate;

if (typeof window !== 'undefined') {
    window.gsap = window.gsap || gsap;
    window.SplitText = window.SplitText || SplitText;
    window.ScrollTrigger = window.ScrollTrigger || ScrollTrigger;
    window.autoAnimate = window.autoAnimate || autoAnimate;
}

gsap.registerPlugin(Draggable,DrawSVGPlugin,EaselPlugin,Flip,GSDevTools,MotionPathHelper,MotionPathPlugin,MorphSVGPlugin,Observer,Physics2DPlugin,PixiPlugin,ScrambleTextPlugin,ScrollTrigger,ScrollSmoother,ScrollToPlugin,SplitText,TextPlugin,RoughEase,ExpoScaleEase,SlowMo,CustomEase,CustomBounce,CustomWiggle);

const registerCookieConsentAlpineData = () => {
    const register = () => {
        Alpine.data('cookieConsent', () => ({
            show: false,
            preferences: false,

            init() {
                const getWireId = () => {
                    let element = this.$el;

                    while (element) {
                        if (element.hasAttribute && element.hasAttribute('wire:id')) {
                            return element.getAttribute('wire:id');
                        }

                        element = element.parentElement;
                    }

                    return null;
                };

                const bindEntangle = () => {
                    const wireId = getWireId();
                    const component = wireId ? window.Livewire?.find(wireId) : null;

                    if (!component) {
                        document.addEventListener('livewire:load', bindEntangle, { once: true });
                        return;
                    }

                    this.show = component.entangle('showBanner');
                    this.preferences = component.entangle('showPreferences');
                };

                bindEntangle();

                if (this.show && typeof gsap !== 'undefined') {
                    const banner = this.$refs.banner;
                    if (banner) {
                        gsap.set(banner, { yPercent: 120, opacity: 0 });
                        setTimeout(() => {
                            gsap.to(banner, {
                                yPercent: 0,
                                opacity: 1,
                                duration: 0.7,
                                ease: 'power4.out',
                                clearProps: 'transform',
                            });
                        }, 400);
                    }
                }

                this.$watch('show', value => {
                    if (!value && this.$refs.banner && typeof gsap !== 'undefined') {
                        gsap.to(this.$refs.banner, {
                            yPercent: 120,
                            opacity: 0,
                            duration: 0.5,
                            ease: 'power3.in',
                        });
                    }
                });

                this.$watch('preferences', value => {
                    if (typeof gsap === 'undefined') {
                        return;
                    }

                    if (value) {
                        gsap.fromTo(
                            this.$refs.modal,
                            { y: 40, opacity: 0, scale: 0.96 },
                            { y: 0, opacity: 1, scale: 1, duration: 0.5, ease: 'back.out(1.1)' }
                        );
                        gsap.fromTo(this.$refs.backdrop, { opacity: 0 }, { opacity: 1, duration: 0.4 });
                    } else {
                        gsap.to(this.$refs.modal, {
                            y: 20,
                            opacity: 0,
                            scale: 0.96,
                            duration: 0.25,
                            ease: 'power2.in',
                        });
                        gsap.to(this.$refs.backdrop, { opacity: 0, duration: 0.25 });
                    }
                });
            },
        }));
    };

    if (window.Alpine) {
        register();
    }

    document.addEventListener('alpine:init', register, { once: true });
};

registerCookieConsentAlpineData();

// ==========================================
// GLOBAL PRO ANIMATIONS (FILAMENT PRO STYLE)
// ==========================================

const initGlobalAnimations = () => {
    // Prevent re-initialization on elements that are already animated
    ScrollTrigger.refresh();

    // 1. SPLIT TEXT HEADINGS ANIMATION
    // Target h1, h2, h3 for a premium staggered word reveal
    const headings = gsap.utils.toArray('main h1, main h2, main h3, .prose h1, .prose h2, .prose h3');
    headings.forEach(heading => {
        // Skip if already animated, hidden, or explicitly marked no-animate
        if (heading.dataset.gsapAnimated || heading.closest('.no-animate')) return;
        heading.dataset.gsapAnimated = 'true';

        // Prevent layout shift during split
        const split = new SplitText(heading, { type: "words,lines" });

        gsap.fromTo(split.words,
            { opacity: 0, y: 20, rotateX: -20 },
            {
                opacity: 1,
                y: 0,
                rotateX: 0,
                duration: 0.8,
                stagger: 0.03,
                ease: "power3.out",
                scrollTrigger: {
                    trigger: heading,
                    start: "top 92%",
                    once: true // Only animate once per page load
                }
            }
        );
    });

    // 2. BATCH FADE-UP FOR CONTENT BLOCKS
    // Target paragraphs, cards, images for smooth scrolling entrance
    const contentBlocks = gsap.utils.toArray('main p, main img, main ul, .flux-card, .prose > div, article, .rounded-3xl, .grid > a.group, .grid > div.group, .gsap-reveal');

    const blocksToAnimate = contentBlocks.filter(block => {
        // Skip elements inside specific interactive components to avoid conflict
        if (
            block.dataset.gsapAnimated ||
            block.closest('.no-animate') ||
            block.closest('[x-data="cookieConsent()"]') ||
            block.closest('header') ||
            block.closest('nav')
        ) {
            return false;
        }
        return true;
    });

    blocksToAnimate.forEach(block => {
        block.dataset.gsapAnimated = 'true';
    });

    ScrollTrigger.batch(blocksToAnimate, {
        start: "top 92%",
        once: true, // Only animate once per page load
        onEnter: batch => gsap.fromTo(batch,
            { opacity: 0, y: 30, scale: 0.98 },
            { opacity: 1, y: 0, scale: 1, stagger: 0.08, duration: 0.8, ease: "power3.out", overwrite: true }
        )
    });

    // 3. PAGE LOAD FADE-IN
    // Ensure the main container enters smoothly on initial load/navigate
    const mainContainer = document.querySelector('.flex-1');
    if (mainContainer && !mainContainer.dataset.pageAnimated) {
        mainContainer.dataset.pageAnimated = 'true';
        gsap.fromTo(mainContainer,
            { opacity: 0, y: 15 },
            { opacity: 1, y: 0, duration: 0.6, ease: "power2.out", delay: 0.1 }
        );
    }
};

// Hook into Livewire navigation events (SPA mode)
document.addEventListener('livewire:navigated', () => {
    // Short delay to let Livewire render the DOM
    setTimeout(initGlobalAnimations, 50);
});

// Hook into standard DOM load
document.addEventListener('DOMContentLoaded', () => {
    initGlobalAnimations();
});
