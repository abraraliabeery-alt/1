<?php
$brand = \App\Models\Setting::getValue('color_primary', config('brand.color'));
$siteName = \App\Models\Setting::getValue('site_title', config('brand.name'));
$siteLogo = \App\Models\Setting::getValue('site_logo', asset(config('brand.logo_path')));
$coverSrc = $tender->cover_image_url ?? $tender->cover_image ?? asset('assets/company-profile-cover.jpg');
?>
<section class="min-cover" style="position:relative; min-height:297mm;">
  <style>
    .min-wrap{ position:relative; height:297mm; background:#fff; color:#0b0e14; overflow:hidden }
    .min-edge{ position:absolute; right:0; top:0; bottom:0; width:8mm; background: <?= $brand ?> }
    .min-top{ position:absolute; left:0; right:0; top:0; height:22mm; background: color-mix(in oklab, <?= $brand ?>, #fff 85%) }
    .min-title{ position:absolute; top:45%; left:50%; transform: translate(-50%,-50%); text-align:center; max-width:160mm }
    .min-title h1{ margin:0 0 4mm; font-size:16mm; font-weight:900 }
    .min-title .sub{ font-weight:800; color:#334155; font-size:5mm }
    .min-meta{ position:absolute; left:20mm; bottom:20mm; font-weight:800; color:#334155; display:grid; gap:2mm }
    .min-logo{ position:absolute; right:16mm; top:16mm; height:16mm }
    @page{ size:A4; margin:0 }
  </style>
  <div class="min-wrap">
    <div class="min-edge"></div>
    <div class="min-top"></div>
    <img src="{{ $siteLogo }}" class="min-logo" alt="logo" onerror="this.style.display='none'">
    <div class="min-title">
      <h1>العرض المالي والفني</h1>
      <div class="sub">{{ $tender->title }} — {{ $tender->client_name }}</div>
    </div>
    <div class="min-meta">
      @if($tender->competition_no || $tender->tender_no)<div>رقم: {{ $tender->competition_no ?? $tender->tender_no }}</div>@endif
      @if($tender->submission_date)<div>التاريخ: {{ $tender->submission_date->format('Y-m-d') }}</div>@endif
      <div>إعداد: {{ $siteName }}</div>
    </div>
  </div>
</section>
