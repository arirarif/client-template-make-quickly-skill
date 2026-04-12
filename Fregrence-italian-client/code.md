Home - L'ESSENCE (Product Showcase)

<!DOCTYPE html><html class="dark" lang="en"><head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,200..800;1,6..72,200..800&amp;family=Manrope:wght@200..800&amp;display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "inverse-primary": "#775276",
                    "secondary": "#e9c176",
                    "surface-container-low": "#1e1b1e",
                    "tertiary": "#c8c6c5",
                    "primary-fixed": "#ffd6fa",
                    "on-primary-fixed-variant": "#5e3b5e",
                    "secondary-container": "#604403",
                    "primary-container": "#341536",
                    "on-secondary": "#412d00",
                    "on-background": "#e8e0e5",
                    "surface-dim": "#151215",
                    "on-error": "#690005",
                    "surface-variant": "#383437",
                    "error-container": "#93000a",
                    "on-secondary-container": "#dab36a",
                    "on-primary-container": "#a47ba2",
                    "on-secondary-fixed": "#261900",
                    "on-primary-fixed": "#2e0f30",
                    "on-error-container": "#ffdad6",
                    "primary": "#e6b8e2",
                    "on-tertiary-fixed": "#1c1b1b",
                    "on-tertiary-container": "#8a8888",
                    "surface-container-high": "#2d292c",
                    "tertiary-container": "#212121",
                    "surface-bright": "#3c383b",
                    "primary-fixed-dim": "#e6b8e2",
                    "surface-container-highest": "#383437",
                    "secondary-fixed-dim": "#e9c176",
                    "on-secondary-fixed-variant": "#5d4201",
                    "secondary-fixed": "#ffdea5",
                    "surface-tint": "#e6b8e2",
                    "on-surface-variant": "#cfc3ca",
                    "error": "#ffb4ab",
                    "outline-variant": "#4c454a",
                    "outline": "#988e94",
                    "inverse-surface": "#e8e0e5",
                    "inverse-on-surface": "#332f33",
                    "on-surface": "#e8e0e5",
                    "on-tertiary-fixed-variant": "#474746",
                    "tertiary-fixed-dim": "#c8c6c5",
                    "on-primary": "#452446",
                    "surface-container-lowest": "#100d10",
                    "tertiary-fixed": "#e5e2e1",
                    "background": "#151215",
                    "surface-container": "#221f22",
                    "on-tertiary": "#313030",
                    "surface": "#151215"
            },
            "borderRadius": {
                    "DEFAULT": "0px",
                    "lg": "0px",
                    "xl": "0px",
                    "full": "9999px"
            },
            "fontFamily": {
                    "headline": ["Newsreader", "serif"],
                    "body": ["Manrope", "sans-serif"],
                    "label": ["Manrope", "sans-serif"]
            }
          },
        },
      }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
        }
        .glass-panel {
            background: rgba(21, 18, 21, 0.4);
            backdrop-filter: blur(40px);
            position: relative;
        }
        .noise-overlay {
            position: relative;
        }
        .noise-overlay::after {
            content: "";
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
            opacity: 0.03;
            pointer-events: none;
            z-index: 10;
        }
        .text-glow {
            text-shadow: 0 0 30px rgba(233, 193, 118, 0.3);
        }
    </style>
</head>
<body class="bg-background text-on-background font-body selection:bg-secondary/30 selection:text-secondary">
<!-- TopNavBar -->
<nav class="fixed top-0 w-full z-50 h-24 bg-[#151215]/60 backdrop-blur-xl flex justify-between items-center px-12 max-w-[1920px] mx-auto border-b border-outline-variant/10">
<div class="flex items-center gap-16">
<span class="text-3xl font-headline italic text-[#e8e0e5] tracking-tight" style="">L'ESSENCE</span>
<div class="hidden lg:flex gap-10 items-center">
<a class="text-[#e9c176] font-label text-[11px] uppercase tracking-[0.15em] hover:opacity-80 transition-all active:scale-95" href="#" style="">Home</a>
<a class="text-[#e8e0e5]/70 hover:text-[#e8e0e5] font-label text-[11px] uppercase tracking-[0.15em] transition-all active:scale-95" href="#" style="">Shop</a>
<a class="text-[#e8e0e5]/70 hover:text-[#e8e0e5] font-label text-[11px] uppercase tracking-[0.15em] transition-all active:scale-95" href="#" style="">Collections</a>
<a class="text-[#e8e0e5]/70 hover:text-[#e8e0e5] font-label text-[11px] uppercase tracking-[0.15em] transition-all active:scale-95" href="#" style="">Heritage</a>
</div>
</div>
<div class="flex items-center gap-8">
<div class="hidden sm:flex items-center gap-4 border-r border-outline-variant/20 pr-8 mr-2">
<button class="material-symbols-outlined text-on-surface/70 hover:text-secondary transition-colors text-xl" style="">search</button>
<button class="material-symbols-outlined text-on-surface/70 hover:text-secondary transition-colors text-xl" style="">favorite</button>
</div>
<button class="material-symbols-outlined text-[#e8e0e5] hover:text-[#e9c176] transition-colors" style="">shopping_bag</button>
<button class="bg-secondary text-on-secondary px-8 py-3 text-[10px] uppercase tracking-[0.2em] font-label hover:opacity-90 active:scale-95 transition-all" style="">Get Started <span class="ml-2" style="">↗</span></button>
</div>
</nav>
<!-- Hero Refinement -->
<header class="relative h-screen w-full flex items-center justify-start overflow-hidden noise-overlay">
<div class="absolute inset-0 z-0">
<img alt="Luxury perfume bottle" class="w-full h-full object-cover opacity-70" src="https://lh3.googleusercontent.com/aida/ADBb0ujPFBO0Z98_4rBKEnTA1KQOptpEwoZmeZ9c4fg1LCNHJbft7DfCix1Q_T71-rVfewLTmlkJ5o7ut3iJsmr1ZR5wAg5kwedTZhTZwTb4Gu4fAjrPeNWcQDQ0Efqqrv5ZPjtMdLWLP820fpNVh6ADGLBwg_DvRh8QIN9M_ui8FLP4sTNPnJYWCNI6kYEnUd9uvgBSfyzOVGMYefLRhT3WfbKVfg6MsMVasmb00xjLl7Zesqwf5Vrnpb8Os248lTP__HBf2UfNysS_FXg" style="">
<div class="absolute inset-0 bg-gradient-to-r from-background via-background/40 to-transparent"></div>
<div class="absolute inset-0 bg-gradient-to-t from-background via-transparent to-transparent"></div>
</div>
<div class="relative z-10 max-w-5xl px-12 lg:px-24">
<div class="flex items-center gap-4 mb-8">
<div class="w-12 h-[1px] bg-secondary"></div>
<p class="font-label text-secondary uppercase tracking-[0.4em] text-[10px]" style="">Private Reserve Edition</p>
</div>
<h1 class="font-headline text-7xl md:text-[10rem] text-on-background italic leading-[0.85] mb-8 text-glow" style="">
                Unleash Your<br>
<span class="text-secondary not-italic font-medium" style="">Inner Fire.</span>
</h1>
<p class="max-w-md text-on-surface-variant font-body text-lg mb-12 leading-relaxed opacity-80" style="">
                L'ESSENCE is more than a fragrance. It's a statement of sophistication and passion, a tribute to the beautiful moments that define you.
            </p>
<div class="flex flex-col sm:flex-row gap-6 items-start">
<button class="bg-secondary text-on-secondary px-10 py-5 text-[11px] uppercase tracking-[0.2em] font-label hover:shadow-[0_0_30px_rgba(233,193,118,0.25)] transition-all active:scale-95 group" style="">
                    Discover LAVA <span class="inline-block transition-transform group-hover:translate-x-1 ml-2" style="">↗</span>
</button>
<div class="flex items-center gap-4 py-4">
<div class="flex -space-x-2">
<div class="w-8 h-8 rounded-full border-2 border-background bg-surface-variant"></div>
<div class="w-8 h-8 rounded-full border-2 border-background bg-surface-container-high"></div>
<div class="w-8 h-8 rounded-full border-2 border-background bg-secondary/20"></div>
</div>
<div>
<div class="flex gap-1">
<span class="material-symbols-outlined text-[12px] text-secondary fill-1" style="">star</span>
<span class="material-symbols-outlined text-[12px] text-secondary fill-1" style="">star</span>
<span class="material-symbols-outlined text-[12px] text-secondary fill-1" style="">star</span>
<span class="material-symbols-outlined text-[12px] text-secondary fill-1" style="">star</span>
<span class="material-symbols-outlined text-[12px] text-secondary fill-1" style="">star</span>
</div>
<p class="text-[9px] uppercase tracking-widest text-on-surface/50 font-label" style="">9K+ Global Reviews</p>
</div>
</div>
</div>
</div>
<!-- Floating Social Info -->
<div class="absolute right-12 bottom-24 hidden xl:flex flex-col gap-8 items-end">
<div class="flex items-center gap-4 group cursor-pointer">
<span class="text-[10px] uppercase tracking-[0.2em] text-on-surface/40 group-hover:text-secondary transition-colors" style="">Instagram</span>
<div class="w-8 h-[1px] bg-outline-variant/30 group-hover:bg-secondary group-hover:w-12 transition-all"></div>
</div>
<div class="flex items-center gap-4 group cursor-pointer">
<span class="text-[10px] uppercase tracking-[0.2em] text-on-surface/40 group-hover:text-secondary transition-colors" style="">Facebook</span>
<div class="w-8 h-[1px] bg-outline-variant/30 group-hover:bg-secondary group-hover:w-12 transition-all"></div>
</div>
</div>
</header>
<!-- Curated Collection Grid -->
<section class="py-32 px-12 max-w-[1920px] mx-auto bg-surface">
<div class="text-center mb-24">
<p class="font-label text-secondary uppercase tracking-[0.3em] text-[10px] mb-4" style="">Curated Selections</p>
<h2 class="font-headline text-5xl md:text-7xl" style="">The Masterpieces</h2>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-16">
<!-- Product 1 -->
<div class="group cursor-pointer">
<div class="relative aspect-[3/4] overflow-hidden bg-surface-container-lowest mb-8">
<img alt="Noir Essence" class="w-full h-full object-cover grayscale opacity-80 group-hover:grayscale-0 group-hover:scale-110 group-hover:opacity-100 transition-all duration-1000" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDQhtanWXDbDsu2wuDhyam9p1aBbTRXxEDmSlZWbIim9yGTHFfw1UbaBzXue4L02d9QYpGo35XFtWsCxohCZFzY0rq3Rf6aSRc8vNlHEt842cU5fqJ_ajNuSfn2LXowCED2EwkZGRJzExOy2HX-PrbWs3qxIxBx7IxPgC0LjFsXWFP1Abeo1Wdvbrr1dT-0JR121RorecqYIVkvw--rZ0q0tENEIPOrt9a63lp6HuStrxQGbnI8PHKPtAeybKjZZelc4vQfpRRa1Hy3" style="">
<div class="absolute inset-0 bg-black/20 group-hover:bg-black/0 transition-colors"></div>
<div class="absolute bottom-8 left-8 translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500">
<button class="bg-on-surface text-surface px-8 py-3 text-[10px] uppercase tracking-[0.2em] font-label" style="">Quick Shop</button>
</div>
</div>
<div class="flex justify-between items-start">
<div>
<h3 class="font-headline text-2xl mb-1" style="">Noir Essence</h3>
<p class="font-label text-[10px] uppercase tracking-[0.2em] text-on-surface/50" style="">Oudh, Smoke, Amber</p>
</div>
<p class="font-headline italic text-xl text-secondary" style="">$280</p>
</div>
</div>
<!-- Product 2 -->
<div class="group cursor-pointer lg:mt-12">
<div class="relative aspect-[3/4] overflow-hidden bg-surface-container-lowest mb-8">
<img alt="Orchid Moon" class="w-full h-full object-cover grayscale opacity-80 group-hover:grayscale-0 group-hover:scale-110 group-hover:opacity-100 transition-all duration-1000" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBjnE67D_POqYBxfNSoof6MzZwuvYqSSxGA8S7YlPOynWc14ufFSLUVGd_L8zpsOaU1Z0vRLuQJFEcloxaV135IL_tkol2O9kxd5b6mAZxUPnGo3y0hJqv0uNu6t1zxbYFSO9oF94N5JUZeFc0M63Z_kbfUK1qoLM0vSLBImu3CnEUPQVU3jco9Y6KNUfx00jHE17PcmtYITUJJKAJqY9JBxyzYfKhCKwFXq1GILweTAXo7_y2aI1ddvKd6RgMDZ1CtEbY8LjkMr2hA" style="">
<div class="absolute inset-0 bg-black/20 group-hover:bg-black/0 transition-colors"></div>
<div class="absolute bottom-8 left-8 translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500">
<button class="bg-on-surface text-surface px-8 py-3 text-[10px] uppercase tracking-[0.2em] font-label" style="">Quick Shop</button>
</div>
</div>
<div class="flex justify-between items-start">
<div>
<h3 class="font-headline text-2xl mb-1" style="">Orchid Moon</h3>
<p class="font-label text-[10px] uppercase tracking-[0.2em] text-on-surface/50" style="">Violet, Leather, Musk</p>
</div>
<p class="font-headline italic text-xl text-secondary" style="">$310</p>
</div>
</div>
<!-- Product 3 -->
<div class="group cursor-pointer">
<div class="relative aspect-[3/4] overflow-hidden bg-surface-container-lowest mb-8">
<img alt="Solar Flare" class="w-full h-full object-cover grayscale opacity-80 group-hover:grayscale-0 group-hover:scale-110 group-hover:opacity-100 transition-all duration-1000" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAMUDu5J7KTgQ0naItzgwsKHkpdui05rBqvgQOmx2-76JGbSMcigeebCOkhaEpaX0DYD-0c_-veMSXGu-yPxGwndhzwg-jxeVO693r_L8LfCzFYMDZJ7GvmzwLSxdXVoIj6b5yR_LPPuRTOSkSGHPhiw4X2XNUfznA4w_ZGXZGH_xnsUwEw4ploLCn5qYZmPxBttvGEjNynEe3D4WY07w95gF3n41uZu8qC-6LGYnlNVkcrb2e5kCc4PzQ1EpHAtFF36XPytvj9EFlT" style="">
<div class="absolute inset-0 bg-black/20 group-hover:bg-black/0 transition-colors"></div>
<div class="absolute bottom-8 left-8 translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500">
<button class="bg-on-surface text-surface px-8 py-3 text-[10px] uppercase tracking-[0.2em] font-label" style="">Quick Shop</button>
</div>
</div>
<div class="flex justify-between items-start">
<div>
<h3 class="font-headline text-2xl mb-1" style="">Solar Flare</h3>
<p class="font-label text-[10px] uppercase tracking-[0.2em] text-on-surface/50" style="">Bergamot, Saffron, Salt</p>
</div>
<p class="font-headline italic text-xl text-secondary" style="">$265</p>
</div>
</div>
</div>
</section>
<!-- Signature Scents Section -->
<section class="py-32 px-12 max-w-[1920px] mx-auto bg-surface-container-lowest">
<div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-8">
<div>
<p class="font-label text-secondary uppercase tracking-[0.4em] text-[10px] mb-4" style="">Limited Release</p>
<h2 class="font-headline text-5xl md:text-7xl italic" style="">Signature Scents</h2>
</div>
<p class="text-on-surface-variant font-body text-sm max-w-sm opacity-60 uppercase tracking-widest leading-loose" style="">
                Exclusive compositions available only through our atelier or private consultation.
            </p>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
