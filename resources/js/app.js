import { gsap } from "gsap";
// Import flowbite locally (avoid CDN / tracking prevention issues)
import "flowbite";
import autoAnimate from "@formkit/auto-animate";

import { ScrollTrigger } from "gsap/ScrollTrigger";
import { ScrollToPlugin } from "gsap/ScrollToPlugin";
import { SplitText } from "gsap/SplitText";

gsap.registerPlugin(ScrollTrigger, ScrollToPlugin, SplitText);

// Rendre disponibles globalement (utile dans les données Alpine)
const registerAlpineExtensions = () => {
    if (typeof Alpine === "undefined") {
        return;
    }

    Alpine.autoAnimate = Alpine.autoAnimate || autoAnimate;
};

registerAlpineExtensions();

globalThis.gsap = globalThis.gsap || gsap;
globalThis.SplitText = globalThis.SplitText || SplitText;
globalThis.ScrollTrigger = globalThis.ScrollTrigger || ScrollTrigger;
globalThis.autoAnimate = globalThis.autoAnimate || autoAnimate;

if (typeof window !== "undefined") {
    window.gsap = window.gsap || gsap;
    window.SplitText = window.SplitText || SplitText;
    window.ScrollTrigger = window.ScrollTrigger || ScrollTrigger;
    window.autoAnimate = window.autoAnimate || autoAnimate;
}

document.addEventListener("alpine:init", registerAlpineExtensions, {
    once: true,
});

// ---------- Utilitaires sécurisés ----------
const safeGsapFromTo = (target, fromVars, toVars) => {
    if (typeof gsap === "undefined") return;
    const arr = gsap.utils
        ? gsap.utils.toArray(target)
        : Array.isArray(target)
          ? target
          : [target];
    if (!arr || arr.length === 0) return;
    gsap.fromTo(arr, fromVars, toVars);
};

const safeGsapTo = (target, vars) => {
    if (typeof gsap === "undefined") return;
    const arr = gsap.utils
        ? gsap.utils.toArray(target)
        : Array.isArray(target)
          ? target
          : [target];
    if (!arr || arr.length === 0) return;
    gsap.to(arr, vars);
};

