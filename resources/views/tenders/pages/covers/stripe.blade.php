<section class="stripe-cover" style="position:relative; min-height:297mm;">
  <style>
    .st-wrap{ position:relative; height:297mm; background:#fff; color:#0b0e14; overflow:hidden }
    .st-stripe{ position:absolute; inset:-40mm -40mm auto -40mm; height:60mm; background: {{ $brand }}; top:90mm; transform: rotate(-8deg); box-shadow:0 18px 46px rgba(0,0,0,.15) }
    .st-photo{ position:absolute; left:0; right:0; top:0; height:120mm; overflow:hidden }
    .st-photo img{ width:100%; height:100%; object-fit:cover }
    .st-title{ position:absolute; top:120mm; right:16mm; background:#fff; border:1px solid #e5e7eb; padding:8mm 10mm; border-radius:6mm; box-shadow:0 12px 28px rgba(0,0,0,.08) }
    .st-title h1{ margin:0 0 4mm; font-weight:900; font-size:14mm }
    .st-sub{ font-weight:800; color:#334155 }
    .st-footer{ position:absolute; right:16mm; bottom:16mm; display:flex; align-items:center; gap:6mm }
    .st-footer img{ height:14mm }
    @page{ size:A4; margin:0 }
  </style>
  <div class="st-wrap">
    <div class="st-photo"><img src="{{ $coverSrc }}" alt="" onerror="this.style.display='none'"></div>
    <div class="st-stripe"></div>
    <div class="st-title">
      <h1>العرض المالي والفني</h1>
      <div class="st-sub">{{ $tender->title }} — {{ $tender->client_name }}</div>
    </div>
    <div class="st-footer"><img src="{{ $siteLogo }}" alt="" onerror="this.style.display='none'"><div class="name" style="font-weight:900">{{ $siteName }}</div></div>
  </div>
</section>
