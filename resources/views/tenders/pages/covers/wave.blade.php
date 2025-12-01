<section class="wave-cover" style="position:relative; min-height:297mm;">
  <style>
    .wv-wrap{ position:relative; height:297mm; background:#fff; overflow:hidden; color:#0b0e14 }
    .wv-top{ position:absolute; inset:0; background: linear-gradient(180deg, color-mix(in oklab, {{ $brand }}, #fff 70%), #fff 60%); clip-path: ellipse(140% 60% at 50% 0%); }
    .wv-ring{ position:absolute; left:-20mm; top:40mm; width:160mm; height:160mm; border-radius:50%; border:4mm solid color-mix(in oklab, {{ $brand }}, #fff 75%); }
    .wv-photo{ position:absolute; left:10mm; top:70mm; width:120mm; height:120mm; border-radius:50%; overflow:hidden; box-shadow:0 12px 32px rgba(0,0,0,.12) }
    .wv-photo img{ width:100%; height:100%; object-fit:cover }
    .wv-title{ position:absolute; right:16mm; top:90mm; max-width:80mm }
    .wv-title h1{ margin:0 0 4mm; font-weight:900; font-size:14mm }
    .wv-sub{ font-weight:800; color:#334155 }
    .wv-badges{ display:flex; flex-wrap:wrap; gap:3mm; margin-top:5mm }
    .wv-badges .b{ display:inline-flex; align-items:center; gap:2mm; padding:2mm 3.2mm; background: color-mix(in oklab, {{ $brand }}, #fff 85%); color:#0b0e14; border:1px solid color-mix(in oklab, {{ $brand }}, #000 92%); border-radius:999px; font-weight:900; font-size:3.3mm }
    .wv-footer{ position:absolute; right:16mm; bottom:16mm; display:flex; align-items:center; gap:6mm }
    .wv-footer img{ height:16mm }
    @page{ size:A4; margin:0 }
  </style>
  <div class="wv-wrap">
    <div class="wv-top"></div>
    <div class="wv-ring"></div>
    <div class="wv-photo"><img src="{{ $coverSrc }}" alt="" onerror="this.style.display='none'"></div>
    <div class="wv-title">
      <h1>العرض المالي والفني</h1>
      <div class="wv-sub">{{ $tender->title }} — {{ $tender->client_name }}</div>
      <div class="wv-badges">
        @if($tender->competition_no || $tender->tender_no)<span class="b">رقم: {{ $tender->competition_no ?? $tender->tender_no }}</span>@endif
        @if($tender->submission_date)<span class="b">التاريخ: {{ $tender->submission_date->format('Y-m-d') }}</span>@endif
      </div>
    </div>
    <div class="wv-footer"><img src="{{ $siteLogo }}" alt="" onerror="this.style.display='none'"><div class="name" style="font-weight:900">{{ $siteName }}</div></div>
  </div>
</section>
