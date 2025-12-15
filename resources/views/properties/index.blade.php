@extends('layouts.app')

@section('content')
<div class="container mx-auto p-0 lg:p-6" dir="rtl">
    <div class="text-center mb-4 props-heading">
        <h2 class="fw-bold" style="font-size: 1.5rem;">Properties For Rent</h2>
        <div class="text-muted" style="font-size: .9rem;">ابحث بين أكثر من 200 عقاراً لايجاد المنزل المثالي في مدينتك</div>
    </div>

    <section>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
        <style>
        /* Use site's global variables from layouts.app: --primary, --bg, --fg, --card, --border */
        :root{ --accent: var(--primary); --price:#22c55e; --radius:20px; --shadow:0 10px 30px rgba(0,0,0,.15) }
        .props-heading h2{ color: var(--fg) }
        .props-heading .text-muted{ color:#6b7280 !important }
        .ep-section{ max-width:1200px; margin:auto; padding:40px 0 }
        .ep-header{ display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:10px }
        .ep-header h2{ font-size:clamp(24px,3vw,34px); font-weight:800; color: var(--fg); display:flex; align-items:center; gap:10px }
        .ep-header h2 i{ color: var(--accent) }
        .ep-header select{ background: var(--card); color: var(--fg); border:1px solid var(--border); border-radius:12px; padding:10px 14px }
        .ep-grid{ display:grid; grid-template-columns:repeat(auto-fill,minmax(320px,1fr)); gap:24px }
        .ep-card{ background: var(--card); border-radius: var(--radius); overflow:hidden; box-shadow: var(--shadow); position:relative }
        .ep-card img{ width:100%; height:230px; object-fit:cover; display:block }
        /* Slider inside cards */
        .ep-slider{ position:relative; height:230px; overflow:hidden }
        .ep-slides{ position:relative; height:100% }
        .ep-slide{ position:absolute; inset:0; width:100%; height:100%; object-fit:cover; opacity:0; transition: opacity .35s ease }
        .ep-slide.active{ opacity:1 }
        .ep-sbtn{ position:absolute; top:50%; transform:translateY(-50%); z-index:2; background: color-mix(in oklab, var(--bg), transparent 0%); color: var(--fg); border:1px solid var(--border); width:34px; height:34px; border-radius:999px; display:grid; place-items:center; cursor:pointer; opacity:.9 }
        .ep-prev{ left:8px }
        .ep-next{ right:8px }
        .ep-card-content{ padding:18px 20px 22px; color: var(--fg) }
        .ep-card h3{ margin:0; font-size:20px; font-weight:700; display:flex; align-items:center; gap:8px; color: var(--fg) }
        .ep-loc{ font-size:14px; color:#6b7280; margin:8px 0 12px; display:flex; align-items:center; gap:6px }
        .ep-features{ display:flex; flex-wrap:wrap; gap:8px; margin-bottom:14px }
        .ep-feature{ background: color-mix(in srgb, var(--card) 80%, #111 20%); border:1px solid var(--border); border-radius:999px; padding:6px 12px; font-size:13px; color: var(--fg); display:flex; align-items:center; gap:6px }
        @supports not (color-mix(in srgb, black, white)){
          .ep-feature{ background: #f1f5f9 }
        }
        .ep-price{ color: var(--price); font-weight:900; font-size:19px; margin-bottom:14px; display:flex; align-items:center; gap:8px }
        .ep-actions{ display:flex; gap:12px }
        .ep-btn{ flex:1; padding:10px; border:none; border-radius:12px; font-weight:600; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px; transition:.3s }
        .ep-btn.details{ background: var(--bg); color: var(--fg); border:1px solid var(--border) }
        .ep-btn.contact{ background: var(--primary); color:#000 }
        </style>

        <div class="ep-section" dir="rtl">
            <header class="ep-header">
              <h2><i class="fa-solid fa-city"></i> عقارات فاخرة</h2>
              <form method="GET" action="{{ route('properties.index') }}" class="flex gap-2">
                <select name="city">
                  <option value="">جميع المدن</option>
                  @foreach(($cities ?? []) as $c)
                    <option value="{{ $c }}" @selected(request('city')===$c)>{{ $c }}</option>
                  @endforeach
                </select>
                <select name="sort">
                  <option value="latest" @selected(request('sort')==='latest')>الأحدث أولاً</option>
                  <option value="price_asc" @selected(request('sort')==='price_asc')>السعر: من الأقل للأعلى</option>
                  <option value="price_desc" @selected(request('sort')==='price_desc')>السعر: من الأعلى للأقل</option>
                </select>
                <button class="ep-btn details" style="min-width:110px"><i class="fa-solid fa-filter"></i> تطبيق</button>
              </form>
            </header>

            <div class="ep-grid">
              @forelse($properties as $property)
              <div class="ep-card">
                @if(!empty($property->gallery_urls))
                  <div class="ep-slider" id="card-{{ $property->id }}">
                    <div class="ep-slides">
                      <img class="ep-slide active" src="{{ $property->primary_image_url }}" alt="{{ $property->title }}">
                      @foreach($property->gallery_urls as $img)
                        <img class="ep-slide" src="{{ $img }}" alt="gallery">
                      @endforeach
                    </div>
                    <button class="ep-sbtn ep-prev" type="button" aria-label="السابق"><i class="fa-solid fa-chevron-right"></i></button>
                    <button class="ep-sbtn ep-next" type="button" aria-label="التالي"><i class="fa-solid fa-chevron-left"></i></button>
                    <a href="{{ route('properties.show', $property) }}" aria-label="فتح تفاصيل" style="position:absolute; inset:0; z-index:1"></a>
                  </div>
                @else
                  <a href="{{ route('properties.show', $property) }}" class="d-block">
                    <img src="{{ $property->primary_image_url }}" alt="{{ $property->title }}">
                  </a>
                @endif
                <div class="ep-card-content">
                  <h3><i class="fa-solid fa-house-chimney"></i> {{ $property->title }}</h3>
                  <div class="ep-loc"><i class="fa-solid fa-location-dot"></i> {{ $property->city }} @if($property->district) - {{ $property->district }} @endif</div>
                  <div class="ep-features">
                    <span class="ep-feature"><i class="fa-solid fa-bed"></i>{{ $property->bedrooms ?? '-' }} غرف</span>
                    <span class="ep-feature"><i class="fa-solid fa-toilet"></i>{{ $property->bathrooms ?? '-' }} حمام</span>
                    <span class="ep-feature"><i class="fa-solid fa-ruler-combined"></i>{{ $property->area ?? '-' }} م²</span>
                  </div>
                  <div class="ep-price"><i class="fa-solid fa-coins"></i>{{ number_format($property->price) }} ر.س</div>
                  <div class="ep-actions">
                    <a href="{{ route('properties.show', $property) }}" class="ep-btn details"><i class="fa-solid fa-circle-info"></i> تفاصيل</a>
                    <a href="{{ !empty($contactPhone) ? 'tel:'.preg_replace('/\s+/', '', $contactPhone) : '#' }}" class="ep-btn contact" @if(empty($contactPhone)) style="pointer-events:none; opacity:.5" @endif><i class="fa-solid fa-phone"></i> تواصل</a>
                  </div>
                </div>
              </div>
              @empty
              <div class="text-center text-gray-500">لا توجد عقارات حالياً.</div>
              @endforelse
            </div>

            <div class="mt-8">{{ $properties->links() }}</div>
        </div>
    </section>
</div>
@endsection
