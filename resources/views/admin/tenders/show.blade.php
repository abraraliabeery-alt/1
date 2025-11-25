@php($title = 'تفاصيل العرض')
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ $title }}</title>
  <style>
    body { font-family: Tahoma, Arial, sans-serif; direction: rtl; margin: 16px; }
    .btn{ display:inline-block; padding:6px 10px; border:1px solid #444; background:#fff; text-decoration:none; color:#222; border-radius:4px; margin:2px 0 }
    .muted{ color:#777 }
    table{ width:100%; border-collapse: collapse; margin-top:8px }
    th,td{ border:1px solid #ddd; padding:8px; font-size:14px }
    th{ background:#f7f7f7 }
    .row{ display:flex; gap:12px; margin:10px 0 }
    .col{ flex:1 }
  </style>
</head>
<body>
  <h1 style="margin:0 0 10px">{{ $tender->title }}</h1>
  <div class="muted">الجهة: {{ $tender->client_name }} — رقم المنافسة: {{ $tender->competition_no }} — تاريخ: {{ $tender->submission_date }}</div>

  <div style="margin:12px 0">
    <a class="btn" href="{{ route('admin.tenders.index') }}">عودة</a>
    <a class="btn" href="{{ route('admin.tenders.edit', $tender) }}">تعديل</a>
    <a class="btn" target="_blank" href="{{ route('admin.tenders.pdf.preview', $tender) }}">معاينة PDF</a>
    <form style="display:inline" method="post" action="{{ route('admin.tenders.pdf.generate', $tender) }}">
      @csrf
      <button type="submit" class="btn">توليد وحفظ PDF</button>
    </form>
    @if($tender->pdf_path)
      <a class="btn" href="{{ route('admin.tenders.pdf.download', $tender) }}">تحميل PDF</a>
    @endif
  </div>

  @php($fo = $tender->financialOffers->first())
  @if($fo)
    <h3>البنود المالية</h3>
    <table>
      <thead>
        <tr>
          <th>#</th><th>البند</th><th>كمية</th><th>وحدة</th><th>سعر الوحدة</th><th>ضريبة</th><th>الإجمالي</th>
        </tr>
      </thead>
      <tbody>
        @foreach($fo->offerItems->sortBy('order_index') as $i=>$it)
        <tr>
          <td>{{ $i+1 }}</td>
          <td>{{ $it->name }}</td>
          <td>{{ $it->qty }}</td>
          <td>{{ $it->unit }}</td>
          <td>{{ $it->unit_price }}</td>
          <td>{{ $it->vat }}</td>
          <td>{{ $it->total }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <p class="muted">لا توجد بنود مالية بعد.</p>
  @endif
</body>
</html>