<!-- Card 1 -->
<div class="group relative overflow-hidden bg-background border border-outline-variant/10 hover:border-secondary/20 transition-all duration-700">
<div class="aspect-[4/5] overflow-hidden">
<img alt="Noir Essence Bottle" class="w-full h-full object-cover grayscale opacity-70 group-hover:opacity-100 group-hover:scale-105 transition-all duration-1000" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDQhtanWXDbDsu2wuDhyam9p1aBbTRXxEDmSlZWbIim9yGTHFfw1UbaBzXue4L02d9QYpGo35XFtWsCxohCZFzY0rq3Rf6aSRc8vNlHEt842cU5fqJ_ajNuSfn2LXowCED2EwkZGRJzExOy2HX-PrbWs3qxIxBx7IxPgC0LjFsXWFP1Abeo1Wdvbrr1dT-0JR121RorecqYIVkvw--rZ0q0tENEIPOrt9a63lp6HuStrxQGbnI8PHKPtAeybKjZZelc4vQfpRRa1Hy3" style="">
</div>
<div class="p-8 space-y-4">
<div class="flex justify-between items-baseline">
<h3 class="font-headline text-3xl" style="">Noir Essence</h3>
<span class="text-secondary font-headline italic text-xl" style="">$280</span>
</div>
<div class="w-8 h-[1px] bg-secondary/30"></div>
<p class="text-[11px] font-label uppercase tracking-[0.2em] text-on-surface/60 leading-relaxed" style="">
                        A haunting melody of Oudh and Smoke, balanced by the warmth of aged Amber.
                    </p>
<button class="pt-4 flex items-center gap-2 text-[10px] font-label uppercase tracking-[0.3em] text-secondary hover:gap-4 transition-all" style="">
                        Details <span class="material-symbols-outlined text-sm" style="">arrow_forward</span>
</button>
</div>
</div>
<!-- Card 2 -->
<div class="group relative overflow-hidden bg-background border border-outline-variant/10 hover:border-secondary/20 transition-all duration-700">
<div class="aspect-[4/5] overflow-hidden">
<img alt="Orchid Moon Bottle" class="w-full h-full object-cover grayscale opacity-70 group-hover:opacity-100 group-hover:scale-105 transition-all duration-1000" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBjnE67D_POqYBxfNSoof6MzZwuvYqSSxGA8S7YlPOynWc14ufFSLUVGd_L8zpsOaU1Z0vRLuQJFEcloxaV135IL_tkol2O9kxd5b6mAZxUPnGo3y0hJqv0uNu6t1zxbYFSO9oF94N5JUZeFc0M63Z_kbfUK1qoLM0vSLBImu3CnEUPQVU3jco9Y6KNUfx00jHE17PcmtYITUJJKAJqY9JBxyzYfKhCKwFXq1GILweTAXo7_y2aI1ddvKd6RgMDZ1CtEbY8LjkMr2hA" style="">
</div>
<div class="p-8 space-y-4">
<div class="flex justify-between items-baseline">
<h3 class="font-headline text-3xl" style="">Orchid Moon</h3>
<span class="text-secondary font-headline italic text-xl" style="">$310</span>
</div>
<div class="w-8 h-[1px] bg-secondary/30"></div>
<p class="text-[11px] font-label uppercase tracking-[0.2em] text-on-surface/60 leading-relaxed" style="">
                        Ephemeral Violet and raw Leather notes create an atmosphere of nocturnal mystery.
                    </p>
<button class="pt-4 flex items-center gap-2 text-[10px] font-label uppercase tracking-[0.3em] text-secondary hover:gap-4 transition-all" style="">
                        Details <span class="material-symbols-outlined text-sm" style="">arrow_forward</span>
</button>
</div>
</div>
<!-- Card 3 -->
<div class="group relative overflow-hidden bg-background border border-outline-variant/10 hover:border-secondary/20 transition-all duration-700">
<div class="aspect-[4/5] overflow-hidden">
<img alt="Solar Flare Bottle" class="w-full h-full object-cover grayscale opacity-70 group-hover:opacity-100 group-hover:scale-105 transition-all duration-1000" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAMUDu5J7KTgQ0naItzgwsKHkpdui05rBqvgQOmx2-76JGbSMcigeebCOkhaEpaX0DYD-0c_-veMSXGu-yPxGwndhzwg-jxeVO693r_L8LfCzFYMDZJ7GvmzwLSxdXVoIj6b5yR_LPPuRTOSkSGHPhiw4X2XNUfznA4w_ZGXZGH_xnsUwEw4ploLCn5qYZmPxBttvGEjNynEe3D4WY07w95gF3n41uZu8qC-6LGYnlNVkcrb2e5kCc4PzQ1EpHAtFF36XPytvj9EFlT" style="">
</div>
<div class="p-8 space-y-4">
<div class="flex justify-between items-baseline">
<h3 class="font-headline text-3xl" style="">Solar Flare</h3>
<span class="text-secondary font-headline italic text-xl" style="">$265</span>
</div>
<div class="w-8 h-[1px] bg-secondary/30"></div>
<p class="text-[11px] font-label uppercase tracking-[0.2em] text-on-surface/60 leading-relaxed" style="">
                        The brilliance of Bergamot and Saffron meet the sharp clarity of mineral sea Salt.
                    </p>
<button class="pt-4 flex items-center gap-2 text-[10px] font-label uppercase tracking-[0.3em] text-secondary hover:gap-4 transition-all" style="">
                        Details <span class="material-symbols-outlined text-sm" style="">arrow_forward</span>
</button>
</div>
</div>
</div>
</section>
<!-- The Scent Finder -->
<section class="relative py-48 overflow-hidden">
<div class="absolute inset-0">
<img alt="Water ripples" class="w-full h-full object-cover grayscale opacity-40 scale-110 blur-[2px]" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBTp9cr1eejc8bUZrWFDglE4LC_tQS3D3nlbf5AmTn-QJOd2yHIaAuisV-DDakQOX2uqhGCG9wx4qVsB-ZYaf0ObhVjI_UYJ1NXtddjhbp8x5yloeHorZT7xsvW_u-LqAa6lE8VjfnTf2idtV2-TmJbhgO_soKyC2Y29BotkigqsnVR7iWp9rPtpwjiLgdFBofV7OsBLTkfR0Qpqmtd22VeDD_llyjC77k822rtRqYZvG5QX4pl7TaiSlgVAEKanKpCrYvRw7k5UEGJ" style="">
<div class="absolute inset-0 bg-background/80"></div>
</div>
<div class="relative z-10 max-w-4xl mx-auto text-center px-6">
<h2 class="font-headline text-5xl md:text-8xl mb-8 leading-tight" style="">Find Your <span class="italic text-secondary" style="">Signature</span> Essence</h2>
<p class="text-on-surface-variant font-body text-xl mb-12 max-w-2xl mx-auto leading-relaxed" style="">
                Every fragrance tells a unique story. Allow our Digital Sommelier to navigate the olfactory notes of your subconscious and reveal your perfect match.
            </p>
<button class="bg-secondary text-on-secondary px-12 py-6 text-xs uppercase tracking-[0.3em] font-label hover:shadow-[0_0_40px_rgba(233,193,118,0.3)] transition-all active:scale-95" style="">
                Begin Consultation
            </button>
</div>
</section>
<!-- Olfactory Storytelling -->
<section class="bg-surface-container-lowest border-y border-outline-variant/10">
<!-- Row 1 -->
<div class="grid grid-cols-1 lg:grid-cols-2">
<div class="aspect-square lg:aspect-auto overflow-hidden">
<img alt="Craftsmanship" class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-1000" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAZdIdDIaT8n2Nd5WHL54LPT-XM9WSCqosn_Xdj3iqU02zbwIcid8psmxkmvdQEu7Pe39Vc8mrkl8ZsQkFnbfPKit4NnmDZgJEnV3XtO_lEichZzYNRyAYqE9u5hSHpu77HCJIzJbb8VbCPP1MfkXTtYP8LbyGjV6y-VXvWh2iS6Z-J9GsuAuENNoh1NzCXNKBmQSGpq3j24n7Y_YXKtHlXfgcI6L_6EDyElDUiG-G0h27SD_iusZf0Pc5N-D3pzB4HaiRIsKRIfIxG" style="">
</div>
<div class="flex flex-col justify-center p-12 lg:p-24 space-y-8 bg-surface">
<span class="font-label text-secondary uppercase tracking-[0.4em] text-[10px]" style="">The Heritage</span>
<h3 class="font-headline text-5xl md:text-6xl italic leading-tight" style="">Alchemy in <br>Every Drop</h3>
<p class="text-on-surface-variant font-body text-lg leading-relaxed max-w-md" style="">
                    Our process remains unchanged since the 18th century. We source the rarest botanicals from across the globe, aged in charred obsidian vessels to achieve a depth that defies modern synthesis.
                </p>
<a class="inline-block font-label text-[10px] uppercase tracking-[0.3em] text-secondary border-b border-secondary/30 pb-2 hover:border-secondary transition-colors w-max" href="#" style="">Read the Chronicles</a>
</div>
</div>
<!-- Row 2 -->
<div class="grid grid-cols-1 lg:grid-cols-2">
<div class="order-2 lg:order-1 flex flex-col justify-center p-12 lg:p-24 space-y-8 bg-surface">
<span class="font-label text-secondary uppercase tracking-[0.4em] text-[10px]" style="">The Ethos</span>
<h3 class="font-headline text-5xl md:text-6xl leading-tight" style="">Whispers of <br><span class="italic text-secondary" style="">Elegance</span></h3>
<p class="text-on-surface-variant font-body text-lg leading-relaxed max-w-md" style="">
                    A fragrance should not shout; it should linger like a memory. We design silhouettes for the skin, invisible garments that reveal the soul's most intimate layers.
                </p>
<a class="inline-block font-label text-[10px] uppercase tracking-[0.3em] text-secondary border-b border-secondary/30 pb-2 hover:border-secondary transition-colors w-max" href="#" style="">Our Philosophy</a>
</div>
<div class="order-1 lg:order-2 aspect-square lg:aspect-auto overflow-hidden">
<img alt="Artistry" class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-1000" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBTp9cr1eejc8bUZrWFDglE4LC_tQS3D3nlbf5AmTn-QJOd2yHIaAuisV-DDakQOX2uqhGCG9wx4qVsB-ZYaf0ObhVjI_UYJ1NXtddjhbp8x5yloeHorZT7xsvW_u-LqAa6lE8VjfnTf2idtV2-TmJbhgO_soKyC2Y29BotkigqsnVR7iWp9rPtpwjiLgdFBofV7OsBLTkfR0Qpqmtd22VeDD_llyjC77k822rtRqYZvG5QX4pl7TaiSlgVAEKanKpCrYvRw7k5UEGJ" style="">
</div>
</div>
</section>
<!-- Newsletter / Inner Circle -->
<section class="py-32 bg-background border-t border-outline-variant/5">
<div class="max-w-4xl mx-auto px-6 text-center">
<span class="font-label text-secondary uppercase tracking-[0.4em] text-[10px] block mb-8" style="">The Inner Circle</span>
<h2 class="font-headline text-5xl mb-12 italic" style="">Join the Sensory Avant-Garde</h2>
<p class="text-on-surface-variant font-body mb-16 text-lg max-w-xl mx-auto opacity-70" style="">
                Be the first to experience private reserve releases, atelier events, and limited batch collaborations.
            </p>
<div class="max-w-md mx-auto relative group">
<input class="w-full bg-transparent border-0 border-b border-outline-variant/30 py-4 font-label text-[10px] uppercase tracking-[0.3em] focus:ring-0 focus:border-secondary transition-colors placeholder:text-on-surface/30 text-center" placeholder="EMAIL ADDRESS" type="email">
<button class="absolute right-0 top-1/2 -translate-y-1/2 text-secondary group-hover:translate-x-1 transition-transform" style="">
<span class="material-symbols-outlined" style="">arrow_forward</span>
</button>
</div>
<div class="mt-12 flex justify-center gap-4">
<label class="flex items-center gap-3 cursor-pointer" style="">
<input class="rounded-none bg-transparent border-outline-variant/30 text-secondary focus:ring-0 w-4 h-4" type="checkbox">
<span class="text-[9px] font-label uppercase tracking-[0.1em] text-on-surface/40" style="">I accept the privacy terms</span>
</label>
</div>
</div>
</section>
<!-- Footer -->
<footer class="w-full pt-24 pb-12 bg-surface-container-lowest">
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-16 px-12 max-w-7xl mx-auto mb-24">
<div class="space-y-8">
<span class="text-2xl font-headline italic text-[#e8e0e5]" style="">L'ESSENCE</span>
<p class="text-[11px] font-label text-on-surface/50 leading-relaxed tracking-wider uppercase" style="">
                    An olfactory studio dedicated to the preservation of high perfumery. Crafted in Paris, Bottled for the World.
                </p>
<div class="flex gap-6">
<a class="text-on-surface/40 hover:text-secondary transition-colors" href="#" style="">
<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"></path></svg>
</a>
<a class="text-on-surface/40 hover:text-secondary transition-colors" href="#" style="">
<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.84 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"></path></svg>
</a>
</div>
</div>
<div class="space-y-6">
<h4 class="font-label text-[10px] uppercase tracking-[0.25em] text-secondary" style="">Maison</h4>
<ul class="space-y-4">
<li class="" style=""><a class="text-[10px] font-label uppercase tracking-[0.2em] text-on-surface/40 hover:text-secondary transition-colors" href="#" style="">Heritage</a></li>
<li class="" style=""><a class="text-[10px] font-label uppercase tracking-[0.2em] text-on-surface/40 hover:text-secondary transition-colors" href="#" style="">Ingredients</a></li>
<li class="" style=""><a class="text-[10px] font-label uppercase tracking-[0.2em] text-on-surface/40 hover:text-secondary transition-colors" href="#" style="">Sustainability</a></li>
</ul>
</div>
<div class="space-y-6">
<h4 class="font-label text-[10px] uppercase tracking-[0.25em] text-secondary" style="">Collections</h4>
<ul class="space-y-4">
<li class="" style=""><a class="text-[10px] font-label uppercase tracking-[0.2em] text-on-surface/40 hover:text-secondary transition-colors" href="#" style="">Noir Absolu</a></li>
<li class="" style=""><a class="text-[10px] font-label uppercase tracking-[0.2em] text-on-surface/40 hover:text-secondary transition-colors" href="#" style="">Lunar Floral</a></li>
<li class="" style=""><a class="text-[10px] font-label uppercase tracking-[0.2em] text-on-surface/40 hover:text-secondary transition-colors" href="#" style="">Private Reserve</a></li>
</ul>
</div>
<div class="space-y-6">
<h4 class="font-label text-[10px] uppercase tracking-[0.25em] text-secondary" style="">Concierge</h4>
<ul class="space-y-4">
<li class="" style=""><a class="text-[10px] font-label uppercase tracking-[0.2em] text-on-surface/40 hover:text-secondary transition-colors" href="#" style="">Order Tracking</a></li>
<li class="" style=""><a class="text-[10px] font-label uppercase tracking-[0.2em] text-on-surface/40 hover:text-secondary transition-colors" href="#" style="">Store Locator</a></li>
<li class="" style=""><a class="text-[10px] font-label uppercase tracking-[0.2em] text-on-surface/40 hover:text-secondary transition-colors" href="#" style="">Sample Service</a></li>
</ul>
</div>
</div>
<div class="pt-12 border-t border-outline-variant/5 text-center px-12">
<p class="text-[9px] font-label text-on-surface/30 uppercase tracking-[0.4em]" style="">
                © 2024 L'ESSENCE PERFUMES ATELIER. ALL RIGHTS RESERVED.
            </p>
