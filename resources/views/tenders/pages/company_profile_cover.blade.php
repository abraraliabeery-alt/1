<!-- غلاف الملف التعريفي -->
<section class="cp-cover" style="position:relative; min-height:297mm;">
  <style>
    .cp-cover{ font-family: 'Cairo', system-ui, -apple-system, Segoe UI, Roboto, sans-serif; color:#0b0e14 }
    .cp-wrap{ position:relative; height:297mm; overflow:hidden; display:grid; grid-template-columns: 1.1fr .9fr }
    .cp-left{ position:relative }
    .cp-img{ position:absolute; inset:0; width:100%; height:100%; object-fit:cover; display:block }
    .cp-overlay{ position:absolute; inset:0; background:
      linear-gradient(180deg, rgba(0,0,0,.25), rgba(0,0,0,.45)),
      linear-gradient(90deg, rgba(0,0,0,.30), transparent 46%) }
    .cp-right{ background:#fff; position:relative }
    .cp-brandbar{ position:absolute; inset:0 auto 0 0; width:10mm; background: {{ config('brand.color') }} }
    .cp-header{ position:absolute; top:12mm; right:12mm; display:flex; align-items:center; gap:6mm; background: rgba(255,255,255,.96); border:1px solid #e5e7eb; border-radius:6mm; padding:4mm 6mm; box-shadow: 0 6px 20px rgba(0,0,0,.06) }
    .cp-header .logo{ height:14mm; width:auto; display:block }
    .cp-header .name{ font-weight:900; font-size:4.2mm; color:#0b0e14; line-height:1.2 }
    .cp-header .tag{ font-size:3.2mm; color:#64748b; font-weight:800 }
    .cp-title{ position:absolute; right:12mm; top:50%; transform: translateY(-50%); background:#fff; border:1px solid #e5e7eb; border-radius:5mm; padding:8mm 10mm; box-shadow: 0 12px 36px rgba(0,0,0,.10) }
    .cp-title h1{ margin:0; font-weight:900; font-size:14mm; letter-spacing:.2mm; color:#0b0e14 }
    .cp-meta{ position:absolute; right:12mm; bottom:14mm; display:grid; gap:3mm; min-width:70mm }
    .cp-meta .row{ display:flex; justify-content:space-between; align-items:center; background:#fff; border:1px solid #e5e7eb; border-radius:4mm; padding:3mm 4mm }
    .cp-meta .row strong{ font-size:3.6mm }
    .cp-meta .row span{ font-size:3.6mm; font-weight:800; color:#0b0e14 }
    .cp-deco{ position:absolute; right:-30mm; top:-30mm; width:120mm; height:120mm; border-radius:50%; filter: blur(30px); background: color-mix(in oklab, {{ config('brand.color') }}, #ffffff 60%); opacity:.5 }
    /* طباعة */
    @page { size: A4; margin: 0 }
    @media print { .cp-header{ box-shadow:none } .cp-title{ box-shadow:none } }
  </style>

  <div class="cp-wrap">
    <div class="cp-left">
      <img src="{{ asset('assets/company-profile-cover.jpg') }}" alt="" class="cp-img" onerror="this.style.display='none'">
      <div class="cp-overlay"></div>
    </div>
    <div class="cp-right">
      <div class="cp-brandbar"></div>
      <div class="cp-deco" aria-hidden="true"></div>
    </div>

    <div class="cp-header">
      <img src="{{ asset(config('brand.logo_path')) }}" alt="logo" class="logo" onerror="this.style.display='none'">
      <div class="text">
        <div class="name">{{ config('brand.name') }}</div>
        <div class="tag">الملف التعريفي</div>
      </div>
    </div>

    <div class="cp-title">
      <h1>Company Profile</h1>
    </div>

    <div class="cp-meta">
      <div class="row"><strong>التاريخ</strong><span>{{ now()->format('Y-m-d') }}</span></div>
      <div class="row"><strong>الجهة</strong><span>{{ config('brand.name') }}</span></div>
      <div class="row"><strong>النسخة</strong><span>v1.0</span></div>
    </div>
  </div>
</section>
