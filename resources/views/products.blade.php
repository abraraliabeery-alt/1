@extends('layouts.app')

@section('head_extra')
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
@endsection

@section('content')
<div class="container py-4">
  <div class="d-flex align-items-center justify-content-between mb-3">
    <div>
      <h1 class="h4 fw-bold m-0">المنتجات</h1>
      <div class="text-muted small">تعرض {{ $paginator->total() ?? ($total ?? 0) }} اسماً مع صور تلقائية (Google CSE)</div>
    </div>
    <a href="{{ route('products.import.form') }}" class="btn btn-sm btn-primary">رفع ملف الأسماء</a>
  </div>

  @if(session('ok'))
    <div class="alert alert-success">{{ session('ok') }}</div>
  @endif
  @isset($notice)
    <div class="alert alert-info">{{ $notice }}</div>
  @endisset

  <div class="row g-3 mt-1">
    @forelse(($items ?? []) as $p)
      <div class="col-6 col-sm-4 col-md-3">
        <div class="card h-100">
          <div class="ratio ratio-4x3 bg-light">
            <img src="{{ $p['image'] }}" alt="{{ $p['name'] }}" loading="lazy" decoding="async" class="w-100 h-100" style="object-fit:cover" />
          </div>
          <div class="card-body p-2">
            <div class="small fw-bold text-truncate" title="{{ $p['name'] }}">{{ $p['name'] }}</div>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12 text-center text-muted">لا توجد بيانات حتى الآن.</div>
    @endforelse
  </div>

  @if(($paginator->lastPage() ?? 1) > 1)
    <nav class="mt-3">
      {{ $paginator->withQueryString()->links() }}
    </nav>
  @endif
</div>
@endsection
