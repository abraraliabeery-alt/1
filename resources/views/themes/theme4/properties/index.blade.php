@extends('layouts.app')

@section('hideSiteChrome', true)

@section('head_extra')
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
  .t4p-bg{ background: radial-gradient(900px 420px at 70% 10%, color-mix(in oklab, var(--primary), transparent 88%), transparent 60%), linear-gradient(180deg, color-mix(in oklab, var(--bg), var(--fg) 86%), color-mix(in oklab, var(--bg), var(--fg) 92%)); }
  .t4p-card{ background: color-mix(in oklab, var(--bg), transparent 5%); border: 1px solid color-mix(in oklab, var(--bg), transparent 92%); }
  .t4p-text-on-dark{ color: var(--footer-fg) }
  .t4p-text-accent{ color: var(--primary) }
  .t4p-text-muted{ color: color-mix(in oklab, var(--footer-fg), transparent 20%) }
  .t4p-control{ background: color-mix(in oklab, var(--bg), var(--fg) 86%); border-color: color-mix(in oklab, var(--primary), transparent 82%); color: var(--footer-fg) }
  .t4p-btn{ background: var(--primary); color: var(--strong-text) }
  .t4p-btn:hover{ background: color-mix(in oklab, var(--primary), var(--fg) 12%) }
  .t4p-media-ph{ background: color-mix(in oklab, var(--bg), var(--fg) 82%) }
  .t4p-img-overlay{ background: linear-gradient(to top, color-mix(in oklab, var(--fg), transparent 30%), transparent) }
  .t4p-price{ background: var(--primary); color: var(--strong-text) }
  .t4p-surface{ color: var(--strong-text) }
  .t4p-subtle{ color: color-mix(in oklab, var(--strong-text), transparent 30%) }
  .t4p-badge{ background: color-mix(in oklab, var(--bg), var(--fg) 8%) }
  .t4p-empty{ color: color-mix(in oklab, var(--footer-fg), transparent 20%) }
</style>
@endsection

@section('content')
<div dir="rtl" class="t4p-bg min-h-screen t4p-text-on-dark">
  <div class="container mx-auto px-4 py-10">
    <div class="flex flex-wrap items-end justify-between gap-4 mb-6">
      <div>
        @php($isLands = request()->routeIs('lands.index'))
        <div class="t4p-text-accent text-sm font-bold uppercase tracking-wide">{{ $isLands ? 'الأراضي' : 'العقارات' }}</div>
        <h1 class="text-3xl md:text-5xl font-extrabold mt-2">{{ $isLands ? 'استعرض الأراضي المتاحة' : 'استعرض العقارات المتاحة' }}</h1>
        <p class="t4p-text-muted mt-2 max-w-2xl">{{ $isLands ? 'فلترة سريعة حسب المدينة، مع عرض بطاقات متناسق مع ثيم 4.' : 'فلترة سريعة حسب المدينة والنوع، مع عرض بطاقات متناسق مع ثيم 4.' }}</p>
      </div>
      <form method="GET" action="{{ $isLands ? route('lands.index') : route('properties.index') }}" class="flex flex-wrap gap-2 items-center">
        <select name="city" class="t4p-control border px-3 py-2 rounded-lg">
          <option value="">جميع المدن</option>
          @foreach(($cities ?? []) as $c)
            <option value="{{ $c }}" @selected(request('city')===$c)>{{ $c }}</option>
          @endforeach
        </select>
        @if($isLands)
          <input type="hidden" name="type" value="land">
        @else
          <select name="type" class="t4p-control border px-3 py-2 rounded-lg">
            <option value="">جميع الأنواع</option>
            @foreach(($types ?? []) as $t)
              <option value="{{ $t }}" @selected(request('type')===$t)>{{ \App\Models\Property::typeLabel($t) }}</option>
            @endforeach
          </select>
        @endif
        <button type="submit" class="t4p-btn px-4 py-2 rounded-lg font-extrabold transition"><i class="fa-solid fa-filter"></i> تطبيق</button>
      </form>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
      @forelse($properties as $property)
        <a href="{{ route('properties.show', $property) }}" class="block rounded-2xl overflow-hidden t4p-card hover:shadow-2xl transition" style="text-decoration:none">
          <div class="relative">
            @if($property->primary_image_url)
              <img src="{{ $property->primary_image_url }}" alt="{{ $property->title }}" class="w-full h-56 object-cover" loading="lazy" />
            @else
              <div class="w-full h-56 t4p-media-ph"></div>
            @endif
            <div class="absolute inset-0 t4p-img-overlay"></div>
            <div class="absolute bottom-3 right-3 t4p-price px-3 py-1 rounded font-bold text-sm">{{ number_format($property->price) }} ر.س</div>
          </div>
          <div class="p-4 t4p-surface">
            <div class="font-extrabold text-lg mb-1">{{ $property->title }}</div>
            <div class="text-sm t4p-subtle flex items-center gap-2"><i class="fa-solid fa-location-dot t4p-text-accent"></i> {{ $property->address }}</div>
            <div class="flex flex-wrap gap-2 mt-3 text-xs font-bold">
              <span class="t4p-badge px-2 py-1 rounded"><i class="fa-solid fa-tag"></i> {{ $property->type_label ?? $property->type }}</span>
              <span class="t4p-badge px-2 py-1 rounded">{{ $property->bedrooms ?? '-' }} غرف</span>
              <span class="t4p-badge px-2 py-1 rounded">{{ $property->bathrooms ?? '-' }} حمام</span>
              <span class="t4p-badge px-2 py-1 rounded">{{ $property->area ?? '-' }} م²</span>
            </div>
          </div>
        </a>
      @empty
        <div class="sm:col-span-2 lg:col-span-3 text-center t4p-empty">لا توجد عقارات حالياً.</div>
      @endforelse
    </div>

    <div class="mt-8">{{ $properties->links() }}</div>
  </div>
</div>
@endsection
