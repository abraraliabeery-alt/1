@extends('layouts.app')

@section('hideSiteChrome', true)

@section('head_extra')
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{
            --t4-accent: var(--primary);
            --t4-dark: color-mix(in oklab, var(--bg), var(--fg) 86%);
            --t4-ink: var(--strong-text);
            --t4-card: color-mix(in oklab, var(--bg), transparent 4%);
            --t4-border: color-mix(in oklab, var(--fg), transparent 90%);
            --t4-ring: color-mix(in oklab, var(--primary), transparent 65%);
        }
        .t4-accent{ color: var(--primary) }
        .t4-ink{ color: var(--strong-text) }
        .t4-on-dark{ color: var(--footer-fg) }
        .t4-muted{ color: color-mix(in oklab, var(--fg), transparent 35%) }
        .t4-muted-on-dark{ color: color-mix(in oklab, var(--footer-fg), transparent 22%) }
        .t4-bg-accent{ background: var(--primary) }
        .t4-bg-soft{ background: color-mix(in oklab, var(--bg), var(--fg) 2%) }
        .t4-bg-card{ background: var(--card) }
        .t4-bg-surface{ background: var(--bg) }
        .t4-bg-deep{ background: color-mix(in oklab, var(--bg), var(--fg) 86%) }
        .t4-border-soft{ border-color: color-mix(in oklab, var(--fg), transparent 86%) }
        .t4-border-accent{ border-color: color-mix(in oklab, var(--primary), transparent 60%) }
        .t4-hero-cta{ background: var(--primary); color: var(--strong-text) }
        .t4-hero-cta:hover{ background: color-mix(in oklab, var(--primary), var(--fg) 12%) }
        .t4-cta-dark{ background: color-mix(in oklab, var(--bg), var(--fg) 86%); color: var(--footer-fg) }
        .t4-cta-dark:hover{ background: color-mix(in oklab, var(--bg), var(--fg) 82%) }
        .t4-hover-on-dark:hover{ color: var(--footer-fg) }
        .t4-hover-accent:hover{ color: var(--primary) }
        .t4-bg-accent-hover:hover{ background: color-mix(in oklab, var(--primary), var(--fg) 12%) }
        .t4-border-deep{ border-color: color-mix(in oklab, var(--bg), var(--fg) 82%) }
        .t4-badge{ background: color-mix(in oklab, var(--bg), var(--fg) 6%); border-color: color-mix(in oklab, var(--fg), transparent 86%); color: color-mix(in oklab, var(--strong-text), transparent 18%) }
        .t4-dot{ color: var(--primary) }
        .t4-panel{ background: var(--card); border-color: color-mix(in oklab, var(--fg), transparent 86%) }
        .t4-field{ background: var(--bg); border-color: color-mix(in oklab, var(--fg), transparent 75%); color: var(--fg) }
        .t4-field:focus{ outline: none; border-color: var(--primary) }
        .t4-project-overlay{ opacity: 0 }
        .t4-project-card:hover .t4-project-overlay{ opacity: 1 }
        .t4-hero-simple{ max-width: 52rem; text-align:center; margin-inline:auto }
        .t4-hero-simple h1{ letter-spacing: -0.02em; text-wrap: balance }
        .t4-hero-kicker{ letter-spacing: .22em }
        .t4-hero-strip{ margin-top: 42px; max-width: 72rem; margin-inline:auto }
        .t4-hero-strip-inner{ position:relative; background: color-mix(in oklab, var(--fg), transparent 82%); border: 1px solid color-mix(in oklab, var(--bg), transparent 88%); backdrop-filter: blur(12px); border-radius: 28px; box-shadow: 0 28px 90px color-mix(in oklab, var(--fg), transparent 78%); overflow:hidden }
        .t4-hero-strip-inner::before{ content:""; position:absolute; inset:0; background:
            radial-gradient(120% 140% at 50% 0%, color-mix(in oklab, var(--fg), transparent 86%), transparent 58%),
            radial-gradient(90% 120% at 50% 120%, color-mix(in oklab, var(--fg), transparent 90%), transparent 62%);
            opacity:.9; pointer-events:none }
        .t4-hero-strip-inner > *{ position:relative }
        .t4-hero-strip-grid{ display:grid; gap:18px; align-items:start }
        @media (min-width:768px){
            .t4-hero-strip-grid{ grid-template-columns: 1.1fr 1.3fr; gap:28px }
        }
        .t4-hero-pill{ background: color-mix(in oklab, var(--fg), transparent 86%); border: 1px solid color-mix(in oklab, var(--bg), transparent 88%); color: var(--footer-fg); backdrop-filter: blur(10px); box-shadow: 0 14px 40px color-mix(in oklab, var(--fg), transparent 84%) }
        .t4-hero-pill strong{ color: var(--footer-fg) }
        .t4-hero-stats{ margin-top: 18px; max-width: 72rem; margin-inline:auto }
        .t4-input{ border-color: color-mix(in oklab, var(--fg), transparent 78%) }
        .t4-input:focus{ border-color: color-mix(in oklab, var(--primary), transparent 0%) }
        .t4-img-overlay{ background: linear-gradient(to top, color-mix(in oklab, var(--fg), transparent 35%), transparent) }
        body {
            font-family: 'Cairo', sans-serif;
        }
        .t4-hero{
            position: relative;
            overflow: hidden;
            border-bottom-left-radius: 64px;
            border-bottom-right-radius: 64px;
            box-shadow: 0 30px 80px color-mix(in oklab, var(--fg), transparent 86%);
        }
        .hero-bg {
            background: linear-gradient(color-mix(in oklab, var(--fg), transparent 30%), color-mix(in oklab, var(--fg), transparent 30%)), var(--hero-image);
            background-size: cover;
            background-position: center;
        }
        html{ scroll-behavior:smooth }
        .t4-topbar{ background: var(--t4-accent) }
        .t4-header{ background: color-mix(in oklab, var(--bg), var(--fg) 84%); backdrop-filter: blur(12px); border-bottom: 1px solid color-mix(in oklab, var(--primary), transparent 78%); box-shadow: 0 10px 30px color-mix(in oklab, var(--fg), transparent 80%) }
        .t4-nav a{ position:relative }
        .t4-nav a::after{ content:""; position:absolute; left:0; right:0; bottom:-7px; height:2px; background: color-mix(in oklab, var(--primary), transparent 15%); transform: scaleX(0); transform-origin:center; transition: transform .18s ease }
        .t4-nav a:hover::after{ transform: scaleX(1) }
        .t4-btn{ border-radius: 14px; box-shadow: 0 12px 28px color-mix(in oklab, var(--fg), transparent 82%); transition: transform .18s ease, box-shadow .18s ease, background-color .18s ease, color .18s ease, border-color .18s ease }
        .t4-btn:hover{ transform: translateY(-1px) }
        .t4-btn:active{ transform: translateY(0) }
        .t4-control{ height:40px; border-radius:12px; display:inline-flex; align-items:center; justify-content:center; gap:.5rem; padding:0 14px; font-weight:800; line-height:1 }
        .t4-control--icon{ width:40px; padding:0 }
        .t4-control--outline{ border:1px solid color-mix(in oklab, var(--primary), transparent 40%); background:transparent; color: var(--primary) }
        .t4-control--outline:hover{ background: var(--primary); color: var(--strong-text) }
        .t4-control--solid{ border:1px solid color-mix(in oklab, var(--primary), transparent 100%); background: var(--primary); color: var(--strong-text) }
        .t4-control--solid:hover{ background: color-mix(in oklab, var(--primary), var(--fg) 12%) }
        .t4-select{ appearance:none; padding-inline: 14px 34px; background-image: linear-gradient(45deg, transparent 50%, var(--primary) 50%), linear-gradient(135deg, var(--primary) 50%, transparent 50%); background-position: calc(1.05rem) 55%, calc(.75rem) 55%; background-size: 6px 6px, 6px 6px; background-repeat:no-repeat }
        .t4-header-row{ display:flex; align-items:center; justify-content:space-between; gap:12px }
        .t4-header-actions{ display:flex; align-items:center; gap:10px; flex:0 0 auto }
        .t4-brand{ display:flex; align-items:center; gap:12px; min-width: 220px }
        .t4-logo{ width:44px; height:44px }
        .t4-brand-title{ font-size:18px; font-weight:900; line-height:1.15 }
        .t4-brand-sub{ font-size:12px; color: var(--primary); font-weight:800; line-height:1.1 }
        .t4-nav{ white-space:nowrap }
        .t4-nav a{ padding: 10px 6px; font-weight:800; font-size:12px; line-height:1 }
        @media (min-width:1024px){
            .t4-nav{ display:flex; align-items:center; justify-content:center; gap:12px; flex:1 1 auto }
        }
        @media (max-width:1023px){
            .t4-nav{ display:none }
        }
        .t4-mobile-menu{ display:none }
        .t4-mobile-menu.is-open{ display:block }
        .t4-card{ border-radius: 18px; background: var(--t4-card); border: 1px solid var(--t4-border); box-shadow: 0 10px 26px color-mix(in oklab, var(--fg), transparent 92%); transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease, background-color .18s ease }
        .t4-card:hover{ transform: translateY(-3px); box-shadow: 0 18px 40px color-mix(in oklab, var(--fg), transparent 86%); border-color: color-mix(in oklab, var(--primary), transparent 65%) }
        .t4-card:focus-within{ box-shadow: 0 18px 42px color-mix(in oklab, var(--fg), transparent 84%), 0 0 0 5px var(--t4-ring) }
        .t4-soft-bg{ background: radial-gradient(1200px 380px at 80% 0%, color-mix(in oklab, var(--primary), transparent 86%), transparent 60%), radial-gradient(900px 320px at 10% 30%, color-mix(in oklab, var(--fg), transparent 94%), transparent 60%) }
        .t4-soft-bg-dark{ background: radial-gradient(1000px 420px at 70% 10%, color-mix(in oklab, var(--primary), transparent 84%), transparent 60%), linear-gradient(180deg, color-mix(in oklab, var(--bg), var(--fg) 86%), color-mix(in oklab, var(--bg), var(--fg) 92%)) }
        .t4-section-kicker{ letter-spacing:.12em }
        .t4-title-underline{ position:relative; display:inline-block }
        .t4-title-underline::after{ content:""; position:absolute; left:50%; transform:translateX(-50%); bottom:-14px; width:68px; height:4px; background: var(--t4-accent); border-radius:999px; opacity:.9 }
        .t4-project-card{ border-radius: 20px; overflow:hidden; box-shadow: 0 16px 40px color-mix(in oklab, var(--fg), transparent 78%) }
        .t4-project-card:hover{ box-shadow: 0 22px 60px color-mix(in oklab, var(--fg), transparent 72%) }
        @media (max-width:640px){
            .t4-topbar{ display:none }
            .t4-brand{ min-width: 0 }
            .t4-brand-title{ font-size:16px }
        }
    </style>
