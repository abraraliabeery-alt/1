<section class="side-cover" style="position:relative; min-height:297mm;">
  <style>
    .side-wrap{ position:relative; height:297mm; display:grid; grid-template-columns: 70mm 1fr; background:#fff; color:#0b0e14 }
    .side-left{ background: {{ $brand }}; color:#fff; position:relative }
    .side-left .logo{ position:absolute; top:16mm; right:16mm; height:16mm; background:#fff; border-radius:6mm; padding:2mm }
    .side-left .meta{ position:absolute; bottom:18mm; right:16mm; left:16mm; font-weight:800 }
    .side-right{ position:relative }
    .side-photo{ position:absolute; inset:0; opacity:.9 }
    .side-photo img{ width:100%; height:100%; object-fit:cover }
    .side-overlay{ position:absolute; inset:0; background: linear-gradient(90deg, rgba(255,255,255,.85), rgba(255,255,255,.65), rgba(255,255,255,.15)); }
    .side-title{ position:absolute; right:18mm; top:50%; transform:translateY(-50%); background:#fff; border:1px solid #e5e7eb; border-radius:6mm; padding:10mm 12mm; box-shadow:0 14px 34px rgba(0,0,0,.08) }
    .side-title h1{ margin:0 0 4mm; font-size:15mm; font-weight:900 }
    .side-title .sub{ font-weight:800; color:#334155 }
    .side-badges{ display:flex; flex-wrap:wrap; gap:3mm; margin-top:5mm }
    .side-badges .b{ display:inline-flex; align-items:center; gap:2mm; padding:2mm 3.2mm; background: color-mix(in oklab, {{ $brand }}, #fff 85%); color:#0b0e14; border:1px solid color-mix(in oklab, {{ $brand }}, #000 92%); border-radius:999px; font-weight:900; font-size:3.3mm }
    @page{ size:A4; margin:0 }
  </style>
  <div class="side-wrap">
    <div class="side-left">
      <img src="{{ $siteLogo }}" class="logo" alt="" onerror="this.style.display='none'">
      <div class="meta">
        <div class="name" style="font-weight:900; font-size:4.6mm">{{ $siteName }}</div>
        @if($tender->competition_no || $tender->tender_no)<div>رقم: {{ $tender->competition_no ?? $tender->tender_no }}</div>@endif
        @if($tender->submission_date)<div>التاريخ: {{ $tender->submission_date->format('Y-m-d') }}</div>@endif
      </div>
    </div>
    <div class="side-right">
      <div class="side-photo"><img src="{{ $coverSrc }}" alt="" onerror="this.style.display='none'"></div>
      <div class="side-overlay" aria-hidden="true"></div>
      <div class="side-title">
        <h1>العرض المالي والفني</h1>
        <div class="sub">{{ $tender->title }} — {{ $tender->client_name }}</div>
        <div class="side-badges">
          @if($tender->competition_no || $tender->tender_no)<span class="b">رقم: {{ $tender->competition_no ?? $tender->tender_no }}</span>@endif
          @if($tender->submission_date)<span class="b">التاريخ: {{ $tender->submission_date->format('Y-m-d') }}</span>@endif
        </div>
      </div>
    </div>
  </div>
</section>