// ---------- Scroll to top (Alpine data global) ----------
document.addEventListener("alpine:init", () => {
    Alpine.data("scrollToTop", () => ({
        show: false,
        init() {
            window.addEventListener(
                "scroll",
                () => {
                    this.show = window.scrollY > 300;
                },
                { passive: true },
            );
            this.show = window.scrollY > 300;

            this.$nextTick(() => {
                const button = this.$el.querySelector("button");
                if (!button) return;

                const textWrapper = button.querySelector("[data-text]");
                const arrow = button.querySelector("svg");

                if (
                    typeof window.SplitText !== "undefined" &&
                    typeof window.gsap !== "undefined"
                ) {
                    try {
                        const split = new window.SplitText(textWrapper, {
                            type: "chars",
                        });
                        const chars = split.chars;
                        const tl = window.gsap.timeline({ paused: true });
                        tl.to(chars, {
                            keyframes: [
                                {
                                    y: -10,
                                    opacity: 0,
                                    duration: 0.2,
                                    ease: "power2.in",
                                },
                                { y: 10, opacity: 0, duration: 0 },
                                {
                                    y: 0,
                                    opacity: 1,
                                    duration: 0.2,
                                    ease: "power2.out",
                                },
                            ],
                            stagger: 0.02,
                        });
                        tl.to(
                            arrow,
                            {
                                keyframes: [
                                    {
                                        y: -30,
                                        duration: 0.25,
                                        ease: "power2.in",
                                    },
                                    { y: 30, duration: 0 },
                                    {
                                        y: 0,
                                        duration: 0.25,
                                        ease: "power2.out",
                                    },
                                ],
                            },
                            0.1,
                        );
                        button.addEventListener("mouseenter", () => tl.play());
                        button.addEventListener("mouseleave", () =>
                            tl.reverse(),
                        );
                    } catch (e) {
                        console.warn(
                            "GSAP animation failed (scroll-to-top)",
                            e,
                        );
                    }
                }
            });
        },
        scrollToTop() {
            window.scrollTo({ top: 0, behavior: "smooth" });
        },
    }));

    Alpine.data("pageProgress", () => ({
        progress: 0,
        init() {
            const updateProgress = () => {
                const scrollTop = window.scrollY || 0;
                const docHeight =
                    document.documentElement.scrollHeight - window.innerHeight;
                this.progress =
                    docHeight > 0
                        ? Math.min(100, (scrollTop / docHeight) * 100)
                        : 0;
            };

            window.addEventListener("scroll", updateProgress, {
                passive: true,
            });
            updateProgress();
        },
    }));

    Alpine.data("socialShare", () => ({
        shareUrl: "",
        shareTitle: "",
        copied: false,
        init() {
            this.shareUrl = this.$el.dataset.shareUrl || "";
            this.shareTitle = this.$el.dataset.shareTitle || "";
        },
        share(provider) {
            if (!this.shareUrl) {
                return;
            }

            const urls = {
                facebook: `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(this.shareUrl)}`,
                twitter: `https://twitter.com/intent/tweet?url=${encodeURIComponent(this.shareUrl)}&text=${encodeURIComponent(this.shareTitle)}`,
                linkedin: `https://www.linkedin.com/shareArticle?mini=true&url=${encodeURIComponent(this.shareUrl)}&title=${encodeURIComponent(this.shareTitle)}`,
                whatsapp: `https://api.whatsapp.com/send?text=${encodeURIComponent(`${this.shareTitle} - ${this.shareUrl}`)}`,
            };

            const url = urls[provider];
            if (!url) {
                return;
            }

            window.open(url, "_blank");
        },
        copyLink() {
            navigator.clipboard
                .writeText(this.shareUrl || window.location.href)
                .then(() => {
                    this.copied = true;
                    setTimeout(() => {
                        this.copied = false;
                    }, 3000);
                });
        },
    }));

    Alpine.data("postSearchFilters", () => ({
        search: "",
        showFilters: false,
        category: null,
        sortBy: "newest",
        sortDropdownOpen: false,
        listeningMessages: [
            "Whatcha looking for? 🔍",
            "I'm listening... 👀",
            "Go ahead, I'm ready 🎯",
            "Type away! ⌨️",
            "Searching is fun! 🤓",
            "What can I find for you? 🕵️‍♂️",
        ],
        listeningIndex: 0,
        get activeFilterCount() {
            return this.category ? 1 : 0;
        },
        get listeningMessage() {
            return this.listeningMessages[
                this.listeningIndex % this.listeningMessages.length
            ];
        },
        init() {
            this.$watch("category", (value) => {
                if (value) {
                    this.showFilters = true;
                }
            });
        },
        resetFilters() {
            this.category = null;
            this.sortBy = "newest";
            this.search = "";
            this.showFilters = false;
            if (this.$refs.filtersButton) {
                this.$refs.filtersButton.focus();
            }
            const target = document.querySelector("#scroll-to-reference");
            if (target) {
                target.scrollIntoView({ behavior: "smooth" });
            }
        },
        clearSearch() {
            this.search = "";
            this.$nextTick(() => {
                if (this.$refs.searchInput) {
                    this.$refs.searchInput.focus();
                }
            });
        },
        selectSort(value) {
            this.sortBy = value;
            if (this.$refs.filtersButton) {
                this.$refs.filtersButton.focus();
            }
        },
        rotateListeningMessage() {
            this.listeningIndex++;
        },
    }));

    Alpine.data("projectSearchFilters", () => ({
        search: "",
        showFilters: false,
        filter: "all",
        sortBy: "newest",
        get activeFilterCount() {
            return this.filter !== "all" ? 1 : 0;
        },
        resetFilters() {
            this.filter = "all";
            this.sortBy = "newest";
            this.search = "";
            this.showFilters = false;
            if (this.$refs.filtersButton) {
                this.$refs.filtersButton.focus();
            }
            const target = document.querySelector("#scroll-to-reference");
            if (target) {
                target.scrollIntoView({ behavior: "smooth" });
            }
        },
        clearSearch() {
            this.search = "";
            this.$nextTick(() => {
                if (this.$refs.searchInput) {
                    this.$refs.searchInput.focus();
                }
            });
        },
        selectSort(value) {
            this.sortBy = value;
            if (this.$refs.filtersButton) {
                this.$refs.filtersButton.focus();
            }
        },
    }));

    Alpine.data("footerScrollReveal", () => ({
        init() {
            this.$nextTick(() => {
                if (
                    typeof gsap === "undefined" ||
                    typeof ScrollTrigger === "undefined"
                ) {
                    return;
                }

                const animations = {
                    "enter-from-left": {
                        x: -60,
                        opacity: 0,
                        duration: 0.8,
                        ease: "power3.out",
                    },
                    "enter-from-right": {
                        x: 60,
                        opacity: 0,
                        duration: 0.8,
                        ease: "power3.out",
                    },
                    "enter-from-left-staggered": {
                        x: -40,
                        opacity: 0,
                        duration: 0.6,
                        ease: "power2.out",
                        stagger: 0.1,
                    },
                    "text-reveal-words": {
                        y: 20,
                        opacity: 0,
                        duration: 0.6,
                        ease: "power3.out",
                        stagger: 0.05,
                    },
                };

                const elements = Array.from(
                    this.$el.querySelectorAll("[data-animate]"),
                );
                elements.forEach((el) => {
                    const type = el.dataset.animate;
                    const config =
                        animations[type] || animations["enter-from-left"];

                    if (type === "text-reveal-words") {
                        const split = new SplitText(el, { type: "words" });
                        gsap.from(split.words, {
                            ...config,
                            scrollTrigger: {
                                trigger: el,
                                start: "top 85%",
                                toggleActions: "play none none none",
                            },
                        });
                    } else {
                        gsap.from(el, {
                            ...config,
                            scrollTrigger: {
                                trigger: el,
                                start: "top 85%",
                                toggleActions: "play none none none",
                            },
                        });
                    }
                });

                ScrollTrigger.refresh();
            });
        },
    }));

    Alpine.data("footerCitationReveal", () => ({
        init() {
            this.$nextTick(() => {
                if (typeof gsap === "undefined") {
                    return;
                }

                const original = this.$refs.originalText;
                const warning = this.$refs.warningText;

                if (!original || !warning) {
                    return;
                }

                gsap.set(warning, { opacity: 0 });

                const tl = gsap.timeline({ paused: true });
                tl.to(
                    original,
                    {
                        y: -20,
                        opacity: 0,
                        duration: 0.3,
                        ease: "power2.in",
                    },
                    0,
                );
                tl.fromTo(
                    warning,
                    { y: 20, opacity: 0 },
                    {
                        y: 0,
                        opacity: 1,
                        duration: 0.4,
                        ease: "back.out(1.2)",
                    },
                    "-=0.15",
                );

                this.$el.addEventListener("mouseenter", () => tl.play());
                this.$el.addEventListener("mouseleave", () => tl.reverse());
            });
        },
    }));

    Alpine.data("returnToTopButton", () => ({
        init() {
            if (
                typeof gsap === "undefined" ||
                typeof SplitText === "undefined"
            ) {
                return;
            }

            const button = this.$el.querySelector("button");
            if (!button) {
                return;
            }

            const textWrapper = button.querySelector("[data-text]");
            const arrow = button.querySelector("svg");
            if (!textWrapper || !arrow) {
                return;
            }

            const split = new SplitText(textWrapper, { type: "chars" });
            const chars = split.chars;
            const tl = gsap.timeline({ paused: true });
            tl.to(chars, {
                keyframes: [
                    { y: -10, opacity: 0, duration: 0.2, ease: "power2.in" },
                    { y: 10, opacity: 0, duration: 0 },
                    { y: 0, opacity: 1, duration: 0.2, ease: "power2.out" },
                ],
                stagger: 0.02,
            });
            tl.to(
                arrow,
                {
                    keyframes: [
                        { y: -30, duration: 0.25, ease: "power2.in" },
                        { y: 30, duration: 0 },
                        { y: 0, duration: 0.25, ease: "power2.out" },
                    ],
                },
                0.1,
            );

            button.addEventListener("mouseenter", () => tl.play());
            button.addEventListener("mouseleave", () => tl.reverse());
        },
        scrollToTop() {
            window.scrollTo({ top: 0, behavior: "smooth" });
        },
    }));

    Alpine.data("hoverStatsCard", () => ({
        init() {
            if (typeof gsap === "undefined") {
                return;
            }

            const card = this.$el;
            const background = this.$refs.background;
            const topLeftCorner = this.$refs.topLeftCorner;
            const bottomLeftCorner = this.$refs.bottomLeftCorner;
            const topRightCorner = this.$refs.topRightCorner;
            const bottomRightCorner = this.$refs.bottomRightCorner;

            if (
                !background ||
                !topLeftCorner ||
                !bottomLeftCorner ||
                !topRightCorner ||
                !bottomRightCorner
            ) {
                return;
            }

            const tl = gsap.timeline({ paused: true });
            tl.fromTo(
                background,
                { scale: 1 },
                { scale: 1.02, duration: 0.25, ease: "power2.out" },
                0,
            );
            tl.to(
                topLeftCorner,
                { x: -5, y: -5, duration: 0.25, ease: "power2.out" },
                0,
            );
            tl.to(
                topRightCorner,
                { x: 5, y: -5, duration: 0.25, ease: "power2.out" },
                0,
            );
            tl.to(
                bottomLeftCorner,
                { x: -5, y: 5, duration: 0.25, ease: "power2.out" },
                0,
            );
            tl.to(
                bottomRightCorner,
                { x: 5, y: 5, duration: 0.25, ease: "power2.out" },
                0,
            );

            card.addEventListener("mouseenter", () => tl.play());
            card.addEventListener("mouseleave", () => tl.reverse());
        },
    }));

    Alpine.data("rotatingBadge", () => ({
        init() {
            if (typeof gsap === "undefined") {
                return;
            }

            const tweens = [];
            let playing = false;
            const rotatingEl = this.$el.querySelector("[data-rotating]");
            if (!rotatingEl) {
                return;
            }

            const rotate = () => {
                gsap.to(rotatingEl, {
                    rotation: "+=60",
                    duration: 0.5,
                    ease: "sine.out",
                    onComplete: () => {
                        if (playing) {
                            gsap.delayedCall(0.5, rotate);
                        }
                    },
                });
            };

            const boxes = Array.from(this.$el.querySelectorAll("[data-box]"));
            const delays = [0, 0.2, 0.1];
            boxes.forEach((box, i) => {
                tweens.push(
                    gsap.to(box, {
                        opacity: 0.3,
                        repeat: -1,
                        yoyo: true,
                        duration: 0.4,
                        delay: delays[i] || 0,
                        ease: "power1.inOut",
                        paused: true,
                    }),
                );
            });

            const group = this.$el.closest(".group");
            if (!group) {
                return;
            }

            group.addEventListener("mouseenter", () => {
                playing = true;
                tweens.forEach((t) => t.resume());
                rotate();
            });
            group.addEventListener("mouseleave", () => {
                playing = false;
                tweens.forEach((t) => t.pause());
            });
        },
    }));

    Alpine.data("buttonTextReveal", () => ({
        init() {
            if (
                typeof gsap === "undefined" ||
                typeof SplitText === "undefined"
            ) {
                return;
            }

            const button = this.$el.querySelector("a");
            if (!button) {
                return;
            }

            const textWrapper = button.querySelector("[data-text]");
            const arrow = button.querySelector("[data-icon] svg");
            if (!textWrapper || !arrow) {
                return;
            }

            const split = new SplitText(textWrapper, { type: "chars" });
            const chars = split.chars;
            const tl = gsap.timeline({ paused: true });
            tl.to(
                chars,
                {
                    keyframes: [
                        {
                            y: -10,
                            opacity: 0,
                            duration: 0.2,
                            ease: "power2.in",
                        },
                        { y: 10, opacity: 0, duration: 0 },
                        { y: 0, opacity: 1, duration: 0.2, ease: "power2.out" },
                    ],
                    stagger: 0.02,
                },
                0,
            );
            tl.to(
                arrow,
                {
                    keyframes: [
                        { y: -30, duration: 0.25, ease: "power2.in" },
                        { y: 30, duration: 0 },
                        { y: 0, duration: 0.25, ease: "power2.out" },
                    ],
                },
                0.1,
            );

            button.addEventListener("mouseenter", () => tl.play());
            button.addEventListener("mouseleave", () => tl.reverse());
        },
    }));

    Alpine.data("autoAnimateGrid", () => ({
        init() {
            if (
                typeof Alpine === "undefined" ||
                typeof Alpine.autoAnimate === "undefined"
            ) {
                return;
            }

            Alpine.autoAnimate(this.$el, { duration: 250 });
        },
    }));

    // Filament section state as a named Alpine component to avoid inline x-data object literals (CSP parser errors)
    Alpine.data(
        "filamentSection",
        (collapsed = false, persist = false, collapseId = null) => ({
            isCollapsed: collapsed,
            init() {
                // If persistence is requested, use localStorage to remember collapsed state
                if (persist) {
                    try {
                        const key = `section-${collapseId ?? this.$el.id}-isCollapsed`;
                        const stored = localStorage.getItem(key);
                        if (stored !== null) {
                            this.isCollapsed = stored === "true";
                        }
                        this.$watch("isCollapsed", (value) => {
                            localStorage.setItem(key, value ? "true" : "false");
                        });
                    } catch (e) {
                        // localStorage could be blocked by tracking prevention — ignore errors silently
                    }
                }
            },
        }),
    );

    Alpine.data("formationSearchFilters", () => ({
        search: "",
        showFilters: false,
        category: null,
        sortBy: "newest",
        sortDropdownOpen: false,
        listeningMessages: [
            "Whatcha looking for? 🔍",
            "I'm listening... 👀",
            "Go ahead, I'm ready 🎯",
            "Type away! ⌨️",
            "Searching is fun! 🤓",
            "What can I find for you? 🕵️‍♂️",
        ],
        listeningIndex: 0,
        get activeFilterCount() {
            return this.category ? 1 : 0;
        },
        get listeningMessage() {
            return this.listeningMessages[
                this.listeningIndex % this.listeningMessages.length
            ];
        },
        init() {
            this.$watch("category", (value) => {
                if (value) {
                    this.showFilters = true;
                }
            });
        },
        resetFilters() {
            this.category = null;
            this.sortBy = "newest";
            this.search = "";
            this.showFilters = false;
            if (this.$refs.filtersButton) {
                this.$refs.filtersButton.focus();
            }
            const target = document.querySelector("#scroll-to-reference");
            if (target) {
                target.scrollIntoView({ behavior: "smooth" });
            }
        },
        rotateListeningMessage() {
            this.listeningIndex++;
        },
    }));

    Alpine.data("animatedStat", () => (targetRaw) => ({
        show: false,
        count: 0,
        targetRaw,
        parsedTarget: 0,
        suffix: "",
        init() {
            this.initializeTarget();
        },
        initializeTarget() {
            const raw = String(this.targetRaw).trim();
            const numericOnly = raw
                .replace(/\s+/g, "")
                .match(/^(\d+(?:[.,]\d+)?)/);
            if (numericOnly) {
                this.parsedTarget = Number(numericOnly[1].replace(",", "."));
                const suffixMatch = raw.match(/^[\d\s,.]+(.*)$/);
                this.suffix = suffixMatch ? suffixMatch[1].trim() : "";
            } else {
                this.suffix = raw;
            }
        },
        formatValue(value) {
            if (!this.parsedTarget) {
                return this.targetRaw;
            }
            return `${Math.round(value).toLocaleString("fr-FR")}${this.suffix ? " " + this.suffix : ""}`;
        },
        animate() {
            if (!this.parsedTarget || this.count) {
                return;
            }

            const start = performance.now();
            const duration = 1100;
            const target = this.parsedTarget;

            const tick = (timestamp) => {
                const progress = Math.min((timestamp - start) / duration, 1);
                this.count = target * progress;
                if (progress < 1) {
                    window.requestAnimationFrame(tick);
                } else {
                    this.count = target;
                }
            };

            window.requestAnimationFrame(tick);
        },
    }));

    Alpine.data("focusFirstInput", () => ({
        init() {
            this.$nextTick(function () {
                const input = this.$el.querySelector("input");
                if (input) {
                    input.focus();
                }
            });
        },
    }));

    Alpine.data("twoFactorChallenge", () => ({
        showRecoveryInput: false,
        code: "",
        recovery_code: "",
        init(initialRecovery = false) {
            this.showRecoveryInput = Boolean(initialRecovery);
            if (!this.showRecoveryInput) {
                this.focusOtp();
            }
        },
        focusOtp() {
            this.$nextTick(() => {
                const input = this.$refs.otp?.querySelector("input");
                if (input) {
                    input.focus();
                }
            });
        },
        toggleInput() {
            this.showRecoveryInput = !this.showRecoveryInput;
            this.code = "";
            this.recovery_code = "";

            this.$nextTick(() => {
                if (this.showRecoveryInput) {
                    this.$refs.recovery_code?.focus();
                } else {
                    this.focusOtp();
                }
            });
        },
    }));

    Alpine.data("clipboardCopy", () => ({
        copied: false,
        async copy() {
            try {
                const text = this.$el.dataset.copyText || "";
                await navigator.clipboard.writeText(text);
                this.copied = true;
                setTimeout(() => {
                    this.copied = false;
                }, 1500);
            } catch (e) {
                console.warn("Could not copy to clipboard", e);
            }
        },
    }));

    Alpine.data("cspState", () => ({
        shown: false,
        visible: false,
        open: false,
        hover: false,
        hovered: false,
        lightbox: false,
        active: null,
        activeImage: "",
        showRecoveryCodes: false,
        currentNumberOfDigits: null,
    }));

    Alpine.data("teamMemberGrid", () => ({
        init() {
            if (
                typeof gsap === "undefined" ||
                typeof ScrollTrigger === "undefined"
            ) {
                return;
            }

            const articles = gsap.utils.toArray(
                this.$el.querySelectorAll("article"),
            );
            articles.forEach((article, index) => {
                gsap.fromTo(
                    article,
                    { opacity: 0, y: 30 },
                    {
                        opacity: 1,
                        y: 0,
                        duration: 0.6,
                        ease: "power2.out",
                        scrollTrigger: {
                            trigger: article,
                            start: "top bottom-=80",
                            toggleActions: "play none none none",
                        },
                        delay: index * 0.1,
                    },
                );
            });
        },
    }));

    Alpine.data("homeHeroReveal", () => ({
        init() {
            if (
                typeof gsap === "undefined" ||
                typeof SplitText === "undefined"
            ) {
                return;
            }

            const tl = gsap.timeline({
                defaults: { ease: "expo.out", duration: 1.2 },
            });
            tl.from(
                this.$refs.bgImage,
                { scale: 1.1, duration: 2.5, ease: "power3.out" },
                0,
            );

            const authorSplit = new SplitText(this.$refs.author, {
                type: "words",
            });

            tl.from(this.$refs.badge, { y: 40, opacity: 0 }, 0.3)
                .from(
                    this.$refs.buttons,
                    { opacity: 0, y: 15, duration: 0.4, ease: "power2.out" },
                    "-=0.15",
                )
                .from(
                    authorSplit.words,
                    {
                        opacity: 0,
                        y: 10,
                        stagger: 0.02,
                        duration: 0.35,
                        ease: "power2.out",
                    },
                    "-=0.25",
                )
                .from(this.$refs.title, { y: 50, opacity: 0 }, 0.5)
                .from(this.$refs.subtitle, { y: 30, opacity: 0 }, 0.7)
                .from(this.$refs.cta, { y: 30, opacity: 0 }, 0.9);
        },
    }));

    Alpine.data("aboutHeroReveal", () => ({
        init() {
            if (
                typeof gsap === "undefined" ||
                typeof SplitText === "undefined" ||
                typeof ScrollTrigger === "undefined"
            ) {
                return;
            }

            const tl = gsap.timeline({
                defaults: { ease: "expo.out", duration: 1.2 },
                scrollTrigger: {
                    trigger: this.$el,
                    start: "top 80%",
                    once: true,
                },
            });

            tl.from(
                this.$refs.bgImage,
                { scale: 1.1, duration: 2.5, ease: "power3.out" },
                0,
            );
            const authorSplit = new SplitText(this.$refs.author, {
                type: "words",
            });

            tl.from(this.$refs.badge, { y: 40, opacity: 0 }, 0.3)
                .from(
                    this.$refs.buttons,
                    { opacity: 0, y: 15, duration: 0.4, ease: "power2.out" },
                    "-=0.15",
                )
                .from(
                    authorSplit.words,
                    {
                        opacity: 0,
                        y: 10,
                        stagger: 0.02,
                        duration: 0.35,
                        ease: "power2.out",
                    },
                    "-=0.25",
                )
                .from(this.$refs.title, { y: 50, opacity: 0 }, 0.5)
                .from(this.$refs.subtitle, { y: 30, opacity: 0 }, 0.7)
                .from(this.$refs.cta, { y: 30, opacity: 0 }, 0.9);
        },
    }));

    Alpine.data("aboutQuoteReveal", () => ({
        init() {
            if (
                typeof gsap === "undefined" ||
                typeof SplitText === "undefined" ||
                typeof ScrollTrigger === "undefined"
            ) {
                return;
            }

            const tl = gsap.timeline({
                defaults: { ease: "power2.out" },
                scrollTrigger: {
                    trigger: this.$el,
                    start: "top 80%",
                    once: true,
                },
            });

            tl.from(
                this.$refs.bgImage,
                { scale: 1.08, duration: 1.6, ease: "power2.out" },
                0,
            );

            const quoteSplit = new SplitText(this.$refs.quote, {
                type: "chars",
            });
            const authorSplit = new SplitText(this.$refs.author, {
                type: "words",
            });
            const subtitleSplit = new SplitText(this.$refs.subtitle, {
                type: "lines",
            });

            tl.from(
                this.$refs.badge,
                { opacity: 0, y: 12, duration: 0.35, ease: "power1.out" },
                0,
            )
                .from(
                    quoteSplit.chars,
                    {
                        opacity: 0,
                        y: 25,
                        rotateX: -10,
                        stagger: 0.012,
                        duration: 0.5,
                        ease: "back.out(1.2)",
                    },
                    "-=0.15",
                )
                .from(
                    authorSplit.words,
                    {
                        opacity: 0,
                        y: 10,
                        stagger: 0.02,
                        duration: 0.35,
                        ease: "power2.out",
                    },
                    "-=0.25",
                )
                .from(
                    subtitleSplit.lines,
                    {
                        opacity: 0,
                        y: 12,
                        stagger: 0.04,
                        duration: 0.4,
                        ease: "power2.out",
                    },
                    "-=0.2",
                )
                .from(
                    this.$refs.buttons,
                    { opacity: 0, y: 15, duration: 0.4, ease: "power2.out" },
                    "-=0.15",
                )
                .from(
                    this.$refs.decoLine,
                    { scaleX: 0, duration: 0.5, ease: "power1.out" },
                    "-=0.1",
                );
        },
    }));

    Alpine.data("serviceHeroReveal", () => ({
        init() {
            if (
                typeof gsap === "undefined" ||
                typeof SplitText === "undefined" ||
                typeof ScrollTrigger === "undefined"
            ) {
                return;
            }

            const tl = gsap.timeline({
                scrollTrigger: {
                    trigger: this.$el,
                    start: "top 80%",
                    once: true,
                },
            });

            tl.from(
                this.$refs.bg,
                { scale: 1.1, duration: 2.5, ease: "power3.out" },
                0,
            );

            const title = new SplitText(this.$refs.title, {
                type: "words,chars",
            });
            const excerpt = new SplitText(this.$refs.excerpt, {
                type: "lines",
            });

            tl.from(
                title.chars,
                {
                    opacity: 0,
                    y: 60,
                    rotateX: -15,
                    stagger: 0.025,
                    duration: 0.9,
                    ease: "back.out(1.6)",
                },
                "-=0.4",
            ).from(
                excerpt.lines,
                {
                    opacity: 0,
                    y: 30,
                    stagger: 0.1,
                    duration: 0.8,
                    ease: "power3.out",
                },
                "-=0.5",
            );
        },
    }));

    Alpine.data("projectShowHeroReveal", () => ({
        init() {
            if (
                typeof gsap === "undefined" ||
                typeof SplitText === "undefined" ||
                typeof ScrollTrigger === "undefined"
            ) {
                return;
            }

            const tl = gsap.timeline({
                scrollTrigger: {
                    trigger: this.$el,
                    start: "top 80%",
                    once: true,
                },
            });

            tl.from(
                this.$refs.bg,
                { scale: 1.1, duration: 2.5, ease: "power3.out" },
                0,
            );

            const title = new SplitText(this.$refs.title, {
                type: "words,chars",
            });
            const subtitle = new SplitText(this.$refs.subtitle, {
                type: "words",
            });

            tl.from(
                this.$refs.badges,
                { opacity: 0, y: 20, duration: 0.4, ease: "power2.out" },
                0,
            )
                .from(
                    title.chars,
                    {
                        opacity: 0,
                        y: 60,
                        rotateX: -15,
                        stagger: 0.025,
                        duration: 0.9,
                        ease: "back.out(1.6)",
                    },
                    "-=0.4",
                )
                .from(
                    subtitle.words,
                    {
                        opacity: 0,
                        y: 20,
                        stagger: 0.04,
                        duration: 0.6,
                        ease: "power3.out",
                    },
                    "-=0.5",
                )
                .from(
                    this.$refs.meta,
                    { opacity: 0, y: 30, duration: 0.6, ease: "power3.out" },
                    "-=0.3",
                );
        },
    }));
});