</div>
</footer>
</body></html>



Shop - L'ESSENCE
<!DOCTYPE html>

<html class="dark" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,200..800;1,6..72,200..800&amp;family=Manrope:wght@200..800&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "inverse-primary": "#775276",
                    "secondary": "#e9c176",
                    "surface-container-low": "#1e1b1e",
                    "tertiary": "#c8c6c5",
                    "primary-fixed": "#ffd6fa",
                    "on-primary-fixed-variant": "#5e3b5e",
                    "secondary-container": "#604403",
                    "primary-container": "#341536",
                    "on-secondary": "#412d00",
                    "on-background": "#e8e0e5",
                    "surface-dim": "#151215",
                    "on-error": "#690005",
                    "surface-variant": "#383437",
                    "error-container": "#93000a",
                    "on-secondary-container": "#dab36a",
                    "on-primary-container": "#a47ba2",
                    "on-secondary-fixed": "#261900",
                    "on-primary-fixed": "#2e0f30",
                    "on-error-container": "#ffdad6",
                    "primary": "#e6b8e2",
                    "on-tertiary-fixed": "#1c1b1b",
                    "on-tertiary-container": "#8a8888",
                    "surface-container-high": "#2d292c",
                    "tertiary-container": "#212121",
                    "surface-bright": "#3c383b",
                    "primary-fixed-dim": "#e6b8e2",
                    "surface-container-highest": "#383437",
                    "secondary-fixed-dim": "#e9c176",
                    "on-secondary-fixed-variant": "#5d4201",
                    "secondary-fixed": "#ffdea5",
                    "surface-tint": "#e6b8e2",
                    "on-surface-variant": "#cfc3ca",
                    "error": "#ffb4ab",
                    "outline-variant": "#4c454a",
                    "outline": "#988e94",
                    "inverse-surface": "#e8e0e5",
                    "inverse-on-surface": "#332f33",
                    "on-surface": "#e8e0e5",
                    "on-tertiary-fixed-variant": "#474746",
                    "tertiary-fixed-dim": "#c8c6c5",
                    "on-primary": "#452446",
                    "surface-container-lowest": "#100d10",
                    "tertiary-fixed": "#e5e2e1",
                    "background": "#151215",
                    "surface-container": "#221f22",
                    "on-tertiary": "#313030",
                    "surface": "#151215"
            },
            "borderRadius": {
                    "DEFAULT": "0px",
                    "lg": "0px",
                    "xl": "0px",
                    "full": "9999px"
            },
            "fontFamily": {
                    "headline": ["Newsreader", "serif"],
                    "body": ["Manrope", "sans-serif"],
                    "label": ["Manrope", "sans-serif"]
            }
          },
        },
      }
    </script>
<style>body {
    background-color: #151215;
    color: #e8e0e5;
    font-family: "Manrope", sans-serif;
    -webkit-font-smoothing: antialiased
    }
.grain {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 99;
    opacity: 0.03;
    background-image: url(https://lh3.googleusercontent.com/aida-public/AB6AXuBUGDSo3XTJJfQtJZUlPLR2mLWGNiwgoep1dfmJkuZTdqNIru_2t2au-FAxuy3zckYMsYpI8erF_AoMbgM0Kh8RzcOGoho4VprZdKxh9tzUe2SKxw3JNxxavKxlVi7G0Ytz-Lqdhg_YNuMCZuyBsX8VMT8vooIbEcqtp1rKxZHeaf9pct8BP1l3H9jJt0NLLtesMyXhCtWwsDqOM994bSR0iU8_J1AhwYSSYjFXmJf0Afrf93zKrFInPT2UWxplfjrMroU4P1klqooJ)
    }
.material-symbols-outlined {
    font-variation-settings: "FILL" 0, "wght" 300, "GRAD" 0, "opsz" 24
    }
.editorial-shadow {
    box-shadow: 0 40px 80px -20px rgba(21, 18, 21, 0.8)
    }</style>
</head>
<body class="bg-background text-on-background selection:bg-secondary/30">
<div class="grain"></div>
<!-- Navigation Shell -->
<nav class="fixed top-0 w-full z-50 h-24 bg-[#151215]/80 backdrop-blur-xl flex justify-between items-center px-12 max-w-[1920px] mx-auto transition-all duration-300">
<div class="flex items-center gap-12">
<span class="text-3xl font-serif italic text-[#e8e0e5] tracking-tight">L'ESSENCE</span>
<div class="hidden md:flex gap-8 items-center pt-1">
<a class="text-[#e8e0e5]/70 hover:text-[#e8e0e5] transition-colors font-body text-sm tracking-[0.05em]" href="#">Home</a>
<a class="text-[#e9c176] border-b border-[#e9c176]/30 pb-1 font-body text-sm tracking-[0.05em]" href="#">Shop</a>
<a class="text-[#e8e0e5]/70 hover:text-[#e8e0e5] transition-colors font-body text-sm tracking-[0.05em]" href="#">Collections</a>
<a class="text-[#e8e0e5]/70 hover:text-[#e8e0e5] transition-colors font-body text-sm tracking-[0.05em]" href="#">About</a>
<a class="text-[#e8e0e5]/70 hover:text-[#e8e0e5] transition-colors font-body text-sm tracking-[0.05em]" href="#">Contact</a>
</div>
</div>
<div class="flex items-center gap-6">
<button class="material-symbols-outlined text-on-background/80 hover:text-secondary transition-colors" data-icon="shopping_bag">shopping_bag</button>
<button class="material-symbols-outlined text-on-background/80 hover:text-secondary transition-colors" data-icon="person">person</button>
</div>
</nav>
<main class="pt-32 pb-20 px-6 md:px-12 max-w-[1600px] mx-auto">
<!-- Header Section -->
<header class="mb-20">
<h1 class="font-headline text-6xl md:text-8xl font-light tracking-tight mb-6">The Boutique</h1>
<p class="font-body text-on-surface-variant max-w-xl text-lg tracking-wide leading-relaxed">
                A curated selection of olfactory journeys, crafted for the discerning soul. Discover your signature scent within our obsidian glass vessels.
            </p>
</header>
<!-- Filters & Results Layout -->
<div class="flex flex-col md:flex-row gap-16">
<!-- Sidebar Filters -->
<aside class="w-full md:w-64 space-y-12">
<div>
<h3 class="font-label uppercase text-[10px] tracking-[0.2em] text-secondary mb-6">Scent Profile</h3>
<ul class="space-y-4 font-body text-sm tracking-widest text-on-surface-variant">
<li class="flex items-center gap-3 cursor-pointer hover:text-secondary transition-colors">
<span class="w-2 h-2 border border-outline-variant"></span>
                            All Fragrances
                        </li>
<li class="flex items-center gap-3 cursor-pointer hover:text-secondary transition-colors">
<span class="w-2 h-2 border border-outline-variant"></span>
                            Floral
                        </li>
<li class="flex items-center gap-3 cursor-pointer hover:text-secondary transition-colors">
<span class="w-2 h-2 border border-secondary bg-secondary/10"></span>
                            Woody
                        </li>
<li class="flex items-center gap-3 cursor-pointer hover:text-secondary transition-colors">
<span class="w-2 h-2 border border-outline-variant"></span>
                            Oriental
                        </li>
<li class="flex items-center gap-3 cursor-pointer hover:text-secondary transition-colors">
<span class="w-2 h-2 border border-outline-variant"></span>
                            Fresh
                        </li>
</ul>
</div>
<div>
<h3 class="font-label uppercase text-[10px] tracking-[0.2em] text-secondary mb-6">Collection</h3>
<ul class="space-y-4 font-body text-sm tracking-widest text-on-surface-variant">
<li class="cursor-pointer hover:text-secondary transition-colors">L'Ombre</li>
<li class="cursor-pointer hover:text-secondary transition-colors">Soleil Levant</li>
<li class="cursor-pointer hover:text-secondary transition-colors">Nuit d'Or</li>
</ul>
</div>
<div>
<h3 class="font-label uppercase text-[10px] tracking-[0.2em] text-secondary mb-6">Intensity</h3>
<div class="space-y-2">
<div class="h-[1px] bg-outline-variant w-full relative">
<div class="absolute left-1/4 h-2 w-2 bg-secondary -top-[4px]"></div>
<div class="absolute left-3/4 h-2 w-2 bg-secondary -top-[4px]"></div>
</div>
<div class="flex justify-between font-label text-[10px] text-on-surface-variant opacity-50">
<span>Muted</span>
<span>Intense</span>
</div>
</div>
</div>
</aside>
<!-- Product Grid -->
<section class="flex-1">
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-20 gap-x-8">
<!-- Product Card 1 -->
<article class="group relative">
<div class="aspect-[3/4] overflow-hidden bg-surface-container-low relative mb-6">
<img alt="Minimalist perfume bottle" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" data-alt="Close-up of a luxury minimal black perfume bottle on a dark reflective stone surface with dramatic side lighting and soft shadows" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDmhXoI3BCwVJMfawJDv4LZYop-sRT2-B2V4ZeaDOcCRTA3fjR2upQvvg-uX6OeZi4xJtrtmy3QXaFgefATwm8GpCUDqn_R7j9ns3T1uwu8qhRt64M9KnU6yqYBBqfCKGEunfnfBAzhEkSxOyQ8D2bvMgWO0RerPCKDcWboZx5Mntg1KaoJqxT1Jh9S0zf6m-1NUi2oOhGAxjG7qNgGxMJzU6sa87iXo2LxmxRuXSLyMjfRJuVf4GvCCB8v9saLcGVwHDQmNMqBomsu"/>
<div class="absolute inset-0 bg-background/10 group-hover:bg-background/0 transition-colors duration-500"></div>
<button class="absolute bottom-6 left-1/2 -translate-x-1/2 bg-secondary text-on-secondary px-8 py-3 font-label text-xs uppercase tracking-[0.15em] opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-4 group-hover:translate-y-0">
                                Quick Buy
                            </button>
</div>
<div class="space-y-1">
<div class="flex justify-between items-baseline">
<h2 class="font-headline text-2xl">Oud Nocturne</h2>
<span class="font-body text-sm text-on-surface-variant tracking-wider">$210</span>
</div>
<p class="font-label text-[10px] uppercase tracking-[0.15em] text-secondary">Woody • Intense</p>
</div>
</article>
<!-- Product Card 2 -->
<article class="group relative lg:mt-12">
<div class="aspect-[3/4] overflow-hidden bg-surface-container-low relative mb-6">
<img alt="Clear glass perfume bottle" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" data-alt="Sleek glass fragrance bottle with gold cap standing in front of soft linen curtains with morning sunlight pouring through" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAaeciI6EH6c0cCiNjD0hCw1haADlhfeJkOaWdYtr9-VCp1QZyc7E9MnBwilqP6k63t0wJzCV1x-2xF1ALhyJmwCEPHMwPHRrbp0Y66p3AauTI8gpivAR187Pwd1iTyYPM5_DT6bgliwsDG-bFPzZg8ANZXsdVDRbWtvP7yl1IMtI17VRjYklBGjyD-n8waVlU9qRM_d98NxIfUAaEXulGlaleDuZW2zNUatInDwSjQz9Ez2uGzMk1IeQN_E7WIMJh8--2mVFcGiYq5"/>
<div class="absolute inset-0 bg-background/10 group-hover:bg-background/0 transition-colors duration-500"></div>
<button class="absolute bottom-6 left-1/2 -translate-x-1/2 bg-secondary text-on-secondary px-8 py-3 font-label text-xs uppercase tracking-[0.15em] opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-4 group-hover:translate-y-0">
                                Quick Buy
                            </button>
</div>
<div class="space-y-1">
<div class="flex justify-between items-baseline">
<h2 class="font-headline text-2xl">Rose de Matin</h2>
<span class="font-body text-sm text-on-surface-variant tracking-wider">$185</span>
</div>
<p class="font-label text-[10px] uppercase tracking-[0.15em] text-secondary">Floral • Delicate</p>
</div>
</article>
<!-- Product Card 3 -->
<article class="group relative">
<div class="aspect-[3/4] overflow-hidden bg-surface-container-low relative mb-6">
<img alt="Dark amber perfume bottle" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" data-alt="Amber glass apothecary style perfume bottle sitting on a dark wood library shelf with warm ambient lighting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCfWKf36UyG3fktExtw26uw-sZiZ2V3LwH1rEqPntHJMhkSeHdRawa26J3M_LCUhuON38-QaBckU8if_3p4xnD9uoT-o39ADgS7TAJrILA19MPfz4U3Px73YTXM39csHKXKY_RwGTvdyo6nonAOFpzk3VORF5HdrI8e-IPPRuw_fLCiYjM4LLozG2SC9UYR-_0LrBx-tU03Onr_0Hho5HCd5BVdlsYZjGIPGkeM1YWmIHG68tqXyE2AhZoyYL0QuX5yhFjV0ukjE0oJ"/>
<div class="absolute inset-0 bg-background/10 group-hover:bg-background/0 transition-colors duration-500"></div>
<button class="absolute bottom-6 left-1/2 -translate-x-1/2 bg-secondary text-on-secondary px-8 py-3 font-label text-xs uppercase tracking-[0.15em] opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-4 group-hover:translate-y-0">
                                Quick Buy
                            </button>
</div>
<div class="space-y-1">
<div class="flex justify-between items-baseline">
<h2 class="font-headline text-2xl">Ambre Rare</h2>
<span class="font-body text-sm text-on-surface-variant tracking-wider">$240</span>
</div>
<p class="font-label text-[10px] uppercase tracking-[0.15em] text-secondary">Oriental • Warm</p>
</div>
</article>
<!-- Product Card 4 -->
<article class="group relative">
<div class="aspect-[3/4] overflow-hidden bg-surface-container-low relative mb-6">
<img alt="Mist over dark water perfume" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" data-alt="Frosted glass perfume bottle on a basalt rock by the ocean at dawn with misty cool tones and dramatic waves" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAFElXJhiNUFqc8nk2GgkcVgapzoT4WuJzYiIlA4797nCsopYQSSCBSs80DkO49LblZgyCSixZ673TAcIxXesPYWR8cPQlRszvuLqOm60oDCyCiH8IguI-KL8YMxSQYW7iAV5AoYf2kU0obTeZPqCvZGbN-pRQrtcP33e00pIuDxgiOos6LmTgqQSnBPnGOMd7r27Ww5aSyf1Bie_zmo_fkHGi6vBn0WlUZw8qqNtey8BNPSySpjIvLc1ImIaxw6B_A0AKdIKZibSiY"/>
<div class="absolute inset-0 bg-background/10 group-hover:bg-background/0 transition-colors duration-500"></div>
<button class="absolute bottom-6 left-1/2 -translate-x-1/2 bg-secondary text-on-secondary px-8 py-3 font-label text-xs uppercase tracking-[0.15em] opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-4 group-hover:translate-y-0">
                                Quick Buy
                            </button>
</div>
<div class="space-y-1">
<div class="flex justify-between items-baseline">
<h2 class="font-headline text-2xl">Sel Marin</h2>
<span class="font-body text-sm text-on-surface-variant tracking-wider">$195</span>
</div>
<p class="font-label text-[10px] uppercase tracking-[0.15em] text-secondary">Fresh • Ozone</p>
</div>
</article>
<!-- Product Card 5 -->
<article class="group relative lg:-mt-12">
<div class="aspect-[3/4] overflow-hidden bg-surface-container-low relative mb-6">
<img alt="Smoky incense perfume" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" data-alt="Square obsidian glass bottle surrounded by thin wisps of incense smoke against a pitch black velvet background" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCPq9kvMjGBTi9cEmy3zoRc_uvSrZkcklik1tErfwMLWPeLD6Pw9cmYqCI-Go96fOqjaD3e3aE4JrFUu0dzb8C4uUBCriGr5T4A3fSfznjZIPCN3ETkvOnqisqPII5yT6YvsK2fM5mJwN72KZ8DPGqzz-85xVisBsVfn6i1OHbnocd4Boahxm4T0zarzZZsGLFPG8jifjaDY6cRTHsUk7eSPkmZvsQLeY4L4jaFJf2wB0BaUUPPOcjSrzgsnLgRAz2fvTkfRhhpEoJh"/>
<div class="absolute inset-0 bg-background/10 group-hover:bg-background/0 transition-colors duration-500"></div>
<button class="absolute bottom-6 left-1/2 -translate-x-1/2 bg-secondary text-on-secondary px-8 py-3 font-label text-xs uppercase tracking-[0.15em] opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-4 group-hover:translate-y-0">
                                Quick Buy
                            </button>
</div>
<div class="space-y-1">
<div class="flex justify-between items-baseline">
<h2 class="font-headline text-2xl">Fumée Grise</h2>
<span class="font-body text-sm text-on-surface-variant tracking-wider">$225</span>
</div>
<p class="font-label text-[10px] uppercase tracking-[0.15em] text-secondary">Woody • Smoky</p>
</div>
</article>
<!-- Product Card 6 -->
<article class="group relative">
<div class="aspect-[3/4] overflow-hidden bg-surface-container-low relative mb-6">
<img alt="Sunset golden perfume" class="w-full h-full object-crop transition-transform duration-700 group-hover:scale-105" data-alt="Tall slender perfume bottle with amber liquid glowing in the golden hour sun on a marble balcony overlooking the mediterranean" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAQtU3XCmdFjQELt6HFhV2oIj4p1iMOhI82FTXYE0kxWfyTDyhsdhYDHAv3RNGsx9tcook1SNW4LkZFIyajsFKwOLbF6TnlihYkOzhPJEzkopr34wnDubp9W5Iv1MG76RgERN64hkV8-KoWVTBL75c6yjSeWbwIOKAwfiviHzOmST1JAPdCIAS3EKlfcY3Sz_y3cax3WUbPCPHUm-CPOfoa4WxzyRLLcOOqo8b0Mro3pS2MuGb8G77TLtO6vCtc5UDdvAD8c6sEGtu_"/>
<div class="absolute inset-0 bg-background/10 group-hover:bg-background/0 transition-colors duration-500"></div>
<button class="absolute bottom-6 left-1/2 -translate-x-1/2 bg-secondary text-on-secondary px-8 py-3 font-label text-xs uppercase tracking-[0.15em] opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-4 group-hover:translate-y-0">
                                Quick Buy
                            </button>
</div>
<div class="space-y-1">
<div class="flex justify-between items-baseline">
<h2 class="font-headline text-2xl">L'Or de Sud</h2>
<span class="font-body text-sm text-on-surface-variant tracking-wider">$260</span>
</div>
<p class="font-label text-[10px] uppercase tracking-[0.15em] text-secondary">Floral • Radiant</p>
</div>
</article>
</div>
<!-- Pagination / Load More -->
<div class="mt-32 text-center">
<button class="font-label text-xs uppercase tracking-[0.3em] text-secondary border-b border-secondary/20 pb-4 hover:border-secondary transition-all">
                        Load More Artistry
                    </button>
</div>
</section>
</div>
</main>
<!-- Footer -->
<footer class="w-full pt-20 pb-10 border-t border-[#383437]/10 bg-[#100d10]">
<div class="grid grid-cols-1 md:grid-cols-4 gap-12 px-12 max-w-7xl mx-auto">
<div class="space-y-6">
<span class="text-xl font-serif text-[#e8e0e5]">L'ESSENCE</span>
<p class="font-body text-xs text-[#e8e0e5]/50 leading-loose tracking-wider">
                    An odyssey of the senses, distilled into timeless fragrances. Handcrafted in the heart of the perfume capital.
                </p>
</div>
<div>
<h4 class="font-label text-[10px] uppercase tracking-[0.2em] text-[#e9c176] mb-8">Client Service</h4>
<ul class="space-y-4 font-body text-[10px] uppercase tracking-[0.2em]">
<li><a class="text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors duration-500" href="#">Shipping &amp; Returns</a></li>
<li><a class="text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors duration-500" href="#">Contact Us</a></li>
<li><a class="text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors duration-500" href="#">Wholesale</a></li>
</ul>
</div>
<div>
<h4 class="font-label text-[10px] uppercase tracking-[0.2em] text-[#e9c176] mb-8">Legal</h4>
<ul class="space-y-4 font-body text-[10px] uppercase tracking-[0.2em]">
<li><a class="text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors duration-500" href="#">Privacy Policy</a></li>
<li><a class="text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors duration-500" href="#">Terms of Service</a></li>
</ul>
</div>
<div>
<h4 class="font-label text-[10px] uppercase tracking-[0.2em] text-[#e9c176] mb-8">Newsletter</h4>
<div class="relative border-b border-outline-variant/30 pb-2 flex items-center">
<input class="bg-transparent border-none text-[10px] w-full focus:ring-0 placeholder:text-[#e8e0e5]/20 font-body tracking-[0.2em]" placeholder="YOUR EMAIL" type="email"/>
<span class="material-symbols-outlined text-secondary text-sm">east</span>
</div>
</div>
</div>
<div class="mt-20 text-center">
<p class="font-body text-[10px] uppercase tracking-[0.2em] text-[#e8e0e5]/30">© 2024 L'ESSENCE PERFUMES. ALL RIGHTS RESERVED.</p>
</div>
</footer>
</body></html>





LAVA - Eau de Parfum
<!DOCTYPE html>

<html class="dark" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>L'ESSENCE | Luxury Fragrance</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,200..800;1,6..72,200..800&amp;family=Manrope:wght@200..800&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "inverse-primary": "#775276",
                        "secondary": "#e9c176",
                        "surface-container-low": "#1e1b1e",
                        "tertiary": "#c8c6c5",
                        "primary-fixed": "#ffd6fa",
                        "on-primary-fixed-variant": "#5e3b5e",
                        "secondary-container": "#604403",
                        "primary-container": "#341536",
                        "on-secondary": "#412d00",
                        "on-background": "#e8e0e5",
                        "surface-dim": "#151215",
                        "on-error": "#690005",
                        "surface-variant": "#383437",
                        "error-container": "#93000a",
                        "on-secondary-container": "#dab36a",
                        "on-primary-container": "#a47ba2",
                        "on-secondary-fixed": "#261900",
                        "on-primary-fixed": "#2e0f30",
                        "on-error-container": "#ffdad6",
                        "primary": "#e6b8e2",
                        "on-tertiary-fixed": "#1c1b1b",
                        "on-tertiary-container": "#8a8888",
                        "surface-container-high": "#2d292c",
                        "tertiary-container": "#212121",
                        "surface-bright": "#3c383b",
                        "primary-fixed-dim": "#e6b8e2",
                        "surface-container-highest": "#383437",
                        "secondary-fixed-dim": "#e9c176",
                        "on-secondary-fixed-variant": "#5d4201",
                        "secondary-fixed": "#ffdea5",
                        "surface-tint": "#e6b8e2",
                        "on-surface-variant": "#cfc3ca",
                        "error": "#ffb4ab",
                        "outline-variant": "#4c454a",
                        "outline": "#988e94",
                        "inverse-surface": "#e8e0e5",
                        "inverse-on-surface": "#332f33",
                        "on-surface": "#e8e0e5",
                        "on-tertiary-fixed-variant": "#474746",
                        "tertiary-fixed-dim": "#c8c6c5",
                        "on-primary": "#452446",
                        "surface-container-lowest": "#100d10",
                        "tertiary-fixed": "#e5e2e1",
                        "background": "#151215",
                        "surface-container": "#221f22",
                        "on-tertiary": "#313030",
                        "surface": "#151215"
                    },
                    "fontFamily": {
                        "headline": ["Newsreader"],
                        "body": ["Manrope"],
                        "label": ["Manrope"]
                    }
                },
            },
        }
    </script>