@endsection

@section('content')
<div dir="rtl">
    <!-- Top Bar -->
    <div class="t4-topbar py-2">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between text-sm">
                <div class="flex items-center gap-6 t4-ink">
                    <span><i class="fas fa-phone ml-2"></i>{{ $contactPhone ?? '+966 50 123 4567' }}</span>
                    <span><i class="fas fa-envelope ml-2"></i>{{ $contactEmail ?? 'info@madagolden.sa' }}</span>
                </div>
                <div class="flex items-center gap-4">
                    @if(!empty($socialLinks['facebook'] ?? null))
                        <a href="{{ $socialLinks['facebook'] }}" target="_blank" rel="noopener" class="t4-ink t4-hover-on-dark" aria-label="فيسبوك"><i class="fab fa-facebook"></i></a>
                    @endif
                    @if(!empty($socialLinks['twitter'] ?? null))
                        <a href="{{ $socialLinks['twitter'] }}" target="_blank" rel="noopener" class="t4-ink t4-hover-on-dark" aria-label="منصة إكس"><i class="fab fa-twitter"></i></a>
                    @endif
                    @if(!empty($socialLinks['instagram'] ?? null))
                        <a href="{{ $socialLinks['instagram'] }}" target="_blank" rel="noopener" class="t4-ink t4-hover-on-dark" aria-label="إنستغرام"><i class="fab fa-instagram"></i></a>
                    @endif
                    @if(!empty($socialLinks['linkedin'] ?? null))
                        <a href="{{ $socialLinks['linkedin'] }}" target="_blank" rel="noopener" class="t4-ink t4-hover-on-dark" aria-label="سناب شات"><i class="fab fa-linkedin"></i></a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <header class="t4-header t4-on-dark sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="t4-header-row py-3">
                <div class="t4-brand">
                    <div class="t4-logo t4-bg-accent flex items-center justify-center" style="overflow:hidden">
                        @if(!empty($siteLogoUrl ?? null))
                            <img src="{{ $siteLogoUrl }}" class="logo-light" alt="الشعار" style="max-width:100%; max-height:100%" onerror="this.style.display='none'">
                        @endif
                        @if(!empty($siteLogoDarkUrl ?? null))
                            <img src="{{ $siteLogoDarkUrl }}" class="logo-dark" alt="الشعار" style="max-width:100%; max-height:100%" onerror="this.style.display='none'">
                        @endif
                        @if(empty($siteLogoUrl ?? null) && empty($siteLogoDarkUrl ?? null))
                            <i class="fas fa-hard-hat t4-ink text-xl"></i>
                        @endif
                    </div>
                    <div>
                        <div class="t4-brand-title">{{ $siteTitle ?? config('app.name') }}</div>
                        <div class="t4-brand-sub">للعقارات والمقاولات</div>
                    </div>
                </div>
                <nav class="t4-nav">
                    <a href="#home" class="t4-hover-accent">الرئيسية</a>
                    <a href="#about" class="t4-hover-accent">من نحن</a>
                    <a href="#properties" class="t4-hover-accent">العقارات</a>
                    <a href="#stats" class="t4-hover-accent">الإحصائيات</a>
                    <a href="#services" class="t4-hover-accent">الخدمات</a>
                    <a href="#projects" class="t4-hover-accent">المشاريع</a>
                    <a href="#testimonials" class="t4-hover-accent">آراء العملاء</a>
                    <a href="#partners" class="t4-hover-accent">الشركاء</a>
                    <a href="#faqs" class="t4-hover-accent">الأسئلة</a>
                    <a href="#contact" class="t4-hover-accent">اتصل بنا</a>
                </nav>
                <div class="t4-header-actions">
                    <button id="t4MenuBtn" type="button" aria-label="فتح القائمة" class="t4-control t4-control--icon t4-control--outline lg:hidden">
                        <i class="bi bi-list" aria-hidden="true"></i>
                    </button>
                    <form action="{{ route('theme.set') }}" method="POST" class="hidden lg:block">
                        @csrf
                        <select name="theme" onchange="this.form.submit()" aria-label="تبديل الثيم" class="t4-control t4-control--outline t4-select">
                            @foreach((array) config('app.themes', []) as $key => $label)
                                <option value="{{ $key }}" @selected(config('app.theme','theme1')===$key)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </form>
                    <button id="themeToggle" type="button" aria-label="تبديل الوضع" class="t4-control t4-control--icon t4-control--outline">
                        <i class="bi bi-moon"></i>
                    </button>
                    @auth
                        @if(optional(auth()->user())->is_staff || optional(auth()->user())->role === 'manager')
                            <a href="{{ url('/admin') }}" class="hidden lg:inline-flex t4-control t4-control--outline" aria-label="لوحة التحكم">
                                <i class="bi bi-speedometer2" aria-hidden="true"></i>
                                <span>لوحة التحكم</span>
                            </a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="hidden lg:block">
                            @csrf
                            <button type="submit" class="t4-control t4-control--outline" aria-label="تسجيل الخروج">
                                <i class="bi bi-box-arrow-right" aria-hidden="true"></i>
                                <span>خروج</span>
                            </button>
                        </form>
                    @else
                        <a class="hidden lg:inline-flex t4-control t4-control--icon t4-control--outline" href="https://api.whatsapp.com/send?phone={{ urlencode(config('app.whatsapp_number', '966000000000')) }}" target="_blank" rel="noopener" aria-label="واتساب">
                            <i class="bi bi-whatsapp" aria-hidden="true"></i>
                        </a>
                        <a class="hidden lg:inline-flex t4-control t4-control--icon t4-control--outline" href="{{ route('login') }}" aria-label="تسجيل الدخول">
                            <i class="bi bi-box-arrow-in-left" aria-hidden="true"></i>
                        </a>
                        <a class="hidden lg:inline-flex t4-control t4-control--icon t4-control--outline" href="{{ route('register') }}" aria-label="إنشاء حساب">
                            <i class="bi bi-person-plus" aria-hidden="true"></i>
                        </a>
                    @endauth
                    <a href="#contact" class="t4-control t4-control--solid">احصل على عرض سعر</a>
                </div>
            </div>

            <div id="t4MobileMenu" class="t4-mobile-menu lg:hidden pb-3">
                <div class="grid gap-2 pt-2">
                    <a href="#home" class="t4-control t4-control--outline w-full justify-start">الرئيسية</a>
                    <a href="#about" class="t4-control t4-control--outline w-full justify-start">من نحن</a>
                    <a href="#properties" class="t4-control t4-control--outline w-full justify-start">العقارات</a>
                    <a href="#stats" class="t4-control t4-control--outline w-full justify-start">الإحصائيات</a>
                    <a href="#services" class="t4-control t4-control--outline w-full justify-start">الخدمات</a>
                    <a href="#projects" class="t4-control t4-control--outline w-full justify-start">المشاريع</a>
                    <a href="#testimonials" class="t4-control t4-control--outline w-full justify-start">آراء العملاء</a>
                    <a href="#partners" class="t4-control t4-control--outline w-full justify-start">الشركاء</a>
                    <a href="#faqs" class="t4-control t4-control--outline w-full justify-start">الأسئلة</a>
                    <a href="#contact" class="t4-control t4-control--solid w-full justify-start">اتصل بنا</a>
                </div>
            </div>
        </div>
    </header>

    <script>
        (function(){
            var btn = document.getElementById('t4MenuBtn');
            var menu = document.getElementById('t4MobileMenu');
            if(!btn || !menu) return;
            btn.addEventListener('click', function(){
                menu.classList.toggle('is-open');
            });
            menu.addEventListener('click', function(e){
                var t = e.target;
                if(t && t.tagName === 'A'){
                    menu.classList.remove('is-open');
                }
            });
        })();
    </script>

    <!-- Hero Section -->
    <section id="home" class="t4-hero hero-bg min-h-screen flex items-center" style="--hero-image: url('{{ $heroImageUrl ?? '' }}');">
        <div class="container mx-auto px-4">
            <div class="t4-hero-simple">
                <h1 class="text-5xl md:text-8xl font-extrabold t4-on-dark mb-2 leading-tight">
                    {{ $heroTitle ?? 'خدمات المقاولات' }}
                </h1>
                <div class="t4-on-dark text-base md:text-xl font-bold mb-7">
                    {{ $heroSubtitle ?? 'إبداعية واحترافية' }}
                </div>
                <div class="flex flex-wrap gap-3 justify-center">
                    <a href="#contact" class="t4-btn t4-hero-cta px-7 py-3 font-extrabold text-base transition">ابدأ مشروعك</a>
                    <a href="#services" class="t4-btn border-2 t4-border-soft t4-on-dark px-7 py-3 font-extrabold text-base transition" style="background: transparent">خدماتنا</a>
                </div>
            </div>

            <div class="t4-hero-strip">
                <div class="t4-hero-strip-inner px-5 py-5 md:px-8 md:py-6">
                    <div class="t4-hero-strip-grid">
                        <div>
                            <div class="t4-muted-on-dark text-xs md:text-sm font-bold mb-2">{{ $heroKicker ?? 'لمحة عن خدماتنا' }}</div>
                            <div class="t4-on-dark text-2xl md:text-4xl font-extrabold leading-tight">
                                {{ $heroStripTitle ?? ($aboutTitle ?? 'تصميم وبناء بجودة عالية') }}
                            </div>
                        </div>
                        <div>
                            <div class="t4-muted-on-dark text-sm md:text-base leading-relaxed">
                                {{ $heroDescription ?? ($aboutDescription ?? 'نقدم حلول مقاولات متكاملة تشمل البناء، التشطيب، الصيانة، وإدارة المشاريع بأعلى معايير الجودة والسلامة.') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="t4-hero-stats">
                <div class="flex flex-wrap gap-2 justify-center md:justify-start">
                    @foreach(array_slice(($stats ?? []), 0, 4) as $s)
                        <div class="t4-hero-pill px-4 py-2 rounded-full text-xs md:text-sm font-bold">
                            <strong class="text-base md:text-lg font-extrabold">{{ $s['value'] ?? '' }}</strong>
                            <span class="mr-1">{{ $s['label'] ?? '' }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Properties -->
    @if($show_properties ?? true)
    <section id="properties" class="py-20 t4-bg-soft t4-soft-bg">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <div class="t4-accent text-sm font-bold uppercase tracking-wide mb-4 t4-section-kicker">العقارات</div>
                <h2 class="text-4xl font-bold t4-ink mb-4 t4-title-underline">أحدث العقارات</h2>
                <div class="flex items-center justify-center gap-3 flex-wrap">
                    <a href="{{ route('properties.index') }}" class="inline-block t4-cta-dark px-6 py-2 font-bold transition">عرض الكل</a>
                    <a href="{{ route('lands.index') }}" class="inline-block border-2 t4-border-deep t4-ink px-6 py-2 font-bold t4-cta-dark transition" style="background: transparent">الأراضي</a>
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                @forelse(($properties ?? collect()) as $p)
                    <a href="{{ route('properties.show', $p) }}" class="t4-card block t4-bg-card border t4-border-soft rounded-lg overflow-hidden hover:shadow-xl transition will-change-transform">
                        <div class="relative">
                            <img src="{{ $p->primary_image_url }}" alt="{{ $p->title }}" class="w-full h-56 object-cover">
                            <div class="absolute inset-0 t4-img-overlay"></div>
                            <div class="absolute bottom-3 right-3 t4-bg-accent t4-ink px-3 py-1 rounded font-bold text-sm">
                                {{ number_format($p->price) }} ر.س
                            </div>
                        </div>
                        <div class="p-5">
                            <h3 class="text-lg font-bold t4-ink mb-1">{{ $p->title }}</h3>
                            <div class="text-sm t4-muted mb-3">{{ $p->city }}@if($p->district) - {{ $p->district }}@endif</div>
                            <div class="flex flex-wrap gap-2 text-xs">
                                <span class="t4-badge border px-2 py-1 rounded">{{ $p->bedrooms ?? '-' }} غرف</span>
                                <span class="t4-badge border px-2 py-1 rounded">{{ $p->bathrooms ?? '-' }} حمام</span>
                                <span class="t4-badge border px-2 py-1 rounded">{{ $p->area ?? '-' }} م²</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="md:col-span-3 text-center t4-muted">لا توجد عقارات حالياً.</div>
                @endforelse
            </div>
        </div>
    </section>
    @endif

    <!-- Welcome Section -->
    @if($show_about ?? true)
    <section id="about" class="py-20 t4-bg-surface">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-16 items-center">
                <div>
                    <div class="t4-accent text-sm font-bold uppercase tracking-wide mb-4">مرحباً بكم في شركتنا</div>
                    <h2 class="text-4xl font-bold t4-ink mb-6">{{ $aboutTitle ?? 'من نحن' }}</h2>
                    <p class="t4-muted mb-8 leading-relaxed">{{ $aboutDescription ?? '' }}</p>
                    <div class="grid grid-cols-2 gap-6 mb-8">
                        <div class="flex items-center gap-3"><i class="fas fa-check-circle t4-dot text-2xl"></i><span class="font-semibold t4-ink">مهندسون معتمدون</span></div>
                        <div class="flex items-center gap-3"><i class="fas fa-check-circle t4-dot text-2xl"></i><span class="font-semibold t4-ink">جودة عالية</span></div>
                        <div class="flex items-center gap-3"><i class="fas fa-check-circle t4-dot text-2xl"></i><span class="font-semibold t4-ink">أسعار تنافسية</span></div>
                        <div class="flex items-center gap-3"><i class="fas fa-check-circle t4-dot text-2xl"></i><span class="font-semibold t4-ink">التزام بالمواعيد</span></div>
                    </div>
                    <a href="#contact" class="inline-block t4-hero-cta px-8 py-3 font-bold transition">اقرأ المزيد</a>
                </div>
                <div class="relative">
                    <img src="{{ $aboutImageUrl ?: 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=800' }}" alt="صورة عن الشركة" class="w-full rounded-lg shadow-2xl">
                    <div class="absolute -bottom-8 -right-8 t4-bg-accent t4-ink p-8 rounded-lg shadow-xl">
                        <div class="text-5xl font-bold mb-2">{{ data_get($stats ?? [], '3.value', '+15') }}</div>
                        <div class="font-semibold">{{ data_get($stats ?? [], '3.label', 'سنة خبرة') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Stats Section -->
    @if($show_kpis ?? true)
    <section id="stats" class="py-20 t4-bg-accent">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8 text-center">
                @forelse(($stats ?? []) as $s)
                    <div>
                        <div class="text-5xl font-bold t4-ink mb-2">{{ $s['value'] ?? '' }}</div>
                        <div class="t4-ink font-semibold">{{ $s['label'] ?? '' }}</div>
                    </div>
                @empty
                @endforelse
            </div>
        </div>
    </section>
    @endif

    <!-- Services -->
    @if($show_services ?? true)
    <section id="services" class="py-20 t4-bg-soft t4-soft-bg">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <div class="t4-accent text-sm font-bold uppercase tracking-wide mb-4 t4-section-kicker">خدماتنا</div>
                <h2 class="text-4xl font-bold t4-ink mb-4 t4-title-underline">نحن الخيار الأفضل لخدمتك</h2>
                <p class="t4-muted max-w-2xl mx-auto">خدمات متميزة تجمع بين الخبرة والاحترافية والالتزام بأعلى معايير الجودة</p>
            </div>

            <div class="flex flex-wrap justify-center gap-8">
                @forelse(($services ?? collect()) as $svc)
                    <div class="block text-center t4-card transition will-change-transform w-full sm:w-[calc(50%-16px)] md:w-[calc(25%-24px)]">
                        <div class="w-24 h-24 t4-bg-card border-4 t4-border-accent rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                            @if($svc->icon)
                                <i class="{{ $svc->icon }} t4-accent text-3xl"></i>
                            @else
                                <i class="fas fa-tools t4-accent text-3xl"></i>
                            @endif
                        </div>
                        <h3 class="text-xl font-bold t4-ink mb-3">{{ $svc->title }}</h3>
                        @if($svc->excerpt)
                            <p class="t4-muted text-sm">{{ $svc->excerpt }}</p>
                        @endif
                        <div class="mt-4 flex flex-wrap justify-center gap-2 text-xs font-bold">
                            <span class="t4-badge border px-3 py-1 rounded-full">نوع 1</span>
                            <span class="t4-badge border px-3 py-1 rounded-full">نوع 2</span>
                        </div>
                    </div>
                @empty
                    <div class="md:col-span-4 text-center t4-muted">لا توجد خدمات حالياً.</div>
                @endforelse
            </div>
        </div>
    </section>
    @endif

    <!-- Projects Portfolio -->
    @if($show_projects ?? true)
    <section id="projects" class="py-20 t4-bg-deep t4-soft-bg-dark">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <div class="t4-accent text-sm font-bold uppercase tracking-wide mb-4 t4-section-kicker">معرض الأعمال</div>
                <h2 class="text-4xl font-bold t4-on-dark mb-4 t4-title-underline">مشاريعنا المنجزة</h2>
                <p class="t4-muted-on-dark max-w-2xl mx-auto">نفخر بإنجاز مئات المشاريع السكنية والتجارية بأعلى معايير الجودة</p>
            </div>
            <div class="grid md:grid-cols-3 gap-4">
                @forelse(($projects ?? collect()) as $proj)
                    <a href="{{ route('projects.show', $proj->slug) }}" class="relative overflow-hidden group cursor-pointer block t4-project-card">
                        @if($proj->cover_image_url)
                            <img src="{{ $proj->cover_image_url }}" alt="{{ $proj->title }}" class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-80 t4-bg-deep"></div>
                        @endif
                        <div class="t4-project-overlay absolute inset-0 t4-bg-accent transition-opacity flex items-center justify-center">
                            <div class="text-center t4-ink px-4">
                                <h3 class="text-2xl font-bold mb-2">{{ $proj->title }}</h3>
                                @if($proj->city)
                                    <p class="font-semibold">{{ $proj->city }}</p>
                                @endif
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="md:col-span-3 text-center t4-muted-on-dark">لا توجد مشاريع حالياً.</div>
                @endforelse
            </div>
        </div>
    </section>
    @endif

    <!-- Testimonials -->
    @if($show_testimonials ?? true)
    <section id="testimonials" class="py-20 t4-bg-soft t4-soft-bg">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <div class="t4-accent text-sm font-bold uppercase tracking-wide mb-4 t4-section-kicker">آراء العملاء</div>
                <h2 class="text-4xl font-bold t4-ink mb-4 t4-title-underline">ماذا يقول عملاؤنا</h2>
                <p class="t4-muted max-w-2xl mx-auto">ثقة عملائنا ورضاهم هو أكبر دليل على جودة خدماتنا</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                @forelse(($testimonials ?? collect()) as $t)
                    <div class="t4-card {{ $loop->index === 1 ? 't4-bg-accent t4-ink transform md:-translate-y-4' : 't4-bg-card' }} p-8">
                        <div class="flex gap-1 {{ $loop->index === 1 ? 't4-ink' : 't4-accent' }} mb-6">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        @if($t->caption)
                            <p class="{{ $loop->index === 1 ? 't4-ink font-semibold' : 't4-muted' }} mb-6 leading-relaxed">"{{ $t->caption }}"</p>
                        @endif
                        <div class="flex items-center gap-4">
                            @if($t->image_url)
                                <img src="{{ $t->image_url }}" alt="{{ $t->title }}" class="w-14 h-14 rounded-full object-cover">
                            @else
                                <div class="w-14 h-14 rounded-full {{ $loop->index === 1 ? 't4-bg-deep' : 't4-bg-soft' }}"></div>
                            @endif
                            <div>
                                @if($t->title)
                                    <div class="font-bold t4-ink">{{ $t->title }}</div>
                                @endif
                                @if($t->city)
                                    <div class="text-sm {{ $loop->index === 1 ? 't4-ink' : 't4-muted' }}">{{ $t->city }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="md:col-span-3 text-center t4-muted">لا توجد آراء عملاء حالياً.</div>
                @endforelse
            </div>
        </div>
    </section>
    @endif

    <!-- Partners -->
    @if($show_partners ?? true)
    <section id="partners" class="py-16 t4-bg-surface">
        <div class="container mx-auto px-4">
            <div class="text-center mb-10">
                <div class="t4-accent text-sm font-bold uppercase tracking-wide mb-4">شركاؤنا</div>
                <h2 class="text-3xl font-bold t4-ink">شركاء النجاح</h2>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-6 place-items-center">
                @forelse(($partners ?? collect()) as $p)
                    <a href="{{ $p->website_url ?: '#' }}" target="_blank" rel="noopener" class="block t4-card t4-bg-soft p-4 w-full max-w-[220px] flex items-center justify-center">
                        @if($p->logo_url)
                            <img src="{{ $p->logo_url }}" alt="{{ $p->name }}" class="h-12 w-full object-contain mx-auto">
                        @else
                            <div class="text-center t4-muted font-semibold">{{ $p->name }}</div>
                        @endif
                    </a>
                @empty
                    <div class="w-full text-center t4-muted">لا يوجد شركاء حالياً.</div>
                @endforelse
            </div>
        </div>
    </section>
    @endif

    <!-- FAQs -->
    @if($show_faqs ?? true)
        <section id="faqs" class="py-20 t4-bg-soft">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <div class="t4-accent text-sm font-bold uppercase tracking-wide mb-4">الأسئلة الشائعة</div>
                    <h2 class="text-3xl font-bold t4-ink">إجابات سريعة</h2>
                </div>
                <div class="max-w-4xl mx-auto space-y-4">
                    @forelse(($faqs ?? collect()) as $f)
                        <details class="t4-card t4-bg-card p-5">
                            <summary class="cursor-pointer font-bold t4-ink">{{ $f->question }}</summary>
                            <div class="mt-3 t4-muted leading-relaxed">{!! nl2br(e($f->answer)) !!}</div>
                        </details>
                    @empty
                        <div class="text-center t4-muted">لا توجد أسئلة حالياً.</div>
                    @endforelse
                </div>
            </div>
        </section>
    @endif

    <!-- Contact Section -->
    @if($show_contact ?? true)
    <section id="contact" class="py-20 t4-bg-accent">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <div class="t4-ink text-sm font-bold uppercase tracking-wide mb-4">هل لديك أي استفسارات؟</div>
                <h2 class="text-4xl font-bold t4-ink mb-4">اتصل بنا مجاناً: {{ $contactPhone ?? '+966 50 123 4567' }}</h2>
            </div>
            <div class="max-w-4xl mx-auto t4-panel border p-10 rounded-lg shadow-2xl">
                <form class="grid md:grid-cols-2 gap-6" action="{{ route('contact.home.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="subject" value="طلب عرض سعر - ثيم المقاولات">
                    <input name="name" type="text" required placeholder="الاسم الكامل *" class="px-4 py-3 border rounded t4-field" value="{{ old('name') }}">
                    <input name="email" type="email" placeholder="البريد الإلكتروني" class="px-4 py-3 border rounded t4-field" value="{{ old('email') }}">
                    <input name="phone" type="tel" required placeholder="رقم الجوال *" class="px-4 py-3 border rounded t4-field" value="{{ old('phone') }}">
                    <select name="type" required class="px-4 py-3 border rounded t4-field">
                        <option value="">نوع الخدمة *</option>
                        <option value="مقاولات بناء" {{ old('type')==='مقاولات بناء' ? 'selected' : '' }}>مقاولات بناء</option>
                        <option value="تشطيب" {{ old('type')==='تشطيب' ? 'selected' : '' }}>تشطيب</option>
                        <option value="صيانة" {{ old('type')==='صيانة' ? 'selected' : '' }}>صيانة</option>
                        <option value="تسويق عقاري" {{ old('type')==='تسويق عقاري' ? 'selected' : '' }}>تسويق عقاري</option>
                        <option value="إدارة مشاريع" {{ old('type')==='إدارة مشاريع' ? 'selected' : '' }}>إدارة مشاريع</option>
                        <option value="استشارات" {{ old('type')==='استشارات' ? 'selected' : '' }}>استشارات</option>
                    </select>
                    <textarea name="message" required rows="4" placeholder="تفاصيل المشروع *" class="md:col-span-2 px-4 py-3 border rounded t4-field resize-none">{{ old('message') }}</textarea>
                    <button type="submit" class="md:col-span-2 t4-cta-dark py-4 rounded font-bold text-lg transition">إرسال الرسالة</button>
                </form>
            </div>
        </div>
    </section>
    @endif

    <footer class="t4-bg-deep t4-on-dark py-16">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-12 mb-12">
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 t4-bg-accent flex items-center justify-center"><i class="fas fa-hard-hat t4-ink text-xl"></i></div>
                        <div>
                            <div class="text-xl font-bold">{{ $siteTitle ?? config('app.name') }}</div>
                            <div class="text-xs t4-accent">للعقارات والمقاولات</div>
                        </div>
                    </div>
                    <p class="t4-muted-on-dark text-sm mb-6">شريكك الموثوق في الحلول العقارية والمقاولات منذ أكثر من 15 عاماً.</p>
                    <div class="flex gap-3">
                        @if(!empty($socialLinks['facebook'] ?? null))
                            <a href="{{ $socialLinks['facebook'] }}" target="_blank" rel="noopener" class="w-10 h-10 t4-bg-accent t4-bg-accent-hover flex items-center justify-center rounded transition" aria-label="فيسبوك"><i class="fab fa-facebook t4-ink"></i></a>
                        @endif
                        @if(!empty($socialLinks['twitter'] ?? null))
                            <a href="{{ $socialLinks['twitter'] }}" target="_blank" rel="noopener" class="w-10 h-10 t4-bg-accent t4-bg-accent-hover flex items-center justify-center rounded transition" aria-label="منصة إكس"><i class="fab fa-twitter t4-ink"></i></a>
                        @endif
                        @if(!empty($socialLinks['instagram'] ?? null))
                            <a href="{{ $socialLinks['instagram'] }}" target="_blank" rel="noopener" class="w-10 h-10 t4-bg-accent t4-bg-accent-hover flex items-center justify-center rounded transition" aria-label="إنستغرام"><i class="fab fa-instagram t4-ink"></i></a>
                        @endif
                        @if(!empty($socialLinks['linkedin'] ?? null))
                            <a href="{{ $socialLinks['linkedin'] }}" target="_blank" rel="noopener" class="w-10 h-10 t4-bg-accent t4-bg-accent-hover flex items-center justify-content-center rounded transition" aria-label="سناب شات"><i class="fab fa-linkedin t4-ink"></i></a>
                        @endif
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-6 t4-accent">روابط سريعة</h3>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#home" class="t4-muted-on-dark t4-hover-accent transition">الرئيسية</a></li>
                        <li><a href="#about" class="t4-muted-on-dark t4-hover-accent transition">من نحن</a></li>
                        <li><a href="#services" class="t4-muted-on-dark t4-hover-accent transition">الخدمات</a></li>
                        <li><a href="#projects" class="t4-muted-on-dark t4-hover-accent transition">المشاريع</a></li>
                        <li><a href="#testimonials" class="t4-muted-on-dark t4-hover-accent transition">آراء العملاء</a></li>
                        <li><a href="#contact" class="t4-muted-on-dark t4-hover-accent transition">اتصل بنا</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-6 t4-accent">خدماتنا</h3>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="t4-muted-on-dark t4-hover-accent transition">مقاولات البناء</a></li>
                        <li><a href="#" class="t4-muted-on-dark t4-hover-accent transition">التشطيب والديكور</a></li>
                        <li><a href="#" class="t4-muted-on-dark t4-hover-accent transition">الصيانة والترميم</a></li>
                        <li><a href="#" class="t4-muted-on-dark t4-hover-accent transition">التسويق العقاري</a></li>
                        <li><a href="#" class="t4-muted-on-dark t4-hover-accent transition">إدارة المشاريع</a></li>
                        <li><a href="#" class="t4-muted-on-dark t4-hover-accent transition">الاستشارات الهندسية</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-6 t4-accent">معلومات التواصل</h3>
                    <ul class="space-y-4 text-sm">
                        <li class="flex items-center gap-3"><i class="fas fa-phone t4-accent"></i><a href="{{ !empty($contactPhone) ? 'tel:'.preg_replace('/\s+/', '', $contactPhone) : '#' }}" class="t4-muted-on-dark t4-hover-accent transition">{{ $contactPhone ?? '—' }}</a></li>
                        <li class="flex items-center gap-3"><i class="fas fa-envelope t4-accent"></i><a href="{{ !empty($contactEmail) ? 'mailto:'.$contactEmail : '#' }}" class="t4-muted-on-dark t4-hover-accent transition">{{ $contactEmail ?? '—' }}</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t t4-border-deep pt-8 text-center t4-muted-on-dark text-sm">
                <p>&copy; {{ date('Y') }} {{ $siteTitle ?? config('app.name') }}. جميع الحقوق محفوظة.</p>
            </div>
        </div>
    </footer>

@endsection