// ----- État minimal pour les animations d'entrée (header, stats) -----
document.addEventListener("alpine:init", () => {
    Alpine.data("cspState", () => ({
        shown: false,
        hover: false,
    }));
});

// ----- Gestion des filtres Livewire pour la page blog -----
document.addEventListener("alpine:init", () => {
    Alpine.data("postSearchFilters", () => ({
        search: "",
        category: null,
        sortBy: "newest",
        showFilters: false,
        open: false,
        activeFilterCount: 0,

        init() {
            // Récupérer les états Livewire
            if (typeof window.Livewire !== "undefined") {
                const component = window.Livewire.find(
                    this.$el.closest("[wire\\:id]")?.getAttribute("wire:id"),
                );
                if (component) {
                    this.search = component.entangle("search").live;
                    this.category = component.entangle("category").live;
                    this.sortBy = component.entangle("sort").live;
                }
            }

            // Mettre à jour le compteur de filtres actifs
            this.activeFilterCount = this.category ? 1 : 0;
            this.$watch(
                "category",
                (val) => (this.activeFilterCount = val ? 1 : 0),
            );
        },

        resetFilters() {
            this.category = null;
            this.sortBy = "newest";
            this.search = "";
            this.showFilters = false;
            this.$refs.filtersButton.focus();
        },
    }));
});

