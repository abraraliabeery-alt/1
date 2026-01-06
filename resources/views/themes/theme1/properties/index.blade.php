@extends('layouts.app')

@section('content')
<div class="container mx-auto p-0 lg:p-6" dir="rtl">
    <section>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
        <style>
        :root{ --accent: var(--primary); --radius:20px; --shadow:0 10px 30px rgba(0,0,0,.15) }
        .props-heading h2{ color: var(--fg) }
        .props-heading .text-muted{ color:#6b7280 !important }
        .ep-section{ max-width:1200px; margin:auto; padding:22px 0 34px }
        .ep-header{ display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:16px; flex-wrap:wrap; gap:10px }
        .ep-header h2{ font-size:clamp(24px,3vw,34px); font-weight:800; color: var(--fg); display:flex; align-items:center; gap:10px }
        .ep-header h2 i{ color: var(--accent) }
        .ep-header select{ background: var(--card); color: var(--fg); border:1px solid var(--border); border-radius:12px; padding:10px 14px }
        .ep-grid{ display:grid; grid-template-columns:repeat(auto-fill,minmax(320px,1fr)); gap:24px }
        .ep-card{ background: var(--card); border-radius: var(--radius); overflow:hidden; box-shadow: var(--shadow); position:relative }
        .ep-card img{ width:100%; height:230px; object-fit:cover; display:block }
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
        .ep-price{ color: var(--footer-accent); font-weight:900; font-size:19px; margin-bottom:14px; display:flex; align-items:center; gap:8px }
        .ep-actions{ display:flex; gap:12px }
        .ep-btn{ flex:1; padding:10px 12px; border:none; border-radius:12px; font-weight:700; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px; transition:.18s ease; height:44px }
        .ep-btn.details{ background: var(--bg); color: var(--fg); border:1px solid var(--border) }
        .ep-btn.contact{ background: var(--primary); color:#000 }
        .ep-filters-panel{ width:100%; background: var(--card); border: 1px solid var(--border); border-radius: 18px; padding: 14px; box-shadow: 0 18px 50px color-mix(in oklab, var(--fg), transparent 92%); }
        .ep-filters{ width:100%; display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:12px; align-items:end }
        .ep-filters input,
        .ep-filters select,
        .ep-filters button,
        .ep-filters a{ width:100% }
        .ep-group{ border:1px solid var(--border); border-radius:12px; background: var(--bg); padding:10px }
        .ep-group-title{ font-weight:800; font-size:.85rem; color: color-mix(in oklab, var(--fg), transparent 22%); margin-bottom:8px }
        .ep-inline{ display:grid; grid-template-columns: 1fr 1fr; gap:8px }
        .ep-inline .ep-btn.details{ min-width:0 !important }
        .ep-range{ border:1px solid var(--border); border-radius:14px; background: var(--bg); padding:10px; --a:0%; --b:100% }
        .ep-range-title{ font-weight:800; font-size:.85rem; color: color-mix(in oklab, var(--fg), transparent 22%); margin-bottom:10px }
        .ep-range-sliders{ position:relative; height:28px }
        .ep-range-sliders::before{ content:""; position:absolute; left:0; right:0; top:50%; transform:translateY(-50%); height:4px; border-radius:999px;
          background: linear-gradient(to right,
            color-mix(in oklab, var(--fg), transparent 86%) 0%,
            color-mix(in oklab, var(--fg), transparent 86%) var(--a),
            color-mix(in oklab, var(--primary), transparent 25%) var(--a),
            color-mix(in oklab, var(--primary), transparent 25%) var(--b),
            color-mix(in oklab, var(--fg), transparent 86%) var(--b),
            color-mix(in oklab, var(--fg), transparent 86%) 100%
          );
          pointer-events:none;
        }
        .ep-range-sliders input[type="range"]{ position:absolute; inset:0; width:100%; margin:0; background:transparent; pointer-events:none; -webkit-appearance:none; appearance:none }
        .ep-range-sliders input[type="range"]::-webkit-slider-runnable-track{ height:4px; border-radius:999px; background: transparent }
        .ep-range-sliders input[type="range"]::-webkit-slider-thumb{ -webkit-appearance:none; appearance:none; width:16px; height:16px; border-radius:999px; background: var(--primary); border:2px solid color-mix(in oklab, var(--bg), var(--fg) 0%); box-shadow: 0 8px 22px color-mix(in oklab, var(--fg), transparent 80%); pointer-events:auto }
        .ep-range-sliders input[type="range"]::-moz-range-track{ height:4px; border-radius:999px; background: transparent }
        .ep-range-sliders input[type="range"]::-moz-range-thumb{ width:16px; height:16px; border-radius:999px; background: var(--primary); border:2px solid color-mix(in oklab, var(--bg), var(--fg) 0%); box-shadow: 0 8px 22px color-mix(in oklab, var(--fg), transparent 80%); pointer-events:auto }
        .ep-range-values{ display:flex; justify-content:space-between; gap:10px; font-weight:800; font-size:.9rem; color: var(--fg); margin-top:6px }
        .ep-range-values span{ color: color-mix(in oklab, var(--fg), transparent 15%) }
        @media (max-width: 900px){
          .ep-header{ flex-direction: column; }
        }
        </style>

        <div class="ep-section" dir="rtl">
            <header class="ep-header">
              @php($isLands = request()->routeIs('lands.index'))
              <h2><i class="fa-solid fa-city"></i> {{ $isLands ? 'الأراضي' : 'العقارات' }}</h2>

              <div class="ep-filters-panel">
              <form method="GET" action="{{ $isLands ? route('lands.index') : route('properties.index') }}" class="ep-filters">
                @if($isLands)
                  <input type="hidden" name="type" value="land">
                @elseif(request()->filled('type'))
                  <input type="hidden" name="type" value="{{ request('type') }}">
                @endif

                <input name="q" value="{{ request('q') }}" placeholder="بحث بالعنوان أو المدينة أو الحي" class="ep-btn details" style="min-width:240px; text-align:right">

                <select name="city">
                  <option value="">جميع المدن</option>
                  @foreach(($cities ?? []) as $c)
                    <option value="{{ $c }}" @selected(request('city')===$c)>{{ $c }}</option>
                  @endforeach
                </select>

                <select name="district">
                  <option value="">جميع الأحياء</option>
                  @foreach(($districts ?? []) as $d)
                    <option value="{{ $d }}" @selected(request('district')===$d)>{{ $d }}</option>
                  @endforeach
                </select>

                @unless($isLands)
                  <select name="type">
                    <option value="">جميع الأنواع</option>
                    @foreach(($types ?? []) as $t)
                      <option value="{{ $t }}" @selected(request('type')===$t)>{{ \App\Models\Property::typeLabel($t) }}</option>
                    @endforeach
                  </select>
                @endunless

                <select name="status">
                  <option value="">جميع الحالات</option>
                  @foreach(($statuses ?? []) as $s)
                    <option value="{{ $s }}" @selected(request('status')===$s)>{{ $s }}</option>
                  @endforeach
                </select>

                <div class="ep-range" data-range="price" data-min="{{ $minPrice ?? 0 }}" data-max="{{ $maxPrice ?? 0 }}" data-step="1000" data-unit="ر.س">
                  <div class="ep-range-title">السعر</div>
                  <div class="ep-range-sliders">
                    <input type="range" name="min_price" value="{{ request('min_price', $minPrice ?? 0) }}" aria-label="السعر من">
                    <input type="range" name="max_price" value="{{ request('max_price', $maxPrice ?? 0) }}" aria-label="السعر إلى">
                  </div>
                  <div class="ep-range-values">
                    <span class="ep-range-min">0</span>
                    <span class="ep-range-max">0</span>
                  </div>
                </div>

                <div class="ep-range" data-range="area" data-min="{{ $minArea ?? 0 }}" data-max="{{ $maxArea ?? 0 }}" data-step="10" data-unit="م²">
                  <div class="ep-range-title">المساحة</div>
                  <div class="ep-range-sliders">
                    <input type="range" name="min_area" value="{{ request('min_area', $minArea ?? 0) }}" aria-label="المساحة من">
                    <input type="range" name="max_area" value="{{ request('max_area', $maxArea ?? 0) }}" aria-label="المساحة إلى">
                  </div>
                  <div class="ep-range-values">
                    <span class="ep-range-min">0</span>
                    <span class="ep-range-max">0</span>
                  </div>
                </div>

                <select name="sort">
                  <option value="latest" @selected(request('sort','latest')==='latest')>الأحدث أولاً</option>
                  <option value="price_asc" @selected(request('sort')==='price_asc')>السعر: من الأقل للأعلى</option>
                  <option value="price_desc" @selected(request('sort')==='price_desc')>السعر: من الأعلى للأقل</option>
                  <option value="area_asc" @selected(request('sort')==='area_asc')>المساحة: من الأقل للأعلى</option>
                  <option value="area_desc" @selected(request('sort')==='area_desc')>المساحة: من الأعلى للأقل</option>
                </select>

                <button class="ep-btn contact"><i class="fa-solid fa-filter"></i> تطبيق الفلتر</button>
                <a href="{{ $isLands ? route('lands.index') : route('properties.index', request()->filled('type') ? ['type' => request('type')] : []) }}" class="ep-btn details" style="text-decoration:none"><i class="fa-solid fa-rotate-right"></i> إعادة ضبط</a>
              </form>
              </div>
            </header>

            <div class="ep-grid">
              @forelse($properties as $property)
              <div class="ep-card">
                @if(!empty($property->gallery_urls))
                  <div class="ep-slider" id="card-{{ $property->id }}">
                    <div class="ep-slides">
                      <img class="ep-slide active" src="{{ $property->primary_image_url }}" alt="{{ $property->title }}">
                      @foreach($property->gallery_urls as $img)
                        <img class="ep-slide" src="{{ $img }}" alt="صور العقار">
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
                  <div class="ep-loc"><i class="fa-solid fa-tag"></i> {{ $property->type_label ?? $property->type }}</div>
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

<script>
  (function(){
    function formatNum(n){
      try { return new Intl.NumberFormat('ar-SA').format(n); } catch(e){ return String(n); }
    }
    document.querySelectorAll('.ep-range').forEach(function(wrap){
      var min = parseFloat(wrap.getAttribute('data-min') || '0');
      var max = parseFloat(wrap.getAttribute('data-max') || '0');
      var step = parseFloat(wrap.getAttribute('data-step') || '1');
      var unit = wrap.getAttribute('data-unit') || '';
      var inputs = wrap.querySelectorAll('input[type="range"]');
      if(inputs.length < 2) return;
      var a = inputs[0];
      var b = inputs[1];
      var minEl = wrap.querySelector('.ep-range-min');
      var maxEl = wrap.querySelector('.ep-range-max');

      a.min = min; a.max = max; a.step = step;
      b.min = min; b.max = max; b.step = step;

      function sync(){
        var v1 = parseFloat(a.value || '0');
        var v2 = parseFloat(b.value || '0');
        if(v1 > v2){
          if(document.activeElement === a){ b.value = v1; v2 = v1; }
          else { a.value = v2; v1 = v2; }
        }
        var denom = (max - min) || 1;
        var pa = Math.min(100, Math.max(0, ((v1 - min) / denom) * 100));
        var pb = Math.min(100, Math.max(0, ((v2 - min) / denom) * 100));
        wrap.style.setProperty('--a', pa + '%');
        wrap.style.setProperty('--b', pb + '%');
        if(minEl) minEl.textContent = formatNum(v1) + (unit ? ' ' + unit : '');
        if(maxEl) maxEl.textContent = formatNum(v2) + (unit ? ' ' + unit : '');
      }

      a.addEventListener('input', sync);
      b.addEventListener('input', sync);
      sync();
    });
  })();
</script>
@endsection
