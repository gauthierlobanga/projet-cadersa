import { Passkeys } from '@laravel/passkeys';

window.Passkeys = Passkeys;

const getDefaultPasskeyName = () => {
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
};

const registerPasskeyComponents = () => {
    if (!window.Alpine || window.__cadersaPasskeyComponentsRegistered) {
        return;
    }

    window.__cadersaPasskeyComponentsRegistered = true;

    window.Alpine.data("passkeyRegistration", () => ({
        supported: false,
        showForm: false,
        name: "",
        loading: false,
        error: null,
        init() {
            this.name = getDefaultPasskeyName();
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
                await this.$wire.loadPasskeys();
            } catch (error) {
                if (error.constructor?.name !== "UserCancelledError") {
                    this.error = error.message;
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

    window.Alpine.data("passkeyVerify", () => ({
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

                window.Livewire?.navigate(response.redirect || "/dashboard");
            } catch (error) {
                if (error.constructor?.name !== "UserCancelledError") {
                    this.error = error.message;
                }
            } finally {
                this.loading = false;
            }
        },
    }));
};

if (window.Alpine) {
    registerPasskeyComponents();
}

document.addEventListener("alpine:init", registerPasskeyComponents, {
    once: true,
});

window.dispatchEvent(new CustomEvent("passkeys:ready"));