// ── Hero animation (about page) ──
document.addEventListener("alpine:init", () => {
    Alpine.data("heroReveal", () => ({
        init() {
            if (typeof gsap === "undefined") return;
            const tl = gsap.timeline({
                defaults: { ease: "expo.out", duration: 1.2 },
            });
            const bgImage = this.$refs.bgImage;
            const badge = this.$refs.badge;
            const buttons = this.$refs.buttons;
            const author = this.$refs.author;
            const title = this.$refs.title;
            const subtitle = this.$refs.subtitle;
            const cta = this.$refs.cta;
            const decoLine = this.$refs.decoLine;

            const authorSplit =
                typeof SplitText !== "undefined"
                    ? new SplitText(author, { type: "words" })
                    : null;

            tl.from(
                bgImage,
                { scale: 1.1, duration: 2.5, ease: "power3.out" },
                0,
            );
            if (badge) tl.from(badge, { y: 40, opacity: 0 }, 0.3);
            if (buttons)
                tl.from(
                    buttons,
                    { opacity: 0, y: 15, duration: 0.4, ease: "power2.out" },
                    "-=0.15",
                );
            if (authorSplit)
                tl.from(
                    authorSplit.words,
                    {
                        opacity: 0,
                        y: 10,
                        stagger: 0.02,
                        duration: 0.35,
                        ease: "power2.out",
                    },
                    "-=0.25",
                );
            if (title) tl.from(title, { y: 50, opacity: 0 }, 0.5);
            if (subtitle) tl.from(subtitle, { y: 30, opacity: 0 }, 0.7);
            if (cta) tl.from(cta, { y: 30, opacity: 0 }, 0.9);
            if (decoLine)
                tl.from(
                    decoLine,
                    { scaleX: 0, duration: 0.5, ease: "power1.out" },
                    "-=0.1",
                );
        },
    }));
});

