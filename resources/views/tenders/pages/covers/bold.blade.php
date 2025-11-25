<?php
$brand = \App\Models\Setting::getValue('color_primary', config('brand.color'));
$siteName = \App\Models\Setting::getValue('site_title', config('brand.name'));
$siteLogo = \App\Models\Setting::getValue('site_logo', asset(config('brand.logo_path')));
$coverSrc = $tender->cover_image_url ?? $tender->cover_image ?? asset('assets/company-profile-cover.jpg');
?>
<section class="bold-cover" style="position:relative; min-height:297mm;">
  <style>
    .bold-cover{ font-family:'Cairo',system-ui }
    .bold-wrap{ position:relative; height:297mm; background:#0b0e14; color:#fff; overflow:hidden }
    .bold-angle{ position:absolute; inset:auto -40mm -40mm auto; width:180mm; height:200mm; background: <?= $brand ?>; transform: rotate(-26deg) }
    .bold-top{ position:absolute; inset:-60mm auto auto -40mm; width:220mm; height:200mm; background: color-mix(in oklab, <?= $brand ?>, #fff 70%); transform: rotate(18deg) }
    .bold-photo{ position:absolute; left:18mm; top:70mm; width:120mm; height:160mm; overflow:hidden; border-radius:8mm; box-shadow:0 20px 50px rgba(0,0,0,.35); border:4px solid rgba(255,255,255,.15) }
    .bold-photo img{ width:100%; height:100%; object-fit:cover }
    .bold-title{ position:absolute; right:18mm; top:80mm; max-width:78mm }
    .bold-title h1{ margin:0 0 6mm; font-weight:900; font-size:16mm; line-height:1.05 }
    .bold-title .sub{ font-weight:800; color:#e5e7eb; font-size:5mm }
    .bold-title .client{ color:#fff; font-weight:900; font-size:4.6mm }
    .bold-meta{ position:absolute; right:18mm; bottom:24mm; display:grid; gap:3mm; font-weight:800 }
    .bold-badge{ display:inline-block; padding:2mm 4mm; border-radius:999px; border:1px solid rgba(255,255,255,.35) }
    .bold-brand{ position:absolute; left:0; right:0; bottom:0; height:8mm; background: <?= $brand ?> }
    @page{ size:A4; margin:0 }
  </style>
  <div class="bold-wrap">
    <div class="bold-top"></div>
    <div class="bold-angle"></div>
    <div class="bold-photo"><img src="{{ $coverSrc }}" alt="" onerror="this.style.display='none'"></div>
    <div class="bold-title">
      <h1>العرض المالي والفني</h1>
      <div class="sub">{{ $tender->title }}</div>
      <div class="client">{{ $tender->client_name }}</div>
    </div>
    <div class="bold-meta">
      @if($tender->competition_no || $tender->tender_no)<span class="bold-badge">رقم المنافسة: {{ $tender->competition_no ?? $tender->tender_no }}</span>@endif
      @if($tender->submission_date)<span class="bold-badge">التاريخ: {{ $tender->submission_date->format('Y-m-d') }}</span>@endif
    </div>
    <div class="bold-brand"></div>
  </div>
</section>
