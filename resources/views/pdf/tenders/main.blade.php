<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8" />
  <title>{{ $tender->title ?? 'عرض مناقصة' }}</title>
  <style>
    @page { size: A4; margin: 15mm; }
    html, body { direction: rtl; unicode-bidi: embed; font-family: dejavusans, sans-serif; color:#111; line-height: 1.6; white-space: normal; letter-spacing: 0; word-spacing: normal; writing-mode: horizontal-tb; }
    p, div, td, th, span { white-space: normal; letter-spacing: 0; word-spacing: normal; writing-mode: horizontal-tb; }
    header, footer { position: fixed; left: 0; right: 0; color: #6b7280; font-size: 11px; }
    header { top: -10mm; }
    footer { bottom: -10mm; }
    .pagenum:before { content: counter(page); }
    .cover { text-align:center; margin-top: 90px; }
    .title { font-size: 28px; margin-bottom: 6px; font-weight: 700; }
    .subtitle { font-size: 15px; margin-bottom: 22px; color: #6b7280; }
    .section { page-break-inside: avoid; margin-top: 18px; }
    .h2 { font-size: 18px; margin: 10px 0 8px; padding-bottom: 6px; border-bottom: 2px solid #e5e7eb; }
    .h2 .bar{ display:inline-block; width:8px; height:16px; background: #0b5fad; margin-left:6px; vertical-align:middle }
    table { width: 100%; border-collapse: collapse; font-size: 12px; }
    td, th { white-space: normal; }
    th, td { border: 1px solid #e5e7eb; padding: 7px 6px; }
    thead th { background: #f3f4f6; color:#111; font-weight: 700; }
    tbody tr:nth-child(even) { background: #fafafa; }
    tfoot th { background:#f9fafb; text-align:left }
    tfoot td { background:#f9fafb; font-weight:700 }
    .muted { color: #6b7280; }
    .table { width:100%; border-collapse: collapse; }
    .td { vertical-align: top; }
    .badge { display:inline-block; padding: 3px 8px; font-size:11px; border:1px solid #0b5fad; color: #0b5fad; border-radius: 999px; }
    .kv { display:flex; gap:8px; margin:4px 0; }
    .kv .k{ color:#374151; min-width: 85px }
    .totals { width: 60%; margin-left:auto; border:1px solid #e5e7eb; }
    .totals td, .totals th{ border:1px solid #e5e7eb; padding:6px }
    .totals th{ background:#f9fafb; text-align:left }
    .note { border:1px dashed #e5e7eb; padding:8px; background:#fcfcfc; color:#374151; }
    .center { text-align:center }
    .right { text-align:right }
    .left { text-align:left }
    .mb-8 { margin-bottom:8px }
    .mb-12 { margin-bottom:12px }
    .mt-8 { margin-top:8px }
    .mt-12 { margin-top:12px }
  </style>
</head>
<body>
<header>
  <table class="table">
    <tr>
      <td class="td" style="text-align:right">{{ $company->name ?? 'مؤسسة طور البناء للتجارة' }}</td>
      <td class="td" style="text-align:left">{{ now()->format('Y-m-d') }}</td>
    </tr>
  </table>
</header>
<footer>
  <table class="table">
    <tr>
      <td class="td" style="text-align:right">
        <span class="muted">{{ $tender->competition_no ? ('رقم المنافسة: '.$tender->competition_no) : '' }}</span>
      </td>
      <td class="td" style="text-align:left">
        <span class="muted">صفحة <span class="pagenum"></span></span>
      </td>
    </tr>
  </table>
</footer>

<main>
  <!-- Cover -->
  <section class="cover">
    @php $logo = !empty($company?->logo_path) ? public_path($company->logo_path) : null; @endphp
    @if($logo && file_exists($logo))
      <img src="{{ $logo }}" alt="logo" style="height:75px; margin-bottom: 14px;" />
    @endif
    <div class="title">{{ $tender->title ?? 'عرض مناقصة' }}</div>
    <div class="subtitle">{{ $tender->client_name ?? '' }}</div>
    @if(!empty($tender->competition_no))
      <div class="badge">رقم المنافسة: {{ $tender->competition_no }}</div>
    @endif
  </section>

  <!-- Financial letter -->
  <section class="section">
    <div class="h2"><span class="bar"></span>الخطاب المالي</div>
    <table class="table" style="font-size:12px;">
      <tr>
        <td style="width:110px;color:#374151">التاريخ:</td>
        <td>{{ $tender->submission_date ? \Carbon\Carbon::parse($tender->submission_date)->format('Y-m-d') : now()->format('Y-m-d') }}</td>
      </tr>
      <tr>
        <td style="width:110px;color:#374151">الجهة:</td>
        <td>{{ $tender->client_name ?? '-' }}</td>
      </tr>
    </table>
    @if(!empty($tender->notes))
    <div class="note mt-8">{!! nl2br(e($tender->notes)) !!}</div>
    @endif
  </section>

  <!-- Financial items -->
  @php $fo = $tender->financialOffers->first(); @endphp
  @if($fo)
    <section class="section">
      <div class="h2"><span class="bar"></span>جدول البنود المالية</div>
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>البند</th>
            <th>الكمية</th>
            <th>الوحدة</th>
            <th>سعر الوحدة</th>
            <th>الضريبة</th>
            <th>الإجمالي</th>
          </tr>
        </thead>
        <tbody>
          @php $items = isset($foComputed) && $foComputed ? $foComputed['items'] : $fo->offerItems->sortBy('order_index'); @endphp
          @foreach($items as $i=>$it)
          <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $it->name }}</td>
            <td>{{ rtrim(rtrim(number_format((float)$it->qty, 3, '.', ''), '0'), '.') }}</td>
            <td>{{ $it->unit }}</td>
            <td>{{ number_format((float)$it->unit_price, 2) }}</td>
            <td>{{ number_format((float)($it->vat ?? ((float)$it->qty * (float)$it->unit_price * ((float)$fo->vat_rate/100.0))), 2) }}</td>
            <td>{{ number_format((float)$it->total, 2) }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>

      <table class="totals mt-12">
        <tr>
          <th>الإجمالي قبل الضريبة</th>
          <td class="right">{{ number_format((float)((isset($foComputed) && $foComputed ? $foComputed['subtotal'] : $fo->subtotal)), 2) }}</td>
        </tr>
        <tr>
          <th>قيمة الضريبة</th>
          <td class="right">{{ number_format((float)((isset($foComputed) && $foComputed ? $foComputed['total_vat'] : $fo->total_vat)), 2) }}</td>
        </tr>
        <tr>
          <th>الإجمالي النهائي</th>
          <td class="right">{{ number_format((float)((isset($foComputed) && $foComputed ? $foComputed['total'] : $fo->total)), 2) }} {{ $fo->currency }}</td>
        </tr>
      </table>
    </section>
  @endif

  <!-- Technical section -->
  <section class="section">
    <div class="h2"><span class="bar"></span>الملف الفني</div>
    @if($company)
      <div class="grid">
        <div class="col w-50">
          <div><strong>الرؤية:</strong></div>
          <div class="muted">{!! nl2br(e($company->vision)) !!}</div>
          <br/>
          <div><strong>الرسالة:</strong></div>
          <div class="muted">{!! nl2br(e($company->mission)) !!}</div>
        </div>
        <div class="col w-50">
          <div><strong>المنتجات/الخدمات:</strong></div>
          <div class="muted">{!! nl2br(e($company->products_text)) !!}</div>
        </div>
      </div>
    @endif

    <div style="margin-top:12px;" class="h2"><span class="bar"></span>فريق العمل</div>
    <table>
      <thead><tr><th>الاسم</th><th>المسمى</th></tr></thead>
      <tbody>
        @foreach($team as $m)
        <tr>
          <td>{{ $m->name }}</td>
          <td>{{ $m->title }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <div style="margin-top:12px;" class="h2"><span class="bar"></span>المشاريع السابقة</div>
    <table>
      <thead><tr><th>المشروع</th><th>الجهة</th><th>الموقع</th><th>الفترة</th></tr></thead>
      <tbody>
        @foreach($projects as $p)
        <tr>
          <td>{{ $p->title }}</td>
          <td>{{ $p->client }}</td>
          <td>{{ $p->location }}</td>
          <td>{{ $p->start_date }} - {{ $p->end_date }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </section>

  <!-- Certificates -->
  @if(count($certificates))
  <section class="section">
    <div class="h2"><span class="bar"></span>الشهادات والسجلات</div>
    <table>
      <thead><tr><th>الشهادة</th><th>الجهة</th><th>التاريخ</th></tr></thead>
      <tbody>
        @foreach($certificates as $c)
        <tr>
          <td>{{ $c->name }}</td>
          <td>{{ $c->issued_by }}</td>
          <td>{{ $c->issued_at }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </section>
  @endif
</main>
</body>
</html>