// ── Quote / About reveal (about page) ──
document.addEventListener("alpine:init", () => {
    Alpine.data("aboutQuoteReveal", () => ({
        init() {
            if (
                typeof gsap === "undefined" ||
                typeof ScrollTrigger === "undefined"
            )
                return;
            const tl = gsap.timeline({
                defaults: { ease: "power2.out" },
                scrollTrigger: {
                    trigger: this.$el,
                    start: "top 80%",
                    once: true,
                },
            });

            const badge = this.$refs.badge;
            const title = this.$refs.title;
            const subtitle = this.$refs.subtitle;
            const buttons = this.$refs.buttons;
            const decoLine = this.$refs.decoLine;
            const quote = this.$refs.quote;
            const author = this.$refs.author;

            if (badge)
                tl.from(
                    badge,
                    { opacity: 0, y: 12, duration: 0.35, ease: "power1.out" },
                    0,
                );
            if (quote && typeof SplitText !== "undefined") {
                const quoteSplit = new SplitText(quote, { type: "chars" });
                tl.from(
                    quoteSplit.chars,
                    {
                        opacity: 0,
                        y: 25,
                        rotateX: -10,
                        stagger: 0.012,
                        duration: 0.5,
                        ease: "back.out(1.2)",
                    },
                    "-=0.15",
                );
            }
            if (author && typeof SplitText !== "undefined") {
                const authorSplit = new SplitText(author, { type: "words" });
                tl.from(
                    authorSplit.words,
                    {
                        opacity: 0,
                        y: 10,
                        stagger: 0.02,
                        duration: 0.35,
                        ease: "power2.out",
                    },
                    "-=0.25",
                );
            }
            if (subtitle && typeof SplitText !== "undefined") {
                const subtitleSplit = new SplitText(subtitle, {
                    type: "lines",
                });
                tl.from(
                    subtitleSplit.lines,
                    {
                        opacity: 0,
                        y: 12,
                        stagger: 0.04,
                        duration: 0.4,
                        ease: "power2.out",
                    },
                    "-=0.2",
                );
            }
            if (buttons)
                tl.from(
                    buttons,
                    { opacity: 0, y: 15, duration: 0.4, ease: "power2.out" },
                    "-=0.15",
                );
            if (decoLine)
                tl.from(
                    decoLine,
                    { scaleX: 0, duration: 0.5, ease: "power1.out" },
                    "-=0.1",
                );
        },
    }));
});

