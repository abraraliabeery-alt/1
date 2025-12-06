@extends('layouts.app')

@section('head_extra')
@php
  $siteLogo = \App\Models\Setting::getValue('site_logo', config('brand.logo_path'));
  if ($siteLogo) {
    if (!\Illuminate\Support\Str::startsWith($siteLogo, ['http://','https://','/'])) {
      if (\Illuminate\Support\Facades\Storage::disk('public')->exists($siteLogo)) {
        $siteLogo = asset('storage/'.$siteLogo);
      } else {
        $siteLogo = asset($siteLogo);
      }
    }
  }
  $orgJson = [
    '@context' => 'https://schema.org',
    '@type' => 'Organization',
    'name' => 'شركة مدى الذهبية',
    'url' => url('/'),
    'logo' => $siteLogo ?: asset('img/logo/1.png'),
    'description' => 'شركة عقارية تقدم خدمات شراء وبيع وتأجير وإدارة أملاك، تقييم وتسويق عقاري واستشارات استثمارية، بخبرة محلية ورؤية احترافية.',
    'sameAs' => [],
  ];
@endphp
<script type="application/ld+json">{!! json_encode($orgJson, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<style>
  /* Landing radical redesign (scoped to landing sections) */
  #hero{ position:relative; min-height:76vh; display:grid; place-items:center; background:
    radial-gradient(1200px 800px at 120% -10%, rgba(252,174,65,.18), transparent 60%),
    linear-gradient(135deg, rgba(252,174,65,.22), transparent 48%),
    var(--bg);
  }
  #hero .hero-copy{ text-align:center; max-width: 80ch; margin-inline:auto }
  #hero h1{ font-weight:900; font-size: clamp(28px, 5vw, 48px); line-height:1.2; letter-spacing:.2px }
  #hero p{ color: color-mix(in oklab, var(--fg), transparent 40%); font-size: clamp(15px, 2.2vw, 18px); margin:.6rem auto 1rem }
  #hero .eyebrow{ display:inline-block; background: var(--primary); color:#000; font-weight:900; padding:.35rem .7rem; border-radius: 999px; letter-spacing:.3px }
  #hero ul{ display:flex; gap:.6rem; justify-content:center; flex-wrap:wrap; margin:.8rem 0 }
  #hero ul li{ background: var(--card); border:1px solid color-mix(in oklab, var(--fg), transparent 85%); padding:.35rem .6rem; border-radius:999px; font-weight:700 }
  #hero .hero-media{ display:none }
  @media (min-width:1024px){
    #hero .hero-media{ display:block }
    #hero .surface-box{ position:relative; width:460px; max-width:38vw; aspect-ratio:1/1; margin-inline:auto }
    #hero .surface-box::before{ content:""; position:absolute; inset:0; border-radius:999px; background: radial-gradient(closest-side, color-mix(in oklab, var(--primary), transparent 0%), transparent 70%); filter: saturate(120%) blur(0px) }
    #hero .hero-media-img{ position:relative; z-index:1; width:100%; height:100%; object-fit:cover; border-radius:28px; box-shadow: 0 24px 60px rgba(0,0,0,.35) }
  }
  #hero .side-label{ position:absolute; inset:auto auto 18% 12px; writing-mode:vertical-rl; transform: rotate(180deg); letter-spacing:.35rem; font-weight:900; font-size:.8rem; color: color-mix(in oklab, var(--fg), transparent 55%); display:none }
  @media (min-width:1280px){ #hero .side-label{ display:block } }
  /* Hero highlight + blobs */
  .hl{ background: linear-gradient(90deg, var(--primary), color-mix(in oklab, var(--primary), var(--fg) 20%)); -webkit-background-clip: text; background-clip:text; color: transparent; position: relative }
  .hl::after{ content:""; position:absolute; inset:auto 0 -2px 0; height:10px; background: color-mix(in oklab, var(--primary), transparent 70%); filter: blur(6px); border-radius:999px; z-index:-1 }
  .blob{ position:absolute; inset:auto; width:520px; height:520px; border-radius:50%; filter: blur(60px); opacity:.35; pointer-events:none; transform: translateZ(0) }
  .blob.b1{ right:-140px; top:-80px; background: radial-gradient(closest-side, var(--orb-1), transparent) }
  .blob.b2{ left:-160px; bottom:-120px; background: radial-gradient(closest-side, var(--orb-2), transparent) }

  /* Section rhythm */
  :root{ --accent: var(--primary) }
  .section{ padding-block: 72px }
  .section h2{ font-weight:900; font-size: clamp(22px, 3.2vw, 34px); margin:0 0 .6rem }
  .section.alt{ background: color-mix(in oklab, var(--bg), var(--fg) 4%) }
  /* Container + responsive helpers */
  .container{ width:min(1160px, 92vw); margin-inline:auto }
  .grid-2{ display:grid; grid-template-columns: 1fr 1fr; gap:1.2rem }
  @media (max-width:1024px){ .grid-2{ grid-template-columns: 1fr } }
  .grid-3{ display:grid; grid-template-columns: repeat(3, minmax(0,1fr)); gap:1rem }
  @media (max-width:1024px){ .grid-3{ grid-template-columns: 1fr 1fr } }
  @media (max-width:640px){ .grid-3{ grid-template-columns: 1fr } }
  /* Global link styling: no default blue/underline */
  a{ color: inherit; text-decoration: none }
  a:hover{ color: var(--primary); text-decoration: none }
  /* Decorative headings */
  .title-deco{ position:relative; display:inline-flex; align-items:center; gap:.6rem }
  .title-deco::before{ content:""; width:8px; height:8px; border-radius:50%; background: var(--accent, var(--primary)) }
  .title-deco::after{ content:""; display:block; width:64px; height:2px; background: color-mix(in oklab, var(--fg), transparent 75%) }

  /* Reveal on scroll */
  .reveal{ opacity:0; transform: translateY(16px); transition: opacity .5s ease, transform .5s ease }
  .reveal.in{ opacity:1; transform: translateY(0) }

  /* Products grid */
  #services .grid-3{ grid-template-columns: repeat(3, minmax(0,1fr)); }
  @media (max-width:1024px){ #services .grid-3{ grid-template-columns: 1fr 1fr } }
  @media (max-width:640px){ #services .grid-3{ grid-template-columns: 1fr } }
  #services .feature{ background: var(--card); border:1px solid color-mix(in oklab, var(--fg), transparent 85%); border-radius:16px; padding:16px; box-shadow: var(--shadow-sm) }
  #services .feature h4{ font-weight:800 }
  #services .feature .btn-link{ color: var(--primary); font-weight:800 }
  /* Remove underline for link-style buttons in landing */
  .btn-link{ text-decoration: none }

  /* Why Us */
  #why-us .grid-4{ display:grid; grid-template-columns: repeat(4, minmax(0,1fr)); gap:1rem }
  @media (max-width:1024px){ #why-us .grid-4{ grid-template-columns: 1fr 1fr } }
  @media (max-width:640px){ #why-us .grid-4{ grid-template-columns: 1fr } }

  /* Two-column narrative sections */
  #vision-mission .container, #goals-values .container{ gap: 1.2rem }
  #goals-values ul{ margin:.4rem 0 0 }

  /* Contact cards */
  #contact .grid-3{ grid-template-columns: repeat(3, minmax(0,1fr)); }
  @media (max-width:1024px){ #contact .grid-3{ grid-template-columns: 1fr 1fr } }
  @media (max-width:640px){ #contact .grid-3{ grid-template-columns: 1fr } }
  #contact .form-card{ background: var(--card); border:1px solid color-mix(in oklab, var(--fg), transparent 85%); border-radius:16px; padding:16px }
  #contact .aside{ display:flex; flex-direction:column; gap:12px }
  #contact label{ display:block; font-weight:700; font-size:.92rem; margin-bottom:.35rem }
  #contact input, #contact select, #contact textarea{ width:100%; border:1px solid color-mix(in oklab, var(--fg), transparent 85%); background: var(--bg); color: var(--fg); border-radius:10px; padding:.6rem .7rem }
  #contact .form-grid{ display:grid; grid-template-columns: 1fr 1fr; gap:.8rem }
  #contact .form-grid .full{ grid-column: 1 / -1 }
  @media (max-width:768px){ #contact .form-grid{ grid-template-columns: 1fr } }
  #contact .info-list{ display:grid; gap:.6rem }
  #contact .info-item{ display:flex; gap:.6rem; align-items:flex-start; padding:.6rem .8rem; background: color-mix(in oklab, var(--fg), transparent 94%); border-radius:12px }
  #contact .info-item i{ color:#000; background: var(--primary); width:28px; height:28px; border-radius:8px; display:grid; place-items:center }
  /* Carousel badges */
  #products-carousel .card .badge{ margin-inline-end:.4rem }
  /* Badge color variants */
  .badge.v1{ background: color-mix(in oklab, var(--primary), #fff 35%); color:#111 }
  .badge.v2{ background: color-mix(in oklab, var(--primary), #fff 15%); color:#111 }
  .badge.v3{ background: color-mix(in oklab, var(--primary), #000 10%); color:#111 }
  /* Glow cards */
  .glow{ position:relative }
  .glow::before{ content:""; position:absolute; inset:-1px; border-radius:16px; padding:1px; background: linear-gradient(135deg, color-mix(in oklab, var(--primary), transparent 0%), color-mix(in oklab, var(--fg), transparent 85%)); -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0); -webkit-mask-composite: xor; mask-composite: exclude; pointer-events:none }
  .glow:hover::before{ background: linear-gradient(135deg, var(--primary), color-mix(in oklab, var(--primary), var(--fg) 25%)) }
  /* Hide scrollbar for products carousel track */
  #products-carousel .pc-track{ scrollbar-width: none; -ms-overflow-style: none }
  #products-carousel .pc-track::-webkit-scrollbar{ width:0; height:0; display:none }
  /* Product card with thumbnail */
  .pc-card .thumb{ position:relative; overflow:hidden; border-radius:12px; margin-bottom:.6rem; aspect-ratio:4/3; background: color-mix(in oklab, var(--fg), transparent 92%) }
  .pc-card .thumb img{ width:100%; height:100%; object-fit:cover; transition: transform .35s ease }
  .pc-card:hover .thumb img{ transform: scale(1.06) }
  /* Tilt cards */
  .tilt{ transform-style: preserve-3d; transition: transform .15s ease, box-shadow .2s ease; will-change: transform }
  .tilt:hover{ box-shadow: 0 14px 34px rgba(0,0,0,.14) }
  /* Wave dividers */
  .wave{ line-height:0; height:48px; overflow:hidden }
  .wave svg{ display:block; width:100%; height:48px }
  /* Mobile CTA bar (disabled on mobile) */
  #mobile-cta{ position:fixed; inset:auto 0 12px 0; z-index:70; display:none; justify-content:center }
  #mobile-cta .bar{ display:flex; gap:.5rem; background:color-mix(in oklab, var(--card), transparent 0%); border:1px solid var(--border); box-shadow: 0 8px 24px rgba(0,0,0,.12); padding:.5rem; margin-inline:auto; border-radius:999px }
  /* تم إلغاء إظهار شريط CTA على شاشات الجوال */
  /* Button variants */
  .btn-ghost{ background:transparent; color: var(--fg); border:1px solid color-mix(in oklab, var(--fg), transparent 85%) }
  .btn-subtle{ background: color-mix(in oklab, var(--fg), transparent 94%); color: var(--fg); border:1px solid color-mix(in oklab, var(--fg), transparent 90%) }
  /* Badge micro animation */
  @keyframes popIn{ 0%{ transform: scale(.6); opacity:0 } 60%{ transform: scale(1.08); opacity:1 } 100%{ transform: scale(1) } }
  .value-card .badge, #goals .badge{ animation: popIn .45s ease both }
  /* Dark-mode fine tuning */
  [data-theme="dark"] .section.alt{ background: color-mix(in oklab, var(--bg), var(--fg) 8%) }
  [data-theme="dark"] .card{ border-color: color-mix(in oklab, var(--fg), transparent 80%) }
  .sheen{ position:relative; overflow:hidden }
  .sheen::after{ content:""; position:absolute; inset:0 -150% 0 100%; background:linear-gradient(120deg, transparent 0%, rgba(255,255,255,.22) 40%, transparent 60%); transform:skewX(-20deg); transition:transform .6s ease }
  .sheen:hover::after{ transform: translateX(-140%) skewX(-20deg) }
  #kpis .nums{ display:grid; grid-template-columns: repeat(4, minmax(0,1fr)); gap:1rem }
  #kpis .tile{ text-align:center }
  #kpis .num{ font-weight:900; font-size: clamp(26px,5vw,40px) }
  #kpis .lbl{ color: color-mix(in oklab, var(--fg), transparent 35%) }
  /* Clients marquee */
  #clients .marquee{ display:flex; overflow:hidden; mask-image: linear-gradient(90deg, transparent, #000 10%, #000 90%, transparent); -webkit-mask-image: linear-gradient(90deg, transparent, #000 10%, #000 90%, transparent) }
  #clients .track{ display:flex; gap:2.5rem; padding-block:.6rem; animation: scrollX 22s linear infinite }
  #clients img{ height:28px; opacity:.7; filter: grayscale(100%); transition: opacity .2s }
  #clients img:hover{ opacity:1 }
  @keyframes scrollX{ from{ transform: translateX(0) } to{ transform: translateX(-50%) } }
  /* Reduced motion */
  @media (prefers-reduced-motion: reduce){
    *{ animation-duration:.01ms !important; animation-iteration-count:1 !important; transition-duration:.01ms !important; scroll-behavior:auto !important }
    #clients .track{ animation:none }
  }
  /* Showcase blocks inspired by references */
  .showcase{ background:#fff; color:#111 }
  [data-theme="dark"] .showcase{ background: color-mix(in oklab, var(--bg), #fff 6%); color: var(--fg) }
  .showcase .wrap{ display:grid; grid-template-columns: 1.1fr .9fr; align-items:center; gap:2rem }
  .showcase .media{ position:relative }
  .platform{ position:absolute; inset:auto 10% -6% 10%; height:18px; border-radius:999px; background: radial-gradient(closest-side, rgba(0,0,0,.35), transparent 70%); filter: blur(6px) }
  .device{ width:100%; height:auto; border-radius:18px; box-shadow: 0 30px 80px rgba(0,0,0,.25) }
  .showcase h3{ font-size: clamp(22px,3vw,30px); margin:.4rem 0; color: var(--primary-700) }
  .showcase p{ color: #555 }
  [data-theme="dark"] .showcase p{ color: color-mix(in oklab, var(--fg), transparent 30%) }
  .showcase .actions{ display:flex; gap:.6rem; flex-wrap:wrap }
  @media (max-width:992px){ .showcase .wrap{ grid-template-columns: 1fr; text-align:center } .showcase .actions{ justify-content:center } }
  /* Before/After slider */
  .before-after{ position:relative; max-width:720px; margin-inline:auto; border-radius:16px; overflow:hidden }
  .before-after img{ display:block; width:100%; height:auto; object-fit:cover }
  .before-after .after{ position:absolute; inset:0; clip-path: inset(0 50% 0 0) }
  .before-after input[type=range]{ position:absolute; inset:auto 0 8px 0; width:60%; margin-inline:auto; display:block }
  /* Sticky sub-nav */
  #subnav{ position:sticky; top:0; z-index:60; backdrop-filter:saturate(140%) blur(8px); background: color-mix(in oklab, var(--bg), transparent 10%); border-bottom:1px solid color-mix(in oklab, var(--fg), transparent 88%); display:none }
  #subnav .inner{ display:flex; gap:.8rem; align-items:center; padding:.5rem 1rem; overflow:auto }
  #subnav a{ white-space:nowrap; padding:.35rem .7rem; border-radius:999px; color: inherit; text-decoration:none; border:1px solid transparent }
  #subnav a.active{ border-color: var(--accent); background: color-mix(in oklab, var(--accent), transparent 85%) }
  @media (min-width:768px){ #subnav{ display:block } }
  /* Cursor blob */
  #cursor-blob{ position:fixed; width:160px; height:160px; border-radius:50%; pointer-events:none; background: radial-gradient(closest-side, color-mix(in oklab, var(--accent), transparent 0%), transparent 70%); opacity:.18; transform: translate(-50%,-50%); z-index:20; display:none }
  @media (min-width:1024px){ #cursor-blob{ display:block } }
  /* FAQ */
  #faq .item{ border:1px solid color-mix(in oklab, var(--fg), transparent 85%); border-radius:12px; overflow:hidden }
  #faq summary{ list-style:none; cursor:pointer; padding:12px 14px; font-weight:800 }
  #faq summary::-webkit-details-marker{ display:none }
  #faq .content{ padding:0 14px 14px; color: color-mix(in oklab, var(--fg), transparent 35%) }
  /* Magnetic buttons */
  .magnet{ position:relative; will-change: transform }
  /* Floating FAB */
  #fab{ position:fixed; inset:auto 12px 12px auto; z-index:75; display:flex; flex-direction:column; gap:.5rem }
  #fab a{ width:48px; height:48px; display:grid; place-items:center; border-radius:999px; background: var(--primary); color:#000; box-shadow:0 10px 24px rgba(0,0,0,.18) }
  #fab a.secondary{ background: color-mix(in oklab, var(--fg), transparent 90%) }
  /* News marquee */
  #newsbar{ position:sticky; top:0; z-index:65; background: color-mix(in oklab, var(--accent), transparent 85%); color: inherit; border-bottom:1px solid color-mix(in oklab, var(--fg), transparent 85%); font-weight:700; display:none }
  #newsbar .wrap{ display:flex; gap:1rem; overflow:hidden; padding:.35rem 1rem }
  #newsbar .ticker{ white-space:nowrap; animation: tick 24s linear infinite }
  @keyframes tick{ from{ transform: translateX(0) } to{ transform: translateX(-50%) } }
  /* Values redesign */
  #values .value-grid{ display:grid; grid-template-columns: repeat(3, minmax(0,1fr)); gap:1rem }
  @media (max-width:1024px){ #values .value-grid{ grid-template-columns: 1fr 1fr } }
  @media (max-width:640px){ #values .value-grid{ grid-template-columns: 1fr } }
  #values .value-card{ background: var(--card); border:1px solid color-mix(in oklab, var(--fg), transparent 85%); border-radius:16px; padding:16px; display:flex; gap:12px; align-items:flex-start; transition: transform .2s ease, box-shadow .2s ease }
  #values .value-card:hover{ transform: translateY(-4px); box-shadow: 0 16px 40px rgba(0,0,0,.10) }
  #values .icon{ width:44px; height:44px; border-radius:12px; display:grid; place-items:center; background: color-mix(in oklab, var(--primary), #fff 22%); color:#000; flex:0 0 auto }
  #values .icon i{ font-size:20px }
  #values .content strong{ display:block; font-weight:900; margin-bottom:.2rem }
  #values .content p{ margin:0; color: color-mix(in oklab, var(--fg), transparent 35%) }
  /* Lucide icon helpers */
  .icon-inline{ display:inline-flex; align-items:center; margin-inline:.4rem }
  .card .body i.fa-solid, .card .body i.fa-regular, .card .body i.fa-brands{ font-size:18px }
  /* Template-matching styles */
  .tpl-hero{ padding-block: 72px }
  /* Enforce RTL direction for template blocks */
  .tpl-hero, .tpl-tiles, .tpl-about, .tpl-band, .tpl-services, .tpl-comm, .tpl-cta, .tpl-footerband{ direction: rtl }
  .tpl-title{ font-weight:900; font-size: clamp(28px,5vw,44px); line-height:1.15 }
  .tpl-emph{ color: var(--primary) }
  .tpl-lead{ color: color-mix(in oklab, var(--fg), transparent 35%); max-width:60ch }
  .tpl-hero-img{ width:100%; height:auto; border-radius:16px; box-shadow:0 30px 70px rgba(0,0,0,.18) }
  /* Glass overlay (merge S1) */
  .hero-media{ position:relative }
  .glass-card{ position:absolute; top:8%; right:8%; width:min(360px, 78%); background: color-mix(in oklab, var(--bg), transparent 35%); border:1px solid color-mix(in oklab, var(--fg), transparent 80%); border-radius:16px; padding:14px; backdrop-filter: blur(12px); box-shadow: 0 18px 48px rgba(0,0,0,.18) }
  .glass-card h4{ margin:0 0 .5rem; font-weight:900 }
  .glass-card .field{ display:flex; flex-direction:column; gap:.25rem; margin-bottom:.5rem }
  .glass-card input{ width:100%; border:1px solid color-mix(in oklab, var(--fg), transparent 85%); background: color-mix(in oklab, var(--bg), transparent 10%); color: var(--fg); border-radius:10px; padding:.55rem .6rem }
  .hero-actions{ display:flex; gap:.6rem; flex-wrap:wrap; margin-top:.6rem }
  .btn-ghost{ border:1px solid color-mix(in oklab, var(--fg), transparent 78%); background: transparent }
  @media (max-width:1024px){ .glass-card{ position:static; width:100%; margin-top:.8rem } }
  .tpl-tiles{ padding-block: 0 }
  .tiles{ display:grid; grid-template-columns: 1fr 1.5fr 1fr; gap:28px }
  .tiles .tile{ position:relative; padding:24px 22px; min-height:140px; display:flex; flex-direction:column; justify-content:center; align-items:center; text-align:center; border-radius:16px; box-shadow: 0 8px 18px rgba(0,0,0,.06); transition: transform .2s ease, box-shadow .2s ease }
  .tiles .tile:hover{ transform: translateY(-6px); box-shadow: 0 16px 36px rgba(0,0,0,.12) }
  .tiles .tile .ico{ width:44px; height:44px; border-radius:12px; display:grid; place-items:center; margin-bottom:.6rem; font-size:18px; background: color-mix(in oklab, var(--primary), #fff 65%); color:#000 }
  .tiles .tile:hover .ico{ transform: scale(1.06) }
  .tiles .tile.dark{ background: linear-gradient(180deg, #0e0f12, #0b0c0f); color:#f6f7f9 }
  [data-theme="dark"] .tiles .tile.dark{ background: linear-gradient(180deg, #0c0d10, #0a0b0e) }
  .tiles .tile.light{ background: color-mix(in oklab, var(--primary), #fff 88%) }
  .tiles .tile h3{ margin:0 0 .35rem; font-weight:900 }
  .tiles .tile.light p{ margin:0; color: color-mix(in oklab, var(--fg), transparent 35%) }
  .tiles .tile.dark p{ margin:0; color:#ffffff }
  /* Featured middle tile */
  .tiles .tile.featured{ min-height:200px; transform: translateY(-10px) }
  .tiles .tile.featured:hover{ transform: translateY(-14px) }
  .tiles .tile.dark.featured{ padding:20px 20px; color:#ffffff }
  @media (max-width:1024px){ .tiles{ grid-template-columns: 1fr; gap:12px } .tiles .tile{ border-radius:16px } .tiles .tile.featured{ transform:none } }
  .tpl-about .center{ text-align:center }
  .tpl-about .narrow{ max-width:60ch; margin-inline:auto; color: color-mix(in oklab, var(--fg), transparent 35%) }
  .tpl-band{ background: color-mix(in oklab, var(--primary), transparent 88%) }
  [data-theme="dark"] .tpl-band{ background: color-mix(in oklab, var(--primary), transparent 90%) }
  .band-img{ width:100%; border-radius:16px }
  .tpl-services .center{ text-align:center }
  /* Pastel decorative shape (merge S2) */
  .tpl-services{ position:relative; overflow:hidden }
  .tpl-services::before{ content:""; position:absolute; inset:-20% auto auto -10%; width:42%; height:70%; background: radial-gradient(80% 80% at 50% 50%, color-mix(in oklab, var(--primary), #fff 86%), transparent 70%); filter: blur(10px); opacity:.6; pointer-events:none }
  .tpl-services .icons-grid{ display:grid; grid-template-columns: repeat(3, minmax(0,1fr)); gap:1rem; margin-block:1rem }
  @media (max-width:1024px){ .tpl-services .icons-grid{ grid-template-columns: 1fr 1fr } }
  @media (max-width:640px){ .tpl-services .icons-grid{ grid-template-columns: 1fr } }
  .icon-card{ background: var(--card); border:1px solid color-mix(in oklab, var(--fg), transparent 88%); border-radius:14px; padding:18px; min-height:160px; display:flex; flex-direction:column; justify-content:center; align-items:center; text-align:center }
  .icon-card i{ font-size:20px; background: color-mix(in oklab, var(--primary), #fff 75%); color:#000; width:36px; height:36px; border-radius:10px; display:grid; place-items:center; margin-inline:auto; margin-bottom:.5rem }
  .tpl-comm{ background: color-mix(in oklab, var(--fg), transparent 94%) }
  [data-theme="dark"] .tpl-comm{ background: color-mix(in oklab, var(--fg), transparent 92%) }
  .tpl-cta{ background: color-mix(in oklab, var(--primary), transparent 80%); padding-block:28px }
  .tpl-cta .cta-inner{ display:flex; justify-content:space-between; align-items:center; gap:1rem }
  @media (max-width:768px){ .tpl-cta .cta-inner{ flex-direction:column; text-align:center } }
  .tpl-footerband{ padding-block: 24px; background: var(--bg) }
  .center{ text-align:center }
  .narrow{ max-width:65ch }
  /* Section spacing & separators */
  .section{ padding-block: 48px }
  .section + .section{ position:relative }
  .section + .section::before{ content:""; display:block; height:1px; background: color-mix(in oklab, var(--fg), transparent 85%); margin: 8px 0 20px; border-radius:999px }
  /* Section headers */
  .title-deco{ position:relative; display:inline-block; padding-bottom:.2rem; font-weight:900 }
  .title-deco::after{ content:""; position:absolute; inset:auto 0 -6px auto; height:3px; width:46%; background: color-mix(in oklab, var(--primary), #fff 20%); border-radius:999px }
  /* Buttons polish */
  .btn{ padding:.6rem 1rem; border-radius:10px; font-weight:800 }
  .btn-primary:hover{ filter: saturate(120%) contrast(1.05) }
  .btn-outline{ border:1px solid color-mix(in oklab, var(--fg), transparent 80%) }
  .btn-outline:hover{ background: color-mix(in oklab, var(--fg), transparent 92%) }
  /* KPIs */
  .tpl-kpis .kpi-grid{ display:grid; grid-template-columns: repeat(4, minmax(0,1fr)); gap:16px }
  @media (max-width:1024px){ .tpl-kpis .kpi-grid{ grid-template-columns: 1fr 1fr } }
  @media (max-width:640px){ .tpl-kpis .kpi-grid{ grid-template-columns: 1fr } }
  .kpi{ background: var(--card); border:1px solid color-mix(in oklab, var(--fg), transparent 88%); border-radius:14px; padding:16px; text-align:center }
  .kpi .num{ font-size: clamp(22px,3.4vw,32px); font-weight:900; display:block }
  .kpi .lbl{ color: color-mix(in oklab, var(--fg), transparent 35%) }
  /* Clients strip */
  .tpl-clients{ background: color-mix(in oklab, var(--fg), transparent 94%) }
  [data-theme="dark"] .tpl-clients{ background: color-mix(in oklab, var(--fg), transparent 92%) }
  .clients-row{ display:grid; grid-template-columns: repeat(6, minmax(0,1fr)); gap:12px; align-items:center }
  @media (max-width:1024px){ .clients-row{ grid-template-columns: repeat(3, 1fr) } }
  @media (max-width:640px){ .clients-row{ grid-template-columns: repeat(2, 1fr) } }
  .client{ background: var(--bg); border:1px dashed color-mix(in oklab, var(--fg), transparent 85%); border-radius:12px; padding:12px; display:grid; place-items:center; transition: transform .2s ease }
  .client img{ max-width:100%; max-height:40px; filter: grayscale(1); opacity:.75; transition: all .2s ease }
  .client:hover{ transform: translateY(-2px) }
  .client:hover img{ filter:none; opacity:1 }
  /* Products (static) */
  .tpl-products .center{ text-align:center }
  .products-grid{ display:grid; grid-template-columns: repeat(4, minmax(0,1fr)); gap:16px }
  @media (max-width:1024px){ .products-grid{ grid-template-columns: 1fr 1fr } }
  @media (max-width:640px){ .products-grid{ grid-template-columns: 1fr } }
  .product-card{ background: var(--card); border:1px solid color-mix(in oklab, var(--fg), transparent 88%); border-radius:14px; overflow:hidden; display:flex; flex-direction:column }
  .product-card .imgwrap{ position:relative; aspect-ratio: 4/3; background: linear-gradient(180deg, color-mix(in oklab, var(--primary), #fff 88%), transparent) }
  .product-card img{ width:100%; height:100%; object-fit:cover; display:block }
  .product-card .body{ padding:12px 14px; display:flex; flex-direction:column; gap:.35rem }
  .product-card .name{ font-weight:900; margin:0; font-size:1rem }
  .product-card .meta{ color: color-mix(in oklab, var(--fg), transparent 40%); font-size:.9rem }
  .product-card .row{ display:flex; justify-content:space-between; align-items:center; gap:.6rem; margin-top:.3rem }
  .price{ font-weight:900 }
  /* Objectives - Minimal (A) */
  .tpl-objectives{ background: none }
  .obj-head{ text-align:center; margin-bottom:.8rem }
  .obj-head h2{ font-size: clamp(22px,4vw,34px); font-weight:900; margin:0 }
  .obj-grid{ display:grid; grid-template-columns: 1fr 1fr; gap:14px }
  @media (max-width:768px){ .obj-grid{ grid-template-columns: 1fr; gap:10px } }
  .obj-card{ background: var(--bg); border:1px solid color-mix(in oklab, var(--fg), transparent 86%); border-radius:12px; padding:16px 16px }
  .obj-card .txt{ margin:0; font-size:.98rem; line-height:1.7; font-weight:700 }
  .obj-card .num{ position:absolute; inset:auto 10px 10px auto; font-weight:900; color: color-mix(in oklab, var(--primary), #000 10%); font-size:16px }
  /* Testimonials */
  .tpl-testimonials .t-grid{ display:grid; grid-template-columns: repeat(3, minmax(0,1fr)); gap:16px }
  @media (max-width:1024px){ .tpl-testimonials .t-grid{ grid-template-columns: 1fr 1fr } }
  @media (max-width:640px){ .tpl-testimonials .t-grid{ grid-template-columns: 1fr } }
  .t-card{ background: var(--card); border:1px solid color-mix(in oklab, var(--fg), transparent 88%); border-radius:14px; padding:16px; position:relative }
  .t-card .quote{ color: color-mix(in oklab, var(--fg), transparent 35%) }
  .t-card .author{ display:flex; align-items:center; gap:.6rem; margin-top:.8rem; font-weight:800 }
  .t-card .avatar{ width:36px; height:36px; border-radius:50%; background: color-mix(in oklab, var(--primary), #fff 55%) }
  /* Testimonials slider (mobile) */
  @media (max-width:768px){ .tpl-testimonials .t-grid{ display:flex; gap:12px; overflow-x:auto; scroll-snap-type:x mandatory; padding-bottom:4px } .tpl-testimonials .t-card{ flex:0 0 85%; scroll-snap-align:center } }
  /* Reveal on scroll */
  .reveal{ opacity:0; transform: translateY(10px); transition: opacity .45s ease, transform .45s ease }
  .reveal.reveal-in, .reveal.in{ opacity:1; transform:none }
  /* Footer */
  .site-footer{ background: color-mix(in oklab, var(--fg), transparent 94%); padding-block:44px; border-top:1px solid color-mix(in oklab, var(--fg), transparent 88%); box-shadow: inset 0 8px 24px rgba(0,0,0,.035) }
  [data-theme="dark"] .site-footer{ background: color-mix(in oklab, var(--fg), transparent 92%) }
  .site-footer .cols{ display:grid; grid-template-columns: 2fr 1fr 1fr; gap:24px; align-items:start }
  @media (max-width:1024px){ .site-footer .cols{ grid-template-columns: 1fr 1fr; gap:16px } }
  @media (max-width:640px){ .site-footer .cols{ grid-template-columns: 1fr } }
  .site-footer .muted{ color: color-mix(in oklab, var(--fg), transparent 40%) }
  .footer-heading{ font-weight:900; margin:0 0 .4rem }
  .footer-list{ list-style:none; padding:0; margin:.2rem 0 0; display:grid; gap:.25rem }
  .footer-list a{ color: inherit }
  .footer-list a:hover{ color: var(--primary) }
  .site-footer .about p{ margin:.25rem 0 0 }
  .socials{ display:flex; gap:.5rem; margin-top:.6rem }
  .socials a{ width:34px; height:34px; display:grid; place-items:center; border-radius:10px; background: color-mix(in oklab, var(--fg), transparent 92%) }
  .socials a:hover{ background: color-mix(in oklab, var(--primary), #fff 80%) }
</style>
@endsection

@section('content')
  <!-- Scroll Progress Bar -->
  <div class="scroll-progress" aria-hidden="true"><span></span></div>

<!-- Floating action buttons -->
<div id="fab" aria-label="اختصارات">
  <a href="https://wa.me/966503310071" target="_blank" rel="noopener" title="WhatsApp">WA</a>
  <a href="tel:0503310071" class="secondary" title="اتصل">☎</a>
  <div id="cursor-blob" aria-hidden="true"></div>
</div>
  

  <main>
    {{-- Flash messages and validation errors --}}
    <div class="container mt-16">
      @if(session('ok'))
        <div class="alert alert-success mb-12" role="status" aria-live="polite">
          <strong>تم:</strong> {{ session('ok') }}
        </div>
      @endif
      @if($errors->any())
        <div class="alert alert-danger mb-12" role="alert">
          <strong>حدثت أخطاء:</strong>
          <ul class="list-compact">
            @foreach($errors->all() as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
        </div>
      @endif
    </div>
    <!-- Template-Matched Layout -->
    <section class="tpl-hero section">
      <div class="container grid-2" style="align-items:center">
        <div>
          <h1 class="tpl-title">شركة مدى الذهبية<br><span class="tpl-emph">بيع وشراء وتأجير وإدارة أملاك باحترافية</span></h1>
          <p class="tpl-lead">نقدّم حلولاً عقارية متكاملة تشمل التسويق العقاري والوساطة وإدارة الأملاك والتقييم والاستشارات الاستثمارية. نلتزم بالشفافية والموثوقية ونبني شراكات طويلة الأمد مع عملائنا.</p>
          <div class="hero-actions">
            <a href="#contact" class="btn btn-primary magnet">تواصل معنا الآن</a>
            <a href="#services" class="btn btn-ghost">استعرض الخدمات</a>
          </div>
        </div>
        <div class="hero-media">
          @php(
            $heroSetting = \App\Models\Setting::getValue('hero_image')
          )
          @php(
            $hero = (!empty($heroSetting)) ? $heroSetting : asset('assets/hero-smart-home.jpg')
          )
          <img src="{{ $hero }}" alt="صورة هيرو" class="tpl-hero-img" onerror="this.onerror=null; this.src='{{ asset('assets/hero-smart-home.jpg') }}'" />
        </div>
      </div>
    </section>

    

 

    <section class="section" id="properties-grid">
      <style>
        :root{ --ep-radius:20px; --ep-shadow:0 10px 30px rgba(0,0,0,.15); --ep-price:#22c55e }
        .ep-wrap{ width:min(1160px,92vw); margin-inline:auto }
        .ep-head{ display:flex; justify-content:space-between; align-items:center; gap:10px; margin-bottom:16px }
        .ep-head h3{ margin:0; font-weight:900; font-size:clamp(20px,3vw,28px) }
        .ep-grid{ display:grid; grid-template-columns:repeat(auto-fill,minmax(320px,1fr)); gap:24px }
        .ep-card{ background: var(--card); border:1px solid var(--border); border-radius: var(--ep-radius); overflow:hidden; box-shadow: var(--ep-shadow) }
        .ep-card img{ width:100%; height:230px; object-fit:cover; display:block }
        .ep-body{ padding:16px 18px 18px; color: var(--fg) }
        .ep-body h4{ margin:0; font-size:18px; font-weight:800; display:flex; align-items:center; gap:8px }
        .ep-loc{ font-size:14px; color: color-mix(in oklab, var(--fg), transparent 45%); margin:6px 0 10px; display:flex; align-items:center; gap:6px }
        .ep-feats{ display:flex; flex-wrap:wrap; gap:8px; margin-bottom:12px }
        .ep-badge{ background: color-mix(in oklab, var(--fg), transparent 94%); border:1px solid var(--border); border-radius:999px; padding:6px 10px; font-size:12px; display:flex; align-items:center; gap:6px }
        .ep-price{ color: var(--ep-price); font-weight:900; font-size:18px; margin-bottom:12px; display:flex; align-items:center; gap:8px }
        .ep-actions{ display:flex; gap:10px }
        .ep-btn{ flex:1; padding:10px; border:none; border-radius:12px; font-weight:800; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px }
        .ep-btn.details{ background: var(--bg); color: var(--fg); border:1px solid var(--border) }
        .ep-btn.contact{ background: var(--primary); color:#000 }
      </style>
      <div class="ep-wrap">
        <div class="ep-head">
          <h3><i class="fa-solid fa-city" style="color:var(--primary)"></i> أحدث العقارات</h3>
          <a href="{{ route('properties.index') }}" class="btn btn-outline">عرض الكل</a>
        </div>
        <div class="ep-grid">
          @forelse(($properties ?? collect()) as $p)
            <div class="ep-card">
              <a href="{{ route('properties.show', $p) }}" class="d-block">
                @php($fallbackImg = 'https://images.unsplash.com/photo-1523217582562-09d0def993a6?q=80&w=1200&auto=format&fit=crop')
                @php($gallery = is_array($p->gallery ?? null) ? $p->gallery : [])
                @php($first = $gallery[0] ?? null)
                @php($src = $p->cover_image_url ?? $fallbackImg)
                @if(!$p->cover_image_url && $first)
                  @php($src = \Illuminate\Support\Str::startsWith($first, ['http://','https://']) ? $first : (\Illuminate\Support\Facades\Storage::disk('public')->exists($first) ? asset('storage/'.$first) : $fallbackImg))
                @endif
                <img src="{{ $src }}" alt="{{ $p->title }}" onerror="this.onerror=null;this.src='{{ $fallbackImg }}'">
              </a>
              <div class="ep-body">
                <h4><i class="fa-solid fa-house-chimney" style="color:var(--primary)"></i> {{ $p->title }}</h4>
                <div class="ep-loc"><i class="fa-solid fa-location-dot" style="color:var(--primary)"></i> {{ $p->city }} @if($p->district) - {{ $p->district }} @endif</div>
                <div class="ep-feats">
                  <span class="ep-badge"><i class="fa-solid fa-bed"></i>{{ $p->bedrooms ?? '-' }} غرف</span>
                  <span class="ep-badge"><i class="fa-solid fa-toilet"></i>{{ $p->bathrooms ?? '-' }} حمام</span>
                  <span class="ep-badge"><i class="fa-solid fa-ruler-combined"></i>{{ $p->area ?? '-' }} م²</span>
                </div>
                <div class="ep-price"><i class="fa-solid fa-coins"></i>{{ number_format($p->price) }} ر.س</div>
                <div class="ep-actions">
                  <a href="{{ route('properties.show', $p) }}" class="ep-btn details"><i class="fa-solid fa-circle-info"></i> تفاصيل</a>
                  <a href="{{ route('properties.show', $p) }}?contact=1" class="ep-btn contact"><i class="fa-solid fa-phone"></i> تواصل</a>
                </div>
              </div>
            </div>
          @empty
            <div class="center" style="color: color-mix(in oklab, var(--fg), transparent 45%)">لا توجد عقارات حالياً.</div>
          @endforelse
        </div>
      </div>
    </section>

    <!-- KPIs (moved up under hero) -->
    <section id="kpis" class="tpl-kpis section reveal">
      <div class="container">
        <div class="kpi-grid">
          <div class="kpi"><span class="num" data-to="10">0</span><span class="lbl">سنوات خبرة</span></div>
          <div class="kpi"><span class="num" data-to="250">0</span><span class="lbl">عميل سعيد</span></div>
          <div class="kpi"><span class="num" data-to="1500">0</span><span class="lbl">مشروع مُنجز</span></div>
          <div class="kpi"><span class="num" data-to="24">0</span><span class="lbl">دعم ومتابعة</span></div>
        </div>
      </div>
    </section>
    

    <section class="tpl-tiles section reveal">
      <div class="container tiles">
        <article class="tile light">
          <span class="ico"><i class="fa-solid fa-building"></i></span>
          <h3>استشارات واستثمار</h3>
          <p>توجيه استثماري مبني على بيانات السوق لتحقيق أفضل عائد.</p>
        </article>
        <article class="tile dark featured">
          <span class="ico" style="background: color-mix(in oklab, var(--primary), #fff 35%)"><i class="fa-solid fa-shield-check"></i></span>
          <h3>شفافية وموثوقية</h3>
          <p>إجراءات واضحة وتقارير دقيقة تحفظ حقوق جميع الأطراف.</p>
        </article>
        <article class="tile light">
          <span class="ico"><i class="fa-solid fa-key"></i></span>
          <h3>إدارة التأجير</h3>
          <p>إدارة عقود وتحصيل ومتابعة صيانة لضمان استدامة الأصل.</p>
        </article>
      </div>
    </section>

    <section class="tpl-about section">
      <div class="container center">
        <h2 class="title-deco">عن الشركة</h2>
        <p class="narrow">نحن شركة عقارية سعودية تقدّم حلول بيع وشراء وتأجير وإدارة أملاك وتسويق عقاري وتقييم واستشارات استثمارية، برؤية تركز على الشفافية والنتائج وبناء علاقات طويلة الأمد.</p>
        <a href="#services" class="btn btn-outline">اقرأ المزيد</a>
      </div>
    </section>

    <section id="services" class="tpl-services section reveal">
      <div class="container center">
        <h2 class="title-deco">خدماتنا</h2>
         <div class="icons-grid">
          <div class="icon-card"><i class="fa-solid fa-bullhorn"></i><strong>التسويق العقاري</strong><p>حملات موجهة وتصوير احترافي وإعلانات مدفوعة لرفع الوصول.</p></div>
          <div class="icon-card"><i class="fa-regular fa-handshake"></i><strong>الوساطة العقارية</strong><p>توفيق البائعين والمشترين وإتمام الصفقات بسلاسة وأمان.</p></div>
          <div class="icon-card"><i class="fa-solid fa-key"></i><strong>إدارة الأملاك</strong><p>تحصيل وإدارة عقود ومتابعة صيانة وتقرير أداء دوري.</p></div>
          <div class="icon-card"><i class="fa-solid fa-scale-balanced"></i><strong>التقييم العقاري</strong><p>تقارير تقييم معتمدة تدعم القرارات الاستثمارية والتمويل.</p></div>
          <div class="icon-card"><i class="fa-solid fa-diagram-project"></i><strong>إدارة المشاريع</strong><p>تنسيق تنفيذ وتطوير وحدات واستغلال أمثل للأصول.</p></div>
          <div class="icon-card"><i class="fa-solid fa-chart-line"></i><strong>استشارات واستثمار</strong><p>تحليل سوق وفرص استثمارية وبناء محافظ عقارية متوازنة.</p></div>
        </div>
        <a href="#contact" class="btn btn-subtle">اعرف المزيد</a>
      </div>
    </section>

    <!-- Clients strip (moved below services) -->
    <section class="tpl-clients section reveal">
      <div class="container">
        <div class="clients-row">
          <div class="client"><img src="{{ asset('assets/top.png') }}" alt="عميل" onerror="this.style.opacity=.35"></div>
          <div class="client"><img src="{{ asset('assets/top.png') }}" alt="عميل" onerror="this.style.opacity=.35"></div>
          <div class="client"><img src="{{ asset('assets/top.png') }}" alt="عميل" onerror="this.style.opacity=.35"></div>
          <div class="client"><img src="{{ asset('assets/top.png') }}" alt="عميل" onerror="this.style.opacity=.35"></div>
          <div class="client"><img src="{{ asset('assets/top.png') }}" alt="عميل" onerror="this.style.opacity=.35"></div>
          <div class="client"><img src="{{ asset('assets/top.png') }}" alt="عميل" onerror="this.style.opacity=.35"></div>
        </div>
      </div>
    </section>

    <section class="tpl-comm section">
      <div class="container grid-2" style="align-items:center">
        <div>
          <h3>نسعى للتميّز بخدمة احترافية</h3>
          <p>فريقنا المتخصص يعمل بروح التعاون والالتزام لتحقيق رضا العملاء وبناء علاقات متينة ومستدامة معهم.</p>
          <a href="#contact" class="btn btn-primary">اتصل بنا</a>
        </div>
        <div><img src="{{ asset('assets/hero-smart-home.jpg') }}" alt="تواصل" class="band-img" loading="lazy" decoding="async" onerror="this.style.display='none'" /></div>
      </div>
    </section>


    <!-- Clients strip -->
    <section class="tpl-clients section">
      <div class="container">
        <div class="clients-row">
          <div class="client"><img src="{{ asset('assets/top.png') }}" alt="عميل" onerror="this.style.opacity=.35"></div>
          <div class="client"><img src="{{ asset('assets/top.png') }}" alt="عميل" onerror="this.style.opacity=.35"></div>
          <div class="client"><img src="{{ asset('assets/top.png') }}" alt="عميل" onerror="this.style.opacity=.35"></div>
          <div class="client"><img src="{{ asset('assets/top.png') }}" alt="عميل" onerror="this.style.opacity=.35"></div>
          <div class="client"><img src="{{ asset('assets/top.png') }}" alt="عميل" onerror="this.style.opacity=.35"></div>
          <div class="client"><img src="{{ asset('assets/top.png') }}" alt="عميل" onerror="this.style.opacity=.35"></div>
        </div>
      </div>
    </section>

    <!-- Testimonials -->
    <section class="tpl-testimonials section">
      <div class="container">
        <h2 class="title-deco">ماذا يقول عملاؤنا</h2>
        <div class="t-grid">
          <article class="t-card">
            <p class="quote">بيعنا وحدتنا خلال أسابيع مع تغطية تسويقية ممتازة وتفاوض محترف.</p>
            <div class="author"><span class="avatar"></span><span>مالك شقة سكنية</span></div>
          </article>
          <article class="t-card">
            <p class="quote">إدارة أملاك دقيقة وتقارير شهرية أوضحت لنا العوائد والتكاليف.</p>
            <div class="author"><span class="avatar"></span><span>شركة استثمار عقاري</span></div>
          </article>
          <article class="t-card">
            <p class="quote">تقييم عقاري مهني ساعدنا في الحصول على تمويل مناسب للمشروع.</p>
            <div class="author"><span class="avatar"></span><span>مطور مشروع تجاري</span></div>
          </article>
        </div>
      </div>
    </section>

    <section class="tpl-cta">
      <div class="container cta-inner">
        <div>
          <h4>لنبدأ اليوم!</h4>
          <p>أخبرنا باحتياجك لنقدّم لك أفضل عرض.</p>
        </div>
        <div class="cta-actions">
          <a href="#contact" class="btn btn-primary">تواصل معنا</a>
          <a href="https://wa.me/966503310071" class="btn btn-outline" target="_blank" rel="noopener">WhatsApp</a>
        </div>
      </div>
    </section>

    <!-- New Contact section (modern) -->
    <section id="contact" class="section">
      <div class="container grid-2">
        <div class="aside">
          <h2><span class="title-deco">تواصل معنا</span></h2>
          <p>يسعدنا خدمتك والإجابة على استفساراتك وتقديم أفضل عرض يناسب مشروعك.</p>
          <div class="info-list">
            <div class="info-item"><i class="fa-solid fa-phone"></i><div><strong>الجوال</strong><div><a href="tel:0503310071">0503310071</a></div></div></div>
            <div class="info-item"><i class="fa-brands fa-whatsapp"></i><div><strong>واتساب</strong><div><a href="https://wa.me/966503310071" target="_blank" rel="noopener">راسلنا مباشرة</a></div></div></div>
            <div class="info-item"><i class="fa-regular fa-envelope"></i><div><strong>البريد</strong><div><a href="mailto:tour@tourcons.com">tour@tourcons.com</a></div></div></div>
          </div>
        </div>
        <div class="form-card">
          <form id="contact-form-new" action="{{ route('contact.home.store') }}" method="POST" novalidate>
            @csrf
            <div class="form-grid">
              <div>
                <label for="name">الاسم</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="اسمك الكامل" required minlength="2" autocomplete="name" class="@error('name') is-invalid @enderror">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div>
                <label for="phone">رقم الجوال</label>
                <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" placeholder="05xxxxxxxx" required inputmode="numeric" pattern="^0?5\d{8}$" autocomplete="tel" class="@error('phone') is-invalid @enderror">
                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="full">
                <label for="email">البريد الإلكتروني (اختياري)</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="you@example.com" autocomplete="email" class="@error('email') is-invalid @enderror">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="full">
                <label for="type">نوع الخدمة العقارية</label>
                <select id="type" name="type" required class="@error('type') is-invalid @enderror">
                  <option value="">اختر النوع</option>
                  <option {{ old('type')==='شراء عقار' ? 'selected' : '' }}>شراء عقار</option>
                  <option {{ old('type')==='بيع عقار' ? 'selected' : '' }}>بيع عقار</option>
                  <option {{ old('type')==='تأجير/استئجار' ? 'selected' : '' }}>تأجير/استئجار</option>
                  <option {{ old('type')==='إدارة أملاك' ? 'selected' : '' }}>إدارة أملاك</option>
                  <option {{ old('type')==='تقييم عقاري' ? 'selected' : '' }}>تقييم عقاري</option>
                  <option {{ old('type')==='استشارات واستثمار' ? 'selected' : '' }}>استشارات واستثمار</option>
                  <option {{ old('type')==='أخرى' ? 'selected' : '' }}>أخرى</option>
                </select>
                @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="full">
                <label for="message">رسالتك</label>
                <textarea id="message" name="message" rows="5" placeholder="اكتب تفاصيل استفسارك" required maxlength="2000" class="@error('message') is-invalid @enderror">{{ old('message') }}</textarea>
                @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
            </div>
            <div style="margin-top:.8rem; display:flex; gap:.6rem; flex-wrap:wrap">
              <button class="btn btn-primary" type="submit">إرسال</button>
              <a class="btn btn-outline" href="https://wa.me/966503310071" target="_blank" rel="noopener">WhatsApp</a>
            </div>
          </form>
        </div>
      </div>
    </section>

  </main>
@endsection

<script>
  document.addEventListener('DOMContentLoaded', function(){
    const track = document.getElementById('pc-track');
    const prev = document.getElementById('pc-prev');
    const next = document.getElementById('pc-next');
    if(track && prev && next){
      const step = 320;
      prev.addEventListener('click', () => track.scrollBy({ left: -step, behavior: 'smooth' }));
      next.addEventListener('click', () => track.scrollBy({ left: step, behavior: 'smooth' }));
    }
    // Reveal on scroll
    const ro = new IntersectionObserver((entries)=>{
      entries.forEach(e=>{
        if(e.isIntersecting){ e.target.classList.add('in'); ro.unobserve(e.target); }
      });
    }, { threshold: .12 });
    document.querySelectorAll('.reveal').forEach(el=>ro.observe(el));
    // Tilt on hover (pointer devices)
    const tilts = Array.from(document.querySelectorAll('.tilt'));
    const max = 10;
    tilts.forEach(card=>{
      card.addEventListener('mousemove', (ev)=>{
        const r = card.getBoundingClientRect();
        const x = ev.clientX - r.left; const y = ev.clientY - r.top;
        const rx = ((y / r.height) - .5) * -2 * max;
        const ry = ((x / r.width) - .5) * 2 * max;
        card.style.transform = `perspective(800px) rotateX(${rx}deg) rotateY(${ry}deg)`;
      });
      card.addEventListener('mouseleave', ()=>{
        card.style.transform = 'perspective(800px) rotateX(0deg) rotateY(0deg)';
      });
    });
    // KPI counters
    const kpiNums = Array.from(document.querySelectorAll('#kpis .num'));
    if(kpiNums.length){
      const once = new Set();
      const ko = new IntersectionObserver((entries)=>{
        entries.forEach(en=>{
          if(en.isIntersecting){
            const el = en.target; if(once.has(el)) return; once.add(el);
            const to = parseInt(el.getAttribute('data-to')||'0',10);
            const dur = 1200; const t0 = performance.now();
            const tick = (now)=>{
              const p = Math.min(1, (now - t0)/dur);
              const val = Math.floor(to * (1 - Math.pow(1-p, 3)));
              el.textContent = val.toLocaleString('ar-SA');
              if(p<1) requestAnimationFrame(tick);
            };
            requestAnimationFrame(tick);
            ko.unobserve(el);
          }
        });
      }, { threshold: .3 });
      kpiNums.forEach(n=>ko.observe(n));
    }
    // Mobile CTA
    const ctabar = document.getElementById('mobile-cta');
    if(ctabar){ setTimeout(()=> ctabar.hidden = false, 600); }
    // Sticky subnav active state + accent updates
    const subnav = document.getElementById('subnav');
    const links = subnav ? Array.from(subnav.querySelectorAll('a')) : [];
    const sections = links.map(a=>document.querySelector(a.getAttribute('href'))).filter(Boolean);
    const so = new IntersectionObserver((ents)=>{
      ents.forEach(en=>{
        if(en.isIntersecting){
          const id = '#' + en.target.id;
          links.forEach(l=>l.classList.toggle('active', l.getAttribute('href')===id));
          document.documentElement.style.setProperty('--accent', getComputedStyle(document.documentElement).getPropertyValue('--primary'));
        }
      })
    }, { threshold:.4 });
    sections.forEach(s=>so.observe(s));
    // Cursor blob follow
    const blob = document.getElementById('cursor-blob');
    if(blob){
      window.addEventListener('pointermove', (e)=>{
        blob.style.left = e.clientX + 'px';
        blob.style.top = e.clientY + 'px';
      }, { passive:true });
    }
    // Magnetic buttons
    document.querySelectorAll('.magnet').forEach(btn=>{
      btn.addEventListener('mousemove', (ev)=>{
        const r = btn.getBoundingClientRect();
        const dx = (ev.clientX - (r.left + r.width/2)) / r.width;
        const dy = (ev.clientY - (r.top + r.height/2)) / r.height;
        btn.style.transform = `translate(${dx*6}px, ${dy*6}px)`;
      });
      btn.addEventListener('mouseleave', ()=>{ btn.style.transform = 'translate(0,0)'; });
    });
    // Before/After slider control
    const ba = document.querySelector('#beforeAfter');
    if(ba){
      const range = ba.querySelector('input[type=range]');
      const after = ba.querySelector('.after');
      const update = ()=>{ const v = +range.value; after.style.clipPath = `inset(0 ${100-v}% 0 0)`; };
      range.addEventListener('input', update); update();
    }
    // Show newsbar when JS ready
    const nb = document.getElementById('newsbar'); if(nb){ nb.style.display = 'block'; }
    // Lucide icons init
    if(window.lucide && typeof window.lucide.createIcons === 'function'){
      window.lucide.createIcons();
    }
    
  });
</script>

<!-- Mobile sticky CTA bar -->
<div id="mobile-cta" hidden>
  <div class="bar">
    <a class="btn" href="tel:0503310071">اتصل الآن</a>
    <a class="btn btn-outline" href="https://wa.me/966503310071" target="_blank" rel="noopener">WhatsApp</a>
    <a class="btn btn-outline" href="#contact">تواصل معنا</a>
  </div>
</div>
