@extends('layouts.app')

@section('head_extra')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
  .t3p{ width:min(1200px, 92vw); margin-inline:auto; padding: 28px 0 52px }
  .t3p-hero{ border-radius:22px; padding:18px 16px; background: radial-gradient(1000px 420px at 70% 10%, color-mix(in oklab, var(--primary), transparent 75%), transparent 60%), color-mix(in oklab, var(--bg), var(--fg) 3%); border:1px solid color-mix(in oklab, var(--fg), transparent 90%); margin-bottom:16px }
  .t3p-hero h1{ margin:0; font-weight:900; font-size:clamp(22px,3.2vw,34px) }
  .t3p-hero p{ margin:.35rem 0 0; color: color-mix(in oklab, var(--fg), transparent 35%) }
  .t3p-f{ display:flex; gap:10px; flex-wrap:wrap; margin-top:12px }
  .t3p-f select{ background:var(--bg); color:var(--fg); border:1px solid color-mix(in oklab, var(--fg), transparent 82%); border-radius:12px; padding:10px 12px }
  .t3p-f button{ background:linear-gradient(135deg, var(--primary), color-mix(in oklab, var(--primary), #000 18%)); color:#000; border:none; border-radius:12px; padding:10px 14px; font-weight:900 }
  .t3p-grid{ display:grid; grid-template-columns: repeat(4, minmax(0,1fr)); gap:12px }
  @media (max-width:1024px){ .t3p-grid{ grid-template-columns: repeat(2, minmax(0,1fr)); } }
  @media (max-width:640px){ .t3p-grid{ grid-template-columns: minmax(0,1fr); } }
  .t3p-card{ border-radius:18px; overflow:hidden; border:1px solid color-mix(in oklab, var(--fg), transparent 90%); background:var(--card); box-shadow:0 12px 30px rgba(0,0,0,.07); display:flex; flex-direction:column; text-decoration:none; color:inherit }
  .t3p-img{ aspect-ratio: 4/3; background: color-mix(in oklab, var(--fg), transparent 92%); position:relative }
  .t3p-img img{ width:100%; height:100%; object-fit:cover; display:block }
  .t3p-badge{ position:absolute; inset:auto 10px 10px auto; background: color-mix(in oklab, var(--primary), #fff 35%); color:#000; padding:.25rem .55rem; border-radius:999px; font-weight:900; font-size:.8rem }
  .t3p-body{ padding:10px 12px 12px }
  .t3p-title{ margin:0; font-weight:900; font-size:.98rem }
  .t3p-loc{ margin-top:6px; font-size:.82rem; color: color-mix(in oklab, var(--fg), transparent 40%); display:flex; gap:6px; align-items:center }
  .t3p-row{ display:flex; align-items:center; justify-content:space-between; gap:10px; margin-top:10px }
  .t3p-price{ font-weight:900; color: color-mix(in oklab, var(--primary), #000 15%) }
  .t3p-mini{ font-size:.78rem; color: color-mix(in oklab, var(--fg), transparent 40%) }
</style>
@endsection

@section('content')
<div class="t3p" dir="rtl">
  <div class="t3p-hero">
    @php($isLands = request()->routeIs('lands.index'))
    <h1>{{ $isLands ? 'أراضي مميزة' : 'عقارات مميزة' }}</h1>
    <p>{{ $isLands ? 'تصفح مجموعة مختارة من الأراضي مع فلترة سريعة.' : 'تصفح مجموعة مختارة مع فلترة سريعة.' }}</p>
    <form method="GET" action="{{ $isLands ? route('lands.index') : route('properties.index') }}" class="t3p-f">
      <select name="city"><option value="">المدينة</option>@foreach(($cities ?? []) as $c)<option value="{{ $c }}" @selected(request('city')===$c)>{{ $c }}</option>@endforeach</select>
      @if($isLands)
        <input type="hidden" name="type" value="land">
      @else
        <select name="type"><option value="">النوع</option>@foreach(($types ?? []) as $t)<option value="{{ $t }}" @selected(request('type')===$t)>{{ \App\Models\Property::typeLabel($t) }}</option>@endforeach</select>
      @endif
      <button type="submit"><i class="fa-solid fa-filter"></i> تطبيق</button>
    </form>
  </div>

  <div class="t3p-grid">
    @forelse($properties as $property)
      <a class="t3p-card" href="{{ route('properties.show', $property) }}">
        <div class="t3p-img">
          @if($property->primary_image_url)
            <img src="{{ $property->primary_image_url }}" alt="{{ $property->title }}" loading="lazy" />
          @endif
          <div class="t3p-badge">{{ number_format($property->price) }} ر.س</div>
        </div>
        <div class="t3p-body">
          <h3 class="t3p-title">{{ $property->title }}</h3>
          <div class="t3p-loc"><i class="fa-solid fa-location-dot" style="color:var(--primary)"></i> {{ $property->address }}</div>
          <div class="t3p-row">
            <div class="t3p-price">{{ $property->type_label ?? $property->type }}</div>
            <div class="t3p-mini"><i class="fa-solid fa-bed"></i> {{ $property->bedrooms ?? '-' }} | <i class="fa-solid fa-ruler-combined"></i> {{ $property->area ?? '-' }} م²</div>
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
