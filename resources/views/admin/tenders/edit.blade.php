@php($title = 'تعديل العرض')
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ $title }}</title>
  <style>
    body { font-family: Tahoma, Arial, sans-serif; direction: rtl; margin: 16px; }
    label{ display:block; margin:8px 0 4px }
    input, textarea, select{ width:100%; padding:8px; box-sizing:border-box }
    .row{ display:flex; gap:12px }
    .col{ flex:1 }
    .btn{ display:inline-block; padding:8px 12px; border:1px solid #444; background:#fff; text-decoration:none; color:#222; border-radius:4px; cursor:pointer }
    .muted{ color:#777; font-size:12px }
    .card{ border:1px solid #ddd; padding:12px; border-radius:6px; margin-top:12px }
  </style>
</head>
<body>
  <h1>{{ $title }}</h1>
  <form method="post" action="{{ route('admin.tenders.update', $tender) }}">
    @csrf
    @method('PUT')
    <label>العنوان</label>
    <input name="title" required value="{{ old('title', $tender->title) }}" />

    <div class="row">
      <div class="col">
        <label>الجهة</label>
        <input name="client_name" value="{{ old('client_name', $tender->client_name) }}" />
      </div>
      <div class="col">
        <label>رقم المنافسة</label>
        <input name="competition_no" value="{{ old('competition_no', $tender->competition_no) }}" />
      </div>
      <div class="col">
        <label>تاريخ التقديم</label>
        <input type="date" name="submission_date" value="{{ old('submission_date', $tender->submission_date) }}" />
      </div>
    </div>

    <label>ملاحظات</label>
    <textarea name="notes" rows="3">{{ old('notes', $tender->notes) }}</textarea>

    <div style="margin-top:12px">
      <button class="btn" type="submit">حفظ</button>
      <a class="btn" href="{{ route('admin.tenders.show', $tender) }}">عودة</a>
      <a class="btn" target="_blank" href="{{ route('admin.tenders.pdf.preview', $tender) }}">معاينة PDF</a>
      <form style="display:inline" method="post" action="{{ route('admin.tenders.pdf.generate', $tender) }}">
        @csrf
        <button type="submit" class="btn">توليد وحفظ PDF</button>
      </form>
    </div>
  </form>
</body>
</html>
