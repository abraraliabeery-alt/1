<section class="grad-cover" style="position:relative; min-height:297mm;">
  <style>
    .gr-wrap{ position:relative; height:297mm; color:#fff; background: radial-gradient(1200px 800px at 20% 20%, color-mix(in oklab, {{ $brand }}, #fff 20%), #0b0e14 60%); overflow:hidden }
    .gr-photo{ position:absolute; right:16mm; top:60mm; width:90mm; height:120mm; overflow:hidden; border-radius:8mm; border:2px solid rgba(255,255,255,.25) }
    .gr-photo img{ width:100%; height:100%; object-fit:cover }
    .gr-title{ position:absolute; left:16mm; top:50%; transform:translateY(-50%); max-width:90mm }
    .gr-title h1{ margin:0 0 4mm; font-size:16mm; font-weight:900 }
    .gr-title .sub{ font-weight:800; color:#e5e7eb }
    .gr-badges{ display:flex; flex-wrap:wrap; gap:3mm; margin-top:5mm }
    .gr-badges .b{ display:inline-flex; align-items:center; gap:2mm; padding:2mm 3.2mm; background: rgba(255,255,255,.12); color:#fff; border:1px solid rgba(255,255,255,.35); border-radius:999px; font-weight:900; font-size:3.3mm }
    .gr-footer{ position:absolute; left:16mm; bottom:16mm; display:flex; align-items:center; gap:6mm }
    .gr-footer img{ height:16mm; background:#fff; border-radius:6mm; padding:2mm }
    .gr-bar{ position:absolute; left:0; right:0; bottom:0; height:8mm; background: {{ $brand }} }
    @page{ size:A4; margin:0 }
  </style>
  <div class="gr-wrap">
    <div class="gr-title">
      <h1>العرض المالي والفني</h1>
      <div class="sub">{{ $tender->title }} — {{ $tender->client_name }}</div>
      <div class="gr-badges">
        @if($tender->competition_no || $tender->tender_no)<span class="b">رقم: {{ $tender->competition_no ?? $tender->tender_no }}</span>@endif
        @if($tender->submission_date)<span class="b">التاريخ: {{ $tender->submission_date->format('Y-m-d') }}</span>@endif
      </div>
    </div>
    <div class="gr-photo"><img src="{{ $coverSrc }}" alt="" onerror="this.style.display='none'"></div>
    <div class="gr-footer"><img src="{{ $siteLogo }}" alt="" onerror="this.style.display='none'"><div class="name" style="font-weight:900">{{ $siteName }}</div></div>
    <div class="gr-bar"></div>
  </div>
</section>