// ── Animated stat counter (impact section) ──
document.addEventListener("alpine:init", () => {
    Alpine.data("animatedStat", (rawValue) => ({
        shown: false,
        count: 0,
        targetRaw: rawValue,
        parsedTarget: 0,
        suffix: "",
        init() {
            const raw = String(this.targetRaw).trim();
            const numericOnly = raw
                .replace(/\s+/g, "")
                .match(/^(\d+(?:[.,]\d+)?)/);
            if (numericOnly) {
                this.parsedTarget = Number(numericOnly[1].replace(",", "."));
                const suffixMatch = raw.match(/^[\d\s,.]+(.*)$/);
                this.suffix = suffixMatch ? suffixMatch[1].trim() : "";
            } else {
                this.suffix = raw;
            }
        },
        formatValue(value) {
            if (!this.parsedTarget) {
                return this.targetRaw;
            }
            return `${Math.round(value).toLocaleString("fr-FR")}${this.suffix ? " " + this.suffix : ""}`;
        },
        animate() {
            if (!this.parsedTarget || this.count) return;
            const start = performance.now();
            const duration = 1100;
            const target = this.parsedTarget;
            const tick = (timestamp) => {
                const progress = Math.min((timestamp - start) / duration, 1);
                this.count = target * progress;
                if (progress < 1) {
                    window.requestAnimationFrame(tick);
                } else {
                    this.count = target;
                }
            };
            window.requestAnimationFrame(tick);
        },
    }));
});

