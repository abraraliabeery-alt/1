@extends('layouts.app')

@section('head_extra')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
<style>
  .t3ps{ width:min(1200px, 92vw); margin-inline:auto; padding: 26px 0 52px }
  .t3ps-head{ display:flex; justify-content:space-between; gap:12px; flex-wrap:wrap; align-items:flex-start; margin-bottom:12px }
  .t3ps-head h1{ margin:0; font-weight:900; font-size:clamp(22px,3.2vw,32px) }
  .t3ps-price{ font-weight:900; font-size:clamp(18px,2.6vw,22px); color: color-mix(in oklab, var(--primary), #000 15%) }
  .t3ps-meta{ margin-top:8px; display:flex; flex-wrap:wrap; gap:8px; color: color-mix(in oklab, var(--fg), transparent 35%); font-weight:800 }
  .t3ps-chip{ padding:.22rem .6rem; border-radius:999px; border:1px solid color-mix(in oklab, var(--fg), transparent 85%); background: color-mix(in oklab, var(--fg), transparent 95%) }
  .t3ps-grid{ display:grid; grid-template-columns: minmax(0,1.35fr) minmax(0,1fr); gap:12px }
  @media (max-width:992px){ .t3ps-grid{ grid-template-columns:minmax(0,1fr) } }
  .t3ps-card{ border-radius:18px; border:1px solid color-mix(in oklab, var(--fg), transparent 90%); background:var(--card); box-shadow:0 12px 30px rgba(0,0,0,.07); padding:14px }
  .t3ps-hero{ border-radius:14px; overflow:hidden; aspect-ratio:16/10; background: color-mix(in oklab, var(--fg), transparent 92%) }
  .t3ps-hero img{ width:100%; height:100%; object-fit:cover; display:block }
  .t3ps-th{ display:grid; grid-template-columns: repeat(5, minmax(0,1fr)); gap:8px; margin-top:10px }
  @media (max-width:640px){ .t3ps-th{ grid-template-columns: repeat(3, minmax(0,1fr)); } }
  .t3ps-th a{ border-radius:12px; overflow:hidden; border:1px solid color-mix(in oklab, var(--fg), transparent 90%); display:block; background: color-mix(in oklab, var(--fg), transparent 94%) }
  .t3ps-th img{ width:100%; height:72px; object-fit:cover; display:block }
  .t3ps-k{ font-weight:900; margin:0 0 10px }
  .t3ps-row{ display:flex; justify-content:space-between; gap:12px; padding:10px 12px; border-radius:12px; border:1px solid color-mix(in oklab, var(--fg), transparent 90%); background: color-mix(in oklab, var(--fg), transparent 96%); font-weight:900 }
  .t3ps-row span:first-child{ color: color-mix(in oklab, var(--fg), transparent 35%) }
  .t3ps-amen{ display:flex; flex-wrap:wrap; gap:8px }
  .t3ps-cta{ display:flex; gap:10px; flex-wrap:wrap }
  .t3ps-btn{ display:inline-flex; align-items:center; gap:8px; padding:10px 14px; border-radius:999px; border:1px solid color-mix(in oklab, var(--fg), transparent 85%); text-decoration:none; font-weight:900 }
  .t3ps-btn.wa{ background:linear-gradient(135deg, var(--primary), color-mix(in oklab, var(--primary), #000 18%)); color:#000 }
  .t3ps-btn.share{ background:var(--card); color:var(--fg) }
</style>
@endsection

@section('content')
<div class="t3ps" dir="rtl">
  <div class="t3ps-head">
    <div>
      <h1>{{ $property->title }}</h1>
      <div class="t3ps-meta">
        <span class="t3ps-chip"><i class="fa-solid fa-location-dot" style="color:var(--primary)"></i> {{ $property->address }}</span>
        <span class="t3ps-chip"><i class="fa-solid fa-tag"></i> {{ $property->type_label ?? $property->type }}</span>
        @if($property->status)
          <span class="t3ps-chip"><i class="fa-solid fa-circle-check"></i> {{ $property->status }}</span>
        @endif
      </div>
    </div>
    <div class="t3ps-price">{{ number_format($property->price) }} ر.س</div>
  </div>

  <div class="t3ps-grid">
    <div class="t3ps-card">
      <div class="t3ps-hero">
        @if($property->primary_image_url)
          <a href="{{ $property->primary_image_url }}" class="glightbox" data-gallery="prop-{{ $property->id }}"><img src="{{ $property->primary_image_url }}" alt="{{ $property->title }}" loading="lazy" /></a>
        @endif
      </div>
      @if(!empty($property->gallery_urls))
        <div class="t3ps-th">
          @foreach($property->gallery_urls as $img)
            <a href="{{ $img }}" class="glightbox" data-gallery="prop-{{ $property->id }}"><img src="{{ $img }}" alt="صورة" loading="lazy" /></a>
          @endforeach
        </div>
      @endif
      @if($property->description)
        <div style="margin-top:12px">
          <div class="t3ps-k">وصف العقار</div>
          <div style="color: color-mix(in oklab, var(--fg), transparent 25%); line-height:1.8">{!! nl2br(e($property->description)) !!}</div>
        </div>
      @endif
    </div>

    <div class="t3ps-card">
      <div class="t3ps-k">المواصفات</div>
      <div class="t3ps-row"><span>المساحة</span><span>{{ $property->area ? number_format($property->area).' م²' : '-' }}</span></div>
      <div class="t3ps-row" style="margin-top:8px"><span>غرف النوم</span><span>{{ $property->bedrooms ?? '-' }}</span></div>
      <div class="t3ps-row" style="margin-top:8px"><span>دورات المياه</span><span>{{ $property->bathrooms ?? '-' }}</span></div>

      @if(!empty($property->amenities_list))
        <div style="margin-top:12px">
          <div class="t3ps-k">المزايا</div>
          <div class="t3ps-amen">
            @foreach($property->amenities_list as $am)
              <span class="t3ps-chip">{{ is_array($am) ? ($am['name'] ?? '') : $am }}</span>
            @endforeach
          </div>
        </div>
      @endif

      <div style="margin-top:14px" class="t3ps-cta">
        <a class="t3ps-btn wa" href="{{ $whatsappLink ? $whatsappLink.'?text='.urlencode('استفسار حول العقار: '.$property->title.' - '.request()->fullUrl()) : '#' }}" target="_blank" rel="noopener" @if(empty($whatsappLink)) style="pointer-events:none; opacity:.5" @endif>
          <i class="fa-brands fa-whatsapp"></i> واتساب
        </a>
        <a class="t3ps-btn share" href="#" id="share-prop-btn"><i class="fa-solid fa-share-nodes"></i> مشاركة</a>
      </div>

      @if($property->location_url)
        <div style="margin-top:12px">
          <a class="t3ps-btn share" style="width:100%; justify-content:center" href="{{ $property->location_url }}" target="_blank" rel="noopener"><i class="fa-solid fa-map-location-dot"></i> فتح على الخريطة</a>
          @if($property->is_location_embeddable)
            <div style="margin-top:10px; border-radius:14px; overflow:hidden; border:1px solid color-mix(in oklab, var(--fg), transparent 88%)">
              <div style="aspect-ratio: 16/10"><iframe src="{{ $property->location_url }}" style="border:0;width:100%;height:100%" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></div>
            </div>
          @endif
        </div>
      @endif
    </div>
  </div>

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
