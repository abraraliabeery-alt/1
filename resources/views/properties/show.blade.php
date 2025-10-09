@extends('layouts.app')

@section('content')
<nav class="muted" style="font-size:.9rem">
  <a href="/" class="muted">الرئيسية</a>
  <span> / </span>
  <a href="{{ route('properties.index') }}" class="muted">العقارات</a>
  <span> / </span>
  <span>{{ $property->title }}</span>
</nav>

<section class="container py-3">
  <!-- الهيدر: العنوان فقط -->
  <div class="card p-3 mb-3">
    <h1 class="m-0" style="font-size:1.4rem; color:var(--ink)">{{ $property->title }}</h1>
  </div>
  <!-- القسم 3: التفاصيل -->
  <div class="card p-3 mb-3">
    <h2 class="fw-bolder m-0" style="color:var(--ink)">{{ $property->title }}</h2>
    <div class="d-flex flex-wrap align-items-center gap-2 text-muted">
      <span class="pill">{{ $property->city }}@if($property->district) — {{ $property->district }} @endif</span>
      @if($property->area)
        <span class="badge"><i class='bx bx-ruler align-middle'></i> {{ $property->area }} م²</span>
      @endif
      @if($property->bedrooms)
        <span class="badge"><i class='bx bx-bed align-middle'></i> {{ $property->bedrooms }} غرف</span>
      @endif
      @if($property->bathrooms)
        <span class="badge"><i class='bx bx-bath align-middle'></i> {{ $property->bathrooms }} دورات</span>
    </div>
    <div class="d-flex align-items-center gap-2 mt-1">
      @if($property->location_url)
        <a class="btn btn-outline-ink btn-sm" href="{{ $property->location_url }}" target="_blank" rel="noopener"><i class='bx bx-navigation'></i> فتح الموقع</a>
      @endif
    </div>
    <div class="text-muted">الحالة: {{ $property->status ?? '—' }}</div>
    <div class="d-flex flex-wrap gap-2 mt-2">
      <a class="btn btn-ink" href="https://wa.me/966500000000?text={{ urlencode('أرغب في تفاصيل أكثر عن العقار: '.$property->title) }}" target="_blank" rel="noopener"><i class='bx bxl-whatsapp'></i> تواصل واتساب</a>
      <a class="btn btn-outline-ink" href="{{ route('properties.index') }}">رجوع للقائمة</a>
      @auth
        <form method="post" action="{{ route('favorites.toggle', $property) }}">
          @csrf
          <button class="btn @if($isFavorited) btn-outline-ink @else btn-ink @endif" type="submit">
            <i class='bx @if($isFavorited) bxs-heart @else bx-heart @endif'></i>
            @if($isFavorited) إزالة من المفضلة @else إضافة إلى المفضلة @endif
          </button>
        </form>
        <a class="btn btn-outline-ink" href="{{ route('favorites.index') }}">مفضلتي</a>
      @else
        <a class="btn btn-outline-ink" href="{{ route('login') }}">سجّل الدخول لحفظ بالمفضلة</a>
      @endauth
    </div>
  </div>
  <!-- القسم 1: الفيديو -->
  @if(!empty($property->video_path) || !empty($embedUrl))
    <div class="card p-0 overflow-hidden" style="box-shadow: var(--shadow-sm)">
      @if(!empty($property->video_path))
        <video controls class="w-100" style="max-height:520px; object-fit:cover">
          <source src="{{ $property->video_path }}" type="video/mp4">
        </video>
      @elseif(!empty($embedUrl))
        <div class="ratio ratio-16x9">
          <iframe src="{{ $embedUrl }}" allowfullscreen loading="lazy"></iframe>
        </div>
      @endif
    </div>
  @endif

  <!-- القسم 2: الصور (مصغرات + ألبوم في مودال) -->
  <div class="card mt-3 p-3">
    @if(!empty($imageSlides))
      <div class="row g-2">
        @foreach($imageSlides as $i=>$img)
          <div class="col-4 col-md-3 col-lg-2">
            <a href="#" class="d-block" data-album-index="{{ $i }}" data-bs-toggle="modal" data-bs-target="#albumModal" title="عرض الصورة">
              <img src="{{ $img['src'] }}" alt="{{ $img['alt'] }}" style="width:100%; aspect-ratio:1/1; object-fit:cover; border-radius:8px; box-shadow:0 0 0 1px var(--border)">
            </a>
          </div>
        @endforeach
      </div>
    @else
      <div class="d-flex align-items-center justify-content-center" style="height:180px; background:#f8fafc">لا توجد صور</div>
    @endif
  </div>

  <!-- ألبوم الصور: مودال + كاروسيل -->
  <div class="modal fade" id="albumModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body p-0">
          <div id="albumCarousel" class="carousel slide" data-bs-ride="false">
            <div class="carousel-inner">
              @foreach($imageSlides as $i=>$img)
                <div class="carousel-item @if($i===0) active @endif">
                  <img src="{{ $img['src'] }}" alt="{{ $img['alt'] }}" class="d-block w-100" style="max-height:80vh; object-fit:contain; background:#000">
                </div>
              @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#albumCarousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">السابق</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#albumCarousel" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">التالي</span>
            </button>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-ink" data-bs-dismiss="modal">إغلاق</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function(){
      var modalEl = document.getElementById('albumModal');
      var carouselEl = document.getElementById('albumCarousel');
      if (!modalEl || !carouselEl) return;
      var carousel = new bootstrap.Carousel(carouselEl, { interval: false });
      document.querySelectorAll('[data-album-index]').forEach(function(a){
        a.addEventListener('click', function(){
          var idx = parseInt(this.getAttribute('data-album-index')) || 0;
          var shown = function(){ carousel.to(idx); modalEl.removeEventListener('shown.bs.modal', shown); };
          modalEl.addEventListener('shown.bs.modal', shown);
        });
      });
    });
  </script>

  

  <!-- القسم 3.0: الوصف -->
  @if($property->description)
    <div class="card p-3 mt-3">
      <h3 class="m-0 mb-2">الوصف</h3>
      <div class="text-body">{!! nl2br(e($property->description)) !!}</div>
    </div>
  @endif

  <!-- القسم 3.1: المميزات (شبكة) -->
  @if(is_array($property->amenities) && count($property->amenities))
    <div class="card p-3 mt-3">
      <h3 class="m-0 mb-3">المميزات</h3>
      <div class="row g-2">
        @foreach($property->amenities as $a)
          <div class="col-6 col-md-4">
            <div class="d-flex align-items-center gap-2 p-2" style="border:1px solid var(--border); border-radius:8px">
              <i class='bx {{ $amenityIcons[$a] ?? "bx-check" }}' style="font-size:1.1rem"></i>
              <span>{{ $amenityLabels[$a] ?? $a }}</span>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  @endif

  <!-- القسم 4: معلومات إضافية -->
  <div class="card mt-3 p-3">
    <h3 class="m-0 mb-2">معلومات إضافية</h3>
    <div class="row g-3">
      <div class="col-6">
        <div class="text-muted small">النوع</div>
        <div>{{ $property->type_label }}</div>
      </div>
      <div class="col-6">
        <div class="text-muted small">المدينة</div>
        <div>{{ $property->city }}</div>
      </div>
      @if($property->district)
      <div class="col-6">
        <div class="text-muted small">الحي</div>
        <div>{{ $property->district }}</div>
      </div>
      @endif
      @if($property->location_url)
      <div class="col-12">
        <div class="text-muted small">الموقع على الخريطة</div>
        <a href="{{ $property->location_url }}" target="_blank" rel="noopener">فتح الخريطة</a>
      </div>
      @endif
    </div>
  </div>

  <!-- القسم 5: الخريطة -->
  @if(!empty($mapEmbed))
    <div class="card mt-3 p-0 overflow-hidden">
      <div class="ratio ratio-16x9"><iframe src="{{ $mapEmbed }}" loading="lazy"></iframe></div>
    </div>
  @endif

  <!-- القسم 5.5: تواصل بشأن هذا العقار -->
  <div class="card mt-3 p-3">
    <h3 class="m-0 mb-3">تواصل بشأن هذا العقار</h3>
    @if(session('ok'))
      <div class="card" style="border-color:#bbf7d0; background:#f0fdf4">{{ session('ok') }}</div>
    @endif
    @if ($errors->any())
      <div class="card" style="border-color:#fecaca; background:#fff7f7">
        <strong>تحقق من الحقول التالية:</strong>
        <ul class="clean">
          @foreach ($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    <form method="post" action="{{ route('properties.contact.store', $property->slug) }}" class="fields" style="max-width:720px">
      @csrf
      <div class="row g-2">
        <div class="col-md-6">
          <input class="field" name="name" value="{{ old('name', optional(auth()->user())->name) }}" placeholder="الاسم (اختياري)">
        </div>
        <div class="col-md-6">
          <input class="field" type="email" name="email" value="{{ old('email') }}" placeholder="البريد الإلكتروني (اختياري)">
        </div>
        <div class="col-md-12">
          <input class="field" name="phone" value="{{ old('phone') }}" placeholder="رقم الجوال (اختياري)">
        </div>
        <div class="col-12">
          <textarea class="field" name="message" rows="3" placeholder="رسالتك" required>{{ old('message') }}</textarea>
        </div>
        <div class="col-12">
          <button class="btn" type="submit">إرسال الطلب</button>
        </div>
      </div>
    </form>
  </div>

  <!-- القسم 6: عقارات مشابهة -->
  @if(isset($similar) && count($similar))
    <div class="mt-4">
      <h3 class="fw-bolder" style="color:var(--ink)">عقارات مشابهة</h3>
      <div class="row g-4 mt-1">
        @foreach($similar as $p)
          <div class="col-12 col-md-6 col-lg-4">
            <x-property-card :p="$p" />
          </div>
        @endforeach
      </div>
    </div>
  @endif

  <!-- القسم 7: التعليقات -->
  <div class="card mt-4 p-3">
    <h3 class="m-0 mb-3">التعليقات</h3>
    @if(session('ok'))
      <div class="card" style="border-color:#bbf7d0; background:#f0fdf4">{{ session('ok') }}</div>
    @endif
    @if ($errors->any())
      <div class="card" style="border-color:#fecaca; background:#fff7f7">
        <strong>تحقق من الحقول التالية:</strong>
        <ul class="clean">
          @foreach ($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="post" action="{{ route('properties.comments.store', $property->slug) }}" class="fields" style="max-width:640px">
      @csrf
      @guest
        <input class="field" name="name" value="{{ old('name') }}" placeholder="الاسم (اختياري)">
        <input class="field" name="phone" value="{{ old('phone') }}" placeholder="رقم التواصل (اختياري)">
      @else
        <input class="field" name="phone" value="{{ old('phone') }}" placeholder="رقم التواصل (اختياري)">
      @endguest
      <textarea class="field" name="body" rows="3" placeholder="أضف تعليقك" required>{{ old('body') }}</textarea>
      <div>
        <button type="submit" class="btn">إضافة تعليق</button>
      </div>
    </form>

    <div class="mt-3">
      @forelse($property->comments as $c)
        <div class="p-2" style="border:1px solid var(--border); border-radius:8px; margin-bottom:.5rem">
          <div class="d-flex justify-content-between align-items-center">
            <div class="text-muted small">
              {{ $c->name ?? optional($c->user)->name ?? 'مستخدم' }} • {{ optional($c->created_at)->diffForHumans() }}
              @if($c->phone)
                • <span dir="ltr">{{ $c->phone }}</span>
              @endif
            </div>
            @if(auth()->check() && (optional(auth()->user())->role === 'manager' || optional(auth()->user())->is_staff))
              <form method="post" action="{{ route('comments.destroy', $c) }}" onsubmit="return confirm('حذف هذا التعليق؟')">
                @csrf
                @method('DELETE')
                <button class="btn btn-outline-ink btn-sm" type="submit">حذف</button>
              </form>
            @endif
          </div>
          <div class="mt-1">{!! nl2br(e($c->body)) !!}</div>
        </div>
      @empty
        <div class="text-muted">لا توجد تعليقات بعد.</div>
      @endforelse
    </div>
  </div>
</section>
@endsection