// ---------- Cookie Consent (Alpine data global) ----------
const registerCookieConsentAlpineData = () => {
    const register = () => {
        Alpine.data("cookieConsent", () => ({
            show: false,
            preferences: false,

            init() {
                const getWireId = () => {
                    let element = this.$el;
                    while (element) {
                        if (
                            element.hasAttribute &&
                            element.hasAttribute("wire:id")
                        ) {
                            return element.getAttribute("wire:id");
                        }
                        element = element.parentElement;
                    }
                    return null;
                };

                const bindEntangle = () => {
                    const wireId = getWireId();
                    const component = wireId
                        ? window.Livewire?.find(wireId)
                        : null;
                    if (!component) {
                        document.addEventListener(
                            "livewire:load",
                            bindEntangle,
                            { once: true },
                        );
                        return;
                    }
                    this.show = component.entangle("showBanner");
                    this.preferences = component.entangle("showPreferences");
                };
                bindEntangle();

                if (this.show && typeof window.gsap !== "undefined") {
                    const banner = this.$refs.banner;
                    if (banner) {
                        window.gsap.set(banner, { yPercent: 120, opacity: 0 });
                        setTimeout(() => {
                            window.gsap.to(banner, {
                                yPercent: 0,
                                opacity: 1,
                                duration: 0.7,
                                ease: "power4.out",
                                clearProps: "transform",
                            });
                        }, 400);
                    }
                }

                this.$watch("show", (value) => {
                    if (
                        !value &&
                        this.$refs.banner &&
                        typeof window.gsap !== "undefined"
                    ) {
                        window.gsap.to(this.$refs.banner, {
                            yPercent: 120,
                            opacity: 0,
                            duration: 0.5,
                            ease: "power3.in",
                        });
                    }
                });

                this.$watch("preferences", (value) => {
                    if (typeof window.gsap === "undefined") return;
                    if (value) {
                        window.gsap.fromTo(
                            this.$refs.modal,
                            { y: 40, opacity: 0, scale: 0.96 },
                            {
                                y: 0,
                                opacity: 1,
                                scale: 1,
                                duration: 0.5,
                                ease: "back.out(1.1)",
                            },
                        );
                        window.gsap.fromTo(
                            this.$refs.backdrop,
                            { opacity: 0 },
                            { opacity: 1, duration: 0.4 },
                        );
                    } else {
                        window.gsap.to(this.$refs.modal, {
                            y: 20,
                            opacity: 0,
                            scale: 0.96,
                            duration: 0.25,
                            ease: "power2.in",
                        });
                        window.gsap.to(this.$refs.backdrop, {
                            opacity: 0,
                            duration: 0.25,
                        });
                    }
                });
            },
        }));
    };

    if (window.Alpine) {
        register();
    }
    document.addEventListener("alpine:init", register, { once: true });
};

