<!-- غلاف العرض المالي والفني (تصميم عصري للطباعة A4) -->
<section class="cv-cover" style="position:relative; min-height:297mm;">
  <?php
    $brand = \App\Models\Setting::getValue('color_primary', config('brand.color'));
    $siteName = \App\Models\Setting::getValue('site_title', config('brand.name'));
    $siteLogo = \App\Models\Setting::getValue('site_logo', asset(config('brand.logo_path')));
    $coverSrc = $tender->cover_image_url ?? $tender->cover_image ?? null;
    if (!$coverSrc) { $coverSrc = asset('assets/company-profile-cover.jpg'); }
  ?>
  <style>
    .cv-cover{ font-family:'Cairo', system-ui, -apple-system, Segoe UI, Roboto, sans-serif; color:#0b0e14 }
    .cv-wrap{ position:relative; height:297mm; overflow:hidden; display:grid; grid-template-columns: 1.1fr .9fr }
    .cv-left{ position:relative }
    .cv-img{ position:absolute; inset:0; width:100%; height:100%; object-fit:cover; display:block }
    .cv-overlay{ position:absolute; inset:0; background: 
      linear-gradient(180deg, rgba(0,0,0,.14), rgba(0,0,0,.32)), 
      linear-gradient(90deg, rgba(0,0,0,.18), transparent 46%) }
    .cv-right{ background:#fff; position:relative }
    .cv-right::before{ content:""; position:absolute; inset:10mm 6mm auto auto; width:80mm; height:80mm; border-radius:50%; filter: blur(30px); background: color-mix(in oklab, <?= $brand ?>, #fff 82%); opacity:.35 }
    .cv-brandbar{ position:absolute; inset:0 auto 0 0; width:10mm; background: <?= $brand ?> }
    .cv-diagonal{ position:absolute; inset:auto -30mm 0 auto; top:-30mm; width:180mm; height:120mm; background: <?= $brand ?>; opacity:.18; transform: rotate(-12deg); filter: saturate(120%) }
    .cv-header{ position:absolute; top:12mm; right:12mm; display:flex; align-items:center; gap:6mm; background: rgba(255,255,255,.96); border:1px solid color-mix(in oklab, #e5e7eb, #000 4%); border-radius:6mm; padding:4mm 6mm; box-shadow: 0 6px 18px rgba(0,0,0,.06) }
    .cv-header .logo{ height:14mm; width:auto; display:block }
    .cv-header .name{ font-weight:900; font-size:4.2mm; color:#0b0e14; line-height:1.2 }
    .cv-header .tag{ font-size:3.2mm; color:#64748b; font-weight:800 }
    .cv-title{ position:absolute; right:12mm; top:50%; transform: translateY(-50%); background:#fff; border:1px solid color-mix(in oklab, <?= $brand ?>, #000 90%); border-radius:5mm; padding:10mm 12mm; box-shadow: 0 14px 34px rgba(0,0,0,.10) }
    .cv-title::before{ content:""; position:absolute; inset:0 0 auto 0; height:3mm; background: linear-gradient(90deg, <?= $brand ?>, color-mix(in oklab, <?= $brand ?>, #fff 40%)); border-top-left-radius:5mm; border-top-right-radius:5mm; opacity:.85 }
    .cv-title h1{ margin:0; font-weight:900; font-size:14.5mm; letter-spacing:.1mm; color:#0b0e14 }
    .cv-title .sub{ margin-top:3mm; font-weight:900; color:#0b0e14; font-size:5mm }
    .cv-title .client{ color: <?= $brand ?>; font-weight:900; font-size:4.8mm }
    .cv-badges{ display:flex; flex-wrap:wrap; gap:3mm; margin-top:5mm }
    .cv-badge{ display:inline-flex; align-items:center; gap:2mm; padding:1.6mm 3mm; background: color-mix(in oklab, <?= $brand ?>, #fff 88%); color:#0b0e14; border:1px solid color-mix(in oklab, <?= $brand ?>, #000 92%); border-radius:999px; font-weight:900; font-size:3.3mm }
    .cv-meta{ position:absolute; right:12mm; bottom:14mm; display:grid; gap:2.2mm; min-width:72mm }
    .cv-meta .row{ display:flex; justify-content:space-between; align-items:center; background:#fff; border:1px solid color-mix(in oklab, #e5e7eb, #000 6%); border-radius:4mm; padding:2.6mm 3.6mm }
    .cv-meta .row strong{ font-size:3.6mm }
    .cv-meta .row span{ font-size:3.6mm; font-weight:800; color:#0b0e14 }
    .cv-deco{ position:absolute; right:-30mm; top:-30mm; width:120mm; height:120mm; border-radius:50%; filter: blur(30px); background: color-mix(in oklab, <?= $brand ?>, #ffffff 60%); opacity:.5 }
    .cv-bottombar{ position:absolute; left:0; right:0; bottom:0; height:8mm; background: <?= $brand ?> }
    .cv-bottombar::after{ content:""; position:absolute; inset:auto 0 0 0; height:2mm; background: #fff; opacity:.35 }
    .cv-watermark{ position:absolute; inset:0; display:grid; place-items:center; pointer-events:none; opacity:.04 }
    .cv-watermark img{ width:90mm; height:auto; filter: grayscale(100%); }
    /* طباعة */
    @page { size:A4; margin:0 }
    @media print { .cv-header{ box-shadow:none } .cv-title{ box-shadow:none } .cv-diagonal{ opacity:.14 } }
  </style>

  <div class="cv-wrap">
    <div class="cv-left">
      <img src="{{ $coverSrc }}" alt="cover" class="cv-img" onerror="this.style.display='none'">
      <div class="cv-overlay"></div>
    </div>
    <div class="cv-right">
      <div class="cv-brandbar"></div>
      <div class="cv-deco" aria-hidden="true"></div>
      <div class="cv-diagonal" aria-hidden="true"></div>
    </div>

    <div class="cv-header">
      <img src="{{ $siteLogo }}" alt="logo" class="logo" onerror="this.style.display='none'">
      <div class="text">
        <div class="name">{{ $siteName }}</div>
        <div class="tag">العرض المالي والفني</div>
      </div>
    </div>

    <div class="cv-title">
      <h1>العرض المالي والفني</h1>
      <div class="sub">{{ $tender->title ?? '' }}</div>
      <div class="client">{{ $tender->client_name ?? '' }}</div>
      <div class="cv-badges">
        @if(!empty($tender->competition_no) || !empty($tender->tender_no))
          <span class="cv-badge">رقم المنافسة: {{ $tender->competition_no ?? $tender->tender_no }}</span>
        @endif
        @if(!empty($tender->submission_date))
          <span class="cv-badge">التاريخ: {{ optional($tender->submission_date)->format('Y-m-d') }}</span>
        @endif
        @if(!empty($tender->validity_days))
          <span class="cv-badge">الصلاحية: {{ $tender->validity_days }} يوم</span>
        @endif
      </div>
    </div>

    <div class="cv-meta">
      <div class="row"><strong>رقم المنافسة</strong><span>{{ $tender->competition_no ?? $tender->tender_no }}</span></div>
      <div class="row"><strong>التاريخ</strong><span>{{ optional($tender->submission_date)->format('Y-m-d') }}</span></div>
      <div class="row"><strong>إعداد</strong><span>{{ $siteName }}</span></div>
      @if(!empty($tender->validity_days))
      <div class="row"><strong>صلاحية العرض</strong><span>{{ $tender->validity_days }} يوم</span></div>
      @endif
    </div>

    <div class="cv-watermark" aria-hidden="true">
      <img src="{{ $siteLogo }}" alt="" onerror="this.style.display='none'" />
    </div>

    <div class="cv-bottombar" aria-hidden="true"></div>
  </div>
</section>
