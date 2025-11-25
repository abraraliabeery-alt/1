<?php
$brand = \App\Models\Setting::getValue('color_primary', config('brand.color'));
$siteName = \App\Models\Setting::getValue('site_title', config('brand.name'));
$siteLogo = \App\Models\Setting::getValue('site_logo', asset(config('brand.logo_path')));
$coverSrc = $tender->cover_image_url ?? $tender->cover_image ?? asset('assets/company-profile-cover.jpg');
?>
<section class="hero-cover" style="position:relative; min-height:297mm;">
  <style>
    .hero-wrap{ position:relative; height:297mm; color:#fff; }
    .hero-img{ position:absolute; inset:0; width:100%; height:100%; object-fit:cover; filter: saturate(110%); }
    .hero-overlay{ position:absolute; inset:0; background: linear-gradient(180deg, rgba(0,0,0,.55), rgba(0,0,0,.65)); }
    .hero-brand{ position:absolute; left:0; right:0; bottom:0; height:10mm; background: <?= $brand ?>; opacity:.9 }
    .hero-head{ position:absolute; top:20mm; right:20mm; display:flex; gap:8mm; align-items:center }
    .hero-head img{ height:18mm; background:#fff; border-radius:6mm; padding:2mm }
    .hero-title{ position:absolute; top:50%; right:10%; transform:translateY(-50%); max-width:110mm }
    .hero-title h1{ margin:0 0 6mm; font-size:18mm; font-weight:900 }
    .hero-title .sub{ font-weight:800; color:#e5e7eb; font-size:5mm }
    .hero-badges{ display:flex; gap:4mm; margin-top:6mm; flex-wrap:wrap }
    .hero-badges .b{ background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.35); border-radius:999px; padding:2mm 4mm; font-weight:900 }
    @page{ size:A4; margin:0 }
  </style>
  <div class="hero-wrap">
    <img src="{{ $coverSrc }}" class="hero-img" alt="" onerror="this.style.display='none'">
    <div class="hero-overlay"></div>
    <div class="hero-head"><img src="{{ $siteLogo }}" alt="" onerror="this.style.display='none'"><div class="name" style="font-weight:900">{{ $siteName }}</div></div>
    <div class="hero-title">
      <h1>العرض المالي والفني</h1>
      <div class="sub">{{ $tender->title }} — {{ $tender->client_name }}</div>
      <div class="hero-badges">
        @if($tender->competition_no || $tender->tender_no)<span class="b">رقم: {{ $tender->competition_no ?? $tender->tender_no }}</span>@endif
        @if($tender->submission_date)<span class="b">التاريخ: {{ $tender->submission_date->format('Y-m-d') }}</span>@endif
      </div>
    </div>
    <div class="hero-brand"></div>
  </div>
</section>
