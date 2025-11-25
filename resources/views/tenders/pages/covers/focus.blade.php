<?php
$brand = \App\Models\Setting::getValue('color_primary', config('brand.color'));
$siteName = \App\Models\Setting::getValue('site_title', config('brand.name'));
$siteLogo = \App\Models\Setting::getValue('site_logo', asset(config('brand.logo_path')));
$coverSrc = $tender->cover_image_url ?? $tender->cover_image ?? asset('assets/company-profile-cover.jpg');
?>
<section class="focus-cover" style="position:relative; min-height:297mm;">
  <style>
    .fc-wrap{ position:relative; height:297mm; background:#fff; color:#0b0e14; overflow:hidden }
    .fc-spot{ position:absolute; inset:auto -60mm -60mm auto; width:240mm; height:240mm; border-radius:50%; background: radial-gradient(circle at 30% 30%, color-mix(in oklab, <?= $brand ?>, #fff 40%), transparent 60%); filter: blur(12px); opacity:.6 }
    .fc-photo{ position:absolute; left:18mm; top:70mm; width:120mm; height:160mm; border-radius:8mm; overflow:hidden; box-shadow:0 14px 36px rgba(0,0,0,.12) }
    .fc-photo img{ width:100%; height:100%; object-fit:cover }
    .fc-title{ position:absolute; right:18mm; top:50%; transform:translateY(-50%); max-width:78mm }
    .fc-title h1{ margin:0 0 6mm; font-weight:900; font-size:16mm }
    .fc-sub{ font-weight:800; color:#334155 }
    .fc-badges{ display:flex; flex-wrap:wrap; gap:3mm; margin-top:6mm }
    .fc-badges .b{ padding:2mm 3.2mm; border-radius:999px; border:1px solid color-mix(in oklab, <?= $brand ?>, #000 90%); background: color-mix(in oklab, <?= $brand ?>, #fff 85%); font-weight:900; font-size:3.3mm }
    .fc-footer{ position:absolute; left:18mm; bottom:16mm; display:flex; gap:6mm; align-items:center }
    .fc-footer img{ height:16mm }
    .fc-bar{ position:absolute; left:0; right:0; bottom:0; height:8mm; background: <?= $brand ?> }
    @page{ size:A4; margin:0 }
  </style>
  <div class="fc-wrap">
    <div class="fc-spot" aria-hidden="true"></div>
    <div class="fc-photo"><img src="{{ $coverSrc }}" alt="" onerror="this.style.display='none'"></div>
    <div class="fc-title">
      <h1>العرض المالي والفني</h1>
      <div class="fc-sub">{{ $tender->title }} — {{ $tender->client_name }}</div>
      <div class="fc-badges">
        @if($tender->competition_no || $tender->tender_no)<span class="b">رقم: {{ $tender->competition_no ?? $tender->tender_no }}</span>@endif
        @if($tender->submission_date)<span class="b">التاريخ: {{ $tender->submission_date->format('Y-m-d') }}</span>@endif
      </div>
    </div>
    <div class="fc-footer"><img src="{{ $siteLogo }}" alt="" onerror="this.style.display='none'"><div class="name" style="font-weight:900">{{ $siteName }}</div></div>
    <div class="fc-bar"></div>
  </div>
</section>
