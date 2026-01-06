@extends('layouts.app')

@section('head_extra')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
<main class="t5" dir="rtl">
  <section class="t5-section">
    <div class="container">
      <div class="t5-head">
        <div>
          @php($isLands = request()->routeIs('lands.index'))
          <h1 class="t5-h2" style="margin:0">{{ $isLands ? 'الأراضي' : 'العقارات' }}</h1>
          <div class="t5-sub">{{ $isLands ? 'استعرض أحدث الأراضي المتاحة مع إمكانية الفلترة حسب المدينة.' : 'استعرض أحدث العقارات المتاحة مع إمكانية الفلترة حسب المدينة والنوع.' }}</div>
        </div>
        <form method="GET" action="{{ $isLands ? route('lands.index') : route('properties.index') }}" class="t5-filters">
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
          <button class="btn btn-primary t5-btn" type="submit"><i class="fa-solid fa-filter"></i> تطبيق</button>
        </form>
      </div>

      <div class="t5-grid">
        @forelse($properties as $property)
          <a class="t5-card" href="{{ route('properties.show', $property) }}" style="text-decoration:none; color:inherit">
            <div class="t5-card-media">
              @if($property->primary_image_url)
                <img src="{{ $property->primary_image_url }}" alt="{{ $property->title }}" loading="lazy" />
              @else
                <div class="t5-media-ph" aria-hidden="true"></div>
              @endif
            </div>
            <div class="t5-card-body">
              <div class="t5-card-title">{{ $property->title }}</div>
              <div class="t5-sub" style="margin-top:8px"><i class="fa-solid fa-location-dot"></i> {{ $property->address }}</div>
              <div class="t5-chips" style="margin-top:10px">
                <span class="t5-chip"><i class="fa-solid fa-tag"></i> {{ $property->type_label ?? $property->type }}</span>
                <span class="t5-chip"><i class="fa-solid fa-bed"></i> {{ $property->bedrooms ?? '-' }}</span>
                <span class="t5-chip"><i class="fa-solid fa-toilet"></i> {{ $property->bathrooms ?? '-' }}</span>
                <span class="t5-chip"><i class="fa-solid fa-ruler-combined"></i> {{ $property->area ?? '-' }} م²</span>
              </div>
              <div class="t5-card-footer" style="margin-top:12px">
                <div class="t5-price">{{ number_format($property->price) }} ر.س</div>
                <div class="t5-link">تفاصيل <i class="fa-solid fa-arrow-left"></i></div>
              </div>
            </div>
          </a>
        @empty
          <div class="t5-empty">لا توجد عقارات حالياً.</div>
        @endforelse
      </div>

      <div class="t5-pagination">{{ $properties->links() }}</div>
    </div>
  </section>
</main>
@endsection
