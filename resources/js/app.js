import { gsap } from "gsap";
import intersect from "@alpinejs/intersect";
// Import flowbite locally (avoid CDN / tracking prevention issues)
import "flowbite";
import autoAnimate from "@formkit/auto-animate";

import { ScrollTrigger } from "gsap/ScrollTrigger";
import { ScrollToPlugin } from "gsap/ScrollToPlugin";
import { SplitText } from "gsap/SplitText";

gsap.registerPlugin(ScrollTrigger, ScrollToPlugin, SplitText);

// Livewire 4 bundle son propre Alpine — ne jamais importer alpinejs séparément.
// On enregistre le plugin Intersect et toutes les données Alpine via l'événement
// alpine:init, qui est déclenché par l'Alpine de Livewire/Flux AVANT le start().
// Cela garantit que $flux et les autres magics Flux sont déjà disponibles.

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

// Le plugin Intersect doit être enregistré sur l'instance Alpine de Livewire.
// alpine:init est le bon moment : Alpine est prêt mais pas encore démarré.
document.addEventListener("alpine:init", () => {
    const Alpine = window.Alpine;
    if (!Alpine) return;

    // Plugin Intersect (x-intersect)
    Alpine.plugin(intersect);

    // Extension autoAnimate
    Alpine.autoAnimate = Alpine.autoAnimate || autoAnimate;
});

// ---------- Livewire scroll-lock (préserve la position au filtre/tri) ----------
// Active uniquement sur les pages ayant un élément [data-preserve-scroll].
// Sauvegarde scrollY avant le commit, le restaure après le morph DOM.
(() => {
    let savedY = null;
    let active = false;

    document.addEventListener("livewire:init", () => {
        Livewire.hook(
            "commit",
            ({ component, commit, respond, succeed, fail }) => {
                // Déclenche seulement si la page a déclaré data-preserve-scroll
                const anchor = document.querySelector("[data-preserve-scroll]");
                if (!anchor) return;

                // Sauvegarde avant le rendu
                savedY = window.scrollY;
                active = true;

                succeed(({ snapshot, effect }) => {
                    if (!active) return;
                    active = false;
                    // Restaure la position après le morph
                    requestAnimationFrame(() => {
                        window.scrollTo({ top: savedY, behavior: "instant" });
                    });
                });
            },
        );
    });
})();

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

