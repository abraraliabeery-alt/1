<section class="orbit-cover" style="position:relative; min-height:297mm;">
  <style>
    .orbit-cover{ font-family:'Cairo', system-ui, -apple-system, Segoe UI, Roboto, sans-serif; color:#0b0e14 }
    .orbit-wrap{ position:relative; height:297mm; overflow:hidden; background:#0f1720; color:#fff }
    .orbit-top{ position:absolute; inset:0 0 auto 0; height:120mm; background:#0f1720 }
    .orbit-diag{ position:absolute; left:-40mm; top:40mm; width:200mm; height:12mm; background:{{ $brand }}; transform: rotate(-24deg); box-shadow:0 10px 28px rgba(0,0,0,.25) }
    .orbit-diag{ position:absolute; left:-40mm; top:40mm; width:200mm; height:12mm; background:#fff; transform: rotate(-24deg); box-shadow:0 10px 28px rgba(0,0,0,.25) }
    .orbit-lower{ position:absolute; right:-40mm; bottom:-20mm; width:240mm; height:120mm; background: #e9eef6; transform: rotate(-12deg) }
    .orbit-ring{ position:absolute; left:22mm; top:90mm; width:140mm; height:140mm; border-radius:50%; background:#e9eef6; display:grid; place-items:center; box-shadow:0 10px 40px rgba(0,0,0,.25) }
    .orbit-ring::before{ content:""; position:absolute; inset:8mm; border-radius:50%; border:2mm dotted #0f1720; opacity:.8 }
    .orbit-ring .imgwrap{ position:relative; width:120mm; height:120mm; border-radius:50%; overflow:hidden; border:3mm solid #0f1720 }
    .orbit-ring img{ width:100%; height:100%; object-fit:cover; display:block }
    .orbit-badge{ position:absolute; left:12mm; top:210mm; background:#0f1720; color:#fff; border:2px solid #fff; border-radius:50%; width:28mm; height:28mm; display:grid; place-items:center; font-weight:900; font-size:8mm; letter-spacing:.2mm; box-shadow:0 6px 20px rgba(0,0,0,.25) }
    .orbit-title{ position:absolute; top:48mm; right:18mm; left:auto; color:#fff; text-align:center }
    .orbit-title h1{ margin:0 0 4mm; font-weight:900; font-size:16mm }
    .orbit-title .sub{ font-size:5mm; color: #cbd5e1; font-weight:800 }
    .orbit-footer{ position:absolute; right:14mm; bottom:18mm; display:flex; align-items:center; gap:6mm; color:#0b0e14 }
    .orbit-footer .logo{ width:18mm; height:auto; display:block; background:#fff; border-radius:6mm; padding:2mm }
    .orbit-footer .meta{ font-weight:800; color:#334155 }
    .orbit-footer .meta .name{ color:#0b0e14; font-weight:900 }
    .orbit-brandbar{ position:absolute; inset:auto 0 0 0; height:10mm; background: {{ $brand }} }
    /* Print */
    @page { size:A4; margin:0 }
  </style>

  <div class="orbit-wrap">
    <div class="orbit-top"></div>
    <div class="orbit-diag" style="background: {{ $brand }}"></div>
    <div class="orbit-ring">
      <div class="imgwrap">
        <img src="{{ $coverSrc }}" alt="cover" onerror="this.style.display='none'" />
      </div>
    </div>
    <div class="orbit-badge">{{ $year }}</div>

    <div class="orbit-title">
      <h1>العرض المالي والفني</h1>
      <div class="sub">{{ $tender->title ?? '' }} — {{ $tender->client_name ?? '' }}</div>
    </div>

    <div class="orbit-footer">
      <img src="{{ $siteLogo }}" alt="logo" class="logo" onerror="this.style.display='none'" />
      <div class="meta">
        <div class="name">{{ $siteName }}</div>
        <div class="muted" style="font-size:3.6mm; color:#64748b">رقم المنافسة: {{ $tender->competition_no ?? $tender->tender_no }} — التاريخ: {{ optional($tender->submission_date)->format('Y-m-d') }}</div>
      </div>
    </div>

    <div class="orbit-lower" style="background: color-mix(in oklab, {{ $brand }}, #fff 75%)"></div>
    <div class="orbit-brandbar"></div>
  </div>
</section>
