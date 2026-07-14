<!DOCTYPE html>
<html lang="en" class="scrollbar-thin">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Build Laravel apps &amp; admin panels fast - Filament</title>
    <meta name="description"
        content="Filament is a powerful open-source UI framework for Laravel. Build and ship apps &amp; admin panels fast with Livewire." />


    <meta property="og:type" content="website" />
    <meta property="og:title" content="Build Laravel apps &amp; admin panels fast - Filament" />
    <meta property="og:description"
        content="Filament is a powerful open-source UI framework for Laravel. Build and ship apps &amp; admin panels fast with Livewire." />
    <meta property="og:image" content="https://filamentphp.com/og/home.png" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />


    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Build Laravel apps &amp; admin panels fast - Filament" />
    <meta name="twitter:description"
        content="Filament is a powerful open-source UI framework for Laravel. Build and ship apps &amp; admin panels fast with Livewire." />
    <meta name="twitter:image" content="https://filamentphp.com/og/home.png" />


    <link rel="icon" type="image/png" href="/favicon/favicon-96x96.png?v=6bT7Ed2SVA" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/favicon/favicon.svg?v=6bT7Ed2SVA" />
    <link rel="shortcut icon" href="/favicon/favicon.ico?v=6bT7Ed2SVA" />
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png?v=6bT7Ed2SVA" />
    <meta name="apple-mobile-web-app-title" content="Filament" />
    <link rel="manifest" href="/favicon/site.webmanifest?v=6bT7Ed2SVA" />


    <link rel="preload" as="font" type="font/woff2"
        href="https://filamentphp.com/build/assets/albert-sans-latin-wght-normal-BJ0ssN8N.woff2" crossorigin />
    <link rel="preload" as="font" type="font/woff2"
        href="https://filamentphp.com/build/assets/outfit-latin-wght-normal-Bc-8i84L.woff2" crossorigin />


    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <!-- Livewire Styles -->
    <style>
        [wire\:loading][wire\:loading],
        [wire\:loading\.delay][wire\:loading\.delay],
        [wire\:loading\.list-item][wire\:loading\.list-item],
        [wire\:loading\.inline-block][wire\:loading\.inline-block],
        [wire\:loading\.inline][wire\:loading\.inline],
        [wire\:loading\.block][wire\:loading\.block],
        [wire\:loading\.flex][wire\:loading\.flex],
        [wire\:loading\.table][wire\:loading\.table],
        [wire\:loading\.grid][wire\:loading\.grid],
        [wire\:loading\.inline-flex][wire\:loading\.inline-flex] {
            display: none;
        }

        [wire\:loading\.delay\.none][wire\:loading\.delay\.none],
        [wire\:loading\.delay\.shortest][wire\:loading\.delay\.shortest],
        [wire\:loading\.delay\.shorter][wire\:loading\.delay\.shorter],
        [wire\:loading\.delay\.short][wire\:loading\.delay\.short],
        [wire\:loading\.delay\.default][wire\:loading\.delay\.default],
        [wire\:loading\.delay\.long][wire\:loading\.delay\.long],
        [wire\:loading\.delay\.longer][wire\:loading\.delay\.longer],
        [wire\:loading\.delay\.longest][wire\:loading\.delay\.longest] {
            display: none;
        }

        [wire\:offline][wire\:offline] {
            display: none;
        }

        [wire\:dirty]:not(textarea):not(input):not(select) {
            display: none;
        }

        :root {
            --livewire-progress-bar-color: #2299dd;
        }

        [x-cloak] {
            display: none !important;
        }

        [wire\:cloak] {
            display: none !important;
        }

        dialog#livewire-error::backdrop {
            background-color: rgba(0, 0, 0, .6);
        }
    </style>
    <link rel="preload" as="style" href="https://filamentphp.com/build/assets/app-DzipoCla.css" />
    <link rel="stylesheet" href="https://filamentphp.com/build/assets/app-DzipoCla.css" data-navigate-track="reload" />
</head>

<body x-data="{
    showMobileMenu: false,
    navMediaQuery: window.matchMedia(
        '(min-width: ' +
        (getComputedStyle(document.documentElement)
            .getPropertyValue('--breakpoint-nav')
            .trim() || '50rem') +
        ')',
    ),
}"
    x-resize="
            if (navMediaQuery.matches) {
                showMobileMenu = false
            }
        "
    :class="{
        'overflow-hidden': showMobileMenu,
    }"
    class="bg-dots-pattern min-h-screen bg-[#faf9f5] bg-repeat font-albert-sans text-stone-600 antialiased selection:bg-stone-400/20 sm:px-5 lg:px-10">
    <main class="mx-auto w-full max-w-350 overflow-x-clip border-x border-b border-bone-100 bg-serenade-50">
        <nav class="sticky top-0 z-100 border-b border-bone-100 bg-serenade-50">
            <header data-triangle-decoration="bottom" class="flex h-16 w-full items-stretch justify-between nav:gap-3">

                <div class="flex w-22 items-stretch border-r border-bone-100 min-[370px]:w-25 2xs:w-30 nav:hidden">
                    <a href="/docs" aria-label="Open Filament documentation"
                        class="flex w-full items-center justify-center px-3.5 transition-all duration-300 ease-out hover:bg-bone-100/30 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset">
                        Docs
                    </a>
                </div>


                <div class="flex grow items-stretch nav:grow-0">

                    <a href="https://filamentphp.com" aria-label="Filament homepage"
                        class="group grid w-full grow place-items-center border-r border-bone-100 px-1 pb-0.5 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset min-[370px]:px-3.5">
                        <style>
                            [data-logo-pre-init] .logoLightBulb,
                            [data-logo-pre-init] .logoF2 {
                                opacity: 0 !important;
                            }

                            [data-logo-pre-init] .logoF1 {
                                translate: 8px;
                            }

                            [data-logo-pre-init] .logoI {
                                translate: -2px;
                            }

                            [data-logo-pre-init] .logoIDot {
                                translate: -2px;
                            }

                            [data-logo-pre-init] .logoL {
                                translate: -11px;
                            }

                            [data-logo-pre-init] .logoA {
                                translate: -11px;
                            }

                            [data-logo-pre-init] .logoM {
                                translate: -10px;
                            }

                            [data-logo-pre-init] .logoE {
                                translate: -9px;
                            }

                            [data-logo-pre-init] .logoN {
                                translate: -9px;
                            }

                            [data-logo-pre-init] .logoT {
                                translate: -8px;
                            }
                        </style>

                        <div class="relative top-1.25" data-logo-pre-init x-init="() => {
                            const logoInitialAnimation = $el.querySelectorAll('.logoInitialAnimation')
                            const logoLightBulb = $el.querySelectorAll('.logoLightBulb')
                            const logoF1 = $el.querySelectorAll('.logoF1')
                            const logoF2 = $el.querySelectorAll('.logoF2')
                            const logoI = $el.querySelector('.logoI')
                            const logoIDot = $el.querySelector('.logoIDot')
                            const logoL = $el.querySelector('.logoL')
                            const logoA = $el.querySelector('.logoA')
                            const logoM = $el.querySelector('.logoM')
                            const logoE = $el.querySelector('.logoE')
                            const logoN = $el.querySelector('.logoN')
                            const logoT = $el.querySelector('.logoT')
                            let isInitialAnimationComplete = false
                            const isReversed = false
                        
                            if (isReversed) {
                                gsap.set(logoLightBulb, {
                                    opacity: 1,
                                    y: 0,
                                    scale: 1,
                                    transformOrigin: '50% 50%',
                                })
                                gsap.set(logoF1, { x: 0, opacity: 0 })
                                gsap.set(logoF2, { x: 0, opacity: 1 })
                                gsap.set(logoI, { x: 0, opacity: 0 })
                                gsap.set(logoIDot, { x: 0, opacity: 0 })
                                gsap.set(logoL, { x: 0 })
                                gsap.set(logoA, { x: 0 })
                                gsap.set(logoM, { x: 0 })
                                gsap.set(logoE, { x: 0 })
                                gsap.set(logoN, { x: 0 })
                                gsap.set(logoT, { x: 0 })
                            } else {
                                gsap.set(logoLightBulb, {
                                    opacity: 0,
                                    y: -2,
                                    scale: 0.5,
                                    transformOrigin: '50% 50%',
                                })
                                gsap.set(logoF1, { x: 8 })
                                gsap.set(logoF2, { x: 8, opacity: 0 })
                                gsap.set(logoI, { x: -2 })
                                gsap.set(logoIDot, { x: -2 })
                                gsap.set(logoL, { x: -11 })
                                gsap.set(logoA, { x: -11 })
                                gsap.set(logoM, { x: -10 })
                                gsap.set(logoE, { x: -9 })
                                gsap.set(logoN, { x: -9 })
                                gsap.set(logoT, { x: -8 })
                            }
                        
                            $el.removeAttribute('data-logo-pre-init')
                            isInitialAnimationComplete = true
                        
                            let animation
                        
                            if (isReversed) {
                                animation = gsap
                                    .timeline({ paused: true })
                                    .to(
                                        logoLightBulb, {
                                            opacity: 0,
                                            y: -2,
                                            scale: 0.5,
                                            duration: 0.4,
                                            ease: 'sine.inOut',
                                            keyframes: {
                                                rotation: [0, -10, 0],
                                                easeEach: 'sine.inOut',
                                            },
                                        },
                                        0,
                                    )
                                    .to(
                                        logoF1, {
                                            x: 8,
                                            rotation: 0,
                                            opacity: 1,
                                            duration: 0.4,
                                            ease: 'sine.inOut',
                                            keyframes: {
                                                rotation: [0, -10, 0],
                                                easeEach: 'sine.inOut',
                                            },
                                        },
                                        0,
                                    )
                                    .to(
                                        logoF2, {
                                            x: 8,
                                            rotation: 0,
                                            opacity: 0,
                                            duration: 0.4,
                                            ease: 'sine.inOut',
                                            keyframes: {
                                                rotation: [0, -10, 0],
                                                easeEach: 'sine.inOut',
                                            },
                                        },
                                        0,
                                    )
                                    .to(
                                        logoI, {
                                            x: -2,
                                            opacity: 1,
                                            duration: 0.4,
                                            ease: 'sine.inOut',
                                        },
                                        0,
                                    )
                                    .to(
                                        logoIDot, {
                                            x: -2,
                                            opacity: 1,
                                            duration: 0.4,
                                            ease: 'sine.inOut',
                                        },
                                        0,
                                    )
                                    .to(
                                        logoL, {
                                            x: -11,
                                            rotation: 0,
                                            duration: 0.4,
                                            ease: 'sine.inOut',
                                            keyframes: {
                                                rotation: [0, -10, 0],
                                                easeEach: 'sine.inOut',
                                            },
                                        },
                                        0,
                                    )
                                    .to(
                                        logoA, {
                                            x: -11,
                                            rotation: 0,
                                            duration: 0.4,
                                            ease: 'sine.inOut',
                                            keyframes: {
                                                rotation: [0, -10, 0],
                                                easeEach: 'sine.inOut',
                                            },
                                        },
                                        0.02,
                                    )
                                    .to(
                                        logoM, {
                                            x: -10,
                                            rotation: 0,
                                            duration: 0.4,
                                            ease: 'sine.inOut',
                                            keyframes: {
                                                rotation: [0, -10, 0],
                                                easeEach: 'sine.inOut',
                                            },
                                        },
                                        0.04,
                                    )
                                    .to(
                                        logoE, {
                                            x: -9,
                                            rotation: 0,
                                            duration: 0.4,
                                            ease: 'sine.inOut',
                                            keyframes: {
                                                rotation: [0, -10, 0],
                                                easeEach: 'sine.inOut',
                                            },
                                        },
                                        0.06,
                                    )
                                    .to(
                                        logoN, {
                                            x: -9,
                                            rotation: 0,
                                            duration: 0.4,
                                            ease: 'sine.inOut',
                                            keyframes: {
                                                rotation: [0, -10, 0],
                                                easeEach: 'sine.inOut',
                                            },
                                        },
                                        0.08,
                                    )
                                    .to(
                                        logoT, {
                                            x: -8,
                                            rotation: 0,
                                            duration: 0.4,
                                            ease: 'sine.inOut',
                                            keyframes: {
                                                rotation: [0, -10, 0],
                                                easeEach: 'sine.inOut',
                                            },
                                        },
                                        0.1,
                                    )
                            } else {
                                animation = gsap
                                    .timeline({ paused: true })
                                    .to(
                                        logoLightBulb, {
                                            opacity: 1,
                                            y: 0,
                                            scale: 1,
                                            duration: 0.4,
                                            ease: 'sine.inOut',
                                            keyframes: {
                                                rotation: [0, -10, 0],
                                                easeEach: 'sine.inOut',
                                            },
                                        },
                                        0,
                                    )
                                    .to(
                                        logoF1, {
                                            x: 0,
                                            rotation: 0,
                                            opacity: 0,
                                            duration: 0.4,
                                            ease: 'sine.inOut',
                                            keyframes: {
                                                rotation: [0, -10, 0],
                                                easeEach: 'sine.inOut',
                                            },
                                        },
                                        0,
                                    )
                                    .to(
                                        logoF2, {
                                            x: 0,
                                            rotation: 0,
                                            opacity: 1,
                                            duration: 0.4,
                                            ease: 'sine.inOut',
                                            keyframes: {
                                                rotation: [0, -10, 0],
                                                easeEach: 'sine.inOut',
                                            },
                                        },
                                        0,
                                    )
                                    .to(
                                        logoI, {
                                            x: 0,
                                            color: '#efaf5d',
                                            opacity: 0,
                                            duration: 0.4,
                                            ease: 'sine.inOut',
                                        },
                                        0,
                                    )
                                    .to(
                                        logoIDot, {
                                            x: 0,
                                            color: '#efaf5d',
                                            opacity: 0,
                                            duration: 0.4,
                                            ease: 'sine.inOut',
                                        },
                                        0,
                                    )
                                    .to(
                                        [logoL, logoA, logoM, logoE, logoN, logoT], {
                                            x: 0,
                                            rotation: 0,
                                            duration: 0.4,
                                            stagger: 0.02,
                                            ease: 'sine.inOut',
                                            keyframes: {
                                                rotation: [0, -10, 0],
                                                easeEach: 'sine.inOut',
                                            },
                                        },
                                        0,
                                    )
                            }
                        
                            motion.hover($el, () => {
                                if (!isInitialAnimationComplete) {
                                    return
                                }
                                animation.play()
                        
                                return () => {
                                    if (!isInitialAnimationComplete) {
                                        return
                                    }
                                    animation.reverse()
                                }
                            })
                        }">
                            <svg class="h-10" viewBox="0 0 144 43" version="1.1" xmlns="http://www.w3.org/2000/svg">

                                <path class="logoInitialAnimation logoF1 fill-cocoa"
                                    d="M7.223,12.685L7.223,11.42C7.223,9.471 7.871,8.001 9.813,8.001L11.55,8.001L11.55,4L9.813,4C5.349,4 3.033,6.769 3.033,11.42L3.033,12.685L0,12.685L0,16.035L3.033,16.035L3.033,28.651L7.223,28.651L7.223,16.035L12.348,16.035L12.348,12.685L7.223,12.685Z" />

                                <path class="logoF2 fill-cocoa"
                                    d="M9.772,8.012L12.283,8.012C12.809,6.58 13.529,5.243 14.407,4.03L9.772,4.03C5.327,4.03 3.02,6.787 3.02,11.416L3.02,12.676L0,12.676L0,16.011L3.02,16.011L3.02,28.571L7.194,28.571L7.194,16.011L11.426,16.011C11.324,15.268 11.267,14.511 11.267,13.74C11.267,13.382 11.282,13.028 11.305,12.676L7.194,12.676L7.194,11.416C7.194,9.476 7.839,8.012 9.772,8.012" />

                                <g transform="matrix(1,0,0,1,0.214531,-0.010962)">
                                    <path class="logoInitialAnimation logoI fill-cocoa"
                                        d="M27.909,12.766L28.056,11.476L25.39,11.554L25.406,11.654C25.43,11.8 25.41,11.976 25.388,12.162C25.344,12.545 25.293,12.98 25.642,13.278C25.763,13.38 26.155,13.601 26.579,13.844C26.846,13.997 27.188,14.19 27.358,14.301C27.25,14.337 27.091,14.333 26.942,14.325C26.845,14.319 26.746,14.313 26.656,14.321L26.527,14.329C26.105,14.357 25.731,14.384 25.614,14.44C25.411,14.537 25.35,14.963 25.379,15.308C25.393,15.481 25.454,15.885 25.723,16.056L27.356,17.047L25.64,17.201L25.607,17.211C25.439,17.295 25.422,17.661 25.423,17.855C25.423,18.173 25.496,18.582 25.716,18.77L27.404,19.805C27.34,19.806 27.276,19.809 27.212,19.81C26.661,19.824 26.087,19.844 25.58,19.991L25.553,20.005C25.426,20.1 25.423,20.764 25.518,21.135C25.572,21.349 25.66,21.467 25.757,21.527L27.408,22.526L25.756,22.678L25.725,22.686C25.376,22.852 25.512,23.777 25.602,24.048L25.616,24.092L27.479,25.289L25.831,25.401C25.719,25.406 25.664,25.468 25.621,25.525C25.485,25.705 25.496,26.429 25.524,27.426C25.538,27.916 25.551,28.379 25.52,28.568L25.498,28.709L27.883,28.717L27.895,27.157L30.718,26.868L30.742,26.865L30.761,26.852C30.861,26.76 30.903,26.505 30.904,26.318C30.905,26.172 30.894,25.621 30.715,25.424L28.93,24.298L30.712,24.133L30.732,24.118C30.879,24.008 30.898,23.375 30.8,22.99C30.738,22.751 30.648,22.585 30.522,22.531L28.874,21.527C29.036,21.519 29.206,21.514 29.381,21.51C29.777,21.5 30.188,21.489 30.531,21.418C30.652,21.392 30.739,21.291 30.788,21.115C30.888,20.759 30.811,20.157 30.643,19.925C30.564,19.815 30.216,19.606 29.376,19.131C29.128,18.991 28.896,18.845 28.772,18.768C28.904,18.762 29.074,18.76 29.25,18.759C29.976,18.752 30.514,18.738 30.662,18.584C30.778,18.464 30.832,17.878 30.727,17.478C30.671,17.262 30.592,17.109 30.474,17.054L28.826,16.048L30.491,15.909L30.524,15.9C30.725,15.798 30.76,15.321 30.735,15.029C30.718,14.828 30.655,14.456 30.428,14.308" />
                                </g>

                                <g transform="matrix(0.995789,0,0,0.995652,0.338179,0.317612)">
                                    <path class="logoInitialAnimation logoIDot fill-cocoa"
                                        d="M27.694,5C26.228,5 25,6.095 25,7.498C25,8.901 26.228,10.029 27.694,10.029C29.159,10.029 30.319,8.934 30.319,7.498C30.319,6.061 29.126,5 27.694,5Z" />
                                </g>


                                <rect class="logoInitialAnimation logoL fill-cocoa" x="44.27" y="4.029" width="4.139"
                                    height="24.542" />

                                <path class="logoInitialAnimation logoA fill-cocoa"
                                    d="M59.517,24.895C57.243,24.895 55.139,23.159 55.139,20.606C55.139,18.052 57.243,16.317 59.517,16.317C61.791,16.317 63.86,17.848 63.86,20.606C63.86,23.363 61.757,24.895 59.517,24.895ZM63.86,14.649C62.706,12.879 60.365,12.335 58.94,12.335C54.766,12.335 50.864,15.5 50.864,20.606C50.864,25.711 54.766,28.877 58.94,28.877C60.501,28.877 62.842,28.162 63.86,26.528L63.86,28.571L67.999,28.571L67.999,12.675L63.86,12.675L63.86,14.649Z" />

                                <path class="logoInitialAnimation logoM fill-cocoa"
                                    d="M89.815,12.335C88.56,12.335 86.32,12.709 84.827,15.331C83.945,13.39 82.282,12.505 79.772,12.369C78.278,12.369 76.106,13.084 75.225,15.024L75.225,12.676L71.085,12.676L71.085,28.572L75.225,28.572L75.225,20.096C75.225,17.374 76.853,16.386 78.55,16.386C80.247,16.386 81.434,17.611 81.468,19.824L81.468,28.571L85.608,28.571L85.608,20.096C85.608,17.679 86.965,16.385 88.832,16.385C90.528,16.385 91.818,17.645 91.818,19.925L91.818,28.571L95.924,28.571L95.924,19.483C95.924,14.819 93.65,12.335 89.816,12.335" />

                                <path class="logoInitialAnimation logoE fill-cocoa"
                                    d="M102.121,19.176C102.427,17.031 104.123,15.806 106.295,15.806C108.331,15.806 109.959,16.997 110.265,19.176L102.121,19.176ZM106.261,12.335C101.748,12.335 98.05,15.569 98.05,20.572C98.05,25.576 101.748,28.912 106.261,28.912C109.179,28.912 112.233,27.788 113.658,25.065C112.64,24.52 111.487,23.908 110.503,23.363C109.757,24.725 108.128,25.406 106.533,25.406C104.192,25.406 102.427,24.112 102.156,22.002L114.235,22.002C114.269,21.628 114.303,20.981 114.303,20.573C114.303,15.569 110.775,12.335 106.262,12.335" />

                                <path class="logoInitialAnimation logoN fill-cocoa"
                                    d="M125.97,12.335C124.137,12.335 122.135,13.322 121.253,15.023L121.253,12.675L117.113,12.675L117.113,28.571L121.253,28.571L121.253,20.096C121.253,17.338 122.848,16.385 124.714,16.385C126.579,16.385 127.734,17.61 127.734,19.925L127.734,28.571L131.874,28.571L131.874,19.176C131.874,14.682 129.668,12.334 125.97,12.334" />

                                <path class="logoInitialAnimation logoT fill-cocoa"
                                    d="M136.535,6.616L136.535,12.675L133.65,12.675L133.65,16.011L136.535,16.011L136.535,28.571L140.641,28.571L140.641,16.011L144,16.011L144,12.675L140.641,12.675L140.641,6.616L136.535,6.616Z" />

                                <path class="logoLightBulb fill-honey-200"
                                    d="M25.233,7.782C25.233,9.213 26.455,10.303 27.915,10.303C29.375,10.303 30.53,9.213 30.53,7.782C30.53,6.352 29.341,5.296 27.915,5.296C26.489,5.296 25.233,6.386 25.233,7.782Z" />

                                <path class="logoLightBulb fill-honey-200"
                                    d="M33.7,1.323C30.892,-0.035 27.654,-0.361 24.586,0.407C22.56,0.916 20.657,1.909 19.088,3.277C18.809,3.513 18.539,3.765 18.277,4.029C17.4,4.915 16.623,5.955 15.965,7.135C15.802,7.423 15.652,7.715 15.511,8.011C14.805,9.496 14.374,11.08 14.241,12.674C14.211,13.046 14.194,13.419 14.195,13.792C14.185,14.526 14.244,15.266 14.368,16.01C14.511,16.859 14.736,17.712 15.051,18.56C15.565,19.922 16.262,21.168 16.929,22.322C17.603,23.527 18.154,24.541 18.648,25.566C19.044,26.406 19.395,27.283 19.698,28.178C19.796,28.469 19.889,28.762 19.977,29.057L20.155,29.691C20.299,30.209 20.577,30.648 20.957,30.959C21.656,31.533 22.585,31.667 23.464,31.308L25.825,30.177L28.861,28.723L28.786,27.072L30.929,26.852L30.953,26.85L30.971,26.837C31.092,26.751 31.113,26.425 31.114,26.24C31.115,26.094 31.105,25.604 30.928,25.408L29.139,24.285L30.922,24.119L30.941,24.105C31.088,23.996 31.107,23.333 31.008,22.95C30.948,22.712 30.845,22.56 30.72,22.507L29.086,21.516C29.248,21.507 29.416,21.503 29.59,21.498C29.985,21.488 30.393,21.478 30.736,21.406C30.857,21.381 30.944,21.279 30.993,21.104C31.092,20.75 31.021,20.131 30.855,19.901C30.775,19.791 30.413,19.576 29.577,19.103C29.33,18.963 29.096,18.831 28.973,18.754C29.105,18.748 29.273,18.747 29.448,18.745C30.171,18.738 30.696,18.723 30.862,18.584C31,18.469 31.042,17.837 30.938,17.438C30.881,17.224 30.787,17.083 30.67,17.029L29.036,16.038L30.701,15.899L30.735,15.889C30.934,15.789 30.97,15.291 30.946,15.001C30.929,14.801 30.867,14.444 30.642,14.296L28.125,12.755L28.271,11.465L25.604,11.543L25.621,11.643C25.644,11.788 25.624,11.963 25.602,12.149C25.559,12.531 25.509,12.963 25.856,13.259C25.976,13.361 26.375,13.59 26.797,13.831C27.063,13.984 27.406,14.18 27.575,14.29C27.467,14.327 27.315,14.318 27.167,14.31C27.071,14.304 26.971,14.299 26.882,14.306L26.754,14.314C26.334,14.342 25.946,14.371 25.829,14.426C25.627,14.522 25.565,14.936 25.594,15.281C25.608,15.454 25.669,15.873 25.937,16.043L27.573,17.036L25.859,17.187L25.825,17.197C25.658,17.281 25.634,17.616 25.634,17.809C25.634,18.125 25.706,18.558 25.924,18.745L27.619,19.793C27.556,19.794 27.492,19.797 27.429,19.798C26.879,19.812 26.31,19.827 25.805,19.973L25.778,19.987C25.652,20.082 25.643,20.734 25.731,21.104C25.784,21.327 25.874,21.47 25.986,21.523L27.623,22.515L25.973,22.666L25.942,22.674C25.594,22.84 25.725,23.76 25.814,24.029L25.828,24.073L27.694,25.278L26.048,25.389C25.936,25.395 25.881,25.457 25.838,25.513C25.736,25.649 25.716,26.064 25.725,26.687L22.928,28.121C22.526,26.781 22.026,25.473 21.44,24.227C20.905,23.117 20.325,22.049 19.616,20.782C18.982,19.686 18.377,18.607 17.949,17.469C17.494,16.244 17.272,15.013 17.289,13.806C17.281,12.04 17.755,10.261 18.66,8.658C19.335,7.45 20.154,6.435 21.099,5.635C22.315,4.575 23.78,3.809 25.335,3.418C25.403,3.4 25.471,3.386 25.539,3.371L25.601,3.358C27.314,2.978 29.114,3.038 30.807,3.528C31.353,3.686 31.877,3.886 32.366,4.122C34.263,5.023 35.908,6.558 36.999,8.449C38.197,10.474 38.699,12.799 38.413,14.999C38.278,16.152 37.912,17.369 37.328,18.611C37.019,19.238 36.663,19.862 36.318,20.466C36.1,20.849 35.882,21.233 35.67,21.623C35.027,22.81 33.998,25.213 33.66,26.003C33.6,26.143 33.562,26.233 33.546,26.266C33.191,27.089 32.681,28.272 32.517,28.649L29.277,30.223L22.526,33.501C21.759,33.811 21.307,34.598 21.426,35.422C21.542,36.23 22.207,36.854 23.065,36.954L27.329,37.104L21.883,40.192L23.155,42.998L34.252,37.646C35.135,37.238 35.527,36.211 35.146,35.309C34.893,34.709 34.312,34.295 33.63,34.228L29.608,33.244L34.727,31.075C34.852,31.018 34.859,31.013 36.174,27.988C36.234,27.849 36.296,27.705 36.362,27.553C36.363,27.551 36.374,27.525 36.394,27.479C36.797,26.527 37.799,24.195 38.388,23.107C38.582,22.747 38.784,22.392 38.987,22.038L39.004,22.009C39.355,21.395 39.752,20.699 40.115,19.961C40.849,18.399 41.31,16.857 41.483,15.382C41.856,12.51 41.211,9.489 39.667,6.877C38.271,4.459 36.15,2.487 33.699,1.321" />
                            </svg>
                        </div>
                    </a>


                    <nav class="hidden items-center gap-2 pl-3.5 nav:flex">
                        <div>
                            <a x-data="{ isActive: true }" href="https://filamentphp.com" aria-current="page"
                                class="group relative inline-grid place-items-center px-2 py-1.5 transition-all duration-300 ease-out will-change-transform focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset font-medium text-stone-800"
                                x-init="() => {
                                    const animation = gsap.timeline({ paused: true })
                                
                                    animation
                                        .fromTo(
                                            $refs['navbar-link-top-left'], { x: -15, y: -15, opacity: 0 }, {
                                                x: 0,
                                                y: 0,
                                                opacity: 1,
                                                duration: 0.25,
                                                ease: 'circ.out',
                                            },
                                        )
                                        .fromTo(
                                            $refs['navbar-link-bottom-right'], { x: 15, y: 15, opacity: 0 }, {
                                                x: 0,
                                                y: 0,
                                                opacity: 1,
                                                duration: 0.25,
                                                ease: 'circ.out',
                                            },
                                            '<',
                                        )
                                        .to(
                                            $refs['navbar-link-label'], {
                                                scale: 0.9,
                                                duration: 0.35,
                                                ease: 'sine.out',
                                            },
                                            0,
                                        )
                                
                                    if (!isActive) {
                                        motion.hover($el, () => {
                                            animation.play()
                                
                                            return () => {
                                                animation.reverse()
                                            }
                                        })
                                    } else {
                                        animation.progress(1)
                                    }
                                }">
                                <div class="absolute top-0 left-0" x-ref="navbar-link-top-left" :aria-hidden="true"
                                    :class="{
                                        'grayscale': !isActive,
                                    }">
                                    <svg class="h-2 text-amber-600" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 11 11" fill="none">
                                        <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                                    </svg>
                                </div>

                                <span x-ref="navbar-link-label" class="flex items-center gap-1.5 whitespace-nowrap"
                                    style="transform: scale(0.9)">
                                    Home

                                </span>

                                <div class="absolute right-0 bottom-0" x-ref="navbar-link-bottom-right"
                                    :aria-hidden="true"
                                    :class="{
                                        'grayscale': !isActive,
                                    }">
                                    <svg class="h-2 -scale-x-100 -scale-y-100 text-blue-400"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 11 11" fill="none">
                                        <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                                    </svg>
                                </div>
                            </a>
                        </div>
                        <div>
                            <a x-data="{ isActive: false }" href="https://filamentphp.com/plugins"
                                class="group relative inline-grid place-items-center px-2 py-1.5 transition-all duration-300 ease-out will-change-transform focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset hover:font-medium hover:text-stone-800"
                                x-init="() => {
                                    const animation = gsap.timeline({ paused: true })
                                
                                    animation
                                        .fromTo(
                                            $refs['navbar-link-top-left'], { x: -15, y: -15, opacity: 0 }, {
                                                x: 0,
                                                y: 0,
                                                opacity: 1,
                                                duration: 0.25,
                                                ease: 'circ.out',
                                            },
                                        )
                                        .fromTo(
                                            $refs['navbar-link-bottom-right'], { x: 15, y: 15, opacity: 0 }, {
                                                x: 0,
                                                y: 0,
                                                opacity: 1,
                                                duration: 0.25,
                                                ease: 'circ.out',
                                            },
                                            '<',
                                        )
                                        .to(
                                            $refs['navbar-link-label'], {
                                                scale: 0.9,
                                                duration: 0.35,
                                                ease: 'sine.out',
                                            },
                                            0,
                                        )
                                
                                    if (!isActive) {
                                        motion.hover($el, () => {
                                            animation.play()
                                
                                            return () => {
                                                animation.reverse()
                                            }
                                        })
                                    } else {
                                        animation.progress(1)
                                    }
                                }">
                                <div class="absolute top-0 left-0 opacity-0" x-ref="navbar-link-top-left"
                                    :aria-hidden="true"
                                    :class="{
                                        'grayscale': !isActive,
                                    }">
                                    <svg class="h-2 text-amber-600" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 11 11" fill="none">
                                        <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                                    </svg>
                                </div>

                                <span x-ref="navbar-link-label" class="flex items-center gap-1.5 whitespace-nowrap">
                                    Plugins

                                </span>

                                <div class="absolute right-0 bottom-0 opacity-0" x-ref="navbar-link-bottom-right"
                                    :aria-hidden="true"
                                    :class="{
                                        'grayscale': !isActive,
                                    }">
                                    <svg class="h-2 -scale-x-100 -scale-y-100 text-blue-400"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 11 11" fill="none">
                                        <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                                    </svg>
                                </div>
                            </a>
                        </div>
                        <div>
                            <a x-data="{ isActive: false }" href="https://filamentphp.com/insights"
                                class="group relative inline-grid place-items-center px-2 py-1.5 transition-all duration-300 ease-out will-change-transform focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset hover:font-medium hover:text-stone-800"
                                x-init="() => {
                                    const animation = gsap.timeline({ paused: true })
                                
                                    animation
                                        .fromTo(
                                            $refs['navbar-link-top-left'], { x: -15, y: -15, opacity: 0 }, {
                                                x: 0,
                                                y: 0,
                                                opacity: 1,
                                                duration: 0.25,
                                                ease: 'circ.out',
                                            },
                                        )
                                        .fromTo(
                                            $refs['navbar-link-bottom-right'], { x: 15, y: 15, opacity: 0 }, {
                                                x: 0,
                                                y: 0,
                                                opacity: 1,
                                                duration: 0.25,
                                                ease: 'circ.out',
                                            },
                                            '<',
                                        )
                                        .to(
                                            $refs['navbar-link-label'], {
                                                scale: 0.9,
                                                duration: 0.35,
                                                ease: 'sine.out',
                                            },
                                            0,
                                        )
                                
                                    if (!isActive) {
                                        motion.hover($el, () => {
                                            animation.play()
                                
                                            return () => {
                                                animation.reverse()
                                            }
                                        })
                                    } else {
                                        animation.progress(1)
                                    }
                                }">
                                <div class="absolute top-0 left-0 opacity-0" x-ref="navbar-link-top-left"
                                    :aria-hidden="true"
                                    :class="{
                                        'grayscale': !isActive,
                                    }">
                                    <svg class="h-2 text-amber-600" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 11 11" fill="none">
                                        <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                                    </svg>
                                </div>

                                <span x-ref="navbar-link-label" class="flex items-center gap-1.5 whitespace-nowrap">
                                    Insights

                                </span>

                                <div class="absolute right-0 bottom-0 opacity-0" x-ref="navbar-link-bottom-right"
                                    :aria-hidden="true"
                                    :class="{
                                        'grayscale': !isActive,
                                    }">
                                    <svg class="h-2 -scale-x-100 -scale-y-100 text-blue-400"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 11 11" fill="none">
                                        <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                                    </svg>
                                </div>
                            </a>
                        </div>
                        <div>
                            <a x-data="{ isActive: false }" href="https://filamentphp.com/consulting"
                                class="group relative inline-grid place-items-center px-2 py-1.5 transition-all duration-300 ease-out will-change-transform focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset hover:font-medium hover:text-stone-800"
                                x-init="() => {
                                    const animation = gsap.timeline({ paused: true })
                                
                                    animation
                                        .fromTo(
                                            $refs['navbar-link-top-left'], { x: -15, y: -15, opacity: 0 }, {
                                                x: 0,
                                                y: 0,
                                                opacity: 1,
                                                duration: 0.25,
                                                ease: 'circ.out',
                                            },
                                        )
                                        .fromTo(
                                            $refs['navbar-link-bottom-right'], { x: 15, y: 15, opacity: 0 }, {
                                                x: 0,
                                                y: 0,
                                                opacity: 1,
                                                duration: 0.25,
                                                ease: 'circ.out',
                                            },
                                            '<',
                                        )
                                        .to(
                                            $refs['navbar-link-label'], {
                                                scale: 0.9,
                                                duration: 0.35,
                                                ease: 'sine.out',
                                            },
                                            0,
                                        )
                                
                                    if (!isActive) {
                                        motion.hover($el, () => {
                                            animation.play()
                                
                                            return () => {
                                                animation.reverse()
                                            }
                                        })
                                    } else {
                                        animation.progress(1)
                                    }
                                }">
                                <div class="absolute top-0 left-0 opacity-0" x-ref="navbar-link-top-left"
                                    :aria-hidden="true"
                                    :class="{
                                        'grayscale': !isActive,
                                    }">
                                    <svg class="h-2 text-amber-600" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 11 11" fill="none">
                                        <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                                    </svg>
                                </div>

                                <span x-ref="navbar-link-label" class="flex items-center gap-1.5 whitespace-nowrap">
                                    Consulting

                                </span>

                                <div class="absolute right-0 bottom-0 opacity-0" x-ref="navbar-link-bottom-right"
                                    :aria-hidden="true"
                                    :class="{
                                        'grayscale': !isActive,
                                    }">
                                    <svg class="h-2 -scale-x-100 -scale-y-100 text-blue-400"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 11 11" fill="none">
                                        <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                                    </svg>
                                </div>
                            </a>
                        </div>
                        <div>
                            <a x-data="{ isActive: false }" href="https://filamentphp.com/custom-dashboards-plugin"
                                class="group relative inline-grid place-items-center px-2 py-1.5 transition-all duration-300 ease-out will-change-transform focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset hover:font-medium hover:text-stone-800"
                                x-init="() => {
                                    const animation = gsap.timeline({ paused: true })
                                
                                    animation
                                        .fromTo(
                                            $refs['navbar-link-top-left'], { x: -15, y: -15, opacity: 0 }, {
                                                x: 0,
                                                y: 0,
                                                opacity: 1,
                                                duration: 0.25,
                                                ease: 'circ.out',
                                            },
                                        )
                                        .fromTo(
                                            $refs['navbar-link-bottom-right'], { x: 15, y: 15, opacity: 0 }, {
                                                x: 0,
                                                y: 0,
                                                opacity: 1,
                                                duration: 0.25,
                                                ease: 'circ.out',
                                            },
                                            '<',
                                        )
                                        .to(
                                            $refs['navbar-link-label'], {
                                                scale: 0.9,
                                                duration: 0.35,
                                                ease: 'sine.out',
                                            },
                                            0,
                                        )
                                
                                    if (!isActive) {
                                        motion.hover($el, () => {
                                            animation.play()
                                
                                            return () => {
                                                animation.reverse()
                                            }
                                        })
                                    } else {
                                        animation.progress(1)
                                    }
                                }">
                                <div class="absolute top-0 left-0 opacity-0" x-ref="navbar-link-top-left"
                                    :aria-hidden="true"
                                    :class="{
                                        'grayscale': !isActive,
                                    }">
                                    <svg class="h-2 text-amber-600" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 11 11" fill="none">
                                        <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                                    </svg>
                                </div>

                                <span x-ref="navbar-link-label" class="flex items-center gap-1.5 whitespace-nowrap">
                                    <span class="hidden lg:inline">Custom </span>Dashboards

                                    <div class="inline-flex items-center">
                                        <span
                                            class="relative inline-block overflow-hidden rounded-xs bg-honey-200 px-1.25 py-px font-roboto-mono text-xs font-medium tracking-wide text-cocoa uppercase"
                                            x-init="() => {
                                                const shine = $refs.shine
                                            
                                                const tween = gsap.fromTo(
                                                    shine, { x: '-100%', opacity: 1 }, {
                                                        x: '200%',
                                                        opacity: 0,
                                                        duration: 1.2,
                                                        ease: 'power2.inOut',
                                                        repeat: -1,
                                                        repeatDelay: 1,
                                                        paused: true,
                                                    },
                                                )
                                            
                                                motion.inView($el, () => {
                                                    tween.play()
                                                    return () => tween.pause()
                                                })
                                            }">
                                            New
                                            <span x-ref="shine"
                                                class="pointer-events-none absolute inset-y-0 -left-full w-full skew-x-[-20deg] bg-linear-to-r from-transparent via-white to-transparent"
                                                aria-hidden="true"></span>
                                        </span>
                                    </div>
                                </span>

                                <div class="absolute right-0 bottom-0 opacity-0" x-ref="navbar-link-bottom-right"
                                    :aria-hidden="true"
                                    :class="{
                                        'grayscale': !isActive,
                                    }">
                                    <svg class="h-2 -scale-x-100 -scale-y-100 text-blue-400"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 11 11" fill="none">
                                        <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                                    </svg>
                                </div>
                            </a>
                        </div>
                    </nav>
                </div>


                <div class="flex items-stretch">

                    <div class="hidden border-r border-bone-100 nav-github:flex">
                        <a href="https://github.com/filamentphp/filament" target="_blank" rel="noopener noreferrer"
                            aria-label="Open Filament GitHub repository"
                            class="group flex items-center gap-2.5 pr-3 pb-0.5 whitespace-nowrap transition-all duration-300 ease-out hover:pr-4 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset"
                            x-init="() => {
                                const star = $refs.star
                                const sparks = $refs.sparksContainer.querySelectorAll('[data-spark]')
                            
                                // Set initial state - sparks hidden
                                gsap.set(sparks, { opacity: 0 })
                            
                                const hoverAnimation = gsap.timeline({ paused: true })
                            
                                // Star bounce and fill
                                hoverAnimation.to(
                                    star, {
                                        scale: 1.25,
                                        duration: 0.2,
                                        ease: 'back.out(2)',
                                    },
                                    0,
                                )
                            
                                // Sparks burst outward
                                sparks.forEach((spark, i) => {
                                    const angle = parseFloat(spark.dataset.angle) * (Math.PI / 180)
                                    const distance = 6
                            
                                    hoverAnimation.fromTo(
                                        spark, {
                                            opacity: 1,
                                            '--spark-distance': '0px',
                                        }, {
                                            opacity: 0,
                                            '--spark-distance': distance + 'px',
                                            duration: 0.5,
                                            ease: 'power2.out',
                                            stagger: 0.5,
                                            immediateRender: false,
                                        },
                                        0.02 + i * 0.02,
                                    )
                                })
                            
                                motion.hover($el, () => {
                                    hoverAnimation.restart()
                            
                                    return () => {
                                        gsap.to(star, {
                                            scale: 1,
                                            rotation: 0,
                                            duration: 0.3,
                                            ease: 'power2.out',
                                        })
                                    }
                                })
                            }">
                            <div class="relative" x-ref="sparksContainer">
                                <svg x-ref="star"
                                    class="size-4 shrink-0 text-transparent transition-colors duration-300 ease-out [--icon-stroke:var(--color-stone-800)] group-hover:text-honey-200"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18" fill="none">
                                    <path
                                        d="M8.08887 0.989258C8.31973 0.427753 9.07211 0.326095 9.44336 0.806641C9.4865 0.862481 9.52201 0.923989 9.54883 0.989258V0.991211L11.3418 5.33105L11.458 5.61328L11.7637 5.63867L16.4102 6.0127V6.01367C17.0215 6.06538 17.3475 6.75913 16.9971 7.2627C16.9591 7.31722 16.9145 7.36673 16.8643 7.41016L15.5156 8.57422L15.5205 8.57324L13.3232 10.4697L13.0938 10.668L13.1631 10.9629L14.2432 15.5381L14.2441 15.54C14.3864 16.1331 13.8328 16.6577 13.248 16.4844C13.1823 16.4648 13.1191 16.4371 13.0605 16.4014H13.0615L9.08301 13.9531L8.82031 13.792L8.55859 13.9531L4.5791 16.4004C4.05796 16.7169 3.38971 16.3508 3.37598 15.7412C3.37445 15.6735 3.38178 15.6059 3.39746 15.54V15.5391L4.48145 10.9629L4.55176 10.668L4.32129 10.4697L0.776367 7.41016C0.312197 7.00899 0.456622 6.25511 1.03613 6.05371C1.09645 6.03279 1.1591 6.01868 1.22266 6.0127L1.22363 6.01367L5.87305 5.63867L6.17773 5.61328L6.29492 5.33105L8.08789 0.991211L8.08887 0.989258Z"
                                        class="fill-current stroke-(--icon-stroke) [stroke-width:var(--stroke-width,1)]" />
                                </svg>


                                <div data-spark data-angle="-45"
                                    class="pointer-events-none absolute -top-1 -right-1 -rotate-45 opacity-0"
                                    style="
                                translate: calc(
                                        var(--spark-distance, 0px) * 0.707
                                    )
                                    calc(var(--spark-distance, 0px) * -0.707);
                            ">
                                    <div class="h-0.5 w-1.5 rounded-full bg-honey-200"></div>
                                </div>


                                <div data-spark data-angle="45"
                                    class="pointer-events-none absolute -right-1 -bottom-1 rotate-45 opacity-0"
                                    style="
                                translate: calc(
                                        var(--spark-distance, 0px) * 0.707
                                    )
                                    calc(var(--spark-distance, 0px) * 0.707);
                            ">
                                    <div class="h-0.5 w-1.5 rounded-full bg-honey-200"></div>
                                </div>


                                <div data-spark data-angle="-135"
                                    class="pointer-events-none absolute -top-1 -left-1 rotate-45 opacity-0"
                                    style="
                                translate: calc(
                                        var(--spark-distance, 0px) * -0.707
                                    )
                                    calc(var(--spark-distance, 0px) * -0.707);
                            ">
                                    <div class="h-0.5 w-1.5 rounded-full bg-honey-200"></div>
                                </div>


                                <div data-spark data-angle="135"
                                    class="pointer-events-none absolute -bottom-1 -left-1 -rotate-45 opacity-0"
                                    style="
                                translate: calc(
                                        var(--spark-distance, 0px) * -0.707
                                    )
                                    calc(var(--spark-distance, 0px) * 0.707);
                            ">
                                    <div class="h-0.5 w-1.5 rounded-full bg-honey-200"></div>
                                </div>
                            </div>
                            <div>
                                <div class="leading-5 font-semibold text-stone-800">
                                    31.4K+
                                </div>
                                <div class="text-sm">GitHub stars</div>
                            </div>
                        </a>
                    </div>

                    <div class="flex items-stretch">

                        <div class="hidden nav-search:flex">
                            <button type="button" x-on:click="$dispatch('open-search-modal')"
                                aria-label="Search the documentation"
                                class="group flex items-center gap-5 px-3.5 transition-all duration-300 ease-out hover:gap-6 hover:bg-bone-100/30 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset"
                                x-init="() => {
                                    const animation = gsap.timeline({ paused: true })
                                    animation.to($refs.circle, {
                                        keyframes: {
                                            scaleX: [1, 0, 1],
                                        },
                                        duration: 0.6,
                                        ease: 'circ.inOut',
                                    })
                                    motion.hover($el, () => {
                                        animation.play()
                                
                                        return () => {
                                            animation.reverse()
                                        }
                                    })
                                }">
                                <div class="flex items-center gap-2">

                                    <div class="relative top-0.5 flex flex-col items-center justify-center">

                                        <div x-ref="circle"
                                            class="size-2.5 -rotate-45 rounded-full ring-1 ring-stone-800"></div>

                                        <div class="relative -top-0.5 left-1.25 h-1.5 w-px -rotate-45 bg-stone-800">
                                        </div>
                                    </div>
                                    <div>Search...</div>
                                </div>
                                <span class="hidden items-center gap-1 text-sm nav-expanded:flex">
                                    <span>
                                        Ctrl
                                    </span>
                                    <span
                                        class="-mx-1.5 opacity-0 transition-all duration-300 ease-out group-hover:-mx-0.5 group-hover:opacity-100">
                                        +
                                    </span>
                                    <span>K</span>
                                </span>
                            </button>
                        </div>


                        <svg class="-mx-px hidden h-full text-bone-300 nav-search:block"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1 75" fill="none">
                            <path d="M0.5 0V75" stroke="currentColor" stroke-dasharray="6 6" />
                        </svg>


                        <div
                            class="hidden justify-center border-l border-bone-100 nav:flex nav:w-auto nav-github:border-l-0">
                            <a href="/docs" aria-label="Open Filament documentation"
                                class="flex w-full items-center justify-center gap-2.5 px-3.5 transition-all duration-300 ease-out hover:bg-bone-100/30 hover:px-4 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset nav:hover:gap-3">
                                <img src="https://filamentphp.com/build/assets/barney-C7Py5uPh.webp"
                                    alt="Barney, the Filament mascot" aria-hidden="true" width="20"
                                    height="32" fetchpriority="high" class="hidden w-5 -scale-x-100 nav:block" />
                                <span class="block nav-expanded:hidden">Docs</span>
                                <span class="hidden nav-expanded:block">
                                    Documentation
                                </span>
                            </a>
                        </div>
                    </div>


                    <div class="relative z-40 nav:hidden">

                        <button type="button" x-on:click="showMobileMenu = true"
                            class="grid h-full w-22 place-items-center overflow-hidden transition duration-300 ease-out hover:bg-bone-100/30 focus:ring-0 focus:outline-none min-[370px]:w-25 2xs:w-30 nav:hidden nav:w-auto"
                            aria-label="Open menu" aria-expanded="false" x-bind:aria-expanded="showMobileMenu">
                            <div>Menu</div>
                        </button>


                        <div x-show="showMobileMenu" x-cloak class="fixed inset-0 z-50 nav:hidden" role="dialog"
                            aria-modal="true" aria-labelledby="mobile-menu-title" x-trap.noscroll="showMobileMenu"
                            x-on:click.self="showMobileMenu = false" x-init="() => {
                                const overlay = $refs.overlay
                                const menuPanel = $refs.menuPanel
                                const closeBtn = $refs.closeBtn
                                const docsBtn = $refs.docsBtn
                                const navItems = $refs.navItems.children
                                const dragHandle = $refs.dragHandle
                                const badges = $refs.navItems.querySelectorAll('[data-badge]')
                                const plusDecoration = $refs.plusDecoration
                                const plusLines = $refs.plusDecoration.querySelectorAll('[data-plus-line]')
                                const plusSymbol = $refs.plusDecoration.querySelector('[data-plus-symbol]')
                                let draggableInstance = null
                            
                                // Watch for menu state changes
                                $watch('showMobileMenu', (isOpen) => {
                                    if (isOpen) {
                                        // Opening animation
                                        const tl = gsap.timeline({
                                            onComplete: () => {
                                                // Initialize draggable after opening animation
                                                draggableInstance = Draggable.create(menuPanel, {
                                                    type: 'y',
                                                    trigger: dragHandle,
                                                    bounds: { minY: 0, maxY: window.innerHeight },
                                                    inertia: true,
                                                    onPress: function() {
                                                        // Animate drag handle to larger width
                                                        gsap.to(dragHandle.querySelector('div'), {
                                                            width: 72,
                                                            duration: 0.3,
                                                            ease: 'back.out(1.7)',
                                                        })
                                                    },
                                                    onDrag: function() {
                                                        // Update overlay opacity based on drag position
                                                        const dragProgress =
                                                            this.y / (window.innerHeight * 0.5)
                                                        const newOpacity = Math.max(0, 1 - dragProgress)
                                                        gsap.set(overlay, { opacity: newOpacity })
                            
                                                        // Update drag handle fill based on drag distance
                                                        const maxDrag = 200 // Maximum drag distance for full fill
                                                        const fillProgress = Math.min(1, this.y / maxDrag)
                                                        const fillWidth = fillProgress * 100
                            
                                                        gsap.set(dragHandle.querySelector('div'), {
                                                            background: `linear-gradient(to right, rgb(120 113 108) ${fillWidth}%, rgb(120 113 108 / 0.4) ${fillWidth}%)`,
                                                        })
                                                    },
                                                    onRelease: function() {
                                                        // Reset drag handle width and fill
                                                        gsap.to(dragHandle.querySelector('div'), {
                                                            width: 48,
                                                            background: 'rgb(120 113 108 / 0.4)',
                                                            duration: 0.3,
                                                            ease: 'power2.out',
                                                        })
                                                    },
                                                    onDragEnd: function() {
                                                        const threshold = 100
                            
                                                        if (this.y > threshold) {
                                                            // Close menu if dragged down past threshold
                                                            showMobileMenu = false
                                                        } else {
                                                            // Snap back to original position
                                                            gsap.to(menuPanel, {
                                                                y: 0,
                                                                duration: 0.3,
                                                                ease: 'back.out(1.7)',
                                                            })
                                                            gsap.to(overlay, {
                                                                opacity: 1,
                                                                duration: 0.3,
                                                            })
                                                        }
                            
                                                        // Ensure drag handle is reset
                                                        gsap.to(dragHandle.querySelector('div'), {
                                                            width: 48,
                                                            background: 'rgb(120 113 108 / 0.4)',
                                                            duration: 0.3,
                                                            ease: 'power2.out',
                                                        })
                                                    },
                                                })[0]
                                            },
                                        })
                            
                                        // Animate overlay
                                        tl.fromTo(
                                            overlay, { opacity: 0 }, {
                                                opacity: 1,
                                                duration: 0.3,
                                                ease: 'power2.out',
                                            },
                                        )
                            
                                        // Animate top buttons
                                        tl.fromTo(
                                            [closeBtn, docsBtn], {
                                                y: -20,
                                                opacity: 0,
                                            }, {
                                                y: 0,
                                                opacity: 1,
                                                duration: 0.5,
                                                stagger: 0.1,
                                                ease: 'back.out(2)',
                                            },
                                            '<0.1',
                                        )
                            
                                        // Animate menu panel from bottom
                                        tl.fromTo(
                                            menuPanel, {
                                                y: 100,
                                                opacity: 0,
                                            }, {
                                                y: 0,
                                                opacity: 1,
                                                duration: 0.5,
                                                ease: 'back.out(1.7)',
                                            },
                                            '<0.1',
                                        )
                            
                                        // Animate navigation items
                                        tl.fromTo(
                                            navItems, {
                                                y: 30,
                                                opacity: 0,
                                            }, {
                                                y: 0,
                                                opacity: 1,
                                                duration: 0.5,
                                                stagger: 0.08,
                                                ease: 'back.out(2)',
                                            },
                                            '<0.2',
                                        )
                            
                                        // Animate you-are-here badges with pop-in effect
                                        if (badges.length > 0) {
                                            tl.fromTo(
                                                badges, {
                                                    scale: 0,
                                                    x: -10,
                                                    opacity: 0,
                                                }, {
                                                    scale: 1,
                                                    x: 0,
                                                    opacity: 1,
                                                    duration: 0.4,
                                                    stagger: 0.1,
                                                    ease: 'back.out(1.5)',
                                                },
                                                '<0.5',
                                            )
                                        }
                            
                                        // Animate plus lines stretching from sides
                                        tl.fromTo(
                                            plusLines[0], {
                                                scaleX: 0,
                                                transformOrigin: 'right center',
                                            }, {
                                                scaleX: 1,
                                                duration: 0.5,
                                                ease: 'power2.out',
                                            },
                                            '<',
                                        )
                            
                                        tl.fromTo(
                                            plusLines[1], {
                                                scaleX: 0,
                                                transformOrigin: 'left center',
                                            }, {
                                                scaleX: 1,
                                                duration: 0.5,
                                                ease: 'power2.out',
                                            },
                                            '<',
                                        )
                            
                                        // Animate plus symbol with scale pop
                                        tl.fromTo(
                                            plusSymbol, {
                                                scale: 0,
                                                opacity: 0,
                                            }, {
                                                scale: 1,
                                                opacity: 1,
                                                duration: 0.4,
                                                ease: 'back.out(2.5)',
                                            },
                                            '<',
                                        )
                                    } else {
                                        // Kill draggable instance
                                        if (draggableInstance) {
                                            draggableInstance.kill()
                                            draggableInstance = null
                                        }
                            
                                        // Closing animation
                                        const tl = gsap.timeline()
                            
                                        // Animate plus symbol out
                                        tl.to(plusSymbol, {
                                            scale: 0,
                                            opacity: 0,
                                            duration: 0.2,
                                            ease: 'power2.in',
                                        })
                            
                                        // Animate plus lines out
                                        tl.to(
                                            plusLines, {
                                                scaleX: 0,
                                                duration: 0.25,
                                                ease: 'power2.in',
                                            },
                                            '<0.1',
                                        )
                            
                                        // Animate badges out first
                                        if (badges.length > 0) {
                                            tl.to(
                                                badges, {
                                                    scale: 0,
                                                    opacity: 0,
                                                    duration: 0.2,
                                                    stagger: 0.05,
                                                    ease: 'power2.in',
                                                },
                                                '<',
                                            )
                                        }
                            
                                        // Animate nav items out
                                        tl.to(
                                            navItems, {
                                                y: 20,
                                                opacity: 0,
                                                duration: 0.25,
                                                stagger: 0.03,
                                                ease: 'power2.in',
                                            },
                                            '<',
                                        )
                            
                                        // Animate menu panel out
                                        tl.to(
                                            menuPanel, {
                                                y: 50,
                                                opacity: 0,
                                                duration: 0.3,
                                                ease: 'power2.in',
                                            },
                                            '<',
                                        )
                            
                                        // Animate buttons out
                                        tl.to(
                                            [closeBtn, docsBtn], {
                                                y: -15,
                                                opacity: 0,
                                                duration: 0.25,
                                                stagger: 0.05,
                                                ease: 'power2.in',
                                            },
                                            '<',
                                        )
                            
                                        // Animate overlay out
                                        tl.to(
                                            overlay, {
                                                opacity: 0,
                                                duration: 0.2,
                                                ease: 'power2.in',
                                            },
                                            '<0.1',
                                        )
                                    }
                                })
                            }">

                            <div x-ref="overlay" x-on:click="showMobileMenu = false"
                                class="bg-dots-pattern absolute inset-0 bg-black/21 bg-repeat backdrop-blur-sm"
                                aria-hidden="true"></div>


                            <div class="pointer-events-none relative flex h-full flex-col px-5"
                                x-on:click="showMobileMenu = false">
                                <span id="mobile-menu-title" class="sr-only">
                                    Navigation menu
                                </span>


                                <div
                                    class="pointer-events-none absolute top-0 right-0 left-0 z-20 flex items-center justify-between px-5 py-4 text-sm">

                                    <div x-ref="docsBtn">
                                        <a href="https://github.com/filamentphp/filament" target="_blank"
                                            rel="noopener noreferrer" x-on:click="showMobileMenu = false"
                                            class="group pointer-events-auto flex h-10 w-23 items-center justify-center gap-1.5 overflow-hidden rounded-md bg-serenade-50 pr-3 pl-3.5 text-stone-800 transition-all duration-300 ease-out hover:w-35 hover:bg-cream-100 focus:outline-none">
                                            <svg class="size-4 shrink-0 text-transparent transition-all duration-300 ease-out [--icon-stroke:var(--color-stone-800)] group-hover:text-honey-200"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18"
                                                fill="none">
                                                <path
                                                    d="M8.08887 0.989258C8.31973 0.427753 9.07211 0.326095 9.44336 0.806641C9.4865 0.862481 9.52201 0.923989 9.54883 0.989258V0.991211L11.3418 5.33105L11.458 5.61328L11.7637 5.63867L16.4102 6.0127V6.01367C17.0215 6.06538 17.3475 6.75913 16.9971 7.2627C16.9591 7.31722 16.9145 7.36673 16.8643 7.41016L15.5156 8.57422L15.5205 8.57324L13.3232 10.4697L13.0938 10.668L13.1631 10.9629L14.2432 15.5381L14.2441 15.54C14.3864 16.1331 13.8328 16.6577 13.248 16.4844C13.1823 16.4648 13.1191 16.4371 13.0605 16.4014H13.0615L9.08301 13.9531L8.82031 13.792L8.55859 13.9531L4.5791 16.4004C4.05796 16.7169 3.38971 16.3508 3.37598 15.7412C3.37445 15.6735 3.38178 15.6059 3.39746 15.54V15.5391L4.48145 10.9629L4.55176 10.668L4.32129 10.4697L0.776367 7.41016C0.312197 7.00899 0.456622 6.25511 1.03613 6.05371C1.09645 6.03279 1.1591 6.01868 1.22266 6.0127L1.22363 6.01367L5.87305 5.63867L6.17773 5.61328L6.29492 5.33105L8.08789 0.991211L8.08887 0.989258Z"
                                                    class="fill-current stroke-(--icon-stroke) [stroke-width:var(--stroke-width,1)]" />
                                            </svg>
                                            <div
                                                class="relative transition-all duration-300 ease-out will-change-transform group-hover:pr-13">
                                                <div
                                                    class="transition duration-300 ease-out will-change-transform group-hover:-translate-y-1.5 group-hover:opacity-0">
                                                    31.4K+
                                                </div>
                                                <div class="absolute top-1/2 left-0 -translate-y-1/2">
                                                    <div
                                                        class="translate-y-1.5 whitespace-nowrap opacity-0 transition duration-300 ease-out group-hover:translate-y-0 group-hover:opacity-100">
                                                        Star on GitHub
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>


                                    <div x-ref="closeBtn">
                                        <button type="button" x-on:click="showMobileMenu = false"
                                            class="group pointer-events-auto flex h-10 items-center justify-center rounded-md bg-serenade-50 pr-3.5 pl-3 text-stone-800 transition duration-300 ease-out hover:bg-cream-100 focus:outline-none"
                                            aria-label="Close menu">
                                            <svg class="mr-1.25 size-3.5 shrink-0 transition duration-300 ease-out will-change-transform group-hover:rotate-90"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M18 6 6 18" />
                                                <path d="m6 6 12 12" />
                                            </svg>
                                            <span>Close</span>
                                            <span
                                                class="grid grid-cols-[0fr] transition-[grid-template-columns] duration-300 ease-out group-hover:grid-cols-[1fr]">
                                                <span class="overflow-hidden">
                                                    <span
                                                        class="ml-1 opacity-0 transition duration-300 ease-out group-hover:opacity-100">
                                                        menu
                                                    </span>
                                                </span>
                                            </span>
                                        </button>
                                    </div>
                                </div>


                                <div class="pointer-events-none mt-auto flex justify-center pb-6">
                                    <nav x-ref="menuPanel"
                                        class="pointer-events-auto relative z-10 w-full rounded-xl bg-serenade-50"
                                        aria-label="Main navigation" x-on:click.stop>

                                        <div x-ref="dragHandle"
                                            class="-mt-5 flex cursor-grab touch-none flex-col items-center pt-8 pb-8 select-none active:cursor-grabbing"
                                            aria-label="Drag to close menu">
                                            <div class="h-1.25 w-12 rounded-full bg-stone-400/40"></div>
                                        </div>


                                        <ul x-ref="navItems"
                                            class="flex flex-col items-stretch px-5 text-center text-lg">
                                            <li>
                                                <a href="https://filamentphp.com" aria-current="page"
                                                    x-on:click="showMobileMenu = false"
                                                    class="block py-2 transition duration-300 ease-out font-medium text-stone-800">
                                                    <span class="relative inline-flex items-center gap-1.5">
                                                        Home


                                                        <div class="pointer-events-none absolute -right-23.5 bottom-2.25 inline-flex flex-col gap-2"
                                                            data-badge style="opacity: 0; transform: scale(0)">
                                                            <div x-init="() => {
                                                                const tween = gsap.to($el, {
                                                                    keyframes: {
                                                                        y: [0, -5, 0],
                                                                        rotate: [0, -3, 3, 0],
                                                                    },
                                                                    duration: 1,
                                                                    repeat: -1,
                                                                    repeatDelay: 1,
                                                                    delay: 1.5,
                                                                    ease: 'bounce.inOut',
                                                                    paused: true,
                                                                })
                                                            
                                                                motion.inView($el.closest('[data-badge]'), () => {
                                                                    tween.play()
                                                                    return () => tween.pause()
                                                                })
                                                            }">
                                                                <div
                                                                    class="ml-2.5 -rotate-5 rounded-tl-md rounded-tr-md rounded-br-md bg-stone-800 px-2 py-1 text-xs whitespace-nowrap text-stone-100">
                                                                    You're here
                                                                </div>
                                                            </div>
                                                            <div x-init="() => {
                                                                const tween = gsap.to($el, {
                                                                    keyframes: {
                                                                        y: [0, -5, 0],
                                                                    },
                                                                    duration: 1,
                                                                    repeat: -1,
                                                                    repeatDelay: 1,
                                                                    delay: 1.5,
                                                                    ease: 'bounce.inOut',
                                                                    paused: true,
                                                                })
                                                            
                                                                motion.inView($el.closest('[data-badge]'), () => {
                                                                    tween.play()
                                                                    return () => tween.pause()
                                                                })
                                                            }">
                                                                <svg class="size-2 text-honey-200"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 8 8" fill="none">
                                                                    <path d="M4 0L8 4L4 8L0 4L4 0Z"
                                                                        class="fill-current" />
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="https://filamentphp.com/plugins"
                                                    x-on:click="showMobileMenu = false"
                                                    class="block py-2 transition duration-300 ease-out hover:scale-110 hover:font-medium hover:text-stone-800">
                                                    <span class="relative inline-flex items-center gap-1.5">
                                                        Plugins


                                                    </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="https://filamentphp.com/insights"
                                                    x-on:click="showMobileMenu = false"
                                                    class="block py-2 transition duration-300 ease-out hover:scale-110 hover:font-medium hover:text-stone-800">
                                                    <span class="relative inline-flex items-center gap-1.5">
                                                        Insights


                                                    </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="https://filamentphp.com/consulting"
                                                    x-on:click="showMobileMenu = false"
                                                    class="block py-2 transition duration-300 ease-out hover:scale-110 hover:font-medium hover:text-stone-800">
                                                    <span class="relative inline-flex items-center gap-1.5">
                                                        Consulting


                                                    </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="https://filamentphp.com/custom-dashboards-plugin"
                                                    x-on:click="showMobileMenu = false"
                                                    class="block py-2 transition duration-300 ease-out hover:scale-110 hover:font-medium hover:text-stone-800">
                                                    <span class="relative inline-flex items-center gap-1.5">
                                                        Custom Dashboards

                                                        <div class="inline-flex items-center">
                                                            <span
                                                                class="relative inline-block overflow-hidden rounded-xs bg-honey-200 px-1.25 py-px font-roboto-mono text-xs font-medium tracking-wide text-cocoa uppercase"
                                                                x-init="() => {
                                                                    const shine = $refs.shine
                                                                
                                                                    const tween = gsap.fromTo(
                                                                        shine, { x: '-100%', opacity: 1 }, {
                                                                            x: '200%',
                                                                            opacity: 0,
                                                                            duration: 1.2,
                                                                            ease: 'power2.inOut',
                                                                            repeat: -1,
                                                                            repeatDelay: 1,
                                                                            paused: true,
                                                                        },
                                                                    )
                                                                
                                                                    motion.inView($el, () => {
                                                                        tween.play()
                                                                        return () => tween.pause()
                                                                    })
                                                                }">
                                                                New
                                                                <span x-ref="shine"
                                                                    class="pointer-events-none absolute inset-y-0 -left-full w-full skew-x-[-20deg] bg-linear-to-r from-transparent via-white to-transparent"
                                                                    aria-hidden="true"></span>
                                                            </span>
                                                        </div>

                                                    </span>
                                                </a>
                                            </li>
                                        </ul>


                                        <div x-ref="plusDecoration" class="flex items-center gap-5 px-5 pt-3 pb-4">
                                            <div data-plus-line class="h-px w-full bg-bone-100"></div>
                                            <div data-plus-symbol class="text-sm text-bone-500">
                                                +
                                            </div>
                                            <div data-plus-line class="h-px w-full bg-bone-100"></div>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
        </nav>
        <div>
            <section x-data x-init="() => {
                window.__heroAnimations = []
            
                const observer = new IntersectionObserver(
                    ([entry]) => {
                        window.__heroAnimations.forEach((t) => {
                            if (entry.isIntersecting) {
                                t.resume()
                            } else {
                                t.pause()
                            }
                        })
                    }, { threshold: 0 },
                )
            
                observer.observe($el)
            }" data-triangle-decoration="bottom"
                class="border-b border-bone-100 pt-20">
                <div class="relative grid place-items-center">

                    <header class="mt-8 px-2 text-center lg:mt-0">
                        <h1>
                            <span class="font-bold xs:block">
                                Build apps & admin panels
                            </span>
                            <span class="font-medium xs:block xs:pt-0.75">
                                fast, for your
                                <span class="block xs:inline-block">bright ideas.</span>
                            </span>
                        </h1>
                        <p data-hero-description class="mx-auto mt-3 px-1 xs:px-0 md:mt-4" role="note">
                            With a solid Laravel foundation and a polished UI, you can focus
                            on what makes your product unique.
                        </p>
                    </header>


                    <div class="mt-7 mb-9 flex flex-wrap items-center justify-center gap-3 px-2 xs:mt-5 xs:mb-7">

                        <div x-data x-init="async () => {
                            await window.FilamentAnimations.waitForFonts()
                        
                            const button = $el.querySelector('a')
                            const textWrapper = button.querySelector('[data-text]')
                            const expandingBg = $refs.expandingBg
                            const horizonGlow = $refs.horizonGlow
                            const rocketContainer = $refs.rocketContainer
                            const rocket = $refs.rocket
                        
                            // Lock button width to prevent resizing
                            button.style.width = button.offsetWidth + 'px'
                        
                            const split = new SplitText(textWrapper, { type: 'chars' })
                            const chars = split.chars
                        
                            const tl = gsap.timeline({ paused: true })
                        
                            // Expand the background circle to cover the entire button
                            tl.to(
                                expandingBg, {
                                    scale: 7,
                                    duration: 0.4,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            tl.to(
                                horizonGlow, {
                                    opacity: 1,
                                    duration: 0.4,
                                    ease: 'power2.out',
                                },
                                0.04,
                            )
                        
                            // Text moves to the right
                            tl.to(
                                textWrapper, {
                                    x: 31,
                                    duration: 0.35,
                                    ease: 'power2.inOut',
                                },
                                0,
                            )
                        
                            // Rocket container moves to the left
                            tl.to(
                                rocketContainer, {
                                    x: -106,
                                    duration: 0.5,
                                    ease: 'circ.inOut',
                                },
                                0,
                            )
                        
                            // Text changes to white/cream with glow
                            tl.to(
                                chars, {
                                    color: '#eaeaea',
                                    duration: 0.25,
                                    ease: 'power2.out',
                                    stagger: 0.02,
                                },
                                0.05,
                            )
                        
                            motion.hover(button, () => {
                                tl.tweenTo(tl.duration())
                        
                                return () => {
                                    tl.tweenTo(0)
                                }
                            })
                        }" data-button-pulse class="rounded-full bg-honey-200">
                            <a href="/docs" aria-label="Get started with Filament"
                                class="relative flex h-13 w-39.75 items-center justify-start overflow-hidden rounded-full bg-honey-200 pr-12 pl-5 font-medium text-stone-900 transition duration-300 ease-out will-change-transform hover:scale-y-102 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset">

                                <div x-ref="horizonGlow"
                                    class="absolute -top-8 left-0 z-2 size-14 rounded-full bg-honey-50 opacity-0 blur-2xl"
                                    aria-hidden="true"></div>


                                <span x-ref="expandingBg"
                                    class="absolute right-1 z-0 size-11 rounded-full bg-stone-900"
                                    aria-hidden="true"></span>

                                <span class="relative z-2 pr-2 whitespace-nowrap" data-text>
                                    Get started
                                </span>
                                <span x-ref="rocketContainer" class="absolute right-1 z-1">
                                    <span
                                        class="relative isolate grid size-11 place-items-center overflow-hidden rounded-full text-honey-100 [--meteor-color:var(--color-honey-200)] [--rocket-color:var(--color-honey-100)]"
                                        aria-hidden="true">

                                        <div x-init="() => {
                                            const tween = gsap.to($el, {
                                                duration: 1.5,
                                                x: -80,
                                                y: 80,
                                                ease: 'power1.in',
                                                repeat: -1,
                                                repeatDelay: 0.5,
                                            })
                                            window.__heroAnimations?.push(tween)
                                        }" class="absolute -top-9 -right-5 z-0"
                                            aria-hidden="true">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17"
                                                viewBox="0 0 18 17" fill="none">
                                                <path
                                                    d="M17.4801 0L0.610057 15.82C0.610057 15.82 0.280057 16.27 0.700057 16.71C1.11006 17.15 1.65006 16.77 1.65006 16.77L17.4801 0Z"
                                                    class="fill-(--meteor-color)" />
                                            </svg>
                                        </div>

                                        <div x-init="() => {
                                            const tween = gsap.to($el, {
                                                duration: 1.5,
                                                x: -80,
                                                y: 80,
                                                ease: 'power1.in',
                                                repeat: -1,
                                                repeatDelay: 0.5,
                                                delay: 1,
                                            })
                                            window.__heroAnimations?.push(tween)
                                        }" class="absolute -top-7 -right-5 z-0"
                                            aria-hidden="true">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17"
                                                viewBox="0 0 18 17" fill="none" class="scale-75 opacity-50">
                                                <path
                                                    d="M17.4801 0L0.610057 15.82C0.610057 15.82 0.280057 16.27 0.700057 16.71C1.11006 17.15 1.65006 16.77 1.65006 16.77L17.4801 0Z"
                                                    class="fill-(--meteor-color)" />
                                            </svg>
                                        </div>

                                        <div x-init="() => {
                                            const tween = gsap.to($el, {
                                                duration: 1.5,
                                                x: -80,
                                                y: 80,
                                                ease: 'power1.in',
                                                repeat: -1,
                                                repeatDelay: 0.5,
                                            })
                                            window.__heroAnimations?.push(tween)
                                        }" class="absolute top-0 -right-5 z-0"
                                            aria-hidden="true">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17"
                                                viewBox="0 0 18 17" fill="none">
                                                <path
                                                    d="M17.4801 0L0.610057 15.82C0.610057 15.82 0.280057 16.27 0.700057 16.71C1.11006 17.15 1.65006 16.77 1.65006 16.77L17.4801 0Z"
                                                    class="fill-(--meteor-color)" />
                                            </svg>
                                        </div>

                                        <div x-init="() => {
                                            const tween = gsap.to($el, {
                                                duration: 1.5,
                                                x: -80,
                                                y: 80,
                                                ease: 'power1.in',
                                                repeat: -1,
                                                repeatDelay: 0.5,
                                                delay: 1,
                                            })
                                            window.__heroAnimations?.push(tween)
                                        }" class="absolute top-3 -right-5 z-0"
                                            aria-hidden="true">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="17"
                                                viewBox="0 0 18 17" fill="none" class="scale-75 opacity-50">
                                                <path
                                                    d="M17.4801 0L0.610057 15.82C0.610057 15.82 0.280057 16.27 0.700057 16.71C1.11006 17.15 1.65006 16.77 1.65006 16.77L17.4801 0Z"
                                                    class="fill-(--meteor-color)" />
                                            </svg>
                                        </div>

                                        <div x-ref="rocket" aria-hidden="true" class="relative z-1">
                                            <div x-init="() => {
                                                const tween = gsap.to($el, {
                                                    x: 3,
                                                    y: 3,
                                                    rotate: -3,
                                                    duration: 1.5,
                                                    repeat: -1,
                                                    yoyo: true,
                                                    ease: 'sine.inOut',
                                                })
                                                window.__heroAnimations?.push(tween)
                                            }">
                                                <svg class="size-6.25 text-current/30"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 25"
                                                    fill="none">
                                                    <path class="fill-current"
                                                        d="M17.627 11.7676V17.4118C17.6269 17.6058 17.5498 17.7918 17.4127 17.9291L14.2679 21.0739C14.1717 21.17 14.0507 21.2372 13.9183 21.2684C13.786 21.2995 13.6476 21.2932 13.5186 21.2502C13.3897 21.2071 13.2753 21.129 13.1882 21.0247C13.1012 20.9203 13.0448 20.7938 13.0255 20.6592L12.5 16.8945L17.627 11.7676ZM13.2324 7.37305H7.58822C7.39423 7.37314 7.20819 7.45018 7.07095 7.58728L3.92611 10.7321C3.83009 10.8283 3.76275 10.9494 3.73163 11.0818C3.70049 11.2141 3.70681 11.3524 3.74984 11.4814C3.79289 11.6103 3.87097 11.7247 3.97535 11.8118C4.07973 11.899 4.20628 11.9553 4.34084 11.9745L8.10549 12.5L13.2324 7.37305ZM4.44338 20.5566C7.89034 20.5566 9.08419 18.754 9.4385 17.9767L7.02334 15.5615C6.24606 15.9158 4.44338 17.1097 4.44338 20.5566Z" />
                                                    <path
                                                        d="M21.2754 5.09522C21.2537 4.73811 21.1021 4.40127 20.849 4.14828C20.5961 3.89529 20.2593 3.74364 19.9021 3.72193C18.7504 3.65327 15.807 3.75856 13.3643 6.20027L12.9295 6.64064H7.58918C7.39608 6.63955 7.20469 6.67686 7.02614 6.75042C6.84759 6.82398 6.68545 6.9323 6.54914 7.0691L3.40888 10.2112C3.2163 10.4036 3.08117 10.646 3.01864 10.9109C2.95612 11.176 2.96868 11.4531 3.05492 11.7114C3.14116 11.9695 3.29766 12.1987 3.50686 12.3729C3.71607 12.5472 3.96969 12.6597 4.23927 12.6978L7.7613 13.1894L11.8088 17.2369L12.3005 20.7608C12.3383 21.0304 12.4507 21.284 12.6251 21.493C12.7995 21.7021 13.029 21.8582 13.2874 21.9437C13.4379 21.9939 13.5956 22.0197 13.7543 22.0197C13.9465 22.02 14.1368 21.9824 14.3145 21.9088C14.492 21.8353 14.6532 21.7273 14.7889 21.5912L17.931 18.4509C18.0678 18.3146 18.1761 18.1525 18.2497 17.9739C18.3232 17.7954 18.3605 17.604 18.3594 17.4109V12.0706L18.7962 11.6339C21.2388 9.19129 21.3441 6.24787 21.2754 5.09522ZM7.58918 8.10548H11.4646L7.84553 11.7236L4.44343 11.2494L7.58918 8.10548ZM14.4016 7.2403C15.1054 6.53218 15.9522 5.98238 16.8854 5.62762C17.8186 5.27286 18.8168 5.12133 19.8133 5.18312C19.8775 6.18011 19.7275 7.17929 19.3735 8.1135C19.0194 9.04772 18.4695 9.89533 17.7607 10.5994L12.5001 15.8582L9.14192 12.5L14.4016 7.2403ZM16.8946 17.4109L13.7516 20.5566L13.2764 17.1536L16.8946 13.5355V17.4109ZM10.1051 18.2806C9.69306 19.1833 8.31519 21.2891 4.44343 21.2891C4.24918 21.2891 4.06289 21.2119 3.92553 21.0746C3.78818 20.9372 3.71101 20.7509 3.71101 20.5566C3.71101 16.6849 5.81672 15.307 6.71943 14.8941C6.80696 14.8542 6.90149 14.8319 6.99763 14.8286C7.09377 14.8252 7.18964 14.8407 7.27975 14.8744C7.36987 14.908 7.45247 14.9591 7.52284 15.0247C7.59321 15.0903 7.64997 15.1691 7.68989 15.2567C7.72981 15.3442 7.75209 15.4388 7.75548 15.5349C7.75886 15.631 7.74327 15.7269 7.70961 15.817C7.67594 15.9071 7.62486 15.9897 7.55926 16.06C7.49367 16.1304 7.41487 16.1872 7.32734 16.2271C6.73866 16.4954 5.43952 17.3587 5.21064 19.7894C7.64137 19.5605 8.50654 18.2614 8.77296 17.6727C8.81287 17.5852 8.86964 17.5064 8.94001 17.4408C9.01039 17.3752 9.09299 17.3241 9.1831 17.2905C9.27322 17.2568 9.36909 17.2412 9.46523 17.2446C9.56136 17.248 9.65589 17.2703 9.74342 17.3102C9.83095 17.3501 9.90975 17.4069 9.97532 17.4773C10.041 17.5476 10.0921 17.6302 10.1256 17.7203C10.1593 17.8104 10.1749 17.9063 10.1715 18.0024C10.1681 18.0986 10.145 18.1931 10.1051 18.2806Z"
                                                        class="fill-(--rocket-color)" />
                                                </svg>
                                            </div>
                                        </div>
                                    </span>
                                </span>
                            </a>
                        </div>


                        <div x-data x-init="async () => {
                            await window.FilamentAnimations.waitForFonts()
                        
                            const button = $el.querySelector('a')
                            const textWrapper = button.querySelector('[data-text]')
                            const arrow = button.querySelector('[data-arrow]')
                            const discordIcon = button.querySelector('[data-discord-icon]')
                        
                            // Lock button width to prevent resizing
                            button.style.width = button.offsetWidth + 'px'
                        
                            const split = new SplitText(textWrapper, { type: 'chars' })
                            const chars = split.chars
                        
                            const tl = gsap.timeline({ paused: true })
                        
                            // Arrow exits to the right
                            tl.to(
                                arrow, {
                                    x: 50,
                                    opacity: 0,
                                    duration: 0.2,
                                    ease: 'circ.in',
                                },
                                0,
                            )
                        
                            // Discord icon comes in from left
                            tl.fromTo(
                                discordIcon, {
                                    x: -30,
                                    opacity: 0,
                                }, {
                                    x: -6,
                                    opacity: 1,
                                    duration: 0.2,
                                    ease: 'circ.out',
                                },
                                0.15,
                            )
                        
                            // Text gets pushed to the right as discord icon comes in
                            tl.to(
                                textWrapper, {
                                    x: 26,
                                    duration: 0.2,
                                    ease: 'sine.out',
                                },
                                0.1,
                            )
                        
                            // Characters shine with stagger
                            tl.to(
                                chars, {
                                    keyframes: {
                                        opacity: [1, 0.4, 1],
                                    },
                                    duration: 0.15,
                                    ease: 'sine.inOut',
                                    stagger: 0.02,
                                },
                                0.1,
                            )
                        
                            motion.hover(button, () => {
                                tl.tweenTo(tl.duration())
                        
                                return () => {
                                    tl.tweenTo(0)
                                }
                            })
                        }" data-button-pulse class="rounded-full bg-bubblegum">
                            <a href="https://filamentphp.com/discord" aria-label="Join Filament Discord community"
                                class="relative flex h-13 w-39.75 items-center justify-center gap-2 overflow-hidden rounded-full bg-bubblegum px-5 font-medium text-stone-900 transition duration-300 ease-out will-change-transform hover:scale-y-102 hover:bg-bubblegum/80 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset">
                                <svg data-discord-icon="data-discord-icon"
                                    class="absolute left-5 h-4.5 shrink-0 opacity-0"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 151 107" fill="none">
                                    <path class="stroke-current [stroke-width:var(--stroke-width,8)]"
                                        d="M60.0637 21.5798V13H36.5301L18 77.6812L60.0637 93L65.9349 76.3188" />
                                    <path class="stroke-current [stroke-width:var(--stroke-width,8)]"
                                        d="M89.9877 21.5798V13H113.521L132.043 77.6812L89.9877 93L84.1084 76.3188" />
                                    <path class="stroke-current [stroke-width:var(--stroke-width,8)]"
                                        d="M100.157 73.2778C94.3831 75.8404 85.3978 77.4866 75.3096 77.4866H75.3259C65.2377 77.4866 56.2606 75.8404 50.4785 73.2778" />
                                    <path class="stroke-current [stroke-width:var(--stroke-width,8)]"
                                        d="M50.4863 24.7345C56.2603 22.1719 65.2455 20.5256 75.3337 20.5256H75.3175C85.4056 20.5256 94.3828 22.1719 100.165 24.7345" />
                                    <path class="fill-current"
                                        d="M58.5061 60.8784C61.3814 60.8784 63.7123 58.5475 63.7123 55.6721C63.7123 52.7968 61.3814 50.4658 58.5061 50.4658C55.6307 50.4658 53.2998 52.7968 53.2998 55.6721C53.2998 58.5475 55.6307 60.8784 58.5061 60.8784Z" />
                                    <path class="fill-current"
                                        d="M92.3645 60.8784C95.2398 60.8784 97.5707 58.5475 97.5707 55.6721C97.5707 52.7968 95.2398 50.4658 92.3645 50.4658C89.4891 50.4658 87.1582 52.7968 87.1582 55.6721C87.1582 58.5475 89.4891 60.8784 92.3645 60.8784Z" />
                                </svg>
                                <span class="whitespace-nowrap" data-text>
                                    Join Discord
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg" data-arrow="data-arrow"
                                    class="h-3.25 shrink-0" aria-hidden="true" viewBox="0 0 28 22" fill="none">
                                    <path class="fill-current"
                                        d="M1 10H5.96046e-08V12H1V10ZM27 12C27.5523 12 28 11.5523 28 11C28 10.4477 27.5523 10 27 10V12ZM18 1V5.96046e-08H16V1H18ZM26.4207 11.7774C26.9055 12.0419 27.5129 11.8632 27.7774 11.3783C28.0419 10.8935 27.8632 10.286 27.3783 10.0216L26.4207 11.7774ZM15.9999 20.8995V21.8995H17.9999V20.8995H15.9999ZM1 12H26.8994V10H1V12ZM26.8994 12H27V10H26.8994V12ZM16 1C16 2.47241 16.7953 3.87873 17.7716 5.0769C18.7678 6.29956 20.0716 7.44977 21.3383 8.42854C22.6109 9.41186 23.8784 10.2469 24.825 10.835C25.2993 11.1295 25.6952 11.3635 25.9738 11.5245C26.1131 11.605 26.2233 11.6674 26.2993 11.71C26.3374 11.7314 26.3669 11.7478 26.3873 11.7591C26.3975 11.7647 26.4055 11.7691 26.411 11.7721C26.4138 11.7737 26.416 11.7749 26.4176 11.7758C26.4184 11.7762 26.4191 11.7765 26.4196 11.7768C26.4199 11.777 26.4201 11.7771 26.4202 11.7772C26.4205 11.7773 26.4207 11.7774 26.8995 10.8995C27.3783 10.0216 27.3784 10.0217 27.3785 10.0217C27.3785 10.0217 27.3785 10.0217 27.3785 10.0217C27.3784 10.0216 27.3781 10.0215 27.3777 10.0213C27.3769 10.0208 27.3756 10.0201 27.3736 10.019C27.3697 10.0168 27.3634 10.0134 27.3549 10.0087C27.3378 9.99926 27.3118 9.98479 27.2773 9.96547C27.2084 9.92682 27.1058 9.86878 26.9745 9.79288C26.7117 9.64102 26.3342 9.41799 25.8804 9.13606C24.9708 8.57104 23.7635 7.77501 22.5612 6.84596C21.353 5.91235 20.182 4.86894 19.322 3.81356C18.4422 2.73371 18 1.77759 18 1H16ZM26.8994 11C26.5248 10.0728 26.5245 10.0729 26.5242 10.0731C26.524 10.0731 26.5237 10.0733 26.5234 10.0734C26.5228 10.0736 26.522 10.0739 26.5211 10.0743C26.5193 10.0751 26.5169 10.076 26.5138 10.0773C26.5078 10.0797 26.4994 10.0832 26.4888 10.0876C26.4674 10.0964 26.4369 10.1091 26.3979 10.1257C26.3199 10.1587 26.2077 10.2071 26.0662 10.2703C25.7834 10.3967 25.3826 10.5825 24.903 10.824C23.9463 11.3055 22.6639 12.0142 21.3751 12.919C20.0914 13.8201 18.7665 14.94 17.7546 16.2535C16.7415 17.5685 15.9999 19.1342 15.9999 20.8995H17.9999C17.9999 19.715 18.4958 18.5685 19.3389 17.4742C20.1831 16.3784 21.333 15.3922 22.5242 14.5559C23.7103 13.7232 24.9028 13.0632 25.8022 12.6104C26.2507 12.3846 26.6233 12.2119 26.8818 12.0965C27.011 12.0388 27.1115 11.9955 27.1785 11.967C27.212 11.9528 27.2371 11.9424 27.2533 11.9357C27.2613 11.9324 27.2671 11.93 27.2706 11.9286C27.2724 11.9279 27.2735 11.9274 27.2741 11.9271C27.2744 11.927 27.2745 11.927 27.2745 11.927C27.2745 11.927 27.2744 11.927 27.2744 11.927C27.2742 11.9271 27.274 11.9272 26.8994 11Z" />
                                </svg>
                            </a>
                        </div>
                    </div>


                    <div class="absolute -top-9.5 left-0 transition-all duration-300 ease-out lg:top-0">
                        <div>
                            <a href="/content/danharrin-filament-v5-blueprint"
                                aria-label="View Filament v5 release page" data-corner-cut="lg"
                                class="group flex items-center gap-2 overflow-hidden bg-stone-800 py-2.75 pr-3.75 pl-3 text-sm whitespace-nowrap text-stone-100 transition-all duration-300 ease-out hover:pr-9.75 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset">
                                <div class="grid" aria-hidden="true">
                                    <svg class="relative z-1 size-2 self-center justify-self-center text-bubblegum transition duration-300 ease-out will-change-transform [grid-area:1/-1] group-hover:rotate-90 group-hover:text-powder-200"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 8" fill="none">
                                        <path d="M4 0L8 4L4 8L0 4L4 0Z" class="fill-current" />
                                    </svg>
                                    <svg class="relative z-0 size-2 scale-140 animate-ping self-center justify-self-center text-bubblegum opacity-60 transition duration-300 ease-out will-change-transform [grid-area:1/-1] group-hover:rotate-90 group-hover:text-powder-200"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 8" fill="none">
                                        <path d="M4 0L8 4L4 8L0 4L4 0Z" class="fill-current" />
                                    </svg>
                                </div>
                                <span class="relative">
                                    <span
                                        class="flex items-center gap-1.5 transition duration-300 ease-out group-hover:-translate-x-3 group-hover:translate-y-3 group-hover:opacity-0"
                                        aria-hidden="true">
                                        <span>New version</span>
                                        <svg class="-mx-1 h-3.5 animate-pulse" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 16 16" fill="none">
                                            <path class="stroke-current"
                                                d="M8.6 5.29362L10.3467 7.04027C10.86 7.5536 10.86 8.39361 10.3467 8.90694L6 13.2469"
                                                stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path class="stroke-current" d="M6 2.69336L6.69333 3.38669"
                                                stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <span class="font-roboto-mono tracking-tighter">
                                            v5
                                        </span>
                                    </span>
                                    <span class="absolute top-1/2 left-0 -translate-y-1/2" aria-hidden="true">
                                        <span
                                            class="flex translate-x-3 -translate-y-3 items-center gap-1.5 opacity-0 transition duration-300 ease-out group-hover:translate-x-0 group-hover:translate-y-0 group-hover:opacity-100">
                                            <span>View release page</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.25 -rotate-45"
                                                viewBox="0 0 28 22" fill="none">
                                                <path class="fill-current"
                                                    d="M1 10H5.96046e-08V12H1V10ZM27 12C27.5523 12 28 11.5523 28 11C28 10.4477 27.5523 10 27 10V12ZM18 1V5.96046e-08H16V1H18ZM26.4207 11.7774C26.9055 12.0419 27.5129 11.8632 27.7774 11.3783C28.0419 10.8935 27.8632 10.286 27.3783 10.0216L26.4207 11.7774ZM15.9999 20.8995V21.8995H17.9999V20.8995H15.9999ZM1 12H26.8994V10H1V12ZM26.8994 12H27V10H26.8994V12ZM16 1C16 2.47241 16.7953 3.87873 17.7716 5.0769C18.7678 6.29956 20.0716 7.44977 21.3383 8.42854C22.6109 9.41186 23.8784 10.2469 24.825 10.835C25.2993 11.1295 25.6952 11.3635 25.9738 11.5245C26.1131 11.605 26.2233 11.6674 26.2993 11.71C26.3374 11.7314 26.3669 11.7478 26.3873 11.7591C26.3975 11.7647 26.4055 11.7691 26.411 11.7721C26.4138 11.7737 26.416 11.7749 26.4176 11.7758C26.4184 11.7762 26.4191 11.7765 26.4196 11.7768C26.4199 11.777 26.4201 11.7771 26.4202 11.7772C26.4205 11.7773 26.4207 11.7774 26.8995 10.8995C27.3783 10.0216 27.3784 10.0217 27.3785 10.0217C27.3785 10.0217 27.3785 10.0217 27.3785 10.0217C27.3784 10.0216 27.3781 10.0215 27.3777 10.0213C27.3769 10.0208 27.3756 10.0201 27.3736 10.019C27.3697 10.0168 27.3634 10.0134 27.3549 10.0087C27.3378 9.99926 27.3118 9.98479 27.2773 9.96547C27.2084 9.92682 27.1058 9.86878 26.9745 9.79288C26.7117 9.64102 26.3342 9.41799 25.8804 9.13606C24.9708 8.57104 23.7635 7.77501 22.5612 6.84596C21.353 5.91235 20.182 4.86894 19.322 3.81356C18.4422 2.73371 18 1.77759 18 1H16ZM26.8994 11C26.5248 10.0728 26.5245 10.0729 26.5242 10.0731C26.524 10.0731 26.5237 10.0733 26.5234 10.0734C26.5228 10.0736 26.522 10.0739 26.5211 10.0743C26.5193 10.0751 26.5169 10.076 26.5138 10.0773C26.5078 10.0797 26.4994 10.0832 26.4888 10.0876C26.4674 10.0964 26.4369 10.1091 26.3979 10.1257C26.3199 10.1587 26.2077 10.2071 26.0662 10.2703C25.7834 10.3967 25.3826 10.5825 24.903 10.824C23.9463 11.3055 22.6639 12.0142 21.3751 12.919C20.0914 13.8201 18.7665 14.94 17.7546 16.2535C16.7415 17.5685 15.9999 19.1342 15.9999 20.8995H17.9999C17.9999 19.715 18.4958 18.5685 19.3389 17.4742C20.1831 16.3784 21.333 15.3922 22.5242 14.5559C23.7103 13.7232 24.9028 13.0632 25.8022 12.6104C26.2507 12.3846 26.6233 12.2119 26.8818 12.0965C27.011 12.0388 27.1115 11.9955 27.1785 11.967C27.212 11.9528 27.2371 11.9424 27.2533 11.9357C27.2613 11.9324 27.2671 11.93 27.2706 11.9286C27.2724 11.9279 27.2735 11.9274 27.2741 11.9271C27.2744 11.927 27.2745 11.927 27.2745 11.927C27.2745 11.927 27.2744 11.927 27.2744 11.927C27.2742 11.9271 27.274 11.9272 26.8994 11Z" />
                                            </svg>
                                        </span>
                                    </span>
                                </span>
                            </a>
                        </div>
                    </div>


                    <div
                        class="transition-all duration-300 ease-out md:absolute md:top-1/2 md:right-0 md:-translate-y-1/2">
                        <div class="md:-translate-y-10">
                            <nav class="inline-flex divide-x divide-bone-100 border-bone-100 md:w-10 md:flex-col md:divide-x-0 md:divide-y rounded-tl-md rounded-tr-md rounded-br-md rounded-bl-md border-y border-r border-l md:rounded-tr-none md:rounded-br-none md:border-r-0"
                                aria-label="Social media links">
                                <a href="https://x.com/filamentphp" target="_blank"
                                    rel="external noopener noreferrer" aria-label="X (Twitter) (opens in a new tab)"
                                    class="group relative inline-grid place-items-center transition duration-300 ease-out focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset size-10 hover:bg-bone-100/30">
                                    <svg class="transition duration-300 will-change-transform group-hover:scale-95 h-4.5"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18" fill="none">
                                        <path
                                            d="M16.9685 16.6804L11.2208 7.64748L16.8923 1.40851C17.2675 0.985507 17.0441 0.31493 16.4902 0.201466C16.2393 0.150075 15.9797 0.233093 15.8052 0.420553L10.4027 6.36295L6.68501 0.520636C6.55027 0.308566 6.31649 0.18007 6.06525 0.179993H1.65802C1.09258 0.179719 0.738876 0.791655 1.02136 1.28149C1.02678 1.2909 1.03242 1.30018 1.03826 1.30935L6.786 10.3414L1.11447 16.5849C0.729173 16.9988 0.936384 17.6746 1.48744 17.8013C1.74935 17.8615 2.02324 17.7739 2.20158 17.5729L7.6041 11.6305L11.3218 17.4728C11.4576 17.6831 11.6912 17.8098 11.9415 17.8089H16.3488C16.9142 17.8087 17.2674 17.1965 16.9845 16.7069C16.9794 16.6979 16.974 16.6891 16.9685 16.6804ZM12.3446 16.3398L2.9958 1.64907H5.65849L15.011 16.3398H12.3446Z"
                                            class="fill-current" />
                                    </svg>


                                    <div
                                        class="pointer-events-none absolute inset-y-0 hidden items-center gap-3 md:flex right-[calc(100%+theme(spacing.3))]">
                                        <div
                                            class="font-roboto-mono text-sm whitespace-nowrap text-stone-500 opacity-0 transition delay-20 duration-300 will-change-transform group-hover:translate-x-0 group-hover:opacity-100 translate-x-1">
                                            X (Twitter)
                                        </div>
                                        <div
                                            class="h-px w-10 scale-x-0 bg-bone-300/80 transition duration-300 will-change-transform group-hover:scale-x-100 origin-right">
                                        </div>
                                    </div>
                                </a>
                                <a href="/discord" target="_blank" rel="external noopener noreferrer"
                                    aria-label="Discord (opens in a new tab)"
                                    class="group relative inline-grid place-items-center transition duration-300 ease-out focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset size-10 hover:bg-bone-100/30">
                                    <svg class="transition duration-300 will-change-transform group-hover:scale-95 h-4.5"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 151 107" fill="none">
                                        <path class="stroke-current [stroke-width:var(--stroke-width,8)]"
                                            d="M60.0637 21.5798V13H36.5301L18 77.6812L60.0637 93L65.9349 76.3188" />
                                        <path class="stroke-current [stroke-width:var(--stroke-width,8)]"
                                            d="M89.9877 21.5798V13H113.521L132.043 77.6812L89.9877 93L84.1084 76.3188" />
                                        <path class="stroke-current [stroke-width:var(--stroke-width,8)]"
                                            d="M100.157 73.2778C94.3831 75.8404 85.3978 77.4866 75.3096 77.4866H75.3259C65.2377 77.4866 56.2606 75.8404 50.4785 73.2778" />
                                        <path class="stroke-current [stroke-width:var(--stroke-width,8)]"
                                            d="M50.4863 24.7345C56.2603 22.1719 65.2455 20.5256 75.3337 20.5256H75.3175C85.4056 20.5256 94.3828 22.1719 100.165 24.7345" />
                                        <path class="fill-current"
                                            d="M58.5061 60.8784C61.3814 60.8784 63.7123 58.5475 63.7123 55.6721C63.7123 52.7968 61.3814 50.4658 58.5061 50.4658C55.6307 50.4658 53.2998 52.7968 53.2998 55.6721C53.2998 58.5475 55.6307 60.8784 58.5061 60.8784Z" />
                                        <path class="fill-current"
                                            d="M92.3645 60.8784C95.2398 60.8784 97.5707 58.5475 97.5707 55.6721C97.5707 52.7968 95.2398 50.4658 92.3645 50.4658C89.4891 50.4658 87.1582 52.7968 87.1582 55.6721C87.1582 58.5475 89.4891 60.8784 92.3645 60.8784Z" />
                                    </svg>


                                    <div
                                        class="pointer-events-none absolute inset-y-0 hidden items-center gap-3 md:flex right-[calc(100%+theme(spacing.3))]">
                                        <div
                                            class="font-roboto-mono text-sm whitespace-nowrap text-stone-500 opacity-0 transition delay-20 duration-300 will-change-transform group-hover:translate-x-0 group-hover:opacity-100 translate-x-1">
                                            Discord
                                        </div>
                                        <div
                                            class="h-px w-10 scale-x-0 bg-bone-300/80 transition duration-300 will-change-transform group-hover:scale-x-100 origin-right">
                                        </div>
                                    </div>
                                </a>
                                <a href="https://github.com/filamentphp/filament" target="_blank"
                                    rel="external noopener noreferrer" aria-label="GitHub (opens in a new tab)"
                                    class="group relative inline-grid place-items-center transition duration-300 ease-out focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset size-10 hover:bg-bone-100/30">
                                    <svg class="transition duration-300 will-change-transform group-hover:scale-95 h-4.5"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 127 133" overflow="visible"
                                        fill="none">
                                        <path class="stroke-current [stroke-width:var(--stroke-width,10)]"
                                            d="M0.480469 71.73C0.480469 71.73 13.9205 76.31 18.0405 91.9C22.1605 107.49 27.5705 110.18 31.8505 112.36C34.6505 113.79 47.5905 117.46 57.7505 113.78" />
                                        <path class="stroke-current [stroke-width:var(--stroke-width,10)]"
                                            d="M103.18 132.95V106.13C103.18 93.54 92.9796 83.34 80.3896 83.34C67.7996 83.34 57.5996 93.54 57.5996 106.13V132.95" />
                                        <path class="stroke-current [stroke-width:var(--stroke-width,10)]"
                                            d="M64.75 22.65C68.38 21.04 74.02 20 80.36 20H80.35" />
                                        <path class="stroke-current [stroke-width:var(--stroke-width,10)]"
                                            d="M45.4302 30.98C45.4302 30.98 35.4802 34.08 35.4902 51.46V57.25C35.4902 71.66 47.1702 83.34 61.5802 83.34H80.3902" />
                                        <path class="stroke-current [stroke-width:var(--stroke-width,10)]"
                                            d="M40.0302 35.23C40.0302 35.23 29.4502 17.64 44.1802 1.57999C44.1802 1.57999 70.2802 4.67999 72.5502 21.33" />
                                        <path class="stroke-current [stroke-width:var(--stroke-width,10)]"
                                            d="M95.6295 22.65C91.9995 21.04 86.3595 20 80.0195 20H80.0295" />
                                        <path class="stroke-current [stroke-width:var(--stroke-width,10)]"
                                            d="M114.95 30.98C114.95 30.98 124.9 34.08 124.89 51.46V57.25C124.89 71.66 113.21 83.34 98.8002 83.34H79.9902" />
                                        <path class="stroke-current [stroke-width:var(--stroke-width,10)]"
                                            d="M120.35 35.23C120.35 35.23 130.93 17.64 116.2 1.57999C116.2 1.57999 90.1001 4.67999 87.8301 21.33" />
                                    </svg>


                                    <div
                                        class="pointer-events-none absolute inset-y-0 hidden items-center gap-3 md:flex right-[calc(100%+theme(spacing.3))]">
                                        <div
                                            class="font-roboto-mono text-sm whitespace-nowrap text-stone-500 opacity-0 transition delay-20 duration-300 will-change-transform group-hover:translate-x-0 group-hover:opacity-100 translate-x-1">
                                            GitHub
                                        </div>
                                        <div
                                            class="h-px w-10 scale-x-0 bg-bone-300/80 transition duration-300 will-change-transform group-hover:scale-x-100 origin-right">
                                        </div>
                                    </div>
                                </a>
                                <a href="https://phpc.social/@filament" target="_blank"
                                    rel="external noopener noreferrer" aria-label="Mastodon (opens in a new tab)"
                                    class="group relative inline-grid place-items-center transition duration-300 ease-out focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset size-10 hover:bg-bone-100/30">
                                    <svg class="transition duration-300 will-change-transform group-hover:scale-95 h-4.5"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18" fill="none">
                                        <path
                                            d="M13.9396 0.179993H4.0612C2.11275 0.179993 0.533203 1.75953 0.533203 3.70799V14.292C0.533203 16.2404 2.11275 17.82 4.0612 17.82H11.8228C12.366 17.82 12.7055 17.232 12.4339 16.7616C12.3078 16.5433 12.0749 16.4088 11.8228 16.4088H4.0612C2.89217 16.4087 1.9444 15.461 1.9444 14.292V13.5864H13.9396C15.888 13.5863 17.4676 12.0068 17.4676 10.0584V3.70799C17.4676 1.75953 15.8881 0.179993 13.9396 0.179993ZM16.0564 10.0584C16.0564 11.2275 15.1087 12.1752 13.9396 12.1752H1.9444V3.70799C1.9444 2.53891 2.89212 1.59119 4.0612 1.59119H13.9396C15.1087 1.59119 16.0564 2.53891 16.0564 3.70799V10.0584ZM13.9396 6.53039V9.35279C13.9396 9.89596 13.3516 10.2354 12.8812 9.96386C12.6629 9.83782 12.5284 9.60488 12.5284 9.35279V6.53039C12.5284 5.44405 11.3524 4.76509 10.4116 5.30826C9.97498 5.56035 9.706 6.02622 9.706 6.53039V9.35279C9.706 9.89596 9.118 10.2354 8.6476 9.96386C8.42929 9.83782 8.2948 9.60488 8.2948 9.35279V6.53039C8.2948 5.44405 7.1188 4.76509 6.178 5.30826C5.74138 5.56035 5.4724 6.02622 5.4724 6.53039V9.35279C5.4724 9.89596 4.8844 10.2354 4.414 9.96386C4.19569 9.83782 4.0612 9.60488 4.0612 9.35279V6.53039C4.06365 4.35771 6.41717 3.00243 8.29755 4.09089C8.56139 4.24361 8.79875 4.43808 9.0004 4.66672C10.4375 3.03721 13.0997 3.57446 13.7923 5.63378C13.8895 5.92274 13.9393 6.22553 13.9396 6.53039Z"
                                            class="fill-current" />
                                    </svg>


                                    <div
                                        class="pointer-events-none absolute inset-y-0 hidden items-center gap-3 md:flex right-[calc(100%+theme(spacing.3))]">
                                        <div
                                            class="font-roboto-mono text-sm whitespace-nowrap text-stone-500 opacity-0 transition delay-20 duration-300 will-change-transform group-hover:translate-x-0 group-hover:opacity-100 translate-x-1">
                                            Mastodon
                                        </div>
                                        <div
                                            class="h-px w-10 scale-x-0 bg-bone-300/80 transition duration-300 will-change-transform group-hover:scale-x-100 origin-right">
                                        </div>
                                    </div>
                                </a>
                            </nav>
                        </div>
                    </div>


                    <div x-data x-init="() => {
                        const heroImage = $refs.heroImage
                        const lightBulbContainer = $refs.lightBulbContainer
                        const glow = $refs.glow
                    
                        // Set initial glow state (dim)
                        gsap.set(glow, {
                            scale: 0.8,
                            opacity: 0.3,
                        })
                    
                        // Cache rects and update on scroll/resize to avoid
                        // forcing layout recalculation on every mouse move.
                        let heroRect = heroImage.getBoundingClientRect()
                        let bulbRect = lightBulbContainer.getBoundingClientRect()
                        let maxDistance = Math.sqrt(
                            Math.pow(heroRect.width, 2) + Math.pow(heroRect.height, 2),
                        )
                    
                        const updateRects = () => {
                            heroRect = heroImage.getBoundingClientRect()
                            bulbRect = lightBulbContainer.getBoundingClientRect()
                            maxDistance = Math.sqrt(
                                Math.pow(heroRect.width, 2) + Math.pow(heroRect.height, 2),
                            )
                        }
                    
                        window.addEventListener('scroll', updateRects, { passive: true })
                        window.addEventListener('resize', updateRects, { passive: true })
                    
                        // Track mouse position relative to the light bulb
                        Observer.create({
                            target: heroImage,
                            type: 'pointer',
                            onMove: (self) => {
                                // Get mouse position relative to viewport
                                const mouseX = self.event.clientX
                                const mouseY = self.event.clientY
                    
                                // Get light bulb center position
                                const bulbCenterX = bulbRect.left + bulbRect.width / 2
                                const bulbCenterY = bulbRect.top + bulbRect.height / 2
                    
                                // Calculate distance from mouse to light bulb center
                                const distance = Math.sqrt(
                                    Math.pow(mouseX - bulbCenterX, 2) +
                                    Math.pow(mouseY - bulbCenterY, 2),
                                )
                    
                                // Normalize distance (0 = at bulb, 1 = far away)
                                const normalizedDistance = Math.min(
                                    distance / (maxDistance * 0.5),
                                    1,
                                )
                    
                                // Invert so closer = higher value (1 = at bulb, 0 = far)
                                const proximity = 1 - normalizedDistance
                    
                                // Map proximity to glow values
                                // Scale: 0.8 (min) to 1.3 (max), Opacity: 0.3 (min) to 0.7 (max)
                                const scale = 0.8 + proximity * 0.5
                                const opacity = 0.3 + proximity * 0.5
                    
                                gsap.to(glow, {
                                    scale: scale,
                                    opacity: opacity,
                                    duration: 0.3,
                                    ease: 'power2.out',
                                })
                            },
                            onLeave: () => {
                                // Reset glow when mouse leaves hero image
                                gsap.to(glow, {
                                    scale: 0.8,
                                    opacity: 0.3,
                                    duration: 0.5,
                                    ease: 'power2.out',
                                })
                            },
                        })
                    }" class="mt-12 mb-10 px-2 xs:mt-10 md:mt-20">
                        <div class="grid">

                            <div x-ref="lightBulbContainer"
                                class="relative top-3 right-[6dvw] z-1 grid self-center justify-self-center [grid-area:1/-1] sm:right-[5dvw] md:right-8"
                                aria-hidden="true">
                                <img src="https://filamentphp.com/build/assets/light-bulb-CaWrwv1p.webp"
                                    alt="Filament light bulb icon" width="107" height="172"
                                    fetchpriority="high"
                                    class="relative z-0 h-[10dvw] w-auto self-center justify-self-center [grid-area:1/-1] md:h-17" />


                                <div x-cloak x-ref="glow"
                                    class="relative -top-3 z-1 size-7 self-center justify-self-center rounded-full bg-honey-200 mix-blend-plus-lighter blur-md [grid-area:1/-1] md:size-10 pointer-coarse:hidden">
                                </div>
                            </div>


                            <img x-ref="heroImage"
                                src="https://filamentphp.com/build/assets/filament-factory-BX0SdGVY.webp"
                                width="560" height="417" fetchpriority="high"
                                alt="Filament admin panel interface showcasing form, table, and dashboard components"
                                class="relative z-0 mr-5 w-140 self-center justify-self-center [grid-area:1/-1]" />
                        </div>
                    </div>
                </div>



                <div x-data x-init="async () => {
                    let registeredLoop = null
                
                    const registerLoop = (newLoop) => {
                        const arr = window.__heroAnimations
                        if (!arr) return
                        if (registeredLoop) {
                            const idx = arr.indexOf(registeredLoop)
                            if (idx !== -1) arr.splice(idx, 1)
                        }
                        arr.push(newLoop)
                        registeredLoop = newLoop
                    }
                
                    const init = () => {
                        const items = gsap.utils.toArray($el.querySelectorAll('li'))
                
                        // Reset any previous transforms before rebuilding.
                        gsap.set(items, { x: 0, xPercent: 0 })
                
                        const loop = window.FilamentAnimations.horizontalLoop(items, {
                            repeat: -1,
                            speed: 0.3,
                        })
                        loop.play()
                
                        return loop
                    }
                
                    // Start immediately with fallback metrics to avoid feeling late.
                    let loop = init()
                    registerLoop(loop)
                
                    // Wait for our actual font families to be available.
                    if (window.FilamentFonts?.ready) {
                        await window.FilamentFonts.ready
                    }
                
                    // Let layout settle after potential font swap.
                    await new Promise((resolve) => requestAnimationFrame(resolve))
                
                    if (loop) {
                        loop.kill()
                    }
                    loop = init()
                    registerLoop(loop)
                
                    // If late font swaps or other layout shifts happen, rebuild.
                    // Debounced to avoid rebuilding the loop on every resize frame.
                    let resizeTimer = null
                    const ro = new ResizeObserver(() => {
                        if (resizeTimer) cancelAnimationFrame(resizeTimer)
                        resizeTimer = requestAnimationFrame(() => {
                            if (loop) {
                                loop.kill()
                            }
                            loop = init()
                            registerLoop(loop)
                        })
                    })
                
                    ro.observe($el)
                }" aria-hidden="true"
                    class="mt-10 overflow-hidden border-t border-bone-100 mask-[linear-gradient(to_right,transparent,black_10%,black_90%,transparent)]">
                    <ul class="flex text-center text-sm">

                        <li class="border-r border-bone-100 px-3.5 py-2.5 whitespace-nowrap will-change-transform">
                            Admin Panel
                        </li>
                        <li class="border-r border-bone-100 px-3.5 py-2.5 whitespace-nowrap will-change-transform">
                            Forms
                        </li>
                        <li class="border-r border-bone-100 px-3.5 py-2.5 whitespace-nowrap will-change-transform">
                            Themes
                        </li>
                        <li class="border-r border-bone-100 px-3.5 py-2.5 whitespace-nowrap will-change-transform">
                            Widgets
                        </li>
                        <li class="border-r border-bone-100 px-3.5 py-2.5 whitespace-nowrap will-change-transform">
                            Filters
                        </li>
                        <li class="border-r border-bone-100 px-3.5 py-2.5 whitespace-nowrap will-change-transform">
                            Auth
                        </li>
                        <li class="border-r border-bone-100 px-3.5 py-2.5 whitespace-nowrap will-change-transform">
                            Actions
                        </li>
                        <li class="border-r border-bone-100 px-3.5 py-2.5 whitespace-nowrap will-change-transform">
                            Dashboards
                        </li>
                        <li class="border-r border-bone-100 px-3.5 py-2.5 whitespace-nowrap will-change-transform">
                            Notifications
                        </li>
                        <li class="border-r border-bone-100 px-3.5 py-2.5 whitespace-nowrap will-change-transform">
                            Localization
                        </li>
                        <li class="border-r border-bone-100 px-3.5 py-2.5 whitespace-nowrap will-change-transform">
                            Plugins
                        </li>
                        <li class="border-r border-bone-100 px-3.5 py-2.5 whitespace-nowrap will-change-transform">
                            Infolists
                        </li>
                        <li class="border-r border-bone-100 px-3.5 py-2.5 whitespace-nowrap will-change-transform">
                            Charts
                        </li>
                        <li class="border-r border-bone-100 px-3.5 py-2.5 whitespace-nowrap will-change-transform">
                            Pages
                        </li>
                        <li class="border-r border-bone-100 px-3.5 py-2.5 whitespace-nowrap will-change-transform">
                            CRUD
                        </li>
                        <li class="border-r border-bone-100 px-3.5 py-2.5 whitespace-nowrap will-change-transform">
                            Tables
                        </li>
                        <li class="border-r border-bone-100 px-3.5 py-2.5 whitespace-nowrap will-change-transform">
                            Admin Panel
                        </li>
                        <li class="border-r border-bone-100 px-3.5 py-2.5 whitespace-nowrap will-change-transform">
                            Forms
                        </li>
                        <li class="border-r border-bone-100 px-3.5 py-2.5 whitespace-nowrap will-change-transform">
                            Themes
                        </li>
                        <li class="border-r border-bone-100 px-3.5 py-2.5 whitespace-nowrap will-change-transform">
                            Widgets
                        </li>
                        <li class="border-r border-bone-100 px-3.5 py-2.5 whitespace-nowrap will-change-transform">
                            Filters
                        </li>
                        <li class="border-r border-bone-100 px-3.5 py-2.5 whitespace-nowrap will-change-transform">
                            Auth
                        </li>
                        <li class="border-r border-bone-100 px-3.5 py-2.5 whitespace-nowrap will-change-transform">
                            Actions
                        </li>
                        <li class="border-r border-bone-100 px-3.5 py-2.5 whitespace-nowrap will-change-transform">
                            Dashboards
                        </li>
                        <li class="border-r border-bone-100 px-3.5 py-2.5 whitespace-nowrap will-change-transform">
                            Notifications
                        </li>
                        <li class="border-r border-bone-100 px-3.5 py-2.5 whitespace-nowrap will-change-transform">
                            Localization
                        </li>
                        <li class="border-r border-bone-100 px-3.5 py-2.5 whitespace-nowrap will-change-transform">
                            Plugins
                        </li>
                        <li class="border-r border-bone-100 px-3.5 py-2.5 whitespace-nowrap will-change-transform">
                            Infolists
                        </li>
                        <li class="border-r border-bone-100 px-3.5 py-2.5 whitespace-nowrap will-change-transform">
                            Charts
                        </li>
                        <li class="border-r border-bone-100 px-3.5 py-2.5 whitespace-nowrap will-change-transform">
                            Pages
                        </li>
                        <li class="border-r border-bone-100 px-3.5 py-2.5 whitespace-nowrap will-change-transform">
                            CRUD
                        </li>
                        <li class="border-r border-bone-100 px-3.5 py-2.5 whitespace-nowrap will-change-transform">
                            Tables
                        </li>
                    </ul>
                </div>
            </section>


            <section data-triangle-decoration="bottom"
                class="@container border-b border-bone-100 px-8 py-10 sm:px-10 sm:py-15 lg:px-15 lg:py-20">
                <div data-animate="enter-from-left-staggered"
                    class="@min-[1100px]:grid-cols-4 grid grid-cols-1 gap-7 md:grid-cols-2 lg:grid-cols-3">

                    <header class="@min-[1100px]:col-span-2 col-span-full flex flex-col justify-center">
                        <h1 data-animate="text-reveal-lines">UI components</h1>
                        <p data-animate="text-reveal-lines"
                            class="mt-1 font-outfit text-2xl font-medium text-stone-800 md:mt-2 md:text-3xl">
                            that you won't outgrow
                        </p>
                        <p data-section-description data-animate="text-reveal-words"
                            class="@min-[1100px]:max-w-135 mt-3 md:mt-4">
                            A cohesive set of well-considered
                            <strong>building blocks</strong>
                            that adapt as your application grows in complexity.
                        </p>
                    </header>



                    <a x-data href="/docs/tables" target="_blank" rel="noopener noreferrer"
                        aria-label="Learn more about Tables feature" x-init="() => {
                            const card = $el
                            const background = $refs.background
                            const featureImage = $refs.featureImage
                            const patternBackground = $refs.patternBackground
                            const topLeftCorner = $refs.topLeftCorner
                            const bottomLeftCorner = $refs.bottomLeftCorner
                            const topRightCorner = $refs.topRightCorner
                            const bottomRightCorner = $refs.bottomRightCorner
                        
                            const tl = gsap.timeline({ paused: true })
                        
                            // Pattern background animation (infinite loop)
                            const patternTl = gsap.timeline({ paused: true, repeat: -1 })
                            patternTl.fromTo(
                                patternBackground, { backgroundPositionY: '0px' }, { backgroundPositionY: '100px', duration: 10, ease: 'none' },
                            )
                        
                            // Background scales up and changes color
                            tl.fromTo(
                                background, {
                                    scale: 1,
                                }, {
                                    scale: 1.02,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            // Feature image scales down slightly
                            tl.to(
                                featureImage, {
                                    scale: 0.95,
                                    duration: 0.25,
                                    ease: 'sine.out',
                                },
                                0,
                            )
                        
                            // Corner animations - move outward with stagger
                            tl.to(
                                topLeftCorner, {
                                    x: -8,
                                    y: -8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            tl.to(
                                topRightCorner, {
                                    x: 8,
                                    y: -8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            tl.to(
                                bottomLeftCorner, {
                                    x: -8,
                                    y: 8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            tl.to(
                                bottomRightCorner, {
                                    x: 8,
                                    y: 8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            motion.hover(card, () => {
                                tl.tweenTo(tl.duration())
                                patternTl.play()
                        
                                return () => {
                                    tl.tweenTo(0)
                                    patternTl.pause()
                                }
                            })
                        }"
                        class="group relative px-8 pb-10 text-center focus:outline-none focus-visible:ring focus-visible:ring-black/50">

                        <div x-ref="background"
                            class="absolute inset-0 bg-cream-100 transition duration-300 ease-out group-hover:bg-bubblegum/25"
                            aria-hidden="true"></div>



                        <div class="relative z-1 grid place-items-center">
                            <div
                                class="relative top-1 z-3 inline-grid size-22 place-items-center self-center justify-self-center rounded-full bg-cream-50 transition duration-400 ease-out [grid-area:1/-1] group-hover:bg-serenade-50">
                                <img x-ref="featureImage"
                                    src="https://filamentphp.com/build/assets/tables-BPQUdDmY.webp"
                                    alt="Filament Tables" loading="lazy" width="176" height="300"
                                    aria-hidden="true" class="h-auto max-h-15 w-auto max-w-15" />


                                <div class="absolute top-1/2 -left-4 -translate-1/2">
                                    <svg class="w-6 -translate-x-1 -scale-x-100 mask-r-from-50% text-bone-300 opacity-0 transition duration-400 ease-out group-hover:translate-x-0 group-hover:opacity-100"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 11" fill="none">
                                        <path
                                            d="M0.5 0.500122C1.3339 2.43778 1.76117 3.95599 1.75794 5.50012M0.5 10.5001C1.34285 8.53412 1.75479 7.00482 1.75794 5.50012M1.75794 5.50012H17.5"
                                            stroke-linecap="round" class="stroke-current" />
                                    </svg>
                                </div>


                                <div class="absolute top-1/2 -right-10 -translate-1/2">
                                    <svg class="w-6 translate-x-1 mask-r-from-50% text-bone-300 opacity-0 transition duration-400 ease-out group-hover:translate-x-0 group-hover:opacity-100"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 11" fill="none">
                                        <path
                                            d="M0.5 0.500122C1.3339 2.43778 1.76117 3.95599 1.75794 5.50012M0.5 10.5001C1.34285 8.53412 1.75479 7.00482 1.75794 5.50012M1.75794 5.50012H17.5"
                                            stroke-linecap="round" class="stroke-current" />
                                    </svg>
                                </div>
                            </div>


                            <div class="relative z-1 self-center justify-self-center mask-y-from-80% [grid-area:1/-1]">
                                <div x-ref="patternBackground"
                                    class="bg-x-pattern h-45 w-40 mask-x-from-35% bg-repeat"></div>
                            </div>
                        </div>


                        <div class="relative z-1 mt-3 flex flex-col items-center gap-1.5">
                            <div class="relative">

                                <div x-data x-init="() => {
                                    const tweens = []
                                    let playing = false
                                
                                    const rotatingEl = $el.querySelector('[data-rotating]')
                                    const rotate = () => {
                                        gsap.to(rotatingEl, {
                                            rotation: '+=60',
                                            duration: 0.5,
                                            ease: 'sine.out',
                                            onComplete: () => {
                                                if (playing) gsap.delayedCall(0.5, rotate)
                                            },
                                        })
                                    }
                                
                                    const boxes = $el.querySelectorAll('[data-box]')
                                    const delays = [0, 0.2, 0.1]
                                    boxes.forEach((box, i) => {
                                        tweens.push(
                                            gsap.to(box, {
                                                opacity: 0.3,
                                                repeat: -1,
                                                yoyo: true,
                                                duration: 0.4,
                                                delay: delays[i] || 0,
                                                ease: 'power1.inOut',
                                                paused: true,
                                            }),
                                        )
                                    })
                                
                                    const group = $el.closest('.group')
                                    if (group) {
                                        group.addEventListener('mouseenter', () => {
                                            playing = true
                                            tweens.forEach((t) => t.resume())
                                            rotate()
                                        })
                                        group.addEventListener('mouseleave', () => {
                                            playing = false
                                            tweens.forEach((t) => t.pause())
                                        })
                                    }
                                }"
                                    class="absolute top-1/2 -left-4 -translate-y-1/2">
                                    <div
                                        class="translate-x-0.5 opacity-0 transition duration-300 ease-out will-change-transform group-hover:translate-x-0 group-hover:opacity-100">
                                        <div data-rotating class="flex items-center gap-0.75">
                                            <div class="flex flex-col gap-1">

                                                <div data-box class="size-0.75 bg-current"></div>


                                                <div data-box class="size-0.75 bg-current"></div>
                                            </div>


                                            <div data-box class="size-0.75 bg-current"></div>
                                        </div>
                                    </div>
                                </div>


                                <p
                                    class="font-outfit text-xl font-medium text-stone-800 transition duration-300 ease-out will-change-transform group-hover:translate-x-0.5 md:text-2xl">
                                    Tables
                                </p>
                            </div>


                            <p class="text-pretty">Browse and filter large datasets with powerful columns, actions, and
                                bulk operations.</p>
                        </div>


                        <div x-ref="topLeftCorner" class="absolute top-0 left-0" aria-hidden="true">
                            <svg class="h-2.5 text-stone-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 11 11"
                                fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>


                        <div x-ref="bottomLeftCorner" class="absolute bottom-0 left-0" aria-hidden="true">
                            <svg class="h-2.5 -scale-y-100 text-stone-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 11 11" fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>


                        <div x-ref="topRightCorner" class="absolute top-0 right-0" aria-hidden="true">
                            <svg class="h-2.5 -scale-x-100 text-stone-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 11 11" fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>


                        <div x-ref="bottomRightCorner" class="absolute right-0 bottom-0" aria-hidden="true">
                            <svg class="h-2.5 -scale-x-100 -scale-y-100 text-stone-600"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 11 11" fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>
                    </a>
                    <a x-data href="/docs/forms" target="_blank" rel="noopener noreferrer"
                        aria-label="Learn more about Forms feature" x-init="() => {
                            const card = $el
                            const background = $refs.background
                            const featureImage = $refs.featureImage
                            const patternBackground = $refs.patternBackground
                            const topLeftCorner = $refs.topLeftCorner
                            const bottomLeftCorner = $refs.bottomLeftCorner
                            const topRightCorner = $refs.topRightCorner
                            const bottomRightCorner = $refs.bottomRightCorner
                        
                            const tl = gsap.timeline({ paused: true })
                        
                            // Pattern background animation (infinite loop)
                            const patternTl = gsap.timeline({ paused: true, repeat: -1 })
                            patternTl.fromTo(
                                patternBackground, { backgroundPositionY: '0px' }, { backgroundPositionY: '100px', duration: 10, ease: 'none' },
                            )
                        
                            // Background scales up and changes color
                            tl.fromTo(
                                background, {
                                    scale: 1,
                                }, {
                                    scale: 1.02,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            // Feature image scales down slightly
                            tl.to(
                                featureImage, {
                                    scale: 0.95,
                                    duration: 0.25,
                                    ease: 'sine.out',
                                },
                                0,
                            )
                        
                            // Corner animations - move outward with stagger
                            tl.to(
                                topLeftCorner, {
                                    x: -8,
                                    y: -8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            tl.to(
                                topRightCorner, {
                                    x: 8,
                                    y: -8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            tl.to(
                                bottomLeftCorner, {
                                    x: -8,
                                    y: 8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            tl.to(
                                bottomRightCorner, {
                                    x: 8,
                                    y: 8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            motion.hover(card, () => {
                                tl.tweenTo(tl.duration())
                                patternTl.play()
                        
                                return () => {
                                    tl.tweenTo(0)
                                    patternTl.pause()
                                }
                            })
                        }"
                        class="group relative px-8 pb-10 text-center focus:outline-none focus-visible:ring focus-visible:ring-black/50">

                        <div x-ref="background"
                            class="absolute inset-0 bg-cream-100 transition duration-300 ease-out group-hover:bg-bubblegum/25"
                            aria-hidden="true"></div>



                        <div class="relative z-1 grid place-items-center">
                            <div
                                class="relative top-1 z-3 inline-grid size-22 place-items-center self-center justify-self-center rounded-full bg-cream-50 transition duration-400 ease-out [grid-area:1/-1] group-hover:bg-serenade-50">
                                <img x-ref="featureImage"
                                    src="https://filamentphp.com/build/assets/forms-CPJ1SHFC.webp"
                                    alt="Filament Forms" loading="lazy" width="178" height="300"
                                    aria-hidden="true" class="h-auto max-h-15 w-auto max-w-15" />


                                <div class="absolute top-1/2 -left-4 -translate-1/2">
                                    <svg class="w-6 -translate-x-1 -scale-x-100 mask-r-from-50% text-bone-300 opacity-0 transition duration-400 ease-out group-hover:translate-x-0 group-hover:opacity-100"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 11" fill="none">
                                        <path
                                            d="M0.5 0.500122C1.3339 2.43778 1.76117 3.95599 1.75794 5.50012M0.5 10.5001C1.34285 8.53412 1.75479 7.00482 1.75794 5.50012M1.75794 5.50012H17.5"
                                            stroke-linecap="round" class="stroke-current" />
                                    </svg>
                                </div>


                                <div class="absolute top-1/2 -right-10 -translate-1/2">
                                    <svg class="w-6 translate-x-1 mask-r-from-50% text-bone-300 opacity-0 transition duration-400 ease-out group-hover:translate-x-0 group-hover:opacity-100"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 11" fill="none">
                                        <path
                                            d="M0.5 0.500122C1.3339 2.43778 1.76117 3.95599 1.75794 5.50012M0.5 10.5001C1.34285 8.53412 1.75479 7.00482 1.75794 5.50012M1.75794 5.50012H17.5"
                                            stroke-linecap="round" class="stroke-current" />
                                    </svg>
                                </div>
                            </div>


                            <div class="relative z-1 self-center justify-self-center mask-y-from-80% [grid-area:1/-1]">
                                <div x-ref="patternBackground"
                                    class="bg-x-pattern h-45 w-40 mask-x-from-35% bg-repeat"></div>
                            </div>
                        </div>


                        <div class="relative z-1 mt-3 flex flex-col items-center gap-1.5">
                            <div class="relative">

                                <div x-data x-init="() => {
                                    const tweens = []
                                    let playing = false
                                
                                    const rotatingEl = $el.querySelector('[data-rotating]')
                                    const rotate = () => {
                                        gsap.to(rotatingEl, {
                                            rotation: '+=60',
                                            duration: 0.5,
                                            ease: 'sine.out',
                                            onComplete: () => {
                                                if (playing) gsap.delayedCall(0.5, rotate)
                                            },
                                        })
                                    }
                                
                                    const boxes = $el.querySelectorAll('[data-box]')
                                    const delays = [0, 0.2, 0.1]
                                    boxes.forEach((box, i) => {
                                        tweens.push(
                                            gsap.to(box, {
                                                opacity: 0.3,
                                                repeat: -1,
                                                yoyo: true,
                                                duration: 0.4,
                                                delay: delays[i] || 0,
                                                ease: 'power1.inOut',
                                                paused: true,
                                            }),
                                        )
                                    })
                                
                                    const group = $el.closest('.group')
                                    if (group) {
                                        group.addEventListener('mouseenter', () => {
                                            playing = true
                                            tweens.forEach((t) => t.resume())
                                            rotate()
                                        })
                                        group.addEventListener('mouseleave', () => {
                                            playing = false
                                            tweens.forEach((t) => t.pause())
                                        })
                                    }
                                }"
                                    class="absolute top-1/2 -left-4 -translate-y-1/2">
                                    <div
                                        class="translate-x-0.5 opacity-0 transition duration-300 ease-out will-change-transform group-hover:translate-x-0 group-hover:opacity-100">
                                        <div data-rotating class="flex items-center gap-0.75">
                                            <div class="flex flex-col gap-1">

                                                <div data-box class="size-0.75 bg-current"></div>


                                                <div data-box class="size-0.75 bg-current"></div>
                                            </div>


                                            <div data-box class="size-0.75 bg-current"></div>
                                        </div>
                                    </div>
                                </div>


                                <p
                                    class="font-outfit text-xl font-medium text-stone-800 transition duration-300 ease-out will-change-transform group-hover:translate-x-0.5 md:text-2xl">
                                    Forms
                                </p>
                            </div>


                            <p class="text-pretty">Build complex, reactive forms using a set of reusable, state-aware
                                components.</p>
                        </div>


                        <div x-ref="topLeftCorner" class="absolute top-0 left-0" aria-hidden="true">
                            <svg class="h-2.5 text-stone-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 11 11"
                                fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>


                        <div x-ref="bottomLeftCorner" class="absolute bottom-0 left-0" aria-hidden="true">
                            <svg class="h-2.5 -scale-y-100 text-stone-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 11 11" fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>


                        <div x-ref="topRightCorner" class="absolute top-0 right-0" aria-hidden="true">
                            <svg class="h-2.5 -scale-x-100 text-stone-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 11 11" fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>


                        <div x-ref="bottomRightCorner" class="absolute right-0 bottom-0" aria-hidden="true">
                            <svg class="h-2.5 -scale-x-100 -scale-y-100 text-stone-600"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 11 11" fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>
                    </a>
                    <a x-data href="/docs/infolists" target="_blank" rel="noopener noreferrer"
                        aria-label="Learn more about Infolists feature" x-init="() => {
                            const card = $el
                            const background = $refs.background
                            const featureImage = $refs.featureImage
                            const patternBackground = $refs.patternBackground
                            const topLeftCorner = $refs.topLeftCorner
                            const bottomLeftCorner = $refs.bottomLeftCorner
                            const topRightCorner = $refs.topRightCorner
                            const bottomRightCorner = $refs.bottomRightCorner
                        
                            const tl = gsap.timeline({ paused: true })
                        
                            // Pattern background animation (infinite loop)
                            const patternTl = gsap.timeline({ paused: true, repeat: -1 })
                            patternTl.fromTo(
                                patternBackground, { backgroundPositionY: '0px' }, { backgroundPositionY: '100px', duration: 10, ease: 'none' },
                            )
                        
                            // Background scales up and changes color
                            tl.fromTo(
                                background, {
                                    scale: 1,
                                }, {
                                    scale: 1.02,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            // Feature image scales down slightly
                            tl.to(
                                featureImage, {
                                    scale: 0.95,
                                    duration: 0.25,
                                    ease: 'sine.out',
                                },
                                0,
                            )
                        
                            // Corner animations - move outward with stagger
                            tl.to(
                                topLeftCorner, {
                                    x: -8,
                                    y: -8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            tl.to(
                                topRightCorner, {
                                    x: 8,
                                    y: -8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            tl.to(
                                bottomLeftCorner, {
                                    x: -8,
                                    y: 8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            tl.to(
                                bottomRightCorner, {
                                    x: 8,
                                    y: 8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            motion.hover(card, () => {
                                tl.tweenTo(tl.duration())
                                patternTl.play()
                        
                                return () => {
                                    tl.tweenTo(0)
                                    patternTl.pause()
                                }
                            })
                        }"
                        class="group relative px-8 pb-10 text-center focus:outline-none focus-visible:ring focus-visible:ring-black/50">

                        <div x-ref="background"
                            class="absolute inset-0 bg-cream-100 transition duration-300 ease-out group-hover:bg-bubblegum/25"
                            aria-hidden="true"></div>



                        <div class="relative z-1 grid place-items-center">
                            <div
                                class="relative top-1 z-3 inline-grid size-22 place-items-center self-center justify-self-center rounded-full bg-cream-50 transition duration-400 ease-out [grid-area:1/-1] group-hover:bg-serenade-50">
                                <img x-ref="featureImage"
                                    src="https://filamentphp.com/build/assets/infolists-CJgdPRc_.webp"
                                    alt="Filament Infolists" loading="lazy" width="179" height="300"
                                    aria-hidden="true" class="h-auto max-h-15 w-auto max-w-15" />


                                <div class="absolute top-1/2 -left-4 -translate-1/2">
                                    <svg class="w-6 -translate-x-1 -scale-x-100 mask-r-from-50% text-bone-300 opacity-0 transition duration-400 ease-out group-hover:translate-x-0 group-hover:opacity-100"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 11" fill="none">
                                        <path
                                            d="M0.5 0.500122C1.3339 2.43778 1.76117 3.95599 1.75794 5.50012M0.5 10.5001C1.34285 8.53412 1.75479 7.00482 1.75794 5.50012M1.75794 5.50012H17.5"
                                            stroke-linecap="round" class="stroke-current" />
                                    </svg>
                                </div>


                                <div class="absolute top-1/2 -right-10 -translate-1/2">
                                    <svg class="w-6 translate-x-1 mask-r-from-50% text-bone-300 opacity-0 transition duration-400 ease-out group-hover:translate-x-0 group-hover:opacity-100"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 11" fill="none">
                                        <path
                                            d="M0.5 0.500122C1.3339 2.43778 1.76117 3.95599 1.75794 5.50012M0.5 10.5001C1.34285 8.53412 1.75479 7.00482 1.75794 5.50012M1.75794 5.50012H17.5"
                                            stroke-linecap="round" class="stroke-current" />
                                    </svg>
                                </div>
                            </div>


                            <div class="relative z-1 self-center justify-self-center mask-y-from-80% [grid-area:1/-1]">
                                <div x-ref="patternBackground"
                                    class="bg-x-pattern h-45 w-40 mask-x-from-35% bg-repeat"></div>
                            </div>
                        </div>


                        <div class="relative z-1 mt-3 flex flex-col items-center gap-1.5">
                            <div class="relative">

                                <div x-data x-init="() => {
                                    const tweens = []
                                    let playing = false
                                
                                    const rotatingEl = $el.querySelector('[data-rotating]')
                                    const rotate = () => {
                                        gsap.to(rotatingEl, {
                                            rotation: '+=60',
                                            duration: 0.5,
                                            ease: 'sine.out',
                                            onComplete: () => {
                                                if (playing) gsap.delayedCall(0.5, rotate)
                                            },
                                        })
                                    }
                                
                                    const boxes = $el.querySelectorAll('[data-box]')
                                    const delays = [0, 0.2, 0.1]
                                    boxes.forEach((box, i) => {
                                        tweens.push(
                                            gsap.to(box, {
                                                opacity: 0.3,
                                                repeat: -1,
                                                yoyo: true,
                                                duration: 0.4,
                                                delay: delays[i] || 0,
                                                ease: 'power1.inOut',
                                                paused: true,
                                            }),
                                        )
                                    })
                                
                                    const group = $el.closest('.group')
                                    if (group) {
                                        group.addEventListener('mouseenter', () => {
                                            playing = true
                                            tweens.forEach((t) => t.resume())
                                            rotate()
                                        })
                                        group.addEventListener('mouseleave', () => {
                                            playing = false
                                            tweens.forEach((t) => t.pause())
                                        })
                                    }
                                }"
                                    class="absolute top-1/2 -left-4 -translate-y-1/2">
                                    <div
                                        class="translate-x-0.5 opacity-0 transition duration-300 ease-out will-change-transform group-hover:translate-x-0 group-hover:opacity-100">
                                        <div data-rotating class="flex items-center gap-0.75">
                                            <div class="flex flex-col gap-1">

                                                <div data-box class="size-0.75 bg-current"></div>


                                                <div data-box class="size-0.75 bg-current"></div>
                                            </div>


                                            <div data-box class="size-0.75 bg-current"></div>
                                        </div>
                                    </div>
                                </div>


                                <p
                                    class="font-outfit text-xl font-medium text-stone-800 transition duration-300 ease-out will-change-transform group-hover:translate-x-0.5 md:text-2xl">
                                    Infolists
                                </p>
                            </div>


                            <p class="text-pretty">Render read-only record views with structured layouts and custom
                                formatting.</p>
                        </div>


                        <div x-ref="topLeftCorner" class="absolute top-0 left-0" aria-hidden="true">
                            <svg class="h-2.5 text-stone-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 11 11"
                                fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>


                        <div x-ref="bottomLeftCorner" class="absolute bottom-0 left-0" aria-hidden="true">
                            <svg class="h-2.5 -scale-y-100 text-stone-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 11 11" fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>


                        <div x-ref="topRightCorner" class="absolute top-0 right-0" aria-hidden="true">
                            <svg class="h-2.5 -scale-x-100 text-stone-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 11 11" fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>


                        <div x-ref="bottomRightCorner" class="absolute right-0 bottom-0" aria-hidden="true">
                            <svg class="h-2.5 -scale-x-100 -scale-y-100 text-stone-600"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 11 11" fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>
                    </a>
                    <a x-data href="/docs/notifications" target="_blank" rel="noopener noreferrer"
                        aria-label="Learn more about Notifications feature" x-init="() => {
                            const card = $el
                            const background = $refs.background
                            const featureImage = $refs.featureImage
                            const patternBackground = $refs.patternBackground
                            const topLeftCorner = $refs.topLeftCorner
                            const bottomLeftCorner = $refs.bottomLeftCorner
                            const topRightCorner = $refs.topRightCorner
                            const bottomRightCorner = $refs.bottomRightCorner
                        
                            const tl = gsap.timeline({ paused: true })
                        
                            // Pattern background animation (infinite loop)
                            const patternTl = gsap.timeline({ paused: true, repeat: -1 })
                            patternTl.fromTo(
                                patternBackground, { backgroundPositionY: '0px' }, { backgroundPositionY: '100px', duration: 10, ease: 'none' },
                            )
                        
                            // Background scales up and changes color
                            tl.fromTo(
                                background, {
                                    scale: 1,
                                }, {
                                    scale: 1.02,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            // Feature image scales down slightly
                            tl.to(
                                featureImage, {
                                    scale: 0.95,
                                    duration: 0.25,
                                    ease: 'sine.out',
                                },
                                0,
                            )
                        
                            // Corner animations - move outward with stagger
                            tl.to(
                                topLeftCorner, {
                                    x: -8,
                                    y: -8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            tl.to(
                                topRightCorner, {
                                    x: 8,
                                    y: -8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            tl.to(
                                bottomLeftCorner, {
                                    x: -8,
                                    y: 8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            tl.to(
                                bottomRightCorner, {
                                    x: 8,
                                    y: 8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            motion.hover(card, () => {
                                tl.tweenTo(tl.duration())
                                patternTl.play()
                        
                                return () => {
                                    tl.tweenTo(0)
                                    patternTl.pause()
                                }
                            })
                        }"
                        class="group relative px-8 pb-10 text-center focus:outline-none focus-visible:ring focus-visible:ring-black/50">

                        <div x-ref="background"
                            class="absolute inset-0 bg-cream-100 transition duration-300 ease-out group-hover:bg-bubblegum/25"
                            aria-hidden="true"></div>



                        <div class="relative z-1 grid place-items-center">
                            <div
                                class="relative top-1 z-3 inline-grid size-22 place-items-center self-center justify-self-center rounded-full bg-cream-50 transition duration-400 ease-out [grid-area:1/-1] group-hover:bg-serenade-50">
                                <img x-ref="featureImage"
                                    src="https://filamentphp.com/build/assets/notifications-Chl0PoDP.webp"
                                    alt="Filament Notifications" loading="lazy" width="287" height="300"
                                    aria-hidden="true" class="h-auto max-h-15 w-auto max-w-15" />


                                <div class="absolute top-1/2 -left-4 -translate-1/2">
                                    <svg class="w-6 -translate-x-1 -scale-x-100 mask-r-from-50% text-bone-300 opacity-0 transition duration-400 ease-out group-hover:translate-x-0 group-hover:opacity-100"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 11" fill="none">
                                        <path
                                            d="M0.5 0.500122C1.3339 2.43778 1.76117 3.95599 1.75794 5.50012M0.5 10.5001C1.34285 8.53412 1.75479 7.00482 1.75794 5.50012M1.75794 5.50012H17.5"
                                            stroke-linecap="round" class="stroke-current" />
                                    </svg>
                                </div>


                                <div class="absolute top-1/2 -right-10 -translate-1/2">
                                    <svg class="w-6 translate-x-1 mask-r-from-50% text-bone-300 opacity-0 transition duration-400 ease-out group-hover:translate-x-0 group-hover:opacity-100"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 11" fill="none">
                                        <path
                                            d="M0.5 0.500122C1.3339 2.43778 1.76117 3.95599 1.75794 5.50012M0.5 10.5001C1.34285 8.53412 1.75479 7.00482 1.75794 5.50012M1.75794 5.50012H17.5"
                                            stroke-linecap="round" class="stroke-current" />
                                    </svg>
                                </div>
                            </div>


                            <div class="relative z-1 self-center justify-self-center mask-y-from-80% [grid-area:1/-1]">
                                <div x-ref="patternBackground"
                                    class="bg-x-pattern h-45 w-40 mask-x-from-35% bg-repeat"></div>
                            </div>
                        </div>


                        <div class="relative z-1 mt-3 flex flex-col items-center gap-1.5">
                            <div class="relative">

                                <div x-data x-init="() => {
                                    const tweens = []
                                    let playing = false
                                
                                    const rotatingEl = $el.querySelector('[data-rotating]')
                                    const rotate = () => {
                                        gsap.to(rotatingEl, {
                                            rotation: '+=60',
                                            duration: 0.5,
                                            ease: 'sine.out',
                                            onComplete: () => {
                                                if (playing) gsap.delayedCall(0.5, rotate)
                                            },
                                        })
                                    }
                                
                                    const boxes = $el.querySelectorAll('[data-box]')
                                    const delays = [0, 0.2, 0.1]
                                    boxes.forEach((box, i) => {
                                        tweens.push(
                                            gsap.to(box, {
                                                opacity: 0.3,
                                                repeat: -1,
                                                yoyo: true,
                                                duration: 0.4,
                                                delay: delays[i] || 0,
                                                ease: 'power1.inOut',
                                                paused: true,
                                            }),
                                        )
                                    })
                                
                                    const group = $el.closest('.group')
                                    if (group) {
                                        group.addEventListener('mouseenter', () => {
                                            playing = true
                                            tweens.forEach((t) => t.resume())
                                            rotate()
                                        })
                                        group.addEventListener('mouseleave', () => {
                                            playing = false
                                            tweens.forEach((t) => t.pause())
                                        })
                                    }
                                }"
                                    class="absolute top-1/2 -left-4 -translate-y-1/2">
                                    <div
                                        class="translate-x-0.5 opacity-0 transition duration-300 ease-out will-change-transform group-hover:translate-x-0 group-hover:opacity-100">
                                        <div data-rotating class="flex items-center gap-0.75">
                                            <div class="flex flex-col gap-1">

                                                <div data-box class="size-0.75 bg-current"></div>


                                                <div data-box class="size-0.75 bg-current"></div>
                                            </div>


                                            <div data-box class="size-0.75 bg-current"></div>
                                        </div>
                                    </div>
                                </div>


                                <p
                                    class="font-outfit text-xl font-medium text-stone-800 transition duration-300 ease-out will-change-transform group-hover:translate-x-0.5 md:text-2xl">
                                    Notifications
                                </p>
                            </div>


                            <p class="text-pretty">Trigger in-app feedback for actions, errors, and system events with
                                minimal setup.</p>
                        </div>


                        <div x-ref="topLeftCorner" class="absolute top-0 left-0" aria-hidden="true">
                            <svg class="h-2.5 text-stone-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 11 11"
                                fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>


                        <div x-ref="bottomLeftCorner" class="absolute bottom-0 left-0" aria-hidden="true">
                            <svg class="h-2.5 -scale-y-100 text-stone-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 11 11" fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>


                        <div x-ref="topRightCorner" class="absolute top-0 right-0" aria-hidden="true">
                            <svg class="h-2.5 -scale-x-100 text-stone-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 11 11" fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>


                        <div x-ref="bottomRightCorner" class="absolute right-0 bottom-0" aria-hidden="true">
                            <svg class="h-2.5 -scale-x-100 -scale-y-100 text-stone-600"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 11 11" fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>
                    </a>
                    <a x-data href="/docs/widgets" target="_blank" rel="noopener noreferrer"
                        aria-label="Learn more about Dashboard widgets feature" x-init="() => {
                            const card = $el
                            const background = $refs.background
                            const featureImage = $refs.featureImage
                            const patternBackground = $refs.patternBackground
                            const topLeftCorner = $refs.topLeftCorner
                            const bottomLeftCorner = $refs.bottomLeftCorner
                            const topRightCorner = $refs.topRightCorner
                            const bottomRightCorner = $refs.bottomRightCorner
                        
                            const tl = gsap.timeline({ paused: true })
                        
                            // Pattern background animation (infinite loop)
                            const patternTl = gsap.timeline({ paused: true, repeat: -1 })
                            patternTl.fromTo(
                                patternBackground, { backgroundPositionY: '0px' }, { backgroundPositionY: '100px', duration: 10, ease: 'none' },
                            )
                        
                            // Background scales up and changes color
                            tl.fromTo(
                                background, {
                                    scale: 1,
                                }, {
                                    scale: 1.02,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            // Feature image scales down slightly
                            tl.to(
                                featureImage, {
                                    scale: 0.95,
                                    duration: 0.25,
                                    ease: 'sine.out',
                                },
                                0,
                            )
                        
                            // Corner animations - move outward with stagger
                            tl.to(
                                topLeftCorner, {
                                    x: -8,
                                    y: -8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            tl.to(
                                topRightCorner, {
                                    x: 8,
                                    y: -8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            tl.to(
                                bottomLeftCorner, {
                                    x: -8,
                                    y: 8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            tl.to(
                                bottomRightCorner, {
                                    x: 8,
                                    y: 8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            motion.hover(card, () => {
                                tl.tweenTo(tl.duration())
                                patternTl.play()
                        
                                return () => {
                                    tl.tweenTo(0)
                                    patternTl.pause()
                                }
                            })
                        }"
                        class="group relative px-8 pb-10 text-center focus:outline-none focus-visible:ring focus-visible:ring-black/50">

                        <div x-ref="background"
                            class="absolute inset-0 bg-cream-100 transition duration-300 ease-out group-hover:bg-bubblegum/25"
                            aria-hidden="true"></div>



                        <div class="relative z-1 grid place-items-center">
                            <div
                                class="relative top-1 z-3 inline-grid size-22 place-items-center self-center justify-self-center rounded-full bg-cream-50 transition duration-400 ease-out [grid-area:1/-1] group-hover:bg-serenade-50">
                                <img x-ref="featureImage"
                                    src="https://filamentphp.com/build/assets/widgets-Ddxz14th.webp"
                                    alt="Filament Dashboard widgets" loading="lazy" width="429"
                                    height="300" aria-hidden="true" class="h-auto max-h-15 w-auto max-w-15" />


                                <div class="absolute top-1/2 -left-4 -translate-1/2">
                                    <svg class="w-6 -translate-x-1 -scale-x-100 mask-r-from-50% text-bone-300 opacity-0 transition duration-400 ease-out group-hover:translate-x-0 group-hover:opacity-100"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 11" fill="none">
                                        <path
                                            d="M0.5 0.500122C1.3339 2.43778 1.76117 3.95599 1.75794 5.50012M0.5 10.5001C1.34285 8.53412 1.75479 7.00482 1.75794 5.50012M1.75794 5.50012H17.5"
                                            stroke-linecap="round" class="stroke-current" />
                                    </svg>
                                </div>


                                <div class="absolute top-1/2 -right-10 -translate-1/2">
                                    <svg class="w-6 translate-x-1 mask-r-from-50% text-bone-300 opacity-0 transition duration-400 ease-out group-hover:translate-x-0 group-hover:opacity-100"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 11" fill="none">
                                        <path
                                            d="M0.5 0.500122C1.3339 2.43778 1.76117 3.95599 1.75794 5.50012M0.5 10.5001C1.34285 8.53412 1.75479 7.00482 1.75794 5.50012M1.75794 5.50012H17.5"
                                            stroke-linecap="round" class="stroke-current" />
                                    </svg>
                                </div>
                            </div>


                            <div
                                class="relative z-1 self-center justify-self-center mask-y-from-80% [grid-area:1/-1]">
                                <div x-ref="patternBackground"
                                    class="bg-x-pattern h-45 w-40 mask-x-from-35% bg-repeat"></div>
                            </div>
                        </div>


                        <div class="relative z-1 mt-3 flex flex-col items-center gap-1.5">
                            <div class="relative">

                                <div x-data x-init="() => {
                                    const tweens = []
                                    let playing = false
                                
                                    const rotatingEl = $el.querySelector('[data-rotating]')
                                    const rotate = () => {
                                        gsap.to(rotatingEl, {
                                            rotation: '+=60',
                                            duration: 0.5,
                                            ease: 'sine.out',
                                            onComplete: () => {
                                                if (playing) gsap.delayedCall(0.5, rotate)
                                            },
                                        })
                                    }
                                
                                    const boxes = $el.querySelectorAll('[data-box]')
                                    const delays = [0, 0.2, 0.1]
                                    boxes.forEach((box, i) => {
                                        tweens.push(
                                            gsap.to(box, {
                                                opacity: 0.3,
                                                repeat: -1,
                                                yoyo: true,
                                                duration: 0.4,
                                                delay: delays[i] || 0,
                                                ease: 'power1.inOut',
                                                paused: true,
                                            }),
                                        )
                                    })
                                
                                    const group = $el.closest('.group')
                                    if (group) {
                                        group.addEventListener('mouseenter', () => {
                                            playing = true
                                            tweens.forEach((t) => t.resume())
                                            rotate()
                                        })
                                        group.addEventListener('mouseleave', () => {
                                            playing = false
                                            tweens.forEach((t) => t.pause())
                                        })
                                    }
                                }"
                                    class="absolute top-1/2 -left-4 -translate-y-1/2">
                                    <div
                                        class="translate-x-0.5 opacity-0 transition duration-300 ease-out will-change-transform group-hover:translate-x-0 group-hover:opacity-100">
                                        <div data-rotating class="flex items-center gap-0.75">
                                            <div class="flex flex-col gap-1">

                                                <div data-box class="size-0.75 bg-current"></div>


                                                <div data-box class="size-0.75 bg-current"></div>
                                            </div>


                                            <div data-box class="size-0.75 bg-current"></div>
                                        </div>
                                    </div>
                                </div>


                                <p
                                    class="font-outfit text-xl font-medium text-stone-800 transition duration-300 ease-out will-change-transform group-hover:translate-x-0.5 md:text-2xl">
                                    Dashboard widgets
                                </p>
                            </div>


                            <p class="text-pretty">Surface key metrics and trends using live, data-driven widgets
                                tailored to each user.</p>
                        </div>


                        <div x-ref="topLeftCorner" class="absolute top-0 left-0" aria-hidden="true">
                            <svg class="h-2.5 text-stone-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 11 11" fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>


                        <div x-ref="bottomLeftCorner" class="absolute bottom-0 left-0" aria-hidden="true">
                            <svg class="h-2.5 -scale-y-100 text-stone-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 11 11" fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>


                        <div x-ref="topRightCorner" class="absolute top-0 right-0" aria-hidden="true">
                            <svg class="h-2.5 -scale-x-100 text-stone-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 11 11" fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>


                        <div x-ref="bottomRightCorner" class="absolute right-0 bottom-0" aria-hidden="true">
                            <svg class="h-2.5 -scale-x-100 -scale-y-100 text-stone-600"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 11 11" fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>
                    </a>
                    <a x-data href="/docs/actions" target="_blank" rel="noopener noreferrer"
                        aria-label="Learn more about Action modals feature" x-init="() => {
                            const card = $el
                            const background = $refs.background
                            const featureImage = $refs.featureImage
                            const patternBackground = $refs.patternBackground
                            const topLeftCorner = $refs.topLeftCorner
                            const bottomLeftCorner = $refs.bottomLeftCorner
                            const topRightCorner = $refs.topRightCorner
                            const bottomRightCorner = $refs.bottomRightCorner
                        
                            const tl = gsap.timeline({ paused: true })
                        
                            // Pattern background animation (infinite loop)
                            const patternTl = gsap.timeline({ paused: true, repeat: -1 })
                            patternTl.fromTo(
                                patternBackground, { backgroundPositionY: '0px' }, { backgroundPositionY: '100px', duration: 10, ease: 'none' },
                            )
                        
                            // Background scales up and changes color
                            tl.fromTo(
                                background, {
                                    scale: 1,
                                }, {
                                    scale: 1.02,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            // Feature image scales down slightly
                            tl.to(
                                featureImage, {
                                    scale: 0.95,
                                    duration: 0.25,
                                    ease: 'sine.out',
                                },
                                0,
                            )
                        
                            // Corner animations - move outward with stagger
                            tl.to(
                                topLeftCorner, {
                                    x: -8,
                                    y: -8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            tl.to(
                                topRightCorner, {
                                    x: 8,
                                    y: -8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            tl.to(
                                bottomLeftCorner, {
                                    x: -8,
                                    y: 8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            tl.to(
                                bottomRightCorner, {
                                    x: 8,
                                    y: 8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            motion.hover(card, () => {
                                tl.tweenTo(tl.duration())
                                patternTl.play()
                        
                                return () => {
                                    tl.tweenTo(0)
                                    patternTl.pause()
                                }
                            })
                        }"
                        class="group relative px-8 pb-10 text-center focus:outline-none focus-visible:ring focus-visible:ring-black/50">

                        <div x-ref="background"
                            class="absolute inset-0 bg-cream-100 transition duration-300 ease-out group-hover:bg-bubblegum/25"
                            aria-hidden="true"></div>



                        <div class="relative z-1 grid place-items-center">
                            <div
                                class="relative top-1 z-3 inline-grid size-22 place-items-center self-center justify-self-center rounded-full bg-cream-50 transition duration-400 ease-out [grid-area:1/-1] group-hover:bg-serenade-50">
                                <img x-ref="featureImage"
                                    src="https://filamentphp.com/build/assets/actions-Co0I9Ix8.webp"
                                    alt="Filament Action modals" loading="lazy" width="351" height="300"
                                    aria-hidden="true" class="h-auto max-h-15 w-auto max-w-15" />


                                <div class="absolute top-1/2 -left-4 -translate-1/2">
                                    <svg class="w-6 -translate-x-1 -scale-x-100 mask-r-from-50% text-bone-300 opacity-0 transition duration-400 ease-out group-hover:translate-x-0 group-hover:opacity-100"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 11" fill="none">
                                        <path
                                            d="M0.5 0.500122C1.3339 2.43778 1.76117 3.95599 1.75794 5.50012M0.5 10.5001C1.34285 8.53412 1.75479 7.00482 1.75794 5.50012M1.75794 5.50012H17.5"
                                            stroke-linecap="round" class="stroke-current" />
                                    </svg>
                                </div>


                                <div class="absolute top-1/2 -right-10 -translate-1/2">
                                    <svg class="w-6 translate-x-1 mask-r-from-50% text-bone-300 opacity-0 transition duration-400 ease-out group-hover:translate-x-0 group-hover:opacity-100"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 11" fill="none">
                                        <path
                                            d="M0.5 0.500122C1.3339 2.43778 1.76117 3.95599 1.75794 5.50012M0.5 10.5001C1.34285 8.53412 1.75479 7.00482 1.75794 5.50012M1.75794 5.50012H17.5"
                                            stroke-linecap="round" class="stroke-current" />
                                    </svg>
                                </div>
                            </div>


                            <div
                                class="relative z-1 self-center justify-self-center mask-y-from-80% [grid-area:1/-1]">
                                <div x-ref="patternBackground"
                                    class="bg-x-pattern h-45 w-40 mask-x-from-35% bg-repeat"></div>
                            </div>
                        </div>


                        <div class="relative z-1 mt-3 flex flex-col items-center gap-1.5">
                            <div class="relative">

                                <div x-data x-init="() => {
                                    const tweens = []
                                    let playing = false
                                
                                    const rotatingEl = $el.querySelector('[data-rotating]')
                                    const rotate = () => {
                                        gsap.to(rotatingEl, {
                                            rotation: '+=60',
                                            duration: 0.5,
                                            ease: 'sine.out',
                                            onComplete: () => {
                                                if (playing) gsap.delayedCall(0.5, rotate)
                                            },
                                        })
                                    }
                                
                                    const boxes = $el.querySelectorAll('[data-box]')
                                    const delays = [0, 0.2, 0.1]
                                    boxes.forEach((box, i) => {
                                        tweens.push(
                                            gsap.to(box, {
                                                opacity: 0.3,
                                                repeat: -1,
                                                yoyo: true,
                                                duration: 0.4,
                                                delay: delays[i] || 0,
                                                ease: 'power1.inOut',
                                                paused: true,
                                            }),
                                        )
                                    })
                                
                                    const group = $el.closest('.group')
                                    if (group) {
                                        group.addEventListener('mouseenter', () => {
                                            playing = true
                                            tweens.forEach((t) => t.resume())
                                            rotate()
                                        })
                                        group.addEventListener('mouseleave', () => {
                                            playing = false
                                            tweens.forEach((t) => t.pause())
                                        })
                                    }
                                }"
                                    class="absolute top-1/2 -left-4 -translate-y-1/2">
                                    <div
                                        class="translate-x-0.5 opacity-0 transition duration-300 ease-out will-change-transform group-hover:translate-x-0 group-hover:opacity-100">
                                        <div data-rotating class="flex items-center gap-0.75">
                                            <div class="flex flex-col gap-1">

                                                <div data-box class="size-0.75 bg-current"></div>


                                                <div data-box class="size-0.75 bg-current"></div>
                                            </div>


                                            <div data-box class="size-0.75 bg-current"></div>
                                        </div>
                                    </div>
                                </div>


                                <p
                                    class="font-outfit text-xl font-medium text-stone-800 transition duration-300 ease-out will-change-transform group-hover:translate-x-0.5 md:text-2xl">
                                    Action modals
                                </p>
                            </div>


                            <p class="text-pretty">Handle confirmations and data entry with focused modal workflows
                                tied to actions.</p>
                        </div>


                        <div x-ref="topLeftCorner" class="absolute top-0 left-0" aria-hidden="true">
                            <svg class="h-2.5 text-stone-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 11 11" fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>


                        <div x-ref="bottomLeftCorner" class="absolute bottom-0 left-0" aria-hidden="true">
                            <svg class="h-2.5 -scale-y-100 text-stone-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 11 11" fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>


                        <div x-ref="topRightCorner" class="absolute top-0 right-0" aria-hidden="true">
                            <svg class="h-2.5 -scale-x-100 text-stone-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 11 11" fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>


                        <div x-ref="bottomRightCorner" class="absolute right-0 bottom-0" aria-hidden="true">
                            <svg class="h-2.5 -scale-x-100 -scale-y-100 text-stone-600"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 11 11" fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>
                    </a>
                </div>
            </section>


            <section data-triangle-decoration="bottom"
                class="grid grid-cols-1 border-b border-bone-100 lg:grid-cols-2">

                <div class="bg-stone-900 p-8 sm:p-10">

                    <div class="flex flex-col items-center gap-4">

                        <header class="flex flex-col items-center gap-2 text-center">
                            <div data-animate="text-reveal-lines"
                                class="text-2xl font-medium text-stone-100 md:text-3xl">
                                Try our live demo
                            </div>
                            <p data-section-description data-animate="text-reveal-words" class="text-stone-400">
                                We've built a
                                <span class="font-medium text-stone-100">feature-rich</span>
                                demo application showcasing Filament in practice. It's
                                completely
                                <span class="font-medium text-stone-100">open-source</span>
                                and
                                <span class="font-medium text-stone-100">
                                    ready to explore.
                                </span>
                            </p>
                        </header>


                        <nav data-animate="enter-from-left">
                            <div x-data data-button-pulse class="rounded-full bg-powder-400"
                                aria-label="Launch the Filament demo application (opens in new window)"
                                x-init="async () => {
                                    await window.FilamentAnimations.waitForFonts()
                                
                                    const button = $el.querySelector('a')
                                    const textWrapper = button.querySelector('[data-text]')
                                    const icon = button.querySelector('[data-icon] svg')
                                    const hasCustomIcon = false
                                    const hasCustomContent = false
                                    const animateIcon = true
                                
                                    const tl = gsap.timeline({ paused: true })
                                
                                    // Only animate text if not using custom content
                                    let chars = []
                                    if (!hasCustomContent && textWrapper) {
                                        const split = new SplitText(textWrapper, { type: 'chars' })
                                        chars = split.chars
                                    }
                                
                                    if (hasCustomIcon && animateIcon) {
                                        // Custom icon animation: subtle scale and lift
                                        tl.to(
                                            icon, {
                                                scale: 1.1,
                                                rotation: 0.01,
                                                duration: 0.3,
                                                ease: 'sine.out',
                                            },
                                            0,
                                        )
                                    } else if (!hasCustomIcon) {
                                        // Arrow animation
                                        const direction = 'right'
                                        const distance = 30
                                
                                        let xOut, yOut, xIn, yIn
                                
                                        switch (direction) {
                                            case 'top-right':
                                                xOut = distance * Math.cos((-45 * Math.PI) / 180)
                                                yOut = distance * Math.sin((-45 * Math.PI) / 180)
                                                xIn = -xOut
                                                yIn = -yOut
                                                break
                                            case 'bottom-right':
                                                xOut = distance * Math.cos((45 * Math.PI) / 180)
                                                yOut = distance * Math.sin((45 * Math.PI) / 180)
                                                xIn = -xOut
                                                yIn = -yOut
                                                break
                                            case 'left':
                                                xOut = -distance
                                                yOut = 0
                                                xIn = -xOut
                                                yIn = 0
                                                break
                                            default:
                                                xOut = distance
                                                yOut = 0
                                                xIn = -distance
                                                yIn = 0
                                        }
                                
                                        tl.to(
                                            icon, {
                                                keyframes: [
                                                    { x: xOut, y: yOut, duration: 0.23, ease: 'power2.in' },
                                                    { x: xIn, y: yIn, duration: 0 },
                                                    { x: 0, y: 0, duration: 0.23, ease: 'power2.out' },
                                                ],
                                            },
                                            0,
                                        )
                                    }
                                
                                    // Characters shine with stagger (only if not custom content)
                                    if (chars.length > 0) {
                                        tl.to(
                                            chars, {
                                                keyframes: {
                                                    opacity: [1, 0.4, 1],
                                                },
                                                duration: 0.15,
                                                ease: 'sine.inOut',
                                                stagger: 0.02,
                                            },
                                            0.1,
                                        )
                                    }
                                
                                    motion.hover(button, () => {
                                        tl.tweenTo(tl.duration())
                                
                                        return () => {
                                            tl.tweenTo(0)
                                        }
                                    })
                                }">
                                <a href="https://demo.filamentphp.com" target="_blank" rel="noopener noreferrer"
                                    aria-label="Launch the Filament demo application (opens in new window)"
                                    class="group inline-flex w-full items-center justify-between rounded-full font-medium whitespace-nowrap text-stone-900 transition duration-300 ease-out will-change-transform hover:scale-y-102 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset h-13 gap-2.5 pr-1.25 pl-5 bg-powder-400 hover:bg-powder-300 ">
                                    <span data-text class="grow">
                                        Launch demo
                                    </span>


                                    <div data-icon
                                        class="relative isolate grid shrink-0 place-items-center overflow-hidden rounded-full size-11 bg-stone-900 text-cream-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.25"
                                            style="transform: rotate(0deg)" viewBox="0 0 28 22" fill="none">
                                            <path class="fill-current"
                                                d="M1 10H5.96046e-08V12H1V10ZM27 12C27.5523 12 28 11.5523 28 11C28 10.4477 27.5523 10 27 10V12ZM18 1V5.96046e-08H16V1H18ZM26.4207 11.7774C26.9055 12.0419 27.5129 11.8632 27.7774 11.3783C28.0419 10.8935 27.8632 10.286 27.3783 10.0216L26.4207 11.7774ZM15.9999 20.8995V21.8995H17.9999V20.8995H15.9999ZM1 12H26.8994V10H1V12ZM26.8994 12H27V10H26.8994V12ZM16 1C16 2.47241 16.7953 3.87873 17.7716 5.0769C18.7678 6.29956 20.0716 7.44977 21.3383 8.42854C22.6109 9.41186 23.8784 10.2469 24.825 10.835C25.2993 11.1295 25.6952 11.3635 25.9738 11.5245C26.1131 11.605 26.2233 11.6674 26.2993 11.71C26.3374 11.7314 26.3669 11.7478 26.3873 11.7591C26.3975 11.7647 26.4055 11.7691 26.411 11.7721C26.4138 11.7737 26.416 11.7749 26.4176 11.7758C26.4184 11.7762 26.4191 11.7765 26.4196 11.7768C26.4199 11.777 26.4201 11.7771 26.4202 11.7772C26.4205 11.7773 26.4207 11.7774 26.8995 10.8995C27.3783 10.0216 27.3784 10.0217 27.3785 10.0217C27.3785 10.0217 27.3785 10.0217 27.3785 10.0217C27.3784 10.0216 27.3781 10.0215 27.3777 10.0213C27.3769 10.0208 27.3756 10.0201 27.3736 10.019C27.3697 10.0168 27.3634 10.0134 27.3549 10.0087C27.3378 9.99926 27.3118 9.98479 27.2773 9.96547C27.2084 9.92682 27.1058 9.86878 26.9745 9.79288C26.7117 9.64102 26.3342 9.41799 25.8804 9.13606C24.9708 8.57104 23.7635 7.77501 22.5612 6.84596C21.353 5.91235 20.182 4.86894 19.322 3.81356C18.4422 2.73371 18 1.77759 18 1H16ZM26.8994 11C26.5248 10.0728 26.5245 10.0729 26.5242 10.0731C26.524 10.0731 26.5237 10.0733 26.5234 10.0734C26.5228 10.0736 26.522 10.0739 26.5211 10.0743C26.5193 10.0751 26.5169 10.076 26.5138 10.0773C26.5078 10.0797 26.4994 10.0832 26.4888 10.0876C26.4674 10.0964 26.4369 10.1091 26.3979 10.1257C26.3199 10.1587 26.2077 10.2071 26.0662 10.2703C25.7834 10.3967 25.3826 10.5825 24.903 10.824C23.9463 11.3055 22.6639 12.0142 21.3751 12.919C20.0914 13.8201 18.7665 14.94 17.7546 16.2535C16.7415 17.5685 15.9999 19.1342 15.9999 20.8995H17.9999C17.9999 19.715 18.4958 18.5685 19.3389 17.4742C20.1831 16.3784 21.333 15.3922 22.5242 14.5559C23.7103 13.7232 24.9028 13.0632 25.8022 12.6104C26.2507 12.3846 26.6233 12.2119 26.8818 12.0965C27.011 12.0388 27.1115 11.9955 27.1785 11.967C27.212 11.9528 27.2371 11.9424 27.2533 11.9357C27.2613 11.9324 27.2671 11.93 27.2706 11.9286C27.2724 11.9279 27.2735 11.9274 27.2741 11.9271C27.2744 11.927 27.2745 11.927 27.2745 11.927C27.2745 11.927 27.2744 11.927 27.2744 11.927C27.2742 11.9271 27.274 11.9272 26.8994 11Z" />
                                        </svg>
                                    </div>
                                </a>
                            </div>
                        </nav>
                    </div>


                    <figure data-animate="enter-from-bottom" class="mt-12 grid">
                        <img src="https://filamentphp.com/build/assets/filament-v4-demo-dark-XPDJbSMg.webp"
                            alt="Screenshot of Filament v5 demo application showing the admin panel interface with dark theme"
                            loading="lazy" width="619" height="334"
                            class="relative z-3 self-center justify-self-center rounded-tl-lg rounded-tr-lg mask-b-from-50% [grid-area:1/-1]" />


                        <div aria-hidden="true"
                            class="relative -top-2 z-2 h-1/2 w-[95%] self-start justify-self-center rounded-tl-lg rounded-tr-lg bg-[#27272D]/70 [grid-area:1/-1]">
                        </div>


                        <div aria-hidden="true"
                            class="relative -top-4 z-1 h-1/2 w-[90%] self-start justify-self-center rounded-tl-lg rounded-tr-lg bg-[#27272D]/50 [grid-area:1/-1]">
                        </div>
                    </figure>
                </div>


                <aside class="flex flex-col">
                    <ul class="flex flex-col divide-y divide-bone-100 lg:grow"
                        aria-label="Community statistics and resources">
                        <li class="flex flex-col justify-between gap-5 px-8 py-8 xs:flex-row xs:items-center lg:grow lg:py-10"
                            aria-label="GitHub stars and link to star Filament on GitHub">
                            <div data-animate="enter-from-left" class="flex items-center gap-3 lg:gap-5">

                                <div class="inline-grid size-12 place-items-center" aria-hidden="true">
                                    <svg class="h-10 text-stone-800 [--stroke-width:7] lg:h-11"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 127 133"
                                        overflow="visible" fill="none">
                                        <path class="stroke-current [stroke-width:var(--stroke-width,10)]"
                                            d="M0.480469 71.73C0.480469 71.73 13.9205 76.31 18.0405 91.9C22.1605 107.49 27.5705 110.18 31.8505 112.36C34.6505 113.79 47.5905 117.46 57.7505 113.78" />
                                        <path class="stroke-current [stroke-width:var(--stroke-width,10)]"
                                            d="M103.18 132.95V106.13C103.18 93.54 92.9796 83.34 80.3896 83.34C67.7996 83.34 57.5996 93.54 57.5996 106.13V132.95" />
                                        <path class="stroke-current [stroke-width:var(--stroke-width,10)]"
                                            d="M64.75 22.65C68.38 21.04 74.02 20 80.36 20H80.35" />
                                        <path class="stroke-current [stroke-width:var(--stroke-width,10)]"
                                            d="M45.4302 30.98C45.4302 30.98 35.4802 34.08 35.4902 51.46V57.25C35.4902 71.66 47.1702 83.34 61.5802 83.34H80.3902" />
                                        <path class="stroke-current [stroke-width:var(--stroke-width,10)]"
                                            d="M40.0302 35.23C40.0302 35.23 29.4502 17.64 44.1802 1.57999C44.1802 1.57999 70.2802 4.67999 72.5502 21.33" />
                                        <path class="stroke-current [stroke-width:var(--stroke-width,10)]"
                                            d="M95.6295 22.65C91.9995 21.04 86.3595 20 80.0195 20H80.0295" />
                                        <path class="stroke-current [stroke-width:var(--stroke-width,10)]"
                                            d="M114.95 30.98C114.95 30.98 124.9 34.08 124.89 51.46V57.25C124.89 71.66 113.21 83.34 98.8002 83.34H79.9902" />
                                        <path class="stroke-current [stroke-width:var(--stroke-width,10)]"
                                            d="M120.35 35.23C120.35 35.23 130.93 17.64 116.2 1.57999C116.2 1.57999 90.1001 4.67999 87.8301 21.33" />
                                    </svg>
                                </div>


                                <div>
                                    <p class="text-xl font-bold text-stone-800 lg:text-2xl">
                                        31.4K+
                                    </p>
                                    <p class="lg:text-lg">GitHub stars</p>
                                </div>
                            </div>


                            <nav data-animate="enter-from-right">
                                <div x-data data-button-pulse class="rounded-full bg-cream-100"
                                    aria-label="Star Filament on GitHub (opens in new window)"
                                    x-init="async () => {
                                        await window.FilamentAnimations.waitForFonts()
                                    
                                        const button = $el.querySelector('a')
                                        const textWrapper = button.querySelector('[data-text]')
                                        const icon = button.querySelector('[data-icon] svg')
                                        const hasCustomIcon = false
                                        const hasCustomContent = false
                                        const animateIcon = true
                                    
                                        const tl = gsap.timeline({ paused: true })
                                    
                                        // Only animate text if not using custom content
                                        let chars = []
                                        if (!hasCustomContent && textWrapper) {
                                            const split = new SplitText(textWrapper, { type: 'chars' })
                                            chars = split.chars
                                        }
                                    
                                        if (hasCustomIcon && animateIcon) {
                                            // Custom icon animation: subtle scale and lift
                                            tl.to(
                                                icon, {
                                                    scale: 1.1,
                                                    rotation: 0.01,
                                                    duration: 0.3,
                                                    ease: 'sine.out',
                                                },
                                                0,
                                            )
                                        } else if (!hasCustomIcon) {
                                            // Arrow animation
                                            const direction = 'right'
                                            const distance = 30
                                    
                                            let xOut, yOut, xIn, yIn
                                    
                                            switch (direction) {
                                                case 'top-right':
                                                    xOut = distance * Math.cos((-45 * Math.PI) / 180)
                                                    yOut = distance * Math.sin((-45 * Math.PI) / 180)
                                                    xIn = -xOut
                                                    yIn = -yOut
                                                    break
                                                case 'bottom-right':
                                                    xOut = distance * Math.cos((45 * Math.PI) / 180)
                                                    yOut = distance * Math.sin((45 * Math.PI) / 180)
                                                    xIn = -xOut
                                                    yIn = -yOut
                                                    break
                                                case 'left':
                                                    xOut = -distance
                                                    yOut = 0
                                                    xIn = -xOut
                                                    yIn = 0
                                                    break
                                                default:
                                                    xOut = distance
                                                    yOut = 0
                                                    xIn = -distance
                                                    yIn = 0
                                            }
                                    
                                            tl.to(
                                                icon, {
                                                    keyframes: [
                                                        { x: xOut, y: yOut, duration: 0.23, ease: 'power2.in' },
                                                        { x: xIn, y: yIn, duration: 0 },
                                                        { x: 0, y: 0, duration: 0.23, ease: 'power2.out' },
                                                    ],
                                                },
                                                0,
                                            )
                                        }
                                    
                                        // Characters shine with stagger (only if not custom content)
                                        if (chars.length > 0) {
                                            tl.to(
                                                chars, {
                                                    keyframes: {
                                                        opacity: [1, 0.4, 1],
                                                    },
                                                    duration: 0.15,
                                                    ease: 'sine.inOut',
                                                    stagger: 0.02,
                                                },
                                                0.1,
                                            )
                                        }
                                    
                                        motion.hover(button, () => {
                                            tl.tweenTo(tl.duration())
                                    
                                            return () => {
                                                tl.tweenTo(0)
                                            }
                                        })
                                    }">
                                    <a href="https://github.com/filamentphp/filament" target="_blank"
                                        rel="noopener noreferrer"
                                        aria-label="Star Filament on GitHub (opens in new window)"
                                        class="group inline-flex w-full items-center justify-between rounded-full font-medium whitespace-nowrap text-stone-900 transition duration-300 ease-out will-change-transform hover:scale-y-102 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset h-13 gap-2.5 pr-1.25 pl-5 bg-cream-100 hover:bg-honey-100 w-full xs:w-40">
                                        <span data-text class="grow">
                                            Star us
                                            <span class="sr-only">on GitHub</span>
                                        </span>


                                        <div data-icon
                                            class="relative isolate grid shrink-0 place-items-center overflow-hidden rounded-full size-11 bg-serenade-50 text-stone-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.25"
                                                style="transform: rotate(0deg)" viewBox="0 0 28 22"
                                                fill="none">
                                                <path class="fill-current"
                                                    d="M1 10H5.96046e-08V12H1V10ZM27 12C27.5523 12 28 11.5523 28 11C28 10.4477 27.5523 10 27 10V12ZM18 1V5.96046e-08H16V1H18ZM26.4207 11.7774C26.9055 12.0419 27.5129 11.8632 27.7774 11.3783C28.0419 10.8935 27.8632 10.286 27.3783 10.0216L26.4207 11.7774ZM15.9999 20.8995V21.8995H17.9999V20.8995H15.9999ZM1 12H26.8994V10H1V12ZM26.8994 12H27V10H26.8994V12ZM16 1C16 2.47241 16.7953 3.87873 17.7716 5.0769C18.7678 6.29956 20.0716 7.44977 21.3383 8.42854C22.6109 9.41186 23.8784 10.2469 24.825 10.835C25.2993 11.1295 25.6952 11.3635 25.9738 11.5245C26.1131 11.605 26.2233 11.6674 26.2993 11.71C26.3374 11.7314 26.3669 11.7478 26.3873 11.7591C26.3975 11.7647 26.4055 11.7691 26.411 11.7721C26.4138 11.7737 26.416 11.7749 26.4176 11.7758C26.4184 11.7762 26.4191 11.7765 26.4196 11.7768C26.4199 11.777 26.4201 11.7771 26.4202 11.7772C26.4205 11.7773 26.4207 11.7774 26.8995 10.8995C27.3783 10.0216 27.3784 10.0217 27.3785 10.0217C27.3785 10.0217 27.3785 10.0217 27.3785 10.0217C27.3784 10.0216 27.3781 10.0215 27.3777 10.0213C27.3769 10.0208 27.3756 10.0201 27.3736 10.019C27.3697 10.0168 27.3634 10.0134 27.3549 10.0087C27.3378 9.99926 27.3118 9.98479 27.2773 9.96547C27.2084 9.92682 27.1058 9.86878 26.9745 9.79288C26.7117 9.64102 26.3342 9.41799 25.8804 9.13606C24.9708 8.57104 23.7635 7.77501 22.5612 6.84596C21.353 5.91235 20.182 4.86894 19.322 3.81356C18.4422 2.73371 18 1.77759 18 1H16ZM26.8994 11C26.5248 10.0728 26.5245 10.0729 26.5242 10.0731C26.524 10.0731 26.5237 10.0733 26.5234 10.0734C26.5228 10.0736 26.522 10.0739 26.5211 10.0743C26.5193 10.0751 26.5169 10.076 26.5138 10.0773C26.5078 10.0797 26.4994 10.0832 26.4888 10.0876C26.4674 10.0964 26.4369 10.1091 26.3979 10.1257C26.3199 10.1587 26.2077 10.2071 26.0662 10.2703C25.7834 10.3967 25.3826 10.5825 24.903 10.824C23.9463 11.3055 22.6639 12.0142 21.3751 12.919C20.0914 13.8201 18.7665 14.94 17.7546 16.2535C16.7415 17.5685 15.9999 19.1342 15.9999 20.8995H17.9999C17.9999 19.715 18.4958 18.5685 19.3389 17.4742C20.1831 16.3784 21.333 15.3922 22.5242 14.5559C23.7103 13.7232 24.9028 13.0632 25.8022 12.6104C26.2507 12.3846 26.6233 12.2119 26.8818 12.0965C27.011 12.0388 27.1115 11.9955 27.1785 11.967C27.212 11.9528 27.2371 11.9424 27.2533 11.9357C27.2613 11.9324 27.2671 11.93 27.2706 11.9286C27.2724 11.9279 27.2735 11.9274 27.2741 11.9271C27.2744 11.927 27.2745 11.927 27.2745 11.927C27.2745 11.927 27.2744 11.927 27.2744 11.927C27.2742 11.9271 27.274 11.9272 26.8994 11Z" />
                                            </svg>
                                        </div>
                                    </a>
                                </div>
                            </nav>
                        </li>
                        <li class="flex flex-col justify-between gap-5 px-8 py-8 xs:flex-row xs:items-center lg:grow lg:py-10"
                            aria-label="GitHub stars and link to star Filament on GitHub">
                            <div data-animate="enter-from-left" class="flex items-center gap-3 lg:gap-5">

                                <div class="inline-grid size-12 place-items-center" aria-hidden="true">
                                    <svg class="h-9 text-stone-800 [--stroke-width:6] lg:h-10 lg:[--stroke-width:7]"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 151 107" fill="none">
                                        <path class="stroke-current [stroke-width:var(--stroke-width,8)]"
                                            d="M60.0637 21.5798V13H36.5301L18 77.6812L60.0637 93L65.9349 76.3188" />
                                        <path class="stroke-current [stroke-width:var(--stroke-width,8)]"
                                            d="M89.9877 21.5798V13H113.521L132.043 77.6812L89.9877 93L84.1084 76.3188" />
                                        <path class="stroke-current [stroke-width:var(--stroke-width,8)]"
                                            d="M100.157 73.2778C94.3831 75.8404 85.3978 77.4866 75.3096 77.4866H75.3259C65.2377 77.4866 56.2606 75.8404 50.4785 73.2778" />
                                        <path class="stroke-current [stroke-width:var(--stroke-width,8)]"
                                            d="M50.4863 24.7345C56.2603 22.1719 65.2455 20.5256 75.3337 20.5256H75.3175C85.4056 20.5256 94.3828 22.1719 100.165 24.7345" />
                                        <path class="fill-current"
                                            d="M58.5061 60.8784C61.3814 60.8784 63.7123 58.5475 63.7123 55.6721C63.7123 52.7968 61.3814 50.4658 58.5061 50.4658C55.6307 50.4658 53.2998 52.7968 53.2998 55.6721C53.2998 58.5475 55.6307 60.8784 58.5061 60.8784Z" />
                                        <path class="fill-current"
                                            d="M92.3645 60.8784C95.2398 60.8784 97.5707 58.5475 97.5707 55.6721C97.5707 52.7968 95.2398 50.4658 92.3645 50.4658C89.4891 50.4658 87.1582 52.7968 87.1582 55.6721C87.1582 58.5475 89.4891 60.8784 92.3645 60.8784Z" />
                                    </svg>
                                </div>


                                <div>
                                    <p class="text-xl font-bold text-stone-800 lg:text-2xl">
                                        19.6K+
                                    </p>
                                    <p class="lg:text-lg">Discord members</p>
                                </div>
                            </div>


                            <nav data-animate="enter-from-right">
                                <div x-data data-button-pulse class="rounded-full bg-cream-100"
                                    aria-label="Join Filament Discord community (opens in new window)"
                                    x-init="async () => {
                                        await window.FilamentAnimations.waitForFonts()
                                    
                                        const button = $el.querySelector('a')
                                        const textWrapper = button.querySelector('[data-text]')
                                        const icon = button.querySelector('[data-icon] svg')
                                        const hasCustomIcon = false
                                        const hasCustomContent = false
                                        const animateIcon = true
                                    
                                        const tl = gsap.timeline({ paused: true })
                                    
                                        // Only animate text if not using custom content
                                        let chars = []
                                        if (!hasCustomContent && textWrapper) {
                                            const split = new SplitText(textWrapper, { type: 'chars' })
                                            chars = split.chars
                                        }
                                    
                                        if (hasCustomIcon && animateIcon) {
                                            // Custom icon animation: subtle scale and lift
                                            tl.to(
                                                icon, {
                                                    scale: 1.1,
                                                    rotation: 0.01,
                                                    duration: 0.3,
                                                    ease: 'sine.out',
                                                },
                                                0,
                                            )
                                        } else if (!hasCustomIcon) {
                                            // Arrow animation
                                            const direction = 'right'
                                            const distance = 30
                                    
                                            let xOut, yOut, xIn, yIn
                                    
                                            switch (direction) {
                                                case 'top-right':
                                                    xOut = distance * Math.cos((-45 * Math.PI) / 180)
                                                    yOut = distance * Math.sin((-45 * Math.PI) / 180)
                                                    xIn = -xOut
                                                    yIn = -yOut
                                                    break
                                                case 'bottom-right':
                                                    xOut = distance * Math.cos((45 * Math.PI) / 180)
                                                    yOut = distance * Math.sin((45 * Math.PI) / 180)
                                                    xIn = -xOut
                                                    yIn = -yOut
                                                    break
                                                case 'left':
                                                    xOut = -distance
                                                    yOut = 0
                                                    xIn = -xOut
                                                    yIn = 0
                                                    break
                                                default:
                                                    xOut = distance
                                                    yOut = 0
                                                    xIn = -distance
                                                    yIn = 0
                                            }
                                    
                                            tl.to(
                                                icon, {
                                                    keyframes: [
                                                        { x: xOut, y: yOut, duration: 0.23, ease: 'power2.in' },
                                                        { x: xIn, y: yIn, duration: 0 },
                                                        { x: 0, y: 0, duration: 0.23, ease: 'power2.out' },
                                                    ],
                                                },
                                                0,
                                            )
                                        }
                                    
                                        // Characters shine with stagger (only if not custom content)
                                        if (chars.length > 0) {
                                            tl.to(
                                                chars, {
                                                    keyframes: {
                                                        opacity: [1, 0.4, 1],
                                                    },
                                                    duration: 0.15,
                                                    ease: 'sine.inOut',
                                                    stagger: 0.02,
                                                },
                                                0.1,
                                            )
                                        }
                                    
                                        motion.hover(button, () => {
                                            tl.tweenTo(tl.duration())
                                    
                                            return () => {
                                                tl.tweenTo(0)
                                            }
                                        })
                                    }">
                                    <a href="https://filamentphp.com/discord" target="_blank"
                                        rel="noopener noreferrer"
                                        aria-label="Join Filament Discord community (opens in new window)"
                                        class="group inline-flex w-full items-center justify-between rounded-full font-medium whitespace-nowrap text-stone-900 transition duration-300 ease-out will-change-transform hover:scale-y-102 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset h-13 gap-2.5 pr-1.25 pl-5 bg-cream-100 hover:bg-honey-100 w-full xs:w-40">
                                        <span data-text class="grow">
                                            Join us
                                            <span class="sr-only">on Discord</span>
                                        </span>


                                        <div data-icon
                                            class="relative isolate grid shrink-0 place-items-center overflow-hidden rounded-full size-11 bg-serenade-50 text-stone-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.25"
                                                style="transform: rotate(0deg)" viewBox="0 0 28 22"
                                                fill="none">
                                                <path class="fill-current"
                                                    d="M1 10H5.96046e-08V12H1V10ZM27 12C27.5523 12 28 11.5523 28 11C28 10.4477 27.5523 10 27 10V12ZM18 1V5.96046e-08H16V1H18ZM26.4207 11.7774C26.9055 12.0419 27.5129 11.8632 27.7774 11.3783C28.0419 10.8935 27.8632 10.286 27.3783 10.0216L26.4207 11.7774ZM15.9999 20.8995V21.8995H17.9999V20.8995H15.9999ZM1 12H26.8994V10H1V12ZM26.8994 12H27V10H26.8994V12ZM16 1C16 2.47241 16.7953 3.87873 17.7716 5.0769C18.7678 6.29956 20.0716 7.44977 21.3383 8.42854C22.6109 9.41186 23.8784 10.2469 24.825 10.835C25.2993 11.1295 25.6952 11.3635 25.9738 11.5245C26.1131 11.605 26.2233 11.6674 26.2993 11.71C26.3374 11.7314 26.3669 11.7478 26.3873 11.7591C26.3975 11.7647 26.4055 11.7691 26.411 11.7721C26.4138 11.7737 26.416 11.7749 26.4176 11.7758C26.4184 11.7762 26.4191 11.7765 26.4196 11.7768C26.4199 11.777 26.4201 11.7771 26.4202 11.7772C26.4205 11.7773 26.4207 11.7774 26.8995 10.8995C27.3783 10.0216 27.3784 10.0217 27.3785 10.0217C27.3785 10.0217 27.3785 10.0217 27.3785 10.0217C27.3784 10.0216 27.3781 10.0215 27.3777 10.0213C27.3769 10.0208 27.3756 10.0201 27.3736 10.019C27.3697 10.0168 27.3634 10.0134 27.3549 10.0087C27.3378 9.99926 27.3118 9.98479 27.2773 9.96547C27.2084 9.92682 27.1058 9.86878 26.9745 9.79288C26.7117 9.64102 26.3342 9.41799 25.8804 9.13606C24.9708 8.57104 23.7635 7.77501 22.5612 6.84596C21.353 5.91235 20.182 4.86894 19.322 3.81356C18.4422 2.73371 18 1.77759 18 1H16ZM26.8994 11C26.5248 10.0728 26.5245 10.0729 26.5242 10.0731C26.524 10.0731 26.5237 10.0733 26.5234 10.0734C26.5228 10.0736 26.522 10.0739 26.5211 10.0743C26.5193 10.0751 26.5169 10.076 26.5138 10.0773C26.5078 10.0797 26.4994 10.0832 26.4888 10.0876C26.4674 10.0964 26.4369 10.1091 26.3979 10.1257C26.3199 10.1587 26.2077 10.2071 26.0662 10.2703C25.7834 10.3967 25.3826 10.5825 24.903 10.824C23.9463 11.3055 22.6639 12.0142 21.3751 12.919C20.0914 13.8201 18.7665 14.94 17.7546 16.2535C16.7415 17.5685 15.9999 19.1342 15.9999 20.8995H17.9999C17.9999 19.715 18.4958 18.5685 19.3389 17.4742C20.1831 16.3784 21.333 15.3922 22.5242 14.5559C23.7103 13.7232 24.9028 13.0632 25.8022 12.6104C26.2507 12.3846 26.6233 12.2119 26.8818 12.0965C27.011 12.0388 27.1115 11.9955 27.1785 11.967C27.212 11.9528 27.2371 11.9424 27.2533 11.9357C27.2613 11.9324 27.2671 11.93 27.2706 11.9286C27.2724 11.9279 27.2735 11.9274 27.2741 11.9271C27.2744 11.927 27.2745 11.927 27.2745 11.927C27.2745 11.927 27.2744 11.927 27.2744 11.927C27.2742 11.9271 27.274 11.9272 26.8994 11Z" />
                                            </svg>
                                        </div>
                                    </a>
                                </div>
                            </nav>
                        </li>
                        <li class="flex flex-col justify-between gap-5 px-8 py-8 xs:flex-row xs:items-center lg:grow lg:py-10"
                            aria-label="Filament download count across all packages and link to documentation">
                            <div data-animate="enter-from-left" class="flex items-center gap-3 lg:gap-5">

                                <div class="inline-grid size-12 place-items-center" aria-hidden="true">
                                    <svg class="h-7 text-stone-800 [--stroke-width:8] lg:h-8 lg:[--stroke-width:9]"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 154 116"
                                        overflow="visible" fill="none">
                                        <path class="stroke-current [stroke-width:var(--stroke-width,10)]"
                                            d="M56.31 107.28C51.67 109.24 46.58 110.33 41.22 110.33C19.81 110.33 2.45996 92.98 2.45996 71.57C2.45996 50.16 19.81 32.81 41.22 32.81C43.9 32.81 46.51 33.08 49.03 33.6" />
                                        <path class="stroke-current [stroke-width:var(--stroke-width,10)]"
                                            d="M44.5195 55.29C44.5195 25.99 68.2695 2.22998 97.5795 2.22998C126.89 2.22998 150.64 25.98 150.64 55.29C150.64 68.43 145.86 80.45 137.95 89.72" />
                                        <path class="stroke-current [stroke-width:var(--stroke-width,10)]"
                                            d="M94.6104 56.36V107.28" />
                                        <path class="stroke-current [stroke-width:var(--stroke-width,10)]"
                                            d="M118.04 91.21C118.04 91.21 94.6202 93.04 94.7702 114.79" />
                                        <path class="stroke-current [stroke-width:var(--stroke-width,10)]"
                                            d="M71.1904 91.53C71.1904 91.53 94.6304 93.05 94.7704 114.8" />
                                    </svg>
                                </div>


                                <div>
                                    <p class="text-xl font-bold text-stone-800 lg:text-2xl">
                                        30.7M+
                                    </p>
                                    <p class="lg:text-lg">Downloads</p>
                                </div>
                            </div>


                            <nav data-animate="enter-from-right">
                                <div x-data data-button-pulse class="rounded-full bg-cream-100"
                                    aria-label="View Filament documentation (opens in new window)"
                                    x-init="async () => {
                                        await window.FilamentAnimations.waitForFonts()
                                    
                                        const button = $el.querySelector('a')
                                        const textWrapper = button.querySelector('[data-text]')
                                        const icon = button.querySelector('[data-icon] svg')
                                        const hasCustomIcon = false
                                        const hasCustomContent = false
                                        const animateIcon = true
                                    
                                        const tl = gsap.timeline({ paused: true })
                                    
                                        // Only animate text if not using custom content
                                        let chars = []
                                        if (!hasCustomContent && textWrapper) {
                                            const split = new SplitText(textWrapper, { type: 'chars' })
                                            chars = split.chars
                                        }
                                    
                                        if (hasCustomIcon && animateIcon) {
                                            // Custom icon animation: subtle scale and lift
                                            tl.to(
                                                icon, {
                                                    scale: 1.1,
                                                    rotation: 0.01,
                                                    duration: 0.3,
                                                    ease: 'sine.out',
                                                },
                                                0,
                                            )
                                        } else if (!hasCustomIcon) {
                                            // Arrow animation
                                            const direction = 'right'
                                            const distance = 30
                                    
                                            let xOut, yOut, xIn, yIn
                                    
                                            switch (direction) {
                                                case 'top-right':
                                                    xOut = distance * Math.cos((-45 * Math.PI) / 180)
                                                    yOut = distance * Math.sin((-45 * Math.PI) / 180)
                                                    xIn = -xOut
                                                    yIn = -yOut
                                                    break
                                                case 'bottom-right':
                                                    xOut = distance * Math.cos((45 * Math.PI) / 180)
                                                    yOut = distance * Math.sin((45 * Math.PI) / 180)
                                                    xIn = -xOut
                                                    yIn = -yOut
                                                    break
                                                case 'left':
                                                    xOut = -distance
                                                    yOut = 0
                                                    xIn = -xOut
                                                    yIn = 0
                                                    break
                                                default:
                                                    xOut = distance
                                                    yOut = 0
                                                    xIn = -distance
                                                    yIn = 0
                                            }
                                    
                                            tl.to(
                                                icon, {
                                                    keyframes: [
                                                        { x: xOut, y: yOut, duration: 0.23, ease: 'power2.in' },
                                                        { x: xIn, y: yIn, duration: 0 },
                                                        { x: 0, y: 0, duration: 0.23, ease: 'power2.out' },
                                                    ],
                                                },
                                                0,
                                            )
                                        }
                                    
                                        // Characters shine with stagger (only if not custom content)
                                        if (chars.length > 0) {
                                            tl.to(
                                                chars, {
                                                    keyframes: {
                                                        opacity: [1, 0.4, 1],
                                                    },
                                                    duration: 0.15,
                                                    ease: 'sine.inOut',
                                                    stagger: 0.02,
                                                },
                                                0.1,
                                            )
                                        }
                                    
                                        motion.hover(button, () => {
                                            tl.tweenTo(tl.duration())
                                    
                                            return () => {
                                                tl.tweenTo(0)
                                            }
                                        })
                                    }">
                                    <a href="/docs" target="_blank" rel="noopener noreferrer"
                                        aria-label="View Filament documentation (opens in new window)"
                                        class="group inline-flex w-full items-center justify-between rounded-full font-medium whitespace-nowrap text-stone-900 transition duration-300 ease-out will-change-transform hover:scale-y-102 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset h-13 gap-2.5 pr-1.25 pl-5 bg-cream-100 hover:bg-honey-100 w-full xs:w-40">
                                        <span data-text class="grow">
                                            Docs
                                            <span class="sr-only">- View documentation</span>
                                        </span>


                                        <div data-icon
                                            class="relative isolate grid shrink-0 place-items-center overflow-hidden rounded-full size-11 bg-serenade-50 text-stone-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.25"
                                                style="transform: rotate(0deg)" viewBox="0 0 28 22"
                                                fill="none">
                                                <path class="fill-current"
                                                    d="M1 10H5.96046e-08V12H1V10ZM27 12C27.5523 12 28 11.5523 28 11C28 10.4477 27.5523 10 27 10V12ZM18 1V5.96046e-08H16V1H18ZM26.4207 11.7774C26.9055 12.0419 27.5129 11.8632 27.7774 11.3783C28.0419 10.8935 27.8632 10.286 27.3783 10.0216L26.4207 11.7774ZM15.9999 20.8995V21.8995H17.9999V20.8995H15.9999ZM1 12H26.8994V10H1V12ZM26.8994 12H27V10H26.8994V12ZM16 1C16 2.47241 16.7953 3.87873 17.7716 5.0769C18.7678 6.29956 20.0716 7.44977 21.3383 8.42854C22.6109 9.41186 23.8784 10.2469 24.825 10.835C25.2993 11.1295 25.6952 11.3635 25.9738 11.5245C26.1131 11.605 26.2233 11.6674 26.2993 11.71C26.3374 11.7314 26.3669 11.7478 26.3873 11.7591C26.3975 11.7647 26.4055 11.7691 26.411 11.7721C26.4138 11.7737 26.416 11.7749 26.4176 11.7758C26.4184 11.7762 26.4191 11.7765 26.4196 11.7768C26.4199 11.777 26.4201 11.7771 26.4202 11.7772C26.4205 11.7773 26.4207 11.7774 26.8995 10.8995C27.3783 10.0216 27.3784 10.0217 27.3785 10.0217C27.3785 10.0217 27.3785 10.0217 27.3785 10.0217C27.3784 10.0216 27.3781 10.0215 27.3777 10.0213C27.3769 10.0208 27.3756 10.0201 27.3736 10.019C27.3697 10.0168 27.3634 10.0134 27.3549 10.0087C27.3378 9.99926 27.3118 9.98479 27.2773 9.96547C27.2084 9.92682 27.1058 9.86878 26.9745 9.79288C26.7117 9.64102 26.3342 9.41799 25.8804 9.13606C24.9708 8.57104 23.7635 7.77501 22.5612 6.84596C21.353 5.91235 20.182 4.86894 19.322 3.81356C18.4422 2.73371 18 1.77759 18 1H16ZM26.8994 11C26.5248 10.0728 26.5245 10.0729 26.5242 10.0731C26.524 10.0731 26.5237 10.0733 26.5234 10.0734C26.5228 10.0736 26.522 10.0739 26.5211 10.0743C26.5193 10.0751 26.5169 10.076 26.5138 10.0773C26.5078 10.0797 26.4994 10.0832 26.4888 10.0876C26.4674 10.0964 26.4369 10.1091 26.3979 10.1257C26.3199 10.1587 26.2077 10.2071 26.0662 10.2703C25.7834 10.3967 25.3826 10.5825 24.903 10.824C23.9463 11.3055 22.6639 12.0142 21.3751 12.919C20.0914 13.8201 18.7665 14.94 17.7546 16.2535C16.7415 17.5685 15.9999 19.1342 15.9999 20.8995H17.9999C17.9999 19.715 18.4958 18.5685 19.3389 17.4742C20.1831 16.3784 21.333 15.3922 22.5242 14.5559C23.7103 13.7232 24.9028 13.0632 25.8022 12.6104C26.2507 12.3846 26.6233 12.2119 26.8818 12.0965C27.011 12.0388 27.1115 11.9955 27.1785 11.967C27.212 11.9528 27.2371 11.9424 27.2533 11.9357C27.2613 11.9324 27.2671 11.93 27.2706 11.9286C27.2724 11.9279 27.2735 11.9274 27.2741 11.9271C27.2744 11.927 27.2745 11.927 27.2745 11.927C27.2745 11.927 27.2744 11.927 27.2744 11.927C27.2742 11.9271 27.274 11.9272 26.8994 11Z" />
                                            </svg>
                                        </div>
                                    </a>
                                </div>
                            </nav>
                        </li>
                        <li class="flex flex-col justify-between gap-5 px-8 py-8 xs:flex-row xs:items-center lg:grow lg:py-10"
                            aria-label="Filament community plugins count and link to browse plugins">
                            <div data-animate="enter-from-left" class="flex items-center gap-3 lg:gap-5">

                                <div class="inline-grid size-12 place-items-center" aria-hidden="true">
                                    <svg class="h-8 text-stone-800 [--stroke-width:8] lg:h-9 lg:[--stroke-width:9]"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 133 133"
                                        overflow="visible" fill="none">
                                        <path class="stroke-current [stroke-width:var(--stroke-width,10)]"
                                            d="M128.88 3.19995H93.3902C95.7502 6.06995 97.1702 9.73995 97.1702 13.75C97.1702 22.92 89.7302 30.36 80.5602 30.36C71.3902 30.36 63.9502 22.92 63.9502 13.75C63.9502 9.73995 65.3702 6.06995 67.7302 3.19995H31.9802V40.7C28.9502 37.43 24.6202 35.3899 19.8102 35.3899C10.6402 35.3899 3.2002 42.83 3.2002 52C3.2002 61.17 10.6402 68.61 19.8102 68.61C24.6202 68.61 28.9502 66.5599 31.9802 63.2999V100.1H69.2702C65.9202 103.14 63.8202 107.53 63.8202 112.4C63.8202 121.57 71.2602 129.01 80.4302 129.01C89.6002 129.01 97.0402 121.57 97.0402 112.4C97.0402 107.52 94.9402 103.13 91.5902 100.1H128.88V3.19995Z" />
                                    </svg>
                                </div>


                                <div>
                                    <p class="text-xl font-bold text-stone-800 lg:text-2xl">
                                        909+
                                    </p>
                                    <p class="lg:text-lg">Community plugins</p>
                                </div>
                            </div>


                            <nav data-animate="enter-from-right">
                                <div x-data data-button-pulse class="rounded-full bg-cream-100"
                                    aria-label="Browse Filament community plugins" x-init="async () => {
                                        await window.FilamentAnimations.waitForFonts()
                                    
                                        const button = $el.querySelector('a')
                                        const textWrapper = button.querySelector('[data-text]')
                                        const icon = button.querySelector('[data-icon] svg')
                                        const hasCustomIcon = false
                                        const hasCustomContent = false
                                        const animateIcon = true
                                    
                                        const tl = gsap.timeline({ paused: true })
                                    
                                        // Only animate text if not using custom content
                                        let chars = []
                                        if (!hasCustomContent && textWrapper) {
                                            const split = new SplitText(textWrapper, { type: 'chars' })
                                            chars = split.chars
                                        }
                                    
                                        if (hasCustomIcon && animateIcon) {
                                            // Custom icon animation: subtle scale and lift
                                            tl.to(
                                                icon, {
                                                    scale: 1.1,
                                                    rotation: 0.01,
                                                    duration: 0.3,
                                                    ease: 'sine.out',
                                                },
                                                0,
                                            )
                                        } else if (!hasCustomIcon) {
                                            // Arrow animation
                                            const direction = 'right'
                                            const distance = 30
                                    
                                            let xOut, yOut, xIn, yIn
                                    
                                            switch (direction) {
                                                case 'top-right':
                                                    xOut = distance * Math.cos((-45 * Math.PI) / 180)
                                                    yOut = distance * Math.sin((-45 * Math.PI) / 180)
                                                    xIn = -xOut
                                                    yIn = -yOut
                                                    break
                                                case 'bottom-right':
                                                    xOut = distance * Math.cos((45 * Math.PI) / 180)
                                                    yOut = distance * Math.sin((45 * Math.PI) / 180)
                                                    xIn = -xOut
                                                    yIn = -yOut
                                                    break
                                                case 'left':
                                                    xOut = -distance
                                                    yOut = 0
                                                    xIn = -xOut
                                                    yIn = 0
                                                    break
                                                default:
                                                    xOut = distance
                                                    yOut = 0
                                                    xIn = -distance
                                                    yIn = 0
                                            }
                                    
                                            tl.to(
                                                icon, {
                                                    keyframes: [
                                                        { x: xOut, y: yOut, duration: 0.23, ease: 'power2.in' },
                                                        { x: xIn, y: yIn, duration: 0 },
                                                        { x: 0, y: 0, duration: 0.23, ease: 'power2.out' },
                                                    ],
                                                },
                                                0,
                                            )
                                        }
                                    
                                        // Characters shine with stagger (only if not custom content)
                                        if (chars.length > 0) {
                                            tl.to(
                                                chars, {
                                                    keyframes: {
                                                        opacity: [1, 0.4, 1],
                                                    },
                                                    duration: 0.15,
                                                    ease: 'sine.inOut',
                                                    stagger: 0.02,
                                                },
                                                0.1,
                                            )
                                        }
                                    
                                        motion.hover(button, () => {
                                            tl.tweenTo(tl.duration())
                                    
                                            return () => {
                                                tl.tweenTo(0)
                                            }
                                        })
                                    }">
                                    <a href="https://filamentphp.com/plugins"
                                        aria-label="Browse Filament community plugins"
                                        class="group inline-flex w-full items-center justify-between rounded-full font-medium whitespace-nowrap text-stone-900 transition duration-300 ease-out will-change-transform hover:scale-y-102 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset h-13 gap-2.5 pr-1.25 pl-5 bg-cream-100 hover:bg-honey-100 w-full xs:w-40">
                                        <span data-text class="grow">
                                            Plugins
                                            <span class="sr-only">- Browse plugins</span>
                                        </span>


                                        <div data-icon
                                            class="relative isolate grid shrink-0 place-items-center overflow-hidden rounded-full size-11 bg-serenade-50 text-stone-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.25"
                                                style="transform: rotate(0deg)" viewBox="0 0 28 22"
                                                fill="none">
                                                <path class="fill-current"
                                                    d="M1 10H5.96046e-08V12H1V10ZM27 12C27.5523 12 28 11.5523 28 11C28 10.4477 27.5523 10 27 10V12ZM18 1V5.96046e-08H16V1H18ZM26.4207 11.7774C26.9055 12.0419 27.5129 11.8632 27.7774 11.3783C28.0419 10.8935 27.8632 10.286 27.3783 10.0216L26.4207 11.7774ZM15.9999 20.8995V21.8995H17.9999V20.8995H15.9999ZM1 12H26.8994V10H1V12ZM26.8994 12H27V10H26.8994V12ZM16 1C16 2.47241 16.7953 3.87873 17.7716 5.0769C18.7678 6.29956 20.0716 7.44977 21.3383 8.42854C22.6109 9.41186 23.8784 10.2469 24.825 10.835C25.2993 11.1295 25.6952 11.3635 25.9738 11.5245C26.1131 11.605 26.2233 11.6674 26.2993 11.71C26.3374 11.7314 26.3669 11.7478 26.3873 11.7591C26.3975 11.7647 26.4055 11.7691 26.411 11.7721C26.4138 11.7737 26.416 11.7749 26.4176 11.7758C26.4184 11.7762 26.4191 11.7765 26.4196 11.7768C26.4199 11.777 26.4201 11.7771 26.4202 11.7772C26.4205 11.7773 26.4207 11.7774 26.8995 10.8995C27.3783 10.0216 27.3784 10.0217 27.3785 10.0217C27.3785 10.0217 27.3785 10.0217 27.3785 10.0217C27.3784 10.0216 27.3781 10.0215 27.3777 10.0213C27.3769 10.0208 27.3756 10.0201 27.3736 10.019C27.3697 10.0168 27.3634 10.0134 27.3549 10.0087C27.3378 9.99926 27.3118 9.98479 27.2773 9.96547C27.2084 9.92682 27.1058 9.86878 26.9745 9.79288C26.7117 9.64102 26.3342 9.41799 25.8804 9.13606C24.9708 8.57104 23.7635 7.77501 22.5612 6.84596C21.353 5.91235 20.182 4.86894 19.322 3.81356C18.4422 2.73371 18 1.77759 18 1H16ZM26.8994 11C26.5248 10.0728 26.5245 10.0729 26.5242 10.0731C26.524 10.0731 26.5237 10.0733 26.5234 10.0734C26.5228 10.0736 26.522 10.0739 26.5211 10.0743C26.5193 10.0751 26.5169 10.076 26.5138 10.0773C26.5078 10.0797 26.4994 10.0832 26.4888 10.0876C26.4674 10.0964 26.4369 10.1091 26.3979 10.1257C26.3199 10.1587 26.2077 10.2071 26.0662 10.2703C25.7834 10.3967 25.3826 10.5825 24.903 10.824C23.9463 11.3055 22.6639 12.0142 21.3751 12.919C20.0914 13.8201 18.7665 14.94 17.7546 16.2535C16.7415 17.5685 15.9999 19.1342 15.9999 20.8995H17.9999C17.9999 19.715 18.4958 18.5685 19.3389 17.4742C20.1831 16.3784 21.333 15.3922 22.5242 14.5559C23.7103 13.7232 24.9028 13.0632 25.8022 12.6104C26.2507 12.3846 26.6233 12.2119 26.8818 12.0965C27.011 12.0388 27.1115 11.9955 27.1785 11.967C27.212 11.9528 27.2371 11.9424 27.2533 11.9357C27.2613 11.9324 27.2671 11.93 27.2706 11.9286C27.2724 11.9279 27.2735 11.9274 27.2741 11.9271C27.2744 11.927 27.2745 11.927 27.2745 11.927C27.2745 11.927 27.2744 11.927 27.2744 11.927C27.2742 11.9271 27.274 11.9272 26.8994 11Z" />
                                            </svg>
                                        </div>
                                    </a>
                                </div>
                            </nav>
                        </li>
                    </ul>
                </aside>
            </section>


            <section data-triangle-decoration="bottom"
                class="border-b border-bone-100 px-8 py-10 sm:px-10 sm:py-15 lg:px-15 lg:py-20 xl:pt-30">
                <div
                    class="flex flex-col gap-x-10 gap-y-45 2xs:gap-y-40 md:gap-y-30 xl:flex-row xl:items-center xl:justify-between">

                    <header class="flex flex-col justify-center xl:-mt-20">
                        <p data-animate="text-reveal-lines"
                            class="mb-1 font-outfit text-2xl font-medium text-stone-800 md:mb-2 md:text-3xl">
                            Powered by the
                        </p>
                        <h1 data-animate="text-reveal-lines">TALL Stack</h1>
                        <div data-animate="enter-from-left" aria-hidden="true"
                            class="my-3 text-stone-400 md:my-6">
                            /tɔːl stæk/
                        </div>
                        <p data-section-description data-animate="text-reveal-words"
                            class="@min-[1100px]:max-w-135">
                            A proven stack that lets you build
                            <strong>dynamic, maintainable</strong>
                            full-stack applications without unnecessary complexity.
                        </p>
                    </header>


                    <div x-data="{ hoveredLayer: null }" x-init="() => {
                        const tailwindCallout = $refs.tailwindCallout
                        const alpineCallout = $refs.alpineCallout
                        const livewireCallout = $refs.livewireCallout
                        const laravelCallout = $refs.laravelCallout
                    
                        const tailwindLayer = $refs.tailwindLayer
                        const alpineLayer = $refs.alpineLayer
                        const livewireLayer = $refs.livewireLayer
                        const laravelLayer = $refs.laravelLayer
                    
                        const atlas = $refs.atlas
                        const atlasCallout = $refs.atlasCallout
                        const grid = $refs.grid
                    
                        gsap.set(
                            [tailwindCallout, alpineCallout, livewireCallout, laravelCallout], {
                                x: -20,
                                opacity: 0,
                            },
                        )
                    
                        gsap.set(atlas, {
                            x: 20,
                            opacity: 0,
                        })
                    
                        gsap.set(atlasCallout, {
                            y: -20,
                            opacity: 0,
                        })
                    
                        gsap.set(grid, {
                            y: 20,
                            opacity: 0,
                            scale: 1.1,
                        })
                    
                        gsap.set([tailwindLayer, alpineLayer], {
                            y: -20,
                            opacity: 0,
                        })
                    
                        gsap.set([livewireLayer, laravelLayer], {
                            y: 20,
                            opacity: 0,
                        })
                    
                        const tl = gsap.timeline({ paused: true })
                    
                        tl.to([tailwindLayer, alpineLayer], {
                            y: 0,
                            opacity: 1,
                            stagger: 0.1,
                            duration: 0.6,
                            ease: 'sine.out',
                        })
                    
                        tl.to(
                            [livewireLayer, laravelLayer], {
                                y: 0,
                                opacity: 1,
                                stagger: 0.1,
                                duration: 0.6,
                                ease: 'sine.out',
                            },
                            '<',
                        )
                    
                        tl.to(
                            atlas, {
                                x: 0,
                                opacity: 1,
                                duration: 0.6,
                                ease: 'sine.out',
                            },
                            '<',
                        )
                    
                        tl.to(
                            atlasCallout, {
                                y: 0,
                                opacity: 1,
                                duration: 0.6,
                                ease: 'sine.out',
                            },
                            '<',
                        )
                    
                        tl.to(
                            grid, {
                                y: 0,
                                scale: 1,
                                opacity: 1,
                                duration: 0.6,
                                ease: 'sine.out',
                            },
                            '<',
                        )
                    
                        tl.to(
                            [tailwindCallout, alpineCallout, livewireCallout, laravelCallout], {
                                x: 0,
                                opacity: 1,
                                stagger: 0.1,
                                duration: 0.6,
                                ease: 'sine.out',
                            },
                            '<0.2',
                        )
                    
                        // Remove inline styles GSAP wrote after the entrance animation
                        // so Tailwind's class-based transforms/transitions work on hover.
                        // Use specific properties to preserve clip-path on layer elements.
                        tl.call(() => {
                            gsap.set(
                                [
                                    tailwindLayer,
                                    alpineLayer,
                                    livewireLayer,
                                    laravelLayer,
                                    tailwindCallout,
                                    alpineCallout,
                                    livewireCallout,
                                    laravelCallout,
                                    atlas,
                                    atlasCallout,
                                    grid,
                                ], { clearProps: 'transform,opacity' },
                            )
                        })
                    
                        motion.inView(
                            $el,
                            () => {
                                tl.play()
                            }, { once: true },
                        )
                    }"
                        class="inline-grid shrink-0 self-center pt-10 2xs:pb-5 sm:pl-10 md:pr-10 md:pl-20 lg:px-30">

                        <div x-ref="atlasCallout"
                            class="relative -top-45 left-0 z-7 flex flex-col items-end gap-3 justify-self-end [grid-area:1/-1] 2xs:-top-40 2xs:left-3 2xs:self-start xs:-top-45 xs:left-5 xs:items-start md:top-0 md:left-25 lg:top-6 lg:left-35">
                            <p class="flex flex-col gap-1 text-center text-sm lg:flex-row">
                                <span>Almost as TALL as</span>
                                <span class="font-medium text-stone-700">Atlas</span>
                            </p>
                            <svg aria-hidden="true" class="w-8 -scale-x-100 xs:scale-x-100"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 31 36" fill="none">
                                <path class="stroke-current [stroke-width:var(--stroke-width,1)]"
                                    d="M30.0128 11.3789C30.0128 11.3789 25.472 5.50653 30.6876 0.992188" />
                                <path class="stroke-current [stroke-width:var(--stroke-width,1)]"
                                    d="M20.125 0.331787C20.125 0.331787 25.473 5.50654 30.6885 0.995296" />
                                <path class="stroke-current [stroke-width:var(--stroke-width,1)]"
                                    d="M28.9319 2.60767C28.9319 2.60767 17.7724 8.3126 16.0255 18.4389C14.4614 27.4985 19.4657 25.5111 20.5031 24.9096C21.8307 24.1376 22.228 21.961 20.7743 19.5178C18.7909 16.1879 13.0298 17.9335 10.7815 19.0125C6.30702 21.1642 -0.967616 26.5901 0.722547 35.9195" />
                            </svg>
                        </div>


                        <div x-ref="atlas"
                            class="pointer-events-none relative -top-20 left-50 z-6 flex flex-col items-center self-center justify-self-end [grid-area:1/-1] 2xs:left-40 2xs:self-start xs:left-30 md:left-20">
                            <img src="https://filamentphp.com/build/assets/atlas-BHQ3kbCV.webp"
                                alt="Atlas, the Filament mascot" loading="lazy" width="643" height="1000"
                                class="relative z-7 w-74" />


                            <div aria-hidden="true"
                                class="relative z-6 -mt-17 -mr-10 h-15 w-45 -rotate-18 rounded-full bg-cocoa/20 blur-xl">
                            </div>
                        </div>


                        <figure role="img"
                            aria-label="TALL stack layers illustration showing Tailwind CSS, Alpine.js, Livewire, and Laravel stacked together"
                            class="relative -top-16 z-2 self-start justify-self-center [grid-area:1/-1] xs:-left-5 sm:-left-10.25">
                            <div class="relative flex flex-col">

                                <div x-ref="tailwindLayer" @mouseenter="hoveredLayer = 'tailwind'"
                                    @mouseleave="hoveredLayer = null"
                                    class="relative z-5 transition duration-300 ease-out"
                                    style="
                            clip-path: polygon(
                                30.59% 7.25%,
                                53.23% -3.17%,
                                59.41% 11.95%,
                                107.06% 53.36%,
                                49.41% 103.17%,
                                -4.7% 54.98%
                            );
                        "
                                    :class="{ '-translate-y-3': hoveredLayer && hoveredLayer !== 'tailwind' }">
                                    <img src="https://filamentphp.com/build/assets/tailwind-layer-InFoK3Go.webp"
                                        alt="" aria-hidden="true" loading="lazy" width="676"
                                        height="439"
                                        class="pointer-events-none w-85 transition duration-300 ease-out"
                                        :class="{ 'opacity-15': hoveredLayer && hoveredLayer !== 'tailwind' }" />
                                </div>


                                <div x-ref="alpineLayer" @mouseenter="hoveredLayer = 'alpine'"
                                    @mouseleave="hoveredLayer = null"
                                    class="relative z-4 -mt-[30dvw] transition duration-300 ease-out 2xs:-mt-30.5"
                                    style="
                            clip-path: polygon(
                                40.58% -22.28%,
                                76.76% 22.42%,
                                90% 20.32%,
                                105.89% 51.89%,
                                50.59% 103.17%,
                                -4.7% 52.03%
                            );
                        "
                                    :class="{
                                        'translate-y-3': hoveredLayer && hoveredLayer === 'tailwind',
                                        '-translate-y-3': hoveredLayer && (hoveredLayer === 'livewire' ||
                                            hoveredLayer === 'laravel'),
                                    }">
                                    <img src="https://filamentphp.com/build/assets/alpine-layer-DAGbRgR4.webp"
                                        alt="" aria-hidden="true" loading="lazy" width="676"
                                        height="404"
                                        class="pointer-events-none w-85 transition duration-300 ease-out"
                                        :class="{ 'opacity-15': hoveredLayer && hoveredLayer !== 'alpine' }" />
                                </div>


                                <div x-ref="livewireLayer" @mouseenter="hoveredLayer = 'livewire'"
                                    @mouseleave="hoveredLayer = null"
                                    class="relative z-3 -mt-[30dvw] transition duration-300 ease-out 2xs:-mt-30.5"
                                    style="
                            clip-path: polygon(
                                26.47% 17.68%,
                                47.94% -15.06%,
                                103.82% 49.43%,
                                92.65% 86.43%,
                                50% 104.16%,
                                -5.88% 50.06%
                            );
                        "
                                    :class="{
                                        'translate-y-3': hoveredLayer && (hoveredLayer === 'tailwind' ||
                                            hoveredLayer === 'alpine'),
                                        '-translate-y-3': hoveredLayer && hoveredLayer === 'laravel',
                                    }">
                                    <img src="https://filamentphp.com/build/assets/livewire-layer-CJkOe1LD.webp"
                                        alt="" aria-hidden="true" loading="lazy" width="676"
                                        height="403"
                                        class="pointer-events-none w-85 transition duration-300 ease-out"
                                        :class="{ 'opacity-15': hoveredLayer && hoveredLayer !== 'livewire' }" />
                                </div>


                                <div x-ref="laravelLayer" @mouseenter="hoveredLayer = 'laravel'"
                                    @mouseleave="hoveredLayer = null"
                                    class="relative z-2 -mt-[30dvw] transition duration-300 ease-out 2xs:-mt-30.5"
                                    style="
                            clip-path: polygon(
                                11.18% 23.59%,
                                48.53% -9.15%,
                                85.58% 28.27%,
                                105.29% 50.99%,
                                50% 104.16%,
                                -5.88% 50.06%
                            );
                        "
                                    :class="{
                                        'translate-y-3': hoveredLayer && hoveredLayer !== 'laravel',
                                    }">
                                    <img src="https://filamentphp.com/build/assets/laravel-layer-DCnrHXje.webp"
                                        alt="" aria-hidden="true" loading="lazy" width="676"
                                        height="404"
                                        class="pointer-events-none w-85 transition duration-300 ease-out"
                                        :class="{ 'opacity-15': hoveredLayer && hoveredLayer !== 'laravel' }" />
                                </div>
                            </div>
                        </figure>


                        <div aria-hidden="true"
                            class="relative -top-7 -left-[10dvw] z-1 hidden flex-col self-start justify-self-start text-sm font-medium text-cocoa [grid-area:1/-1] sm:flex md:-left-25">

                            <div x-ref="tailwindCallout">
                                <div @mouseenter="hoveredLayer = 'tailwind'" @mouseleave="hoveredLayer = null"
                                    class="flex items-center gap-2 transition duration-300 ease-out"
                                    :class="{ '-translate-y-3 opacity-15': hoveredLayer && hoveredLayer !== 'tailwind' }">
                                    <div class="rounded-full bg-cream-100 px-3 py-1 select-none">
                                        Tailwind CSS
                                    </div>
                                    <div class="hidden items-center tablet:flex">
                                        <div
                                            class="h-0 w-0 [border-width:5px_8px_5px_0px] border-solid border-[transparent_var(--color-cocoa)_transparent_transparent]">
                                        </div>
                                        <div class="h-0.5 w-[10dvw] bg-cocoa md:w-23 lg:w-27"></div>
                                    </div>
                                </div>
                            </div>


                            <div x-ref="alpineCallout">
                                <div @mouseenter="hoveredLayer = 'alpine'" @mouseleave="hoveredLayer = null"
                                    class="mt-22 flex items-center gap-2 transition duration-300 ease-out"
                                    :class="{
                                        'translate-y-3 opacity-15': hoveredLayer && hoveredLayer === 'tailwind',
                                        '-translate-y-3 opacity-15': hoveredLayer && (hoveredLayer === 'livewire' ||
                                            hoveredLayer === 'laravel'),
                                    }">
                                    <div class="rounded-full bg-cream-100 px-3 py-1 select-none">
                                        Alpine.js
                                    </div>
                                    <div class="hidden items-center tablet:flex">
                                        <div
                                            class="h-0 w-0 [border-width:5px_8px_5px_0px] border-solid border-[transparent_var(--color-cocoa)_transparent_transparent]">
                                        </div>
                                        <div class="h-0.5 w-[5dvw] bg-cocoa md:w-16 lg:w-19"></div>
                                    </div>
                                </div>
                            </div>


                            <div x-ref="livewireCallout">
                                <div @mouseenter="hoveredLayer = 'livewire'" @mouseleave="hoveredLayer = null"
                                    class="mt-22 flex items-center gap-2 transition duration-300 ease-out"
                                    :class="{
                                        'translate-y-3 opacity-15': hoveredLayer && (hoveredLayer === 'tailwind' ||
                                            hoveredLayer === 'alpine'),
                                        '-translate-y-3 opacity-15': hoveredLayer && hoveredLayer === 'laravel',
                                    }">
                                    <div class="rounded-full bg-cream-100 px-3 py-1 select-none">
                                        Livewire
                                    </div>
                                    <div class="hidden items-center tablet:flex">
                                        <div
                                            class="h-0 w-0 [border-width:5px_8px_5px_0px] border-solid border-[transparent_var(--color-cocoa)_transparent_transparent]">
                                        </div>
                                        <div class="h-0.5 w-[2dvw] bg-cocoa md:w-8 lg:w-10"></div>
                                    </div>
                                </div>
                            </div>


                            <div x-ref="laravelCallout">
                                <div @mouseenter="hoveredLayer = 'laravel'" @mouseleave="hoveredLayer = null"
                                    class="mt-22 flex items-center gap-2 transition duration-300 ease-out"
                                    :class="{
                                        'translate-y-3 opacity-15': hoveredLayer && hoveredLayer !== 'laravel',
                                    }">
                                    <div class="rounded-full bg-cream-100 px-3 py-1 select-none">
                                        Laravel
                                    </div>
                                    <div class="hidden items-center tablet:flex">
                                        <div
                                            class="h-0 w-0 [border-width:5px_8px_5px_0px] border-solid border-[transparent_var(--color-cocoa)_transparent_transparent]">
                                        </div>
                                        <div class="h-0.5 w-[7dvw] bg-cocoa md:w-19 lg:w-22"></div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div x-ref="grid" aria-hidden="true"
                            class="relative top-[20dvw] z-0 self-center justify-self-center [grid-area:1/-1] 2xs:top-0 2xs:self-end">
                            <img src="https://filamentphp.com/build/assets/tall-grid--9s2OTMt.webp" alt=""
                                loading="lazy" width="721" height="476"
                                class="w-125 transition duration-300 ease-out"
                                :class="{ 'opacity-50': hoveredLayer }" />
                        </div>
                    </div>
                </div>



                <div data-animate="enter-from-left-staggered"
                    class="grid grid-cols-1 gap-7 2xs:mt-10 sm:grid-cols-2 xl:grid-cols-4">
                    <a x-data href="https://tailwindcss.com/" target="_blank" rel="noopener noreferrer"
                        aria-label="Learn more about Tailwind CSS" x-init="() => {
                            const card = $el
                            const background = $refs.background
                            const featureImage = $refs.featureImage
                            const topLeftCorner = $refs.topLeftCorner
                            const bottomLeftCorner = $refs.bottomLeftCorner
                            const topRightCorner = $refs.topRightCorner
                            const bottomRightCorner = $refs.bottomRightCorner
                        
                            const tl = gsap.timeline({ paused: true })
                        
                            // Background scales up and changes color
                            tl.fromTo(
                                background, {
                                    scale: 1,
                                }, {
                                    scale: 1.02,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            // Feature image floats up
                            tl.to(
                                featureImage, {
                                    scale: 1.05,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            // Corner animations - move outward with stagger
                            tl.to(
                                topLeftCorner, {
                                    x: -8,
                                    y: -8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            tl.to(
                                topRightCorner, {
                                    x: 8,
                                    y: -8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            tl.to(
                                bottomLeftCorner, {
                                    x: -8,
                                    y: 8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            tl.to(
                                bottomRightCorner, {
                                    x: 8,
                                    y: 8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            motion.hover(card, () => {
                                tl.tweenTo(tl.duration())
                        
                                return () => {
                                    tl.tweenTo(0)
                                }
                            })
                        }"
                        class="group relative px-8 pt-5 pb-10 text-center focus:outline-none focus-visible:ring focus-visible:ring-black/50">

                        <div x-ref="background"
                            class="absolute inset-0 bg-cream-100 transition duration-300 ease-out group-hover:bg-bubblegum/25"
                            aria-hidden="true"></div>


                        <div class="relative z-1 grid mix-blend-luminosity">
                            <div class="relative z-1 self-center justify-self-center [grid-area:1/-1]">
                                <svg x-ref="featureImage" class="h-10" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 83 50" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M41.5 0C30.4333 0 23.5167 5.55556 20.75 16.6667C24.9 11.1111 29.7417 9.02778 35.275 10.4167C38.4321 11.2083 40.6884 13.5093 43.1861 16.054C47.2547 20.2006 51.9641 25 62.25 25C73.3167 25 80.2333 19.4444 83 8.33333C78.85 13.8889 74.0083 15.9722 68.475 14.5833C65.3179 13.7917 63.0616 11.4907 60.5639 8.94599C56.4953 4.79938 51.7859 0 41.5 0ZM20.75 25C9.68333 25 2.76667 30.5556 0 41.6667C4.15 36.1111 8.99167 34.0278 14.525 35.4167C17.6821 36.2099 19.9384 38.5093 22.4361 41.054C26.5047 45.2006 31.2141 50 41.5 50C52.5667 50 59.4833 44.4444 62.25 33.3333C58.1 38.8889 53.2583 40.9722 47.725 39.5833C44.5679 38.7917 42.3116 36.4907 39.8139 33.946C35.7453 29.7994 31.0359 25 20.75 25Z"
                                        fill="#38BDF8" />
                                </svg>
                            </div>

                            <img src="https://filamentphp.com/build/assets/logo-highlight-decoration-CCc501QJ.webp"
                                alt="" loading="lazy" width="156" height="120" aria-hidden="true"
                                class="relative z-0 h-30 self-center justify-self-center [grid-area:1/-1]" />
                        </div>


                        <div class="relative z-1 mt-2 flex flex-col items-center gap-1.5">
                            <div class="relative">

                                <div x-data x-init="() => {
                                    const tweens = []
                                    let playing = false
                                
                                    const rotatingEl = $el.querySelector('[data-rotating]')
                                    const rotate = () => {
                                        gsap.to(rotatingEl, {
                                            rotation: '+=60',
                                            duration: 0.5,
                                            ease: 'sine.out',
                                            onComplete: () => {
                                                if (playing) gsap.delayedCall(0.5, rotate)
                                            },
                                        })
                                    }
                                
                                    const boxes = $el.querySelectorAll('[data-box]')
                                    const delays = [0, 0.2, 0.1]
                                    boxes.forEach((box, i) => {
                                        tweens.push(
                                            gsap.to(box, {
                                                opacity: 0.3,
                                                repeat: -1,
                                                yoyo: true,
                                                duration: 0.4,
                                                delay: delays[i] || 0,
                                                ease: 'power1.inOut',
                                                paused: true,
                                            }),
                                        )
                                    })
                                
                                    const group = $el.closest('.group')
                                    if (group) {
                                        group.addEventListener('mouseenter', () => {
                                            playing = true
                                            tweens.forEach((t) => t.resume())
                                            rotate()
                                        })
                                        group.addEventListener('mouseleave', () => {
                                            playing = false
                                            tweens.forEach((t) => t.pause())
                                        })
                                    }
                                }"
                                    class="absolute top-1/2 -left-4 -translate-y-1/2">
                                    <div
                                        class="translate-x-0.5 opacity-0 transition duration-300 ease-out will-change-transform group-hover:translate-x-0 group-hover:opacity-100">
                                        <div data-rotating class="flex items-center gap-0.75">
                                            <div class="flex flex-col gap-1">

                                                <div data-box class="size-0.75 bg-current"></div>


                                                <div data-box class="size-0.75 bg-current"></div>
                                            </div>


                                            <div data-box class="size-0.75 bg-current"></div>
                                        </div>
                                    </div>
                                </div>


                                <p
                                    class="font-outfit text-xl font-medium text-stone-800 transition duration-300 ease-out will-change-transform group-hover:translate-x-0.5 md:text-2xl">
                                    Tailwind CSS
                                </p>
                            </div>


                            <p class="text-pretty">Utility-first CSS that enables fast iteration and consistent,
                                responsive UI.</p>
                        </div>


                        <div x-ref="topLeftCorner" class="absolute top-0 left-0" aria-hidden="true">
                            <svg class="h-2.5 text-stone-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 11 11" fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>


                        <div x-ref="bottomLeftCorner" class="absolute bottom-0 left-0" aria-hidden="true">
                            <svg class="h-2.5 -scale-y-100 text-stone-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 11 11" fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>


                        <div x-ref="topRightCorner" class="absolute top-0 right-0" aria-hidden="true">
                            <svg class="h-2.5 -scale-x-100 text-stone-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 11 11" fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>


                        <div x-ref="bottomRightCorner" class="absolute right-0 bottom-0" aria-hidden="true">
                            <svg class="h-2.5 -scale-x-100 -scale-y-100 text-stone-600"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 11 11" fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>
                    </a>
                    <a x-data href="https://alpinejs.dev/" target="_blank" rel="noopener noreferrer"
                        aria-label="Learn more about Alpine.js" x-init="() => {
                            const card = $el
                            const background = $refs.background
                            const featureImage = $refs.featureImage
                            const topLeftCorner = $refs.topLeftCorner
                            const bottomLeftCorner = $refs.bottomLeftCorner
                            const topRightCorner = $refs.topRightCorner
                            const bottomRightCorner = $refs.bottomRightCorner
                        
                            const tl = gsap.timeline({ paused: true })
                        
                            // Background scales up and changes color
                            tl.fromTo(
                                background, {
                                    scale: 1,
                                }, {
                                    scale: 1.02,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            // Feature image floats up
                            tl.to(
                                featureImage, {
                                    scale: 1.05,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            // Corner animations - move outward with stagger
                            tl.to(
                                topLeftCorner, {
                                    x: -8,
                                    y: -8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            tl.to(
                                topRightCorner, {
                                    x: 8,
                                    y: -8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            tl.to(
                                bottomLeftCorner, {
                                    x: -8,
                                    y: 8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            tl.to(
                                bottomRightCorner, {
                                    x: 8,
                                    y: 8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            motion.hover(card, () => {
                                tl.tweenTo(tl.duration())
                        
                                return () => {
                                    tl.tweenTo(0)
                                }
                            })
                        }"
                        class="group relative px-8 pt-5 pb-10 text-center focus:outline-none focus-visible:ring focus-visible:ring-black/50">

                        <div x-ref="background"
                            class="absolute inset-0 bg-cream-100 transition duration-300 ease-out group-hover:bg-bubblegum/25"
                            aria-hidden="true"></div>


                        <div class="relative z-1 grid mix-blend-luminosity">
                            <div class="relative z-1 self-center justify-self-center [grid-area:1/-1]">
                                <svg x-ref="featureImage" class="h-8" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 88 40" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M67.8282 0L87.2078 19.2945L67.8282 38.5891L48.4487 19.2945L67.8282 0Z"
                                        fill="#77C1D2" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M19.3795 0L59.5557 40H20.7966L0 19.2945L19.3795 0Z" fill="#2D3441" />
                                </svg>
                            </div>

                            <img src="https://filamentphp.com/build/assets/logo-highlight-decoration-CCc501QJ.webp"
                                alt="" loading="lazy" width="156" height="120" aria-hidden="true"
                                class="relative z-0 h-30 self-center justify-self-center [grid-area:1/-1]" />
                        </div>


                        <div class="relative z-1 mt-2 flex flex-col items-center gap-1.5">
                            <div class="relative">

                                <div x-data x-init="() => {
                                    const tweens = []
                                    let playing = false
                                
                                    const rotatingEl = $el.querySelector('[data-rotating]')
                                    const rotate = () => {
                                        gsap.to(rotatingEl, {
                                            rotation: '+=60',
                                            duration: 0.5,
                                            ease: 'sine.out',
                                            onComplete: () => {
                                                if (playing) gsap.delayedCall(0.5, rotate)
                                            },
                                        })
                                    }
                                
                                    const boxes = $el.querySelectorAll('[data-box]')
                                    const delays = [0, 0.2, 0.1]
                                    boxes.forEach((box, i) => {
                                        tweens.push(
                                            gsap.to(box, {
                                                opacity: 0.3,
                                                repeat: -1,
                                                yoyo: true,
                                                duration: 0.4,
                                                delay: delays[i] || 0,
                                                ease: 'power1.inOut',
                                                paused: true,
                                            }),
                                        )
                                    })
                                
                                    const group = $el.closest('.group')
                                    if (group) {
                                        group.addEventListener('mouseenter', () => {
                                            playing = true
                                            tweens.forEach((t) => t.resume())
                                            rotate()
                                        })
                                        group.addEventListener('mouseleave', () => {
                                            playing = false
                                            tweens.forEach((t) => t.pause())
                                        })
                                    }
                                }"
                                    class="absolute top-1/2 -left-4 -translate-y-1/2">
                                    <div
                                        class="translate-x-0.5 opacity-0 transition duration-300 ease-out will-change-transform group-hover:translate-x-0 group-hover:opacity-100">
                                        <div data-rotating class="flex items-center gap-0.75">
                                            <div class="flex flex-col gap-1">

                                                <div data-box class="size-0.75 bg-current"></div>


                                                <div data-box class="size-0.75 bg-current"></div>
                                            </div>


                                            <div data-box class="size-0.75 bg-current"></div>
                                        </div>
                                    </div>
                                </div>


                                <p
                                    class="font-outfit text-xl font-medium text-stone-800 transition duration-300 ease-out will-change-transform group-hover:translate-x-0.5 md:text-2xl">
                                    Alpine.js
                                </p>
                            </div>


                            <p class="text-pretty">Lightweight JavaScript for small, focused interactions directly in
                                markup.</p>
                        </div>


                        <div x-ref="topLeftCorner" class="absolute top-0 left-0" aria-hidden="true">
                            <svg class="h-2.5 text-stone-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 11 11" fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>


                        <div x-ref="bottomLeftCorner" class="absolute bottom-0 left-0" aria-hidden="true">
                            <svg class="h-2.5 -scale-y-100 text-stone-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 11 11" fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>


                        <div x-ref="topRightCorner" class="absolute top-0 right-0" aria-hidden="true">
                            <svg class="h-2.5 -scale-x-100 text-stone-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 11 11" fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>


                        <div x-ref="bottomRightCorner" class="absolute right-0 bottom-0" aria-hidden="true">
                            <svg class="h-2.5 -scale-x-100 -scale-y-100 text-stone-600"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 11 11" fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>
                    </a>
                    <a x-data href="https://livewire.laravel.com/" target="_blank" rel="noopener noreferrer"
                        aria-label="Learn more about Livewire" x-init="() => {
                            const card = $el
                            const background = $refs.background
                            const featureImage = $refs.featureImage
                            const topLeftCorner = $refs.topLeftCorner
                            const bottomLeftCorner = $refs.bottomLeftCorner
                            const topRightCorner = $refs.topRightCorner
                            const bottomRightCorner = $refs.bottomRightCorner
                        
                            const tl = gsap.timeline({ paused: true })
                        
                            // Background scales up and changes color
                            tl.fromTo(
                                background, {
                                    scale: 1,
                                }, {
                                    scale: 1.02,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            // Feature image floats up
                            tl.to(
                                featureImage, {
                                    scale: 1.05,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            // Corner animations - move outward with stagger
                            tl.to(
                                topLeftCorner, {
                                    x: -8,
                                    y: -8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            tl.to(
                                topRightCorner, {
                                    x: 8,
                                    y: -8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            tl.to(
                                bottomLeftCorner, {
                                    x: -8,
                                    y: 8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            tl.to(
                                bottomRightCorner, {
                                    x: 8,
                                    y: 8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            motion.hover(card, () => {
                                tl.tweenTo(tl.duration())
                        
                                return () => {
                                    tl.tweenTo(0)
                                }
                            })
                        }"
                        class="group relative px-8 pt-5 pb-10 text-center focus:outline-none focus-visible:ring focus-visible:ring-black/50">

                        <div x-ref="background"
                            class="absolute inset-0 bg-cream-100 transition duration-300 ease-out group-hover:bg-bubblegum/25"
                            aria-hidden="true"></div>


                        <div class="relative z-1 grid mix-blend-luminosity">
                            <div class="relative z-1 self-center justify-self-center [grid-area:1/-1]">
                                <svg x-ref="featureImage" class="h-10" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 62 50" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M58.3936 46.1767C57.2526 47.89 56.3884 50 54.0695 50C50.1665 50 49.9551 44.0217 46.0488 44.0217C42.1441 44.0217 42.3555 50 38.4526 50C34.5496 50 34.3382 44.0217 30.4319 44.0217C26.5272 44.0217 26.7386 50 22.834 50C18.931 50 18.7196 44.0217 14.8133 44.0217C10.907 44.0217 11.1217 50 7.21542 50C5.98882 50 5.12634 49.41 4.39978 48.6C1.50093 43.5666 -0.0162274 37.8654 0.000130896 32.0667C0.000130896 14.355 13.7729 0 30.7624 0C47.7553 0 61.5264 14.3567 61.5264 32.0667C61.5264 37.1283 60.3988 41.9167 58.3936 46.1767Z"
                                        fill="#FB70A9" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M58.3936 46.1767C57.2526 47.89 56.3884 50 54.0695 50C50.1665 50 49.9551 44.0217 46.0488 44.0217C42.1441 44.0217 42.3555 50 38.4526 50C34.5496 50 34.3382 44.0217 30.4319 44.0217C26.5272 44.0217 26.7386 50 22.834 50C18.931 50 18.7196 44.0217 14.8133 44.0217C10.907 44.0217 11.1217 50 7.21542 50C5.98882 50 5.12634 49.41 4.39978 48.6C1.50093 43.5666 -0.0162274 37.8654 0.000130896 32.0667C0.000130896 14.355 13.7729 0 30.7624 0C47.7553 0 61.5264 14.3567 61.5264 32.0667C61.5264 37.1283 60.3988 41.9167 58.3936 46.1767Z"
                                        fill="#FB70A9" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M51.7383 49.3614C59.7993 37.4498 60.009 24.2364 52.3625 9.72144C58.253 15.7124 61.5431 23.7591 61.5259 32.1331C61.5259 37.1764 60.3597 41.9498 58.2807 46.1898C57.0977 47.8964 56.2 49.9998 53.7955 49.9998C52.9733 49.9998 52.3088 49.7531 51.7383 49.3614Z"
                                        fill="#E24CA6" />
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M29.1129 40.0633C39.8116 40.0633 44.3153 33.8999 44.3153 25.1466C44.3153 16.3899 37.5111 8.33325 29.1129 8.33325C20.718 8.33325 13.9121 16.3916 13.9121 25.1449C13.9121 33.8999 18.4141 40.0633 29.1129 40.0633Z"
                                        fill="white" />
                                    <path
                                        d="M25.0272 25.6418C28.1751 25.6418 30.7273 22.8418 30.7273 19.3918C30.7273 15.9402 28.1768 13.1418 25.0272 13.1418C21.8793 13.1418 19.3271 15.9402 19.3271 19.3918C19.3271 22.8418 21.8777 25.6418 25.0272 25.6418Z"
                                        fill="#030776" />
                                    <path
                                        d="M24.0791 20.8333C25.6514 20.8333 26.9283 19.5416 26.9283 17.9499C26.9283 16.3549 25.6531 15.0649 24.0774 15.0649C22.5035 15.0649 21.2266 16.3549 21.2266 17.9483C21.2266 19.5416 22.5018 20.8333 24.0791 20.8333Z"
                                        fill="white" />
                                </svg>
                            </div>

                            <img src="https://filamentphp.com/build/assets/logo-highlight-decoration-CCc501QJ.webp"
                                alt="" loading="lazy" width="156" height="120" aria-hidden="true"
                                class="relative z-0 h-30 self-center justify-self-center [grid-area:1/-1]" />
                        </div>


                        <div class="relative z-1 mt-2 flex flex-col items-center gap-1.5">
                            <div class="relative">

                                <div x-data x-init="() => {
                                    const tweens = []
                                    let playing = false
                                
                                    const rotatingEl = $el.querySelector('[data-rotating]')
                                    const rotate = () => {
                                        gsap.to(rotatingEl, {
                                            rotation: '+=60',
                                            duration: 0.5,
                                            ease: 'sine.out',
                                            onComplete: () => {
                                                if (playing) gsap.delayedCall(0.5, rotate)
                                            },
                                        })
                                    }
                                
                                    const boxes = $el.querySelectorAll('[data-box]')
                                    const delays = [0, 0.2, 0.1]
                                    boxes.forEach((box, i) => {
                                        tweens.push(
                                            gsap.to(box, {
                                                opacity: 0.3,
                                                repeat: -1,
                                                yoyo: true,
                                                duration: 0.4,
                                                delay: delays[i] || 0,
                                                ease: 'power1.inOut',
                                                paused: true,
                                            }),
                                        )
                                    })
                                
                                    const group = $el.closest('.group')
                                    if (group) {
                                        group.addEventListener('mouseenter', () => {
                                            playing = true
                                            tweens.forEach((t) => t.resume())
                                            rotate()
                                        })
                                        group.addEventListener('mouseleave', () => {
                                            playing = false
                                            tweens.forEach((t) => t.pause())
                                        })
                                    }
                                }"
                                    class="absolute top-1/2 -left-4 -translate-y-1/2">
                                    <div
                                        class="translate-x-0.5 opacity-0 transition duration-300 ease-out will-change-transform group-hover:translate-x-0 group-hover:opacity-100">
                                        <div data-rotating class="flex items-center gap-0.75">
                                            <div class="flex flex-col gap-1">

                                                <div data-box class="size-0.75 bg-current"></div>


                                                <div data-box class="size-0.75 bg-current"></div>
                                            </div>


                                            <div data-box class="size-0.75 bg-current"></div>
                                        </div>
                                    </div>
                                </div>


                                <p
                                    class="font-outfit text-xl font-medium text-stone-800 transition duration-300 ease-out will-change-transform group-hover:translate-x-0.5 md:text-2xl">
                                    Livewire
                                </p>
                            </div>


                            <p class="text-pretty">Server-driven reactivity for building dynamic interfaces without
                                writing APIs.</p>
                        </div>


                        <div x-ref="topLeftCorner" class="absolute top-0 left-0" aria-hidden="true">
                            <svg class="h-2.5 text-stone-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 11 11" fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>


                        <div x-ref="bottomLeftCorner" class="absolute bottom-0 left-0" aria-hidden="true">
                            <svg class="h-2.5 -scale-y-100 text-stone-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 11 11" fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>


                        <div x-ref="topRightCorner" class="absolute top-0 right-0" aria-hidden="true">
                            <svg class="h-2.5 -scale-x-100 text-stone-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 11 11" fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>


                        <div x-ref="bottomRightCorner" class="absolute right-0 bottom-0" aria-hidden="true">
                            <svg class="h-2.5 -scale-x-100 -scale-y-100 text-stone-600"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 11 11" fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>
                    </a>
                    <a x-data href="https://laravel.com/" target="_blank" rel="noopener noreferrer"
                        aria-label="Learn more about Laravel" x-init="() => {
                            const card = $el
                            const background = $refs.background
                            const featureImage = $refs.featureImage
                            const topLeftCorner = $refs.topLeftCorner
                            const bottomLeftCorner = $refs.bottomLeftCorner
                            const topRightCorner = $refs.topRightCorner
                            const bottomRightCorner = $refs.bottomRightCorner
                        
                            const tl = gsap.timeline({ paused: true })
                        
                            // Background scales up and changes color
                            tl.fromTo(
                                background, {
                                    scale: 1,
                                }, {
                                    scale: 1.02,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            // Feature image floats up
                            tl.to(
                                featureImage, {
                                    scale: 1.05,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            // Corner animations - move outward with stagger
                            tl.to(
                                topLeftCorner, {
                                    x: -8,
                                    y: -8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            tl.to(
                                topRightCorner, {
                                    x: 8,
                                    y: -8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            tl.to(
                                bottomLeftCorner, {
                                    x: -8,
                                    y: 8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            tl.to(
                                bottomRightCorner, {
                                    x: 8,
                                    y: 8,
                                    duration: 0.25,
                                    ease: 'power2.out',
                                },
                                0,
                            )
                        
                            motion.hover(card, () => {
                                tl.tweenTo(tl.duration())
                        
                                return () => {
                                    tl.tweenTo(0)
                                }
                            })
                        }"
                        class="group relative px-8 pt-5 pb-10 text-center focus:outline-none focus-visible:ring focus-visible:ring-black/50">

                        <div x-ref="background"
                            class="absolute inset-0 bg-cream-100 transition duration-300 ease-out group-hover:bg-bubblegum/25"
                            aria-hidden="true"></div>


                        <div class="relative z-1 grid mix-blend-luminosity">
                            <div class="relative z-1 self-center justify-self-center [grid-area:1/-1]">
                                <svg x-ref="featureImage" class="h-11" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 52 53" fill="none">
                                    <path
                                        d="M10.6555 0.0458414C10.572 0.0781381 8.22406 1.40396 5.43872 2.99064C2.06389 4.91354 0.330521 5.92633 0.237773 6.02156C0.158395 6.11472 0.095728 6.22114 0.0547856 6.33625C-0.0149837 6.56978 -0.0199971 40.697 0.0506078 40.9426C0.0760924 41.0378 0.159231 41.1778 0.234431 41.2548C0.416583 41.4453 20.5653 52.9272 20.8101 52.9826C20.9237 53.0096 21.0512 53.005 21.1778 52.9702C21.4527 52.9019 41.5487 41.4453 41.7275 41.2581C41.8006 41.1774 41.8842 41.0378 41.9113 40.943C41.9464 40.83 41.9594 39.0466 41.9594 35.289V29.7986L46.8583 27.0099C51.4773 24.3777 51.7601 24.2129 51.8787 24.0324L51.9999 23.8378V17.9237C51.9999 11.4859 52.0124 11.8482 51.7555 11.6155C51.6866 11.5551 49.3332 10.194 46.5207 8.58874L41.4121 5.67706H40.8443L35.8464 8.52166C33.0949 10.0901 30.7562 11.4313 30.6421 11.5041C30.5285 11.5787 30.3927 11.7161 30.3372 11.8159L30.2361 11.9886L30.2135 17.5598L30.1934 23.133L26.0662 25.489C23.796 26.7826 21.9064 27.8533 21.8663 27.8632C21.7931 27.8835 21.7881 27.3531 21.7881 17.1118V6.33252L21.6795 6.14744C21.5433 5.92177 22.1541 6.28159 16.0211 2.78775C10.8778 -0.143798 11.0015 -0.0825174 10.6555 0.0458414ZM15.3836 4.31356C17.5351 5.53711 19.2957 6.54949 19.2957 6.56191C19.2957 6.57475 17.409 7.65544 15.1032 8.96884L10.9083 11.3559L6.72089 8.96926C4.42017 7.65544 2.53473 6.57475 2.53473 6.56191C2.53473 6.54907 4.41683 5.46879 6.71796 4.15829L10.8953 1.77661L11.1836 1.9323C12.5862 2.72178 13.9862 3.51553 15.3836 4.31356ZM45.325 9.80442C47.5902 11.0971 49.4644 12.1654 49.4819 12.1828C49.5296 12.2254 41.2208 16.959 41.1071 16.954C40.9935 16.9507 32.787 12.2606 32.7904 12.2035C32.7945 12.1385 41.0511 7.43061 41.1347 7.44344C41.1727 7.45255 43.0594 8.51586 45.325 9.80442ZM6.07207 10.4876L10.0652 12.7662L10.0882 24.0481L10.1091 35.3321L10.2064 35.4844C10.2574 35.5648 10.3535 35.6745 10.4237 35.725C10.4897 35.7726 12.7119 37.0276 15.361 38.5092L20.1738 41.203V45.9759C20.1738 48.5953 20.1559 50.7442 20.1333 50.7442C20.1162 50.7442 15.9555 48.3845 10.8903 45.4956L1.68246 40.2474L1.66992 24.1131L1.66199 7.98379L1.8667 8.096C1.98493 8.15811 3.87497 9.23384 6.07166 10.4872L6.07207 10.4876ZM20.1738 18.4293V28.8259L20.0121 28.9307C19.7928 29.0682 11.7957 33.6241 11.7685 33.6241C11.756 33.6241 11.7459 28.9303 11.7459 23.1926L11.751 12.7658L15.9288 10.3841C18.2261 9.0736 20.1208 8.01029 20.1433 8.01816C20.1596 8.0281 20.1738 12.7136 20.1738 18.4293ZM36.1121 16.0381L40.2995 18.4243V23.1546C40.2995 27.6421 40.295 27.8831 40.226 27.857C40.1813 27.8401 38.2867 26.7639 36.0135 25.4663L31.8733 23.1102V18.3817C31.8733 15.7785 31.8867 13.6515 31.8992 13.6515C31.9172 13.6515 33.8114 14.7247 36.1121 16.0381ZM50.3852 18.3515C50.3852 20.941 50.3676 23.0767 50.3501 23.0974C50.32 23.145 42.0379 27.8748 41.9853 27.8748C41.9723 27.8748 41.9594 25.7486 41.9594 23.145V18.4165L46.1372 16.0331C48.4379 14.7247 50.3325 13.6515 50.3501 13.6515C50.3722 13.6515 50.3852 15.7652 50.3852 18.3515ZM39.3662 29.3708L20.9889 39.7667L12.6546 35.0683C12.6546 35.0683 31.0136 24.5446 31.0871 24.5719L39.3662 29.3708ZM40.2916 35.5101L40.2774 40.2478L31.0745 45.4964C26.0111 48.3849 21.8491 50.7446 21.8282 50.7446C21.8061 50.7446 21.7885 48.8159 21.7885 45.9763V41.2034L31.0131 35.9896C36.0816 33.1231 40.2465 30.7766 40.2686 30.7716C40.2866 30.7716 40.2945 32.9032 40.2912 35.5097L40.2916 35.5101Z"
                                        fill="#F0513F" />
                                </svg>
                            </div>

                            <img src="https://filamentphp.com/build/assets/logo-highlight-decoration-CCc501QJ.webp"
                                alt="" loading="lazy" width="156" height="120" aria-hidden="true"
                                class="relative z-0 h-30 self-center justify-self-center [grid-area:1/-1]" />
                        </div>


                        <div class="relative z-1 mt-2 flex flex-col items-center gap-1.5">
                            <div class="relative">

                                <div x-data x-init="() => {
                                    const tweens = []
                                    let playing = false
                                
                                    const rotatingEl = $el.querySelector('[data-rotating]')
                                    const rotate = () => {
                                        gsap.to(rotatingEl, {
                                            rotation: '+=60',
                                            duration: 0.5,
                                            ease: 'sine.out',
                                            onComplete: () => {
                                                if (playing) gsap.delayedCall(0.5, rotate)
                                            },
                                        })
                                    }
                                
                                    const boxes = $el.querySelectorAll('[data-box]')
                                    const delays = [0, 0.2, 0.1]
                                    boxes.forEach((box, i) => {
                                        tweens.push(
                                            gsap.to(box, {
                                                opacity: 0.3,
                                                repeat: -1,
                                                yoyo: true,
                                                duration: 0.4,
                                                delay: delays[i] || 0,
                                                ease: 'power1.inOut',
                                                paused: true,
                                            }),
                                        )
                                    })
                                
                                    const group = $el.closest('.group')
                                    if (group) {
                                        group.addEventListener('mouseenter', () => {
                                            playing = true
                                            tweens.forEach((t) => t.resume())
                                            rotate()
                                        })
                                        group.addEventListener('mouseleave', () => {
                                            playing = false
                                            tweens.forEach((t) => t.pause())
                                        })
                                    }
                                }"
                                    class="absolute top-1/2 -left-4 -translate-y-1/2">
                                    <div
                                        class="translate-x-0.5 opacity-0 transition duration-300 ease-out will-change-transform group-hover:translate-x-0 group-hover:opacity-100">
                                        <div data-rotating class="flex items-center gap-0.75">
                                            <div class="flex flex-col gap-1">

                                                <div data-box class="size-0.75 bg-current"></div>


                                                <div data-box class="size-0.75 bg-current"></div>
                                            </div>


                                            <div data-box class="size-0.75 bg-current"></div>
                                        </div>
                                    </div>
                                </div>


                                <p
                                    class="font-outfit text-xl font-medium text-stone-800 transition duration-300 ease-out will-change-transform group-hover:translate-x-0.5 md:text-2xl">
                                    Laravel
                                </p>
                            </div>


                            <p class="text-pretty">A robust PHP framework providing the foundation for Filament
                                applications.</p>
                        </div>


                        <div x-ref="topLeftCorner" class="absolute top-0 left-0" aria-hidden="true">
                            <svg class="h-2.5 text-stone-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 11 11" fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>


                        <div x-ref="bottomLeftCorner" class="absolute bottom-0 left-0" aria-hidden="true">
                            <svg class="h-2.5 -scale-y-100 text-stone-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 11 11" fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>


                        <div x-ref="topRightCorner" class="absolute top-0 right-0" aria-hidden="true">
                            <svg class="h-2.5 -scale-x-100 text-stone-600" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 11 11" fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>


                        <div x-ref="bottomRightCorner" class="absolute right-0 bottom-0" aria-hidden="true">
                            <svg class="h-2.5 -scale-x-100 -scale-y-100 text-stone-600"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 11 11" fill="none">
                                <path d="M9.5 0.5H0.5V9.5" class="stroke-current" stroke-linecap="round" />
                            </svg>
                        </div>
                    </a>
                </div>
            </section>


            <section>
                <div data-triangle-decoration="bottom"
                    class="border-b border-bone-100 px-5 py-10 sm:px-10 lg:px-15">

                    <header class="flex flex-col items-center justify-center text-center">
                        <div data-animate="enter-from-top">
                            <svg aria-hidden="true" class="h-5 text-stone-800 lg:h-6"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130 121" fill="none">
                                <path class="stroke-current [stroke-width:var(--stroke-width,8)]"
                                    d="M35.1101 28.8301L2.12012 61.8201L37.4901 97.1801" />
                                <path class="stroke-current [stroke-width:var(--stroke-width,8)]"
                                    d="M94.5001 28.8301L127.49 61.8201L92.1201 97.1801" />
                                <path class="stroke-current [stroke-width:var(--stroke-width,8)]"
                                    d="M88.7499 0.550049L41.3799 119.92" />
                            </svg>
                        </div>
                        <h1 data-animate="text-reveal-lines" class="mt-2.5">
                            Turn PHP into polished UI
                        </h1>
                        <p data-section-description data-animate="text-reveal-words" class="mt-3 md:mt-4">
                            Use a declarative syntax that emphasizes
                            <strong>clarity</strong>
                            and
                            <strong>long-term maintainability.</strong>
                        </p>
                    </header>
                </div>

                <div data-triangle-decoration="bottom" x-data="{
                    activeTab: 'tables',
                    tabs: JSON.parse('[\u0022tables\u0022,\u0022forms\u0022,\u0022infolists\u0022,\u0022notifications\u0022,\u0022widgets\u0022,\u0022actions\u0022]'),
                    direction: 'right',
                    switchTab(newTab) {
                        if (this.activeTab === newTab) return
                
                        const currentIndex = this.tabs.indexOf(this.activeTab)
                        const newIndex = this.tabs.indexOf(newTab)
                
                        this.direction = newIndex > currentIndex ? 'right' : 'left'
                        this.activeTab = newTab
                    },
                }"
                    :class="direction === 'right' ? 'slide-direction-right' : 'slide-direction-left'"
                    class="border-b border-bone-100">

                    <div class="relative border-b border-bone-100">
                        <nav class="-mb-px flex h-14 scrollbar-thin items-stretch justify-start gap-0 divide-x divide-bone-100 overflow-x-auto scroll-smooth xl:justify-center"
                            role="tablist" aria-label="Code snippet tabs">
                            <button type="button" role="tab" :aria-selected="activeTab === 'tables'"
                                aria-controls="tab-panel-tables" @click="switchTab('tables')"
                                class="relative shrink-0 px-5 text-center text-sm transition duration-300 ease-out focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset sm:text-base lg:first:border-l lg:first:border-l-bone-100 lg:last:border-r lg:last:border-r-bone-100"
                                :class="{
                                    'border-b-2 bg-cream-100 cursor-default border-b-honey-200 font-medium text-stone-800': activeTab === 'tables',
                                    'hover:bg-bone-100/30 hover:text-stone-800 cursor-pointer': activeTab !== 'tables',
                                }">
                                Tables
                            </button>
                            <button type="button" role="tab" :aria-selected="activeTab === 'forms'"
                                aria-controls="tab-panel-forms" @click="switchTab('forms')"
                                class="relative shrink-0 px-5 text-center text-sm transition duration-300 ease-out focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset sm:text-base lg:first:border-l lg:first:border-l-bone-100 lg:last:border-r lg:last:border-r-bone-100"
                                :class="{
                                    'border-b-2 bg-cream-100 cursor-default border-b-honey-200 font-medium text-stone-800': activeTab === 'forms',
                                    'hover:bg-bone-100/30 hover:text-stone-800 cursor-pointer': activeTab !== 'forms',
                                }">
                                Forms
                            </button>
                            <button type="button" role="tab" :aria-selected="activeTab === 'infolists'"
                                aria-controls="tab-panel-infolists" @click="switchTab('infolists')"
                                class="relative shrink-0 px-5 text-center text-sm transition duration-300 ease-out focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset sm:text-base lg:first:border-l lg:first:border-l-bone-100 lg:last:border-r lg:last:border-r-bone-100"
                                :class="{
                                    'border-b-2 bg-cream-100 cursor-default border-b-honey-200 font-medium text-stone-800': activeTab === 'infolists',
                                    'hover:bg-bone-100/30 hover:text-stone-800 cursor-pointer': activeTab !== 'infolists',
                                }">
                                Infolists
                            </button>
                            <button type="button" role="tab" :aria-selected="activeTab === 'notifications'"
                                aria-controls="tab-panel-notifications" @click="switchTab('notifications')"
                                class="relative shrink-0 px-5 text-center text-sm transition duration-300 ease-out focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset sm:text-base lg:first:border-l lg:first:border-l-bone-100 lg:last:border-r lg:last:border-r-bone-100"
                                :class="{
                                    'border-b-2 bg-cream-100 cursor-default border-b-honey-200 font-medium text-stone-800': activeTab === 'notifications',
                                    'hover:bg-bone-100/30 hover:text-stone-800 cursor-pointer': activeTab !== 'notifications',
                                }">
                                Notifications
                            </button>
                            <button type="button" role="tab" :aria-selected="activeTab === 'widgets'"
                                aria-controls="tab-panel-widgets" @click="switchTab('widgets')"
                                class="relative shrink-0 px-5 text-center text-sm transition duration-300 ease-out focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset sm:text-base lg:first:border-l lg:first:border-l-bone-100 lg:last:border-r lg:last:border-r-bone-100"
                                :class="{
                                    'border-b-2 bg-cream-100 cursor-default border-b-honey-200 font-medium text-stone-800': activeTab === 'widgets',
                                    'hover:bg-bone-100/30 hover:text-stone-800 cursor-pointer': activeTab !== 'widgets',
                                }">
                                Dashboard widgets
                            </button>
                            <button type="button" role="tab" :aria-selected="activeTab === 'actions'"
                                aria-controls="tab-panel-actions" @click="switchTab('actions')"
                                class="relative shrink-0 px-5 text-center text-sm transition duration-300 ease-out focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset sm:text-base lg:first:border-l lg:first:border-l-bone-100 lg:last:border-r lg:last:border-r-bone-100"
                                :class="{
                                    'border-b-2 bg-cream-100 cursor-default border-b-honey-200 font-medium text-stone-800': activeTab === 'actions',
                                    'hover:bg-bone-100/30 hover:text-stone-800 cursor-pointer': activeTab !== 'actions',
                                }">
                                Action modals
                            </button>
                        </nav>

                        <div class="absolute right-10 -bottom-12 z-1 hidden flex-col items-center gap-3 lg:flex">
                            <p class="flex flex-col items-center gap-4 pl-8 text-sm xl:pr-10 xl:pl-0">
                                <span>
                                    Follow
                                    <span class="font-medium text-stone-700">Barney's</span>
                                    lead
                                </span>
                                <svg aria-hidden="true" class="w-5 -scale-x-100 xl:scale-x-100 xl:rotate-10"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 81 116" fill="none">
                                    <path class="stroke-current [stroke-width:var(--stroke-width,5)]"
                                        d="M79.0098 115.04C79.0098 115.04 59.8198 43.9098 2.1198 4.31982" />
                                    <path class="stroke-current [stroke-width:var(--stroke-width,5)]"
                                        d="M34.4903 1.06982C34.4903 1.06982 17.5303 17.7598 0.990273 3.20982" />
                                    <path class="stroke-current [stroke-width:var(--stroke-width,5)]"
                                        d="M3.13036 36.7002C3.13036 36.7002 17.5304 17.7602 0.990356 3.2002" />
                                </svg>
                            </p>
                            <img src="https://filamentphp.com/build/assets/barney-C7Py5uPh.webp"
                                alt="Barney, the Filament mascot" aria-hidden="true" width="32"
                                height="52" class="hidden w-8 tablet:block" />
                        </div>
                    </div>


                    <div
                        class="flex flex-col justify-between gap-x-10 gap-y-10 px-5 pt-14 pb-10 sm:px-10 lg:flex-row lg:items-center lg:px-15 lg:pt-10">

                        <div class="relative">
                            <div x-show="activeTab === 'tables'" x-transition:enter="tab-enter"
                                x-transition:enter-start="tab-enter-start" x-transition:enter-end="tab-enter-end"
                                x-transition:leave="tab-leave" x-transition:leave-start="tab-leave-start"
                                x-transition:leave-end="tab-leave-end" x-cloak id="tab-panel-tables">
                                <div>

                                    <div data-animate="enter-from-top" class="relative z-1 -ml-13 inline-grid">
                                        <div
                                            class="relative -top-4 z-1 self-start justify-self-center [grid-area:1/-1]">
                                            <img src="https://filamentphp.com/build/assets/tables-BLq3rhQI.webp"
                                                alt="Filament Tables" width="207" height="300"
                                                aria-hidden="true" class="h-25 w-auto" />
                                        </div>
                                        <img src="https://filamentphp.com/build/assets/mini-isometric-grid-BrbSNZpX.webp"
                                            alt="" width="186" height="112" aria-hidden="true"
                                            class="relative z-0 h-20 -rotate-7 self-end justify-self-center mask-x-from-80% [grid-area:1/-1]" />
                                    </div>


                                    <div data-animate="text-reveal-lines"
                                        class="mt-3 font-outfit text-xl font-medium text-stone-800 md:text-2xl"
                                        role="heading" aria-level="2">
                                        Tables
                                    </div>


                                    <p data-animate="enter-from-left" class="mt-1 max-w-md md:mt-2 md:text-lg">
                                        Browse and manage large datasets with configurable columns, filters, row
                                        actions, and bulk operations, all defined in PHP for seamless integration
                                        between your data models and UI.
                                    </p>


                                    <nav data-animate="enter-from-bottom" class="mt-3 inline-flex md:mt-4">
                                        <div x-data data-button-pulse class="rounded-full bg-cream-100"
                                            aria-label="View documentation for Filament tables"
                                            x-init="async () => {
                                                await window.FilamentAnimations.waitForFonts()
                                            
                                                const button = $el.querySelector('a')
                                                const textWrapper = button.querySelector('[data-text]')
                                                const icon = button.querySelector('[data-icon] svg')
                                                const hasCustomIcon = false
                                                const hasCustomContent = false
                                                const animateIcon = true
                                            
                                                const tl = gsap.timeline({ paused: true })
                                            
                                                // Only animate text if not using custom content
                                                let chars = []
                                                if (!hasCustomContent && textWrapper) {
                                                    const split = new SplitText(textWrapper, { type: 'chars' })
                                                    chars = split.chars
                                                }
                                            
                                                if (hasCustomIcon && animateIcon) {
                                                    // Custom icon animation: subtle scale and lift
                                                    tl.to(
                                                        icon, {
                                                            scale: 1.1,
                                                            rotation: 0.01,
                                                            duration: 0.3,
                                                            ease: 'sine.out',
                                                        },
                                                        0,
                                                    )
                                                } else if (!hasCustomIcon) {
                                                    // Arrow animation
                                                    const direction = 'right'
                                                    const distance = 30
                                            
                                                    let xOut, yOut, xIn, yIn
                                            
                                                    switch (direction) {
                                                        case 'top-right':
                                                            xOut = distance * Math.cos((-45 * Math.PI) / 180)
                                                            yOut = distance * Math.sin((-45 * Math.PI) / 180)
                                                            xIn = -xOut
                                                            yIn = -yOut
                                                            break
                                                        case 'bottom-right':
                                                            xOut = distance * Math.cos((45 * Math.PI) / 180)
                                                            yOut = distance * Math.sin((45 * Math.PI) / 180)
                                                            xIn = -xOut
                                                            yIn = -yOut
                                                            break
                                                        case 'left':
                                                            xOut = -distance
                                                            yOut = 0
                                                            xIn = -xOut
                                                            yIn = 0
                                                            break
                                                        default:
                                                            xOut = distance
                                                            yOut = 0
                                                            xIn = -distance
                                                            yIn = 0
                                                    }
                                            
                                                    tl.to(
                                                        icon, {
                                                            keyframes: [
                                                                { x: xOut, y: yOut, duration: 0.23, ease: 'power2.in' },
                                                                { x: xIn, y: yIn, duration: 0 },
                                                                { x: 0, y: 0, duration: 0.23, ease: 'power2.out' },
                                                            ],
                                                        },
                                                        0,
                                                    )
                                                }
                                            
                                                // Characters shine with stagger (only if not custom content)
                                                if (chars.length > 0) {
                                                    tl.to(
                                                        chars, {
                                                            keyframes: {
                                                                opacity: [1, 0.4, 1],
                                                            },
                                                            duration: 0.15,
                                                            ease: 'sine.inOut',
                                                            stagger: 0.02,
                                                        },
                                                        0.1,
                                                    )
                                                }
                                            
                                                motion.hover(button, () => {
                                                    tl.tweenTo(tl.duration())
                                            
                                                    return () => {
                                                        tl.tweenTo(0)
                                                    }
                                                })
                                            }">
                                            <a href="/docs/tables" target="_blank" rel="noopener noreferrer"
                                                aria-label="View documentation for Filament tables"
                                                class="group inline-flex w-full items-center justify-between rounded-full font-medium whitespace-nowrap text-stone-900 transition duration-300 ease-out will-change-transform hover:scale-y-102 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset h-13 gap-2.5 pr-1.25 pl-5 bg-cream-100 hover:bg-honey-100 ">
                                                <span data-text class="grow">
                                                    View docs
                                                </span>


                                                <div data-icon
                                                    class="relative isolate grid shrink-0 place-items-center overflow-hidden rounded-full size-11 bg-serenade-50 text-stone-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.25"
                                                        style="transform: rotate(0deg)" viewBox="0 0 28 22"
                                                        fill="none">
                                                        <path class="fill-current"
                                                            d="M1 10H5.96046e-08V12H1V10ZM27 12C27.5523 12 28 11.5523 28 11C28 10.4477 27.5523 10 27 10V12ZM18 1V5.96046e-08H16V1H18ZM26.4207 11.7774C26.9055 12.0419 27.5129 11.8632 27.7774 11.3783C28.0419 10.8935 27.8632 10.286 27.3783 10.0216L26.4207 11.7774ZM15.9999 20.8995V21.8995H17.9999V20.8995H15.9999ZM1 12H26.8994V10H1V12ZM26.8994 12H27V10H26.8994V12ZM16 1C16 2.47241 16.7953 3.87873 17.7716 5.0769C18.7678 6.29956 20.0716 7.44977 21.3383 8.42854C22.6109 9.41186 23.8784 10.2469 24.825 10.835C25.2993 11.1295 25.6952 11.3635 25.9738 11.5245C26.1131 11.605 26.2233 11.6674 26.2993 11.71C26.3374 11.7314 26.3669 11.7478 26.3873 11.7591C26.3975 11.7647 26.4055 11.7691 26.411 11.7721C26.4138 11.7737 26.416 11.7749 26.4176 11.7758C26.4184 11.7762 26.4191 11.7765 26.4196 11.7768C26.4199 11.777 26.4201 11.7771 26.4202 11.7772C26.4205 11.7773 26.4207 11.7774 26.8995 10.8995C27.3783 10.0216 27.3784 10.0217 27.3785 10.0217C27.3785 10.0217 27.3785 10.0217 27.3785 10.0217C27.3784 10.0216 27.3781 10.0215 27.3777 10.0213C27.3769 10.0208 27.3756 10.0201 27.3736 10.019C27.3697 10.0168 27.3634 10.0134 27.3549 10.0087C27.3378 9.99926 27.3118 9.98479 27.2773 9.96547C27.2084 9.92682 27.1058 9.86878 26.9745 9.79288C26.7117 9.64102 26.3342 9.41799 25.8804 9.13606C24.9708 8.57104 23.7635 7.77501 22.5612 6.84596C21.353 5.91235 20.182 4.86894 19.322 3.81356C18.4422 2.73371 18 1.77759 18 1H16ZM26.8994 11C26.5248 10.0728 26.5245 10.0729 26.5242 10.0731C26.524 10.0731 26.5237 10.0733 26.5234 10.0734C26.5228 10.0736 26.522 10.0739 26.5211 10.0743C26.5193 10.0751 26.5169 10.076 26.5138 10.0773C26.5078 10.0797 26.4994 10.0832 26.4888 10.0876C26.4674 10.0964 26.4369 10.1091 26.3979 10.1257C26.3199 10.1587 26.2077 10.2071 26.0662 10.2703C25.7834 10.3967 25.3826 10.5825 24.903 10.824C23.9463 11.3055 22.6639 12.0142 21.3751 12.919C20.0914 13.8201 18.7665 14.94 17.7546 16.2535C16.7415 17.5685 15.9999 19.1342 15.9999 20.8995H17.9999C17.9999 19.715 18.4958 18.5685 19.3389 17.4742C20.1831 16.3784 21.333 15.3922 22.5242 14.5559C23.7103 13.7232 24.9028 13.0632 25.8022 12.6104C26.2507 12.3846 26.6233 12.2119 26.8818 12.0965C27.011 12.0388 27.1115 11.9955 27.1785 11.967C27.212 11.9528 27.2371 11.9424 27.2533 11.9357C27.2613 11.9324 27.2671 11.93 27.2706 11.9286C27.2724 11.9279 27.2735 11.9274 27.2741 11.9271C27.2744 11.927 27.2745 11.927 27.2745 11.927C27.2745 11.927 27.2744 11.927 27.2744 11.927C27.2742 11.9271 27.274 11.9272 26.8994 11Z" />
                                                    </svg>
                                                </div>
                                            </a>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                            <div x-show="activeTab === 'forms'" x-transition:enter="tab-enter"
                                x-transition:enter-start="tab-enter-start" x-transition:enter-end="tab-enter-end"
                                x-transition:leave="tab-leave" x-transition:leave-start="tab-leave-start"
                                x-transition:leave-end="tab-leave-end" x-cloak id="tab-panel-forms">
                                <div>

                                    <div data-animate="enter-from-top" class="relative z-1 -ml-13 inline-grid">
                                        <div
                                            class="relative -top-4 z-1 self-start justify-self-center [grid-area:1/-1]">
                                            <img src="https://filamentphp.com/build/assets/forms-DBh2qSR6.webp"
                                                alt="Filament Forms" width="207" height="300"
                                                aria-hidden="true" class="h-25 w-auto" />
                                        </div>
                                        <img src="https://filamentphp.com/build/assets/mini-isometric-grid-BrbSNZpX.webp"
                                            alt="" width="186" height="112" aria-hidden="true"
                                            class="relative z-0 h-20 -rotate-7 self-end justify-self-center mask-x-from-80% [grid-area:1/-1]" />
                                    </div>


                                    <div data-animate="text-reveal-lines"
                                        class="mt-3 font-outfit text-xl font-medium text-stone-800 md:text-2xl"
                                        role="heading" aria-level="2">
                                        Forms
                                    </div>


                                    <p data-animate="enter-from-left" class="mt-1 max-w-md md:mt-2 md:text-lg">
                                        Build complex forms using composable input components that handle state
                                        management, validation rules, inter-field dependencies, and flexible layout
                                        composition.
                                    </p>


                                    <nav data-animate="enter-from-bottom" class="mt-3 inline-flex md:mt-4">
                                        <div x-data data-button-pulse class="rounded-full bg-cream-100"
                                            aria-label="View documentation for Filament forms"
                                            x-init="async () => {
                                                await window.FilamentAnimations.waitForFonts()
                                            
                                                const button = $el.querySelector('a')
                                                const textWrapper = button.querySelector('[data-text]')
                                                const icon = button.querySelector('[data-icon] svg')
                                                const hasCustomIcon = false
                                                const hasCustomContent = false
                                                const animateIcon = true
                                            
                                                const tl = gsap.timeline({ paused: true })
                                            
                                                // Only animate text if not using custom content
                                                let chars = []
                                                if (!hasCustomContent && textWrapper) {
                                                    const split = new SplitText(textWrapper, { type: 'chars' })
                                                    chars = split.chars
                                                }
                                            
                                                if (hasCustomIcon && animateIcon) {
                                                    // Custom icon animation: subtle scale and lift
                                                    tl.to(
                                                        icon, {
                                                            scale: 1.1,
                                                            rotation: 0.01,
                                                            duration: 0.3,
                                                            ease: 'sine.out',
                                                        },
                                                        0,
                                                    )
                                                } else if (!hasCustomIcon) {
                                                    // Arrow animation
                                                    const direction = 'right'
                                                    const distance = 30
                                            
                                                    let xOut, yOut, xIn, yIn
                                            
                                                    switch (direction) {
                                                        case 'top-right':
                                                            xOut = distance * Math.cos((-45 * Math.PI) / 180)
                                                            yOut = distance * Math.sin((-45 * Math.PI) / 180)
                                                            xIn = -xOut
                                                            yIn = -yOut
                                                            break
                                                        case 'bottom-right':
                                                            xOut = distance * Math.cos((45 * Math.PI) / 180)
                                                            yOut = distance * Math.sin((45 * Math.PI) / 180)
                                                            xIn = -xOut
                                                            yIn = -yOut
                                                            break
                                                        case 'left':
                                                            xOut = -distance
                                                            yOut = 0
                                                            xIn = -xOut
                                                            yIn = 0
                                                            break
                                                        default:
                                                            xOut = distance
                                                            yOut = 0
                                                            xIn = -distance
                                                            yIn = 0
                                                    }
                                            
                                                    tl.to(
                                                        icon, {
                                                            keyframes: [
                                                                { x: xOut, y: yOut, duration: 0.23, ease: 'power2.in' },
                                                                { x: xIn, y: yIn, duration: 0 },
                                                                { x: 0, y: 0, duration: 0.23, ease: 'power2.out' },
                                                            ],
                                                        },
                                                        0,
                                                    )
                                                }
                                            
                                                // Characters shine with stagger (only if not custom content)
                                                if (chars.length > 0) {
                                                    tl.to(
                                                        chars, {
                                                            keyframes: {
                                                                opacity: [1, 0.4, 1],
                                                            },
                                                            duration: 0.15,
                                                            ease: 'sine.inOut',
                                                            stagger: 0.02,
                                                        },
                                                        0.1,
                                                    )
                                                }
                                            
                                                motion.hover(button, () => {
                                                    tl.tweenTo(tl.duration())
                                            
                                                    return () => {
                                                        tl.tweenTo(0)
                                                    }
                                                })
                                            }">
                                            <a href="/docs/forms" target="_blank" rel="noopener noreferrer"
                                                aria-label="View documentation for Filament forms"
                                                class="group inline-flex w-full items-center justify-between rounded-full font-medium whitespace-nowrap text-stone-900 transition duration-300 ease-out will-change-transform hover:scale-y-102 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset h-13 gap-2.5 pr-1.25 pl-5 bg-cream-100 hover:bg-honey-100 ">
                                                <span data-text class="grow">
                                                    View docs
                                                </span>


                                                <div data-icon
                                                    class="relative isolate grid shrink-0 place-items-center overflow-hidden rounded-full size-11 bg-serenade-50 text-stone-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.25"
                                                        style="transform: rotate(0deg)" viewBox="0 0 28 22"
                                                        fill="none">
                                                        <path class="fill-current"
                                                            d="M1 10H5.96046e-08V12H1V10ZM27 12C27.5523 12 28 11.5523 28 11C28 10.4477 27.5523 10 27 10V12ZM18 1V5.96046e-08H16V1H18ZM26.4207 11.7774C26.9055 12.0419 27.5129 11.8632 27.7774 11.3783C28.0419 10.8935 27.8632 10.286 27.3783 10.0216L26.4207 11.7774ZM15.9999 20.8995V21.8995H17.9999V20.8995H15.9999ZM1 12H26.8994V10H1V12ZM26.8994 12H27V10H26.8994V12ZM16 1C16 2.47241 16.7953 3.87873 17.7716 5.0769C18.7678 6.29956 20.0716 7.44977 21.3383 8.42854C22.6109 9.41186 23.8784 10.2469 24.825 10.835C25.2993 11.1295 25.6952 11.3635 25.9738 11.5245C26.1131 11.605 26.2233 11.6674 26.2993 11.71C26.3374 11.7314 26.3669 11.7478 26.3873 11.7591C26.3975 11.7647 26.4055 11.7691 26.411 11.7721C26.4138 11.7737 26.416 11.7749 26.4176 11.7758C26.4184 11.7762 26.4191 11.7765 26.4196 11.7768C26.4199 11.777 26.4201 11.7771 26.4202 11.7772C26.4205 11.7773 26.4207 11.7774 26.8995 10.8995C27.3783 10.0216 27.3784 10.0217 27.3785 10.0217C27.3785 10.0217 27.3785 10.0217 27.3785 10.0217C27.3784 10.0216 27.3781 10.0215 27.3777 10.0213C27.3769 10.0208 27.3756 10.0201 27.3736 10.019C27.3697 10.0168 27.3634 10.0134 27.3549 10.0087C27.3378 9.99926 27.3118 9.98479 27.2773 9.96547C27.2084 9.92682 27.1058 9.86878 26.9745 9.79288C26.7117 9.64102 26.3342 9.41799 25.8804 9.13606C24.9708 8.57104 23.7635 7.77501 22.5612 6.84596C21.353 5.91235 20.182 4.86894 19.322 3.81356C18.4422 2.73371 18 1.77759 18 1H16ZM26.8994 11C26.5248 10.0728 26.5245 10.0729 26.5242 10.0731C26.524 10.0731 26.5237 10.0733 26.5234 10.0734C26.5228 10.0736 26.522 10.0739 26.5211 10.0743C26.5193 10.0751 26.5169 10.076 26.5138 10.0773C26.5078 10.0797 26.4994 10.0832 26.4888 10.0876C26.4674 10.0964 26.4369 10.1091 26.3979 10.1257C26.3199 10.1587 26.2077 10.2071 26.0662 10.2703C25.7834 10.3967 25.3826 10.5825 24.903 10.824C23.9463 11.3055 22.6639 12.0142 21.3751 12.919C20.0914 13.8201 18.7665 14.94 17.7546 16.2535C16.7415 17.5685 15.9999 19.1342 15.9999 20.8995H17.9999C17.9999 19.715 18.4958 18.5685 19.3389 17.4742C20.1831 16.3784 21.333 15.3922 22.5242 14.5559C23.7103 13.7232 24.9028 13.0632 25.8022 12.6104C26.2507 12.3846 26.6233 12.2119 26.8818 12.0965C27.011 12.0388 27.1115 11.9955 27.1785 11.967C27.212 11.9528 27.2371 11.9424 27.2533 11.9357C27.2613 11.9324 27.2671 11.93 27.2706 11.9286C27.2724 11.9279 27.2735 11.9274 27.2741 11.9271C27.2744 11.927 27.2745 11.927 27.2745 11.927C27.2745 11.927 27.2744 11.927 27.2744 11.927C27.2742 11.9271 27.274 11.9272 26.8994 11Z" />
                                                    </svg>
                                                </div>
                                            </a>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                            <div x-show="activeTab === 'infolists'" x-transition:enter="tab-enter"
                                x-transition:enter-start="tab-enter-start" x-transition:enter-end="tab-enter-end"
                                x-transition:leave="tab-leave" x-transition:leave-start="tab-leave-start"
                                x-transition:leave-end="tab-leave-end" x-cloak id="tab-panel-infolists">
                                <div>

                                    <div data-animate="enter-from-top" class="relative z-1 -ml-13 inline-grid">
                                        <div
                                            class="relative -top-4 z-1 self-start justify-self-center [grid-area:1/-1]">
                                            <img src="https://filamentphp.com/build/assets/infolists-BWAlkNkB.webp"
                                                alt="Filament Infolists" width="207" height="300"
                                                aria-hidden="true" class="h-25 w-auto" />
                                        </div>
                                        <img src="https://filamentphp.com/build/assets/mini-isometric-grid-BrbSNZpX.webp"
                                            alt="" width="186" height="112" aria-hidden="true"
                                            class="relative z-0 h-20 -rotate-7 self-end justify-self-center mask-x-from-80% [grid-area:1/-1]" />
                                    </div>


                                    <div data-animate="text-reveal-lines"
                                        class="mt-3 font-outfit text-xl font-medium text-stone-800 md:text-2xl"
                                        role="heading" aria-level="2">
                                        Infolists
                                    </div>


                                    <p data-animate="enter-from-left" class="mt-1 max-w-md md:mt-2 md:text-lg">
                                        Render structured, read-only record views using responsive layouts, and
                                        formatting helpers. Suitable for detail pages, side panels, and inspection-style
                                        interfaces.
                                    </p>


                                    <nav data-animate="enter-from-bottom" class="mt-3 inline-flex md:mt-4">
                                        <div x-data data-button-pulse class="rounded-full bg-cream-100"
                                            aria-label="View documentation for Filament infolists"
                                            x-init="async () => {
                                                await window.FilamentAnimations.waitForFonts()
                                            
                                                const button = $el.querySelector('a')
                                                const textWrapper = button.querySelector('[data-text]')
                                                const icon = button.querySelector('[data-icon] svg')
                                                const hasCustomIcon = false
                                                const hasCustomContent = false
                                                const animateIcon = true
                                            
                                                const tl = gsap.timeline({ paused: true })
                                            
                                                // Only animate text if not using custom content
                                                let chars = []
                                                if (!hasCustomContent && textWrapper) {
                                                    const split = new SplitText(textWrapper, { type: 'chars' })
                                                    chars = split.chars
                                                }
                                            
                                                if (hasCustomIcon && animateIcon) {
                                                    // Custom icon animation: subtle scale and lift
                                                    tl.to(
                                                        icon, {
                                                            scale: 1.1,
                                                            rotation: 0.01,
                                                            duration: 0.3,
                                                            ease: 'sine.out',
                                                        },
                                                        0,
                                                    )
                                                } else if (!hasCustomIcon) {
                                                    // Arrow animation
                                                    const direction = 'right'
                                                    const distance = 30
                                            
                                                    let xOut, yOut, xIn, yIn
                                            
                                                    switch (direction) {
                                                        case 'top-right':
                                                            xOut = distance * Math.cos((-45 * Math.PI) / 180)
                                                            yOut = distance * Math.sin((-45 * Math.PI) / 180)
                                                            xIn = -xOut
                                                            yIn = -yOut
                                                            break
                                                        case 'bottom-right':
                                                            xOut = distance * Math.cos((45 * Math.PI) / 180)
                                                            yOut = distance * Math.sin((45 * Math.PI) / 180)
                                                            xIn = -xOut
                                                            yIn = -yOut
                                                            break
                                                        case 'left':
                                                            xOut = -distance
                                                            yOut = 0
                                                            xIn = -xOut
                                                            yIn = 0
                                                            break
                                                        default:
                                                            xOut = distance
                                                            yOut = 0
                                                            xIn = -distance
                                                            yIn = 0
                                                    }
                                            
                                                    tl.to(
                                                        icon, {
                                                            keyframes: [
                                                                { x: xOut, y: yOut, duration: 0.23, ease: 'power2.in' },
                                                                { x: xIn, y: yIn, duration: 0 },
                                                                { x: 0, y: 0, duration: 0.23, ease: 'power2.out' },
                                                            ],
                                                        },
                                                        0,
                                                    )
                                                }
                                            
                                                // Characters shine with stagger (only if not custom content)
                                                if (chars.length > 0) {
                                                    tl.to(
                                                        chars, {
                                                            keyframes: {
                                                                opacity: [1, 0.4, 1],
                                                            },
                                                            duration: 0.15,
                                                            ease: 'sine.inOut',
                                                            stagger: 0.02,
                                                        },
                                                        0.1,
                                                    )
                                                }
                                            
                                                motion.hover(button, () => {
                                                    tl.tweenTo(tl.duration())
                                            
                                                    return () => {
                                                        tl.tweenTo(0)
                                                    }
                                                })
                                            }">
                                            <a href="/docs/infolists" target="_blank" rel="noopener noreferrer"
                                                aria-label="View documentation for Filament infolists"
                                                class="group inline-flex w-full items-center justify-between rounded-full font-medium whitespace-nowrap text-stone-900 transition duration-300 ease-out will-change-transform hover:scale-y-102 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset h-13 gap-2.5 pr-1.25 pl-5 bg-cream-100 hover:bg-honey-100 ">
                                                <span data-text class="grow">
                                                    View docs
                                                </span>


                                                <div data-icon
                                                    class="relative isolate grid shrink-0 place-items-center overflow-hidden rounded-full size-11 bg-serenade-50 text-stone-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.25"
                                                        style="transform: rotate(0deg)" viewBox="0 0 28 22"
                                                        fill="none">
                                                        <path class="fill-current"
                                                            d="M1 10H5.96046e-08V12H1V10ZM27 12C27.5523 12 28 11.5523 28 11C28 10.4477 27.5523 10 27 10V12ZM18 1V5.96046e-08H16V1H18ZM26.4207 11.7774C26.9055 12.0419 27.5129 11.8632 27.7774 11.3783C28.0419 10.8935 27.8632 10.286 27.3783 10.0216L26.4207 11.7774ZM15.9999 20.8995V21.8995H17.9999V20.8995H15.9999ZM1 12H26.8994V10H1V12ZM26.8994 12H27V10H26.8994V12ZM16 1C16 2.47241 16.7953 3.87873 17.7716 5.0769C18.7678 6.29956 20.0716 7.44977 21.3383 8.42854C22.6109 9.41186 23.8784 10.2469 24.825 10.835C25.2993 11.1295 25.6952 11.3635 25.9738 11.5245C26.1131 11.605 26.2233 11.6674 26.2993 11.71C26.3374 11.7314 26.3669 11.7478 26.3873 11.7591C26.3975 11.7647 26.4055 11.7691 26.411 11.7721C26.4138 11.7737 26.416 11.7749 26.4176 11.7758C26.4184 11.7762 26.4191 11.7765 26.4196 11.7768C26.4199 11.777 26.4201 11.7771 26.4202 11.7772C26.4205 11.7773 26.4207 11.7774 26.8995 10.8995C27.3783 10.0216 27.3784 10.0217 27.3785 10.0217C27.3785 10.0217 27.3785 10.0217 27.3785 10.0217C27.3784 10.0216 27.3781 10.0215 27.3777 10.0213C27.3769 10.0208 27.3756 10.0201 27.3736 10.019C27.3697 10.0168 27.3634 10.0134 27.3549 10.0087C27.3378 9.99926 27.3118 9.98479 27.2773 9.96547C27.2084 9.92682 27.1058 9.86878 26.9745 9.79288C26.7117 9.64102 26.3342 9.41799 25.8804 9.13606C24.9708 8.57104 23.7635 7.77501 22.5612 6.84596C21.353 5.91235 20.182 4.86894 19.322 3.81356C18.4422 2.73371 18 1.77759 18 1H16ZM26.8994 11C26.5248 10.0728 26.5245 10.0729 26.5242 10.0731C26.524 10.0731 26.5237 10.0733 26.5234 10.0734C26.5228 10.0736 26.522 10.0739 26.5211 10.0743C26.5193 10.0751 26.5169 10.076 26.5138 10.0773C26.5078 10.0797 26.4994 10.0832 26.4888 10.0876C26.4674 10.0964 26.4369 10.1091 26.3979 10.1257C26.3199 10.1587 26.2077 10.2071 26.0662 10.2703C25.7834 10.3967 25.3826 10.5825 24.903 10.824C23.9463 11.3055 22.6639 12.0142 21.3751 12.919C20.0914 13.8201 18.7665 14.94 17.7546 16.2535C16.7415 17.5685 15.9999 19.1342 15.9999 20.8995H17.9999C17.9999 19.715 18.4958 18.5685 19.3389 17.4742C20.1831 16.3784 21.333 15.3922 22.5242 14.5559C23.7103 13.7232 24.9028 13.0632 25.8022 12.6104C26.2507 12.3846 26.6233 12.2119 26.8818 12.0965C27.011 12.0388 27.1115 11.9955 27.1785 11.967C27.212 11.9528 27.2371 11.9424 27.2533 11.9357C27.2613 11.9324 27.2671 11.93 27.2706 11.9286C27.2724 11.9279 27.2735 11.9274 27.2741 11.9271C27.2744 11.927 27.2745 11.927 27.2745 11.927C27.2745 11.927 27.2744 11.927 27.2744 11.927C27.2742 11.9271 27.274 11.9272 26.8994 11Z" />
                                                    </svg>
                                                </div>
                                            </a>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                            <div x-show="activeTab === 'notifications'" x-transition:enter="tab-enter"
                                x-transition:enter-start="tab-enter-start" x-transition:enter-end="tab-enter-end"
                                x-transition:leave="tab-leave" x-transition:leave-start="tab-leave-start"
                                x-transition:leave-end="tab-leave-end" x-cloak id="tab-panel-notifications">
                                <div>

                                    <div data-animate="enter-from-top" class="relative z-1 -ml-13 inline-grid">
                                        <div
                                            class="relative -top-4 z-1 self-start justify-self-center [grid-area:1/-1]">
                                            <img src="https://filamentphp.com/build/assets/notifications-2B3pqYd6.webp"
                                                alt="Filament Notifications" width="207" height="300"
                                                aria-hidden="true" class="h-25 w-auto" />
                                        </div>
                                        <img src="https://filamentphp.com/build/assets/mini-isometric-grid-BrbSNZpX.webp"
                                            alt="" width="186" height="112" aria-hidden="true"
                                            class="relative z-0 h-20 -rotate-7 self-end justify-self-center mask-x-from-80% [grid-area:1/-1]" />
                                    </div>


                                    <div data-animate="text-reveal-lines"
                                        class="mt-3 font-outfit text-xl font-medium text-stone-800 md:text-2xl"
                                        role="heading" aria-level="2">
                                        Notifications
                                    </div>


                                    <p data-animate="enter-from-left" class="mt-1 max-w-md md:mt-2 md:text-lg">
                                        Trigger in-app notifications in response to user actions and system events, with
                                        flexible content options and integration with Laravel&#039;s notification system
                                        for seamless delivery.
                                    </p>


                                    <nav data-animate="enter-from-bottom" class="mt-3 inline-flex md:mt-4">
                                        <div x-data data-button-pulse class="rounded-full bg-cream-100"
                                            aria-label="View documentation for Filament notifications"
                                            x-init="async () => {
                                                await window.FilamentAnimations.waitForFonts()
                                            
                                                const button = $el.querySelector('a')
                                                const textWrapper = button.querySelector('[data-text]')
                                                const icon = button.querySelector('[data-icon] svg')
                                                const hasCustomIcon = false
                                                const hasCustomContent = false
                                                const animateIcon = true
                                            
                                                const tl = gsap.timeline({ paused: true })
                                            
                                                // Only animate text if not using custom content
                                                let chars = []
                                                if (!hasCustomContent && textWrapper) {
                                                    const split = new SplitText(textWrapper, { type: 'chars' })
                                                    chars = split.chars
                                                }
                                            
                                                if (hasCustomIcon && animateIcon) {
                                                    // Custom icon animation: subtle scale and lift
                                                    tl.to(
                                                        icon, {
                                                            scale: 1.1,
                                                            rotation: 0.01,
                                                            duration: 0.3,
                                                            ease: 'sine.out',
                                                        },
                                                        0,
                                                    )
                                                } else if (!hasCustomIcon) {
                                                    // Arrow animation
                                                    const direction = 'right'
                                                    const distance = 30
                                            
                                                    let xOut, yOut, xIn, yIn
                                            
                                                    switch (direction) {
                                                        case 'top-right':
                                                            xOut = distance * Math.cos((-45 * Math.PI) / 180)
                                                            yOut = distance * Math.sin((-45 * Math.PI) / 180)
                                                            xIn = -xOut
                                                            yIn = -yOut
                                                            break
                                                        case 'bottom-right':
                                                            xOut = distance * Math.cos((45 * Math.PI) / 180)
                                                            yOut = distance * Math.sin((45 * Math.PI) / 180)
                                                            xIn = -xOut
                                                            yIn = -yOut
                                                            break
                                                        case 'left':
                                                            xOut = -distance
                                                            yOut = 0
                                                            xIn = -xOut
                                                            yIn = 0
                                                            break
                                                        default:
                                                            xOut = distance
                                                            yOut = 0
                                                            xIn = -distance
                                                            yIn = 0
                                                    }
                                            
                                                    tl.to(
                                                        icon, {
                                                            keyframes: [
                                                                { x: xOut, y: yOut, duration: 0.23, ease: 'power2.in' },
                                                                { x: xIn, y: yIn, duration: 0 },
                                                                { x: 0, y: 0, duration: 0.23, ease: 'power2.out' },
                                                            ],
                                                        },
                                                        0,
                                                    )
                                                }
                                            
                                                // Characters shine with stagger (only if not custom content)
                                                if (chars.length > 0) {
                                                    tl.to(
                                                        chars, {
                                                            keyframes: {
                                                                opacity: [1, 0.4, 1],
                                                            },
                                                            duration: 0.15,
                                                            ease: 'sine.inOut',
                                                            stagger: 0.02,
                                                        },
                                                        0.1,
                                                    )
                                                }
                                            
                                                motion.hover(button, () => {
                                                    tl.tweenTo(tl.duration())
                                            
                                                    return () => {
                                                        tl.tweenTo(0)
                                                    }
                                                })
                                            }">
                                            <a href="/docs/notifications" target="_blank"
                                                rel="noopener noreferrer"
                                                aria-label="View documentation for Filament notifications"
                                                class="group inline-flex w-full items-center justify-between rounded-full font-medium whitespace-nowrap text-stone-900 transition duration-300 ease-out will-change-transform hover:scale-y-102 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset h-13 gap-2.5 pr-1.25 pl-5 bg-cream-100 hover:bg-honey-100 ">
                                                <span data-text class="grow">
                                                    View docs
                                                </span>


                                                <div data-icon
                                                    class="relative isolate grid shrink-0 place-items-center overflow-hidden rounded-full size-11 bg-serenade-50 text-stone-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.25"
                                                        style="transform: rotate(0deg)" viewBox="0 0 28 22"
                                                        fill="none">
                                                        <path class="fill-current"
                                                            d="M1 10H5.96046e-08V12H1V10ZM27 12C27.5523 12 28 11.5523 28 11C28 10.4477 27.5523 10 27 10V12ZM18 1V5.96046e-08H16V1H18ZM26.4207 11.7774C26.9055 12.0419 27.5129 11.8632 27.7774 11.3783C28.0419 10.8935 27.8632 10.286 27.3783 10.0216L26.4207 11.7774ZM15.9999 20.8995V21.8995H17.9999V20.8995H15.9999ZM1 12H26.8994V10H1V12ZM26.8994 12H27V10H26.8994V12ZM16 1C16 2.47241 16.7953 3.87873 17.7716 5.0769C18.7678 6.29956 20.0716 7.44977 21.3383 8.42854C22.6109 9.41186 23.8784 10.2469 24.825 10.835C25.2993 11.1295 25.6952 11.3635 25.9738 11.5245C26.1131 11.605 26.2233 11.6674 26.2993 11.71C26.3374 11.7314 26.3669 11.7478 26.3873 11.7591C26.3975 11.7647 26.4055 11.7691 26.411 11.7721C26.4138 11.7737 26.416 11.7749 26.4176 11.7758C26.4184 11.7762 26.4191 11.7765 26.4196 11.7768C26.4199 11.777 26.4201 11.7771 26.4202 11.7772C26.4205 11.7773 26.4207 11.7774 26.8995 10.8995C27.3783 10.0216 27.3784 10.0217 27.3785 10.0217C27.3785 10.0217 27.3785 10.0217 27.3785 10.0217C27.3784 10.0216 27.3781 10.0215 27.3777 10.0213C27.3769 10.0208 27.3756 10.0201 27.3736 10.019C27.3697 10.0168 27.3634 10.0134 27.3549 10.0087C27.3378 9.99926 27.3118 9.98479 27.2773 9.96547C27.2084 9.92682 27.1058 9.86878 26.9745 9.79288C26.7117 9.64102 26.3342 9.41799 25.8804 9.13606C24.9708 8.57104 23.7635 7.77501 22.5612 6.84596C21.353 5.91235 20.182 4.86894 19.322 3.81356C18.4422 2.73371 18 1.77759 18 1H16ZM26.8994 11C26.5248 10.0728 26.5245 10.0729 26.5242 10.0731C26.524 10.0731 26.5237 10.0733 26.5234 10.0734C26.5228 10.0736 26.522 10.0739 26.5211 10.0743C26.5193 10.0751 26.5169 10.076 26.5138 10.0773C26.5078 10.0797 26.4994 10.0832 26.4888 10.0876C26.4674 10.0964 26.4369 10.1091 26.3979 10.1257C26.3199 10.1587 26.2077 10.2071 26.0662 10.2703C25.7834 10.3967 25.3826 10.5825 24.903 10.824C23.9463 11.3055 22.6639 12.0142 21.3751 12.919C20.0914 13.8201 18.7665 14.94 17.7546 16.2535C16.7415 17.5685 15.9999 19.1342 15.9999 20.8995H17.9999C17.9999 19.715 18.4958 18.5685 19.3389 17.4742C20.1831 16.3784 21.333 15.3922 22.5242 14.5559C23.7103 13.7232 24.9028 13.0632 25.8022 12.6104C26.2507 12.3846 26.6233 12.2119 26.8818 12.0965C27.011 12.0388 27.1115 11.9955 27.1785 11.967C27.212 11.9528 27.2371 11.9424 27.2533 11.9357C27.2613 11.9324 27.2671 11.93 27.2706 11.9286C27.2724 11.9279 27.2735 11.9274 27.2741 11.9271C27.2744 11.927 27.2745 11.927 27.2745 11.927C27.2745 11.927 27.2744 11.927 27.2744 11.927C27.2742 11.9271 27.274 11.9272 26.8994 11Z" />
                                                    </svg>
                                                </div>
                                            </a>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                            <div x-show="activeTab === 'widgets'" x-transition:enter="tab-enter"
                                x-transition:enter-start="tab-enter-start" x-transition:enter-end="tab-enter-end"
                                x-transition:leave="tab-leave" x-transition:leave-start="tab-leave-start"
                                x-transition:leave-end="tab-leave-end" x-cloak id="tab-panel-widgets">
                                <div>

                                    <div data-animate="enter-from-top" class="relative z-1 -ml-13 inline-grid">
                                        <div
                                            class="relative -top-4 z-1 self-start justify-self-center [grid-area:1/-1]">
                                            <img src="https://filamentphp.com/build/assets/widgets-CmQeBJZ7.webp"
                                                alt="Filament Dashboard widgets" width="207" height="300"
                                                aria-hidden="true" class="h-25 w-auto" />
                                        </div>
                                        <img src="https://filamentphp.com/build/assets/mini-isometric-grid-BrbSNZpX.webp"
                                            alt="" width="186" height="112" aria-hidden="true"
                                            class="relative z-0 h-20 -rotate-7 self-end justify-self-center mask-x-from-80% [grid-area:1/-1]" />
                                    </div>


                                    <div data-animate="text-reveal-lines"
                                        class="mt-3 font-outfit text-xl font-medium text-stone-800 md:text-2xl"
                                        role="heading" aria-level="2">
                                        Dashboard widgets
                                    </div>


                                    <p data-animate="enter-from-left" class="mt-1 max-w-md md:mt-2 md:text-lg">
                                        Display metrics, aggregates, charts, and recent activity using data-driven
                                        widgets that can query models, refresh automatically, and be arranged across
                                        dashboard layouts.
                                    </p>


                                    <nav data-animate="enter-from-bottom" class="mt-3 inline-flex md:mt-4">
                                        <div x-data data-button-pulse class="rounded-full bg-cream-100"
                                            aria-label="View documentation for Filament dashboard widgets"
                                            x-init="async () => {
                                                await window.FilamentAnimations.waitForFonts()
                                            
                                                const button = $el.querySelector('a')
                                                const textWrapper = button.querySelector('[data-text]')
                                                const icon = button.querySelector('[data-icon] svg')
                                                const hasCustomIcon = false
                                                const hasCustomContent = false
                                                const animateIcon = true
                                            
                                                const tl = gsap.timeline({ paused: true })
                                            
                                                // Only animate text if not using custom content
                                                let chars = []
                                                if (!hasCustomContent && textWrapper) {
                                                    const split = new SplitText(textWrapper, { type: 'chars' })
                                                    chars = split.chars
                                                }
                                            
                                                if (hasCustomIcon && animateIcon) {
                                                    // Custom icon animation: subtle scale and lift
                                                    tl.to(
                                                        icon, {
                                                            scale: 1.1,
                                                            rotation: 0.01,
                                                            duration: 0.3,
                                                            ease: 'sine.out',
                                                        },
                                                        0,
                                                    )
                                                } else if (!hasCustomIcon) {
                                                    // Arrow animation
                                                    const direction = 'right'
                                                    const distance = 30
                                            
                                                    let xOut, yOut, xIn, yIn
                                            
                                                    switch (direction) {
                                                        case 'top-right':
                                                            xOut = distance * Math.cos((-45 * Math.PI) / 180)
                                                            yOut = distance * Math.sin((-45 * Math.PI) / 180)
                                                            xIn = -xOut
                                                            yIn = -yOut
                                                            break
                                                        case 'bottom-right':
                                                            xOut = distance * Math.cos((45 * Math.PI) / 180)
                                                            yOut = distance * Math.sin((45 * Math.PI) / 180)
                                                            xIn = -xOut
                                                            yIn = -yOut
                                                            break
                                                        case 'left':
                                                            xOut = -distance
                                                            yOut = 0
                                                            xIn = -xOut
                                                            yIn = 0
                                                            break
                                                        default:
                                                            xOut = distance
                                                            yOut = 0
                                                            xIn = -distance
                                                            yIn = 0
                                                    }
                                            
                                                    tl.to(
                                                        icon, {
                                                            keyframes: [
                                                                { x: xOut, y: yOut, duration: 0.23, ease: 'power2.in' },
                                                                { x: xIn, y: yIn, duration: 0 },
                                                                { x: 0, y: 0, duration: 0.23, ease: 'power2.out' },
                                                            ],
                                                        },
                                                        0,
                                                    )
                                                }
                                            
                                                // Characters shine with stagger (only if not custom content)
                                                if (chars.length > 0) {
                                                    tl.to(
                                                        chars, {
                                                            keyframes: {
                                                                opacity: [1, 0.4, 1],
                                                            },
                                                            duration: 0.15,
                                                            ease: 'sine.inOut',
                                                            stagger: 0.02,
                                                        },
                                                        0.1,
                                                    )
                                                }
                                            
                                                motion.hover(button, () => {
                                                    tl.tweenTo(tl.duration())
                                            
                                                    return () => {
                                                        tl.tweenTo(0)
                                                    }
                                                })
                                            }">
                                            <a href="/docs/widgets" target="_blank" rel="noopener noreferrer"
                                                aria-label="View documentation for Filament dashboard widgets"
                                                class="group inline-flex w-full items-center justify-between rounded-full font-medium whitespace-nowrap text-stone-900 transition duration-300 ease-out will-change-transform hover:scale-y-102 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset h-13 gap-2.5 pr-1.25 pl-5 bg-cream-100 hover:bg-honey-100 ">
                                                <span data-text class="grow">
                                                    View docs
                                                </span>


                                                <div data-icon
                                                    class="relative isolate grid shrink-0 place-items-center overflow-hidden rounded-full size-11 bg-serenade-50 text-stone-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.25"
                                                        style="transform: rotate(0deg)" viewBox="0 0 28 22"
                                                        fill="none">
                                                        <path class="fill-current"
                                                            d="M1 10H5.96046e-08V12H1V10ZM27 12C27.5523 12 28 11.5523 28 11C28 10.4477 27.5523 10 27 10V12ZM18 1V5.96046e-08H16V1H18ZM26.4207 11.7774C26.9055 12.0419 27.5129 11.8632 27.7774 11.3783C28.0419 10.8935 27.8632 10.286 27.3783 10.0216L26.4207 11.7774ZM15.9999 20.8995V21.8995H17.9999V20.8995H15.9999ZM1 12H26.8994V10H1V12ZM26.8994 12H27V10H26.8994V12ZM16 1C16 2.47241 16.7953 3.87873 17.7716 5.0769C18.7678 6.29956 20.0716 7.44977 21.3383 8.42854C22.6109 9.41186 23.8784 10.2469 24.825 10.835C25.2993 11.1295 25.6952 11.3635 25.9738 11.5245C26.1131 11.605 26.2233 11.6674 26.2993 11.71C26.3374 11.7314 26.3669 11.7478 26.3873 11.7591C26.3975 11.7647 26.4055 11.7691 26.411 11.7721C26.4138 11.7737 26.416 11.7749 26.4176 11.7758C26.4184 11.7762 26.4191 11.7765 26.4196 11.7768C26.4199 11.777 26.4201 11.7771 26.4202 11.7772C26.4205 11.7773 26.4207 11.7774 26.8995 10.8995C27.3783 10.0216 27.3784 10.0217 27.3785 10.0217C27.3785 10.0217 27.3785 10.0217 27.3785 10.0217C27.3784 10.0216 27.3781 10.0215 27.3777 10.0213C27.3769 10.0208 27.3756 10.0201 27.3736 10.019C27.3697 10.0168 27.3634 10.0134 27.3549 10.0087C27.3378 9.99926 27.3118 9.98479 27.2773 9.96547C27.2084 9.92682 27.1058 9.86878 26.9745 9.79288C26.7117 9.64102 26.3342 9.41799 25.8804 9.13606C24.9708 8.57104 23.7635 7.77501 22.5612 6.84596C21.353 5.91235 20.182 4.86894 19.322 3.81356C18.4422 2.73371 18 1.77759 18 1H16ZM26.8994 11C26.5248 10.0728 26.5245 10.0729 26.5242 10.0731C26.524 10.0731 26.5237 10.0733 26.5234 10.0734C26.5228 10.0736 26.522 10.0739 26.5211 10.0743C26.5193 10.0751 26.5169 10.076 26.5138 10.0773C26.5078 10.0797 26.4994 10.0832 26.4888 10.0876C26.4674 10.0964 26.4369 10.1091 26.3979 10.1257C26.3199 10.1587 26.2077 10.2071 26.0662 10.2703C25.7834 10.3967 25.3826 10.5825 24.903 10.824C23.9463 11.3055 22.6639 12.0142 21.3751 12.919C20.0914 13.8201 18.7665 14.94 17.7546 16.2535C16.7415 17.5685 15.9999 19.1342 15.9999 20.8995H17.9999C17.9999 19.715 18.4958 18.5685 19.3389 17.4742C20.1831 16.3784 21.333 15.3922 22.5242 14.5559C23.7103 13.7232 24.9028 13.0632 25.8022 12.6104C26.2507 12.3846 26.6233 12.2119 26.8818 12.0965C27.011 12.0388 27.1115 11.9955 27.1785 11.967C27.212 11.9528 27.2371 11.9424 27.2533 11.9357C27.2613 11.9324 27.2671 11.93 27.2706 11.9286C27.2724 11.9279 27.2735 11.9274 27.2741 11.9271C27.2744 11.927 27.2745 11.927 27.2745 11.927C27.2745 11.927 27.2744 11.927 27.2744 11.927C27.2742 11.9271 27.274 11.9272 26.8994 11Z" />
                                                    </svg>
                                                </div>
                                            </a>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                            <div x-show="activeTab === 'actions'" x-transition:enter="tab-enter"
                                x-transition:enter-start="tab-enter-start" x-transition:enter-end="tab-enter-end"
                                x-transition:leave="tab-leave" x-transition:leave-start="tab-leave-start"
                                x-transition:leave-end="tab-leave-end" x-cloak id="tab-panel-actions">
                                <div>

                                    <div data-animate="enter-from-top" class="relative z-1 -ml-13 inline-grid">
                                        <div
                                            class="relative -top-4 z-1 self-start justify-self-center [grid-area:1/-1]">
                                            <img src="https://filamentphp.com/build/assets/actions-CMfN2rMT.webp"
                                                alt="Filament Action modals" width="207" height="300"
                                                aria-hidden="true" class="h-25 w-auto" />
                                        </div>
                                        <img src="https://filamentphp.com/build/assets/mini-isometric-grid-BrbSNZpX.webp"
                                            alt="" width="186" height="112" aria-hidden="true"
                                            class="relative z-0 h-20 -rotate-7 self-end justify-self-center mask-x-from-80% [grid-area:1/-1]" />
                                    </div>


                                    <div data-animate="text-reveal-lines"
                                        class="mt-3 font-outfit text-xl font-medium text-stone-800 md:text-2xl"
                                        role="heading" aria-level="2">
                                        Action modals
                                    </div>


                                    <p data-animate="enter-from-left" class="mt-1 max-w-md md:mt-2 md:text-lg">
                                        Define reusable actions with buttons, dropdowns, and bulk triggers, supporting
                                        confirmation steps, modal forms, authorization checks, and synchronous or queued
                                        execution.
                                    </p>


                                    <nav data-animate="enter-from-bottom" class="mt-3 inline-flex md:mt-4">
                                        <div x-data data-button-pulse class="rounded-full bg-cream-100"
                                            aria-label="View documentation for Filament action modals"
                                            x-init="async () => {
                                                await window.FilamentAnimations.waitForFonts()
                                            
                                                const button = $el.querySelector('a')
                                                const textWrapper = button.querySelector('[data-text]')
                                                const icon = button.querySelector('[data-icon] svg')
                                                const hasCustomIcon = false
                                                const hasCustomContent = false
                                                const animateIcon = true
                                            
                                                const tl = gsap.timeline({ paused: true })
                                            
                                                // Only animate text if not using custom content
                                                let chars = []
                                                if (!hasCustomContent && textWrapper) {
                                                    const split = new SplitText(textWrapper, { type: 'chars' })
                                                    chars = split.chars
                                                }
                                            
                                                if (hasCustomIcon && animateIcon) {
                                                    // Custom icon animation: subtle scale and lift
                                                    tl.to(
                                                        icon, {
                                                            scale: 1.1,
                                                            rotation: 0.01,
                                                            duration: 0.3,
                                                            ease: 'sine.out',
                                                        },
                                                        0,
                                                    )
                                                } else if (!hasCustomIcon) {
                                                    // Arrow animation
                                                    const direction = 'right'
                                                    const distance = 30
                                            
                                                    let xOut, yOut, xIn, yIn
                                            
                                                    switch (direction) {
                                                        case 'top-right':
                                                            xOut = distance * Math.cos((-45 * Math.PI) / 180)
                                                            yOut = distance * Math.sin((-45 * Math.PI) / 180)
                                                            xIn = -xOut
                                                            yIn = -yOut
                                                            break
                                                        case 'bottom-right':
                                                            xOut = distance * Math.cos((45 * Math.PI) / 180)
                                                            yOut = distance * Math.sin((45 * Math.PI) / 180)
                                                            xIn = -xOut
                                                            yIn = -yOut
                                                            break
                                                        case 'left':
                                                            xOut = -distance
                                                            yOut = 0
                                                            xIn = -xOut
                                                            yIn = 0
                                                            break
                                                        default:
                                                            xOut = distance
                                                            yOut = 0
                                                            xIn = -distance
                                                            yIn = 0
                                                    }
                                            
                                                    tl.to(
                                                        icon, {
                                                            keyframes: [
                                                                { x: xOut, y: yOut, duration: 0.23, ease: 'power2.in' },
                                                                { x: xIn, y: yIn, duration: 0 },
                                                                { x: 0, y: 0, duration: 0.23, ease: 'power2.out' },
                                                            ],
                                                        },
                                                        0,
                                                    )
                                                }
                                            
                                                // Characters shine with stagger (only if not custom content)
                                                if (chars.length > 0) {
                                                    tl.to(
                                                        chars, {
                                                            keyframes: {
                                                                opacity: [1, 0.4, 1],
                                                            },
                                                            duration: 0.15,
                                                            ease: 'sine.inOut',
                                                            stagger: 0.02,
                                                        },
                                                        0.1,
                                                    )
                                                }
                                            
                                                motion.hover(button, () => {
                                                    tl.tweenTo(tl.duration())
                                            
                                                    return () => {
                                                        tl.tweenTo(0)
                                                    }
                                                })
                                            }">
                                            <a href="/docs/actions" target="_blank" rel="noopener noreferrer"
                                                aria-label="View documentation for Filament action modals"
                                                class="group inline-flex w-full items-center justify-between rounded-full font-medium whitespace-nowrap text-stone-900 transition duration-300 ease-out will-change-transform hover:scale-y-102 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset h-13 gap-2.5 pr-1.25 pl-5 bg-cream-100 hover:bg-honey-100 ">
                                                <span data-text class="grow">
                                                    View docs
                                                </span>


                                                <div data-icon
                                                    class="relative isolate grid shrink-0 place-items-center overflow-hidden rounded-full size-11 bg-serenade-50 text-stone-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.25"
                                                        style="transform: rotate(0deg)" viewBox="0 0 28 22"
                                                        fill="none">
                                                        <path class="fill-current"
                                                            d="M1 10H5.96046e-08V12H1V10ZM27 12C27.5523 12 28 11.5523 28 11C28 10.4477 27.5523 10 27 10V12ZM18 1V5.96046e-08H16V1H18ZM26.4207 11.7774C26.9055 12.0419 27.5129 11.8632 27.7774 11.3783C28.0419 10.8935 27.8632 10.286 27.3783 10.0216L26.4207 11.7774ZM15.9999 20.8995V21.8995H17.9999V20.8995H15.9999ZM1 12H26.8994V10H1V12ZM26.8994 12H27V10H26.8994V12ZM16 1C16 2.47241 16.7953 3.87873 17.7716 5.0769C18.7678 6.29956 20.0716 7.44977 21.3383 8.42854C22.6109 9.41186 23.8784 10.2469 24.825 10.835C25.2993 11.1295 25.6952 11.3635 25.9738 11.5245C26.1131 11.605 26.2233 11.6674 26.2993 11.71C26.3374 11.7314 26.3669 11.7478 26.3873 11.7591C26.3975 11.7647 26.4055 11.7691 26.411 11.7721C26.4138 11.7737 26.416 11.7749 26.4176 11.7758C26.4184 11.7762 26.4191 11.7765 26.4196 11.7768C26.4199 11.777 26.4201 11.7771 26.4202 11.7772C26.4205 11.7773 26.4207 11.7774 26.8995 10.8995C27.3783 10.0216 27.3784 10.0217 27.3785 10.0217C27.3785 10.0217 27.3785 10.0217 27.3785 10.0217C27.3784 10.0216 27.3781 10.0215 27.3777 10.0213C27.3769 10.0208 27.3756 10.0201 27.3736 10.019C27.3697 10.0168 27.3634 10.0134 27.3549 10.0087C27.3378 9.99926 27.3118 9.98479 27.2773 9.96547C27.2084 9.92682 27.1058 9.86878 26.9745 9.79288C26.7117 9.64102 26.3342 9.41799 25.8804 9.13606C24.9708 8.57104 23.7635 7.77501 22.5612 6.84596C21.353 5.91235 20.182 4.86894 19.322 3.81356C18.4422 2.73371 18 1.77759 18 1H16ZM26.8994 11C26.5248 10.0728 26.5245 10.0729 26.5242 10.0731C26.524 10.0731 26.5237 10.0733 26.5234 10.0734C26.5228 10.0736 26.522 10.0739 26.5211 10.0743C26.5193 10.0751 26.5169 10.076 26.5138 10.0773C26.5078 10.0797 26.4994 10.0832 26.4888 10.0876C26.4674 10.0964 26.4369 10.1091 26.3979 10.1257C26.3199 10.1587 26.2077 10.2071 26.0662 10.2703C25.7834 10.3967 25.3826 10.5825 24.903 10.824C23.9463 11.3055 22.6639 12.0142 21.3751 12.919C20.0914 13.8201 18.7665 14.94 17.7546 16.2535C16.7415 17.5685 15.9999 19.1342 15.9999 20.8995H17.9999C17.9999 19.715 18.4958 18.5685 19.3389 17.4742C20.1831 16.3784 21.333 15.3922 22.5242 14.5559C23.7103 13.7232 24.9028 13.0632 25.8022 12.6104C26.2507 12.3846 26.6233 12.2119 26.8818 12.0965C27.011 12.0388 27.1115 11.9955 27.1785 11.967C27.212 11.9528 27.2371 11.9424 27.2533 11.9357C27.2613 11.9324 27.2671 11.93 27.2706 11.9286C27.2724 11.9279 27.2735 11.9274 27.2741 11.9271C27.2744 11.927 27.2745 11.927 27.2745 11.927C27.2745 11.927 27.2744 11.927 27.2744 11.927C27.2742 11.9271 27.274 11.9272 26.8994 11Z" />
                                                    </svg>
                                                </div>
                                            </a>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                        </div>


                        <div data-animate="enter-from-right" class="w-full shrink-0 lg:max-w-lg">

                            <div
                                class="relative flex h-8.5 items-center gap-2 rounded-tl-lg rounded-tr-lg border-b border-b-white/5 bg-[#21272D] px-3 pt-0.5">

                                <div class="flex items-center gap-1.25">
                                    <div class="size-2 rounded-full bg-honey-200"></div>
                                    <div class="size-2 rounded-full bg-flamingo"></div>
                                    <div class="size-2 rounded-full bg-powder-200"></div>
                                </div>


                                <div
                                    class="absolute top-1/2 right-1/2 translate-x-1/2 -translate-y-1/2 pt-0.5 text-sm text-white/50">
                                    <div class="relative overflow-hidden">
                                        <span x-show="activeTab === 'tables'"
                                            x-transition:enter="transition duration-200 ease-out"
                                            x-transition:enter-start="-translate-y-3 opacity-0"
                                            x-transition:enter-end="translate-y-0 opacity-100"
                                            x-transition:leave="absolute inset-0 transition duration-150 ease-in"
                                            x-transition:leave-start="translate-y-0 opacity-100"
                                            x-transition:leave-end="translate-y-3 opacity-0" x-cloak class="block">
                                            OrdersTable.php
                                        </span>
                                        <span x-show="activeTab === 'forms'"
                                            x-transition:enter="transition duration-200 ease-out"
                                            x-transition:enter-start="-translate-y-3 opacity-0"
                                            x-transition:enter-end="translate-y-0 opacity-100"
                                            x-transition:leave="absolute inset-0 transition duration-150 ease-in"
                                            x-transition:leave-start="translate-y-0 opacity-100"
                                            x-transition:leave-end="translate-y-3 opacity-0" x-cloak class="block">
                                            PostForm.php
                                        </span>
                                        <span x-show="activeTab === 'infolists'"
                                            x-transition:enter="transition duration-200 ease-out"
                                            x-transition:enter-start="-translate-y-3 opacity-0"
                                            x-transition:enter-end="translate-y-0 opacity-100"
                                            x-transition:leave="absolute inset-0 transition duration-150 ease-in"
                                            x-transition:leave-start="translate-y-0 opacity-100"
                                            x-transition:leave-end="translate-y-3 opacity-0" x-cloak class="block">
                                            UserInfolist.php
                                        </span>
                                        <span x-show="activeTab === 'notifications'"
                                            x-transition:enter="transition duration-200 ease-out"
                                            x-transition:enter-start="-translate-y-3 opacity-0"
                                            x-transition:enter-end="translate-y-0 opacity-100"
                                            x-transition:leave="absolute inset-0 transition duration-150 ease-in"
                                            x-transition:leave-start="translate-y-0 opacity-100"
                                            x-transition:leave-end="translate-y-3 opacity-0" x-cloak class="block">
                                            ReportGeneratedNotification.php
                                        </span>
                                        <span x-show="activeTab === 'widgets'"
                                            x-transition:enter="transition duration-200 ease-out"
                                            x-transition:enter-start="-translate-y-3 opacity-0"
                                            x-transition:enter-end="translate-y-0 opacity-100"
                                            x-transition:leave="absolute inset-0 transition duration-150 ease-in"
                                            x-transition:leave-start="translate-y-0 opacity-100"
                                            x-transition:leave-end="translate-y-3 opacity-0" x-cloak class="block">
                                            AnalyticsWidget.php
                                        </span>
                                        <span x-show="activeTab === 'actions'"
                                            x-transition:enter="transition duration-200 ease-out"
                                            x-transition:enter-start="-translate-y-3 opacity-0"
                                            x-transition:enter-end="translate-y-0 opacity-100"
                                            x-transition:leave="absolute inset-0 transition duration-150 ease-in"
                                            x-transition:leave-start="translate-y-0 opacity-100"
                                            x-transition:leave-end="translate-y-3 opacity-0" x-cloak class="block">
                                            ArchivePostAction.php
                                        </span>
                                    </div>
                                </div>
                            </div>


                            <div class="phiki-code-wrapper" x-init="$el.querySelectorAll('pre').forEach((pre) => pre.setAttribute('tabindex', '0'))">
                                <div class="relative overflow-hidden rounded-br-lg rounded-bl-lg bg-[#101010]">

                                    <div x-show="activeTab === 'tables'" x-transition:enter="tab-enter"
                                        x-transition:enter-start="tab-enter-start"
                                        x-transition:enter-end="tab-enter-end" x-transition:leave="tab-leave"
                                        x-transition:leave-start="tab-leave-start"
                                        x-transition:leave-end="tab-leave-end" x-cloak>
                                        <pre class="phiki language-php vesper" data-language="php" style="background-color: #101010;color: #FFF;"><code><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 1</span><span class="token" style="color: #FFF;">$</span><span class="token" style="color: #FFF;">table</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 2</span><span class="token">	</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">columns</span><span class="token">(</span><span class="token">[</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 3</span><span class="token">		</span><span class="token" style="color: #FFC799;">TextColumn</span><span class="token" style="color: #A0A0A0;">::</span><span class="token" style="color: #FFC799;">make</span><span class="token">(</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token" style="color: #99FFE4;">number</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 4</span><span class="token">			</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">sortable</span><span class="token">(</span><span class="token">)</span><span class="token">,</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 5</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 6</span><span class="token">		</span><span class="token" style="color: #FFC799;">TextColumn</span><span class="token" style="color: #A0A0A0;">::</span><span class="token" style="color: #FFC799;">make</span><span class="token">(</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token" style="color: #99FFE4;">user.email</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 7</span><span class="token">			</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">label</span><span class="token">(</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token" style="color: #99FFE4;">Customer</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 8</span><span class="token">			</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">searchable</span><span class="token">(</span><span class="token">)</span><span class="token">,</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 9</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">10</span><span class="token">		</span><span class="token" style="color: #FFC799;">IconColumn</span><span class="token" style="color: #A0A0A0;">::</span><span class="token" style="color: #FFC799;">make</span><span class="token">(</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token" style="color: #99FFE4;">is_priority</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">11</span><span class="token">			</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">boolean</span><span class="token">(</span><span class="token">)</span><span class="token">,</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">12</span><span class="token">	</span><span class="token">]</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">13</span><span class="token">	</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">filters</span><span class="token">(</span><span class="token">[</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">14</span><span class="token">		</span><span class="token" style="color: #FFC799;">SelectFilter</span><span class="token" style="color: #A0A0A0;">::</span><span class="token" style="color: #FFC799;">make</span><span class="token">(</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token" style="color: #99FFE4;">status</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token">)</span><span class="token">,</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">15</span><span class="token">	</span><span class="token">]</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">16</span><span class="token">	</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">bulkActions</span><span class="token">(</span><span class="token">[</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">17</span><span class="token">		</span><span class="token" style="color: #FFC799;">DeleteBulkAction</span><span class="token" style="color: #A0A0A0;">::</span><span class="token" style="color: #FFC799;">make</span><span class="token">(</span><span class="token">)</span><span class="token">,</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">18</span><span class="token">	</span><span class="token">]</span><span class="token">)</span><span class="token">;</span><span class="token">
</span></span></code></pre>
                                    </div>

                                    <div x-show="activeTab === 'forms'" x-transition:enter="tab-enter"
                                        x-transition:enter-start="tab-enter-start"
                                        x-transition:enter-end="tab-enter-end" x-transition:leave="tab-leave"
                                        x-transition:leave-start="tab-leave-start"
                                        x-transition:leave-end="tab-leave-end" x-cloak>
                                        <pre class="phiki language-php vesper" data-language="php" style="background-color: #101010;color: #FFF;"><code><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 1</span><span class="token" style="color: #FFF;">$</span><span class="token" style="color: #FFF;">schema</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 2</span><span class="token">	</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">components</span><span class="token">(</span><span class="token">[</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 3</span><span class="token">		</span><span class="token" style="color: #FFC799;">TextInput</span><span class="token" style="color: #A0A0A0;">::</span><span class="token" style="color: #FFC799;">make</span><span class="token">(</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token" style="color: #99FFE4;">title</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 4</span><span class="token">			</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">required</span><span class="token">(</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 5</span><span class="token">			</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">maxLength</span><span class="token">(</span><span class="token" style="color: #FFC799;">255</span><span class="token">)</span><span class="token">,</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 6</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 7</span><span class="token">		</span><span class="token" style="color: #FFC799;">DateTimePicker</span><span class="token" style="color: #A0A0A0;">::</span><span class="token" style="color: #FFC799;">make</span><span class="token">(</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token" style="color: #99FFE4;">published_at</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token">)</span><span class="token">,</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 8</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 9</span><span class="token">		</span><span class="token" style="color: #FFC799;">Toggle</span><span class="token" style="color: #A0A0A0;">::</span><span class="token" style="color: #FFC799;">make</span><span class="token">(</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token" style="color: #99FFE4;">is_featured</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">10</span><span class="token">			</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">live</span><span class="token">(</span><span class="token">)</span><span class="token">,</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">11</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">12</span><span class="token">		</span><span class="token" style="color: #FFC799;">Textarea</span><span class="token" style="color: #A0A0A0;">::</span><span class="token" style="color: #FFC799;">make</span><span class="token">(</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token" style="color: #99FFE4;">featured_description</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">13</span><span class="token">			</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">maxLength</span><span class="token">(</span><span class="token" style="color: #FFC799;">500</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">14</span><span class="token">			</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">visible</span><span class="token">(</span><span class="token" style="color: #A0A0A0;">function</span><span class="token"> </span><span class="token">(</span><span class="token" style="color: #FFC799;">Get</span><span class="token"> </span><span class="token" style="color: #FFF;">$</span><span class="token" style="color: #FFF;">get</span><span class="token">)</span><span class="token" style="color: #A0A0A0;">:</span><span class="token"> </span><span class="token" style="color: #FFC799;">bool</span><span class="token"> </span><span class="token">{</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">15</span><span class="token">				</span><span class="token" style="color: #A0A0A0;">return</span><span class="token"> </span><span class="token" style="color: #FFF;">$</span><span class="token" style="color: #FFF;">get</span><span class="token">(</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token" style="color: #99FFE4;">is_featured</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token">)</span><span class="token">;</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">16</span><span class="token">			</span><span class="token">}</span><span class="token">)</span><span class="token">,</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">17</span><span class="token">	</span><span class="token">]</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">18</span><span class="token">	</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">columns</span><span class="token">(</span><span class="token" style="color: #FFC799;">2</span><span class="token">)</span><span class="token">;</span><span class="token">
</span></span></code></pre>
                                    </div>

                                    <div x-show="activeTab === 'infolists'" x-transition:enter="tab-enter"
                                        x-transition:enter-start="tab-enter-start"
                                        x-transition:enter-end="tab-enter-end" x-transition:leave="tab-leave"
                                        x-transition:leave-start="tab-leave-start"
                                        x-transition:leave-end="tab-leave-end" x-cloak>
                                        <pre class="phiki language-php vesper" data-language="php" style="background-color: #101010;color: #FFF;"><code><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 1</span><span class="token" style="color: #FFF;">$</span><span class="token" style="color: #FFF;">schema</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 2</span><span class="token">	</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">components</span><span class="token">(</span><span class="token">[</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 3</span><span class="token">		</span><span class="token" style="color: #FFC799;">TextEntry</span><span class="token" style="color: #A0A0A0;">::</span><span class="token" style="color: #FFC799;">make</span><span class="token">(</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token" style="color: #99FFE4;">email</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token">)</span><span class="token">,</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 4</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 5</span><span class="token">		</span><span class="token" style="color: #FFC799;">TextEntry</span><span class="token" style="color: #A0A0A0;">::</span><span class="token" style="color: #FFC799;">make</span><span class="token">(</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token" style="color: #99FFE4;">roles.name</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 6</span><span class="token">			</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">badge</span><span class="token">(</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 7</span><span class="token">			</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">columnSpanFull</span><span class="token">(</span><span class="token">)</span><span class="token">,</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 8</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 9</span><span class="token">		</span><span class="token" style="color: #FFC799;">Section</span><span class="token" style="color: #A0A0A0;">::</span><span class="token" style="color: #FFC799;">make</span><span class="token">(</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token" style="color: #99FFE4;">Verification</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">10</span><span class="token">			</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">schema</span><span class="token">(</span><span class="token">[</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">11</span><span class="token">				</span><span class="token" style="color: #FFC799;">IconEntry</span><span class="token" style="color: #A0A0A0;">::</span><span class="token" style="color: #FFC799;">make</span><span class="token">(</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token" style="color: #99FFE4;">is_verified</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">12</span><span class="token">					</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">boolean</span><span class="token">(</span><span class="token">)</span><span class="token">,</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">13</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">14</span><span class="token">				</span><span class="token" style="color: #FFC799;">TextEntry</span><span class="token" style="color: #A0A0A0;">::</span><span class="token" style="color: #FFC799;">make</span><span class="token">(</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token" style="color: #99FFE4;">next_check_at</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">15</span><span class="token">					</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">dateTime</span><span class="token">(</span><span class="token">)</span><span class="token">,</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">16</span><span class="token">			</span><span class="token">]</span><span class="token">)</span><span class="token">,</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">17</span><span class="token">	</span><span class="token">]</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">18</span><span class="token">	</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">columns</span><span class="token">(</span><span class="token" style="color: #FFC799;">2</span><span class="token">)</span><span class="token">;</span><span class="token">
</span></span></code></pre>
                                    </div>

                                    <div x-show="activeTab === 'notifications'" x-transition:enter="tab-enter"
                                        x-transition:enter-start="tab-enter-start"
                                        x-transition:enter-end="tab-enter-end" x-transition:leave="tab-leave"
                                        x-transition:leave-start="tab-leave-start"
                                        x-transition:leave-end="tab-leave-end" x-cloak>
                                        <pre class="phiki language-php vesper" data-language="php" style="background-color: #101010;color: #FFF;"><code><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 1</span><span class="token" style="color: #FFC799;">Notification</span><span class="token" style="color: #A0A0A0;">::</span><span class="token" style="color: #FFC799;">make</span><span class="token">(</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 2</span><span class="token">	</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">title</span><span class="token">(</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token" style="color: #99FFE4;">Report generated</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 3</span><span class="token">	</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">body</span><span class="token">(</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token" style="color: #99FFE4;">The monthly report is ready to check.</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 4</span><span class="token">	</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">icon</span><span class="token">(</span><span class="token" style="color: #FFC799;">Heroicon</span><span class="token" style="color: #A0A0A0;">::</span><span class="token">DocumentChartBar</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 5</span><span class="token">	</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">actions</span><span class="token">(</span><span class="token">[</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 6</span><span class="token">		</span><span class="token" style="color: #FFC799;">Action</span><span class="token" style="color: #A0A0A0;">::</span><span class="token" style="color: #FFC799;">make</span><span class="token">(</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token" style="color: #99FFE4;">download</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 7</span><span class="token">			</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">color</span><span class="token">(</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token" style="color: #99FFE4;">primary</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 8</span><span class="token">			</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">icon</span><span class="token">(</span><span class="token" style="color: #FFC799;">Heroicon</span><span class="token" style="color: #A0A0A0;">::</span><span class="token">ArrowDownTray</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 9</span><span class="token">			</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">url</span><span class="token">(</span><span class="token" style="color: #FFC799;">route</span><span class="token">(</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token" style="color: #99FFE4;">reports.download</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token">,</span><span class="token"> </span><span class="token" style="color: #FFF;">$</span><span class="token" style="color: #FFF;">report</span><span class="token">)</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">10</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">11</span><span class="token">		</span><span class="token" style="color: #FFC799;">Action</span><span class="token" style="color: #A0A0A0;">::</span><span class="token" style="color: #FFC799;">make</span><span class="token">(</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token" style="color: #99FFE4;">view</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">12</span><span class="token">			</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">color</span><span class="token">(</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token" style="color: #99FFE4;">gray</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">13</span><span class="token">			</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">icon</span><span class="token">(</span><span class="token" style="color: #FFC799;">Heroicon</span><span class="token" style="color: #A0A0A0;">::</span><span class="token">Eye</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">14</span><span class="token">			</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">url</span><span class="token">(</span><span class="token" style="color: #FFC799;">route</span><span class="token">(</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token" style="color: #99FFE4;">reports.view</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token">,</span><span class="token"> </span><span class="token" style="color: #FFF;">$</span><span class="token" style="color: #FFF;">report</span><span class="token">)</span><span class="token">)</span><span class="token">,</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">15</span><span class="token">	</span><span class="token">]</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">16</span><span class="token">	</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">success</span><span class="token">(</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">17</span><span class="token">	</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">persistent</span><span class="token">(</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">18</span><span class="token">	</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">send</span><span class="token">(</span><span class="token">)</span><span class="token">;</span><span class="token">
</span></span></code></pre>
                                    </div>

                                    <div x-show="activeTab === 'widgets'" x-transition:enter="tab-enter"
                                        x-transition:enter-start="tab-enter-start"
                                        x-transition:enter-end="tab-enter-end" x-transition:leave="tab-leave"
                                        x-transition:leave-start="tab-leave-start"
                                        x-transition:leave-end="tab-leave-end" x-cloak>
                                        <pre class="phiki language-php vesper" data-language="php" style="background-color: #101010;color: #FFF;"><code><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 1</span><span class="token" style="color: #FFF;">$</span><span class="token" style="color: #FFF;">uniqueViews</span><span class="token"> </span><span class="token" style="color: #A0A0A0;">=</span><span class="token"> </span><span class="token" style="color: #FFF;">$</span><span class="token" style="color: #FFF;">service</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">getUniqueViews</span><span class="token">(</span><span class="token">)</span><span class="token">;</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 2</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 3</span><span class="token" style="color: #FFF;">$</span><span class="token" style="color: #FFF;">totalSales</span><span class="token"> </span><span class="token" style="color: #A0A0A0;">=</span><span class="token"> </span><span class="token" style="color: #FFF;">$</span><span class="token" style="color: #FFF;">service</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">getTotalSales</span><span class="token">(</span><span class="token">)</span><span class="token">;</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 4</span><span class="token" style="color: #FFF;">$</span><span class="token" style="color: #FFF;">totalSalesChange</span><span class="token"> </span><span class="token" style="color: #A0A0A0;">=</span><span class="token"> </span><span class="token" style="color: #FFF;">$</span><span class="token" style="color: #FFF;">service</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">getTotalSalesChange</span><span class="token">(</span><span class="token">)</span><span class="token">;</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 5</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 6</span><span class="token" style="color: #A0A0A0;">return</span><span class="token"> </span><span class="token">[</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 7</span><span class="token">	</span><span class="token" style="color: #FFC799;">Stat</span><span class="token" style="color: #A0A0A0;">::</span><span class="token" style="color: #FFC799;">make</span><span class="token">(</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token" style="color: #99FFE4;">Unique views</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token">,</span><span class="token"> </span><span class="token" style="color: #FFF;">$</span><span class="token" style="color: #FFF;">uniqueViews</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 8</span><span class="token">		</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">icon</span><span class="token">(</span><span class="token" style="color: #FFC799;">Heroicon</span><span class="token" style="color: #A0A0A0;">::</span><span class="token">Eye</span><span class="token">)</span><span class="token">,</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 9</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">10</span><span class="token">	</span><span class="token" style="color: #FFC799;">Stat</span><span class="token" style="color: #A0A0A0;">::</span><span class="token" style="color: #FFC799;">make</span><span class="token">(</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token" style="color: #99FFE4;">Total sales</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token">,</span><span class="token"> </span><span class="token" style="color: #FFF;">$</span><span class="token" style="color: #FFF;">totalSales</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">11</span><span class="token">		</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">color</span><span class="token">(</span><span class="token">(</span><span class="token" style="color: #FFF;">$</span><span class="token" style="color: #FFF;">totalSalesChange</span><span class="token"> </span><span class="token" style="color: #A0A0A0;">&gt;=</span><span class="token"> </span><span class="token" style="color: #FFC799;">0</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">12</span><span class="token">			</span><span class="token" style="color: #A0A0A0;">?</span><span class="token"> </span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token" style="color: #99FFE4;">success</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">13</span><span class="token">			</span><span class="token" style="color: #A0A0A0;">:</span><span class="token"> </span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token" style="color: #99FFE4;">danger</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">14</span><span class="token">		</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">descriptionIcon</span><span class="token">(</span><span class="token">(</span><span class="token" style="color: #FFF;">$</span><span class="token" style="color: #FFF;">totalSalesChange</span><span class="token"> </span><span class="token" style="color: #A0A0A0;">&gt;=</span><span class="token"> </span><span class="token" style="color: #FFC799;">0</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">15</span><span class="token">			</span><span class="token" style="color: #A0A0A0;">?</span><span class="token"> </span><span class="token" style="color: #FFC799;">Heroicon</span><span class="token" style="color: #A0A0A0;">::</span><span class="token">ArrowTrendingUp</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">16</span><span class="token">			</span><span class="token" style="color: #A0A0A0;">:</span><span class="token"> </span><span class="token" style="color: #FFC799;">Heroicon</span><span class="token" style="color: #A0A0A0;">::</span><span class="token">ArrowTrendingDown</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">17</span><span class="token">		</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">description</span><span class="token">(</span><span class="token" style="color: #FFC799;">abs</span><span class="token">(</span><span class="token" style="color: #FFF;">$</span><span class="token" style="color: #FFF;">totalSalesChange</span><span class="token">)</span><span class="token"> </span><span class="token" style="color: #A0A0A0;">.</span><span class="token"> </span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token" style="color: #99FFE4;">%</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token">)</span><span class="token">,</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">18</span><span class="token">]</span><span class="token">;</span><span class="token">
</span></span></code></pre>
                                    </div>

                                    <div x-show="activeTab === 'actions'" x-transition:enter="tab-enter"
                                        x-transition:enter-start="tab-enter-start"
                                        x-transition:enter-end="tab-enter-end" x-transition:leave="tab-leave"
                                        x-transition:leave-start="tab-leave-start"
                                        x-transition:leave-end="tab-leave-end" x-cloak>
                                        <pre class="phiki language-php vesper" data-language="php" style="background-color: #101010;color: #FFF;"><code><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 1</span><span class="token" style="color: #FFC799;">Action</span><span class="token" style="color: #A0A0A0;">::</span><span class="token" style="color: #FFC799;">make</span><span class="token">(</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token" style="color: #99FFE4;">archive</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 2</span><span class="token">	</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">icon</span><span class="token">(</span><span class="token" style="color: #FFC799;">Heroicon</span><span class="token" style="color: #A0A0A0;">::</span><span class="token">ArchiveBox</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 3</span><span class="token">	</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">requiresConfirmation</span><span class="token">(</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 4</span><span class="token">	</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">schema</span><span class="token">(</span><span class="token">[</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 5</span><span class="token">		</span><span class="token" style="color: #FFC799;">TextInput</span><span class="token" style="color: #A0A0A0;">::</span><span class="token" style="color: #FFC799;">make</span><span class="token">(</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token" style="color: #99FFE4;">reason</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 6</span><span class="token">			</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">label</span><span class="token">(</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token" style="color: #99FFE4;">Reason for archiving</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 7</span><span class="token">			</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">maxLength</span><span class="token">(</span><span class="token" style="color: #FFC799;">255</span><span class="token">)</span><span class="token">,</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 8</span><span class="token">	</span><span class="token">]</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none"> 9</span><span class="token">	</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">action</span><span class="token">(</span><span class="token" style="color: #A0A0A0;">function</span><span class="token"> </span><span class="token">(</span><span class="token" style="color: #FFC799;">Post</span><span class="token"> </span><span class="token" style="color: #FFF;">$</span><span class="token" style="color: #FFF;">post</span><span class="token">,</span><span class="token"> </span><span class="token" style="color: #FFC799;">array</span><span class="token"> </span><span class="token" style="color: #FFF;">$</span><span class="token" style="color: #FFF;">data</span><span class="token">)</span><span class="token"> </span><span class="token">{</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">10</span><span class="token">		</span><span class="token" style="color: #FFF;">$</span><span class="token" style="color: #FFF;">post</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFF;">archive_reason</span><span class="token"> </span><span class="token" style="color: #A0A0A0;">=</span><span class="token"> </span><span class="token" style="color: #FFF;">$</span><span class="token" style="color: #FFF;">data</span><span class="token">[</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token" style="color: #99FFE4;">reason</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token">]</span><span class="token">;</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">11</span><span class="token">		</span><span class="token" style="color: #FFF;">$</span><span class="token" style="color: #FFF;">post</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">touch</span><span class="token">(</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token" style="color: #99FFE4;">archived_at</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token">)</span><span class="token">;</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">12</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">13</span><span class="token">		</span><span class="token" style="color: #FFC799;">Notification</span><span class="token" style="color: #A0A0A0;">::</span><span class="token" style="color: #FFC799;">make</span><span class="token">(</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">14</span><span class="token">			</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">title</span><span class="token">(</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token" style="color: #99FFE4;">Post archived</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">15</span><span class="token">			</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">body</span><span class="token">(</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token" style="color: #99FFE4;">It can no longer be edited.</span><span class="token" style="color: #99FFE4;">&#039;</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">16</span><span class="token">			</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">success</span><span class="token">(</span><span class="token">)</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">17</span><span class="token">			</span><span class="token" style="color: #A0A0A0;">-&gt;</span><span class="token" style="color: #FFC799;">send</span><span class="token">(</span><span class="token">)</span><span class="token">;</span><span class="token">
</span></span><span class="line"><span class="line-number" style="color: #505050;-webkit-user-select: none">18</span><span class="token">	</span><span class="token">}</span><span class="token">)</span><span class="token">;</span><span class="token">
</span></span></code></pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <section data-triangle-decoration="bottom"
                class="border-b border-bone-100 px-8 py-10 sm:px-10 sm:py-15 lg:px-15 lg:py-20">

                <header class="flex flex-col items-center justify-center text-center">
                      <div x-data="{ shown: false }" x-intersect="shown = true"
             :class="shown ? 'opacity-100 scale-100' : 'opacity-0 scale-90'"
             class="transition-all duration-700 ease-out">
                        <svg aria-hidden="true" class="h-5 text-stone-800 lg:h-6"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 48 48">
                            <path class="stroke-current [stroke-width:var(--stroke-width,3)]" stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M2 28.5641S8 26 13 26c3.5274 0 7.4004 1.4179 9.9935 2.5866 1.9898 0.8968 3.1354 1.4628 3.591 3.5974 0.3166 1.4829 -0.749 3.9554 -2.2605 4.0771l-1.0647 0.0858m0 0c-2.4421 0 -6.2222 -0.724 -6.2222 -0.724m6.2222 0.724c3.3866 0 12.3032 -1.6086 15.4627 -2.1991 0.7538 -0.1409 1.5346 -0.2442 2.252 0.0266 0.9023 0.3406 2.1117 1.1633 2.6902 3.15 0.4519 1.5517 -0.6332 3.0446 -2.1404 3.6279C37.1039 42.6627 27.887 46 23.2593 46 11 46 2 42.9231 2 42.9231">
                            </path>
                            <path class="stroke-current [stroke-width:var(--stroke-width,3)]"
                                stroke-linejoin="round"
                                d="M46 10c0 -4 -2.5 -8 -7.4992 -8 -4.5008 0 -6.5 4 -6.5 4S30 2 25.5008 2C20.5008 2 18 6 18 10c0 5.9985 5.5363 10.8956 11.1866 14.3765 1.7262 1.0634 3.9022 1.0634 5.6284 -0.0001C40.4649 20.8955 46 15.9985 46 10Z">
                            </path>
                        </svg>
                    </div>
                    <p data-animate="text-reveal-lines"
                        class="mt-2.5 font-outfit text-2xl font-medium text-stone-800 md:text-3xl">
                        Our Premium
                    </p>
                    <h1 data-animate="text-reveal-lines">Sponsors</h1>
                    <p data-section-description data-animate="text-reveal-words" class="mt-3 max-w-4xl md:mt-4">
                        Filament is
                        <strong>proudly open-source.</strong>
                        It is thanks to the amazing generosity of our premium sponsors that
                        continued development, bug fixes, and dedicated community support is
                        possible.
                    </p>


                    <nav data-animate="enter-from-top" class="mt-3 md:mt-4">
                        <div x-data data-button-pulse class="rounded-full bg-flamingo/50"
                            aria-label="Sponsor Filament (opens in new window)" x-init="async () => {
                                await window.FilamentAnimations.waitForFonts()
                            
                                const button = $el.querySelector('a')
                                const textWrapper = button.querySelector('[data-text]')
                                const icon = button.querySelector('[data-icon] svg')
                                const hasCustomIcon = false
                                const hasCustomContent = false
                                const animateIcon = true
                            
                                const tl = gsap.timeline({ paused: true })
                            
                                // Only animate text if not using custom content
                                let chars = []
                                if (!hasCustomContent && textWrapper) {
                                    const split = new SplitText(textWrapper, { type: 'chars' })
                                    chars = split.chars
                                }
                            
                                if (hasCustomIcon && animateIcon) {
                                    // Custom icon animation: subtle scale and lift
                                    tl.to(
                                        icon, {
                                            scale: 1.1,
                                            rotation: 0.01,
                                            duration: 0.3,
                                            ease: 'sine.out',
                                        },
                                        0,
                                    )
                                } else if (!hasCustomIcon) {
                                    // Arrow animation
                                    const direction = 'bottom-right'
                                    const distance = 30
                            
                                    let xOut, yOut, xIn, yIn
                            
                                    switch (direction) {
                                        case 'top-right':
                                            xOut = distance * Math.cos((-45 * Math.PI) / 180)
                                            yOut = distance * Math.sin((-45 * Math.PI) / 180)
                                            xIn = -xOut
                                            yIn = -yOut
                                            break
                                        case 'bottom-right':
                                            xOut = distance * Math.cos((45 * Math.PI) / 180)
                                            yOut = distance * Math.sin((45 * Math.PI) / 180)
                                            xIn = -xOut
                                            yIn = -yOut
                                            break
                                        case 'left':
                                            xOut = -distance
                                            yOut = 0
                                            xIn = -xOut
                                            yIn = 0
                                            break
                                        default:
                                            xOut = distance
                                            yOut = 0
                                            xIn = -distance
                                            yIn = 0
                                    }
                            
                                    tl.to(
                                        icon, {
                                            keyframes: [
                                                { x: xOut, y: yOut, duration: 0.23, ease: 'power2.in' },
                                                { x: xIn, y: yIn, duration: 0 },
                                                { x: 0, y: 0, duration: 0.23, ease: 'power2.out' },
                                            ],
                                        },
                                        0,
                                    )
                                }
                            
                                // Characters shine with stagger (only if not custom content)
                                if (chars.length > 0) {
                                    tl.to(
                                        chars, {
                                            keyframes: {
                                                opacity: [1, 0.4, 1],
                                            },
                                            duration: 0.15,
                                            ease: 'sine.inOut',
                                            stagger: 0.02,
                                        },
                                        0.1,
                                    )
                                }
                            
                                motion.hover(button, () => {
                                    tl.tweenTo(tl.duration())
                            
                                    return () => {
                                        tl.tweenTo(0)
                                    }
                                })
                            }">
                            <a href="https://github.com/sponsors/danharrin" target="_blank"
                                rel="noopener noreferrer" aria-label="Sponsor Filament (opens in new window)"
                                class="group inline-flex w-full items-center justify-between rounded-full font-medium whitespace-nowrap text-stone-900 transition duration-300 ease-out will-change-transform hover:scale-y-102 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset h-13 gap-2.5 pr-1.25 pl-5 bg-flamingo/50 hover:bg-flamingo ">
                                <span data-text class="grow">
                                    Sponsor Filament
                                </span>


                                <div data-icon
                                    class="relative isolate grid shrink-0 place-items-center overflow-hidden rounded-full size-11 bg-stone-900 text-cream-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.25"
                                        style="transform: rotate(45deg)" viewBox="0 0 28 22" fill="none">
                                        <path class="fill-current"
                                            d="M1 10H5.96046e-08V12H1V10ZM27 12C27.5523 12 28 11.5523 28 11C28 10.4477 27.5523 10 27 10V12ZM18 1V5.96046e-08H16V1H18ZM26.4207 11.7774C26.9055 12.0419 27.5129 11.8632 27.7774 11.3783C28.0419 10.8935 27.8632 10.286 27.3783 10.0216L26.4207 11.7774ZM15.9999 20.8995V21.8995H17.9999V20.8995H15.9999ZM1 12H26.8994V10H1V12ZM26.8994 12H27V10H26.8994V12ZM16 1C16 2.47241 16.7953 3.87873 17.7716 5.0769C18.7678 6.29956 20.0716 7.44977 21.3383 8.42854C22.6109 9.41186 23.8784 10.2469 24.825 10.835C25.2993 11.1295 25.6952 11.3635 25.9738 11.5245C26.1131 11.605 26.2233 11.6674 26.2993 11.71C26.3374 11.7314 26.3669 11.7478 26.3873 11.7591C26.3975 11.7647 26.4055 11.7691 26.411 11.7721C26.4138 11.7737 26.416 11.7749 26.4176 11.7758C26.4184 11.7762 26.4191 11.7765 26.4196 11.7768C26.4199 11.777 26.4201 11.7771 26.4202 11.7772C26.4205 11.7773 26.4207 11.7774 26.8995 10.8995C27.3783 10.0216 27.3784 10.0217 27.3785 10.0217C27.3785 10.0217 27.3785 10.0217 27.3785 10.0217C27.3784 10.0216 27.3781 10.0215 27.3777 10.0213C27.3769 10.0208 27.3756 10.0201 27.3736 10.019C27.3697 10.0168 27.3634 10.0134 27.3549 10.0087C27.3378 9.99926 27.3118 9.98479 27.2773 9.96547C27.2084 9.92682 27.1058 9.86878 26.9745 9.79288C26.7117 9.64102 26.3342 9.41799 25.8804 9.13606C24.9708 8.57104 23.7635 7.77501 22.5612 6.84596C21.353 5.91235 20.182 4.86894 19.322 3.81356C18.4422 2.73371 18 1.77759 18 1H16ZM26.8994 11C26.5248 10.0728 26.5245 10.0729 26.5242 10.0731C26.524 10.0731 26.5237 10.0733 26.5234 10.0734C26.5228 10.0736 26.522 10.0739 26.5211 10.0743C26.5193 10.0751 26.5169 10.076 26.5138 10.0773C26.5078 10.0797 26.4994 10.0832 26.4888 10.0876C26.4674 10.0964 26.4369 10.1091 26.3979 10.1257C26.3199 10.1587 26.2077 10.2071 26.0662 10.2703C25.7834 10.3967 25.3826 10.5825 24.903 10.824C23.9463 11.3055 22.6639 12.0142 21.3751 12.919C20.0914 13.8201 18.7665 14.94 17.7546 16.2535C16.7415 17.5685 15.9999 19.1342 15.9999 20.8995H17.9999C17.9999 19.715 18.4958 18.5685 19.3389 17.4742C20.1831 16.3784 21.333 15.3922 22.5242 14.5559C23.7103 13.7232 24.9028 13.0632 25.8022 12.6104C26.2507 12.3846 26.6233 12.2119 26.8818 12.0965C27.011 12.0388 27.1115 11.9955 27.1785 11.967C27.212 11.9528 27.2371 11.9424 27.2533 11.9357C27.2613 11.9324 27.2671 11.93 27.2706 11.9286C27.2724 11.9279 27.2735 11.9274 27.2741 11.9271C27.2744 11.927 27.2745 11.927 27.2745 11.927C27.2745 11.927 27.2744 11.927 27.2744 11.927C27.2742 11.9271 27.274 11.9272 26.8994 11Z" />
                                    </svg>
                                </div>
                            </a>
                        </div>
                    </nav>
                </header>


                <div data-animate="enter-from-top-staggered"
                    class="mt-8 flex flex-wrap items-center justify-center gap-5">
                    <div>
                        <a x-data x-init="() => {
                            const card = $el
                            const sponsorImage = $refs.sponsorImage
                            const sponsorTier = $refs.sponsorTier
                        
                            gsap.set(sponsorTier, { opacity: 0, y: -10, x: -5 })
                        
                            const tl = gsap.timeline({ paused: true })
                        
                            // Feature image scales down slightly
                            tl.to(
                                sponsorImage, {
                                    scale: 0.9,
                                    rotation: 0.01,
                                    duration: 0.3,
                                    ease: 'sine.out',
                                },
                                0,
                            )
                        
                            // Sponsor tier fades in and slides down
                            tl.to(
                                sponsorTier, {
                                    opacity: 1,
                                    y: 0,
                                    x: 0,
                                    duration: 0.3,
                                    ease: 'sine.out',
                                },
                                0.1,
                            )
                        
                            motion.hover(card, () => {
                                tl.tweenTo(tl.duration())
                        
                                return () => {
                                    tl.tweenTo(0)
                                }
                            })
                        }"
                            href="https://kirschbaumdevelopment.com/solutions/filament-development" target="_blank"
                            rel="noopener noreferrer" aria-label="Visit Kirschbaum (opens in new window)"
                            class="relative inline-grid place-items-center overflow-hidden bg-cream-100 transition duration-300 ease-out hover:bg-cream-50 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset h-15 w-35 p-4 xs:h-25 xs:w-50 xs:p-6">

                            <div x-ref="sponsorTier"
                                class="absolute top-0 left-0 z-2 bg-stone-800 px-2 pt-px pb-0.5 font-roboto-mono text-xs text-stone-100"
                                data-corner-cut="sm" aria-hidden="true">
                                Agency Partner
                            </div>


                            <img x-ref="sponsorImage"
                                src="https://fls-a148a526-7ce4-465e-b283-9b405912858a.laravel.cloud/019c953a-0c78-7283-b894-3af9e1e2fa72/kirschbaum.svg"
                                alt="Kirschbaum" loading="lazy" width="auto" height="auto"
                                class="relative z-1 object-contain mix-blend-luminosity max-h-7 xs:max-h-11" />


                            <div
                                class="bg-line-pattern absolute inset-0 z-0 h-full w-full mask-y-from-70% mask-x-from-70% bg-repeat opacity-80">
                            </div>
                        </a>
                    </div>
                    <div>
                        <a x-data x-init="() => {
                            const card = $el
                            const sponsorImage = $refs.sponsorImage
                            const sponsorTier = $refs.sponsorTier
                        
                            gsap.set(sponsorTier, { opacity: 0, y: -10, x: -5 })
                        
                            const tl = gsap.timeline({ paused: true })
                        
                            // Feature image scales down slightly
                            tl.to(
                                sponsorImage, {
                                    scale: 0.9,
                                    rotation: 0.01,
                                    duration: 0.3,
                                    ease: 'sine.out',
                                },
                                0,
                            )
                        
                            // Sponsor tier fades in and slides down
                            tl.to(
                                sponsorTier, {
                                    opacity: 1,
                                    y: 0,
                                    x: 0,
                                    duration: 0.3,
                                    ease: 'sine.out',
                                },
                                0.1,
                            )
                        
                            motion.hover(card, () => {
                                tl.tweenTo(tl.duration())
                        
                                return () => {
                                    tl.tweenTo(0)
                                }
                            })
                        }" href="https://baiz.ai" target="_blank"
                            rel="noopener noreferrer" aria-label="Visit Baiz.ai (opens in new window)"
                            class="relative inline-grid place-items-center overflow-hidden bg-cream-100 transition duration-300 ease-out hover:bg-cream-50 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset h-15 w-35 p-4 xs:h-25 xs:w-50 xs:p-6">

                            <div x-ref="sponsorTier"
                                class="absolute top-0 left-0 z-2 bg-stone-800 px-2 pt-px pb-0.5 font-roboto-mono text-xs text-stone-100"
                                data-corner-cut="sm" aria-hidden="true">
                                Gold sponsor
                            </div>


                            <img x-ref="sponsorImage"
                                src="https://fls-a148a526-7ce4-465e-b283-9b405912858a.laravel.cloud/019c953a-0dc5-739f-bcb3-25c033523707/baiz-ai.svg"
                                alt="Baiz.ai" loading="lazy" width="auto" height="auto"
                                class="relative z-1 object-contain mix-blend-luminosity max-h-7 xs:max-h-11" />


                            <div
                                class="bg-line-pattern absolute inset-0 z-0 h-full w-full mask-y-from-70% mask-x-from-70% bg-repeat opacity-80">
                            </div>
                        </a>
                    </div>
                    <div>
                        <a x-data x-init="() => {
                            const card = $el
                            const sponsorImage = $refs.sponsorImage
                            const sponsorTier = $refs.sponsorTier
                        
                            gsap.set(sponsorTier, { opacity: 0, y: -10, x: -5 })
                        
                            const tl = gsap.timeline({ paused: true })
                        
                            // Feature image scales down slightly
                            tl.to(
                                sponsorImage, {
                                    scale: 0.9,
                                    rotation: 0.01,
                                    duration: 0.3,
                                    ease: 'sine.out',
                                },
                                0,
                            )
                        
                            // Sponsor tier fades in and slides down
                            tl.to(
                                sponsorTier, {
                                    opacity: 1,
                                    y: 0,
                                    x: 0,
                                    duration: 0.3,
                                    ease: 'sine.out',
                                },
                                0.1,
                            )
                        
                            motion.hover(card, () => {
                                tl.tweenTo(tl.duration())
                        
                                return () => {
                                    tl.tweenTo(0)
                                }
                            })
                        }" href="https://serpapi.com/?utm_source=filamentphp"
                            target="_blank" rel="noopener noreferrer"
                            aria-label="Visit SerpApi (opens in new window)"
                            class="relative inline-grid place-items-center overflow-hidden bg-cream-100 transition duration-300 ease-out hover:bg-cream-50 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset h-15 w-35 p-4 xs:h-25 xs:w-50 xs:p-6">

                            <div x-ref="sponsorTier"
                                class="absolute top-0 left-0 z-2 bg-stone-800 px-2 pt-px pb-0.5 font-roboto-mono text-xs text-stone-100"
                                data-corner-cut="sm" aria-hidden="true">
                                Gold sponsor
                            </div>


                            <img x-ref="sponsorImage"
                                src="https://fls-a148a526-7ce4-465e-b283-9b405912858a.laravel.cloud/019c953a-0eac-705c-8def-601fa4a28164/serpapi.svg"
                                alt="SerpApi" loading="lazy" width="auto" height="auto"
                                class="relative z-1 object-contain mix-blend-luminosity max-h-7 xs:max-h-11" />


                            <div
                                class="bg-line-pattern absolute inset-0 z-0 h-full w-full mask-y-from-70% mask-x-from-70% bg-repeat opacity-80">
                            </div>
                        </a>
                    </div>
                    <div>
                        <a x-data x-init="() => {
                            const card = $el
                            const sponsorImage = $refs.sponsorImage
                            const sponsorTier = $refs.sponsorTier
                        
                            gsap.set(sponsorTier, { opacity: 0, y: -10, x: -5 })
                        
                            const tl = gsap.timeline({ paused: true })
                        
                            // Feature image scales down slightly
                            tl.to(
                                sponsorImage, {
                                    scale: 0.9,
                                    rotation: 0.01,
                                    duration: 0.3,
                                    ease: 'sine.out',
                                },
                                0,
                            )
                        
                            // Sponsor tier fades in and slides down
                            tl.to(
                                sponsorTier, {
                                    opacity: 1,
                                    y: 0,
                                    x: 0,
                                    duration: 0.3,
                                    ease: 'sine.out',
                                },
                                0.1,
                            )
                        
                            motion.hover(card, () => {
                                tl.tweenTo(tl.duration())
                        
                                return () => {
                                    tl.tweenTo(0)
                                }
                            })
                        }" href="https://cmsmax.com?ref=filamentphp.com"
                            target="_blank" rel="noopener noreferrer"
                            aria-label="Visit CMS Max (opens in new window)"
                            class="relative inline-grid place-items-center overflow-hidden bg-cream-100 transition duration-300 ease-out hover:bg-cream-50 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset h-15 w-35 p-4 xs:h-25 xs:w-50 xs:p-6">

                            <div x-ref="sponsorTier"
                                class="absolute top-0 left-0 z-2 bg-stone-800 px-2 pt-px pb-0.5 font-roboto-mono text-xs text-stone-100"
                                data-corner-cut="sm" aria-hidden="true">
                                Gold sponsor
                            </div>


                            <img x-ref="sponsorImage"
                                src="https://fls-a148a526-7ce4-465e-b283-9b405912858a.laravel.cloud/019c953a-0df8-73b8-bb35-5bc9517949e2/cms-max.svg"
                                alt="CMS Max" loading="lazy" width="auto" height="auto"
                                class="relative z-1 object-contain mix-blend-luminosity max-h-7 xs:max-h-11" />


                            <div
                                class="bg-line-pattern absolute inset-0 z-0 h-full w-full mask-y-from-70% mask-x-from-70% bg-repeat opacity-80">
                            </div>
                        </a>
                    </div>
                    <div>
                        <a x-data x-init="() => {
                            const card = $el
                            const sponsorImage = $refs.sponsorImage
                            const sponsorTier = $refs.sponsorTier
                        
                            gsap.set(sponsorTier, { opacity: 0, y: -10, x: -5 })
                        
                            const tl = gsap.timeline({ paused: true })
                        
                            // Feature image scales down slightly
                            tl.to(
                                sponsorImage, {
                                    scale: 0.9,
                                    rotation: 0.01,
                                    duration: 0.3,
                                    ease: 'sine.out',
                                },
                                0,
                            )
                        
                            // Sponsor tier fades in and slides down
                            tl.to(
                                sponsorTier, {
                                    opacity: 1,
                                    y: 0,
                                    x: 0,
                                    duration: 0.3,
                                    ease: 'sine.out',
                                },
                                0.1,
                            )
                        
                            motion.hover(card, () => {
                                tl.tweenTo(tl.duration())
                        
                                return () => {
                                    tl.tweenTo(0)
                                }
                            })
                        }"
                            href="https://mailtrap.io/email-sending?utm_source=community&amp;utm_medium=referral&amp;utm_campaign=filament"
                            target="_blank" rel="noopener noreferrer"
                            aria-label="Visit Mailtrap (opens in new window)"
                            class="relative inline-grid place-items-center overflow-hidden bg-cream-100 transition duration-300 ease-out hover:bg-cream-50 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset h-15 w-35 p-4 xs:h-25 xs:w-50 xs:p-6">

                            <div x-ref="sponsorTier"
                                class="absolute top-0 left-0 z-2 bg-stone-800 px-2 pt-px pb-0.5 font-roboto-mono text-xs text-stone-100"
                                data-corner-cut="sm" aria-hidden="true">
                                Gold sponsor
                            </div>


                            <img x-ref="sponsorImage"
                                src="https://fls-a148a526-7ce4-465e-b283-9b405912858a.laravel.cloud/019c953a-0e2b-7127-9e05-8d899d66321e/mailtrap.svg"
                                alt="Mailtrap" loading="lazy" width="auto" height="auto"
                                class="relative z-1 object-contain mix-blend-luminosity max-h-7 xs:max-h-11" />


                            <div
                                class="bg-line-pattern absolute inset-0 z-0 h-full w-full mask-y-from-70% mask-x-from-70% bg-repeat opacity-80">
                            </div>
                        </a>
                    </div>
                    <div>
                        <a x-data x-init="() => {
                            const card = $el
                            const sponsorImage = $refs.sponsorImage
                            const sponsorTier = $refs.sponsorTier
                        
                            gsap.set(sponsorTier, { opacity: 0, y: -10, x: -5 })
                        
                            const tl = gsap.timeline({ paused: true })
                        
                            // Feature image scales down slightly
                            tl.to(
                                sponsorImage, {
                                    scale: 0.9,
                                    rotation: 0.01,
                                    duration: 0.3,
                                    ease: 'sine.out',
                                },
                                0,
                            )
                        
                            // Sponsor tier fades in and slides down
                            tl.to(
                                sponsorTier, {
                                    opacity: 1,
                                    y: 0,
                                    x: 0,
                                    duration: 0.3,
                                    ease: 'sine.out',
                                },
                                0.1,
                            )
                        
                            motion.hover(card, () => {
                                tl.tweenTo(tl.duration())
                        
                                return () => {
                                    tl.tweenTo(0)
                                }
                            })
                        }"
                            href="https://www.agiledrop.com/laravel?utm_source=filament" target="_blank"
                            rel="noopener noreferrer" aria-label="Visit Agiledrop (opens in new window)"
                            class="relative inline-grid place-items-center overflow-hidden bg-cream-100 transition duration-300 ease-out hover:bg-cream-50 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset h-15 w-35 p-4 xs:h-25 xs:w-50 xs:p-6">

                            <div x-ref="sponsorTier"
                                class="absolute top-0 left-0 z-2 bg-stone-800 px-2 pt-px pb-0.5 font-roboto-mono text-xs text-stone-100"
                                data-corner-cut="sm" aria-hidden="true">
                                Gold sponsor
                            </div>


                            <img x-ref="sponsorImage"
                                src="https://fls-a148a526-7ce4-465e-b283-9b405912858a.laravel.cloud/019c953a-0d2c-738d-9bb5-594888161dd8/agiledrop.svg"
                                alt="Agiledrop" loading="lazy" width="auto" height="auto"
                                class="relative z-1 object-contain mix-blend-luminosity max-h-7 xs:max-h-11" />


                            <div
                                class="bg-line-pattern absolute inset-0 z-0 h-full w-full mask-y-from-70% mask-x-from-70% bg-repeat opacity-80">
                            </div>
                        </a>
                    </div>
                    <div>
                        <a x-data x-init="() => {
                            const card = $el
                            const sponsorImage = $refs.sponsorImage
                            const sponsorTier = $refs.sponsorTier
                        
                            gsap.set(sponsorTier, { opacity: 0, y: -10, x: -5 })
                        
                            const tl = gsap.timeline({ paused: true })
                        
                            // Feature image scales down slightly
                            tl.to(
                                sponsorImage, {
                                    scale: 0.9,
                                    rotation: 0.01,
                                    duration: 0.3,
                                    ease: 'sine.out',
                                },
                                0,
                            )
                        
                            // Sponsor tier fades in and slides down
                            tl.to(
                                sponsorTier, {
                                    opacity: 1,
                                    y: 0,
                                    x: 0,
                                    duration: 0.3,
                                    ease: 'sine.out',
                                },
                                0.1,
                            )
                        
                            motion.hover(card, () => {
                                tl.tweenTo(tl.duration())
                        
                                return () => {
                                    tl.tweenTo(0)
                                }
                            })
                        }"
                            href="https://redberry.international/filament-development" target="_blank"
                            rel="noopener noreferrer" aria-label="Visit Redberry (opens in new window)"
                            class="relative inline-grid place-items-center overflow-hidden bg-cream-100 transition duration-300 ease-out hover:bg-cream-50 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset h-15 w-35 p-4 xs:h-25 xs:w-50 xs:p-6">

                            <div x-ref="sponsorTier"
                                class="absolute top-0 left-0 z-2 bg-stone-800 px-2 pt-px pb-0.5 font-roboto-mono text-xs text-stone-100"
                                data-corner-cut="sm" aria-hidden="true">
                                Silver sponsor
                            </div>


                            <img x-ref="sponsorImage"
                                src="https://fls-a148a526-7ce4-465e-b283-9b405912858a.laravel.cloud/019c953a-0f81-7316-a657-d449809bf26e/redberry.svg"
                                alt="Redberry" loading="lazy" width="auto" height="auto"
                                class="relative z-1 object-contain mix-blend-luminosity max-h-7 xs:max-h-11" />


                            <div
                                class="bg-line-pattern absolute inset-0 z-0 h-full w-full mask-y-from-70% mask-x-from-70% bg-repeat opacity-80">
                            </div>
                        </a>
                    </div>
                    <div>
                        <a x-data x-init="() => {
                            const card = $el
                            const sponsorImage = $refs.sponsorImage
                            const sponsorTier = $refs.sponsorTier
                        
                            gsap.set(sponsorTier, { opacity: 0, y: -10, x: -5 })
                        
                            const tl = gsap.timeline({ paused: true })
                        
                            // Feature image scales down slightly
                            tl.to(
                                sponsorImage, {
                                    scale: 0.9,
                                    rotation: 0.01,
                                    duration: 0.3,
                                    ease: 'sine.out',
                                },
                                0,
                            )
                        
                            // Sponsor tier fades in and slides down
                            tl.to(
                                sponsorTier, {
                                    opacity: 1,
                                    y: 0,
                                    x: 0,
                                    duration: 0.3,
                                    ease: 'sine.out',
                                },
                                0.1,
                            )
                        
                            motion.hover(card, () => {
                                tl.tweenTo(tl.duration())
                        
                                return () => {
                                    tl.tweenTo(0)
                                }
                            })
                        }" href="https://www.wordonfire.org" target="_blank"
                            rel="noopener noreferrer" aria-label="Visit Word on Fire (opens in new window)"
                            class="relative inline-grid place-items-center overflow-hidden bg-cream-100 transition duration-300 ease-out hover:bg-cream-50 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset h-15 w-35 p-4 xs:h-25 xs:w-50 xs:p-6">

                            <div x-ref="sponsorTier"
                                class="absolute top-0 left-0 z-2 bg-stone-800 px-2 pt-px pb-0.5 font-roboto-mono text-xs text-stone-100"
                                data-corner-cut="sm" aria-hidden="true">
                                Silver sponsor
                            </div>


                            <img x-ref="sponsorImage"
                                src="https://fls-a148a526-7ce4-465e-b283-9b405912858a.laravel.cloud/019c953a-10c2-7107-83f4-97197a15125b/word-on-fire.svg"
                                alt="Word on Fire" loading="lazy" width="auto" height="auto"
                                class="relative z-1 object-contain mix-blend-luminosity max-h-7 xs:max-h-11" />


                            <div
                                class="bg-line-pattern absolute inset-0 z-0 h-full w-full mask-y-from-70% mask-x-from-70% bg-repeat opacity-80">
                            </div>
                        </a>
                    </div>
                    <div>
                        <a x-data x-init="() => {
                            const card = $el
                            const sponsorImage = $refs.sponsorImage
                            const sponsorTier = $refs.sponsorTier
                        
                            gsap.set(sponsorTier, { opacity: 0, y: -10, x: -5 })
                        
                            const tl = gsap.timeline({ paused: true })
                        
                            // Feature image scales down slightly
                            tl.to(
                                sponsorImage, {
                                    scale: 0.9,
                                    rotation: 0.01,
                                    duration: 0.3,
                                    ease: 'sine.out',
                                },
                                0,
                            )
                        
                            // Sponsor tier fades in and slides down
                            tl.to(
                                sponsorTier, {
                                    opacity: 1,
                                    y: 0,
                                    x: 0,
                                    duration: 0.3,
                                    ease: 'sine.out',
                                },
                                0.1,
                            )
                        
                            motion.hover(card, () => {
                                tl.tweenTo(tl.duration())
                        
                                return () => {
                                    tl.tweenTo(0)
                                }
                            })
                        }" href="https://ploi.io" target="_blank"
                            rel="noopener noreferrer" aria-label="Visit Ploi (opens in new window)"
                            class="relative inline-grid place-items-center overflow-hidden bg-cream-100 transition duration-300 ease-out hover:bg-cream-50 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset h-15 w-35 p-4 xs:h-25 xs:w-50 xs:p-6">

                            <div x-ref="sponsorTier"
                                class="absolute top-0 left-0 z-2 bg-stone-800 px-2 pt-px pb-0.5 font-roboto-mono text-xs text-stone-100"
                                data-corner-cut="sm" aria-hidden="true">
                                Silver sponsor
                            </div>


                            <img x-ref="sponsorImage"
                                src="https://fls-a148a526-7ce4-465e-b283-9b405912858a.laravel.cloud/019c953a-0ee2-7267-bf74-80dedf08077e/ploi.svg"
                                alt="Ploi" loading="lazy" width="auto" height="auto"
                                class="relative z-1 object-contain mix-blend-luminosity max-h-7 xs:max-h-11" />


                            <div
                                class="bg-line-pattern absolute inset-0 z-0 h-full w-full mask-y-from-70% mask-x-from-70% bg-repeat opacity-80">
                            </div>
                        </a>
                    </div>
                    <div>
                        <a x-data x-init="() => {
                            const card = $el
                            const sponsorImage = $refs.sponsorImage
                            const sponsorTier = $refs.sponsorTier
                        
                            gsap.set(sponsorTier, { opacity: 0, y: -10, x: -5 })
                        
                            const tl = gsap.timeline({ paused: true })
                        
                            // Feature image scales down slightly
                            tl.to(
                                sponsorImage, {
                                    scale: 0.9,
                                    rotation: 0.01,
                                    duration: 0.3,
                                    ease: 'sine.out',
                                },
                                0,
                            )
                        
                            // Sponsor tier fades in and slides down
                            tl.to(
                                sponsorTier, {
                                    opacity: 1,
                                    y: 0,
                                    x: 0,
                                    duration: 0.3,
                                    ease: 'sine.out',
                                },
                                0.1,
                            )
                        
                            motion.hover(card, () => {
                                tl.tweenTo(tl.duration())
                        
                                return () => {
                                    tl.tweenTo(0)
                                }
                            })
                        }" href="https://tappnetwork.com" target="_blank"
                            rel="noopener noreferrer" aria-label="Visit Tapp Network (opens in new window)"
                            class="relative inline-grid place-items-center overflow-hidden bg-cream-100 transition duration-300 ease-out hover:bg-cream-50 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset h-15 w-35 p-4 xs:h-25 xs:w-50 xs:p-6">

                            <div x-ref="sponsorTier"
                                class="absolute top-0 left-0 z-2 bg-stone-800 px-2 pt-px pb-0.5 font-roboto-mono text-xs text-stone-100"
                                data-corner-cut="sm" aria-hidden="true">
                                Silver sponsor
                            </div>


                            <img x-ref="sponsorImage"
                                src="https://fls-a148a526-7ce4-465e-b283-9b405912858a.laravel.cloud/019c953a-1037-7138-b715-3217e1b84a8d/tapp-network.svg"
                                alt="Tapp Network" loading="lazy" width="auto" height="auto"
                                class="relative z-1 object-contain mix-blend-luminosity max-h-7 xs:max-h-11" />


                            <div
                                class="bg-line-pattern absolute inset-0 z-0 h-full w-full mask-y-from-70% mask-x-from-70% bg-repeat opacity-80">
                            </div>
                        </a>
                    </div>

                    <div>
                        <a x-data href="https://github.com/sponsors/danharrin" target="_blank"
                            rel="noopener noreferrer"
                            aria-label="Sponsor Filament - your logo here (opens in new window)"
                            class="custom-dashed-border group relative inline-grid place-items-center overflow-hidden bg-minty-100/30 transition duration-300 ease-out hover:bg-bubblegum/30 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset h-15 w-35 p-4 xs:h-25 xs:w-50 xs:p-6">
                            <div
                                class="relative z-1 flex items-center gap-1 transition duration-300 ease-out will-change-transform group-hover:scale-105">

                                <svg class="shrink-0 size-3 xs:size-3.5" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14" />
                                    <path d="M12 5v14" />
                                </svg>

                                <span class="font-medium text-xs xs:text-sm">
                                    Your logo here
                                </span>
                            </div>


                            <div
                                class="bg-line-pattern absolute inset-0 z-0 h-full w-full mask-y-from-70% mask-x-from-70% bg-repeat opacity-60">
                            </div>
                        </a>
                    </div>
                </div>
            </section>


            <section class="px-8 py-10 sm:px-10 sm:py-15 lg:px-15 lg:py-20">

                <header class="flex flex-col items-center justify-center text-center">
                    <div data-animate="enter-from-top">
                        <svg aria-hidden="true" class="h-5 text-stone-800 lg:h-6"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                            <path class="stroke-current [stroke-width:var(--stroke-width,3)]"
                                d="M140.8 133.12c0 9.8534 -10.6667 16.0118 -19.2 11.0851 -8.5333 -4.9267 -8.5333 -17.2435 0 -22.1702 1.9458 -1.1235 4.1531 -1.7149 6.4 -1.7149 7.0692 0 12.8 5.7308 12.8 12.8Zm-69.12 -12.8c-9.8534 0 -16.0118 10.6667 -11.0851 19.2 4.9267 8.5333 17.2435 8.5333 22.1702 0 1.1235 -1.9458 1.7149 -4.1531 1.7149 -6.4 0 -7.0692 -5.7308 -12.8 -12.8 -12.8Zm112.64 0c-9.8534 0 -16.0118 10.6667 -11.0851 19.2 4.9267 8.5333 17.2435 8.5333 22.1702 0 1.1235 -1.9458 1.7149 -4.1531 1.7149 -6.4 0 -7.0692 -5.7308 -12.8 -12.8 -12.8Zm69.12 7.68c-0.0776 69.2464 -56.1936 125.3624 -125.44 125.44H20.48c-9.8969 0 -17.92 -8.0231 -17.92 -17.92V128c0 -96.5638 104.5333 -156.9161 188.16 -108.6342C229.5313 41.7735 253.44 83.1846 253.44 128Zm-15.36 0c0 -84.7396 -91.7333 -137.7019 -165.12 -95.3321C38.9011 52.3318 17.92 88.6722 17.92 128v107.52c0 1.4138 1.1462 2.56 2.56 2.56H128c60.7663 -0.0706 110.0095 -49.3137 110.08 -110.08Z">
                            </path>
                        </svg>
                    </div>

                    <h1 data-animate="text-reveal-lines" class="mt-2.5">
                        Trusted by the community
                    </h1>
                    <p data-section-description data-animate="text-reveal-words" class="mt-3 max-w-2xl md:mt-4">
                        Filament
                        <strong>grows</strong>
                        alongside the Laravel community, guided by real-world usage,
                        feedback, and teams shipping real products.
                    </p>


                    <nav data-animate="enter-from-top" class="mt-3 md:mt-4">
                        <div x-data data-button-pulse class="rounded-full bg-cream-100" aria-label="Tell your story"
                            x-init="async () => {
                                await window.FilamentAnimations.waitForFonts()
                            
                                const button = $el.querySelector('a')
                                const textWrapper = button.querySelector('[data-text]')
                                const icon = button.querySelector('[data-icon] svg')
                                const hasCustomIcon = false
                                const hasCustomContent = false
                                const animateIcon = true
                            
                                const tl = gsap.timeline({ paused: true })
                            
                                // Only animate text if not using custom content
                                let chars = []
                                if (!hasCustomContent && textWrapper) {
                                    const split = new SplitText(textWrapper, { type: 'chars' })
                                    chars = split.chars
                                }
                            
                                if (hasCustomIcon && animateIcon) {
                                    // Custom icon animation: subtle scale and lift
                                    tl.to(
                                        icon, {
                                            scale: 1.1,
                                            rotation: 0.01,
                                            duration: 0.3,
                                            ease: 'sine.out',
                                        },
                                        0,
                                    )
                                } else if (!hasCustomIcon) {
                                    // Arrow animation
                                    const direction = 'right'
                                    const distance = 30
                            
                                    let xOut, yOut, xIn, yIn
                            
                                    switch (direction) {
                                        case 'top-right':
                                            xOut = distance * Math.cos((-45 * Math.PI) / 180)
                                            yOut = distance * Math.sin((-45 * Math.PI) / 180)
                                            xIn = -xOut
                                            yIn = -yOut
                                            break
                                        case 'bottom-right':
                                            xOut = distance * Math.cos((45 * Math.PI) / 180)
                                            yOut = distance * Math.sin((45 * Math.PI) / 180)
                                            xIn = -xOut
                                            yIn = -yOut
                                            break
                                        case 'left':
                                            xOut = -distance
                                            yOut = 0
                                            xIn = -xOut
                                            yIn = 0
                                            break
                                        default:
                                            xOut = distance
                                            yOut = 0
                                            xIn = -distance
                                            yIn = 0
                                    }
                            
                                    tl.to(
                                        icon, {
                                            keyframes: [
                                                { x: xOut, y: yOut, duration: 0.23, ease: 'power2.in' },
                                                { x: xIn, y: yIn, duration: 0 },
                                                { x: 0, y: 0, duration: 0.23, ease: 'power2.out' },
                                            ],
                                        },
                                        0,
                                    )
                                }
                            
                                // Characters shine with stagger (only if not custom content)
                                if (chars.length > 0) {
                                    tl.to(
                                        chars, {
                                            keyframes: {
                                                opacity: [1, 0.4, 1],
                                            },
                                            duration: 0.15,
                                            ease: 'sine.inOut',
                                            stagger: 0.02,
                                        },
                                        0.1,
                                    )
                                }
                            
                                motion.hover(button, () => {
                                    tl.tweenTo(tl.duration())
                            
                                    return () => {
                                        tl.tweenTo(0)
                                    }
                                })
                            }">
                            <a href="https://filamentphp.com/wall-of-love#share" aria-label="Tell your story"
                                class="group inline-flex w-full items-center justify-between rounded-full font-medium whitespace-nowrap text-stone-900 transition duration-300 ease-out will-change-transform hover:scale-y-102 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset h-13 gap-2.5 pr-1.25 pl-5 bg-cream-100 hover:bg-honey-100 ">
                                <span data-text class="grow">
                                    Tell your story
                                </span>


                                <div data-icon
                                    class="relative isolate grid shrink-0 place-items-center overflow-hidden rounded-full size-11 bg-stone-900 text-cream-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.25"
                                        style="transform: rotate(0deg)" viewBox="0 0 28 22" fill="none">
                                        <path class="fill-current"
                                            d="M1 10H5.96046e-08V12H1V10ZM27 12C27.5523 12 28 11.5523 28 11C28 10.4477 27.5523 10 27 10V12ZM18 1V5.96046e-08H16V1H18ZM26.4207 11.7774C26.9055 12.0419 27.5129 11.8632 27.7774 11.3783C28.0419 10.8935 27.8632 10.286 27.3783 10.0216L26.4207 11.7774ZM15.9999 20.8995V21.8995H17.9999V20.8995H15.9999ZM1 12H26.8994V10H1V12ZM26.8994 12H27V10H26.8994V12ZM16 1C16 2.47241 16.7953 3.87873 17.7716 5.0769C18.7678 6.29956 20.0716 7.44977 21.3383 8.42854C22.6109 9.41186 23.8784 10.2469 24.825 10.835C25.2993 11.1295 25.6952 11.3635 25.9738 11.5245C26.1131 11.605 26.2233 11.6674 26.2993 11.71C26.3374 11.7314 26.3669 11.7478 26.3873 11.7591C26.3975 11.7647 26.4055 11.7691 26.411 11.7721C26.4138 11.7737 26.416 11.7749 26.4176 11.7758C26.4184 11.7762 26.4191 11.7765 26.4196 11.7768C26.4199 11.777 26.4201 11.7771 26.4202 11.7772C26.4205 11.7773 26.4207 11.7774 26.8995 10.8995C27.3783 10.0216 27.3784 10.0217 27.3785 10.0217C27.3785 10.0217 27.3785 10.0217 27.3785 10.0217C27.3784 10.0216 27.3781 10.0215 27.3777 10.0213C27.3769 10.0208 27.3756 10.0201 27.3736 10.019C27.3697 10.0168 27.3634 10.0134 27.3549 10.0087C27.3378 9.99926 27.3118 9.98479 27.2773 9.96547C27.2084 9.92682 27.1058 9.86878 26.9745 9.79288C26.7117 9.64102 26.3342 9.41799 25.8804 9.13606C24.9708 8.57104 23.7635 7.77501 22.5612 6.84596C21.353 5.91235 20.182 4.86894 19.322 3.81356C18.4422 2.73371 18 1.77759 18 1H16ZM26.8994 11C26.5248 10.0728 26.5245 10.0729 26.5242 10.0731C26.524 10.0731 26.5237 10.0733 26.5234 10.0734C26.5228 10.0736 26.522 10.0739 26.5211 10.0743C26.5193 10.0751 26.5169 10.076 26.5138 10.0773C26.5078 10.0797 26.4994 10.0832 26.4888 10.0876C26.4674 10.0964 26.4369 10.1091 26.3979 10.1257C26.3199 10.1587 26.2077 10.2071 26.0662 10.2703C25.7834 10.3967 25.3826 10.5825 24.903 10.824C23.9463 11.3055 22.6639 12.0142 21.3751 12.919C20.0914 13.8201 18.7665 14.94 17.7546 16.2535C16.7415 17.5685 15.9999 19.1342 15.9999 20.8995H17.9999C17.9999 19.715 18.4958 18.5685 19.3389 17.4742C20.1831 16.3784 21.333 15.3922 22.5242 14.5559C23.7103 13.7232 24.9028 13.0632 25.8022 12.6104C26.2507 12.3846 26.6233 12.2119 26.8818 12.0965C27.011 12.0388 27.1115 11.9955 27.1785 11.967C27.212 11.9528 27.2371 11.9424 27.2533 11.9357C27.2613 11.9324 27.2671 11.93 27.2706 11.9286C27.2724 11.9279 27.2735 11.9274 27.2741 11.9271C27.2744 11.927 27.2745 11.927 27.2745 11.927C27.2745 11.927 27.2744 11.927 27.2744 11.927C27.2742 11.9271 27.274 11.9272 26.8994 11Z" />
                                    </svg>
                                </div>
                            </a>
                        </div>
                    </nav>
                </header>


                <div class="relative mt-8">
                    <div data-animate="enter-from-left-staggered" class="columns-sm gap-6">
                        <article
                            class="group block break-inside-avoid border border-bone-100 transition duration-500 ease-out not-last:mb-7 odd:hover:bg-bubblegum/25 even:hover:bg-minty-100/30 rounded-lg p-6 sm:p-8">
                            <header class="flex items-start justify-between gap-5">
                                <div class="flex items-center gap-2.5 sm:gap-3.5">

                                    <img src="https://fls-a148a526-7ce4-465e-b283-9b405912858a.laravel.cloud/019d24d5-5002-7241-9f65-fd11f00f746b/01KMJDAKXZS6KS41K3CTTA93TR.jpg"
                                        alt="Avatar of Eric Barnes" aria-hidden="true" loading="lazy"
                                        class="object-cover size-10 rounded-sm sm:size-12" />


                                    <div class="flex flex-col gap-px sm:gap-0.5">
                                        <cite
                                            class="truncate font-outfit font-medium text-stone-800 not-italic sm:text-lg">
                                            Eric Barnes
                                        </cite>
                                        <p class="text-pretty text-sm sm:text-base">
                                            Owner of Laravel News
                                        </p>
                                    </div>
                                </div>


                                <svg aria-hidden="true"
                                    class="h-6 shrink-0 text-bone-300 mix-blend-luminosity sm:h-7.5"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35 35" fill="none">
                                    <path
                                        class="fill-current transition duration-500 ease-out group-hover:translate-x-4"
                                        d="M11.7982 16.9613H4.95865C5.07532 10.1508 6.41697 9.02785 10.6024 6.54868C11.0836 6.25702 11.244 5.64453 10.9524 5.1487C10.6607 4.66745 10.0482 4.50705 9.55234 4.79871C4.62318 7.71538 2.90234 9.49452 2.90234 17.982V25.8425C2.90234 28.3363 4.92947 30.3488 7.40864 30.3488H11.7836C14.3503 30.3488 16.2898 28.4092 16.2898 25.8425V21.4675C16.3044 18.9009 14.3649 16.9613 11.7982 16.9613Z" />
                                    <path
                                        class="fill-current opacity-40 transition duration-500 ease-out group-hover:-translate-x-4"
                                        d="M27.5773 16.9613H20.7377C20.8544 10.1508 22.1962 9.02785 26.3816 6.54868C26.8629 6.25702 27.0233 5.64453 26.7316 5.1487C26.44 4.66745 25.8275 4.50705 25.3316 4.79871C20.4025 7.71538 18.6816 9.49452 18.6816 17.982V25.8425C18.6816 28.3363 20.7087 30.3488 23.1879 30.3488H27.5629C30.1296 30.3488 32.0691 28.4092 32.0691 25.8425V21.4675C32.0837 18.9009 30.144 16.9613 27.5773 16.9613Z" />
                                </svg>
                            </header>


                            <blockquote
                                class="text-pretty text-stone-700 transition duration-500 ease-out will-change-transform group-hover:translate-x-0.5 mt-3 sm:mt-5 sm:text-lg">
                                We use Filament to power the backend of Laravel News, and it has been a
                                <strong>fantastic fit for our workflow</strong>. It lets us move quickly, manage content
                                easily, and build custom admin features with minimal overhead. Filament strikes a
                                <strong>great balance between flexibility and developer experience</strong>, and it has
                                saved us countless hours while keeping our tools simple and reliable.
                            </blockquote>
                        </article>
                        <article
                            class="group block break-inside-avoid border border-bone-100 transition duration-500 ease-out not-last:mb-7 odd:hover:bg-bubblegum/25 even:hover:bg-minty-100/30 rounded-lg p-6 sm:p-8">
                            <header class="flex items-start justify-between gap-5">
                                <div class="flex items-center gap-2.5 sm:gap-3.5">

                                    <img src="https://fls-a148a526-7ce4-465e-b283-9b405912858a.laravel.cloud/019d24d8-16c9-713e-a0b0-4024e80e0c5e/01KMJDG5MV8D4GGF7B436D8RZA.jpg"
                                        alt="Avatar of Mike Craig" aria-hidden="true" loading="lazy"
                                        class="object-cover size-10 rounded-sm sm:size-12" />


                                    <div class="flex flex-col gap-px sm:gap-0.5">
                                        <cite
                                            class="truncate font-outfit font-medium text-stone-800 not-italic sm:text-lg">
                                            Mike Craig
                                        </cite>
                                        <p class="text-pretty text-sm sm:text-base">
                                            President
                                        </p>
                                    </div>
                                </div>


                                <svg aria-hidden="true"
                                    class="h-6 shrink-0 text-bone-300 mix-blend-luminosity sm:h-7.5"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35 35" fill="none">
                                    <path
                                        class="fill-current transition duration-500 ease-out group-hover:translate-x-4"
                                        d="M11.7982 16.9613H4.95865C5.07532 10.1508 6.41697 9.02785 10.6024 6.54868C11.0836 6.25702 11.244 5.64453 10.9524 5.1487C10.6607 4.66745 10.0482 4.50705 9.55234 4.79871C4.62318 7.71538 2.90234 9.49452 2.90234 17.982V25.8425C2.90234 28.3363 4.92947 30.3488 7.40864 30.3488H11.7836C14.3503 30.3488 16.2898 28.4092 16.2898 25.8425V21.4675C16.3044 18.9009 14.3649 16.9613 11.7982 16.9613Z" />
                                    <path
                                        class="fill-current opacity-40 transition duration-500 ease-out group-hover:-translate-x-4"
                                        d="M27.5773 16.9613H20.7377C20.8544 10.1508 22.1962 9.02785 26.3816 6.54868C26.8629 6.25702 27.0233 5.64453 26.7316 5.1487C26.44 4.66745 25.8275 4.50705 25.3316 4.79871C20.4025 7.71538 18.6816 9.49452 18.6816 17.982V25.8425C18.6816 28.3363 20.7087 30.3488 23.1879 30.3488H27.5629C30.1296 30.3488 32.0691 28.4092 32.0691 25.8425V21.4675C32.0837 18.9009 30.144 16.9613 27.5773 16.9613Z" />
                                </svg>
                            </header>


                            <blockquote
                                class="text-pretty text-stone-700 transition duration-500 ease-out will-change-transform group-hover:translate-x-0.5 mt-3 sm:mt-5 sm:text-lg">
                                Wow. 🤩 We&#039;ve changed our entire shop to produce nothing but Filament-enabled
                                backend applications. Filament <strong>blows any other platform out of the
                                    water</strong>, and is another reason why the Laravel ecosystem and developers like
                                us continue to ship! 🚀
                            </blockquote>
                        </article>
                        <article
                            class="group block break-inside-avoid border border-bone-100 transition duration-500 ease-out not-last:mb-7 odd:hover:bg-bubblegum/25 even:hover:bg-minty-100/30 rounded-lg p-6 sm:p-8">
                            <header class="flex items-start justify-between gap-5">
                                <div class="flex items-center gap-2.5 sm:gap-3.5">

                                    <img src="https://fls-a148a526-7ce4-465e-b283-9b405912858a.laravel.cloud/019d24d7-d30e-72fe-903c-8498be3e97d1/01KMJDFMPQ222HP05BZY8MXT67.jpg"
                                        alt="Avatar of Tim Wassenburg" aria-hidden="true" loading="lazy"
                                        class="object-cover size-10 rounded-sm sm:size-12" />


                                    <div class="flex flex-col gap-px sm:gap-0.5">
                                        <cite
                                            class="truncate font-outfit font-medium text-stone-800 not-italic sm:text-lg">
                                            Tim Wassenburg
                                        </cite>
                                        <p class="text-pretty text-sm sm:text-base">
                                            PHP/Laravel Developer
                                        </p>
                                    </div>
                                </div>


                                <svg aria-hidden="true"
                                    class="h-6 shrink-0 text-bone-300 mix-blend-luminosity sm:h-7.5"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35 35" fill="none">
                                    <path
                                        class="fill-current transition duration-500 ease-out group-hover:translate-x-4"
                                        d="M11.7982 16.9613H4.95865C5.07532 10.1508 6.41697 9.02785 10.6024 6.54868C11.0836 6.25702 11.244 5.64453 10.9524 5.1487C10.6607 4.66745 10.0482 4.50705 9.55234 4.79871C4.62318 7.71538 2.90234 9.49452 2.90234 17.982V25.8425C2.90234 28.3363 4.92947 30.3488 7.40864 30.3488H11.7836C14.3503 30.3488 16.2898 28.4092 16.2898 25.8425V21.4675C16.3044 18.9009 14.3649 16.9613 11.7982 16.9613Z" />
                                    <path
                                        class="fill-current opacity-40 transition duration-500 ease-out group-hover:-translate-x-4"
                                        d="M27.5773 16.9613H20.7377C20.8544 10.1508 22.1962 9.02785 26.3816 6.54868C26.8629 6.25702 27.0233 5.64453 26.7316 5.1487C26.44 4.66745 25.8275 4.50705 25.3316 4.79871C20.4025 7.71538 18.6816 9.49452 18.6816 17.982V25.8425C18.6816 28.3363 20.7087 30.3488 23.1879 30.3488H27.5629C30.1296 30.3488 32.0691 28.4092 32.0691 25.8425V21.4675C32.0837 18.9009 30.144 16.9613 27.5773 16.9613Z" />
                                </svg>
                            </header>


                            <blockquote
                                class="text-pretty text-stone-700 transition duration-500 ease-out will-change-transform group-hover:translate-x-0.5 mt-3 sm:mt-5 sm:text-lg">
                                Filament enabled us to <strong>rapidly create complex features</strong>, with
                                development taking only weeks instead of months. Working with Filament proved to be
                                efficient and productive. Being backed by a supportive community was crucial for the
                                delivery of a high-quality product.
                            </blockquote>
                        </article>
                        <article
                            class="group block break-inside-avoid border border-bone-100 transition duration-500 ease-out not-last:mb-7 odd:hover:bg-bubblegum/25 even:hover:bg-minty-100/30 rounded-lg p-6 sm:p-8">
                            <header class="flex items-start justify-between gap-5">
                                <div class="flex items-center gap-2.5 sm:gap-3.5">

                                    <img src="https://fls-a148a526-7ce4-465e-b283-9b405912858a.laravel.cloud/019d24d5-89e0-70e4-b573-af839911b94d/01KMJDB2D83GSYRCYKC7RQ69WR.png"
                                        alt="Avatar of Kevin McKee" aria-hidden="true" loading="lazy"
                                        class="object-cover size-10 rounded-sm sm:size-12" />


                                    <div class="flex flex-col gap-px sm:gap-0.5">
                                        <cite
                                            class="truncate font-outfit font-medium text-stone-800 not-italic sm:text-lg">
                                            Kevin McKee
                                        </cite>
                                        <p class="text-pretty text-sm sm:text-base">
                                            CTO of Padmission
                                        </p>
                                    </div>
                                </div>


                                <svg aria-hidden="true"
                                    class="h-6 shrink-0 text-bone-300 mix-blend-luminosity sm:h-7.5"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35 35" fill="none">
                                    <path
                                        class="fill-current transition duration-500 ease-out group-hover:translate-x-4"
                                        d="M11.7982 16.9613H4.95865C5.07532 10.1508 6.41697 9.02785 10.6024 6.54868C11.0836 6.25702 11.244 5.64453 10.9524 5.1487C10.6607 4.66745 10.0482 4.50705 9.55234 4.79871C4.62318 7.71538 2.90234 9.49452 2.90234 17.982V25.8425C2.90234 28.3363 4.92947 30.3488 7.40864 30.3488H11.7836C14.3503 30.3488 16.2898 28.4092 16.2898 25.8425V21.4675C16.3044 18.9009 14.3649 16.9613 11.7982 16.9613Z" />
                                    <path
                                        class="fill-current opacity-40 transition duration-500 ease-out group-hover:-translate-x-4"
                                        d="M27.5773 16.9613H20.7377C20.8544 10.1508 22.1962 9.02785 26.3816 6.54868C26.8629 6.25702 27.0233 5.64453 26.7316 5.1487C26.44 4.66745 25.8275 4.50705 25.3316 4.79871C20.4025 7.71538 18.6816 9.49452 18.6816 17.982V25.8425C18.6816 28.3363 20.7087 30.3488 23.1879 30.3488H27.5629C30.1296 30.3488 32.0691 28.4092 32.0691 25.8425V21.4675C32.0837 18.9009 30.144 16.9613 27.5773 16.9613Z" />
                                </svg>
                            </header>


                            <blockquote
                                class="text-pretty text-stone-700 transition duration-500 ease-out will-change-transform group-hover:translate-x-0.5 mt-3 sm:mt-5 sm:text-lg">
                                Our flagship SaaS product couldn&#039;t even exist without Filament. It is the
                                <strong>superpower</strong> that allows a small company like mine to <strong>build world
                                    class software</strong> in a fraction of the time it takes other companies. Whenever
                                I encounter something that&#039;s not already in the framework, the community has almost
                                always solved the problem with a plugin. Whether coding by hand or using AI, everything
                                just makes sense.
                            </blockquote>
                        </article>
                        <article
                            class="group block break-inside-avoid border border-bone-100 transition duration-500 ease-out not-last:mb-7 odd:hover:bg-bubblegum/25 even:hover:bg-minty-100/30 rounded-lg p-6 sm:p-8">
                            <header class="flex items-start justify-between gap-5">
                                <div class="flex items-center gap-2.5 sm:gap-3.5">

                                    <img src="https://fls-a148a526-7ce4-465e-b283-9b405912858a.laravel.cloud/019d24d7-a3ef-722e-9589-31877b18b538/01KMJDF8XWRPGBYK8BYFJR8NE2.jpg"
                                        alt="Avatar of Wiebe Nieuwenhuis" aria-hidden="true" loading="lazy"
                                        class="object-cover size-10 rounded-sm sm:size-12" />


                                    <div class="flex flex-col gap-px sm:gap-0.5">
                                        <cite
                                            class="truncate font-outfit font-medium text-stone-800 not-italic sm:text-lg">
                                            Wiebe Nieuwenhuis
                                        </cite>
                                        <p class="text-pretty text-sm sm:text-base">
                                            Developer &amp; Entrepreneur
                                        </p>
                                    </div>
                                </div>


                                <svg aria-hidden="true"
                                    class="h-6 shrink-0 text-bone-300 mix-blend-luminosity sm:h-7.5"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35 35" fill="none">
                                    <path
                                        class="fill-current transition duration-500 ease-out group-hover:translate-x-4"
                                        d="M11.7982 16.9613H4.95865C5.07532 10.1508 6.41697 9.02785 10.6024 6.54868C11.0836 6.25702 11.244 5.64453 10.9524 5.1487C10.6607 4.66745 10.0482 4.50705 9.55234 4.79871C4.62318 7.71538 2.90234 9.49452 2.90234 17.982V25.8425C2.90234 28.3363 4.92947 30.3488 7.40864 30.3488H11.7836C14.3503 30.3488 16.2898 28.4092 16.2898 25.8425V21.4675C16.3044 18.9009 14.3649 16.9613 11.7982 16.9613Z" />
                                    <path
                                        class="fill-current opacity-40 transition duration-500 ease-out group-hover:-translate-x-4"
                                        d="M27.5773 16.9613H20.7377C20.8544 10.1508 22.1962 9.02785 26.3816 6.54868C26.8629 6.25702 27.0233 5.64453 26.7316 5.1487C26.44 4.66745 25.8275 4.50705 25.3316 4.79871C20.4025 7.71538 18.6816 9.49452 18.6816 17.982V25.8425C18.6816 28.3363 20.7087 30.3488 23.1879 30.3488H27.5629C30.1296 30.3488 32.0691 28.4092 32.0691 25.8425V21.4675C32.0837 18.9009 30.144 16.9613 27.5773 16.9613Z" />
                                </svg>
                            </header>


                            <blockquote
                                class="text-pretty text-stone-700 transition duration-500 ease-out will-change-transform group-hover:translate-x-0.5 mt-3 sm:mt-5 sm:text-lg">
                                I can&#039;t imagine creating an application without Filament anymore. It&#039;s
                                <strong>incredibly easy and swift to use</strong>, yet highly adaptable to accommodate
                                your own or your clients&#039; specific requirements.
                            </blockquote>
                        </article>
                        <article
                            class="group block break-inside-avoid border border-bone-100 transition duration-500 ease-out not-last:mb-7 odd:hover:bg-bubblegum/25 even:hover:bg-minty-100/30 rounded-lg p-6 sm:p-8">
                            <header class="flex items-start justify-between gap-5">
                                <div class="flex items-center gap-2.5 sm:gap-3.5">

                                    <img src="https://fls-a148a526-7ce4-465e-b283-9b405912858a.laravel.cloud/019d24d7-79fb-7214-bb2c-6755424a8260/01KMJDEYE6HJGMVM9FJ0WBJGQJ.jpg"
                                        alt="Avatar of Cam Kemshal-Bell" aria-hidden="true" loading="lazy"
                                        class="object-cover size-10 rounded-sm sm:size-12" />


                                    <div class="flex flex-col gap-px sm:gap-0.5">
                                        <cite
                                            class="truncate font-outfit font-medium text-stone-800 not-italic sm:text-lg">
                                            Cam Kemshal-Bell
                                        </cite>
                                        <p class="text-pretty text-sm sm:text-base">
                                            Software Developer
                                        </p>
                                    </div>
                                </div>


                                <svg aria-hidden="true"
                                    class="h-6 shrink-0 text-bone-300 mix-blend-luminosity sm:h-7.5"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35 35" fill="none">
                                    <path
                                        class="fill-current transition duration-500 ease-out group-hover:translate-x-4"
                                        d="M11.7982 16.9613H4.95865C5.07532 10.1508 6.41697 9.02785 10.6024 6.54868C11.0836 6.25702 11.244 5.64453 10.9524 5.1487C10.6607 4.66745 10.0482 4.50705 9.55234 4.79871C4.62318 7.71538 2.90234 9.49452 2.90234 17.982V25.8425C2.90234 28.3363 4.92947 30.3488 7.40864 30.3488H11.7836C14.3503 30.3488 16.2898 28.4092 16.2898 25.8425V21.4675C16.3044 18.9009 14.3649 16.9613 11.7982 16.9613Z" />
                                    <path
                                        class="fill-current opacity-40 transition duration-500 ease-out group-hover:-translate-x-4"
                                        d="M27.5773 16.9613H20.7377C20.8544 10.1508 22.1962 9.02785 26.3816 6.54868C26.8629 6.25702 27.0233 5.64453 26.7316 5.1487C26.44 4.66745 25.8275 4.50705 25.3316 4.79871C20.4025 7.71538 18.6816 9.49452 18.6816 17.982V25.8425C18.6816 28.3363 20.7087 30.3488 23.1879 30.3488H27.5629C30.1296 30.3488 32.0691 28.4092 32.0691 25.8425V21.4675C32.0837 18.9009 30.144 16.9613 27.5773 16.9613Z" />
                                </svg>
                            </header>


                            <blockquote
                                class="text-pretty text-stone-700 transition duration-500 ease-out will-change-transform group-hover:translate-x-0.5 mt-3 sm:mt-5 sm:text-lg">
                                Filament, seamlessly integrated with Livewire, offers a <strong>robust and efficient
                                    development experience</strong>. The combination of Filament&#039;s user-friendly
                                admin interface and Livewire&#039;s real-time features enhances productivity and
                                simplifies complex tasks. This integration has proven instrumental in our workflow.
                            </blockquote>
                        </article>
                        <article
                            class="group block break-inside-avoid border border-bone-100 transition duration-500 ease-out not-last:mb-7 odd:hover:bg-bubblegum/25 even:hover:bg-minty-100/30 rounded-lg p-6 sm:p-8">
                            <header class="flex items-start justify-between gap-5">
                                <div class="flex items-center gap-2.5 sm:gap-3.5">

                                    <img src="https://fls-a148a526-7ce4-465e-b283-9b405912858a.laravel.cloud/019d24d5-c5ce-71e0-9ebc-63b69e89fcc6/01KMJDBHCSPGGS2V8CQ2N2351J.jpg"
                                        alt="Avatar of Luís Dalmolin" aria-hidden="true" loading="lazy"
                                        class="object-cover size-10 rounded-sm sm:size-12" />


                                    <div class="flex flex-col gap-px sm:gap-0.5">
                                        <cite
                                            class="truncate font-outfit font-medium text-stone-800 not-italic sm:text-lg">
                                            Luís Dalmolin
                                        </cite>
                                        <p class="text-pretty text-sm sm:text-base">
                                            CTO of Kirschbaum
                                        </p>
                                    </div>
                                </div>


                                <svg aria-hidden="true"
                                    class="h-6 shrink-0 text-bone-300 mix-blend-luminosity sm:h-7.5"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35 35" fill="none">
                                    <path
                                        class="fill-current transition duration-500 ease-out group-hover:translate-x-4"
                                        d="M11.7982 16.9613H4.95865C5.07532 10.1508 6.41697 9.02785 10.6024 6.54868C11.0836 6.25702 11.244 5.64453 10.9524 5.1487C10.6607 4.66745 10.0482 4.50705 9.55234 4.79871C4.62318 7.71538 2.90234 9.49452 2.90234 17.982V25.8425C2.90234 28.3363 4.92947 30.3488 7.40864 30.3488H11.7836C14.3503 30.3488 16.2898 28.4092 16.2898 25.8425V21.4675C16.3044 18.9009 14.3649 16.9613 11.7982 16.9613Z" />
                                    <path
                                        class="fill-current opacity-40 transition duration-500 ease-out group-hover:-translate-x-4"
                                        d="M27.5773 16.9613H20.7377C20.8544 10.1508 22.1962 9.02785 26.3816 6.54868C26.8629 6.25702 27.0233 5.64453 26.7316 5.1487C26.44 4.66745 25.8275 4.50705 25.3316 4.79871C20.4025 7.71538 18.6816 9.49452 18.6816 17.982V25.8425C18.6816 28.3363 20.7087 30.3488 23.1879 30.3488H27.5629C30.1296 30.3488 32.0691 28.4092 32.0691 25.8425V21.4675C32.0837 18.9009 30.144 16.9613 27.5773 16.9613Z" />
                                </svg>
                            </header>


                            <blockquote
                                class="text-pretty text-stone-700 transition duration-500 ease-out will-change-transform group-hover:translate-x-0.5 mt-3 sm:mt-5 sm:text-lg">
                                Filament has become a core part of how we build at Kirschbaum. It&#039;s fast to get
                                started with, <strong>reliable in production</strong>, looks amazing out of the box, and
                                has genuinely helped us ship projects faster without cutting corners on quality. When a
                                client needs a powerful admin panel or sometimes a fully fleshed-out application,
                                <strong>Filament is our first reach</strong>. It just works!
                            </blockquote>
                        </article>
                        <article
                            class="group block break-inside-avoid border border-bone-100 transition duration-500 ease-out not-last:mb-7 odd:hover:bg-bubblegum/25 even:hover:bg-minty-100/30 rounded-lg p-6 sm:p-8">
                            <header class="flex items-start justify-between gap-5">
                                <div class="flex items-center gap-2.5 sm:gap-3.5">

                                    <img src="https://fls-a148a526-7ce4-465e-b283-9b405912858a.laravel.cloud/019d24d7-486f-73fd-9fb5-a30b03875471/01KMJDEJ23JK72KNBNC7X9CMH1.jpg"
                                        alt="Avatar of Austin Carpenter" aria-hidden="true" loading="lazy"
                                        class="object-cover size-10 rounded-sm sm:size-12" />


                                    <div class="flex flex-col gap-px sm:gap-0.5">
                                        <cite
                                            class="truncate font-outfit font-medium text-stone-800 not-italic sm:text-lg">
                                            Austin Carpenter
                                        </cite>
                                        <p class="text-pretty text-sm sm:text-base">
                                            Director
                                        </p>
                                    </div>
                                </div>


                                <svg aria-hidden="true"
                                    class="h-6 shrink-0 text-bone-300 mix-blend-luminosity sm:h-7.5"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35 35" fill="none">
                                    <path
                                        class="fill-current transition duration-500 ease-out group-hover:translate-x-4"
                                        d="M11.7982 16.9613H4.95865C5.07532 10.1508 6.41697 9.02785 10.6024 6.54868C11.0836 6.25702 11.244 5.64453 10.9524 5.1487C10.6607 4.66745 10.0482 4.50705 9.55234 4.79871C4.62318 7.71538 2.90234 9.49452 2.90234 17.982V25.8425C2.90234 28.3363 4.92947 30.3488 7.40864 30.3488H11.7836C14.3503 30.3488 16.2898 28.4092 16.2898 25.8425V21.4675C16.3044 18.9009 14.3649 16.9613 11.7982 16.9613Z" />
                                    <path
                                        class="fill-current opacity-40 transition duration-500 ease-out group-hover:-translate-x-4"
                                        d="M27.5773 16.9613H20.7377C20.8544 10.1508 22.1962 9.02785 26.3816 6.54868C26.8629 6.25702 27.0233 5.64453 26.7316 5.1487C26.44 4.66745 25.8275 4.50705 25.3316 4.79871C20.4025 7.71538 18.6816 9.49452 18.6816 17.982V25.8425C18.6816 28.3363 20.7087 30.3488 23.1879 30.3488H27.5629C30.1296 30.3488 32.0691 28.4092 32.0691 25.8425V21.4675C32.0837 18.9009 30.144 16.9613 27.5773 16.9613Z" />
                                </svg>
                            </header>


                            <blockquote
                                class="text-pretty text-stone-700 transition duration-500 ease-out will-change-transform group-hover:translate-x-0.5 mt-3 sm:mt-5 sm:text-lg">
                                Filament has been an <strong>absolute game-changer</strong> for us for web application
                                development with Laravel. It&#039;s packed with features and is also highly extensible
                                and modular, allowing us to deliver bespoke experiences to our customers every time.
                            </blockquote>
                        </article>
                        <article
                            class="group block break-inside-avoid border border-bone-100 transition duration-500 ease-out not-last:mb-7 odd:hover:bg-bubblegum/25 even:hover:bg-minty-100/30 rounded-lg p-6 sm:p-8">
                            <header class="flex items-start justify-between gap-5">
                                <div class="flex items-center gap-2.5 sm:gap-3.5">

                                    <img src="https://fls-a148a526-7ce4-465e-b283-9b405912858a.laravel.cloud/019d24d7-2168-729e-bccf-d0d131599d78/01KMJDE89QZMTE7QZNM07GSBXZ.jpg"
                                        alt="Avatar of Bane Stojanović" aria-hidden="true" loading="lazy"
                                        class="object-cover size-10 rounded-sm sm:size-12" />


                                    <div class="flex flex-col gap-px sm:gap-0.5">
                                        <cite
                                            class="truncate font-outfit font-medium text-stone-800 not-italic sm:text-lg">
                                            Bane Stojanović
                                        </cite>
                                        <p class="text-pretty text-sm sm:text-base">
                                            Developer
                                        </p>
                                    </div>
                                </div>


                                <svg aria-hidden="true"
                                    class="h-6 shrink-0 text-bone-300 mix-blend-luminosity sm:h-7.5"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35 35" fill="none">
                                    <path
                                        class="fill-current transition duration-500 ease-out group-hover:translate-x-4"
                                        d="M11.7982 16.9613H4.95865C5.07532 10.1508 6.41697 9.02785 10.6024 6.54868C11.0836 6.25702 11.244 5.64453 10.9524 5.1487C10.6607 4.66745 10.0482 4.50705 9.55234 4.79871C4.62318 7.71538 2.90234 9.49452 2.90234 17.982V25.8425C2.90234 28.3363 4.92947 30.3488 7.40864 30.3488H11.7836C14.3503 30.3488 16.2898 28.4092 16.2898 25.8425V21.4675C16.3044 18.9009 14.3649 16.9613 11.7982 16.9613Z" />
                                    <path
                                        class="fill-current opacity-40 transition duration-500 ease-out group-hover:-translate-x-4"
                                        d="M27.5773 16.9613H20.7377C20.8544 10.1508 22.1962 9.02785 26.3816 6.54868C26.8629 6.25702 27.0233 5.64453 26.7316 5.1487C26.44 4.66745 25.8275 4.50705 25.3316 4.79871C20.4025 7.71538 18.6816 9.49452 18.6816 17.982V25.8425C18.6816 28.3363 20.7087 30.3488 23.1879 30.3488H27.5629C30.1296 30.3488 32.0691 28.4092 32.0691 25.8425V21.4675C32.0837 18.9009 30.144 16.9613 27.5773 16.9613Z" />
                                </svg>
                            </header>


                            <blockquote
                                class="text-pretty text-stone-700 transition duration-500 ease-out will-change-transform group-hover:translate-x-0.5 mt-3 sm:mt-5 sm:text-lg">
                                In every project that I am using where an admin panel is needed, I use Filament. I
                                don&#039;t even think about it, two lines of code to get you started, an amazing setup
                                experience, and <strong>unbelievable customizability</strong>. A million-dollar project
                                that is open-sourced!
                            </blockquote>
                        </article>
                    </div>

                    <div data-animate="enter-from-right" data-animate-delay="0.2"
                        class="absolute -top-52 right-15 z-1 hidden min-[1300px]:right-25 desktop:block">
                        <div x-data x-init="() => {
                            const sparky = $refs.sparky
                            const topZap = $refs.topZap
                            const leftZap = $refs.leftZap
                            const rightZap = $refs.rightZap
                            let isAnimating = false
                        
                            gsap.set(topZap, { opacity: 0 })
                            gsap.set(leftZap, { opacity: 0 })
                            gsap.set(rightZap, { opacity: 0 })
                        
                            motion.hover(sparky, () => {
                                if (isAnimating) return
                        
                                isAnimating = true
                        
                                const tl = gsap.timeline({
                                    onComplete: () => {
                                        isAnimating = false
                                    },
                                })
                        
                                tl.to(
                                        sparky, {
                                            keyframes: {
                                                y: [0, -4, 0],
                                                rotation: [0, 1, -1, 1, -1, 0],
                                            },
                                            duration: 0.7,
                                            ease: 'bounce.out',
                                        },
                                        0,
                                    )
                                    .to(
                                        topZap, {
                                            keyframes: {
                                                '0%': { scale: 0, opacity: 0, y: 6 },
                                                '60%': {
                                                    scale: 1,
                                                    opacity: 1,
                                                    y: 0,
                                                    ease: 'bounce.out',
                                                },
                                                '100%': { scale: 0, opacity: 0 },
                                            },
                                            duration: 0.7,
                                            ease: 'none',
                                        },
                                        0,
                                    )
                                    .to(
                                        leftZap, {
                                            keyframes: {
                                                '0%': { scale: 0, opacity: 0, x: 6 },
                                                '60%': {
                                                    scale: 1,
                                                    opacity: 1,
                                                    x: 0,
                                                    ease: 'bounce.out',
                                                },
                                                '100%': { scale: 0, opacity: 0 },
                                            },
                                            duration: 0.7,
                                            ease: 'none',
                                        },
                                        0.05,
                                    )
                                    .to(
                                        rightZap, {
                                            keyframes: {
                                                '0%': { scale: 0, opacity: 0, x: 6 },
                                                '60%': {
                                                    scale: 1,
                                                    opacity: 1,
                                                    x: 0,
                                                    ease: 'bounce.out',
                                                },
                                                '100%': { scale: 0, opacity: 0 },
                                            },
                                            duration: 0.7,
                                            ease: 'none',
                                        },
                                        0.1,
                                    )
                            })
                        }" class="relative flex flex-col items-center gap-2.5">

                            <p class="-mr-30 flex flex-col items-center gap-2 text-sm">
                                <span class="text-center">
                                    They're all crazy about Filament,
                                    <br />
                                    almost as much as
                                    <span class="font-medium text-stone-700">
                                        Sparky
                                    </span>
                                </span>
                                <svg aria-hidden="true" class="w-7" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 111 116" fill="none">
                                    <path class="stroke-current [stroke-width:var(--stroke-width,5)]"
                                        d="M1.5 114.97C1.99 100.9 6.34 75.02 31.41 72.1C66.03 68.07 93.85 60.56 84.68 9.04004" />
                                    <path class="stroke-current [stroke-width:var(--stroke-width,5)]"
                                        d="M64.5801 29.0999C64.5801 29.0999 87.2101 21.7499 81.9201 0.359863" />
                                    <path class="stroke-current [stroke-width:var(--stroke-width,5)]"
                                        d="M110.65 17.6999C110.65 17.6999 87.2002 21.7499 81.9102 0.359863" />
                                </svg>
                            </p>


                            <img x-ref="sparky" src="https://filamentphp.com/build/assets/sparky-CVGRXke7.webp"
                                alt="Sparky, the Filament mascot" aria-hidden="true" width="112"
                                height="145" class="w-28" loading="lazy" />


                            <div aria-hidden="true"
                                class="absolute right-0 bottom-0 z-0 h-5 w-20 -rotate-18 rounded-full bg-cocoa/20 blur-sm will-change-transform">
                            </div>


                            <div class="absolute bottom-25 left-5">
                                <svg x-ref="topZap" class="w-1.25 text-honey-200" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 5 25" fill="none">
                                    <path class="fill-current"
                                        d="M0 11.7063L5 25L2.4 12.6984L5 11.7063L3.4 0L0 3.1746L2.4 9.92064L0 11.7063Z" />
                                </svg>
                            </div>


                            <div class="absolute bottom-22 -left-2">
                                <svg x-ref="leftZap" class="w-5 text-honey-200" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 7" fill="none">
                                    <path class="fill-current"
                                        d="M10.9326 1.77286L15.217 5.02309L11.3758 3.54571L10.0462 6.05726L0 2.21607L3.54571 0L9.30749 3.25023L10.9326 1.77286Z" />
                                </svg>
                            </div>


                            <div class="absolute bottom-25 left-11 -scale-x-100 -rotate-20">
                                <svg x-ref="rightZap" class="w-5 text-honey-200" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 7" fill="none">
                                    <path class="fill-current"
                                        d="M10.9326 1.77286L15.217 5.02309L11.3758 3.54571L10.0462 6.05726L0 2.21607L3.54571 0L9.30749 3.25023L10.9326 1.77286Z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <footer data-triangle-decoration="top" class="border-t border-bone-100">
            <div data-triangle-decoration="bottom" class="border-b border-bone-100 px-5 pt-5 pb-5 sm:px-8 sm:pt-8">

                <div class="flex flex-col items-start justify-between gap-4 sm:flex-row">

                    <div class="flex flex-col items-start">

                        <div data-animate="enter-from-left">
                            <a href="https://filamentphp.com" aria-label="Filament homepage"
                                class="block transition duration-300 ease-out hover:-translate-x-2 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset">
                                <div x-init="() => {
                                    const logoInitialAnimation = $el.querySelectorAll('.logoInitialAnimation')
                                    const logoLightBulb = $el.querySelectorAll('.logoLightBulb')
                                    const logoF1 = $el.querySelectorAll('.logoF1')
                                    const logoF2 = $el.querySelectorAll('.logoF2')
                                    const logoI = $el.querySelector('.logoI')
                                    const logoIDot = $el.querySelector('.logoIDot')
                                    const logoL = $el.querySelector('.logoL')
                                    const logoA = $el.querySelector('.logoA')
                                    const logoM = $el.querySelector('.logoM')
                                    const logoE = $el.querySelector('.logoE')
                                    const logoN = $el.querySelector('.logoN')
                                    const logoT = $el.querySelector('.logoT')
                                    let isInitialAnimationComplete = false
                                    const isReversed = true
                                
                                    if (isReversed) {
                                        gsap.set(logoLightBulb, {
                                            opacity: 1,
                                            y: 0,
                                            scale: 1,
                                            transformOrigin: '50% 50%',
                                        })
                                        gsap.set(logoF1, { x: 0, opacity: 0 })
                                        gsap.set(logoF2, { x: 0, opacity: 1 })
                                        gsap.set(logoI, { x: 0, opacity: 0 })
                                        gsap.set(logoIDot, { x: 0, opacity: 0 })
                                        gsap.set(logoL, { x: 0 })
                                        gsap.set(logoA, { x: 0 })
                                        gsap.set(logoM, { x: 0 })
                                        gsap.set(logoE, { x: 0 })
                                        gsap.set(logoN, { x: 0 })
                                        gsap.set(logoT, { x: 0 })
                                    } else {
                                        gsap.set(logoLightBulb, {
                                            opacity: 0,
                                            y: -2,
                                            scale: 0.5,
                                            transformOrigin: '50% 50%',
                                        })
                                        gsap.set(logoF1, { x: 8 })
                                        gsap.set(logoF2, { x: 8, opacity: 0 })
                                        gsap.set(logoI, { x: -2 })
                                        gsap.set(logoIDot, { x: -2 })
                                        gsap.set(logoL, { x: -11 })
                                        gsap.set(logoA, { x: -11 })
                                        gsap.set(logoM, { x: -10 })
                                        gsap.set(logoE, { x: -9 })
                                        gsap.set(logoN, { x: -9 })
                                        gsap.set(logoT, { x: -8 })
                                    }
                                
                                    $el.removeAttribute('data-logo-pre-init')
                                    isInitialAnimationComplete = true
                                
                                    let animation
                                
                                    if (isReversed) {
                                        animation = gsap
                                            .timeline({ paused: true })
                                            .to(
                                                logoLightBulb, {
                                                    opacity: 0,
                                                    y: -2,
                                                    scale: 0.5,
                                                    duration: 0.4,
                                                    ease: 'sine.inOut',
                                                    keyframes: {
                                                        rotation: [0, -10, 0],
                                                        easeEach: 'sine.inOut',
                                                    },
                                                },
                                                0,
                                            )
                                            .to(
                                                logoF1, {
                                                    x: 8,
                                                    rotation: 0,
                                                    opacity: 1,
                                                    duration: 0.4,
                                                    ease: 'sine.inOut',
                                                    keyframes: {
                                                        rotation: [0, -10, 0],
                                                        easeEach: 'sine.inOut',
                                                    },
                                                },
                                                0,
                                            )
                                            .to(
                                                logoF2, {
                                                    x: 8,
                                                    rotation: 0,
                                                    opacity: 0,
                                                    duration: 0.4,
                                                    ease: 'sine.inOut',
                                                    keyframes: {
                                                        rotation: [0, -10, 0],
                                                        easeEach: 'sine.inOut',
                                                    },
                                                },
                                                0,
                                            )
                                            .to(
                                                logoI, {
                                                    x: -2,
                                                    opacity: 1,
                                                    duration: 0.4,
                                                    ease: 'sine.inOut',
                                                },
                                                0,
                                            )
                                            .to(
                                                logoIDot, {
                                                    x: -2,
                                                    opacity: 1,
                                                    duration: 0.4,
                                                    ease: 'sine.inOut',
                                                },
                                                0,
                                            )
                                            .to(
                                                logoL, {
                                                    x: -11,
                                                    rotation: 0,
                                                    duration: 0.4,
                                                    ease: 'sine.inOut',
                                                    keyframes: {
                                                        rotation: [0, -10, 0],
                                                        easeEach: 'sine.inOut',
                                                    },
                                                },
                                                0,
                                            )
                                            .to(
                                                logoA, {
                                                    x: -11,
                                                    rotation: 0,
                                                    duration: 0.4,
                                                    ease: 'sine.inOut',
                                                    keyframes: {
                                                        rotation: [0, -10, 0],
                                                        easeEach: 'sine.inOut',
                                                    },
                                                },
                                                0.02,
                                            )
                                            .to(
                                                logoM, {
                                                    x: -10,
                                                    rotation: 0,
                                                    duration: 0.4,
                                                    ease: 'sine.inOut',
                                                    keyframes: {
                                                        rotation: [0, -10, 0],
                                                        easeEach: 'sine.inOut',
                                                    },
                                                },
                                                0.04,
                                            )
                                            .to(
                                                logoE, {
                                                    x: -9,
                                                    rotation: 0,
                                                    duration: 0.4,
                                                    ease: 'sine.inOut',
                                                    keyframes: {
                                                        rotation: [0, -10, 0],
                                                        easeEach: 'sine.inOut',
                                                    },
                                                },
                                                0.06,
                                            )
                                            .to(
                                                logoN, {
                                                    x: -9,
                                                    rotation: 0,
                                                    duration: 0.4,
                                                    ease: 'sine.inOut',
                                                    keyframes: {
                                                        rotation: [0, -10, 0],
                                                        easeEach: 'sine.inOut',
                                                    },
                                                },
                                                0.08,
                                            )
                                            .to(
                                                logoT, {
                                                    x: -8,
                                                    rotation: 0,
                                                    duration: 0.4,
                                                    ease: 'sine.inOut',
                                                    keyframes: {
                                                        rotation: [0, -10, 0],
                                                        easeEach: 'sine.inOut',
                                                    },
                                                },
                                                0.1,
                                            )
                                    } else {
                                        animation = gsap
                                            .timeline({ paused: true })
                                            .to(
                                                logoLightBulb, {
                                                    opacity: 1,
                                                    y: 0,
                                                    scale: 1,
                                                    duration: 0.4,
                                                    ease: 'sine.inOut',
                                                    keyframes: {
                                                        rotation: [0, -10, 0],
                                                        easeEach: 'sine.inOut',
                                                    },
                                                },
                                                0,
                                            )
                                            .to(
                                                logoF1, {
                                                    x: 0,
                                                    rotation: 0,
                                                    opacity: 0,
                                                    duration: 0.4,
                                                    ease: 'sine.inOut',
                                                    keyframes: {
                                                        rotation: [0, -10, 0],
                                                        easeEach: 'sine.inOut',
                                                    },
                                                },
                                                0,
                                            )
                                            .to(
                                                logoF2, {
                                                    x: 0,
                                                    rotation: 0,
                                                    opacity: 1,
                                                    duration: 0.4,
                                                    ease: 'sine.inOut',
                                                    keyframes: {
                                                        rotation: [0, -10, 0],
                                                        easeEach: 'sine.inOut',
                                                    },
                                                },
                                                0,
                                            )
                                            .to(
                                                logoI, {
                                                    x: 0,
                                                    color: '#efaf5d',
                                                    opacity: 0,
                                                    duration: 0.4,
                                                    ease: 'sine.inOut',
                                                },
                                                0,
                                            )
                                            .to(
                                                logoIDot, {
                                                    x: 0,
                                                    color: '#efaf5d',
                                                    opacity: 0,
                                                    duration: 0.4,
                                                    ease: 'sine.inOut',
                                                },
                                                0,
                                            )
                                            .to(
                                                [logoL, logoA, logoM, logoE, logoN, logoT], {
                                                    x: 0,
                                                    rotation: 0,
                                                    duration: 0.4,
                                                    stagger: 0.02,
                                                    ease: 'sine.inOut',
                                                    keyframes: {
                                                        rotation: [0, -10, 0],
                                                        easeEach: 'sine.inOut',
                                                    },
                                                },
                                                0,
                                            )
                                    }
                                
                                    motion.hover($el, () => {
                                        if (!isInitialAnimationComplete) {
                                            return
                                        }
                                        animation.play()
                                
                                        return () => {
                                            if (!isInitialAnimationComplete) {
                                                return
                                            }
                                            animation.reverse()
                                        }
                                    })
                                }">
                                    <svg class="h-10" viewBox="0 0 144 43" version="1.1"
                                        xmlns="http://www.w3.org/2000/svg">

                                        <path class="logoInitialAnimation logoF1 fill-cocoa"
                                            d="M7.223,12.685L7.223,11.42C7.223,9.471 7.871,8.001 9.813,8.001L11.55,8.001L11.55,4L9.813,4C5.349,4 3.033,6.769 3.033,11.42L3.033,12.685L0,12.685L0,16.035L3.033,16.035L3.033,28.651L7.223,28.651L7.223,16.035L12.348,16.035L12.348,12.685L7.223,12.685Z" />

                                        <path class="logoF2 fill-cocoa"
                                            d="M9.772,8.012L12.283,8.012C12.809,6.58 13.529,5.243 14.407,4.03L9.772,4.03C5.327,4.03 3.02,6.787 3.02,11.416L3.02,12.676L0,12.676L0,16.011L3.02,16.011L3.02,28.571L7.194,28.571L7.194,16.011L11.426,16.011C11.324,15.268 11.267,14.511 11.267,13.74C11.267,13.382 11.282,13.028 11.305,12.676L7.194,12.676L7.194,11.416C7.194,9.476 7.839,8.012 9.772,8.012" />

                                        <g transform="matrix(1,0,0,1,0.214531,-0.010962)">
                                            <path class="logoInitialAnimation logoI fill-cocoa"
                                                d="M27.909,12.766L28.056,11.476L25.39,11.554L25.406,11.654C25.43,11.8 25.41,11.976 25.388,12.162C25.344,12.545 25.293,12.98 25.642,13.278C25.763,13.38 26.155,13.601 26.579,13.844C26.846,13.997 27.188,14.19 27.358,14.301C27.25,14.337 27.091,14.333 26.942,14.325C26.845,14.319 26.746,14.313 26.656,14.321L26.527,14.329C26.105,14.357 25.731,14.384 25.614,14.44C25.411,14.537 25.35,14.963 25.379,15.308C25.393,15.481 25.454,15.885 25.723,16.056L27.356,17.047L25.64,17.201L25.607,17.211C25.439,17.295 25.422,17.661 25.423,17.855C25.423,18.173 25.496,18.582 25.716,18.77L27.404,19.805C27.34,19.806 27.276,19.809 27.212,19.81C26.661,19.824 26.087,19.844 25.58,19.991L25.553,20.005C25.426,20.1 25.423,20.764 25.518,21.135C25.572,21.349 25.66,21.467 25.757,21.527L27.408,22.526L25.756,22.678L25.725,22.686C25.376,22.852 25.512,23.777 25.602,24.048L25.616,24.092L27.479,25.289L25.831,25.401C25.719,25.406 25.664,25.468 25.621,25.525C25.485,25.705 25.496,26.429 25.524,27.426C25.538,27.916 25.551,28.379 25.52,28.568L25.498,28.709L27.883,28.717L27.895,27.157L30.718,26.868L30.742,26.865L30.761,26.852C30.861,26.76 30.903,26.505 30.904,26.318C30.905,26.172 30.894,25.621 30.715,25.424L28.93,24.298L30.712,24.133L30.732,24.118C30.879,24.008 30.898,23.375 30.8,22.99C30.738,22.751 30.648,22.585 30.522,22.531L28.874,21.527C29.036,21.519 29.206,21.514 29.381,21.51C29.777,21.5 30.188,21.489 30.531,21.418C30.652,21.392 30.739,21.291 30.788,21.115C30.888,20.759 30.811,20.157 30.643,19.925C30.564,19.815 30.216,19.606 29.376,19.131C29.128,18.991 28.896,18.845 28.772,18.768C28.904,18.762 29.074,18.76 29.25,18.759C29.976,18.752 30.514,18.738 30.662,18.584C30.778,18.464 30.832,17.878 30.727,17.478C30.671,17.262 30.592,17.109 30.474,17.054L28.826,16.048L30.491,15.909L30.524,15.9C30.725,15.798 30.76,15.321 30.735,15.029C30.718,14.828 30.655,14.456 30.428,14.308" />
                                        </g>

                                        <g transform="matrix(0.995789,0,0,0.995652,0.338179,0.317612)">
                                            <path class="logoInitialAnimation logoIDot fill-cocoa"
                                                d="M27.694,5C26.228,5 25,6.095 25,7.498C25,8.901 26.228,10.029 27.694,10.029C29.159,10.029 30.319,8.934 30.319,7.498C30.319,6.061 29.126,5 27.694,5Z" />
                                        </g>


                                        <rect class="logoInitialAnimation logoL fill-cocoa" x="44.27" y="4.029"
                                            width="4.139" height="24.542" />

                                        <path class="logoInitialAnimation logoA fill-cocoa"
                                            d="M59.517,24.895C57.243,24.895 55.139,23.159 55.139,20.606C55.139,18.052 57.243,16.317 59.517,16.317C61.791,16.317 63.86,17.848 63.86,20.606C63.86,23.363 61.757,24.895 59.517,24.895ZM63.86,14.649C62.706,12.879 60.365,12.335 58.94,12.335C54.766,12.335 50.864,15.5 50.864,20.606C50.864,25.711 54.766,28.877 58.94,28.877C60.501,28.877 62.842,28.162 63.86,26.528L63.86,28.571L67.999,28.571L67.999,12.675L63.86,12.675L63.86,14.649Z" />

                                        <path class="logoInitialAnimation logoM fill-cocoa"
                                            d="M89.815,12.335C88.56,12.335 86.32,12.709 84.827,15.331C83.945,13.39 82.282,12.505 79.772,12.369C78.278,12.369 76.106,13.084 75.225,15.024L75.225,12.676L71.085,12.676L71.085,28.572L75.225,28.572L75.225,20.096C75.225,17.374 76.853,16.386 78.55,16.386C80.247,16.386 81.434,17.611 81.468,19.824L81.468,28.571L85.608,28.571L85.608,20.096C85.608,17.679 86.965,16.385 88.832,16.385C90.528,16.385 91.818,17.645 91.818,19.925L91.818,28.571L95.924,28.571L95.924,19.483C95.924,14.819 93.65,12.335 89.816,12.335" />

                                        <path class="logoInitialAnimation logoE fill-cocoa"
                                            d="M102.121,19.176C102.427,17.031 104.123,15.806 106.295,15.806C108.331,15.806 109.959,16.997 110.265,19.176L102.121,19.176ZM106.261,12.335C101.748,12.335 98.05,15.569 98.05,20.572C98.05,25.576 101.748,28.912 106.261,28.912C109.179,28.912 112.233,27.788 113.658,25.065C112.64,24.52 111.487,23.908 110.503,23.363C109.757,24.725 108.128,25.406 106.533,25.406C104.192,25.406 102.427,24.112 102.156,22.002L114.235,22.002C114.269,21.628 114.303,20.981 114.303,20.573C114.303,15.569 110.775,12.335 106.262,12.335" />

                                        <path class="logoInitialAnimation logoN fill-cocoa"
                                            d="M125.97,12.335C124.137,12.335 122.135,13.322 121.253,15.023L121.253,12.675L117.113,12.675L117.113,28.571L121.253,28.571L121.253,20.096C121.253,17.338 122.848,16.385 124.714,16.385C126.579,16.385 127.734,17.61 127.734,19.925L127.734,28.571L131.874,28.571L131.874,19.176C131.874,14.682 129.668,12.334 125.97,12.334" />

                                        <path class="logoInitialAnimation logoT fill-cocoa"
                                            d="M136.535,6.616L136.535,12.675L133.65,12.675L133.65,16.011L136.535,16.011L136.535,28.571L140.641,28.571L140.641,16.011L144,16.011L144,12.675L140.641,12.675L140.641,6.616L136.535,6.616Z" />

                                        <path class="logoLightBulb fill-honey-200"
                                            d="M25.233,7.782C25.233,9.213 26.455,10.303 27.915,10.303C29.375,10.303 30.53,9.213 30.53,7.782C30.53,6.352 29.341,5.296 27.915,5.296C26.489,5.296 25.233,6.386 25.233,7.782Z" />

                                        <path class="logoLightBulb fill-honey-200"
                                            d="M33.7,1.323C30.892,-0.035 27.654,-0.361 24.586,0.407C22.56,0.916 20.657,1.909 19.088,3.277C18.809,3.513 18.539,3.765 18.277,4.029C17.4,4.915 16.623,5.955 15.965,7.135C15.802,7.423 15.652,7.715 15.511,8.011C14.805,9.496 14.374,11.08 14.241,12.674C14.211,13.046 14.194,13.419 14.195,13.792C14.185,14.526 14.244,15.266 14.368,16.01C14.511,16.859 14.736,17.712 15.051,18.56C15.565,19.922 16.262,21.168 16.929,22.322C17.603,23.527 18.154,24.541 18.648,25.566C19.044,26.406 19.395,27.283 19.698,28.178C19.796,28.469 19.889,28.762 19.977,29.057L20.155,29.691C20.299,30.209 20.577,30.648 20.957,30.959C21.656,31.533 22.585,31.667 23.464,31.308L25.825,30.177L28.861,28.723L28.786,27.072L30.929,26.852L30.953,26.85L30.971,26.837C31.092,26.751 31.113,26.425 31.114,26.24C31.115,26.094 31.105,25.604 30.928,25.408L29.139,24.285L30.922,24.119L30.941,24.105C31.088,23.996 31.107,23.333 31.008,22.95C30.948,22.712 30.845,22.56 30.72,22.507L29.086,21.516C29.248,21.507 29.416,21.503 29.59,21.498C29.985,21.488 30.393,21.478 30.736,21.406C30.857,21.381 30.944,21.279 30.993,21.104C31.092,20.75 31.021,20.131 30.855,19.901C30.775,19.791 30.413,19.576 29.577,19.103C29.33,18.963 29.096,18.831 28.973,18.754C29.105,18.748 29.273,18.747 29.448,18.745C30.171,18.738 30.696,18.723 30.862,18.584C31,18.469 31.042,17.837 30.938,17.438C30.881,17.224 30.787,17.083 30.67,17.029L29.036,16.038L30.701,15.899L30.735,15.889C30.934,15.789 30.97,15.291 30.946,15.001C30.929,14.801 30.867,14.444 30.642,14.296L28.125,12.755L28.271,11.465L25.604,11.543L25.621,11.643C25.644,11.788 25.624,11.963 25.602,12.149C25.559,12.531 25.509,12.963 25.856,13.259C25.976,13.361 26.375,13.59 26.797,13.831C27.063,13.984 27.406,14.18 27.575,14.29C27.467,14.327 27.315,14.318 27.167,14.31C27.071,14.304 26.971,14.299 26.882,14.306L26.754,14.314C26.334,14.342 25.946,14.371 25.829,14.426C25.627,14.522 25.565,14.936 25.594,15.281C25.608,15.454 25.669,15.873 25.937,16.043L27.573,17.036L25.859,17.187L25.825,17.197C25.658,17.281 25.634,17.616 25.634,17.809C25.634,18.125 25.706,18.558 25.924,18.745L27.619,19.793C27.556,19.794 27.492,19.797 27.429,19.798C26.879,19.812 26.31,19.827 25.805,19.973L25.778,19.987C25.652,20.082 25.643,20.734 25.731,21.104C25.784,21.327 25.874,21.47 25.986,21.523L27.623,22.515L25.973,22.666L25.942,22.674C25.594,22.84 25.725,23.76 25.814,24.029L25.828,24.073L27.694,25.278L26.048,25.389C25.936,25.395 25.881,25.457 25.838,25.513C25.736,25.649 25.716,26.064 25.725,26.687L22.928,28.121C22.526,26.781 22.026,25.473 21.44,24.227C20.905,23.117 20.325,22.049 19.616,20.782C18.982,19.686 18.377,18.607 17.949,17.469C17.494,16.244 17.272,15.013 17.289,13.806C17.281,12.04 17.755,10.261 18.66,8.658C19.335,7.45 20.154,6.435 21.099,5.635C22.315,4.575 23.78,3.809 25.335,3.418C25.403,3.4 25.471,3.386 25.539,3.371L25.601,3.358C27.314,2.978 29.114,3.038 30.807,3.528C31.353,3.686 31.877,3.886 32.366,4.122C34.263,5.023 35.908,6.558 36.999,8.449C38.197,10.474 38.699,12.799 38.413,14.999C38.278,16.152 37.912,17.369 37.328,18.611C37.019,19.238 36.663,19.862 36.318,20.466C36.1,20.849 35.882,21.233 35.67,21.623C35.027,22.81 33.998,25.213 33.66,26.003C33.6,26.143 33.562,26.233 33.546,26.266C33.191,27.089 32.681,28.272 32.517,28.649L29.277,30.223L22.526,33.501C21.759,33.811 21.307,34.598 21.426,35.422C21.542,36.23 22.207,36.854 23.065,36.954L27.329,37.104L21.883,40.192L23.155,42.998L34.252,37.646C35.135,37.238 35.527,36.211 35.146,35.309C34.893,34.709 34.312,34.295 33.63,34.228L29.608,33.244L34.727,31.075C34.852,31.018 34.859,31.013 36.174,27.988C36.234,27.849 36.296,27.705 36.362,27.553C36.363,27.551 36.374,27.525 36.394,27.479C36.797,26.527 37.799,24.195 38.388,23.107C38.582,22.747 38.784,22.392 38.987,22.038L39.004,22.009C39.355,21.395 39.752,20.699 40.115,19.961C40.849,18.399 41.31,16.857 41.483,15.382C41.856,12.51 41.211,9.489 39.667,6.877C38.271,4.459 36.15,2.487 33.699,1.321" />
                                    </svg>
                                </div>
                            </a>
                        </div>


                        <p data-animate="text-reveal-words" class="mt-1 max-w-sm text-pretty" role="note">
                            An open-source
                            <strong>UI framework,</strong>
                            built with Livewire to help you ship apps & admin panels
                            fast.
                        </p>
                    </div>

                    <div data-animate="enter-from-right" x-init="async () => {
                        await window.FilamentAnimations.waitForFonts()
                    
                        const button = $el.querySelector('button')
                        const textWrapper = button.querySelector('[data-text]')
                        const arrow = button.querySelector('svg')
                    
                        const split = new SplitText(textWrapper, { type: 'chars' })
                        const chars = split.chars
                    
                        const tl = gsap.timeline({ paused: true })
                    
                        tl.to(chars, {
                            keyframes: [
                                { y: -10, opacity: 0, duration: 0.2, ease: 'power2.in' },
                                { y: 10, opacity: 0, duration: 0 },
                                { y: 0, opacity: 1, duration: 0.2, ease: 'power2.out' },
                            ],
                            stagger: 0.02,
                        })
                    
                        tl.to(
                            arrow, {
                                keyframes: [
                                    { y: -30, duration: 0.25, ease: 'power2.in' },
                                    { y: 30, duration: 0 },
                                    { y: 0, duration: 0.25, ease: 'power2.out' },
                                ],
                            },
                            0.1,
                        )
                    
                        motion.hover(button, () => {
                            tl.tweenTo(tl.duration())
                    
                            return () => {
                                tl.tweenTo(0)
                            }
                        })
                    }">
                        <button data-button-pulse type="button" aria-label="Back to top"
                            x-on:click="window.scrollTo({ top: 0, behavior: 'smooth' })"
                            class="inline-flex h-13 items-center gap-2 rounded-full bg-cream-100 pr-5 pl-1.25 font-medium text-stone-900 transition duration-300 ease-out will-change-transform hover:scale-y-102 hover:bg-minty-100 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset">
                            <div
                                class="relative isolate grid size-11 place-items-center overflow-hidden rounded-full bg-stone-900 text-cream-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.25 -rotate-90"
                                    viewBox="0 0 28 22" fill="none">
                                    <path class="fill-current"
                                        d="M1 10H5.96046e-08V12H1V10ZM27 12C27.5523 12 28 11.5523 28 11C28 10.4477 27.5523 10 27 10V12ZM18 1V5.96046e-08H16V1H18ZM26.4207 11.7774C26.9055 12.0419 27.5129 11.8632 27.7774 11.3783C28.0419 10.8935 27.8632 10.286 27.3783 10.0216L26.4207 11.7774ZM15.9999 20.8995V21.8995H17.9999V20.8995H15.9999ZM1 12H26.8994V10H1V12ZM26.8994 12H27V10H26.8994V12ZM16 1C16 2.47241 16.7953 3.87873 17.7716 5.0769C18.7678 6.29956 20.0716 7.44977 21.3383 8.42854C22.6109 9.41186 23.8784 10.2469 24.825 10.835C25.2993 11.1295 25.6952 11.3635 25.9738 11.5245C26.1131 11.605 26.2233 11.6674 26.2993 11.71C26.3374 11.7314 26.3669 11.7478 26.3873 11.7591C26.3975 11.7647 26.4055 11.7691 26.411 11.7721C26.4138 11.7737 26.416 11.7749 26.4176 11.7758C26.4184 11.7762 26.4191 11.7765 26.4196 11.7768C26.4199 11.777 26.4201 11.7771 26.4202 11.7772C26.4205 11.7773 26.4207 11.7774 26.8995 10.8995C27.3783 10.0216 27.3784 10.0217 27.3785 10.0217C27.3785 10.0217 27.3785 10.0217 27.3785 10.0217C27.3784 10.0216 27.3781 10.0215 27.3777 10.0213C27.3769 10.0208 27.3756 10.0201 27.3736 10.019C27.3697 10.0168 27.3634 10.0134 27.3549 10.0087C27.3378 9.99926 27.3118 9.98479 27.2773 9.96547C27.2084 9.92682 27.1058 9.86878 26.9745 9.79288C26.7117 9.64102 26.3342 9.41799 25.8804 9.13606C24.9708 8.57104 23.7635 7.77501 22.5612 6.84596C21.353 5.91235 20.182 4.86894 19.322 3.81356C18.4422 2.73371 18 1.77759 18 1H16ZM26.8994 11C26.5248 10.0728 26.5245 10.0729 26.5242 10.0731C26.524 10.0731 26.5237 10.0733 26.5234 10.0734C26.5228 10.0736 26.522 10.0739 26.5211 10.0743C26.5193 10.0751 26.5169 10.076 26.5138 10.0773C26.5078 10.0797 26.4994 10.0832 26.4888 10.0876C26.4674 10.0964 26.4369 10.1091 26.3979 10.1257C26.3199 10.1587 26.2077 10.2071 26.0662 10.2703C25.7834 10.3967 25.3826 10.5825 24.903 10.824C23.9463 11.3055 22.6639 12.0142 21.3751 12.919C20.0914 13.8201 18.7665 14.94 17.7546 16.2535C16.7415 17.5685 15.9999 19.1342 15.9999 20.8995H17.9999C17.9999 19.715 18.4958 18.5685 19.3389 17.4742C20.1831 16.3784 21.333 15.3922 22.5242 14.5559C23.7103 13.7232 24.9028 13.0632 25.8022 12.6104C26.2507 12.3846 26.6233 12.2119 26.8818 12.0965C27.011 12.0388 27.1115 11.9955 27.1785 11.967C27.212 11.9528 27.2371 11.9424 27.2533 11.9357C27.2613 11.9324 27.2671 11.93 27.2706 11.9286C27.2724 11.9279 27.2735 11.9274 27.2741 11.9271C27.2744 11.927 27.2745 11.927 27.2745 11.927C27.2745 11.927 27.2744 11.927 27.2744 11.927C27.2742 11.9271 27.274 11.9272 26.8994 11Z" />
                                </svg>
                            </div>
                            <div class="overflow-hidden whitespace-nowrap" data-text>
                                Back to top
                            </div>
                        </button>
                    </div>
                </div>


                <div class="mt-5 flex flex-wrap items-start justify-between gap-5">

                    <div data-animate="enter-from-left" class="order-last sm:order-first">
                        <nav class="inline-flex divide-x divide-bone-100 border-bone-100 md:w-10 md:flex-col md:divide-x-0 md:divide-y rounded-md border"
                            aria-label="Social media links">
                            <a href="https://x.com/filamentphp" target="_blank" rel="external noopener noreferrer"
                                aria-label="X (Twitter) (opens in a new tab)"
                                class="group relative inline-grid place-items-center transition duration-300 ease-out focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset size-10 hover:bg-bone-100/30">
                                <svg class="transition duration-300 will-change-transform group-hover:scale-95 h-4.5"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18" fill="none">
                                    <path
                                        d="M16.9685 16.6804L11.2208 7.64748L16.8923 1.40851C17.2675 0.985507 17.0441 0.31493 16.4902 0.201466C16.2393 0.150075 15.9797 0.233093 15.8052 0.420553L10.4027 6.36295L6.68501 0.520636C6.55027 0.308566 6.31649 0.18007 6.06525 0.179993H1.65802C1.09258 0.179719 0.738876 0.791655 1.02136 1.28149C1.02678 1.2909 1.03242 1.30018 1.03826 1.30935L6.786 10.3414L1.11447 16.5849C0.729173 16.9988 0.936384 17.6746 1.48744 17.8013C1.74935 17.8615 2.02324 17.7739 2.20158 17.5729L7.6041 11.6305L11.3218 17.4728C11.4576 17.6831 11.6912 17.8098 11.9415 17.8089H16.3488C16.9142 17.8087 17.2674 17.1965 16.9845 16.7069C16.9794 16.6979 16.974 16.6891 16.9685 16.6804ZM12.3446 16.3398L2.9958 1.64907H5.65849L15.011 16.3398H12.3446Z"
                                        class="fill-current" />
                                </svg>


                                <div
                                    class="pointer-events-none absolute inset-y-0 hidden items-center gap-3 md:flex left-[calc(100%+theme(spacing.3))] flex-row-reverse">
                                    <div
                                        class="font-roboto-mono text-sm whitespace-nowrap text-stone-500 opacity-0 transition delay-20 duration-300 will-change-transform group-hover:translate-x-0 group-hover:opacity-100 -translate-x-1">
                                        X (Twitter)
                                    </div>
                                    <div
                                        class="h-px w-10 scale-x-0 bg-bone-300/80 transition duration-300 will-change-transform group-hover:scale-x-100 origin-left">
                                    </div>
                                </div>
                            </a>
                            <a href="/discord" target="_blank" rel="external noopener noreferrer"
                                aria-label="Discord (opens in a new tab)"
                                class="group relative inline-grid place-items-center transition duration-300 ease-out focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset size-10 hover:bg-bone-100/30">
                                <svg class="transition duration-300 will-change-transform group-hover:scale-95 h-4.5"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 151 107" fill="none">
                                    <path class="stroke-current [stroke-width:var(--stroke-width,8)]"
                                        d="M60.0637 21.5798V13H36.5301L18 77.6812L60.0637 93L65.9349 76.3188" />
                                    <path class="stroke-current [stroke-width:var(--stroke-width,8)]"
                                        d="M89.9877 21.5798V13H113.521L132.043 77.6812L89.9877 93L84.1084 76.3188" />
                                    <path class="stroke-current [stroke-width:var(--stroke-width,8)]"
                                        d="M100.157 73.2778C94.3831 75.8404 85.3978 77.4866 75.3096 77.4866H75.3259C65.2377 77.4866 56.2606 75.8404 50.4785 73.2778" />
                                    <path class="stroke-current [stroke-width:var(--stroke-width,8)]"
                                        d="M50.4863 24.7345C56.2603 22.1719 65.2455 20.5256 75.3337 20.5256H75.3175C85.4056 20.5256 94.3828 22.1719 100.165 24.7345" />
                                    <path class="fill-current"
                                        d="M58.5061 60.8784C61.3814 60.8784 63.7123 58.5475 63.7123 55.6721C63.7123 52.7968 61.3814 50.4658 58.5061 50.4658C55.6307 50.4658 53.2998 52.7968 53.2998 55.6721C53.2998 58.5475 55.6307 60.8784 58.5061 60.8784Z" />
                                    <path class="fill-current"
                                        d="M92.3645 60.8784C95.2398 60.8784 97.5707 58.5475 97.5707 55.6721C97.5707 52.7968 95.2398 50.4658 92.3645 50.4658C89.4891 50.4658 87.1582 52.7968 87.1582 55.6721C87.1582 58.5475 89.4891 60.8784 92.3645 60.8784Z" />
                                </svg>


                                <div
                                    class="pointer-events-none absolute inset-y-0 hidden items-center gap-3 md:flex left-[calc(100%+theme(spacing.3))] flex-row-reverse">
                                    <div
                                        class="font-roboto-mono text-sm whitespace-nowrap text-stone-500 opacity-0 transition delay-20 duration-300 will-change-transform group-hover:translate-x-0 group-hover:opacity-100 -translate-x-1">
                                        Discord
                                    </div>
                                    <div
                                        class="h-px w-10 scale-x-0 bg-bone-300/80 transition duration-300 will-change-transform group-hover:scale-x-100 origin-left">
                                    </div>
                                </div>
                            </a>
                            <a href="https://github.com/filamentphp/filament" target="_blank"
                                rel="external noopener noreferrer" aria-label="GitHub (opens in a new tab)"
                                class="group relative inline-grid place-items-center transition duration-300 ease-out focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset size-10 hover:bg-bone-100/30">
                                <svg class="transition duration-300 will-change-transform group-hover:scale-95 h-4.5"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 127 133" overflow="visible"
                                    fill="none">
                                    <path class="stroke-current [stroke-width:var(--stroke-width,10)]"
                                        d="M0.480469 71.73C0.480469 71.73 13.9205 76.31 18.0405 91.9C22.1605 107.49 27.5705 110.18 31.8505 112.36C34.6505 113.79 47.5905 117.46 57.7505 113.78" />
                                    <path class="stroke-current [stroke-width:var(--stroke-width,10)]"
                                        d="M103.18 132.95V106.13C103.18 93.54 92.9796 83.34 80.3896 83.34C67.7996 83.34 57.5996 93.54 57.5996 106.13V132.95" />
                                    <path class="stroke-current [stroke-width:var(--stroke-width,10)]"
                                        d="M64.75 22.65C68.38 21.04 74.02 20 80.36 20H80.35" />
                                    <path class="stroke-current [stroke-width:var(--stroke-width,10)]"
                                        d="M45.4302 30.98C45.4302 30.98 35.4802 34.08 35.4902 51.46V57.25C35.4902 71.66 47.1702 83.34 61.5802 83.34H80.3902" />
                                    <path class="stroke-current [stroke-width:var(--stroke-width,10)]"
                                        d="M40.0302 35.23C40.0302 35.23 29.4502 17.64 44.1802 1.57999C44.1802 1.57999 70.2802 4.67999 72.5502 21.33" />
                                    <path class="stroke-current [stroke-width:var(--stroke-width,10)]"
                                        d="M95.6295 22.65C91.9995 21.04 86.3595 20 80.0195 20H80.0295" />
                                    <path class="stroke-current [stroke-width:var(--stroke-width,10)]"
                                        d="M114.95 30.98C114.95 30.98 124.9 34.08 124.89 51.46V57.25C124.89 71.66 113.21 83.34 98.8002 83.34H79.9902" />
                                    <path class="stroke-current [stroke-width:var(--stroke-width,10)]"
                                        d="M120.35 35.23C120.35 35.23 130.93 17.64 116.2 1.57999C116.2 1.57999 90.1001 4.67999 87.8301 21.33" />
                                </svg>


                                <div
                                    class="pointer-events-none absolute inset-y-0 hidden items-center gap-3 md:flex left-[calc(100%+theme(spacing.3))] flex-row-reverse">
                                    <div
                                        class="font-roboto-mono text-sm whitespace-nowrap text-stone-500 opacity-0 transition delay-20 duration-300 will-change-transform group-hover:translate-x-0 group-hover:opacity-100 -translate-x-1">
                                        GitHub
                                    </div>
                                    <div
                                        class="h-px w-10 scale-x-0 bg-bone-300/80 transition duration-300 will-change-transform group-hover:scale-x-100 origin-left">
                                    </div>
                                </div>
                            </a>
                            <a href="https://phpc.social/@filament" target="_blank"
                                rel="external noopener noreferrer" aria-label="Mastodon (opens in a new tab)"
                                class="group relative inline-grid place-items-center transition duration-300 ease-out focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset size-10 hover:bg-bone-100/30">
                                <svg class="transition duration-300 will-change-transform group-hover:scale-95 h-4.5"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18" fill="none">
                                    <path
                                        d="M13.9396 0.179993H4.0612C2.11275 0.179993 0.533203 1.75953 0.533203 3.70799V14.292C0.533203 16.2404 2.11275 17.82 4.0612 17.82H11.8228C12.366 17.82 12.7055 17.232 12.4339 16.7616C12.3078 16.5433 12.0749 16.4088 11.8228 16.4088H4.0612C2.89217 16.4087 1.9444 15.461 1.9444 14.292V13.5864H13.9396C15.888 13.5863 17.4676 12.0068 17.4676 10.0584V3.70799C17.4676 1.75953 15.8881 0.179993 13.9396 0.179993ZM16.0564 10.0584C16.0564 11.2275 15.1087 12.1752 13.9396 12.1752H1.9444V3.70799C1.9444 2.53891 2.89212 1.59119 4.0612 1.59119H13.9396C15.1087 1.59119 16.0564 2.53891 16.0564 3.70799V10.0584ZM13.9396 6.53039V9.35279C13.9396 9.89596 13.3516 10.2354 12.8812 9.96386C12.6629 9.83782 12.5284 9.60488 12.5284 9.35279V6.53039C12.5284 5.44405 11.3524 4.76509 10.4116 5.30826C9.97498 5.56035 9.706 6.02622 9.706 6.53039V9.35279C9.706 9.89596 9.118 10.2354 8.6476 9.96386C8.42929 9.83782 8.2948 9.60488 8.2948 9.35279V6.53039C8.2948 5.44405 7.1188 4.76509 6.178 5.30826C5.74138 5.56035 5.4724 6.02622 5.4724 6.53039V9.35279C5.4724 9.89596 4.8844 10.2354 4.414 9.96386C4.19569 9.83782 4.0612 9.60488 4.0612 9.35279V6.53039C4.06365 4.35771 6.41717 3.00243 8.29755 4.09089C8.56139 4.24361 8.79875 4.43808 9.0004 4.66672C10.4375 3.03721 13.0997 3.57446 13.7923 5.63378C13.8895 5.92274 13.9393 6.22553 13.9396 6.53039Z"
                                        class="fill-current" />
                                </svg>


                                <div
                                    class="pointer-events-none absolute inset-y-0 hidden items-center gap-3 md:flex left-[calc(100%+theme(spacing.3))] flex-row-reverse">
                                    <div
                                        class="font-roboto-mono text-sm whitespace-nowrap text-stone-500 opacity-0 transition delay-20 duration-300 will-change-transform group-hover:translate-x-0 group-hover:opacity-100 -translate-x-1">
                                        Mastodon
                                    </div>
                                    <div
                                        class="h-px w-10 scale-x-0 bg-bone-300/80 transition duration-300 will-change-transform group-hover:scale-x-100 origin-left">
                                    </div>
                                </div>
                            </a>
                        </nav>
                    </div>


                    <div class="flex flex-wrap gap-x-20 gap-y-5 pr-8 sm:gap-x-30">

                        <div data-animate="enter-from-left-staggered" class="flex flex-col items-start gap-1.5">
                            <strong>Explore</strong>
                            <div class="group/footer-links flex flex-col items-start">
                                <div
                                    class="transition duration-300 group-has-hover/footer-links:opacity-50 hover:opacity-100!">
                                    <a x-data href="https://filamentphp.com"
                                        class="relative block py-1.5 transition duration-300 ease-out hover:text-stone-800 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset"
                                        x-init="() => {
                                            const label = $refs['footer-link-label']
                                            const polygon = $refs['footer-link-polygon']
                                        
                                            gsap.set(polygon, { opacity: 0, x: -8, y: -5, rotation: -90, scale: 0.5 })
                                        
                                            motion.hover($el, () => {
                                                gsap.to(label, {
                                                    x: 15,
                                                    duration: 0.85,
                                                    ease: 'elastic.out(1,0.5)',
                                                    overwrite: true,
                                                })
                                                gsap.to(polygon, {
                                                    x: 0,
                                                    y: 0,
                                                    rotation: 0,
                                                    scale: 1,
                                                    opacity: 1,
                                                    duration: 0.85,
                                                    ease: 'elastic.out(1,0.5)',
                                                    overwrite: true,
                                                })
                                        
                                                return () => {
                                                    gsap.to(label, {
                                                        x: 0,
                                                        duration: 0.85,
                                                        ease: 'elastic.out(1,0.5)',
                                                        overwrite: true,
                                                    })
                                                    gsap.to(polygon, {
                                                        x: -8,
                                                        y: -5,
                                                        rotation: -90,
                                                        scale: 0.5,
                                                        opacity: 0,
                                                        duration: 0.85,
                                                        ease: 'elastic.out(1,0.5)',
                                                        overwrite: true,
                                                    })
                                                }
                                            })
                                        }">
                                        <div class="absolute top-1/2 left-0 -translate-y-1/2">
                                            <svg class="size-2 text-honey-200" x-ref="footer-link-polygon"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 8"
                                                fill="none">
                                                <path d="M4 0L8 4L4 8L0 4L4 0Z" class="fill-current" />
                                            </svg>
                                        </div>

                                        <div x-ref="footer-link-label">
                                            Home
                                        </div>
                                    </a>
                                </div>
                                <div
                                    class="transition duration-300 group-has-hover/footer-links:opacity-50 hover:opacity-100!">
                                    <a x-data href="/docs" target="_blank" rel="noopener"
                                        class="relative block py-1.5 transition duration-300 ease-out hover:text-stone-800 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset"
                                        x-init="() => {
                                            const label = $refs['footer-link-label']
                                            const polygon = $refs['footer-link-polygon']
                                        
                                            gsap.set(polygon, { opacity: 0, x: -8, y: -5, rotation: -90, scale: 0.5 })
                                        
                                            motion.hover($el, () => {
                                                gsap.to(label, {
                                                    x: 15,
                                                    duration: 0.85,
                                                    ease: 'elastic.out(1,0.5)',
                                                    overwrite: true,
                                                })
                                                gsap.to(polygon, {
                                                    x: 0,
                                                    y: 0,
                                                    rotation: 0,
                                                    scale: 1,
                                                    opacity: 1,
                                                    duration: 0.85,
                                                    ease: 'elastic.out(1,0.5)',
                                                    overwrite: true,
                                                })
                                        
                                                return () => {
                                                    gsap.to(label, {
                                                        x: 0,
                                                        duration: 0.85,
                                                        ease: 'elastic.out(1,0.5)',
                                                        overwrite: true,
                                                    })
                                                    gsap.to(polygon, {
                                                        x: -8,
                                                        y: -5,
                                                        rotation: -90,
                                                        scale: 0.5,
                                                        opacity: 0,
                                                        duration: 0.85,
                                                        ease: 'elastic.out(1,0.5)',
                                                        overwrite: true,
                                                    })
                                                }
                                            })
                                        }">
                                        <div class="absolute top-1/2 left-0 -translate-y-1/2">
                                            <svg class="size-2 text-honey-200" x-ref="footer-link-polygon"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 8"
                                                fill="none">
                                                <path d="M4 0L8 4L4 8L0 4L4 0Z" class="fill-current" />
                                            </svg>
                                        </div>

                                        <div x-ref="footer-link-label">
                                            Documentation
                                            <span class="sr-only">(opens in a new tab)</span>
                                        </div>
                                    </a>
                                </div>
                                <div
                                    class="transition duration-300 group-has-hover/footer-links:opacity-50 hover:opacity-100!">
                                    <a x-data href="https://filamentphp.com/build-a-laravel-admin-panel"
                                        class="relative block py-1.5 transition duration-300 ease-out hover:text-stone-800 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset"
                                        x-init="() => {
                                            const label = $refs['footer-link-label']
                                            const polygon = $refs['footer-link-polygon']
                                        
                                            gsap.set(polygon, { opacity: 0, x: -8, y: -5, rotation: -90, scale: 0.5 })
                                        
                                            motion.hover($el, () => {
                                                gsap.to(label, {
                                                    x: 15,
                                                    duration: 0.85,
                                                    ease: 'elastic.out(1,0.5)',
                                                    overwrite: true,
                                                })
                                                gsap.to(polygon, {
                                                    x: 0,
                                                    y: 0,
                                                    rotation: 0,
                                                    scale: 1,
                                                    opacity: 1,
                                                    duration: 0.85,
                                                    ease: 'elastic.out(1,0.5)',
                                                    overwrite: true,
                                                })
                                        
                                                return () => {
                                                    gsap.to(label, {
                                                        x: 0,
                                                        duration: 0.85,
                                                        ease: 'elastic.out(1,0.5)',
                                                        overwrite: true,
                                                    })
                                                    gsap.to(polygon, {
                                                        x: -8,
                                                        y: -5,
                                                        rotation: -90,
                                                        scale: 0.5,
                                                        opacity: 0,
                                                        duration: 0.85,
                                                        ease: 'elastic.out(1,0.5)',
                                                        overwrite: true,
                                                    })
                                                }
                                            })
                                        }">
                                        <div class="absolute top-1/2 left-0 -translate-y-1/2">
                                            <svg class="size-2 text-honey-200" x-ref="footer-link-polygon"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 8"
                                                fill="none">
                                                <path d="M4 0L8 4L4 8L0 4L4 0Z" class="fill-current" />
                                            </svg>
                                        </div>

                                        <div x-ref="footer-link-label">
                                            Build an admin panel
                                        </div>
                                    </a>
                                </div>
                                <div
                                    class="transition duration-300 group-has-hover/footer-links:opacity-50 hover:opacity-100!">
                                    <a x-data href="https://filamentphp.com/custom-dashboards-plugin"
                                        class="relative block py-1.5 transition duration-300 ease-out hover:text-stone-800 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset"
                                        x-init="() => {
                                            const label = $refs['footer-link-label']
                                            const polygon = $refs['footer-link-polygon']
                                        
                                            gsap.set(polygon, { opacity: 0, x: -8, y: -5, rotation: -90, scale: 0.5 })
                                        
                                            motion.hover($el, () => {
                                                gsap.to(label, {
                                                    x: 15,
                                                    duration: 0.85,
                                                    ease: 'elastic.out(1,0.5)',
                                                    overwrite: true,
                                                })
                                                gsap.to(polygon, {
                                                    x: 0,
                                                    y: 0,
                                                    rotation: 0,
                                                    scale: 1,
                                                    opacity: 1,
                                                    duration: 0.85,
                                                    ease: 'elastic.out(1,0.5)',
                                                    overwrite: true,
                                                })
                                        
                                                return () => {
                                                    gsap.to(label, {
                                                        x: 0,
                                                        duration: 0.85,
                                                        ease: 'elastic.out(1,0.5)',
                                                        overwrite: true,
                                                    })
                                                    gsap.to(polygon, {
                                                        x: -8,
                                                        y: -5,
                                                        rotation: -90,
                                                        scale: 0.5,
                                                        opacity: 0,
                                                        duration: 0.85,
                                                        ease: 'elastic.out(1,0.5)',
                                                        overwrite: true,
                                                    })
                                                }
                                            })
                                        }">
                                        <div class="absolute top-1/2 left-0 -translate-y-1/2">
                                            <svg class="size-2 text-honey-200" x-ref="footer-link-polygon"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 8"
                                                fill="none">
                                                <path d="M4 0L8 4L4 8L0 4L4 0Z" class="fill-current" />
                                            </svg>
                                        </div>

                                        <div x-ref="footer-link-label">
                                            Custom Dashboards Plugin
                                        </div>
                                    </a>
                                </div>
                                <div
                                    class="transition duration-300 group-has-hover/footer-links:opacity-50 hover:opacity-100!">
                                    <a x-data href="https://shop.filamentphp.com" target="_blank" rel="noopener"
                                        class="relative block py-1.5 transition duration-300 ease-out hover:text-stone-800 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset"
                                        x-init="() => {
                                            const label = $refs['footer-link-label']
                                            const polygon = $refs['footer-link-polygon']
                                        
                                            gsap.set(polygon, { opacity: 0, x: -8, y: -5, rotation: -90, scale: 0.5 })
                                        
                                            motion.hover($el, () => {
                                                gsap.to(label, {
                                                    x: 15,
                                                    duration: 0.85,
                                                    ease: 'elastic.out(1,0.5)',
                                                    overwrite: true,
                                                })
                                                gsap.to(polygon, {
                                                    x: 0,
                                                    y: 0,
                                                    rotation: 0,
                                                    scale: 1,
                                                    opacity: 1,
                                                    duration: 0.85,
                                                    ease: 'elastic.out(1,0.5)',
                                                    overwrite: true,
                                                })
                                        
                                                return () => {
                                                    gsap.to(label, {
                                                        x: 0,
                                                        duration: 0.85,
                                                        ease: 'elastic.out(1,0.5)',
                                                        overwrite: true,
                                                    })
                                                    gsap.to(polygon, {
                                                        x: -8,
                                                        y: -5,
                                                        rotation: -90,
                                                        scale: 0.5,
                                                        opacity: 0,
                                                        duration: 0.85,
                                                        ease: 'elastic.out(1,0.5)',
                                                        overwrite: true,
                                                    })
                                                }
                                            })
                                        }">
                                        <div class="absolute top-1/2 left-0 -translate-y-1/2">
                                            <svg class="size-2 text-honey-200" x-ref="footer-link-polygon"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 8"
                                                fill="none">
                                                <path d="M4 0L8 4L4 8L0 4L4 0Z" class="fill-current" />
                                            </svg>
                                        </div>

                                        <div x-ref="footer-link-label">
                                            Shop
                                            <span class="sr-only">(opens in a new tab)</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>


                        <div data-animate="enter-from-left-staggered" class="flex flex-col items-start gap-1.5">
                            <strong>Community</strong>
                            <div class="group/footer-links flex flex-col items-start">
                                <div
                                    class="transition duration-300 group-has-hover/footer-links:opacity-50 hover:opacity-100!">
                                    <a x-data href="https://filamentphp.com/plugins"
                                        class="relative block py-1.5 transition duration-300 ease-out hover:text-stone-800 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset"
                                        x-init="() => {
                                            const label = $refs['footer-link-label']
                                            const polygon = $refs['footer-link-polygon']
                                        
                                            gsap.set(polygon, { opacity: 0, x: -8, y: -5, rotation: -90, scale: 0.5 })
                                        
                                            motion.hover($el, () => {
                                                gsap.to(label, {
                                                    x: 15,
                                                    duration: 0.85,
                                                    ease: 'elastic.out(1,0.5)',
                                                    overwrite: true,
                                                })
                                                gsap.to(polygon, {
                                                    x: 0,
                                                    y: 0,
                                                    rotation: 0,
                                                    scale: 1,
                                                    opacity: 1,
                                                    duration: 0.85,
                                                    ease: 'elastic.out(1,0.5)',
                                                    overwrite: true,
                                                })
                                        
                                                return () => {
                                                    gsap.to(label, {
                                                        x: 0,
                                                        duration: 0.85,
                                                        ease: 'elastic.out(1,0.5)',
                                                        overwrite: true,
                                                    })
                                                    gsap.to(polygon, {
                                                        x: -8,
                                                        y: -5,
                                                        rotation: -90,
                                                        scale: 0.5,
                                                        opacity: 0,
                                                        duration: 0.85,
                                                        ease: 'elastic.out(1,0.5)',
                                                        overwrite: true,
                                                    })
                                                }
                                            })
                                        }">
                                        <div class="absolute top-1/2 left-0 -translate-y-1/2">
                                            <svg class="size-2 text-honey-200" x-ref="footer-link-polygon"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 8"
                                                fill="none">
                                                <path d="M4 0L8 4L4 8L0 4L4 0Z" class="fill-current" />
                                            </svg>
                                        </div>

                                        <div x-ref="footer-link-label">
                                            Plugins
                                        </div>
                                    </a>
                                </div>
                                <div
                                    class="transition duration-300 group-has-hover/footer-links:opacity-50 hover:opacity-100!">
                                    <a x-data href="https://filamentphp.com/insights"
                                        class="relative block py-1.5 transition duration-300 ease-out hover:text-stone-800 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset"
                                        x-init="() => {
                                            const label = $refs['footer-link-label']
                                            const polygon = $refs['footer-link-polygon']
                                        
                                            gsap.set(polygon, { opacity: 0, x: -8, y: -5, rotation: -90, scale: 0.5 })
                                        
                                            motion.hover($el, () => {
                                                gsap.to(label, {
                                                    x: 15,
                                                    duration: 0.85,
                                                    ease: 'elastic.out(1,0.5)',
                                                    overwrite: true,
                                                })
                                                gsap.to(polygon, {
                                                    x: 0,
                                                    y: 0,
                                                    rotation: 0,
                                                    scale: 1,
                                                    opacity: 1,
                                                    duration: 0.85,
                                                    ease: 'elastic.out(1,0.5)',
                                                    overwrite: true,
                                                })
                                        
                                                return () => {
                                                    gsap.to(label, {
                                                        x: 0,
                                                        duration: 0.85,
                                                        ease: 'elastic.out(1,0.5)',
                                                        overwrite: true,
                                                    })
                                                    gsap.to(polygon, {
                                                        x: -8,
                                                        y: -5,
                                                        rotation: -90,
                                                        scale: 0.5,
                                                        opacity: 0,
                                                        duration: 0.85,
                                                        ease: 'elastic.out(1,0.5)',
                                                        overwrite: true,
                                                    })
                                                }
                                            })
                                        }">
                                        <div class="absolute top-1/2 left-0 -translate-y-1/2">
                                            <svg class="size-2 text-honey-200" x-ref="footer-link-polygon"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 8"
                                                fill="none">
                                                <path d="M4 0L8 4L4 8L0 4L4 0Z" class="fill-current" />
                                            </svg>
                                        </div>

                                        <div x-ref="footer-link-label">
                                            Insights
                                        </div>
                                    </a>
                                </div>
                                <div
                                    class="transition duration-300 group-has-hover/footer-links:opacity-50 hover:opacity-100!">
                                    <a x-data href="https://filamentphp.com/team"
                                        class="relative block py-1.5 transition duration-300 ease-out hover:text-stone-800 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset"
                                        x-init="() => {
                                            const label = $refs['footer-link-label']
                                            const polygon = $refs['footer-link-polygon']
                                        
                                            gsap.set(polygon, { opacity: 0, x: -8, y: -5, rotation: -90, scale: 0.5 })
                                        
                                            motion.hover($el, () => {
                                                gsap.to(label, {
                                                    x: 15,
                                                    duration: 0.85,
                                                    ease: 'elastic.out(1,0.5)',
                                                    overwrite: true,
                                                })
                                                gsap.to(polygon, {
                                                    x: 0,
                                                    y: 0,
                                                    rotation: 0,
                                                    scale: 1,
                                                    opacity: 1,
                                                    duration: 0.85,
                                                    ease: 'elastic.out(1,0.5)',
                                                    overwrite: true,
                                                })
                                        
                                                return () => {
                                                    gsap.to(label, {
                                                        x: 0,
                                                        duration: 0.85,
                                                        ease: 'elastic.out(1,0.5)',
                                                        overwrite: true,
                                                    })
                                                    gsap.to(polygon, {
                                                        x: -8,
                                                        y: -5,
                                                        rotation: -90,
                                                        scale: 0.5,
                                                        opacity: 0,
                                                        duration: 0.85,
                                                        ease: 'elastic.out(1,0.5)',
                                                        overwrite: true,
                                                    })
                                                }
                                            })
                                        }">
                                        <div class="absolute top-1/2 left-0 -translate-y-1/2">
                                            <svg class="size-2 text-honey-200" x-ref="footer-link-polygon"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 8"
                                                fill="none">
                                                <path d="M4 0L8 4L4 8L0 4L4 0Z" class="fill-current" />
                                            </svg>
                                        </div>

                                        <div x-ref="footer-link-label">
                                            Team
                                        </div>
                                    </a>
                                </div>
                                <div
                                    class="transition duration-300 group-has-hover/footer-links:opacity-50 hover:opacity-100!">
                                    <a x-data href="https://filamentphp.com/wall-of-love"
                                        class="relative block py-1.5 transition duration-300 ease-out hover:text-stone-800 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset"
                                        x-init="() => {
                                            const label = $refs['footer-link-label']
                                            const polygon = $refs['footer-link-polygon']
                                        
                                            gsap.set(polygon, { opacity: 0, x: -8, y: -5, rotation: -90, scale: 0.5 })
                                        
                                            motion.hover($el, () => {
                                                gsap.to(label, {
                                                    x: 15,
                                                    duration: 0.85,
                                                    ease: 'elastic.out(1,0.5)',
                                                    overwrite: true,
                                                })
                                                gsap.to(polygon, {
                                                    x: 0,
                                                    y: 0,
                                                    rotation: 0,
                                                    scale: 1,
                                                    opacity: 1,
                                                    duration: 0.85,
                                                    ease: 'elastic.out(1,0.5)',
                                                    overwrite: true,
                                                })
                                        
                                                return () => {
                                                    gsap.to(label, {
                                                        x: 0,
                                                        duration: 0.85,
                                                        ease: 'elastic.out(1,0.5)',
                                                        overwrite: true,
                                                    })
                                                    gsap.to(polygon, {
                                                        x: -8,
                                                        y: -5,
                                                        rotation: -90,
                                                        scale: 0.5,
                                                        opacity: 0,
                                                        duration: 0.85,
                                                        ease: 'elastic.out(1,0.5)',
                                                        overwrite: true,
                                                    })
                                                }
                                            })
                                        }">
                                        <div class="absolute top-1/2 left-0 -translate-y-1/2">
                                            <svg class="size-2 text-honey-200" x-ref="footer-link-polygon"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 8"
                                                fill="none">
                                                <path d="M4 0L8 4L4 8L0 4L4 0Z" class="fill-current" />
                                            </svg>
                                        </div>

                                        <div x-ref="footer-link-label">
                                            Wall of Love
                                        </div>
                                    </a>
                                </div>
                                <div
                                    class="transition duration-300 group-has-hover/footer-links:opacity-50 hover:opacity-100!">
                                    <a x-data href="https://filamentphp.com/media-kit"
                                        class="relative block py-1.5 transition duration-300 ease-out hover:text-stone-800 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset"
                                        x-init="() => {
                                            const label = $refs['footer-link-label']
                                            const polygon = $refs['footer-link-polygon']
                                        
                                            gsap.set(polygon, { opacity: 0, x: -8, y: -5, rotation: -90, scale: 0.5 })
                                        
                                            motion.hover($el, () => {
                                                gsap.to(label, {
                                                    x: 15,
                                                    duration: 0.85,
                                                    ease: 'elastic.out(1,0.5)',
                                                    overwrite: true,
                                                })
                                                gsap.to(polygon, {
                                                    x: 0,
                                                    y: 0,
                                                    rotation: 0,
                                                    scale: 1,
                                                    opacity: 1,
                                                    duration: 0.85,
                                                    ease: 'elastic.out(1,0.5)',
                                                    overwrite: true,
                                                })
                                        
                                                return () => {
                                                    gsap.to(label, {
                                                        x: 0,
                                                        duration: 0.85,
                                                        ease: 'elastic.out(1,0.5)',
                                                        overwrite: true,
                                                    })
                                                    gsap.to(polygon, {
                                                        x: -8,
                                                        y: -5,
                                                        rotation: -90,
                                                        scale: 0.5,
                                                        opacity: 0,
                                                        duration: 0.85,
                                                        ease: 'elastic.out(1,0.5)',
                                                        overwrite: true,
                                                    })
                                                }
                                            })
                                        }">
                                        <div class="absolute top-1/2 left-0 -translate-y-1/2">
                                            <svg class="size-2 text-honey-200" x-ref="footer-link-polygon"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 8"
                                                fill="none">
                                                <path d="M4 0L8 4L4 8L0 4L4 0Z" class="fill-current" />
                                            </svg>
                                        </div>

                                        <div x-ref="footer-link-label">
                                            Media Kit
                                        </div>
                                    </a>
                                </div>
                                <div
                                    class="transition duration-300 group-has-hover/footer-links:opacity-50 hover:opacity-100!">
                                    <a x-data href="https://github.com/sponsors/danharrin" target="_blank"
                                        rel="noopener"
                                        class="relative block py-1.5 transition duration-300 ease-out hover:text-stone-800 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset"
                                        x-init="() => {
                                            const label = $refs['footer-link-label']
                                            const polygon = $refs['footer-link-polygon']
                                        
                                            gsap.set(polygon, { opacity: 0, x: -8, y: -5, rotation: -90, scale: 0.5 })
                                        
                                            motion.hover($el, () => {
                                                gsap.to(label, {
                                                    x: 15,
                                                    duration: 0.85,
                                                    ease: 'elastic.out(1,0.5)',
                                                    overwrite: true,
                                                })
                                                gsap.to(polygon, {
                                                    x: 0,
                                                    y: 0,
                                                    rotation: 0,
                                                    scale: 1,
                                                    opacity: 1,
                                                    duration: 0.85,
                                                    ease: 'elastic.out(1,0.5)',
                                                    overwrite: true,
                                                })
                                        
                                                return () => {
                                                    gsap.to(label, {
                                                        x: 0,
                                                        duration: 0.85,
                                                        ease: 'elastic.out(1,0.5)',
                                                        overwrite: true,
                                                    })
                                                    gsap.to(polygon, {
                                                        x: -8,
                                                        y: -5,
                                                        rotation: -90,
                                                        scale: 0.5,
                                                        opacity: 0,
                                                        duration: 0.85,
                                                        ease: 'elastic.out(1,0.5)',
                                                        overwrite: true,
                                                    })
                                                }
                                            })
                                        }">
                                        <div class="absolute top-1/2 left-0 -translate-y-1/2">
                                            <svg class="size-2 text-honey-200" x-ref="footer-link-polygon"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 8"
                                                fill="none">
                                                <path d="M4 0L8 4L4 8L0 4L4 0Z" class="fill-current" />
                                            </svg>
                                        </div>

                                        <div x-ref="footer-link-label">
                                            Sponsor
                                            <span class="sr-only">(opens in a new tab)</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>


                        <div data-animate="enter-from-left-staggered" class="flex flex-col items-start gap-1.5">
                            <strong>Support</strong>
                            <div class="group/footer-links flex flex-col items-start">
                                <div
                                    class="transition duration-300 group-has-hover/footer-links:opacity-50 hover:opacity-100!">
                                    <a x-data href="/docs/introduction/help" target="_blank" rel="noopener"
                                        class="relative block py-1.5 transition duration-300 ease-out hover:text-stone-800 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset"
                                        x-init="() => {
                                            const label = $refs['footer-link-label']
                                            const polygon = $refs['footer-link-polygon']
                                        
                                            gsap.set(polygon, { opacity: 0, x: -8, y: -5, rotation: -90, scale: 0.5 })
                                        
                                            motion.hover($el, () => {
                                                gsap.to(label, {
                                                    x: 15,
                                                    duration: 0.85,
                                                    ease: 'elastic.out(1,0.5)',
                                                    overwrite: true,
                                                })
                                                gsap.to(polygon, {
                                                    x: 0,
                                                    y: 0,
                                                    rotation: 0,
                                                    scale: 1,
                                                    opacity: 1,
                                                    duration: 0.85,
                                                    ease: 'elastic.out(1,0.5)',
                                                    overwrite: true,
                                                })
                                        
                                                return () => {
                                                    gsap.to(label, {
                                                        x: 0,
                                                        duration: 0.85,
                                                        ease: 'elastic.out(1,0.5)',
                                                        overwrite: true,
                                                    })
                                                    gsap.to(polygon, {
                                                        x: -8,
                                                        y: -5,
                                                        rotation: -90,
                                                        scale: 0.5,
                                                        opacity: 0,
                                                        duration: 0.85,
                                                        ease: 'elastic.out(1,0.5)',
                                                        overwrite: true,
                                                    })
                                                }
                                            })
                                        }">
                                        <div class="absolute top-1/2 left-0 -translate-y-1/2">
                                            <svg class="size-2 text-honey-200" x-ref="footer-link-polygon"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 8"
                                                fill="none">
                                                <path d="M4 0L8 4L4 8L0 4L4 0Z" class="fill-current" />
                                            </svg>
                                        </div>

                                        <div x-ref="footer-link-label">
                                            Help
                                            <span class="sr-only">(opens in a new tab)</span>
                                        </div>
                                    </a>
                                </div>
                                <div
                                    class="transition duration-300 group-has-hover/footer-links:opacity-50 hover:opacity-100!">
                                    <a x-data href="https://filamentphp.com/consulting"
                                        class="relative block py-1.5 transition duration-300 ease-out hover:text-stone-800 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset"
                                        x-init="() => {
                                            const label = $refs['footer-link-label']
                                            const polygon = $refs['footer-link-polygon']
                                        
                                            gsap.set(polygon, { opacity: 0, x: -8, y: -5, rotation: -90, scale: 0.5 })
                                        
                                            motion.hover($el, () => {
                                                gsap.to(label, {
                                                    x: 15,
                                                    duration: 0.85,
                                                    ease: 'elastic.out(1,0.5)',
                                                    overwrite: true,
                                                })
                                                gsap.to(polygon, {
                                                    x: 0,
                                                    y: 0,
                                                    rotation: 0,
                                                    scale: 1,
                                                    opacity: 1,
                                                    duration: 0.85,
                                                    ease: 'elastic.out(1,0.5)',
                                                    overwrite: true,
                                                })
                                        
                                                return () => {
                                                    gsap.to(label, {
                                                        x: 0,
                                                        duration: 0.85,
                                                        ease: 'elastic.out(1,0.5)',
                                                        overwrite: true,
                                                    })
                                                    gsap.to(polygon, {
                                                        x: -8,
                                                        y: -5,
                                                        rotation: -90,
                                                        scale: 0.5,
                                                        opacity: 0,
                                                        duration: 0.85,
                                                        ease: 'elastic.out(1,0.5)',
                                                        overwrite: true,
                                                    })
                                                }
                                            })
                                        }">
                                        <div class="absolute top-1/2 left-0 -translate-y-1/2">
                                            <svg class="size-2 text-honey-200" x-ref="footer-link-polygon"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 8"
                                                fill="none">
                                                <path d="M4 0L8 4L4 8L0 4L4 0Z" class="fill-current" />
                                            </svg>
                                        </div>

                                        <div x-ref="footer-link-label">
                                            Consulting
                                        </div>
                                    </a>
                                </div>
                                <div
                                    class="transition duration-300 group-has-hover/footer-links:opacity-50 hover:opacity-100!">
                                    <a x-data href="https://status.filamentphp.com" target="_blank" rel="noopener"
                                        class="relative block py-1.5 transition duration-300 ease-out hover:text-stone-800 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset"
                                        x-init="() => {
                                            const label = $refs['footer-link-label']
                                            const polygon = $refs['footer-link-polygon']
                                        
                                            gsap.set(polygon, { opacity: 0, x: -8, y: -5, rotation: -90, scale: 0.5 })
                                        
                                            motion.hover($el, () => {
                                                gsap.to(label, {
                                                    x: 15,
                                                    duration: 0.85,
                                                    ease: 'elastic.out(1,0.5)',
                                                    overwrite: true,
                                                })
                                                gsap.to(polygon, {
                                                    x: 0,
                                                    y: 0,
                                                    rotation: 0,
                                                    scale: 1,
                                                    opacity: 1,
                                                    duration: 0.85,
                                                    ease: 'elastic.out(1,0.5)',
                                                    overwrite: true,
                                                })
                                        
                                                return () => {
                                                    gsap.to(label, {
                                                        x: 0,
                                                        duration: 0.85,
                                                        ease: 'elastic.out(1,0.5)',
                                                        overwrite: true,
                                                    })
                                                    gsap.to(polygon, {
                                                        x: -8,
                                                        y: -5,
                                                        rotation: -90,
                                                        scale: 0.5,
                                                        opacity: 0,
                                                        duration: 0.85,
                                                        ease: 'elastic.out(1,0.5)',
                                                        overwrite: true,
                                                    })
                                                }
                                            })
                                        }">
                                        <div class="absolute top-1/2 left-0 -translate-y-1/2">
                                            <svg class="size-2 text-honey-200" x-ref="footer-link-polygon"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 8"
                                                fill="none">
                                                <path d="M4 0L8 4L4 8L0 4L4 0Z" class="fill-current" />
                                            </svg>
                                        </div>

                                        <div x-ref="footer-link-label">
                                            Status
                                            <span class="sr-only">(opens in a new tab)</span>
                                        </div>
                                    </a>
                                </div>
                            </div>


                            <strong class="mt-4">Legal</strong>
                            <div class="group/footer-links flex flex-col items-start">
                                <div
                                    class="transition duration-300 group-has-hover/footer-links:opacity-50 hover:opacity-100!">
                                    <a x-data href="https://filamentphp.com/legal/terms-of-service"
                                        class="relative block py-1.5 transition duration-300 ease-out hover:text-stone-800 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset"
                                        x-init="() => {
                                            const label = $refs['footer-link-label']
                                            const polygon = $refs['footer-link-polygon']
                                        
                                            gsap.set(polygon, { opacity: 0, x: -8, y: -5, rotation: -90, scale: 0.5 })
                                        
                                            motion.hover($el, () => {
                                                gsap.to(label, {
                                                    x: 15,
                                                    duration: 0.85,
                                                    ease: 'elastic.out(1,0.5)',
                                                    overwrite: true,
                                                })
                                                gsap.to(polygon, {
                                                    x: 0,
                                                    y: 0,
                                                    rotation: 0,
                                                    scale: 1,
                                                    opacity: 1,
                                                    duration: 0.85,
                                                    ease: 'elastic.out(1,0.5)',
                                                    overwrite: true,
                                                })
                                        
                                                return () => {
                                                    gsap.to(label, {
                                                        x: 0,
                                                        duration: 0.85,
                                                        ease: 'elastic.out(1,0.5)',
                                                        overwrite: true,
                                                    })
                                                    gsap.to(polygon, {
                                                        x: -8,
                                                        y: -5,
                                                        rotation: -90,
                                                        scale: 0.5,
                                                        opacity: 0,
                                                        duration: 0.85,
                                                        ease: 'elastic.out(1,0.5)',
                                                        overwrite: true,
                                                    })
                                                }
                                            })
                                        }">
                                        <div class="absolute top-1/2 left-0 -translate-y-1/2">
                                            <svg class="size-2 text-honey-200" x-ref="footer-link-polygon"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 8"
                                                fill="none">
                                                <path d="M4 0L8 4L4 8L0 4L4 0Z" class="fill-current" />
                                            </svg>
                                        </div>

                                        <div x-ref="footer-link-label">
                                            Terms of Service
                                        </div>
                                    </a>
                                </div>
                                <div
                                    class="transition duration-300 group-has-hover/footer-links:opacity-50 hover:opacity-100!">
                                    <a x-data href="https://filamentphp.com/legal/privacy-policy"
                                        class="relative block py-1.5 transition duration-300 ease-out hover:text-stone-800 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset"
                                        x-init="() => {
                                            const label = $refs['footer-link-label']
                                            const polygon = $refs['footer-link-polygon']
                                        
                                            gsap.set(polygon, { opacity: 0, x: -8, y: -5, rotation: -90, scale: 0.5 })
                                        
                                            motion.hover($el, () => {
                                                gsap.to(label, {
                                                    x: 15,
                                                    duration: 0.85,
                                                    ease: 'elastic.out(1,0.5)',
                                                    overwrite: true,
                                                })
                                                gsap.to(polygon, {
                                                    x: 0,
                                                    y: 0,
                                                    rotation: 0,
                                                    scale: 1,
                                                    opacity: 1,
                                                    duration: 0.85,
                                                    ease: 'elastic.out(1,0.5)',
                                                    overwrite: true,
                                                })
                                        
                                                return () => {
                                                    gsap.to(label, {
                                                        x: 0,
                                                        duration: 0.85,
                                                        ease: 'elastic.out(1,0.5)',
                                                        overwrite: true,
                                                    })
                                                    gsap.to(polygon, {
                                                        x: -8,
                                                        y: -5,
                                                        rotation: -90,
                                                        scale: 0.5,
                                                        opacity: 0,
                                                        duration: 0.85,
                                                        ease: 'elastic.out(1,0.5)',
                                                        overwrite: true,
                                                    })
                                                }
                                            })
                                        }">
                                        <div class="absolute top-1/2 left-0 -translate-y-1/2">
                                            <svg class="size-2 text-honey-200" x-ref="footer-link-polygon"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 8"
                                                fill="none">
                                                <path d="M4 0L8 4L4 8L0 4L4 0Z" class="fill-current" />
                                            </svg>
                                        </div>

                                        <div x-ref="footer-link-label">
                                            Privacy Policy
                                        </div>
                                    </a>
                                </div>
                                <div
                                    class="transition duration-300 group-has-hover/footer-links:opacity-50 hover:opacity-100!">
                                    <a x-data href="https://filamentphp.com/legal/trademark-policy"
                                        class="relative block py-1.5 transition duration-300 ease-out hover:text-stone-800 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset"
                                        x-init="() => {
                                            const label = $refs['footer-link-label']
                                            const polygon = $refs['footer-link-polygon']
                                        
                                            gsap.set(polygon, { opacity: 0, x: -8, y: -5, rotation: -90, scale: 0.5 })
                                        
                                            motion.hover($el, () => {
                                                gsap.to(label, {
                                                    x: 15,
                                                    duration: 0.85,
                                                    ease: 'elastic.out(1,0.5)',
                                                    overwrite: true,
                                                })
                                                gsap.to(polygon, {
                                                    x: 0,
                                                    y: 0,
                                                    rotation: 0,
                                                    scale: 1,
                                                    opacity: 1,
                                                    duration: 0.85,
                                                    ease: 'elastic.out(1,0.5)',
                                                    overwrite: true,
                                                })
                                        
                                                return () => {
                                                    gsap.to(label, {
                                                        x: 0,
                                                        duration: 0.85,
                                                        ease: 'elastic.out(1,0.5)',
                                                        overwrite: true,
                                                    })
                                                    gsap.to(polygon, {
                                                        x: -8,
                                                        y: -5,
                                                        rotation: -90,
                                                        scale: 0.5,
                                                        opacity: 0,
                                                        duration: 0.85,
                                                        ease: 'elastic.out(1,0.5)',
                                                        overwrite: true,
                                                    })
                                                }
                                            })
                                        }">
                                        <div class="absolute top-1/2 left-0 -translate-y-1/2">
                                            <svg class="size-2 text-honey-200" x-ref="footer-link-polygon"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 8"
                                                fill="none">
                                                <path d="M4 0L8 4L4 8L0 4L4 0Z" class="fill-current" />
                                            </svg>
                                        </div>

                                        <div x-ref="footer-link-label">
                                            Trademark Policy
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div data-animate="enter-from-top-staggered"
                    class="mt-5 flex flex-wrap items-center justify-center gap-5">
                    <div>
                        <a x-data x-init="() => {
                            const card = $el
                            const sponsorImage = $refs.sponsorImage
                            const sponsorTier = $refs.sponsorTier
                        
                            gsap.set(sponsorTier, { opacity: 0, y: -10, x: -5 })
                        
                            const tl = gsap.timeline({ paused: true })
                        
                            // Feature image scales down slightly
                            tl.to(
                                sponsorImage, {
                                    scale: 0.9,
                                    rotation: 0.01,
                                    duration: 0.3,
                                    ease: 'sine.out',
                                },
                                0,
                            )
                        
                            // Sponsor tier fades in and slides down
                            tl.to(
                                sponsorTier, {
                                    opacity: 1,
                                    y: 0,
                                    x: 0,
                                    duration: 0.3,
                                    ease: 'sine.out',
                                },
                                0.1,
                            )
                        
                            motion.hover(card, () => {
                                tl.tweenTo(tl.duration())
                        
                                return () => {
                                    tl.tweenTo(0)
                                }
                            })
                        }"
                            href="https://kirschbaumdevelopment.com/solutions/filament-development" target="_blank"
                            rel="noopener noreferrer" aria-label="Visit Kirschbaum (opens in new window)"
                            class="relative inline-grid place-items-center overflow-hidden bg-cream-100 transition duration-300 ease-out hover:bg-cream-50 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset h-15 w-35 p-4">

                            <div x-ref="sponsorTier"
                                class="absolute top-0 left-0 z-2 bg-stone-800 px-2 pt-px pb-0.5 font-roboto-mono text-xs text-stone-100 hidden"
                                data-corner-cut="sm" aria-hidden="true">
                                Agency Partner
                            </div>


                            <img x-ref="sponsorImage"
                                src="https://fls-a148a526-7ce4-465e-b283-9b405912858a.laravel.cloud/019c953a-0c78-7283-b894-3af9e1e2fa72/kirschbaum.svg"
                                alt="Kirschbaum" loading="lazy" width="auto" height="auto"
                                class="relative z-1 object-contain mix-blend-luminosity max-h-7" />


                            <div
                                class="bg-line-pattern absolute inset-0 z-0 h-full w-full mask-y-from-70% mask-x-from-70% bg-repeat opacity-80">
                            </div>
                        </a>
                    </div>
                    <div>
                        <a x-data x-init="() => {
                            const card = $el
                            const sponsorImage = $refs.sponsorImage
                            const sponsorTier = $refs.sponsorTier
                        
                            gsap.set(sponsorTier, { opacity: 0, y: -10, x: -5 })
                        
                            const tl = gsap.timeline({ paused: true })
                        
                            // Feature image scales down slightly
                            tl.to(
                                sponsorImage, {
                                    scale: 0.9,
                                    rotation: 0.01,
                                    duration: 0.3,
                                    ease: 'sine.out',
                                },
                                0,
                            )
                        
                            // Sponsor tier fades in and slides down
                            tl.to(
                                sponsorTier, {
                                    opacity: 1,
                                    y: 0,
                                    x: 0,
                                    duration: 0.3,
                                    ease: 'sine.out',
                                },
                                0.1,
                            )
                        
                            motion.hover(card, () => {
                                tl.tweenTo(tl.duration())
                        
                                return () => {
                                    tl.tweenTo(0)
                                }
                            })
                        }"
                            href="https://www.agiledrop.com/laravel?utm_source=filament" target="_blank"
                            rel="noopener noreferrer" aria-label="Visit Agiledrop (opens in new window)"
                            class="relative inline-grid place-items-center overflow-hidden bg-cream-100 transition duration-300 ease-out hover:bg-cream-50 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset h-15 w-35 p-4">

                            <div x-ref="sponsorTier"
                                class="absolute top-0 left-0 z-2 bg-stone-800 px-2 pt-px pb-0.5 font-roboto-mono text-xs text-stone-100 hidden"
                                data-corner-cut="sm" aria-hidden="true">
                                Gold sponsor
                            </div>


                            <img x-ref="sponsorImage"
                                src="https://fls-a148a526-7ce4-465e-b283-9b405912858a.laravel.cloud/019c953a-0d2c-738d-9bb5-594888161dd8/agiledrop.svg"
                                alt="Agiledrop" loading="lazy" width="auto" height="auto"
                                class="relative z-1 object-contain mix-blend-luminosity max-h-7" />


                            <div
                                class="bg-line-pattern absolute inset-0 z-0 h-full w-full mask-y-from-70% mask-x-from-70% bg-repeat opacity-80">
                            </div>
                        </a>
                    </div>
                    <div>
                        <a x-data x-init="() => {
                            const card = $el
                            const sponsorImage = $refs.sponsorImage
                            const sponsorTier = $refs.sponsorTier
                        
                            gsap.set(sponsorTier, { opacity: 0, y: -10, x: -5 })
                        
                            const tl = gsap.timeline({ paused: true })
                        
                            // Feature image scales down slightly
                            tl.to(
                                sponsorImage, {
                                    scale: 0.9,
                                    rotation: 0.01,
                                    duration: 0.3,
                                    ease: 'sine.out',
                                },
                                0,
                            )
                        
                            // Sponsor tier fades in and slides down
                            tl.to(
                                sponsorTier, {
                                    opacity: 1,
                                    y: 0,
                                    x: 0,
                                    duration: 0.3,
                                    ease: 'sine.out',
                                },
                                0.1,
                            )
                        
                            motion.hover(card, () => {
                                tl.tweenTo(tl.duration())
                        
                                return () => {
                                    tl.tweenTo(0)
                                }
                            })
                        }" href="https://serpapi.com/?utm_source=filamentphp"
                            target="_blank" rel="noopener noreferrer"
                            aria-label="Visit SerpApi (opens in new window)"
                            class="relative inline-grid place-items-center overflow-hidden bg-cream-100 transition duration-300 ease-out hover:bg-cream-50 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset h-15 w-35 p-4">

                            <div x-ref="sponsorTier"
                                class="absolute top-0 left-0 z-2 bg-stone-800 px-2 pt-px pb-0.5 font-roboto-mono text-xs text-stone-100 hidden"
                                data-corner-cut="sm" aria-hidden="true">
                                Gold sponsor
                            </div>


                            <img x-ref="sponsorImage"
                                src="https://fls-a148a526-7ce4-465e-b283-9b405912858a.laravel.cloud/019c953a-0eac-705c-8def-601fa4a28164/serpapi.svg"
                                alt="SerpApi" loading="lazy" width="auto" height="auto"
                                class="relative z-1 object-contain mix-blend-luminosity max-h-7" />


                            <div
                                class="bg-line-pattern absolute inset-0 z-0 h-full w-full mask-y-from-70% mask-x-from-70% bg-repeat opacity-80">
                            </div>
                        </a>
                    </div>
                    <div>
                        <a x-data x-init="() => {
                            const card = $el
                            const sponsorImage = $refs.sponsorImage
                            const sponsorTier = $refs.sponsorTier
                        
                            gsap.set(sponsorTier, { opacity: 0, y: -10, x: -5 })
                        
                            const tl = gsap.timeline({ paused: true })
                        
                            // Feature image scales down slightly
                            tl.to(
                                sponsorImage, {
                                    scale: 0.9,
                                    rotation: 0.01,
                                    duration: 0.3,
                                    ease: 'sine.out',
                                },
                                0,
                            )
                        
                            // Sponsor tier fades in and slides down
                            tl.to(
                                sponsorTier, {
                                    opacity: 1,
                                    y: 0,
                                    x: 0,
                                    duration: 0.3,
                                    ease: 'sine.out',
                                },
                                0.1,
                            )
                        
                            motion.hover(card, () => {
                                tl.tweenTo(tl.duration())
                        
                                return () => {
                                    tl.tweenTo(0)
                                }
                            })
                        }"
                            href="https://mailtrap.io/email-sending?utm_source=community&amp;utm_medium=referral&amp;utm_campaign=filament"
                            target="_blank" rel="noopener noreferrer"
                            aria-label="Visit Mailtrap (opens in new window)"
                            class="relative inline-grid place-items-center overflow-hidden bg-cream-100 transition duration-300 ease-out hover:bg-cream-50 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset h-15 w-35 p-4">

                            <div x-ref="sponsorTier"
                                class="absolute top-0 left-0 z-2 bg-stone-800 px-2 pt-px pb-0.5 font-roboto-mono text-xs text-stone-100 hidden"
                                data-corner-cut="sm" aria-hidden="true">
                                Gold sponsor
                            </div>


                            <img x-ref="sponsorImage"
                                src="https://fls-a148a526-7ce4-465e-b283-9b405912858a.laravel.cloud/019c953a-0e2b-7127-9e05-8d899d66321e/mailtrap.svg"
                                alt="Mailtrap" loading="lazy" width="auto" height="auto"
                                class="relative z-1 object-contain mix-blend-luminosity max-h-7" />


                            <div
                                class="bg-line-pattern absolute inset-0 z-0 h-full w-full mask-y-from-70% mask-x-from-70% bg-repeat opacity-80">
                            </div>
                        </a>
                    </div>
                    <div>
                        <a x-data x-init="() => {
                            const card = $el
                            const sponsorImage = $refs.sponsorImage
                            const sponsorTier = $refs.sponsorTier
                        
                            gsap.set(sponsorTier, { opacity: 0, y: -10, x: -5 })
                        
                            const tl = gsap.timeline({ paused: true })
                        
                            // Feature image scales down slightly
                            tl.to(
                                sponsorImage, {
                                    scale: 0.9,
                                    rotation: 0.01,
                                    duration: 0.3,
                                    ease: 'sine.out',
                                },
                                0,
                            )
                        
                            // Sponsor tier fades in and slides down
                            tl.to(
                                sponsorTier, {
                                    opacity: 1,
                                    y: 0,
                                    x: 0,
                                    duration: 0.3,
                                    ease: 'sine.out',
                                },
                                0.1,
                            )
                        
                            motion.hover(card, () => {
                                tl.tweenTo(tl.duration())
                        
                                return () => {
                                    tl.tweenTo(0)
                                }
                            })
                        }" href="https://baiz.ai" target="_blank"
                            rel="noopener noreferrer" aria-label="Visit Baiz.ai (opens in new window)"
                            class="relative inline-grid place-items-center overflow-hidden bg-cream-100 transition duration-300 ease-out hover:bg-cream-50 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset h-15 w-35 p-4">

                            <div x-ref="sponsorTier"
                                class="absolute top-0 left-0 z-2 bg-stone-800 px-2 pt-px pb-0.5 font-roboto-mono text-xs text-stone-100 hidden"
                                data-corner-cut="sm" aria-hidden="true">
                                Gold sponsor
                            </div>


                            <img x-ref="sponsorImage"
                                src="https://fls-a148a526-7ce4-465e-b283-9b405912858a.laravel.cloud/019c953a-0dc5-739f-bcb3-25c033523707/baiz-ai.svg"
                                alt="Baiz.ai" loading="lazy" width="auto" height="auto"
                                class="relative z-1 object-contain mix-blend-luminosity max-h-7" />


                            <div
                                class="bg-line-pattern absolute inset-0 z-0 h-full w-full mask-y-from-70% mask-x-from-70% bg-repeat opacity-80">
                            </div>
                        </a>
                    </div>
                    <div>
                        <a x-data x-init="() => {
                            const card = $el
                            const sponsorImage = $refs.sponsorImage
                            const sponsorTier = $refs.sponsorTier
                        
                            gsap.set(sponsorTier, { opacity: 0, y: -10, x: -5 })
                        
                            const tl = gsap.timeline({ paused: true })
                        
                            // Feature image scales down slightly
                            tl.to(
                                sponsorImage, {
                                    scale: 0.9,
                                    rotation: 0.01,
                                    duration: 0.3,
                                    ease: 'sine.out',
                                },
                                0,
                            )
                        
                            // Sponsor tier fades in and slides down
                            tl.to(
                                sponsorTier, {
                                    opacity: 1,
                                    y: 0,
                                    x: 0,
                                    duration: 0.3,
                                    ease: 'sine.out',
                                },
                                0.1,
                            )
                        
                            motion.hover(card, () => {
                                tl.tweenTo(tl.duration())
                        
                                return () => {
                                    tl.tweenTo(0)
                                }
                            })
                        }" href="https://cmsmax.com?ref=filamentphp.com"
                            target="_blank" rel="noopener noreferrer"
                            aria-label="Visit CMS Max (opens in new window)"
                            class="relative inline-grid place-items-center overflow-hidden bg-cream-100 transition duration-300 ease-out hover:bg-cream-50 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset h-15 w-35 p-4">

                            <div x-ref="sponsorTier"
                                class="absolute top-0 left-0 z-2 bg-stone-800 px-2 pt-px pb-0.5 font-roboto-mono text-xs text-stone-100 hidden"
                                data-corner-cut="sm" aria-hidden="true">
                                Gold sponsor
                            </div>


                            <img x-ref="sponsorImage"
                                src="https://fls-a148a526-7ce4-465e-b283-9b405912858a.laravel.cloud/019c953a-0df8-73b8-bb35-5bc9517949e2/cms-max.svg"
                                alt="CMS Max" loading="lazy" width="auto" height="auto"
                                class="relative z-1 object-contain mix-blend-luminosity max-h-7" />


                            <div
                                class="bg-line-pattern absolute inset-0 z-0 h-full w-full mask-y-from-70% mask-x-from-70% bg-repeat opacity-80">
                            </div>
                        </a>
                    </div>

                    <div>
                        <a x-data href="https://github.com/sponsors/danharrin" target="_blank"
                            rel="noopener noreferrer"
                            aria-label="Sponsor Filament - your logo here (opens in new window)"
                            class="custom-dashed-border group relative inline-grid place-items-center overflow-hidden bg-minty-100/30 transition duration-300 ease-out hover:bg-bubblegum/30 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset h-15 w-35 p-4">
                            <div
                                class="relative z-1 flex items-center gap-1 transition duration-300 ease-out will-change-transform group-hover:scale-105">

                                <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14" />
                                    <path d="M12 5v14" />
                                </svg>

                                <span class="font-medium text-xs">
                                    Your logo here
                                </span>
                            </div>


                            <div
                                class="bg-line-pattern absolute inset-0 z-0 h-full w-full mask-y-from-70% mask-x-from-70% bg-repeat opacity-60">
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div
                class="flex flex-wrap items-center justify-around gap-x-5 gap-y-3 px-5 py-5 sm:justify-between md:px-8">
                <div data-animate="enter-from-left" x-data x-init="async () => {
                    await window.FilamentAnimations.waitForFonts()
                
                    const container = $el
                    const originalText = $refs.originalText
                    const warningText = $refs.warningText
                
                    const tl = gsap.timeline({ paused: true })
                
                    // Original text exits upward
                    tl.to(
                        originalText, {
                            y: -20,
                            opacity: 0,
                            duration: 0.25,
                            ease: 'circ.in',
                        },
                        0,
                    )
                
                    // Warning text enters from below
                    tl.fromTo(
                        warningText, {
                            y: 20,
                            opacity: 0,
                        }, {
                            y: 0,
                            opacity: 1,
                            duration: 0.25,
                            ease: 'circ.out',
                        },
                        0.15,
                    )
                
                    motion.hover(container, () => {
                        tl.tweenTo(tl.duration())
                
                        return () => {
                            tl.tweenTo(0)
                        }
                    })
                }"
                    class="relative grid cursor-default overflow-hidden">
                    <p x-ref="originalText" class="[grid-area:1/-1]">
                        &copy; 2026 Filament. All rights reserved.
                    </p>
                    <p x-ref="warningText" class="whitespace-nowrap [grid-area:1/-1]">
                        Copying? Our lawyers are faster than you! 😈
                    </p>
                </div>

                <p data-animate="enter-from-right" class="flex gap-1.5" role="contentinfo">
                    <span>Website designed by</span>
                    <a href="https://zahirnia.com" target="_blank" rel="external noopener noreferrer"
                        aria-label="Hassan Zahirnia website (opens in new window)"
                        class="group relative transition duration-200 focus:outline-none focus-visible:ring focus-visible:ring-black/50 focus-visible:ring-inset">
                        <span class="flex items-center gap-1 font-medium">
                            <span
                                class="text-amber-500 transition duration-300 ease-out group-hover:-translate-x-0.5 group-hover:text-bubblegum">
                                {
                            </span>
                            <span class="font-outfit text-stone-800">
                                Hassan Zahirnia
                            </span>
                            <span
                                class="text-amber-500 transition duration-300 ease-out group-hover:translate-x-0.5 group-hover:text-bubblegum">
                                }
                            </span>
                        </span>
                        <span
                            class="absolute -bottom-0.5 left-3 h-px w-[84%] origin-right scale-x-0 bg-current transition duration-300 ease-out will-change-transform group-hover:origin-left group-hover:scale-x-100"></span>
                    </a>
                </p>
            </div>
        </footer>
    </main>

    <div x-data="searchModal()" x-on:keydown.escape.window="open && closeModal()" class="relative z-101">

        <div x-show="open" x-cloak x-transition:enter="transition duration-200 ease-out"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition duration-150 ease-in" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="bg-dots-pattern fixed inset-0 bg-black/21 bg-repeat backdrop-blur-sm" aria-hidden="true"></div>


        <div x-show="open" x-cloak class="fixed inset-0 z-10 overflow-y-auto" role="dialog" aria-modal="true"
            aria-label="Search the site" x-trap.noscroll="open">
            <div class="flex min-h-full items-start justify-center px-4 pt-[15vh] pb-12" x-on:click="closeModal()">

                <div x-show="open" x-transition:enter="transition duration-200 ease-out"
                    x-transition:enter-start="translate-y-1 scale-95 opacity-0"
                    x-transition:enter-end="translate-y-0 scale-100 opacity-100"
                    x-transition:leave="transition duration-150 ease-in"
                    x-transition:leave-start="translate-y-0 scale-100 opacity-100"
                    x-transition:leave-end="translate-y-1 scale-95 opacity-0"
                    class="flex w-full max-w-2xl flex-col overflow-hidden rounded-xl border border-bone-100 bg-serenade-50 shadow-lg"
                    x-on:click.stop>

                    <div class="relative border-b border-bone-100">
                        <label for="search-input" class="sr-only">
                            Search docs, plugins and insights
                        </label>
                        <input x-ref="searchInput" x-model="query" x-on:input="search()"
                            x-on:keydown.arrow-up.prevent="navigateUp()"
                            x-on:keydown.arrow-down.prevent="navigateDown()"
                            x-on:keydown.enter.prevent="selectResult()" type="text" id="search-input"
                            class="h-12 w-full bg-transparent pr-14 pl-11 text-sm tracking-tight text-stone-800 placeholder:text-stone-400 focus:outline-none"
                            placeholder="Search docs, plugins, insights..." autocomplete="off" role="combobox"
                            aria-autocomplete="list" aria-controls="search-results"
                            :aria-expanded="results.length > 0"
                            :aria-activedescendant="results.length > 0 ? 'search-result-' + selectedIndex : null" />
                        <svg class="absolute top-1/2 left-4 size-4 -translate-y-1/2 text-stone-400"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="none">
                            <path
                                d="M15.6631 14.811L11.8927 11.0414C15.1616 7.11685 12.9562 1.12536 7.92306 0.256672C2.8899 -0.612009 -1.19622 4.29362 0.568066 9.08681C2.15179 13.3895 7.51813 14.8274 11.041 11.893L14.8107 15.6635C15.1388 15.9916 15.699 15.8414 15.8191 15.3932C15.8749 15.1852 15.8154 14.9633 15.6631 14.811ZM1.38115 6.80331C1.38115 2.6296 5.89933 0.0210223 9.51387 2.10788C13.1284 4.19474 13.1284 9.41188 9.51387 11.4987C8.68972 11.9746 7.75461 12.2251 6.80297 12.2251C3.80996 12.2218 1.38447 9.79632 1.38115 6.80331Z"
                                class="fill-current" />
                        </svg>
                        <div
                            class="absolute top-1/2 right-4 flex -translate-y-1/2 items-center justify-center rounded-xs bg-bone-100 px-1.5 py-0.5 text-xs font-medium text-stone-600">
                            ESC
                        </div>
                    </div>


                    <div x-ref="resultsList" id="search-results" class="max-h-96 scrollbar-thin overflow-y-auto"
                        role="listbox">

                        <template x-if="loading">
                            <div class="flex items-center justify-center py-12 text-stone-400">
                                <svg class="size-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                            </div>
                        </template>


                        <template x-if="error && !loading">
                            <div class="px-4 py-8 text-center text-sm text-stone-500">
                                <span x-text="error"></span>
                            </div>
                        </template>


                        <template x-if="query.length >= 2 && ! loading && ! error && results.length === 0">
                            <div class="px-4 py-8 text-center text-sm text-stone-500">
                                No results found for "
                                <span x-text="query" class="font-medium text-stone-800"></span>
                                "
                            </div>
                        </template>


                        <template x-if="query.length < 2 && ! loading">
                            <div class="px-4 py-8 text-center text-sm text-stone-500">
                                Search documentation, plugins and insights...
                            </div>
                        </template>


                        <template x-if="! loading && ! error && results.length > 0">
                            <div class="p-2">
                                <template x-for="(result, index) in results"
                                    :key="result.type + '-' + (result.path || result.url || '') + '-' + index">
                                    <div>

                                        <div x-show="isSectionStart(index)"
                                            :class="index === 0 ?
                                                'px-2 pt-1 pb-1.5 font-outfit text-sm font-medium text-stone-800' :
                                                'mt-2 border-t border-bone-100 px-2 pt-3 pb-1.5 font-outfit text-sm font-medium text-stone-800'"
                                            x-text="sectionLabel(result.type)"></div>


                                        <div :id="'search-result-' + index" role="option"
                                            :aria-selected="selectedIndex === index"
                                            :data-selected="selectedIndex === index">
                                            <a :href="getResultUrl(result)"
                                                class="group flex items-center gap-3 rounded-lg px-3 py-2.5 transition duration-150 ease-out"
                                                :class="selectedIndex === index ? 'bg-cream-100' : 'hover:bg-cream-50'"
                                                x-on:mouseenter="selectedIndex = index">

                                                <template x-if="result.type === 'plugin' && result.image">
                                                    <img :src="result.image" :alt="result.title"
                                                        class="aspect-video h-8 shrink-0 rounded-xs object-cover ring ring-bone-500/30"
                                                        loading="lazy" />
                                                </template>

                                                <template x-if="result.type === 'plugin' && ! result.image">
                                                    <div class="inline-grid aspect-video h-8 shrink-0 place-items-center rounded-xs bg-bone-100 text-stone-500"
                                                        aria-hidden="true">
                                                        <svg class="size-4" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="1.5"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <path
                                                                d="M14 4h4a2 2 0 0 1 2 2v4M10 4H6a2 2 0 0 0-2 2v4m0 4v4a2 2 0 0 0 2 2h4m4 0h4a2 2 0 0 0 2-2v-4M9 10a2 2 0 1 1 4 0v0a1 1 0 0 0 1 1h2v2a2 2 0 1 1 0 4v0a1 1 0 0 0-1 1h-2v-2a2 2 0 1 1-4 0v0a1 1 0 0 0-1-1H6v-2a2 2 0 1 1 0-4v0a1 1 0 0 0 1-1z" />
                                                        </svg>
                                                    </div>
                                                </template>


                                                <div class="flex min-w-0 flex-1 flex-col gap-0.5">

                                                    <div x-show="result.type === 'doc' && getBreadcrumbs(result).length > 0"
                                                        class="flex items-center gap-1 text-xs text-stone-400">
                                                        <template x-for="(crumb, i) in getBreadcrumbs(result)"
                                                            :key="i">
                                                            <div class="flex items-center">
                                                                <span x-text="crumb" class="truncate"></span>
                                                                <svg x-show="i < getBreadcrumbs(result).length - 1"
                                                                    class="mx-0.5 size-3 shrink-0"
                                                                    viewBox="0 0 24 24" fill="currentColor">
                                                                    <path
                                                                        d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z" />
                                                                </svg>
                                                            </div>
                                                        </template>
                                                    </div>


                                                    <div class="truncate text-sm font-medium text-stone-800"
                                                        x-text="getTitle(result)"></div>


                                                    <div x-show="result.type !== 'doc' && getSubtitle(result)"
                                                        class="truncate text-xs text-stone-400"
                                                        x-text="getSubtitle(result) ? 'by ' + getSubtitle(result) : ''">
                                                    </div>
                                                </div>


                                                <svg class="size-4 shrink-0 text-stone-400 opacity-0 transition-opacity duration-150"
                                                    :class="selectedIndex === index ? 'opacity-100' : 'group-hover:opacity-100'"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path d="m9 18 6-6-6-6" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>


                    <div x-show="results.length > 0" x-cloak
                        class="flex items-center gap-4 border-t border-bone-100 px-4 py-2.5 text-xs text-stone-400">
                        <div class="flex items-center gap-1">
                            <kbd class="rounded-xs bg-bone-100 px-1.5 py-0.5 font-mono text-[10px] text-stone-600">
                                &uarr;
                            </kbd>
                            <kbd class="rounded-xs bg-bone-100 px-1.5 py-0.5 font-mono text-[10px] text-stone-600">
                                &darr;
                            </kbd>
                            <span>to navigate</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <kbd class="rounded-xs bg-bone-100 px-1.5 py-0.5 font-mono text-[10px] text-stone-600">
                                &crarr;
                            </kbd>
                            <span>to select</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <kbd class="rounded-xs bg-bone-100 px-1.5 py-0.5 font-mono text-[10px] text-stone-600">
                                esc
                            </kbd>
                            <span>to close</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://filamentphp.com/livewire-aee9962d/livewire.min.js?id=657d57c2"
        data-csrf="20pzGRgiruUB4xyXmBwoU973CQ7tPhWBy6Hd0l9Q" data-module-url="https://filamentphp.com/livewire-aee9962d"
        data-update-uri="https://filamentphp.com/livewire-aee9962d/update" data-navigate-once="true"></script>
    <link rel="modulepreload" as="script" href="https://filamentphp.com/build/assets/app-B5h1W_V9.js" />
    <script type="module" src="https://filamentphp.com/build/assets/app-B5h1W_V9.js" data-navigate-track="reload"></script>
    <script>
        (function() {
            function c() {
                var b = a.contentDocument || a.contentWindow.document;
                if (b) {
                    var d = b.createElement('script');
                    d.innerHTML =
                        "window.__CF$cv$params={r:'a1ac4aa58fa66cb8',t:'MTc4Mzk4NzY5Mg=='};var a=document.createElement('script');a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";
                    b.getElementsByTagName('head')[0].appendChild(d)
                }
            }
            if (document.body) {
                var a = document.createElement('iframe');
                a.height = 1;
                a.width = 1;
                a.style.position = 'absolute';
                a.style.top = 0;
                a.style.left = 0;
                a.style.border = 'none';
                a.style.visibility = 'hidden';
                document.body.appendChild(a);
                if ('loading' !== document.readyState) c();
                else if (window.addEventListener) document.addEventListener('DOMContentLoaded', c);
                else {
                    var e = document.onreadystatechange || function() {};
                    document.onreadystatechange = function(b) {
                        e(b);
                        'loading' !== document.readyState && (document.onreadystatechange = e, c())
                    }
                }
            }
        })();
    </script>
</body>

</html>
