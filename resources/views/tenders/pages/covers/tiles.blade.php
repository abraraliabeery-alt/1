<?php
$brand = \App\Models\Setting::getValue('color_primary', config('brand.color'));
$siteName = \App\Models\Setting::getValue('site_title', config('brand.name'));
$siteLogo = \App\Models\Setting::getValue('site_logo', asset(config('brand.logo_path')));
$coverSrc = $tender->cover_image_url ?? $tender->cover_image ?? asset('assets/company-profile-cover.jpg');
?>
<section class="tiles-cover" style="position:relative; min-height:297mm;">
  <style>
    .ti-wrap{ position:relative; height:297mm; background:#fff; color:#0b0e14; overflow:hidden }
    .ti-grid{ position:absolute; inset:0; display:grid; grid-template-columns: repeat(8,1fr); grid-auto-rows: 24mm; opacity:.08 }
    .ti-grid div{ border:1px solid #0b0e14; }
    .ti-hero{ position:absolute; left:16mm; top:60mm; width:120mm; height:140mm; overflow:hidden; border-radius:6mm; box-shadow:0 14px 36px rgba(0,0,0,.12) }
    .ti-hero img{ width:100%; height:100%; object-fit:cover }
    .ti-swash{ position:absolute; right:-40mm; top:-40mm; width:180mm; height:180mm; background: color-mix(in oklab, <?= $brand ?>, #fff 70%); border-radius:50%; filter: blur(20px); opacity:.5 }
    .ti-title{ position:absolute; right:16mm; top:90mm; max-width:78mm }
    .ti-title h1{ margin:0 0 4mm; font-weight:900; font-size:15mm }
    .ti-sub{ font-weight:800; color:#334155 }
    .ti-badges{ display:flex; flex-wrap:wrap; gap:3mm; margin-top:5mm }
    .ti-badges .b{ display:inline-flex; align-items:center; gap:2mm; padding:2mm 3.2mm; background: color-mix(in oklab, <?= $brand ?>, #fff 85%); color:#0b0e14; border:1px solid color-mix(in oklab, <?= $brand ?>, #000 92%); border-radius:999px; font-weight:900; font-size:3.3mm }
    .ti-footer{ position:absolute; right:16mm; bottom:16mm; display:flex; gap:6mm; align-items:center }
    .ti-footer img{ height:16mm }
    .ti-bar{ position:absolute; left:0; right:0; bottom:0; height:8mm; background: <?= $brand ?> }
    @page{ size:A4; margin:0 }
  </style>
  <div class="ti-wrap">
    <div class="ti-grid" aria-hidden="true">
      @for($i=0;$i<200;$i++)<div></div>@endfor
    </div>
    <div class="ti-swash" aria-hidden="true"></div>
    <div class="ti-hero"><img src="{{ $coverSrc }}" alt="" onerror="this.style.display='none'"></div>
    <div class="ti-title">
      <h1>العرض المالي والفني</h1>
      <div class="ti-sub">{{ $tender->title }} — {{ $tender->client_name }}</div>
      <div class="ti-badges">
        @if($tender->competition_no || $tender->tender_no)<span class="b">رقم: {{ $tender->competition_no ?? $tender->tender_no }}</span>@endif
        @if($tender->submission_date)<span class="b">التاريخ: {{ $tender->submission_date->format('Y-m-d') }}</span>@endif
      </div>
    </div>
    <div class="ti-footer"><img src="{{ $siteLogo }}" alt="" onerror="this.style.display='none'"><div class="name" style="font-weight:900">{{ $siteName }}</div></div>
    <div class="ti-bar"></div>
  </div>
</section>
