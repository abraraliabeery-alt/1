@extends('layouts.app')

@section('head_extra')
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
@endsection

@section('content')
<div class="container py-4">
  <h1 class="h4 fw-bold mb-3">استيراد أسماء المنتجات</h1>

  @if(session('ok'))
    <div class="alert alert-success">{{ session('ok') }}</div>
  @endif
  @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  @php($xlsxSupported = class_exists('PhpOffice\\PhpSpreadsheet\\IOFactory'))
  @unless($xlsxSupported)
    <div class="alert alert-warning">
      لاستيراد ملفات Excel مباشرة (xlsx/xls) تحتاج لتثبيت الحزمة <code>phpoffice/phpspreadsheet</code>.
      يمكنك بدلاً من ذلك رفع ملف <strong>CSV</strong> أو <strong>TXT</strong> حالياً.
    </div>
  @endunless

  <form action="{{ route('products.import.store') }}" method="POST" enctype="multipart/form-data" class="card p-3">
    @csrf
    <div class="mb-3">
      <label class="form-label">ملف الأسماء (TXT/CSV/XLSX)</label>
      <input type="file" name="names" accept=".txt,.csv,.xlsx,.xls" class="form-control" required>
      <div class="form-text">السطر الأول بعنوان "الاسم" سيتم تجاهله تلقائياً.</div>
    </div>
    <div class="mb-3">
      <label class="form-label">رقم العمود (لملفات CSV/XLSX)</label>
      <input type="number" name="column" min="1" max="20" value="1" class="form-control" style="max-width: 160px;">
      <div class="form-text">حدّد العمود الذي يحتوي أسماء المنتجات (افتراضي العمود الأول).</div>
    </div>
    <div class="d-flex gap-2">
      <button class="btn btn-primary" type="submit">استيراد</button>
      <a class="btn btn-outline-secondary" href="{{ route('products.index') }}">العودة للمنتجات</a>
    </div>
  </form>
</div>
@endsection
