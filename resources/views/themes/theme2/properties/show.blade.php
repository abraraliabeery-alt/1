@extends('layouts.app')

@section('head_extra')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
<style>
  .t2ps-wrap{ padding: 22px 0 52px; max-width: 1220px; margin-inline:auto; width: min(1220px, 92vw) }
  .t2ps-top{ display:flex; align-items:flex-start; justify-content:space-between; gap:12px; flex-wrap:wrap; margin-bottom:12px }
  .t2ps-title{ margin:0; font-weight:900; font-size:clamp(22px,3.2vw,32px) }
  .t2ps-meta{ margin-top:6px; color: color-mix(in oklab, var(--fg), transparent 40%); display:flex; flex-wrap:wrap; gap:8px; font-weight:700 }
  .t2ps-chip{ padding:.22rem .6rem; border-radius:999px; border:1px solid color-mix(in oklab, var(--fg), transparent 85%); background: color-mix(in oklab, var(--fg), transparent 95%) }
  .t2ps-price{ font-weight:900; font-size:clamp(18px,2.6vw,22px); color: color-mix(in oklab, var(--primary), #000 15%) }
  .t2ps-grid{ display:grid; grid-template-columns: minmax(0, 1.35fr) minmax(0, 1fr); gap:14px }
  @media (max-width:992px){ .t2ps-grid{ grid-template-columns: minmax(0,1fr); } }
  .t2ps-card{ background:var(--card); border:1px solid color-mix(in oklab, var(--fg), transparent 88%); border-radius:18px; padding:14px; box-shadow:0 14px 40px rgba(0,0,0,.06) }
  .t2ps-hero{ border-radius:14px; overflow:hidden; aspect-ratio: 16/10; background: color-mix(in oklab, var(--fg), transparent 92%) }
  .t2ps-hero img{ width:100%; height:100%; object-fit:cover; display:block }
  .t2ps-thumbs{ display:grid; grid-template-columns: repeat(5, minmax(0,1fr)); gap:8px; margin-top:10px }
  @media (max-width:640px){ .t2ps-thumbs{ grid-template-columns: repeat(3, minmax(0,1fr)); } }
  .t2ps-thumbs a{ border-radius:12px; overflow:hidden; border:1px solid color-mix(in oklab, var(--fg), transparent 88%); display:block; background: color-mix(in oklab, var(--fg), transparent 94%) }
  .t2ps-thumbs img{ width:100%; height:72px; object-fit:cover; display:block }
  .t2ps-k{ font-weight:900; margin:0 0 10px }
  .t2ps-spec{ display:grid; gap:8px }
  .t2ps-row{ display:flex; justify-content:space-between; gap:12px; padding:10px 12px; border-radius:12px; border:1px solid color-mix(in oklab, var(--fg), transparent 88%); background: color-mix(in oklab, var(--fg), transparent 96%); font-weight:800 }
  .t2ps-row span:first-child{ color: color-mix(in oklab, var(--fg), transparent 35%) }
  .t2ps-amen{ display:flex; flex-wrap:wrap; gap:8px }
  .t2ps-amen .t2ps-chip{ font-size:.85rem }
  .t2ps-cta{ display:flex; gap:10px; flex-wrap:wrap }
  .t2ps-btn{ display:inline-flex; align-items:center; gap:8px; padding:10px 14px; border-radius:999px; border:1px solid color-mix(in oklab, var(--fg), transparent 85%); text-decoration:none; font-weight:900 }
  .t2ps-btn.wa{ background:var(--primary); color:#000 }
  .t2ps-btn.share{ background:var(--card); color:var(--fg) }
</style>
@endsection

@section('content')
<div class="t2ps-wrap" dir="rtl">
  <div class="t2ps-top">
    <div>
      <h1 class="t2ps-title">{{ $property->title }}</h1>
      <div class="t2ps-meta">
        <span class="t2ps-chip"><i class="fa-solid fa-location-dot" style="color:var(--primary)"></i> {{ $property->address }}</span>
        <span class="t2ps-chip"><i class="fa-solid fa-tag"></i> {{ $property->type_label ?? $property->type }}</span>
        @if($property->status)
          <span class="t2ps-chip"><i class="fa-solid fa-circle-check"></i> {{ $property->status }}</span>
        @endif
      </div>
    </div>
    <div class="t2ps-price">{{ number_format($property->price) }} ر.س</div>
  </div>

  <div class="t2ps-grid">
    <div class="t2ps-card">
      <div class="t2ps-hero">
        @if($property->primary_image_url)
          <a href="{{ $property->primary_image_url }}" class="glightbox" data-gallery="prop-{{ $property->id }}">
            <img src="{{ $property->primary_image_url }}" alt="{{ $property->title }}" loading="lazy" />
          </a>
        @endif
      </div>
      @if(!empty($property->gallery_urls))
        <div class="t2ps-thumbs">
          @foreach($property->gallery_urls as $img)
            <a href="{{ $img }}" class="glightbox" data-gallery="prop-{{ $property->id }}">
              <img src="{{ $img }}" alt="صورة" loading="lazy" />
            </a>
          @endforeach
        </div>
      @endif
      @if($property->description)
        <div style="margin-top:12px">
          <div class="t2ps-k">وصف العقار</div>
          <div style="color: color-mix(in oklab, var(--fg), transparent 25%); line-height:1.8">{!! nl2br(e($property->description)) !!}</div>
        </div>
      @endif
    </div>

    <div class="t2ps-card">
      <div class="t2ps-k">المواصفات</div>
      <div class="t2ps-spec">
        <div class="t2ps-row"><span>المساحة</span><span>{{ $property->area ? number_format($property->area).' م²' : '-' }}</span></div>
        <div class="t2ps-row"><span>غرف النوم</span><span>{{ $property->bedrooms ?? '-' }}</span></div>
        <div class="t2ps-row"><span>دورات المياه</span><span>{{ $property->bathrooms ?? '-' }}</span></div>
      </div>

      @if(!empty($property->amenities_list))
        <div style="margin-top:12px">
          <div class="t2ps-k">المزايا</div>
          <div class="t2ps-amen">
            @foreach($property->amenities_list as $am)
              <span class="t2ps-chip">{{ is_array($am) ? ($am['name'] ?? '') : $am }}</span>
            @endforeach
          </div>
        </div>
      @endif

      <div style="margin-top:14px" class="t2ps-cta">
        <a class="t2ps-btn wa" href="{{ $whatsappLink ? $whatsappLink.'?text='.urlencode('استفسار حول العقار: '.$property->title.' - '.request()->fullUrl()) : '#' }}" target="_blank" rel="noopener" @if(empty($whatsappLink)) style="pointer-events:none; opacity:.5" @endif>
          <i class="fa-brands fa-whatsapp"></i> واتساب
        </a>
        <a class="t2ps-btn share" href="#" id="share-prop-btn">
          <i class="fa-solid fa-share-nodes"></i> مشاركة
        </a>
      </div>

      @if($property->location_url)
        <div style="margin-top:12px">
          <a class="t2ps-btn share" style="width:100%; justify-content:center" href="{{ $property->location_url }}" target="_blank" rel="noopener">
            <i class="fa-solid fa-map-location-dot"></i> فتح على الخريطة
          </a>
          @if($property->is_location_embeddable)
            <div style="margin-top:10px; border-radius:14px; overflow:hidden; border:1px solid color-mix(in oklab, var(--fg), transparent 88%)">
              <div style="aspect-ratio: 16/10">
                <iframe src="{{ $property->location_url }}" style="border:0;width:100%;height:100%" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
              </div>
            </div>
          @endif
        </div>
      @endif
    </div>
  </div>

  @if(($similar ?? collect())->count())
    <div class="t2ps-card" style="margin-top:14px">
      <div class="t2ps-k">عقارات مشابهة</div>
      <div class="t2p-grid" style="grid-template-columns: repeat(3, minmax(0,1fr));">
        @foreach($similar as $p)
          <a class="t2p-card" href="{{ route('properties.show', $p) }}" style="text-decoration:none; color:inherit">
            <div class="t2p-img">@if($p->primary_image_url)<img src="{{ $p->primary_image_url }}" alt="{{ $p->title }}" loading="lazy" />@endif</div>
            <div class="t2p-body">
              <h3 class="t2p-name">{{ $p->title }}</h3>
              <div class="t2p-loc"><i class="fa-solid fa-location-dot" style="color:var(--primary)"></i> {{ $p->address }}</div>
              <div class="t2p-footer"><div class="t2p-price">{{ number_format($p->price) }} ر.س</div><div class="t2p-link">تفاصيل</div></div>
            </div>
          </a>
        @endforeach
      </div>
    </div>
  @endif

  <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded',()=>{
      if(window.GLightbox){ GLightbox({ selector: '.glightbox' }); }
      const shareBtn = document.getElementById('share-prop-btn');
      if(shareBtn){
        shareBtn.addEventListener('click', function(e){
          e.preventDefault();
          const data = { title: '{{ addslashes($property->title) }}', text: 'اطلع على هذا العقار', url: '{{ request()->fullUrl() }}' };
          if(navigator.share){ navigator.share(data).catch(()=>{}); }
          else if(navigator.clipboard){ navigator.clipboard.writeText(data.url).then(()=>{ shareBtn.textContent='تم نسخ الرابط'; setTimeout(()=>{ shareBtn.innerHTML='<i class="fa-solid fa-share-nodes"></i> مشاركة'; }, 1400); }); }
          else { window.prompt('انسخ الرابط:', data.url); }
        });
      }
    });
  </script>
</div>
@endsection
