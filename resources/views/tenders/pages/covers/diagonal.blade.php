<?php
$brand = \App\Models\Setting::getValue('color_primary', config('brand.color'));
$siteName = \App\Models\Setting::getValue('site_title', config('brand.name'));
$siteLogo = \App\Models\Setting::getValue('site_logo', asset(config('brand.logo_path')));
$coverSrc = $tender->cover_image_url ?? $tender->cover_image ?? asset('assets/company-profile-cover.jpg');
?>
<section class="diag-cover" style="position:relative; min-height:297mm;">
  <style>
    .dg-wrap{ position:relative; height:297mm; background:#0b0e14; color:#fff; overflow:hidden }
    .dg-slice{ position:absolute; inset:auto -60mm -40mm auto; width:260mm; height:160mm; transform: rotate(-18deg); background: <?= $brand ?> }
    .dg-photo{ position:absolute; left:-20mm; top:30mm; width:160mm; height:200mm; border-radius:8mm; overflow:hidden; border:4px solid rgba(255,255,255,.15); box-shadow:0 18px 46px rgba(0,0,0,.35) }
    .dg-photo img{ width:100%; height:100%; object-fit:cover }
    .dg-title{ position:absolute; right:18mm; top:80mm; max-width:84mm }
    .dg-title h1{ margin:0 0 6mm; font-weight:900; font-size:16mm }
    .dg-sub{ font-weight:800; color:#e5e7eb }
    .dg-badges{ display:flex; flex-wrap:wrap; gap:3mm; margin-top:6mm }
    .dg-badges .b{ padding:2mm 3.2mm; border-radius:999px; border:1px solid rgba(255,255,255,.35); background: rgba(255,255,255,.10); font-weight:900; font-size:3.3mm }
    .dg-footer{ position:absolute; right:18mm; bottom:18mm; display:flex; gap:6mm; align-items:center }
    .dg-footer img{ height:16mm; background:#fff; border-radius:6mm; padding:2mm }
    @page{ size:A4; margin:0 }
  </style>
  <div class="dg-wrap">
    <div class="dg-slice"></div>
    <div class="dg-photo"><img src="{{ $coverSrc }}" alt="" onerror="this.style.display='none'"></div>
    <div class="dg-title">
      <h1>العرض المالي والفني</h1>
      <div class="dg-sub">{{ $tender->title }} — {{ $tender->client_name }}</div>
      <div class="dg-badges">
        @if($tender->competition_no || $tender->tender_no)<span class="b">رقم: {{ $tender->competition_no ?? $tender->tender_no }}</span>@endif
        @if($tender->submission_date)<span class="b">التاريخ: {{ $tender->submission_date->format('Y-m-d') }}</span>@endif
      </div>
    </div>
    <div class="dg-footer"><img src="{{ $siteLogo }}" alt="" onerror="this.style.display='none'"><div class="name" style="font-weight:900">{{ $siteName }}</div></div>
  </div>
</section>