<style>
        body {
            background-color: #151215;
            color: #e8e0e5;
            font-family: 'Manrope', sans-serif;
            overflow-x: hidden;
        }
        .grain {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            pointer-events: none;
            z-index: 9999;
            opacity: 0.02;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
        }
        .glass-panel {
            background: rgba(21, 18, 21, 0.6);
            backdrop-filter: blur(40px);
        }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-background text-on-background selection:bg-secondary/30">
<div class="grain"></div>
<!-- TopNavBar -->
<nav class="fixed top-0 w-full z-50 h-24 bg-[#151215]/80 backdrop-blur-xl flex justify-between items-center px-12 max-w-[1920px] mx-auto bg-gradient-to-b from-[#151215] to-transparent">
<div class="flex items-center gap-12">
<span class="text-3xl font-serif italic text-[#e8e0e5] tracking-tight">L'ESSENCE</span>
<div class="hidden md:flex gap-8">
<a class="text-[#e8e0e5]/70 hover:text-[#e8e0e5] transition-colors font-body text-sm tracking-[0.05em]" href="#">Home</a>
<a class="text-[#e9c176] border-b border-[#e9c176]/30 pb-1 font-body text-sm tracking-[0.05em]" href="#">Shop</a>
<a class="text-[#e8e0e5]/70 hover:text-[#e8e0e5] transition-colors font-body text-sm tracking-[0.05em]" href="#">Collections</a>
<a class="text-[#e8e0e5]/70 hover:text-[#e8e0e5] transition-colors font-body text-sm tracking-[0.05em]" href="#">About</a>
<a class="text-[#e8e0e5]/70 hover:text-[#e8e0e5] transition-colors font-body text-sm tracking-[0.05em]" href="#">Contact</a>
</div>
</div>
<div class="flex items-center gap-6">
<button class="material-symbols-outlined text-[#e8e0e5]/70 hover:text-[#e8e0e5] transition-colors">shopping_bag</button>
<button class="material-symbols-outlined text-[#e8e0e5]/70 hover:text-[#e8e0e5] transition-colors">person</button>
<button class="bg-[#e9c176] text-[#412d00] px-8 py-2 font-body text-xs tracking-[0.1em] uppercase hover:opacity-80 transition-opacity active:scale-95">Shop</button>
</div>
</nav>
<main class="pt-24 min-h-screen">
<!-- Hero Product Section -->
<div class="grid grid-cols-1 lg:grid-cols-12 min-h-[calc(100vh-96px)] items-stretch">
<!-- Left: High-end Asymmetric Image Showcase -->
<div class="lg:col-span-7 relative overflow-hidden bg-surface-container-low flex items-center justify-center p-12 lg:p-24">
<div class="absolute inset-0 bg-gradient-to-tr from-surface-container-lowest to-transparent opacity-50"></div>
<!-- Main Bottle Image -->
<div class="relative z-10 w-full max-w-2xl aspect-[3/4] shadow-[0_40px_100px_-20px_rgba(0,0,0,0.8)]">
<img class="w-full h-full object-cover" data-alt="Exquisite minimalist perfume bottle with thick glass base and golden liquid inside, set against a dark atmospheric background with soft dramatic rim lighting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCCUaaUQD4yKy0ASWx9e3lH_rk1wQeY33cBt9cB-ohK6ZZ-_46Qrow9hDoUAvpHOp5JVWeQA0j3oLn8CSG_lbfkSB5eJUS_Fyz9RBtb_m-2oZyAXxWD2koGztfZf_aMVkB39nVATV8WXLZMpg0R2s94kaMLPVTMM9IJMs6SpXp_LMsqfxuc5IzxkcMIM9hYIWdW5v8BoLJa1hxuhJD225P4Er22BnqQIuyp4rK1_W1IrjumYKIddhDNaWXDBj33TBibd02TXQ9TIPLe"/>
<!-- Overlapping Aesthetic Element -->
<div class="absolute -bottom-10 -right-10 w-48 h-64 border border-outline-variant/20 glass-panel hidden md:block">
<img class="w-full h-full object-cover opacity-60 mix-blend-screen" data-alt="Macro photography of delicate white orchid petals with dew drops, soft purple lighting, high luxury editorial style" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBXkLzMT_IE9O2IST8T-42P244Fp8Uu6tXFxb3t4Nz66dAwlZxrrq5puN8ZU8B5F-xpKlbV6oKxcqfS0DtudPDbaqWT86DbpevVY-L2OF4AS3IvAnFoBdy5-N3T70-9FOZhRq3gHY5-lEVSKSL_Va_l98lZA1ljIAmkfKviLeMvrFHxI3vCU6k1lZRHivMC6VXIkIlciOit9aKfdfjfkNhcEd9M9PCAzQULl8dj8Kva2pIb-wH-_4FRbWMJcddB2KYmMag0mOf6qXo0"/>
</div>
</div>
<!-- Large Decorative Text -->
<div class="absolute top-24 -left-12 rotate-90 origin-top-left">
<h2 class="text-display-lg font-headline text-[12rem] opacity-5 select-none pointer-events-none">NOCTURNE</h2>
</div>
</div>
<!-- Right: Content & Interaction -->
<div class="lg:col-span-5 flex flex-col justify-center px-8 lg:px-20 py-16 bg-surface">
<div class="max-w-md">
<p class="font-label text-secondary text-xs tracking-[0.3em] uppercase mb-4">Collection Privée</p>
<h1 class="font-headline text-5xl lg:text-7xl mb-6 leading-tight italic">Nocturne de l’Orchidée</h1>
<p class="font-body text-on-surface-variant text-lg leading-relaxed mb-8">
                        A deep, atmospheric scent inspired by rare nocturnal blooms. A symphony of shadow and light, captured in obsidian glass.
                    </p>
