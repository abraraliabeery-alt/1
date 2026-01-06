@extends('layouts.app')

@section('head_extra')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
@endsection

@section('content')
<main class="t5" dir="rtl">
  <section class="t5-section">
    <div class="container" style="max-width: 1220px">
      <div class="t5-prop-top">
        <div>
          <h1 class="t5-h2" style="margin:0">{{ $property->title }}</h1>
          <div class="t5-prop-meta">
            <span class="t5-chip"><i class="fa-solid fa-location-dot"></i> {{ $property->address }}</span>
            <span class="t5-chip"><i class="fa-solid fa-tag"></i> {{ $property->type_label ?? $property->type }}</span>
            @if($property->status)
              <span class="t5-chip"><i class="fa-solid fa-circle-check"></i> {{ $property->status }}</span>
            @endif
          </div>
        </div>
        <div class="t5-prop-price">{{ number_format($property->price) }} ر.س</div>
      </div>

      <div class="t5-prop-grid">
        <div class="t5-card">
          <div class="t5-card-media t5-prop-hero">
            @if($property->primary_image_url)
              <a href="{{ $property->primary_image_url }}" class="glightbox" data-gallery="prop-{{ $property->id }}">
                <img src="{{ $property->primary_image_url }}" alt="{{ $property->title }}" loading="lazy" />
              </a>
            @endif
          </div>
          @if(!empty($property->gallery_urls))
            <div class="t5-prop-thumbs">
              @foreach($property->gallery_urls as $img)
                <a href="{{ $img }}" class="glightbox" data-gallery="prop-{{ $property->id }}">
                  <img src="{{ $img }}" alt="صورة" loading="lazy" />
                </a>
              @endforeach
            </div>
          @endif
          @if($property->description)
            <div class="t5-card-body">
              <div class="t5-card-title">وصف العقار</div>
              <div class="t5-sub" style="margin-top:10px; line-height:1.85">{!! nl2br(e($property->description)) !!}</div>
            </div>
          @endif
        </div>

        <div class="t5-card">
          <div class="t5-card-body">
            <div class="t5-card-title">المواصفات</div>
            <div class="t5-prop-spec" style="margin-top:12px">
              <div class="t5-spec-row"><span>المساحة</span><span>{{ $property->area ? number_format($property->area).' م²' : '-' }}</span></div>
              <div class="t5-spec-row"><span>غرف النوم</span><span>{{ $property->bedrooms ?? '-' }}</span></div>
              <div class="t5-spec-row"><span>دورات المياه</span><span>{{ $property->bathrooms ?? '-' }}</span></div>
            </div>

            @if(!empty($property->amenities_list))
              <div style="margin-top:14px">
                <div class="t5-card-title" style="font-size: 1rem">المزايا</div>
                <div class="t5-prop-amen">
                  @foreach($property->amenities_list as $am)
                    <span class="t5-chip">{{ is_array($am) ? ($am['name'] ?? '') : $am }}</span>
                  @endforeach
                </div>
              </div>
            @endif

            <div class="t5-prop-cta">
              <a class="btn btn-primary t5-btn" href="{{ $whatsappLink ? $whatsappLink.'?text='.urlencode('استفسار حول العقار: '.$property->title.' - '.request()->fullUrl()) : '#' }}" target="_blank" rel="noopener" @if(empty($whatsappLink)) style="pointer-events:none; opacity:.5" @endif>
                <i class="fa-brands fa-whatsapp"></i> واتساب
              </a>
              <a class="btn btn-outline t5-btn" href="#" id="share-prop-btn">
                <i class="fa-solid fa-share-nodes"></i> مشاركة
              </a>
            </div>

            @if($property->location_url)
              <div style="margin-top:10px">
                <a class="btn btn-outline t5-btn" style="width:100%; justify-content:center" href="{{ $property->location_url }}" target="_blank" rel="noopener">
                  <i class="fa-solid fa-map-location-dot"></i> فتح على الخريطة
                </a>
                @if($property->is_location_embeddable)
                  <div class="t5-map">
                    <iframe src="{{ $property->location_url }}" style="border:0;width:100%;height:100%" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                  </div>
                @endif
              </div>
            @endif
          </div>
        </div>
      </div>

      @if(($similar ?? collect())->count())
        <section class="t5-section" style="padding-top: 0">
          <div class="t5-head" style="margin-bottom:12px">
            <div>
              <h2 class="t5-h2" style="font-size: 1.25rem; margin:0">عقارات مشابهة</h2>
            </div>
          </div>
          <div class="t5-grid">
            @foreach($similar as $p)
              <a class="t5-card" href="{{ route('properties.show', $p) }}" style="text-decoration:none; color:inherit">
                <div class="t5-card-media">
                  @if($p->primary_image_url)
                    <img src="{{ $p->primary_image_url }}" alt="{{ $p->title }}" loading="lazy" />
                  @else
                    <div class="t5-media-ph" aria-hidden="true"></div>
                  @endif
                </div>
                <div class="t5-card-body">
                  <div class="t5-card-title">{{ $p->title }}</div>
                  <div class="t5-card-footer" style="margin-top:12px">
                    <div class="t5-price">{{ number_format($p->price) }} ر.س</div>
                    <div class="t5-link">تفاصيل</div>
                  </div>
                </div>
              </a>
            @endforeach
          </div>
        </section>
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
  </section>
</main>
@endsection
