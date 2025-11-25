<?php
$brand = \App\Models\Setting::getValue('color_primary', config('brand.color'));
$siteName = \App\Models\Setting::getValue('site_title', config('brand.name'));
$siteLogo = \App\Models\Setting::getValue('site_logo', asset(config('brand.logo_path')));
$coverSrc = $tender->cover_image_url ?? $tender->cover_image ?? asset('assets/company-profile-cover.jpg');
?>
<section class="geo-cover" style="position:relative; min-height:297mm;">
  <style>
    .geo-wrap{ position:relative; height:297mm; color:#0b0e14; background:#fff; overflow:hidden }
    .geo-block{ position:absolute; width:120mm; height:120mm; left:-20mm; top:40mm; transform: rotate(15deg); background: color-mix(in oklab, <?= $brand ?>, #fff 75%) }
    .geo-block2{ position:absolute; width:140mm; height:140mm; right:-30mm; bottom:-20mm; transform: rotate(-18deg); background: color-mix(in oklab, <?= $brand ?>, #fff 65%) }
    .geo-photo{ position:absolute; left:20mm; top:70mm; width:120mm; height:160mm; overflow:hidden; border-radius:6mm; box-shadow:0 12px 28px rgba(0,0,0,.10) }
    .geo-photo img{ width:100%; height:100%; object-fit:cover }
    .geo-title{ position:absolute; right:16mm; top:90mm; max-width:78mm }
    .geo-title h1{ margin:0 0 4mm; font-weight:900; font-size:15mm }
    .geo-sub{ font-weight:800; color:#334155 }
    .geo-badges{ display:flex; flex-wrap:wrap; gap:3mm; margin-top:5mm }
    .geo-badges .b{ display:inline-flex; align-items:center; gap:2mm; padding:2mm 3.2mm; background: color-mix(in oklab, <?= $brand ?>, #fff 85%); color:#0b0e14; border:1px solid color-mix(in oklab, <?= $brand ?>, #000 92%); border-radius:999px; font-weight:900; font-size:3.3mm }
    .geo-brand{ position:absolute; left:0; right:0; bottom:0; height:8mm; background: <?= $brand ?> }
    @page{ size:A4; margin:0 }
  </style>
  <div class="geo-wrap">
    <div class="geo-block"></div>
    <div class="geo-block2"></div>
    <div class="geo-photo"><img src="{{ $coverSrc }}" alt="" onerror="this.style.display='none'"></div>
    <div class="geo-title">
      <h1>العرض المالي والفني</h1>
      <div class="geo-sub">{{ $tender->title }} — {{ $tender->client_name }}</div>
      <div class="geo-badges">
        @if($tender->competition_no || $tender->tender_no)<span class="b">رقم: {{ $tender->competition_no ?? $tender->tender_no }}</span>@endif
        @if($tender->submission_date)<span class="b">التاريخ: {{ $tender->submission_date->format('Y-m-d') }}</span>@endif
      </div>
    </div>
    <div class="geo-brand"></div>
  </div>
</section>
