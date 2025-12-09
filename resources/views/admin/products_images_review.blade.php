@extends('layouts.app')

@section('head_extra')
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
@endsection

@section('content')
<div class="container py-4">
  <div class="d-flex align-items-center justify-content-between mb-3">
    <h1 class="h4 m-0">المنتجات</h1>
    <form method="GET" action="{{ route('admin.products.images.review') }}" class="d-flex gap-2">
      <select name="mode" class="form-select form-select-sm" style="width:auto">
        <option value="all" @selected(($mode ?? 'all')==='all')>الكل</option>
        <option value="missing" @selected(($mode ?? '')==='missing')>الصور المفقودة</option>
      </select>
      <input type="number" name="limit" class="form-control form-control-sm" style="width:110px" value="{{ $limit ?? 200 }}" min="1" max="500" />
      <button class="btn btn-sm btn-primary">تحديث</button>
    </form>
  </div>

  <div class="row g-3">
    @forelse($items as $p)
      <div class="col-6 col-sm-4 col-md-3 col-lg-2">
        <div class="card h-100">
          <div class="ratio ratio-1x1 bg-light">
            <img src="{{ trim((string)($p['image'] ?? '')) ?: '/assets/products/placeholder.svg' }}" alt="{{ $p['name_ar'] ?? '' }}" class="img-fluid w-100 h-100" style="object-fit:cover" />
          </div>
          <div class="card-body p-2">
            <div class="small fw-bold text-truncate" title="{{ $p['name_ar'] ?? '' }}">{{ $p['name_ar'] ?? '' }}</div>
            @if(!empty($p['sku']))
              <div class="text-muted small">SKU: {{ $p['sku'] }}</div>
            @endif
          </div>
        </div>
      </div>
    @empty
      <div class="col-12 text-center text-muted">لا توجد منتجات.</div>
    @endforelse
  </div>
</div>
@endsection