<div class="flex items-end gap-4 mb-12">
<span class="font-headline text-4xl text-on-surface">$245.00</span>
<span class="font-body text-on-surface-variant/50 text-sm mb-1">100ml / 3.4 fl.oz</span>
</div>
<!-- Olfactory Pyramid (Bento-lite) -->
<div class="grid grid-cols-3 gap-1 mb-12 border border-outline-variant/10">
<div class="p-4 bg-surface-container-low">
<span class="block font-label text-[10px] uppercase tracking-[0.2em] text-on-surface-variant mb-2">Top</span>
<span class="block font-body text-sm font-light">Black Pepper<br/>Bergamot</span>
</div>
<div class="p-4 bg-surface-container">
<span class="block font-label text-[10px] uppercase tracking-[0.2em] text-on-surface-variant mb-2">Heart</span>
<span class="block font-body text-sm font-light">Midnight Orchid<br/>Violet</span>
</div>
<div class="p-4 bg-surface-container-high">
<span class="block font-label text-[10px] uppercase tracking-[0.2em] text-on-surface-variant mb-2">Base</span>
<span class="block font-body text-sm font-light">Oud Wood<br/>Ambergris</span>
</div>
</div>
<!-- Main Action -->
<button class="w-full bg-secondary text-on-secondary py-5 font-label font-bold tracking-[0.2em] uppercase hover:bg-secondary-fixed transition-all duration-500 active:scale-[0.98] mb-12">
                        Add to Bag
                    </button>
<!-- Accordions -->
<div class="space-y-6">
<details class="group border-b border-outline-variant/20 pb-4" open="">
<summary class="flex justify-between items-center cursor-pointer list-none">
<span class="font-label text-xs uppercase tracking-[0.2em]">Ingredients</span>
<span class="material-symbols-outlined transition-transform group-open:rotate-180">expand_more</span>
</summary>
<div class="pt-4 font-body text-sm text-on-surface-variant leading-relaxed">
                                Alcohol Denat, Fragrance (Parfum), Aqua (Water), Limonene, Linalool, Citronellol, Rare Orchid Extract, Sustainably Sourced Oud Oil.
                            </div>
</details>
<details class="group border-b border-outline-variant/20 pb-4">
<summary class="flex justify-between items-center cursor-pointer list-none">
<span class="font-label text-xs uppercase tracking-[0.2em]">Shipping &amp; Returns</span>
<span class="material-symbols-outlined transition-transform group-open:rotate-180">expand_more</span>
</summary>
<div class="pt-4 font-body text-sm text-on-surface-variant leading-relaxed">
                                Complimentary worldwide shipping on all orders over $200. Signature gift wrapping included. Returns accepted within 14 days of delivery.
                            </div>
</details>
</div>
</div>
</div>
</div>
<!-- You May Also Like Section -->
<section class="py-24 bg-surface-container-lowest overflow-hidden">
<div class="px-12 mb-12 flex justify-between items-end">
<div>
<h3 class="font-headline text-4xl italic">You May Also Like</h3>
<div class="h-px w-24 bg-secondary mt-4"></div>
</div>
<div class="flex gap-4">
<button class="w-12 h-12 border border-outline-variant/30 flex items-center justify-center hover:bg-surface-container transition-colors">
<span class="material-symbols-outlined">chevron_left</span>
</button>
<button class="w-12 h-12 border border-outline-variant/30 flex items-center justify-center hover:bg-surface-container transition-colors">
<span class="material-symbols-outlined">chevron_right</span>
</button>
</div>
</div>
<div class="flex gap-8 overflow-x-auto no-scrollbar px-12 pb-8">
<!-- Product Card 1 -->
<div class="min-w-[320px] group cursor-pointer">
<div class="relative aspect-[4/5] bg-surface-container-low mb-6 overflow-hidden">
<img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" data-alt="Elegant tall perfume bottle with silver cap on a dark stone surface, moody lighting with blue undertones" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBK-t-B4XIOjdTXHlB2dh-iUdWVJLyyBsCWFmuFoZ8PuAwVdptiET_mbBOZt6ubVsk3qjfKUP0h257xQ2d86AAD5ayOF6RpfQCeiaeem_q7OZpyWjG-ECJwV-eI6_C8EK9RsnOgn9bSHktXdO8CnQ9qvX0sLK7BNAJSiNmvZBo2e-J2YKNQvjWvRNhnLJE8McBEYIiTPklKf8oixUEan4rUkzOcP8nQxqxREA9J-xUmIdkxxZHLTSXK7eUKLUYQV2G6rKinrvBtx_yZ"/>
<div class="absolute inset-0 bg-surface-container-highest/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
</div>
<span class="font-label text-[10px] uppercase tracking-[0.2em] text-on-surface-variant">Oriental • Woody</span>
<h4 class="font-headline text-xl mt-2">Ambre Gris</h4>
<p class="font-body text-sm text-secondary mt-1">$195.00</p>
</div>
<!-- Product Card 2 -->
<div class="min-w-[320px] group cursor-pointer">
<div class="relative aspect-[4/5] bg-surface-container-low mb-6 overflow-hidden">
<img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" data-alt="Luxury perfume bottle in warm sunset lighting, amber tones, soft bokeh background" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD-v9ka-UIPUotN22MsNHrOmkNsLuwgF7RLNcgyJRDc06_MvouZzROyEUlq_Dz3VIhHPuG9p54zSIo18ZTgcOP_CGBGcgsXKrX7s2wE5MUk7kyxSpBxr6TtPworKA6scR6V9Ouw0aQOVH18RLEVikNUPYj52aIa5VQ2-8vJUYe7NWtMhywOknPeV4e1f65f9mExEC02rh6aFucSL96O26R8MM9L3GyXAJOPTLkSP0Jjn7cQ3yr4sF0HFve7ZAzhfHDOZx8xvC8gU32K"/>
<div class="absolute inset-0 bg-surface-container-highest/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
</div>
<span class="font-label text-[10px] uppercase tracking-[0.2em] text-on-surface-variant">Spicy • Warm</span>
<h4 class="font-headline text-xl mt-2">Santal d’Or</h4>
<p class="font-body text-sm text-secondary mt-1">$210.00</p>
</div>
<!-- Product Card 3 -->
<div class="min-w-[320px] group cursor-pointer">
<div class="relative aspect-[4/5] bg-surface-container-low mb-6 overflow-hidden">
<img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" data-alt="Minimalist perfume bottle with black label on dark background, sharp contrast, luxury photography" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA4vqn3lWDHsIFLAIC2nUG0CCnekJtXuWQbkMTMaciWduWlyFYFq7VZNPfMWT0WrkkG7cvw7KZMlz1pVBlh1fMm1FUC3o6gqJ0-KbFxGpY0z7pnFIpVUCsIxNJbhdXdGRGnsPM5ocMw0wCKpG7wLUgXTKeC3vrAk1KO25aZh7nmn983s1AZCB46sJFbi0-pSPMBJCTQgIf2BURlVdRetwn5jaAm1zKT_4mTmW3baoAZXSzx36aLzewfZODlxAcGv6BFxgieUXztEltt"/>
<div class="absolute inset-0 bg-surface-container-highest/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
</div>
<span class="font-label text-[10px] uppercase tracking-[0.2em] text-on-surface-variant">Floral • Fresh</span>
<h4 class="font-headline text-xl mt-2">Violette Noire</h4>
<p class="font-body text-sm text-secondary mt-1">$185.00</p>
</div>
<!-- Product Card 4 -->
<div class="min-w-[320px] group cursor-pointer">
<div class="relative aspect-[4/5] bg-surface-container-low mb-6 overflow-hidden">
<img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" data-alt="Square heavy glass perfume bottle, warm golden liquid, elegant typography on label" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCTdE3P8vKxoNvKSIKjZOY4Zmh-6dGSp79S4JzIS_afbI-a-sA3ebST3q_UPW9nnPLYt-up3TOsN4IZQ6u3pR3vuFlhnwW8jmg4ad37il-w2uPpr16zKXMcb9VBzKuOvRcPOXLs_Nt_kWil18h94OgREHLwxnnXMnQwQWnRtKgj-mIG9vtKw8zwzxQPwBEIsDoTnGoSd8vJIt5Vf-VwgQSJJN8rPeJffU0bXAxluZ_LqevS5uXGT8r_8oJYWZmvXJ0YgQX9H6RQyoe9"/>
<div class="absolute inset-0 bg-surface-container-highest/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
</div>
<span class="font-label text-[10px] uppercase tracking-[0.2em] text-on-surface-variant">Musk • Powder</span>
<h4 class="font-headline text-xl mt-2">Poudre Blanche</h4>
<p class="font-body text-sm text-secondary mt-1">$230.00</p>
</div>
</div>
</section>
</main>
<!-- Footer -->
<footer class="w-full pt-20 pb-10 border-t border-[#383437]/10 bg-[#100d10]">
<div class="grid grid-cols-1 md:grid-cols-4 gap-12 px-12 max-w-7xl mx-auto">
<div class="col-span-1 md:col-span-2">
<span class="text-xl font-serif text-[#e8e0e5] mb-6 block">L'ESSENCE</span>
<p class="font-body text-on-surface-variant text-sm max-w-sm mb-8 leading-loose opacity-60">
                    Crafting olfactory experiences that linger in the soul. Our fragrances are designed for those who find beauty in the shadows.
                </p>
<div class="flex gap-6">
<a class="material-symbols-outlined text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors" href="#">brand_awareness</a>
<a class="material-symbols-outlined text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors" href="#">alternate_email</a>
<a class="material-symbols-outlined text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors" href="#">public</a>
</div>
</div>
<div>
<h5 class="font-label text-[10px] uppercase tracking-[0.2em] text-[#e9c176] mb-8">Navigation</h5>
<ul class="space-y-4">
<li><a class="text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors text-xs uppercase tracking-widest" href="#">Shop All</a></li>
<li><a class="text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors text-xs uppercase tracking-widest" href="#">Collections</a></li>
<li><a class="text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors text-xs uppercase tracking-widest" href="#">Bespoke Services</a></li>
<li><a class="text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors text-xs uppercase tracking-widest" href="#">Store Locator</a></li>
</ul>
</div>
<div>
<h5 class="font-label text-[10px] uppercase tracking-[0.2em] text-[#e9c176] mb-8">Client Care</h5>
<ul class="space-y-4">
<li><a class="text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors text-xs uppercase tracking-widest" href="#">Privacy Policy</a></li>
<li><a class="text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors text-xs uppercase tracking-widest" href="#">Terms of Service</a></li>
<li><a class="text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors text-xs uppercase tracking-widest" href="#">Shipping &amp; Returns</a></li>
<li><a class="text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors text-xs uppercase tracking-widest" href="#">Wholesale</a></li>
</ul>
</div>
</div>
<div class="mt-20 px-12 max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-8 pt-8 border-t border-[#383437]/10">
<span class="font-label text-[10px] uppercase tracking-[0.2em] text-[#e8e0e5]/50">© 2024 L'ESSENCE PERFUMES. ALL RIGHTS RESERVED.</span>
<div class="flex gap-8 text-[10px] uppercase tracking-[0.2em] text-[#e8e0e5]/30">
<span>Designed in Paris</span>
<span>Crafted in Grasse</span>
</div>
</div>
</footer>
</body></html>



Checkout - L'ESSENCE
<!DOCTYPE html>

<html class="dark" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Checkout | L'ESSENCE</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,200..800;1,6..72,200..800&amp;family=Manrope:wght@200..800&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "inverse-primary": "#775276",
                        "secondary": "#e9c176",
                        "surface-container-low": "#1e1b1e",
                        "tertiary": "#c8c6c5",
                        "primary-fixed": "#ffd6fa",
                        "on-primary-fixed-variant": "#5e3b5e",
                        "secondary-container": "#604403",
                        "primary-container": "#341536",
                        "on-secondary": "#412d00",
                        "on-background": "#e8e0e5",
                        "surface-dim": "#151215",
                        "on-error": "#690005",
                        "surface-variant": "#383437",
                        "error-container": "#93000a",
                        "on-secondary-container": "#dab36a",
                        "on-primary-container": "#a47ba2",
                        "on-secondary-fixed": "#261900",
                        "on-primary-fixed": "#2e0f30",
                        "on-error-container": "#ffdad6",
                        "primary": "#e6b8e2",
                        "on-tertiary-fixed": "#1c1b1b",
                        "on-tertiary-container": "#8a8888",
                        "surface-container-high": "#2d292c",
                        "tertiary-container": "#212121",
                        "surface-bright": "#3c383b",
                        "primary-fixed-dim": "#e6b8e2",
                        "surface-container-highest": "#383437",
                        "secondary-fixed-dim": "#e9c176",
                        "on-secondary-fixed-variant": "#5d4201",
                        "secondary-fixed": "#ffdea5",
                        "surface-tint": "#e6b8e2",
                        "on-surface-variant": "#cfc3ca",
                        "error": "#ffb4ab",
                        "outline-variant": "#4c454a",
                        "outline": "#988e94",
                        "inverse-surface": "#e8e0e5",
                        "inverse-on-surface": "#332f33",
                        "on-surface": "#e8e0e5",
                        "on-tertiary-fixed-variant": "#474746",
                        "tertiary-fixed-dim": "#c8c6c5",
                        "on-primary": "#452446",
                        "surface-container-lowest": "#100d10",
                        "tertiary-fixed": "#e5e2e1",
                        "background": "#151215",
                        "surface-container": "#221f22",
                        "on-tertiary": "#313030",
                        "surface": "#151215"
                    },
                    "borderRadius": {
                        "DEFAULT": "0px",
                        "lg": "0px",
                        "xl": "0px",
                        "full": "9999px"
                    },
                    "fontFamily": {
                        "headline": ["Newsreader"],
                        "body": ["Manrope"],
                        "label": ["Manrope"]
                    }
                },
            },
        }
    </script>
<style>
        body {
            background-color: #151215;
            color: #e8e0e5;
            font-family: 'Manrope', sans-serif;
        }
        .font-serif { font-family: 'Newsreader', serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
        }
        input:focus {
            outline: none !important;
            box-shadow: none !important;
            border-color: #e9c176 !important;
        }
        /* Custom Noise Texture */
        .noise-overlay::before {
            content: "";
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
            opacity: 0.02;
            pointer-events: none;
            z-index: 9999;
        }
    </style>