registerCookieConsentAlpineData();

// ---------- Global Pro Animations (Filament style) ----------
const initGlobalAnimations = () => {
    if (
        typeof window.gsap === "undefined" ||
        typeof window.ScrollTrigger === "undefined"
    )
        return;

    window.ScrollTrigger.refresh();

    // 1. Titres avec SplitText
    const headings = window.gsap.utils.toArray(
        "main h1, main h2, main h3, .prose h1, .prose h2, .prose h3",
    );
    headings.forEach((heading) => {
        if (heading.dataset.gsapAnimated || heading.closest(".no-animate"))
            return;
        heading.dataset.gsapAnimated = "true";

        try {
            const split = new window.SplitText(heading, {
                type: "words,lines",
            });
            const splitWords =
                split && split.words
                    ? window.gsap.utils.toArray(split.words)
                    : [];
            if (!splitWords.length) {
                if (typeof split.revert === "function") split.revert();
                return;
            }
            safeGsapFromTo(
                splitWords,
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
                        once: true,
                    },
                },
            );
        } catch (e) {
            console.warn("SplitText animation failed on heading", e);
        }
    });

    // 2. Content blocks batch fade-up
    const contentBlocks = window.gsap.utils.toArray(
        "main p, main img, main ul, .flux-card, .prose > div, article, .rounded-3xl, .grid > a.group, .grid > div.group, .gsap-reveal",
    );
    const blocksToAnimate = contentBlocks.filter((block) => {
        if (
            block.dataset.gsapAnimated ||
            block.closest(".no-animate") ||
            block.closest('[x-data="cookieConsent()"]') ||
            block.closest("header") ||
            block.closest("nav")
        ) {
            return false;
        }
        return true;
    });
    blocksToAnimate.forEach((block) => {
        block.dataset.gsapAnimated = "true";
    });

    window.ScrollTrigger.batch(blocksToAnimate, {
        start: "top 92%",
        once: true,
        onEnter: (batch) => {
            const items = window.gsap.utils.toArray(batch);
            if (!items.length) return;
            safeGsapFromTo(
                items,
                { opacity: 0, y: 30, scale: 0.98 },
                {
                    opacity: 1,
                    y: 0,
                    scale: 1,
                    stagger: 0.08,
                    duration: 0.8,
                    ease: "power3.out",
                    overwrite: true,
                },
            );
        },
    });

    // 3. Page load fade-in
    const mainContainer = document.querySelector(".flex-1");
    if (mainContainer && !mainContainer.dataset.pageAnimated) {
        mainContainer.dataset.pageAnimated = "true";
        window.gsap.fromTo(
            mainContainer,
            { opacity: 0, y: 15 },
            { opacity: 1, y: 0, duration: 0.6, ease: "power2.out", delay: 0.1 },
        );
    }
};

const initAnchorSmoothScroll = () => {
    if (typeof document === "undefined") {
        return;
    }

    document
        .querySelectorAll('a[href^="#"]:not([href="#"])')
        .forEach((anchor) => {
            anchor.addEventListener("click", (event) => {
                const href = anchor.getAttribute("href");
                if (!href || href === "#") {
                    return;
                }

                const target = document.querySelector(href);
                if (!target) {
                    return;
                }

                event.preventDefault();
                target.scrollIntoView({ behavior: "smooth" });
            });
        });
};

document.addEventListener("livewire:navigated", () => {
    setTimeout(initGlobalAnimations, 50);
    setTimeout(initAnchorSmoothScroll, 50);
});

document.addEventListener("DOMContentLoaded", () => {
    initGlobalAnimations();
    initAnchorSmoothScroll();
});

if (
    document.readyState === "interactive" ||
    document.readyState === "complete"
) {
    initAnchorSmoothScroll();
}
