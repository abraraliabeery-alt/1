<?php
$brand = \App\Models\Setting::getValue('color_primary', config('brand.color'));
$siteName = \App\Models\Setting::getValue('site_title', config('brand.name'));
$siteLogo = \App\Models\Setting::getValue('site_logo', asset(config('brand.logo_path')));
$coverSrc = $tender->cover_image_url ?? $tender->cover_image ?? asset('assets/company-profile-cover.jpg');
?>
<section class="arch-cover" style="position:relative; min-height:297mm;">
  <style>
    .arch-wrap{ position:relative; height:297mm; background:#fff; color:#0b0e14; overflow:hidden }
    .arch-band{ position:absolute; inset:-40mm -40mm auto -40mm; height:120mm; background: color-mix(in oklab, <?= $brand ?>, #fff 70%); clip-path: ellipse(60% 100% at 50% 100%); box-shadow:0 20px 40px rgba(0,0,0,.12) }
    .arch-photo{ position:absolute; right:18mm; top:70mm; width:90mm; height:120mm; border-radius:8mm; overflow:hidden; border:2px solid #e5e7eb; box-shadow:0 12px 30px rgba(0,0,0,.10) }
    .arch-photo img{ width:100%; height:100%; object-fit:cover }
    .arch-title{ position:absolute; left:18mm; top:50%; transform:translateY(-50%); max-width:90mm }
    .arch-title h1{ margin:0 0 6mm; font-weight:900; font-size:16mm }
    .arch-sub{ font-weight:800; color:#334155 }
    .arch-badges{ display:flex; flex-wrap:wrap; gap:3mm; margin-top:6mm }
    .arch-badges .b{ padding:2mm 3.2mm; border-radius:999px; border:1px solid color-mix(in oklab, <?= $brand ?>, #000 90%); background: color-mix(in oklab, <?= $brand ?>, #fff 85%); font-weight:900; font-size:3.3mm }
    .arch-footer{ position:absolute; left:18mm; bottom:16mm; display:flex; gap:6mm; align-items:center }
    .arch-footer img{ height:16mm }
    .arch-bar{ position:absolute; left:0; right:0; bottom:0; height:8mm; background: <?= $brand ?> }
    @page{ size:A4; margin:0 }
  </style>
  <div class="arch-wrap">
    <div class="arch-band"></div>
    <div class="arch-photo"><img src="{{ $coverSrc }}" alt="" onerror="this.style.display='none'"></div>
    <div class="arch-title">
      <h1>العرض المالي والفني</h1>
      <div class="arch-sub">{{ $tender->title }} — {{ $tender->client_name }}</div>
      <div class="arch-badges">
        @if($tender->competition_no || $tender->tender_no)<span class="b">رقم: {{ $tender->competition_no ?? $tender->tender_no }}</span>@endif
        @if($tender->submission_date)<span class="b">التاريخ: {{ $tender->submission_date->format('Y-m-d') }}</span>@endif
      </div>
    </div>
    <div class="arch-footer"><img src="{{ $siteLogo }}" alt="" onerror="this.style.display='none'"><div class="name" style="font-weight:900">{{ $siteName }}</div></div>
    <div class="arch-bar"></div>
  </div>
</section>