</head>
<body class="noise-overlay">
<!-- TopNavBar -->
<nav class="fixed top-0 w-full z-50 h-24 bg-[#151215]/80 backdrop-blur-xl flex justify-between items-center px-12 max-w-[1920px] mx-auto">
<div class="text-3xl font-serif italic text-[#e8e0e5] tracking-tight">L'ESSENCE</div>
<div class="hidden md:flex items-center gap-8">
<a class="font-label text-sm tracking-[0.05em] text-[#e8e0e5]/70 hover:text-[#e8e0e5] transition-colors" href="#">Home</a>
<a class="font-label text-sm tracking-[0.05em] text-[#e9c176] border-b border-[#e9c176]/30 pb-1" href="#">Shop</a>
<a class="font-label text-sm tracking-[0.05em] text-[#e8e0e5]/70 hover:text-[#e8e0e5] transition-colors" href="#">Collections</a>
<a class="font-label text-sm tracking-[0.05em] text-[#e8e0e5]/70 hover:text-[#e8e0e5] transition-colors" href="#">About</a>
<a class="font-label text-sm tracking-[0.05em] text-[#e8e0e5]/70 hover:text-[#e8e0e5] transition-colors" href="#">Contact</a>
</div>
<div class="flex items-center gap-6 text-[#e9c176]">
<button class="hover:opacity-80 transition-opacity"><span class="material-symbols-outlined" data-icon="shopping_bag">shopping_bag</span></button>
<button class="hover:opacity-80 transition-opacity"><span class="material-symbols-outlined" data-icon="person">person</span></button>
</div>
</nav>
<main class="pt-32 pb-24 px-6 md:px-12 max-w-7xl mx-auto">
<div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
<!-- Left: Shipping and Payment -->
<div class="lg:col-span-7 space-y-16">
<div>
<h1 class="text-4xl font-serif mb-12 text-on-surface">Secure Checkout</h1>
<!-- Contact Information -->
<section class="space-y-8 mb-16">
<h2 class="font-serif text-xl tracking-wide border-b border-outline-variant/10 pb-4">Contact Information</h2>
<div class="grid grid-cols-1 gap-6">
<div class="relative">
<label class="text-[10px] uppercase tracking-[0.2em] text-on-surface-variant block mb-2">Email Address</label>
<input class="w-full bg-transparent border-t-0 border-x-0 border-b border-outline-variant/20 py-3 text-on-surface placeholder:text-on-surface-variant/30 focus:border-secondary transition-all" placeholder="julian@example.com" type="email"/>
</div>
</div>
</section>
<!-- Shipping Address -->
<section class="space-y-8 mb-16">
<h2 class="font-serif text-xl tracking-wide border-b border-outline-variant/10 pb-4">Shipping Destination</h2>
<div class="grid grid-cols-2 gap-6">
<div class="col-span-1">
<label class="text-[10px] uppercase tracking-[0.2em] text-on-surface-variant block mb-2">First Name</label>
<input class="w-full bg-transparent border-t-0 border-x-0 border-b border-outline-variant/20 py-3 text-on-surface focus:border-secondary transition-all" type="text"/>
</div>
<div class="col-span-1">
<label class="text-[10px] uppercase tracking-[0.2em] text-on-surface-variant block mb-2">Last Name</label>
<input class="w-full bg-transparent border-t-0 border-x-0 border-b border-outline-variant/20 py-3 text-on-surface focus:border-secondary transition-all" type="text"/>
</div>
<div class="col-span-2">
<label class="text-[10px] uppercase tracking-[0.2em] text-on-surface-variant block mb-2">Address</label>
<input class="w-full bg-transparent border-t-0 border-x-0 border-b border-outline-variant/20 py-3 text-on-surface focus:border-secondary transition-all" placeholder="123 Atelier Street" type="text"/>
</div>
<div class="col-span-1">
<label class="text-[10px] uppercase tracking-[0.2em] text-on-surface-variant block mb-2">City</label>
<input class="w-full bg-transparent border-t-0 border-x-0 border-b border-outline-variant/20 py-3 text-on-surface focus:border-secondary transition-all" type="text"/>
</div>
<div class="col-span-1">
<label class="text-[10px] uppercase tracking-[0.2em] text-on-surface-variant block mb-2">Postal Code</label>
<input class="w-full bg-transparent border-t-0 border-x-0 border-b border-outline-variant/20 py-3 text-on-surface focus:border-secondary transition-all" type="text"/>
</div>
</div>
</section>
<!-- Payment Details -->
<section class="space-y-8">
<h2 class="font-serif text-xl tracking-wide border-b border-outline-variant/10 pb-4">Payment Method</h2>
<div class="bg-surface-container-lowest p-8 border border-outline-variant/5">
<div class="grid grid-cols-2 gap-6">
<div class="col-span-2">
<label class="text-[10px] uppercase tracking-[0.2em] text-on-surface-variant block mb-2">Card Number</label>
<div class="relative">
<input class="w-full bg-transparent border-t-0 border-x-0 border-b border-outline-variant/20 py-3 text-on-surface focus:border-secondary transition-all" placeholder="0000 0000 0000 0000" type="text"/>
<span class="absolute right-0 top-3 material-symbols-outlined text-on-surface-variant/50" data-icon="credit_card">credit_card</span>
</div>
</div>
<div class="col-span-1">
<label class="text-[10px] uppercase tracking-[0.2em] text-on-surface-variant block mb-2">Expiry Date</label>
<input class="w-full bg-transparent border-t-0 border-x-0 border-b border-outline-variant/20 py-3 text-on-surface focus:border-secondary transition-all" placeholder="MM/YY" type="text"/>
</div>
<div class="col-span-1">
<label class="text-[10px] uppercase tracking-[0.2em] text-on-surface-variant block mb-2">CVV</label>
<input class="w-full bg-transparent border-t-0 border-x-0 border-b border-outline-variant/20 py-3 text-on-surface focus:border-secondary transition-all" placeholder="***" type="text"/>
</div>
</div>
</div>
</section>
</div>
</div>
<!-- Right: Order Summary -->
<div class="lg:col-span-5">
<div class="sticky top-32 bg-surface-container-low p-10 border border-outline-variant/5">
<h3 class="font-serif text-2xl mb-10">Order Summary</h3>
<div class="space-y-8 mb-10">
<!-- Product 1 -->
<div class="flex gap-6">
<div class="w-24 h-32 bg-surface-container-high overflow-hidden">
<img alt="Noir Essence" class="w-full h-full object-cover grayscale opacity-80 hover:grayscale-0 transition-all duration-700" data-alt="luxury perfume bottle with dark liquid on a black marble surface with dramatic soft lighting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCUWnCTpiysKptlGdnLNpDCTJ5dbzON1n-OrOcnFAv-n9zYY3N_8CYAuPsuz4CwNUVowora7ypmcU_mm1HW9QW-uL3DlYT8Hn9CyOl4ASKMZUITa2Fh5T5t8FRsmEgB08SjhIK7QNoDR0kgVgWEkyMz0bVIFuG5dvpInArVBnnTWqB1fZhVecteRic6XP6YWcqM5AoJYnZ6vLmpdAn6Zx82W3srxLWxXTnEUXklZnPg-f_5nPvSRyX-bW37_-HOrxe7bjvUDN04MueH"/>
</div>
<div class="flex-1 flex flex-col justify-center">
<span class="text-[10px] uppercase tracking-[0.2em] text-secondary mb-1">Eau de Parfum</span>
<h4 class="font-serif text-lg">Noir Essence, 100ml</h4>
<p class="text-sm text-on-surface-variant mt-1">Quantity: 1</p>
<span class="text-sm font-medium mt-auto">$245.00</span>
</div>
</div>
<!-- Product 2 -->
<div class="flex gap-6">
<div class="w-24 h-32 bg-surface-container-high overflow-hidden">
<img alt="Velvet Oud" class="w-full h-full object-cover grayscale opacity-80 hover:grayscale-0 transition-all duration-700" data-alt="artisanal fragrance bottle with gold accents in a moody atmospheric setting with smoke wisps" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA0UNw4njC1_tm09NQfnMVzEAVGbYWfVttO_bl-uhkWcw8_BVI6O8XWpwIhJzWuuSozmpgZl6E8FZFp5FS8tUUvXN-hMOzffCKmzj0JcT7QTxhNI3Ul1aoFY1A9qHTG8w3mvHnUCZ1P8ZwTb7JhSD7UIcy8VsKo1IBO5TNYZCN82Yj9_u6qlCOO5xUwHl9kwfGLf5uaHk91ax8FBaw-VaKeNdSsUK-6-qcTBEFsXS5AWb2GVkEVbX8A9rlGssjlNKLQ8Pw0ZcjtxYiN"/>
</div>
<div class="flex-1 flex flex-col justify-center">
<span class="text-[10px] uppercase tracking-[0.2em] text-secondary mb-1">Signature Collection</span>
<h4 class="font-serif text-lg">Velvet Oud, 50ml</h4>
<p class="text-sm text-on-surface-variant mt-1">Quantity: 1</p>
<span class="text-sm font-medium mt-auto">$185.00</span>
</div>
</div>
</div>
<div class="border-t border-outline-variant/10 pt-8 space-y-4">
<div class="flex justify-between text-sm text-on-surface-variant">
<span>Subtotal</span>
<span>$430.00</span>
</div>
<div class="flex justify-between text-sm text-on-surface-variant">
<span>Shipping (Express)</span>
<span>$15.00</span>
</div>
<div class="flex justify-between text-sm text-on-surface-variant">
<span>Taxes</span>
<span>$34.40</span>
</div>
<div class="flex justify-between text-xl font-serif pt-4 text-on-surface">
<span>Total</span>
<span class="text-secondary">$479.40</span>
</div>
</div>
<button class="w-full mt-12 bg-secondary text-on-secondary py-5 text-sm uppercase tracking-[0.25em] font-bold hover:bg-secondary-fixed transition-all active:scale-[0.98]">
                        Complete Purchase
                    </button>
<p class="mt-6 text-center text-[10px] text-on-surface-variant/60 uppercase tracking-widest flex items-center justify-center gap-2">
<span class="material-symbols-outlined text-xs" data-icon="lock">lock</span>
                        Encrypted &amp; Secure Checkout
                    </p>
</div>
</div>
</div>
</main>
<!-- Footer -->
<footer class="w-full pt-20 pb-10 border-t border-[#383437]/10 bg-[#100d10]">
<div class="grid grid-cols-1 md:grid-cols-4 gap-12 px-12 max-w-7xl mx-auto">
<div class="space-y-6">
<div class="text-xl font-serif text-[#e8e0e5]">L'ESSENCE</div>
<p class="text-[10px] text-[#e8e0e5]/50 leading-loose tracking-[0.05em]">
                    CRAFTING OLFACTORY ART FOR THE DISCERNING SOUL. BORN IN PARIS, AGED IN OBSIDIAN.
                </p>
</div>
<div class="flex flex-col gap-4">
<span class="text-[10px] uppercase tracking-[0.2em] text-[#e9c176] mb-2">Explore</span>
<a class="text-[10px] uppercase tracking-[0.2em] text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors duration-500" href="#">Shop All</a>
<a class="text-[10px] uppercase tracking-[0.2em] text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors duration-500" href="#">Boutiques</a>
<a class="text-[10px] uppercase tracking-[0.2em] text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors duration-500" href="#">Fragrance Finder</a>
</div>
<div class="flex flex-col gap-4">
<span class="text-[10px] uppercase tracking-[0.2em] text-[#e9c176] mb-2">Legal</span>
<a class="text-[10px] uppercase tracking-[0.2em] text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors duration-500" href="#">Privacy Policy</a>
<a class="text-[10px] uppercase tracking-[0.2em] text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors duration-500" href="#">Terms of Service</a>
<a class="text-[10px] uppercase tracking-[0.2em] text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors duration-500" href="#">Shipping &amp; Returns</a>
</div>
<div class="flex flex-col gap-4">
<span class="text-[10px] uppercase tracking-[0.2em] text-[#e9c176] mb-2">Connect</span>
<a class="text-[10px] uppercase tracking-[0.2em] text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors duration-500" href="#">Instagram</a>
<a class="text-[10px] uppercase tracking-[0.2em] text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors duration-500" href="#">Newsletter</a>
<a class="text-[10px] uppercase tracking-[0.2em] text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors duration-500" href="#">Concierge</a>
</div>
</div>
<div class="mt-20 text-center border-t border-[#383437]/10 pt-10">
<p class="text-[10px] uppercase tracking-[0.2em] text-[#e8e0e5]/30">© 2024 L'ESSENCE PERFUMES. ALL RIGHTS RESERVED.</p>
</div>
</footer>
</body></html>




Our Story - L'ESSENCE
<!DOCTYPE html>

<html class="dark" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,200..800;1,6..72,200..800&amp;family=Manrope:wght@200..800&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "inverse-primary": "#775276",
                    "secondary": "#e9c176",
                    "surface-container-low": "#1e1b1e",
                    "tertiary": "#c8c6c5",
                    "primary-fixed": "#ffd6fa",
                    "on-primary-fixed-variant": "#5e3b5e",
                    "secondary-container": "#604403",
                    "primary-container": "#341536",
                    "on-secondary": "#412d00",
                    "on-background": "#e8e0e5",
                    "surface-dim": "#151215",
                    "on-error": "#690005",
                    "surface-variant": "#383437",
                    "error-container": "#93000a",
                    "on-secondary-container": "#dab36a",
                    "on-primary-container": "#a47ba2",
                    "on-secondary-fixed": "#261900",
                    "on-primary-fixed": "#2e0f30",
                    "on-error-container": "#ffdad6",
                    "primary": "#e6b8e2",
                    "on-tertiary-fixed": "#1c1b1b",
                    "on-tertiary-container": "#8a8888",
                    "surface-container-high": "#2d292c",
                    "tertiary-container": "#212121",
                    "surface-bright": "#3c383b",
                    "primary-fixed-dim": "#e6b8e2",
                    "surface-container-highest": "#383437",
                    "secondary-fixed-dim": "#e9c176",
                    "on-secondary-fixed-variant": "#5d4201",
                    "secondary-fixed": "#ffdea5",
                    "surface-tint": "#e6b8e2",
                    "on-surface-variant": "#cfc3ca",
                    "error": "#ffb4ab",
                    "outline-variant": "#4c454a",
                    "outline": "#988e94",
                    "inverse-surface": "#e8e0e5",
                    "inverse-on-surface": "#332f33",
                    "on-surface": "#e8e0e5",
                    "on-tertiary-fixed-variant": "#474746",
                    "tertiary-fixed-dim": "#c8c6c5",
                    "on-primary": "#452446",
                    "surface-container-lowest": "#100d10",
                    "tertiary-fixed": "#e5e2e1",
                    "background": "#151215",
                    "surface-container": "#221f22",
                    "on-tertiary": "#313030",
                    "surface": "#151215"
            },
            "borderRadius": {
                    "DEFAULT": "0px",
                    "lg": "0px",
                    "xl": "0px",
                    "full": "9999px"
            },
            "fontFamily": {
                    "headline": ["Newsreader", "serif"],
                    "body": ["Manrope", "sans-serif"],
                    "label": ["Manrope", "sans-serif"]
            }
          },
        },
      }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
        }
        .noise-overlay {
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
            opacity: 0.02;
            pointer-events: none;
        }
    </style>