// ---------- Alpine.data() registrations ----------
document.addEventListener("alpine:init", () => {
    const Alpine = window.Alpine;
    if (!Alpine) return;

    Alpine.data("buttonAnimation", () => ({
        init() {
            if (typeof gsap === "undefined" || typeof SplitText === "undefined")
                return;
            const button = this.$el.querySelector("a");
            if (!button) return;
            const textWrapper = button.querySelector("[data-text]");
            const icon = button.querySelector("[data-icon] svg");
            if (!textWrapper || !icon) return;

            const split = new SplitText(textWrapper, { type: "chars" });
            const chars = split.chars;
            const tl = gsap.timeline({ paused: true });

            // Brillance du texte
            if (chars.length > 0) {
                tl.to(
                    chars,
                    {
                        keyframes: {
                            opacity: [1, 0.4, 1],
                        },
                        duration: 0.15,
                        ease: "sine.inOut",
                        stagger: 0.02,
                    },
                    0.1,
                );
            }

            // Flèche
            tl.to(
                icon,
                {
                    keyframes: [
                        { x: 30, duration: 0.23, ease: "power2.in" },
                        { x: -30, duration: 0 },
                        { x: 0, duration: 0.23, ease: "power2.out" },
                    ],
                },
                0,
            );

            button.addEventListener("mouseenter", () => tl.play());
            button.addEventListener("mouseleave", () => tl.reverse());
        },
    }));
    // scripts pour filament / site
    // ===== Définitions pour les composants Filament =====

    // filamentSchemaComponent (utilisé par les formulaires)
    Alpine.data("filamentSchemaComponent", () => ({
        init() {
            // L'initialisation minimale requise pour éviter les erreurs
        },
    }));

    // selectFormComponent (utilisé par les champs de type Select)
    Alpine.data("selectFormComponent", (config) => ({
        state: config.state,
        init() {},
    }));

    // fileUploadFormComponent (utilisé par les champs d'upload de fichiers)
    Alpine.data("fileUploadFormComponent", (config) => ({
        state: config.state,
        error: null,
        isEditorOpen: false,
        init() {},
        closeEditor() {
            this.isEditorOpen = false;
        },
    }));

    // keyValueFormComponent (utilisé par les champs clé-valeur)
    Alpine.data("keyValueFormComponent", (config) => ({
        rows: [],
        state: config.state,
        init() {},
        addRow() {
            this.rows.push({ key: "", value: "" });
            this.updateState();
        },
        updateState() {
            const obj = {};
            this.rows.forEach((row) => {
                if (row.key) obj[row.key] = row.value;
            });
            this.state = obj;
        },
        reorderRows(event) {
            // Réorganisation basique (peut être améliorée si nécessaire)
        },
    }));

    // filamentSection (déjà présente, mais assurez-vous qu'elle est bien là)
    // Si elle n'existe pas, ajoutez-la :
    if (!Alpine.data("filamentSection")) {
        Alpine.data(
            "filamentSection",
            (collapsed = false, persist = false, collapseId = null) => ({
                isCollapsed: collapsed,
                init() {
                    if (persist) {
                        try {
                            const key = `section-${collapseId ?? this.$el.id}-isCollapsed`;
                            const stored = localStorage.getItem(key);
                            if (stored !== null) {
                                this.isCollapsed = stored === "true";
                            }
                            this.$watch("isCollapsed", (value) => {
                                localStorage.setItem(
                                    key,
                                    value ? "true" : "false",
                                );
                            });
                        } catch (e) {}
                    }
                },
            }),
        );
    }
    // Fin scripts pour filament / site
    Alpine.data("scrollToTop", () => ({
        show: false,
        hovering: false,
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
            // si un provider est passé, on l'utilise
            if (provider) {
                const urls = {
                    facebook: `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(this.shareUrl)}`,
                    twitter: `https://twitter.com/intent/tweet?url=${encodeURIComponent(this.shareUrl)}&text=${encodeURIComponent(this.shareTitle)}`,
                    linkedin: `https://www.linkedin.com/shareArticle?mini=true&url=${encodeURIComponent(this.shareUrl)}&title=${encodeURIComponent(this.shareTitle)}`,
                    whatsapp: `https://api.whatsapp.com/send?text=${encodeURIComponent(`${this.shareTitle} - ${this.shareUrl}`)}`,
                };
                const url = urls[provider];
                if (url) window.open(url, "_blank");
            } else {
                // Fallback : utiliser l'API Web Share si disponible, sinon copier le lien
                if (navigator.share) {
                    navigator
                        .share({
                            title: this.shareTitle,
                            url: this.shareUrl,
                        })
                        .catch(() => {});
                } else {
                    this.copyLink();
                }
            }
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
            if (typeof gsap === "undefined") return;
            const link = this.$el.querySelector("a");
            if (!link) return;

            const text = link.querySelector("[data-text]");
            const icon = link.querySelector("svg");
            const arrow = link.querySelector("svg:last-child");

            if (!text || !icon || !arrow) return;

            const tl = gsap.timeline({ paused: true });

            // Icône : rotation + zoom
            tl.to(
                icon,
                {
                    rotation: 360,
                    scale: 1.15,
                    duration: 0.35,
                    ease: "power2.out",
                },
                0,
            );

            // Texte : fondu + léger décalage (sans SplitText, espacement préservé)
            tl.fromTo(
                text,
                {
                    opacity: 0,
                    y: 4,
                },
                {
                    opacity: 1,
                    y: 0,
                    duration: 0.3,
                    ease: "power2.out",
                },
                0.05,
            );

            // Flèche
            tl.to(
                arrow,
                {
                    x: 3,
                    duration: 0.25,
                    ease: "power2.out",
                },
                0.1,
            );

            link.addEventListener("mouseenter", () => tl.play());
            link.addEventListener("mouseleave", () => {
                tl.reverse();
            });
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

            Alpine.autoAnimate(this.$el, {
                duration: 320,
                easing: "cubic-bezier(0.16, 1, 0.3, 1)",
            });

            if (
                typeof window.Livewire !== "undefined" &&
                typeof window.Livewire.hook === "function"
            ) {
                const preserveHeight = () => {
                    try {
                        const height = this.$el.getBoundingClientRect().height;
                        this.$el.style.minHeight = `${height}px`;
                    } catch (e) {
                        console.debug(
                            "autoAnimateGrid: preserve height failed",
                            e,
                        );
                    }
                };

                const releaseHeight = () => {
                    try {
                        this.$el.style.minHeight = "";
                    } catch (e) {
                        console.debug(
                            "autoAnimateGrid: release height failed",
                            e,
                        );
                    }
                };

                try {
                    window.Livewire.hook("message.sent", () => {
                        preserveHeight();
                    });

                    window.Livewire.hook("message.processed", () => {
                        setTimeout(releaseHeight, 280);
                    });
                } catch (e) {
                    console.debug(
                        "autoAnimateGrid: livewire hooks unavailable",
                        e,
                    );
                }
            }
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

    Alpine.data("animatedStat", (rawValue) => ({
        shown: false,
        count: 0,
        targetRaw: rawValue,
        parsedTarget: 0,
        suffix: "",
        init() {
            // Analyser la valeur brute
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

            // Surveiller 'shown' pour lancer l'animation automatiquement
            this.$watch("shown", (value) => {
                if (value) {
                    this.animate();
                }
            });
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

    Alpine.data("passkeyRegistration", () => ({
        supported: false,
        showForm: false,
        name: "",
        loading: false,
        error: null,
        init() {
            this.name = this.getDefaultPasskeyName();
            this.updateSupport();
            window.addEventListener(
                "passkeys:ready",
                () => this.updateSupport(),
                { once: true },
            );
        },
        updateSupport() {
            this.supported = Boolean(window.Passkeys?.isSupported());
        },
        getDefaultPasskeyName() {
            const ua = navigator.userAgent;
            const browser = [
                { pattern: /Edg|Edge/, name: "Edge" },
                { pattern: /OPR|Opera|OPiOS/, name: "Opera" },
                { pattern: /Firefox|FxiOS/, name: "Firefox" },
                { pattern: /Chrome|CriOS/, name: "Chrome" },
                { pattern: /Safari/, name: "Safari" },
            ].find((item) => item.pattern.test(ua))?.name;
            const os = [
                { pattern: /iPhone/, name: "iPhone" },
                { pattern: /iPad|Macintosh(?=.*Mobile)/, name: "iPad" },
                { pattern: /Android/, name: "Android" },
                { pattern: /Mac/, name: "Mac" },
                { pattern: /Windows/, name: "Windows" },
            ].find((item) => item.pattern.test(ua))?.name;
            return [browser, os].filter(Boolean).join(" on ") || "";
        },
        focusInput() {
            this.$nextTick(() => {
                this.$refs.passkeyNameInput?.focus();
            });
        },
        async register() {
            if (!this.name.trim()) {
                return;
            }
            this.loading = true;
            this.error = null;
            try {
                await window.Passkeys.register({ name: this.name });
                this.name = "";
                this.showForm = false;
                await $wire.loadPasskeys();
            } catch (e) {
                if (e.constructor?.name !== "UserCancelledError") {
                    this.error = e.message;
                }
            } finally {
                this.loading = false;
            }
        },
        cancel() {
            this.showForm = false;
            this.name = "";
            this.error = null;
        },
    }));

    Alpine.data("passkeyVerify", () => ({
        supported: false,
        loading: false,
        error: null,
        optionsRoute: "",
        submitRoute: "",
        init() {
            this.updateSupport();
            this.optionsRoute = this.$el.dataset.optionsRoute || "";
            this.submitRoute = this.$el.dataset.submitRoute || "";
            window.addEventListener(
                "passkeys:ready",
                () => this.updateSupport(),
                { once: true },
            );
        },
        updateSupport() {
            this.supported = Boolean(window.Passkeys?.isSupported());
        },
        async verify() {
            this.loading = true;
            this.error = null;
            try {
                const response = await window.Passkeys.verify({
                    routes: {
                        options: this.optionsRoute,
                        submit: this.submitRoute,
                    },
                });
                Livewire.navigate(response.redirect || "/dashboard");
            } catch (e) {
                if (e.constructor?.name !== "UserCancelledError") {
                    this.error = e.message;
                }
            } finally {
                this.loading = false;
            }
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
                // Déterminer le nombre de colonnes selon la largeur (sm: 640px = 2 cols, lg: 1024px = 3 cols)
                let cols = 1;
                if (window.innerWidth >= 1024) cols = 3;
                else if (window.innerWidth >= 640) cols = 2;

                // Sur mobile (1 colonne), on limite le délai.
                // Sur grille, on crée un effet de cascade basé sur la ligne et la colonne.
                const row = Math.floor(index / cols);
                const col = index % cols;

                // Délai plus court : 0.05s (au lieu de 0.1s)
                const staggerDelay =
                    cols === 1
                        ? Math.min(index, 3) * 0.05 // Mobile : plafonner le délai après les 3 premières cartes
                        : (row + col) * 0.05;

                gsap.fromTo(
                    article,
                    { opacity: 0, y: 20 },
                    {
                        opacity: 1,
                        y: 0,
                        duration: 0.4, // Plus rapide (0.4s au lieu de 0.6s)
                        ease: "power2.out",
                        scrollTrigger: {
                            trigger: article,
                            start: "top bottom-=40", // Déclenchement plus tôt (40px au lieu de 80px)
                            toggleActions: "play none none none",
                        },
                        delay: staggerDelay,
                    },
                );
            });
        },
    }));

    Alpine.data("HeroReveal", () => ({
        init() {
            if (typeof gsap === "undefined") return;

            const refs = this.$refs;
            if (
                !refs.bgImage &&
                !refs.badge &&
                !refs.buttons &&
                !refs.author &&
                !refs.title &&
                !refs.subtitle
            ) {
                return;
            }

            const getAuthorElement = () => {
                if (!refs.author) {
                    return null;
                }

                if (refs.author.querySelector) {
                    return refs.author.querySelector("p") || refs.author;
                }

                return refs.author;
            };

            const runAnimation = () => {
                const tl = gsap.timeline({
                    defaults: { ease: "expo.out", duration: 0.75 },
                });

                if (refs.bgImage) {
                    gsap.set(refs.bgImage, {
                        transformOrigin: "center center",
                        scale: 1.05,
                    });

                    tl.to(refs.bgImage, {
                        scale: 1,
                        duration: 1.2,
                        ease: "power3.out",
                    }, 0);
                }

                if (refs.title) {
                    tl.from(refs.title, { y: 26, opacity: 0, duration: 0.5 }, 0.15);
                }

                const authorElement = getAuthorElement();
                if (authorElement) {
                    let authorSplit = null;
                    try {
                        if (typeof SplitText !== "undefined") {
                            authorSplit = new SplitText(authorElement, { type: "words" });
                        }
                    } catch (error) {
                        authorSplit = null;
                    }

                    if (authorSplit && authorSplit.words?.length > 0) {
                        tl.from(
                            authorSplit.words,
                            {
                                opacity: 0,
                                y: 12,
                                stagger: 0.02,
                                duration: 0.35,
                                ease: "power2.out",
                            },
                            "-=0.25",
                        );
                    } else {
                        tl.from(
                            refs.author,
                            { opacity: 0, y: 12, duration: 0.35, ease: "power2.out" },
                            "-=0.25",
                        );
                    }
                }

                if (refs.subtitle) {
                    tl.from(
                        refs.subtitle,
                        { y: 20, opacity: 0, duration: 0.45 },
                        "-=0.15",
                    );
                }

                if (refs.buttons) {
                    tl.from(
                        refs.buttons,
                        { opacity: 0, y: 10, duration: 0.35, ease: "power2.out" },
                        "-=0.15",
                    );
                }

                if (refs.decoLine) {
                    tl.from(
                        refs.decoLine,
                        {
                            scaleX: 0,
                            transformOrigin: "left center",
                            opacity: 0,
                            duration: 0.35,
                        },
                        "-=0.25",
                    );
                }
            };

            const image = refs.bgImage;
            if (image instanceof HTMLImageElement && !image.complete) {
                image.addEventListener("load", runAnimation, { once: true });
            } else {
                runAnimation();
            }
        },
    }));

    Alpine.data("heroImageReveal", () => ({
        init() {
            const reducedMotion = window.matchMedia(
                "(prefers-reduced-motion: reduce)",
            ).matches;
            if (
                reducedMotion ||
                typeof gsap === "undefined" ||
                typeof ScrollTrigger === "undefined"
            )
                return;

            const refs = this.$refs;
            if (!refs.takeOff) return;

            gsap.fromTo(
                refs.takeOff,
                { autoAlpha: 0, y: 30 },
                {
                    autoAlpha: 1,
                    y: 0,
                    duration: 0.7,
                    ease: "circ.out",
                    scrollTrigger: {
                        trigger: this.$el,
                        start: "top bottom-=100px",
                    },
                },
            );
        },
    }));

    Alpine.data("homeHeroReveal", () => ({
        init() {
            if (
                typeof gsap === "undefined" ||
                typeof SplitText === "undefined" ||
                typeof ScrollTrigger === "undefined"
            )
                return;
            const tl = gsap.timeline({
                defaults: { ease: "expo.out", duration: 0.8 },
                scrollTrigger: {
                    trigger: this.$el,
                    start: "top 80%",
                    once: true,
                },
            });
            const refs = this.$refs;
            const addFrom = (target, vars, position) => {
                if (!target) return;
                tl.from(target, vars, position);
            };

            addFrom(
                refs.bgImage,
                { scale: 1.05, duration: 1.4, ease: "power3.out" },
                0,
            );
            const authorElement = refs.author?.querySelector?.("p") || refs.author;
            let authorSplit = null;
            if (authorElement) {
                try {
                    if (typeof SplitText !== "undefined") {
                        authorSplit = new SplitText(authorElement, { type: "words" });
                    }
                } catch (error) {
                    authorSplit = null;
                }
            }

            addFrom(refs.badge, { y: 40, opacity: 0 }, 0.3);
            addFrom(
                refs.buttons,
                { opacity: 0, y: 15, duration: 0.4, ease: "power2.out" },
                "-=0.15",
            );

            if (authorSplit && authorSplit.words?.length > 0) {
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
            } else if (refs.author) {
                addFrom(
                    refs.author,
                    { opacity: 0, y: 10, duration: 0.35, ease: "power2.out" },
                    "-=0.25",
                );
            }

            addFrom(refs.title, { y: 50, opacity: 0 }, 0.5);
            addFrom(refs.subtitle, { y: 30, opacity: 0 }, 0.7);
            addFrom(
                refs.decoLine,
                { scaleX: 0, duration: 0.5, ease: "power1.out" },
                "-=0.1",
            );
        },
    }));

    Alpine.data("aboutHeroReveal", () => ({
        init() {
            if (
                typeof gsap === "undefined" ||
                typeof SplitText === "undefined" ||
                typeof ScrollTrigger === "undefined"
            )
                return;
            const tl = gsap.timeline({
                defaults: { ease: "expo.out", duration: 0.8 },
                scrollTrigger: {
                    trigger: this.$el,
                    start: "top 80%",
                    once: true,
                },
            });
            const refs = this.$refs;
            const addFrom = (target, vars, position) => {
                if (!target) return;
                tl.from(target, vars, position);
            };

            addFrom(
                refs.bgImage,
                { scale: 1.05, duration: 1.4, ease: "power3.out" },
                0,
            );
            const authorElement = refs.author?.querySelector?.("p") || refs.author;
            let authorSplit = null;
            if (authorElement) {
                try {
                    if (typeof SplitText !== "undefined") {
                        authorSplit = new SplitText(authorElement, { type: "words" });
                    }
                } catch (error) {
                    authorSplit = null;
                }
            }

            addFrom(refs.badge, { y: 40, opacity: 0 }, 0.3);
            addFrom(
                refs.buttons,
                { opacity: 0, y: 15, duration: 0.4, ease: "power2.out" },
                "-=0.15",
            );

            if (authorSplit && authorSplit.words?.length > 0) {
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
            } else if (refs.author) {
                addFrom(
                    refs.author,
                    { opacity: 0, y: 10, duration: 0.35, ease: "power2.out" },
                    "-=0.25",
                );
            }

            addFrom(refs.title, { y: 50, opacity: 0 }, 0.5);
            addFrom(refs.subtitle, { y: 30, opacity: 0 }, 0.7);
            addFrom(
                refs.decoLine,
                { scaleX: 0, duration: 0.5, ease: "power1.out" },
                "-=0.1",
            );
        },
    }));

    Alpine.data("aboutQuoteReveal", () => ({
        init() {
            if (
                typeof gsap === "undefined" ||
                typeof ScrollTrigger === "undefined"
            )
                return;

            const refs = this.$refs;
            // Si aucun élément n'est présent, on ne fait rien
            if (
                !refs.badge &&
                !refs.quote &&
                !refs.author &&
                !refs.subtitle &&
                !refs.buttons &&
                !refs.decoLine &&
                !refs.bgImage
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

            if (refs.bgImage)
                tl.from(
                    refs.bgImage,
                    { scale: 1.08, duration: 1.6, ease: "power2.out" },
                    0,
                );
            if (refs.badge)
                tl.from(
                    refs.badge,
                    { opacity: 0, y: 12, duration: 0.35, ease: "power1.out" },
                    0,
                );

            if (refs.quote && typeof SplitText !== "undefined") {
                const quoteSplit = new SplitText(refs.quote, { type: "chars" });
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

            if (refs.author && typeof SplitText !== "undefined") {
                const authorSplit = new SplitText(refs.author, {
                    type: "words",
                });
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

            if (refs.subtitle && typeof SplitText !== "undefined") {
                const subtitleSplit = new SplitText(refs.subtitle, {
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

            if (refs.buttons)
                tl.from(
                    refs.buttons,
                    { opacity: 0, y: 15, duration: 0.4, ease: "power2.out" },
                    "-=0.15",
                );
            if (refs.decoLine)
                tl.from(
                    refs.decoLine,
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
                { scale: 1.05, duration: 1.4, ease: "power3.out" },
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
                    y: 30,
                    rotateX: -15,
                    stagger: 0.015,
                    duration: 0.6,
                    ease: "back.out(1.6)",
                },
                "-=0.4",
            ).from(
                excerpt.lines,
                {
                    opacity: 0,
                    y: 20,
                    stagger: 0.05,
                    duration: 0.5,
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
                { scale: 1.05, duration: 1.4, ease: "power3.out" },
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
        "main p, main img, main ul, .flux-card, .prose > div, article, .rounded-3xl, .gsap-reveal",
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

// Ne pas appeler Alpine.start() manuellement.
// Livewire 4 intègre Alpine et le démarre après que @fluxScripts a
// enregistré le magic $flux. Appeler Alpine.start() ici provoquerait
// une erreur « $flux is not defined » car Flux n'aurait pas encore
// enregistré ses plugins Alpine.
