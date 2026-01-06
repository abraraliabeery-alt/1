@extends('layouts.app')

@section('head_extra')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
  .t2p-wrap{ padding: 26px 0 52px; max-width: 1220px; margin-inline:auto; width: min(1220px, 92vw) }
  .t2p-head{ display:flex; align-items:flex-end; justify-content:space-between; gap:14px; flex-wrap:wrap; margin-bottom:16px }
  .t2p-title{ margin:0; font-weight:900; font-size:clamp(22px,3.2vw,34px) }
  .t2p-sub{ margin:6px 0 0; color: color-mix(in oklab, var(--fg), transparent 35%) }
  .t2p-filters{ display:flex; gap:10px; flex-wrap:wrap; align-items:center }
  .t2p-filters select{ background:var(--bg); color:var(--fg); border:1px solid color-mix(in oklab, var(--fg), transparent 80%); border-radius:12px; padding:10px 12px }
  .t2p-btn{ border-radius:12px; border:1px solid color-mix(in oklab, var(--fg), transparent 80%); padding:10px 14px; font-weight:800; background:var(--primary); color:#000 }
  .t2p-grid{ display:grid; grid-template-columns: repeat(3, minmax(0,1fr)); gap:14px }
  @media (max-width:1024px){ .t2p-grid{ grid-template-columns: repeat(2, minmax(0,1fr)); } }
  @media (max-width:640px){ .t2p-grid{ grid-template-columns: minmax(0,1fr); } }
  .t2p-card{ border:1px solid color-mix(in oklab, var(--fg), transparent 88%); background:var(--card); border-radius:18px; overflow:hidden; box-shadow:0 14px 40px rgba(0,0,0,.06); display:flex; flex-direction:column }
  .t2p-img{ aspect-ratio: 16/10; background: color-mix(in oklab, var(--fg), transparent 92%); }
  .t2p-img img{ width:100%; height:100%; object-fit:cover; display:block }
  .t2p-body{ padding:12px 14px 14px }
  .t2p-name{ margin:0; font-weight:900; font-size:1rem }
  .t2p-loc{ margin-top:6px; font-size:.86rem; color: color-mix(in oklab, var(--fg), transparent 40%); display:flex; gap:6px; align-items:center }
  .t2p-metrics{ display:flex; flex-wrap:wrap; gap:8px; margin-top:10px; font-size:.82rem }
  .t2p-chip{ padding:.22rem .55rem; border-radius:999px; border:1px solid color-mix(in oklab, var(--fg), transparent 85%); background: color-mix(in oklab, var(--fg), transparent 95%); }
  .t2p-footer{ margin-top:10px; display:flex; align-items:center; justify-content:space-between; gap:10px }
  .t2p-price{ font-weight:900; color: color-mix(in oklab, var(--primary), #000 15%) }
  .t2p-link{ font-weight:900; text-decoration:none }
</style>
@endsection

@section('content')
<div class="t2p-wrap" dir="rtl">
  <div class="t2p-head">
    <div>
      @php($isLands = request()->routeIs('lands.index'))
      <h1 class="t2p-title">{{ $isLands ? 'الأراضي' : 'العقارات' }}</h1>
      <p class="t2p-sub">{{ $isLands ? 'استعرض أحدث الأراضي المتاحة مع إمكانية الفلترة حسب المدينة.' : 'استعرض أحدث العقارات المتاحة مع إمكانية الفلترة حسب المدينة.' }}</p>
    </div>
    <form method="GET" action="{{ $isLands ? route('lands.index') : route('properties.index') }}" class="t2p-filters">
      <select name="city" aria-label="المدينة">
        <option value="">جميع المدن</option>
        @foreach(($cities ?? []) as $c)
          <option value="{{ $c }}" @selected(request('city')===$c)>{{ $c }}</option>
        @endforeach
      </select>
      @if($isLands)
        <input type="hidden" name="type" value="land">
      @else
        <select name="type" aria-label="النوع">
          <option value="">جميع الأنواع</option>
          @foreach(($types ?? []) as $t)
            <option value="{{ $t }}" @selected(request('type')===$t)>{{ \App\Models\Property::typeLabel($t) }}</option>
          @endforeach
        </select>
      @endif
      <button class="t2p-btn" type="submit"><i class="fa-solid fa-filter"></i> تطبيق</button>
    </form>
  </div>

  <div class="t2p-grid">
    @forelse($properties as $property)
      <a class="t2p-card" href="{{ route('properties.show', $property) }}" style="text-decoration:none; color:inherit">
        <div class="t2p-img">
          @if($property->primary_image_url)
            <img src="{{ $property->primary_image_url }}" alt="{{ $property->title }}" loading="lazy" />
          @endif
        </div>
        <div class="t2p-body">
          <h3 class="t2p-name">{{ $property->title }}</h3>
          <div class="t2p-loc"><i class="fa-solid fa-location-dot" style="color:var(--primary)"></i> {{ $property->address }}</div>
          <div class="t2p-metrics">
            <span class="t2p-chip"><i class="fa-solid fa-tag"></i> {{ $property->type_label ?? $property->type }}</span>
            <span class="t2p-chip"><i class="fa-solid fa-bed"></i> {{ $property->bedrooms ?? '-' }}</span>
            <span class="t2p-chip"><i class="fa-solid fa-toilet"></i> {{ $property->bathrooms ?? '-' }}</span>
            <span class="t2p-chip"><i class="fa-solid fa-ruler-combined"></i> {{ $property->area ?? '-' }} م²</span>
          </div>
          <div class="t2p-footer">
            <div class="t2p-price">{{ number_format($property->price) }} ر.س</div>
            <div class="t2p-link">تفاصيل <i class="fa-solid fa-arrow-left"></i></div>
          </div>
        </div>
      </a>
    @empty
      <div style="grid-column: 1 / -1; text-align:center; color: color-mix(in oklab, var(--fg), transparent 45%)">لا توجد عقارات حالياً.</div>
    @endforelse
  </div>

  <div style="margin-top:18px">{{ $properties->links() }}</div>
</div>
@endsection