</head>
<body class="bg-background text-on-background font-body selection:bg-secondary/30">
<div class="fixed inset-0 noise-overlay z-[100]"></div>
<!-- TopNavBar -->
<nav class="fixed top-0 w-full z-50 h-24 bg-[#151215]/80 backdrop-blur-xl flex justify-between items-center px-12 max-w-[1920px] mx-auto transition-all duration-300">
<div class="flex items-center gap-12">
<span class="text-3xl font-serif italic text-[#e8e0e5] tracking-tight">L'ESSENCE</span>
<div class="hidden md:flex gap-8 items-center">
<a class="text-[#e8e0e5]/70 hover:text-[#e8e0e5] transition-colors font-label text-sm tracking-[0.05em]" href="#">Home</a>
<a class="text-[#e8e0e5]/70 hover:text-[#e8e0e5] transition-colors font-label text-sm tracking-[0.05em]" href="#">Shop</a>
<a class="text-[#e8e0e5]/70 hover:text-[#e8e0e5] transition-colors font-label text-sm tracking-[0.05em]" href="#">Collections</a>
<a class="text-[#e9c176] border-b border-[#e9c176]/30 pb-1 font-label text-sm tracking-[0.05em]" href="#">About</a>
<a class="text-[#e8e0e5]/70 hover:text-[#e8e0e5] transition-colors font-label text-sm tracking-[0.05em]" href="#">Contact</a>
</div>
</div>
<div class="flex items-center gap-6">
<button class="hover:opacity-80 transition-opacity duration-300">
<span class="material-symbols-outlined text-[#e8e0e5]">shopping_bag</span>
</button>
<button class="hover:opacity-80 transition-opacity duration-300">
<span class="material-symbols-outlined text-[#e8e0e5]">person</span>
</button>
<button class="hidden md:block bg-secondary text-on-secondary px-8 py-2 font-label text-sm tracking-[0.1em] hover:opacity-90 active:scale-95 transition-all">
                Shop
            </button>
</div>
</nav>
<main class="pt-24">
<!-- Hero Section -->
<section class="relative h-[921px] flex items-center px-12 overflow-hidden">
<div class="absolute inset-0 z-0">
<img alt="Artisan perfumer" class="w-full h-full object-cover opacity-50 grayscale contrast-125" data-alt="Moody black and white close-up of a master perfumer's hands carefully measuring amber liquid into a crystal vial, soft cinematic lighting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDGfw3ecqBeETuolNAZZQq71RlajLNVWU0zZss6HbuWyuYY-tmMHKCxgd4t1DgactfAkS5_vMBiVvlv4sFiYERREMEeh_LIEEdn6rZ3UKSKSqf47f23od7Axxhfnb2tYA8y0sejmWGckKYC1L436amMZYv-CDb3ukx6kA1pYQagq55fPgumbLZtjdI5KOiwqkGCFaYdaJwWC7WhHwzq2ZmEfK73akNQMcxu12qHS8USm88TNiKYAwuRYcgsyKFKmKKJD6MxCb6ymsz0"/>
<div class="absolute inset-0 bg-gradient-to-r from-background via-background/40 to-transparent"></div>
</div>
<div class="relative z-10 max-w-4xl">
<span class="font-label text-secondary tracking-[0.3em] uppercase text-xs mb-6 block">Our Heritage</span>
<h1 class="font-headline text-7xl md:text-9xl text-on-background leading-none mb-8">The Silent <br/><span class="italic text-secondary">Soul</span> of Scent</h1>
<p class="font-body text-xl text-on-surface-variant max-w-xl leading-relaxed font-light tracking-wide">
                    Born in the limestone hills of Grasse and refined in the obsidian shadows of Parisian nights, L'Essence represents the intersection of ancestral alchemy and modern desire.
                </p>
</div>
</section>
<!-- The Story Section: Asymmetric Editorial -->
<section class="py-32 px-12 max-w-7xl mx-auto">
<div class="grid grid-cols-1 md:grid-cols-12 gap-12 items-center">
<div class="md:col-span-5 relative">
<img alt="Vintage perfume lab" class="w-full grayscale brightness-75" data-alt="Sepia toned vintage laboratory setup with glass beakers, dried botanicals, and handwritten parchment formulas on a dark wood table" src="https://lh3.googleusercontent.com/aida-public/AB6AXuARxJGBuD1vygS3nRIEGh20Mm2qovnDPyqk889Sb3suPxtqL0Xgi6djBVE8TeZ1a_w98mLpDn2QkYO73MANGoLsAocmOMSeBhD8-Ua4xxJ4Lde2rbjDL_Dv-r0QMxHF6u4Dj4EHwUNcXiOGcnDSmGSwhDw8wddGFj6DTw2kbRf7jYPywX84kxydpdTJSX2nqoUaXT2aadTTBMrsT5XaInyfbyPQDp9Ni7jb57BB9RZ95KZb0iq42JnAZ67kCrhF29nEC5XxdYVb9vlT"/>
<div class="absolute -bottom-8 -right-8 bg-surface-container-high p-8 hidden md:block">
<p class="font-headline text-3xl italic text-on-surface leading-tight">"A fragrance <br/>is a memory <br/>unspoken."</p>
</div>
</div>
<div class="md:col-start-7 md:col-span-6">
<h2 class="font-headline text-5xl mb-12 text-on-background">Crafted in Shadows</h2>
<div class="space-y-8 font-body text-on-surface-variant leading-loose tracking-wide">
<p>Established in 1924, L'Essence began as a private apothecary catering to the avant-garde elite of the roaring twenties. While the world looked toward synthetic reproduction, we remained anchored in the physical—the soil, the root, and the resin.</p>
<p>Our process is one of patient extraction. We believe that true luxury cannot be hurried. It is matured in oak, distilled in glass, and preserved in the dark.</p>
<div class="pt-8">
<a class="inline-flex items-center gap-4 text-secondary font-label tracking-widest text-xs uppercase group" href="#">
                                Explore Our Archives
                                <span class="material-symbols-outlined text-sm group-hover:translate-x-2 transition-transform">arrow_forward</span>
</a>
</div>
</div>
</div>
</div>
</section>
<!-- Large Quote Break -->
<section class="bg-surface-container-lowest py-40 px-12 text-center border-y border-outline-variant/10">
<div class="max-w-5xl mx-auto">
<blockquote class="font-headline text-5xl md:text-7xl italic text-on-background leading-tight">
                    "We do not create perfumes to mask the wearer, but to unveil the <span class="text-secondary">architectural truth</span> of their character."
                </blockquote>
<cite class="font-label text-outline tracking-[0.2em] uppercase text-xs mt-12 block">— Julian Vane, Master Perfumer</cite>
</div>
</section>
<!-- Craftsmanship Grid -->
<section class="py-32 px-12 bg-background">
<div class="max-w-7xl mx-auto">
<div class="flex flex-col md:flex-row justify-between items-end mb-24 gap-8">
<div class="max-w-2xl">
<span class="font-label text-secondary tracking-[0.3em] uppercase text-xs mb-4 block">The Process</span>
<h2 class="font-headline text-6xl text-on-background">Alchemy &amp; Ethics</h2>
</div>
<p class="font-body text-on-surface-variant max-w-sm text-sm tracking-wider leading-relaxed">
                        Sustainable sourcing is not a trend for us; it is the preservation of the medium we love. 
                    </p>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-px bg-outline-variant/10">
<div class="bg-background p-12 space-y-8 group transition-colors hover:bg-surface-container-low">
<img alt="Botanical extraction" class="w-full aspect-square object-cover grayscale opacity-60 group-hover:opacity-90 transition-opacity" data-alt="High contrast black and white shot of dark flower petals swirling in clear water, artistic macro photography" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDieMHwAzBg7bfF0FPCwVm4MD1IsMzRd5-DGsz68HXmXyWsiITBGAy1x_WwvZoQx02MPsaYw91ri91Da7nKJ-z0psBuNMj2PbMkxwEuGJoP7DLTFgiUu83Z21HuwF_HFnU-yI9IW7p_aNIxD77kjzO1hZUpfQ1od9YkX-JlrR3jMrcIg7NAuTOCdiQcU0AXhWvs7ihPTtMn33mCQhGaelxUNPkhpzibLGpVsSw8CqRqDV3F8o60u34EcjhpUk_n6pyrhISvNY3H9vQE"/>
<h3 class="font-headline text-3xl">Botanical Integrity</h3>
<p class="font-body text-on-surface-variant text-sm leading-relaxed">We work directly with small-batch flower farms from the Grasse region to ensure the molecular purity of every petal.</p>
</div>
<div class="bg-background p-12 space-y-8 group transition-colors hover:bg-surface-container-low">
<img alt="Crystal vials" class="w-full aspect-square object-cover grayscale opacity-60 group-hover:opacity-90 transition-opacity" data-alt="Row of heavy glass perfume bottles on a dark stone surface, low key lighting, deep shadows and sharp highlights" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAKTO_V4675oIxBnS0k2T-5o52oMugq3gJBzxYhfE3DpXvG8k4bCdufWR9Zs-xGv4GCI2wZlfSEQo9l2O7wboyOKbCnorDYbyqKCQuyuZxAWktIn8uhIcob0bsHgv_EmwykQpg91CRxXFRjoswYaM-ubYvPtMZhX9cmUS-BP0muYW50szYwqTn7vWizmaBHVZ_TJIHP8eCOMC257-9xkt1b1DCK6cbmxcYeTHXEb-9MKbRLEpVGpzGhs2xuwhjI9_QcAbLS05nkSYHy"/>
<h3 class="font-headline text-3xl">Glass Craft</h3>
<p class="font-body text-on-surface-variant text-sm leading-relaxed">Our obsidian-glass bottles are hand-poured by traditional glassblowers in Normandy, designed to be kept for a lifetime.</p>
</div>
<div class="bg-background p-12 space-y-8 group transition-colors hover:bg-surface-container-low">
<img alt="Smudging oud" class="w-full aspect-square object-cover grayscale opacity-60 group-hover:opacity-90 transition-opacity" data-alt="Wisps of incense smoke rising in a dark room, ethereal lighting, moody sepia tones" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCzz6NPIqvUhhslT01DU15E0x8cx2YQ4QR7ujVyCwVCGk-8T1XOt0cXRfAYuG5QSzvoNpZPyCQhFY6nVjQnEO-_n_Mfs5QsaGOVOgwFMxtdMOUCJe5dK0AC9Dffs3jaMer3NTAw_kFlxtsp5AWSq5H-X4Z3yk9hBoICV2pweoCoFy3bvhLsRfg-WjFdenv7F3Kmvj2e6wdpQOemizZDOjbZMKiUWDjnMAyzlz-V6RtACOwvwfqqhxhcbpI-LvYc47DyjOvnDZNW79dS"/>
<h3 class="font-headline text-3xl">Aged Resins</h3>
<p class="font-body text-on-surface-variant text-sm leading-relaxed">We utilize a proprietary aging process for our Oud and Sandalwood oils, maturing them for a minimum of 36 months.</p>
</div>
</div>
</div>
</section>
<!-- Immersive Call to Action -->
<section class="relative h-[614px] flex items-center justify-center text-center px-12 overflow-hidden">
<div class="absolute inset-0 z-0">
<img alt="Mist over fields" class="w-full h-full object-cover grayscale contrast-150 brightness-50" data-alt="Ethereal landscape of a lavender field at twilight covered in thick morning mist, monochromatic black and white" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDMAGtal_sPI5SGU2FgKegk8KjV5whYjRjN-edQbbuvYQDK2R2n7g_8DQjlMEMz4jROh9G4d8uNGNQt42mqxyd24bkEBGvE-LSvPh7bgtLM_5-4P87QR4DkBCXzA7_1e6HNdPh4SJbk-zLc2pB-8Wkmq8sizI-PKLLOSmiTsHQAwVO4Ze3YWUBJlWTWUN1PUyEizSDcHOzMLgwrdnc-O3yBfmpl3-KzB-SdSOb_6IQRlvbcBvqik_9iG1pROt3cQCuhd6cTBnvQ9pR6"/>
<div class="absolute inset-0 bg-background/60"></div>
</div>
<div class="relative z-10 max-w-2xl">
<h2 class="font-headline text-5xl md:text-6xl text-on-background mb-8">Begin Your Consultation</h2>
<p class="font-body text-on-surface-variant mb-12 tracking-wide leading-relaxed">Allow our digital sommelier to guide you through the olfactory landscapes of L'Essence.</p>
<button class="bg-secondary text-on-secondary px-12 py-4 font-label tracking-[0.2em] uppercase text-xs hover:bg-secondary/80 transition-colors">Find Your Signature</button>
</div>
</section>
</main>
<!-- Footer -->
<footer class="w-full pt-20 pb-10 border-t border-[#383437]/10 bg-[#100d10]">
<div class="grid grid-cols-1 md:grid-cols-4 gap-12 px-12 max-w-7xl mx-auto">
<div class="col-span-1 md:col-span-1">
<span class="text-xl font-serif text-[#e8e0e5] block mb-6">L'ESSENCE</span>
<p class="font-body text-[10px] text-[#e8e0e5]/50 leading-loose tracking-widest uppercase">
                    The intersection of ancestral alchemy and modern desire.
                </p>
</div>
<div>
<h4 class="font-label text-[10px] uppercase tracking-[0.2em] text-[#e9c176] mb-6">Explore</h4>
<ul class="space-y-4">
<li><a class="font-label text-[10px] uppercase tracking-[0.2em] text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors duration-500" href="#">Shop All</a></li>
<li><a class="font-label text-[10px] uppercase tracking-[0.2em] text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors duration-500" href="#">Collections</a></li>
<li><a class="font-label text-[10px] uppercase tracking-[0.2em] text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors duration-500" href="#">Discovery Sets</a></li>
</ul>
</div>
<div>
<h4 class="font-label text-[10px] uppercase tracking-[0.2em] text-[#e9c176] mb-6">Legal</h4>
<ul class="space-y-4">
<li><a class="font-label text-[10px] uppercase tracking-[0.2em] text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors duration-500" href="#">Privacy Policy</a></li>
<li><a class="font-label text-[10px] uppercase tracking-[0.2em] text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors duration-500" href="#">Terms of Service</a></li>
<li><a class="font-label text-[10px] uppercase tracking-[0.2em] text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors duration-500" href="#">Shipping &amp; Returns</a></li>
<li><a class="font-label text-[10px] uppercase tracking-[0.2em] text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors duration-500" href="#">Wholesale</a></li>
</ul>
</div>
<div>
<h4 class="font-label text-[10px] uppercase tracking-[0.2em] text-[#e9c176] mb-6">Newsletter</h4>
<div class="relative border-b border-outline-variant/30 py-2">
<input class="bg-transparent border-none w-full text-[10px] tracking-[0.2em] text-on-surface focus:ring-0 placeholder:text-outline/40" placeholder="JOIN THE LIST" type="email"/>
<button class="absolute right-0 top-1/2 -translate-y-1/2">
<span class="material-symbols-outlined text-sm text-secondary">arrow_forward</span>
</button>
</div>
</div>
</div>
<div class="mt-20 px-12 max-w-7xl mx-auto border-t border-[#383437]/10 pt-10 text-center">
<span class="font-label text-[8px] uppercase tracking-[0.3em] text-[#e8e0e5]/30">© 2024 L'ESSENCE PERFUMES. ALL RIGHTS RESERVED.</span>
</div>
</footer>
</body></html>



Contact - L'ESSENCE
<!DOCTYPE html>

