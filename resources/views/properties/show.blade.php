@extends('layouts.app')

@section('content')
<div class="container" dir="rtl" style="padding-block:20px">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
  <style>
    .prop-header{ display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:12px }
    .prop-title{ margin:0; font-weight:900; font-size:clamp(22px,3.2vw,30px); color: var(--fg) }
    .prop-meta{ color: color-mix(in oklab, var(--fg), transparent 40%); display:flex; gap:10px; flex-wrap:wrap }
    .badge-chip{ background: color-mix(in oklab, var(--fg), transparent 92%); border:1px solid var(--border); color: var(--fg); padding:.25rem .55rem; border-radius:999px; font-weight:700; font-size:.85rem }
    .prop-price{ color:var(--footer-accent); font-weight:900; font-size:clamp(18px,2.6vw,22px) }
    .card{ background: var(--card); color: var(--fg); border:1px solid var(--border) }
    .thumbs{ display:grid; grid-template-columns: repeat(6, minmax(0,1fr)); gap:8px }
    @media (max-width:992px){ .thumbs{ grid-template-columns: repeat(4, 1fr) } }
    @media (max-width:576px){ .thumbs{ grid-template-columns: repeat(3, 1fr) } }
    .thumbs a{ display:block; border-radius:10px; overflow:hidden; border:1px solid var(--border); background: color-mix(in oklab, var(--fg), transparent 94%) }
    .thumbs img{ width:100%; height:86px; object-fit:cover; display:block }
    .specs-grid{ display:grid; grid-template-columns: 190px 1fr; gap:0; font-weight:700; border:1px solid var(--border); border-radius:12px; overflow:hidden }
    .specs-grid .lbl{ color: color-mix(in oklab, var(--fg), transparent 35%); background: color-mix(in oklab, var(--fg), transparent 95%); padding:10px 12px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:8px }
    .specs-grid .lbl i{ color: var(--primary); opacity:.9 }
    .specs-grid .val{ color:#0f172a; padding:10px 12px; border-bottom:1px solid var(--border); font-weight:900; text-align:start }
    .specs-grid .lbl:nth-last-child(2), .specs-grid .val:last-child{ border-bottom:none }
    @media (max-width:576px){ .specs-grid{ grid-template-columns: 1fr; } .specs-grid .val{ border-bottom:1px solid var(--border) } }
    .amenities{ display:flex; flex-wrap:wrap; gap:6px }
    .amenities .badge-chip{ font-size:.8rem }
    .section-title{ font-weight:900; margin-bottom:.6rem }
    .form-control, .form-select{ background: var(--bg); color: var(--fg); border:1px solid var(--border) }
    .form-control::placeholder{ color: color-mix(in oklab, var(--fg), transparent 50%) }
    .btn-outline{ border:1px solid var(--border) }
    .stats-strip{ display:grid; grid-template-columns: repeat(3, minmax(0,1fr)); gap:10px; margin-bottom:.8rem }
    .stat-card{ display:flex; align-items:center; gap:8px; padding:10px 12px; border:1px solid var(--border); border-radius:12px; background: var(--card) }
    .stat-card .num{ font-weight:900; font-size:1.05rem; color: var(--fg) }
    .stat-card .lbl{ color: color-mix(in oklab, var(--fg), transparent 35%); font-weight:700 }
    @media (max-width:576px){ .stats-strip{ grid-template-columns: 1fr 1fr; } }
    .sticky-cta{ position:fixed; inset:auto 20px 24px auto; z-index:95; display:flex; gap:8px; }
    .sticky-cta .cta-btn{ display:inline-flex; align-items:center; gap:8px; padding:10px 14px; border-radius:12px; text-decoration:none; font-weight:800; box-shadow:0 12px 30px rgba(0,0,0,.18); border:1px solid var(--border); }
    .cta-wa{ background: linear-gradient(180deg, var(--primary), var(--primary-700)); color:#000 }
    .cta-share{ background: var(--card); color: var(--fg) }
    @media (max-width: 900px){ .sticky-cta{ left: 16px; right: auto; bottom: 80px; } }
  </style>

  <div class="row g-3">
    <div class="col-lg-8">
      <div class="prop-header">
        <div>
          <h1 class="prop-title"><i class="fa-solid fa-house-chimney" style="color:var(--primary)"></i> {{ $property->title }}</h1>
          <div class="prop-meta">
            <span><i class="fa-solid fa-location-dot" style="color:var(--primary)"></i> {{ $property->city }} @if($property->district) - {{ $property->district }} @endif</span>
            <span class="badge-chip"><i class="fa-solid fa-tag"></i> {{ $property->type }}</span>
            @if($property->status)
              <span class="badge-chip"><i class="fa-solid fa-circle-check"></i> {{ $property->status }}</span>
            @endif
          </div>
        </div>
        <div class="prop-price"><i class="fa-solid fa-coins"></i> {{ number_format($property->price) }} ر.س</div>
      </div>

      <div class="card mb-3">
        <div class="card-body">
          @php($gallery = is_array($property->gallery ?? null) ? $property->gallery : [])
          @php($fallback = 'https://images.unsplash.com/photo-1523217582562-09d0def993a6?q=80&w=1200&auto=format&fit=crop')
          @php($first = $gallery[0] ?? null)
          @php($cover = $property->cover_image_url)
          @if(!$cover && $first)
            @php($cover = \Illuminate\Support\Str::startsWith($first, ['http://','https://']) ? $first : (\Illuminate\Support\Facades\Storage::disk('public')->exists($first) ? asset('storage/'.$first) : $fallback))
          @endif
          @php($cover = $cover ?: $fallback)
          @if(!empty($gallery))
            <div id="propCarousel-{{ $property->id }}" class="carousel slide mb-2" data-bs-ride="carousel">
              <div class="carousel-indicators">
                <button type="button" data-bs-target="#propCarousel-{{ $property->id }}" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                @foreach($gallery as $i => $img)
                  <button type="button" data-bs-target="#propCarousel-{{ $property->id }}" data-bs-slide-to="{{ $i+1 }}" aria-label="Slide {{ $i+2 }}"></button>
                @endforeach
              </div>
              <div class="carousel-inner" style="border-radius:12px; overflow:hidden">
                <div class="carousel-item active ratio ratio-16x9">
                  <a href="{{ $cover }}" class="glightbox" data-gallery="prop-{{ $property->id }}">
                    <img src="{{ $cover }}" class="d-block w-100" alt="cover" style="object-fit:cover" loading="lazy" onerror="this.onerror=null;this.src='{{ $fallback }}'">
                  </a>
                </div>
                @foreach($gallery as $img)
                  @php($src = \Illuminate\Support\Str::startsWith($img, ['http://','https://']) ? $img : (\Illuminate\Support\Facades\Storage::disk('public')->exists($img) ? asset('storage/'.$img) : $fallback))
                  <div class="carousel-item ratio ratio-16x9">
                    <a href="{{ $src }}" class="glightbox" data-gallery="prop-{{ $property->id }}">
                      <img src="{{ $src }}" class="d-block w-100" alt="gallery" style="object-fit:cover" loading="lazy" onerror="this.onerror=null;this.src='{{ $fallback }}'">
                    </a>
                  </div>
                @endforeach
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#propCarousel-{{ $property->id }}" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">السابق</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#propCarousel-{{ $property->id }}" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">التالي</span>
              </button>
            </div>
          @else
            <div class="ratio ratio-16x9 mb-2" style="background: color-mix(in oklab, var(--fg), transparent 92%); border-radius:12px; overflow:hidden">
              <img src="{{ $cover }}" alt="{{ $property->title }}" style="width:100%; height:100%; object-fit:cover" loading="lazy" onerror="this.onerror=null;this.src='{{ $fallback }}'">
            </div>
          @endif
          @if(!empty($gallery))
            <div class="thumbs">
              @foreach($gallery as $img)
                @php($src = \Illuminate\Support\Str::startsWith($img, ['http://','https://']) ? $img : (\Illuminate\Support\Facades\Storage::disk('public')->exists($img) ? asset('storage/'.$img) : $fallback))
                <a href="{{ $src }}" class="glightbox" data-gallery="prop-{{ $property->id }}">
                  <img src="{{ $src }}" alt="gallery" loading="lazy" onerror="this.onerror=null;this.src='{{ $fallback }}'">
                </a>
              @endforeach
            </div>
          @endif
        </div>
      </div>

      @php($agent = ($property->user_id ?? null) ? \App\Models\User::find($property->user_id) : null)
      @if($agent)
      <div class="card mt-3">
        <div class="card-body d-flex align-items-center gap-3">
          <div>
            <div class="fw-bold">{{ $agent->name }}</div>
            @if($agent->email)
              <div class="text-muted small">{{ $agent->email }}</div>
            @endif
          </div>
          <div class="ms-auto d-flex gap-2">
            <a class="btn btn-outline" href="mailto:{{ $agent->email }}"><i class="fa-regular fa-envelope"></i> بريد</a>
            <a class="btn btn-outline" href="https://wa.me/966503310071?text={{ urlencode('استفسار حول العقار: '.$property->title) }}" target="_blank"><i class="fa-brands fa-whatsapp"></i> واتساب</a>
          </div>
        </div>
      </div>
      @endif

      @if($property->video_url || $property->video_path)
      <div class="card mb-3">
        <div class="card-body">
          <div class="section-title"><i class="fa-solid fa-video" style="color:var(--primary)"></i> فيديو العقار</div>
          @if($property->video_url)
            <div class="ratio ratio-16x9"><iframe src="{{ $property->video_url }}" allowfullscreen style="border:0; border-radius:10px"></iframe></div>
          @else
            <div class="ratio ratio-16x9">
              <video controls style="width:100%; height:100%; border-radius:10px"><source src="{{ asset('storage/'.$property->video_path) }}" type="video/mp4"></video>
            </div>
          @endif
        </div>
      </div>
      @endif

      @if($property->description)
      <div class="card mb-3">
        <div class="card-body">
          <div class="section-title"><i class="fa-solid fa-file-lines" style="color:var(--primary)"></i> وصف العقار</div>
          <div>{!! nl2br(e($property->description)) !!}</div>
        </div>
      </div>
      @endif

      <div class="card mb-3">
        <div class="card-body">
          <div class="section-title"><i class="fa-solid fa-list-check" style="color:var(--primary)"></i> مواصفات العقار</div>
          

          <div class="stats-strip">
            @if(!empty($property->area))
              <div class="stat-card"><i class="fa-solid fa-vector-square" style="color:var(--footer-accent)"></i><div><div class="num">{{ number_format($property->area) }} م<sup>2</sup></div><div class="lbl">المساحة</div></div></div>
            @endif
            @if(!empty($property->bedrooms))
              <div class="stat-card"><i class="fa-solid fa-bed" style="color:var(--footer-accent)"></i><div><div class="num">{{ $property->bedrooms }}</div><div class="lbl">غرف النوم</div></div></div>
            @endif
            @if(!empty($property->bathrooms))
              <div class="stat-card"><i class="fa-solid fa-toilet" style="color:var(--footer-accent)"></i><div><div class="num">{{ $property->bathrooms }}</div><div class="lbl">دورات المياه</div></div></div>
            @endif
          </div>
          <div class="specs-grid">
            <div class="lbl"><i class="fa-solid fa-location-dot"></i> العنوان</div><div class="val">{{ $property->address }}</div>
            <div class="lbl"><i class="fa-solid fa-tag"></i> النوع</div><div class="val">{{ $property->type_label ?? $property->type }}</div>
            @if(!empty($property->area))
              <div class="lbl"><i class="fa-solid fa-vector-square"></i> المساحة</div><div class="val">{{ number_format($property->area) }} م<sup>2</sup></div>
            @endif
            @if(!empty($property->bedrooms))
              <div class="lbl"><i class="fa-solid fa-bed"></i> غرف النوم</div><div class="val">{{ $property->bedrooms }}</div>
            @endif
            @if(!empty($property->bathrooms))
              <div class="lbl"><i class="fa-solid fa-toilet"></i> دورات المياه</div><div class="val">{{ $property->bathrooms }}</div>
            @endif
            @if(!empty($property->age))
              <div class="lbl"><i class="fa-solid fa-hourglass-half"></i> عمر العقار</div><div class="val">{{ $property->age }}</div>
            @endif
            @if(!empty($property->floor))
              <div class="lbl"><i class="fa-solid fa-layer-group"></i> الدور</div><div class="val">{{ $property->floor }}</div>
            @endif
            @if(!empty($property->furnished_label))
              <div class="lbl"><i class="fa-solid fa-couch"></i> التأثيث</div><div class="val">{{ $property->furnished_label }}</div>
            @endif
            @if(!empty($property->interface_label))
              <div class="lbl"><i class="fa-solid fa-compass"></i> الواجهة</div><div class="val">{{ $property->interface_label }}</div>
            @endif
            @if(!empty($property->street_width))
              <div class="lbl"><i class="fa-solid fa-road"></i> عرض الشارع</div><div class="val">{{ $property->street_width }} م</div>
            @endif
            @if(!empty($property->created_at))
              <div class="lbl"><i class="fa-regular fa-clock"></i> تاريخ الإضافة</div><div class="val">{{ $property->created_at->diffForHumans() }}</div>
            @endif
          </div>
          <div class="d-flex gap-2 mt-2">
            <a class="btn btn-outline" href="https://wa.me/966503310071?text={{ urlencode('استفسار حول العقار: '.$property->title.' - '.request()->fullUrl()) }}" target="_blank"><i class="fa-brands fa-whatsapp"></i> تواصل واتساب</a>
            <button class="btn btn-outline" type="button" onclick="navigator.clipboard && navigator.clipboard.writeText('{{ request()->fullUrl() }}').then(()=>this.innerHTML='تم نسخ الرابط').catch(()=>window.prompt('انسخ الرابط:', '{{ request()->fullUrl() }}'))"><i class="fa-regular fa-copy"></i> نسخ الرابط</button>
          </div>
        </div>
      </div>

      @php($amenities = is_array($property->amenities ?? null) ? $property->amenities : (is_array($property->features ?? null) ? $property->features : []))
      @if(!empty($amenities))
      <div class="card mb-3">
        <div class="card-body">
          <div class="section-title"><i class="fa-solid fa-star" style="color:var(--primary)"></i> المزايا</div>
          <div class="amenities">
            @foreach($amenities as $am)
              @if(!empty($am))
                <span class="badge-chip">{{ is_array($am) ? ($am['name'] ?? '') : $am }}</span>
              @endif
            @endforeach
          </div>
        </div>
      </div>
      @endif

      <div class="card mb-3">
        <div class="card-body">
          <div class="section-title"><i class="fa-solid fa-comments" style="color:var(--primary)"></i> التعليقات</div>
          <div class="text-muted mb-2">لا توجد تعليقات حتى الآن.</div>
          @if(session('ok'))
            <div class="alert alert-success" role="alert">{{ session('ok') }}</div>
          @endif
          @if(($errors ?? null) && $errors->any())
            <div class="alert alert-danger" role="alert">حدثت أخطاء، يرجى مراجعة الحقول وإعادة المحاولة.</div>
          @endif
          <form id="comment-form" method="POST" action="{{ route('contact.home.store') }}" class="row g-2" novalidate>
            @csrf
            <input type="hidden" name="subject" value="تعليق على العقار: {{ $property->title }} ">
            <input type="hidden" name="property_id" value="{{ $property->id }}">
            <input type="hidden" name="property_url" value="{{ request()->fullUrl() }}">
            <div class="col-md-6">
              <label class="form-label">الاسم</label>
              <input type="text" name="name" required class="form-control" placeholder="اسمك الكامل" autocomplete="name" minlength="2">
            </div>
            <div class="col-md-6">
              <label class="form-label">الجوال</label>
              <input type="tel" name="phone" required class="form-control" placeholder="05xxxxxxxx" inputmode="numeric" pattern="^0?5\d{8}$" autocomplete="tel">
            </div>
            <div class="col-12">
              <label class="form-label">التعليق</label>
              <textarea name="message" required class="form-control" rows="3" placeholder="أضف تعليقك هنا" maxlength="2000"></textarea>
            </div>
            <div class="col-12 d-flex gap-2">
              <button class="btn btn-primary" type="submit"><i class="fa-solid fa-paper-plane"></i> إرسال التعليق</button>
              <a class="btn btn-outline" href="https://wa.me/966503310071?text={{ urlencode('استفسار حول العقار: '.$property->title.' - '.request()->fullUrl()) }}" target="_blank"><i class="fa-brands fa-whatsapp"></i> واتساب</a>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card">
        <div class="card-body">
          @if($property->location_url)
            <div class="mt-3">
              <a class="btn btn-outline w-100" href="{{ $property->location_url }}" target="_blank" rel="noopener"><i class="fa-solid fa-map-location-dot"></i> فتح على الخريطة</a>
            </div>
            @php($isEmbeddable = \Illuminate\Support\Str::contains($property->location_url, ['google.com/maps','maps.google','goo.gl/maps','maps.app.goo']))
            @if($isEmbeddable)
              <div class="ratio ratio-16x9 mt-2" style="border:1px solid var(--border); border-radius:12px; overflow:hidden">
                <iframe src="{{ $property->location_url }}" style="border:0" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
              </div>
            @endif
          @endif
        </div>
      </div>

      @auth
      
      @endauth
    </div>
  </div>

  @if(($similar ?? collect())->count())
  <div class="card mb-3 mt-3">
    <div class="card-body">
      <div class="section-title"><i class="fa-solid fa-building" style="color:var(--footer-accent)"></i> عقارات مشابهة</div>
      <div class="row g-3">
        @foreach($similar as $p)
          <div class="col-12 col-md-6 col-lg-4">
            <a href="{{ route('properties.show', $p->slug) }}" class="card" style="text-decoration:none">
              <div class="ratio ratio-16x9" style="border-radius:10px; overflow:hidden">
                <img src="{{ $p->cover_image_url ?? 'https://images.unsplash.com/photo-1523217582562-09d0def993a6?q=80&w=1200&auto=format&fit=crop' }}" alt="{{ $p->title }}" loading="lazy" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1523217582562-09d0def993a6?q=80&w=1200&auto=format&fit=crop'">
              </div>
              <div class="p-2">
                <div class="fw-bold" style="color:var(--fg)">{{ $p->title }}</div>
                <div class="text-muted small">{{ $p->address }}</div>
                <div class="fw-bold" style="color:var(--footer-accent)">{{ number_format($p->price) }} ر.س</div>
              </div>
            </a>
          </div>
        @endforeach
      </div>
    </div>
  </div>
  @endif

  <!-- Sticky CTA: WhatsApp & Share -->
  <div class="sticky-cta">
    <a class="cta-btn cta-wa" href="https://wa.me/966503310071?text={{ urlencode('استفسار حول العقار: '.$property->title.' - '.request()->fullUrl()) }}" target="_blank" rel="noopener">
      <i class="fa-brands fa-whatsapp"></i> تواصل واتساب
    </a>
    <a class="cta-btn cta-share" href="#" id="share-prop-btn">
      <i class="fa-solid fa-share-nodes"></i> مشاركة
    </a>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded',()=>{
      GLightbox({ selector: '.glightbox' });
      const f = document.getElementById('comment-form');
      if(f){
        f.addEventListener('submit', function(){
          const btn = f.querySelector('button[type="submit"]');
          if(btn){ btn.disabled = true; btn.dataset.orig = btn.innerHTML; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> جاري الإرسال...'; }
        }, { once: true });
      }
      // Share button behavior
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