<html class="dark" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Contact Us | L'ESSENCE</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,200..800;1,6..72,200..800&amp;family=Manrope:wght@200..800&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "inverse-primary": "#775276",
                        "secondary": "#e9c176",
                        "surface-container-low": "#1e1b1e",
                        "tertiary": "#c8c6c5",
                        "primary-fixed": "#ffd6fa",
                        "on-primary-fixed-variant": "#5e3b5e",
                        "secondary-container": "#604403",
                        "primary-container": "#341536",
                        "on-secondary": "#412d00",
                        "on-background": "#e8e0e5",
                        "surface-dim": "#151215",
                        "on-error": "#690005",
                        "surface-variant": "#383437",
                        "error-container": "#93000a",
                        "on-secondary-container": "#dab36a",
                        "on-primary-container": "#a47ba2",
                        "on-secondary-fixed": "#261900",
                        "on-primary-fixed": "#2e0f30",
                        "on-error-container": "#ffdad6",
                        "primary": "#e6b8e2",
                        "on-tertiary-fixed": "#1c1b1b",
                        "on-tertiary-container": "#8a8888",
                        "surface-container-high": "#2d292c",
                        "tertiary-container": "#212121",
                        "surface-bright": "#3c383b",
                        "primary-fixed-dim": "#e6b8e2",
                        "surface-container-highest": "#383437",
                        "secondary-fixed-dim": "#e9c176",
                        "on-secondary-fixed-variant": "#5d4201",
                        "secondary-fixed": "#ffdea5",
                        "surface-tint": "#e6b8e2",
                        "on-surface-variant": "#cfc3ca",
                        "error": "#ffb4ab",
                        "outline-variant": "#4c454a",
                        "outline": "#988e94",
                        "inverse-surface": "#e8e0e5",
                        "inverse-on-surface": "#332f33",
                        "on-surface": "#e8e0e5",
                        "on-tertiary-fixed-variant": "#474746",
                        "tertiary-fixed-dim": "#c8c6c5",
                        "on-primary": "#452446",
                        "surface-container-lowest": "#100d10",
                        "tertiary-fixed": "#e5e2e1",
                        "background": "#151215",
                        "surface-container": "#221f22",
                        "on-tertiary": "#313030",
                        "surface": "#151215"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "fontFamily": {
                        "headline": ["Newsreader"],
                        "body": ["Manrope"],
                        "label": ["Manrope"]
                    }
                },
            }
        }
    </script>
<style>
        body {
            background-color: #151215;
            color: #e8e0e5;
            font-family: 'Manrope', sans-serif;
        }
        .noise-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            opacity: 0.02;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
            z-index: 9999;
        }
        .glass-panel {
            backdrop-filter: blur(40px);
            background-color: rgba(21, 18, 21, 0.8);
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-background text-on-background selection:bg-secondary/30">
<div class="noise-overlay"></div>
<!-- TopNavBar -->
<nav class="fixed top-0 w-full z-50 h-24 bg-[#151215]/80 backdrop-blur-xl no-line tonal-transition bg-gradient-to-b from-[#151215] to-transparent">
<div class="flex justify-between items-center px-12 max-w-[1920px] mx-auto h-full">
<div class="text-3xl font-serif italic text-[#e8e0e5] tracking-tight">L'ESSENCE</div>
<div class="hidden md:flex items-center space-x-12">
<a class="font-body text-[13px] uppercase tracking-[0.2em] text-[#e8e0e5]/70 hover:text-[#e8e0e5] transition-colors" href="#">Home</a>
<a class="font-body text-[13px] uppercase tracking-[0.2em] text-[#e8e0e5]/70 hover:text-[#e8e0e5] transition-colors" href="#">Shop</a>
<a class="font-body text-[13px] uppercase tracking-[0.2em] text-[#e8e0e5]/70 hover:text-[#e8e0e5] transition-colors" href="#">Collections</a>
<a class="font-body text-[13px] uppercase tracking-[0.2em] text-[#e8e0e5]/70 hover:text-[#e8e0e5] transition-colors" href="#">About</a>
<a class="font-body text-[13px] uppercase tracking-[0.2em] text-[#e9c176] border-b border-[#e9c176]/30 pb-1" href="#">Contact</a>
</div>
<div class="flex items-center space-x-8">
<button class="text-[#e8e0e5]/70 hover:opacity-80 transition-opacity active:scale-95">
<span class="material-symbols-outlined">shopping_bag</span>
</button>
<button class="text-[#e8e0e5]/70 hover:opacity-80 transition-opacity active:scale-95">
<span class="material-symbols-outlined">person</span>
</button>
</div>
</div>
</nav>
<main class="pt-40 pb-32 px-6 md:px-12 max-w-[1440px] mx-auto">
<!-- Hero Section -->
<header class="mb-24 flex flex-col md:flex-row md:items-end justify-between gap-8">
<div class="max-w-2xl">
<span class="font-label text-secondary uppercase tracking-[0.3em] text-xs mb-4 block">Concierge &amp; Inquiries</span>
<h1 class="font-headline text-6xl md:text-8xl leading-[0.9] tracking-tighter italic">Connect with <br/> the Senses.</h1>
</div>
<div class="md:text-right">
<p class="font-body text-on-surface-variant max-w-xs md:ml-auto leading-relaxed opacity-80">
                    Whether seeking a signature scent or a private consultation, our masters are here to guide your olfactory journey.
                </p>
</div>
</header>
<!-- Main Content Bento Grid -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
<!-- Contact Form Card -->
<div class="lg:col-span-7 bg-surface-container-low p-8 md:p-16 border border-outline-variant/10">
<h2 class="font-headline text-3xl mb-12">Send a Message</h2>
<form class="space-y-12">
<div class="grid grid-cols-1 md:grid-cols-2 gap-12">
<div class="relative">
<input class="peer w-full bg-transparent border-0 border-b border-outline-variant/30 py-2 px-0 focus:ring-0 focus:border-secondary transition-colors placeholder-transparent" id="name" placeholder=" " type="text"/>
<label class="absolute left-0 -top-4 font-label text-[10px] uppercase tracking-widest text-on-surface-variant transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-2 peer-focus:-top-4 peer-focus:text-[10px] peer-focus:text-secondary" for="name">Full Name</label>
</div>
<div class="relative">
<input class="peer w-full bg-transparent border-0 border-b border-outline-variant/30 py-2 px-0 focus:ring-0 focus:border-secondary transition-colors placeholder-transparent" id="email" placeholder=" " type="email"/>
<label class="absolute left-0 -top-4 font-label text-[10px] uppercase tracking-widest text-on-surface-variant transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-2 peer-focus:-top-4 peer-focus:text-[10px] peer-focus:text-secondary" for="email">Email Address</label>
</div>
</div>
<div class="relative">
<select class="peer w-full bg-transparent border-0 border-b border-outline-variant/30 py-2 px-0 focus:ring-0 focus:border-secondary transition-colors appearance-none text-on-surface-variant/70" id="subject">
<option value="">General Inquiry</option>
<option value="">Order Assistance</option>
<option value="">Bespoke Consultation</option>
<option value="">Wholesale &amp; Press</option>
</select>
<label class="absolute left-0 -top-4 font-label text-[10px] uppercase tracking-widest text-on-surface-variant" for="subject">Subject</label>
</div>
<div class="relative">
<textarea class="peer w-full bg-transparent border-0 border-b border-outline-variant/30 py-2 px-0 focus:ring-0 focus:border-secondary transition-colors placeholder-transparent resize-none" id="message" placeholder=" " rows="4"></textarea>
<label class="absolute left-0 -top-4 font-label text-[10px] uppercase tracking-widest text-on-surface-variant transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-2 peer-focus:-top-4 peer-focus:text-[10px] peer-focus:text-secondary" for="message">Your Message</label>
</div>
<button class="w-full md:w-auto px-12 py-5 bg-secondary text-on-secondary font-label text-xs uppercase tracking-[0.2em] hover:bg-secondary/90 transition-all flex items-center justify-center gap-4 group" type="submit">
                        Inquire Now
                        <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
</button>
</form>
</div>
<!-- Side Info & Map -->
<div class="lg:col-span-5 flex flex-col gap-8">
<!-- Boutique Location -->
<div class="bg-surface-container-high p-8 flex flex-col justify-between h-full min-h-[400px] border border-outline-variant/5">
<div>
<h3 class="font-headline text-2xl mb-6 italic">The Paris Atelier</h3>
<p class="font-body text-on-surface-variant leading-relaxed mb-8">
                            24 Rue de Sèvres,<br/>
                            75007 Paris, France
                        </p>
<div class="space-y-2">
<div class="flex items-center gap-3 text-secondary text-xs uppercase tracking-widest">
<span class="material-symbols-outlined text-lg">schedule</span>
                                Tue — Sat: 11:00 — 19:00
                            </div>
<div class="flex items-center gap-3 text-on-surface-variant/50 text-xs uppercase tracking-widest">
<span class="material-symbols-outlined text-lg">call</span>
                                +33 (0) 1 44 39 80 00
                            </div>
</div>
</div>
<div class="mt-12 relative w-full aspect-video grayscale contrast-125 brightness-75 overflow-hidden">
<img class="w-full h-full object-cover opacity-40" data-alt="Minimalist dark monochromatic street map of Paris 7th arrondissement with gold accent dot for boutique location" data-location="Paris, France" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBkOmIKkvuCtwSnFFotF4muCTHfwNppFjAwJK7Gmgx_cxQva1Llwtf7gOKTYc--RibI_SIPcxkkgfeRBw5NmkELvr1LxZhVrkHy7DI8jHL-MLwMN4xRVjeSI6fSnig8mMkzY2ZeRKpYpb46nxIKmk1ELWHmkDRoLxekgbjcHrOr8Br-H-Gw8my2K_1D6xE5kUA1vd3u2zudGGZLHPEuTKWRfW6KYm9ukDBdkNwaMRII_rlMBhPeryhVKp1UW4U1MbTFO_oyRRsJlHuA"/>
<div class="absolute inset-0 bg-gradient-to-t from-surface-container-high via-transparent to-transparent"></div>
</div>
</div>
<!-- Customer Service Links -->
<div class="grid grid-cols-2 gap-4">
<a class="bg-surface-container p-6 hover:bg-surface-container-highest transition-colors flex flex-col gap-4 border border-outline-variant/5 group" href="#">
<span class="material-symbols-outlined text-secondary">help_center</span>
<div>
<span class="font-label text-[10px] uppercase tracking-widest block mb-1">Help Center</span>
<span class="font-body text-sm opacity-60 group-hover:opacity-100 transition-opacity">FAQ &amp; Shipping</span>
</div>
</a>
<a class="bg-surface-container p-6 hover:bg-surface-container-highest transition-colors flex flex-col gap-4 border border-outline-variant/5 group" href="#">
<span class="material-symbols-outlined text-secondary">history</span>
<div>
<span class="font-label text-[10px] uppercase tracking-widest block mb-1">Returns</span>
<span class="font-body text-sm opacity-60 group-hover:opacity-100 transition-opacity">Track &amp; Refund</span>
</div>
</a>
</div>
</div>
</div>
<!-- Secondary Imagery / Quote -->
<section class="mt-32 grid grid-cols-1 md:grid-cols-2 gap-24 items-center">
<div class="relative order-2 md:order-1">
<div class="absolute -top-12 -left-12 w-64 h-64 bg-primary/5 rounded-full blur-[100px]"></div>
<img class="w-full h-[500px] object-cover grayscale opacity-90 border border-outline-variant/10" data-alt="Aesthetic close-up of a dark amber perfume bottle with gold cap resting on a dark velvet cloth with dramatic soft lighting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAdc_tYieb6HA7-t5dNdIS2w9wcB-9MOLKyg8H7xYBls59KqkWTZ4znS6ZW_E0gV5sXXFJicoRcI9tKclvuv4flEv3XbtXx-sV4aIem-Ef5qF6R5fmlMYZtQRpD0DjpvBvUmIRPzIi_p2GMLkQzv9wKns0g-DNH7SN1DXiHAWqhmMgRnUL_xVsdHOmWdUZ2KeP0H_DuxsOAhVY55RpwIwE29rcsx6siP9bNM-jCB6ZXpjejPIPgRDBrjpGtqqdOEVV0puUUc45bH5zb"/>
</div>
<div class="order-1 md:order-2">
<blockquote class="font-headline text-4xl leading-snug italic mb-8">
                    "Fragrance is the most intense form of memory. It should be treated with the intimacy of a secret shared."
                </blockquote>
<cite class="font-label text-xs uppercase tracking-[0.3em] text-secondary not-italic">— Master Parfumeur</cite>
</div>
</section>
</main>
<!-- Footer -->
<footer class="w-full pt-20 pb-10 border-t border-[#383437]/10 bg-[#100d10]">
<div class="grid grid-cols-1 md:grid-cols-4 gap-12 px-12 max-w-7xl mx-auto">
<div class="md:col-span-1">
<div class="text-xl font-serif text-[#e8e0e5] mb-8">L'ESSENCE</div>
<p class="font-body text-[12px] leading-relaxed text-[#e8e0e5]/40 max-w-[200px]">
                    Crafting olfactory experiences that transcend time and space.
                </p>
</div>
<div class="space-y-4">
<h4 class="font-label text-[10px] uppercase tracking-[0.2em] text-[#e9c176]">Collections</h4>
<ul class="space-y-2">
<li><a class="font-label text-[10px] uppercase tracking-[0.2em] text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors duration-500" href="#">The Noir Series</a></li>
<li><a class="font-label text-[10px] uppercase tracking-[0.2em] text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors duration-500" href="#">Botanical Essence</a></li>
<li><a class="font-label text-[10px] uppercase tracking-[0.2em] text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors duration-500" href="#">Bespoke Atelier</a></li>
</ul>
</div>
<div class="space-y-4">
<h4 class="font-label text-[10px] uppercase tracking-[0.2em] text-[#e9c176]">Information</h4>
<ul class="space-y-2">
<li><a class="font-label text-[10px] uppercase tracking-[0.2em] text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors duration-500" href="#">Privacy Policy</a></li>
<li><a class="font-label text-[10px] uppercase tracking-[0.2em] text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors duration-500" href="#">Terms of Service</a></li>
<li><a class="font-label text-[10px] uppercase tracking-[0.2em] text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors duration-500" href="#">Shipping &amp; Returns</a></li>
<li><a class="font-label text-[10px] uppercase tracking-[0.2em] text-[#e8e0e5]/50 hover:text-[#e9c176] transition-colors duration-500" href="#">Wholesale</a></li>
</ul>
</div>
<div class="space-y-4">
<h4 class="font-label text-[10px] uppercase tracking-[0.2em] text-[#e9c176]">Newsletter</h4>
<div class="relative border-b border-[#383437]/30">
<input class="w-full bg-transparent border-none py-3 px-0 font-label text-[10px] tracking-[0.2em] focus:ring-0 text-[#e8e0e5] placeholder:text-[#e8e0e5]/20" placeholder="YOUR EMAIL" type="email"/>
<button class="absolute right-0 top-1/2 -translate-y-1/2 text-[#e9c176]">
<span class="material-symbols-outlined text-sm">north_east</span>
</button>
</div>
</div>
</div>
<div class="mt-20 px-12 max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
<span class="font-label text-[10px] uppercase tracking-[0.2em] text-[#e8e0e5]/30">© 2024 L'ESSENCE PERFUMES. ALL RIGHTS RESERVED.</span>
<div class="flex gap-8">
<a class="font-label text-[10px] uppercase tracking-[0.2em] text-[#e8e0e5]/30 hover:text-[#e9c176]" href="#">Instagram</a>
<a class="font-label text-[10px] uppercase tracking-[0.2em] text-[#e8e0e5]/30 hover:text-[#e9c176]" href="#">Pinterest</a>
</div>
</div>
</footer>
</body></html>