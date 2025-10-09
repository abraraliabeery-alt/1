@extends('layouts.app')

@section('content')
  <!-- 1) Hero full-bleed with search -->
  <section class="full-bleed pt-1 panel-dark curve-bottom">
    <div class="relative hero-section bg-cover bg-hero">
      <div class="overlay-dark"></div>
      <div class="relative center hero-center text-center">
        <div class="maxw">
          <h1 class="hero-title text-white">اكتشف عقارك المثالي</h1>
          <p class="hero-sub text-soft">منازل، شقق، أراضٍ واستثمارات مختارة بعناية. ألوان هادئة وهوية أنيقة بالأبيض والأسود والبيج.</p>
          <form action="{{ route('properties.index') }}" method="get" class="hero-search maxw">
            <div class="fields">
              <input class="field" name="city" value="{{ request('city') }}" placeholder="المدينة">
              <select class="field" name="type">
                <option value="">النوع</option>
                @foreach(['apartment'=>'شقة','villa'=>'فيلا','land'=>'أرض','office'=>'مكتب','shop'=>'محل'] as $k=>$v)
                  <option value="{{ $k }}" @selected(request('type')==$k)>{{ $v }}</option>
                @endforeach
              </select>
              <input class="field" name="min" value="{{ request('min') }}" placeholder="أدنى سعر">
              <input class="field" name="max" value="{{ request('max') }}" placeholder="أعلى سعر">
              <button class="btn btn-dark" type="submit">بحث</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- 2) Stats band full-bleed (beige like brochure) -->
  <section class="full-bleed panel-beige py-1">
    <div class="maxw stats-grid">
      @foreach([
        ['40+','مشروع'],['50+','عميل'],['2650','وحدة'],['100','مدينة']
      ] as $s)
        <div class="card body text-center">
          <div class="fw-900">{{ $s[0] }}</div>
          <div class="muted">{{ $s[1] }}</div>
        </div>
      @endforeach
    </div>
  </section>

  <!-- 2.5) Features icons on dark panel -->
  <section class="full-bleed panel-dark py-1 curve-bottom">
    <div class="maxw">
      <h3 class="fw-900 text-white m-0 mb-05">مميزات المشروع</h3>
      <div class="grid-4">
        @foreach([
          ['أمن','<svg width="28" height="28" viewBox="0 0 24 24" fill="#fff" xmlns="http://www.w3.org/2000/svg"><path d="M12 2l7 4v6c0 5-3.5 9-7 10-3.5-1-7-5-7-10V6l7-4z"/></svg>'],
          ['مواقف','<svg width="28" height="28" viewBox="0 0 24 24" fill="#fff" xmlns="http://www.w3.org/2000/svg"><path d="M7 4h7a5 5 0 010 10H9v6H7V4zm2 2v6h5a3 3 0 000-6H9z"/></svg>'],
          ['مصاعد','<svg width="28" height="28" viewBox="0 0 24 24" fill="#fff" xmlns="http://www.w3.org/2000/svg"><path d="M7 2h10a2 2 0 012 2v16a2 2 0 01-2 2H7a2 2 0 01-2-2V4a2 2 0 012-2zm1 2v16h8V4H8zm3 12l-2-3h4l-2 3zm0-6l2 3H9l2-3z"/></svg>'],
          ['كاميرات','<svg width="28" height="28" viewBox="0 0 24 24" fill="#fff" xmlns="http://www.w3.org/2000/svg"><path d="M4 7h4l2-2h4l2 2h4a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V9a2 2 0 012-2zm8 2a5 5 0 100 10 5 5 0 000-10zm0 2a3 3 0 110 6 3 3 0 010-6z"/></svg>']
        ] as $f)
        <div class="card bg-transparent border-white-20">
          <div class="body text-center">
            {!! $f[1] !!}
            <div class="text-white">{{ $f[0] }}</div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- 3) Categories band full-bleed with images -->
  <section class="full-bleed py-1">
    <div class="maxw grid-4">
      @foreach([
        ['شقق','https://images.unsplash.com/photo-1505691723518-36a5ac3b2d91?w=800&q=80'],
        ['فلل','https://images.unsplash.com/photo-1531973968078-9bb02785f13d?w=800&q=80'],
        ['أراضٍ','https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?w=800&q=80'],
        ['مكاتب','https://images.unsplash.com/photo-1524758631624-e2822e304c36?w=800&q=80']
      ] as $c)
      <a href="{{ route('properties.index',[ 'type' => $loop->index==0?'apartment':($loop->index==1?'villa':($loop->index==2?'land':'office')) ]) }}" class="card block overflow-hidden">
        <div class="card-image-160 bg-cover {{ 'bg-cat-'.($loop->index+1) }}"></div>
        <div class="body text-center fw-900">{{ $c[0] }}</div>
      </a>
      @endforeach
    </div>
  </section>

  <!-- 4) Featured properties grid (dynamic) -->
  <section class="full-bleed py-1">
    <div class="maxw">
      <div class="between mb-05 align-center">
        <h3 class="fw-900 m-0">مختارات مميزة</h3>
        <a href="{{ route('properties.index') }}" class="btn btn-outline-dark">عرض الكل</a>
      </div>
      <div class="grid cols-3">
        @forelse($properties as $p)
          <x-property-card :p="$p" />
        @empty
          <div class="card body span-all">لا توجد عقارات حالياً.</div>
        @endforelse
      </div>
    </div>
  </section>

  <!-- 5) Split feature image/text full-bleed -->
  <section class="full-bleed band-white">
    <div class="maxw split-grid py-1">
      <div class="h-320 bg-cover bg-feature-img rounded"></div>
      <div>
        <h3 class="fw-900 mb-05 m-0">إدارة عقارية محترفة</h3>
        <p class="muted">نقدّم إدارة وتسويقًا عقاريًا مبنيًا على البيانات، مع واجهة بسيطة وألوان أنيقة بالأبيض والأسود والبيج.</p>
        <div class="mt-1"><a class="btn btn-dark" href="{{ route('properties.index') }}">ابدأ الآن</a></div>
      </div>
    </div>
  </section>

  <!-- 6) Testimonials full-bleed -->
  <section class="full-bleed py-1">
    <div class="maxw grid-3">
      @foreach([
        'واجهة بسيطة وألوان رايقة رفعت ثقة العملاء.',
        'نتائج بيع أسرع وتنظيم واضح للإعلانات.',
        'هوية أنيقة بلا تعقيد وتصفح مريح.'
      ] as $t)
      <div class="card body">{{ $t }}</div>
      @endforeach
    </div>
  </section>

  <!-- 7) Partners logos strip full-bleed -->
  <section class="full-bleed band-white">
    <div class="maxw partners-grid py-1">
      @foreach(range(1,5) as $i)
        <div class="card center h-64">
          <img src="https://dummyimage.com/120x40/eee/111&text=Logo" alt="logo"/>
        </div>
      @endforeach
    </div>
  </section>

  <!-- 8) Banner image with play overlay full-bleed -->
  <section class="full-bleed py-1">
    <div class="card maxw overflow-hidden">
      <div class="relative ratio-2-1 bg-cover bg-banner-img">
        <div class="abs inset-0 center">
          <div class="badge cursor-default">►</div>
        </div>
      </div>
    </div>
  </section>

  <!-- 9) Blog/News cards full-bleed -->
  <section class="full-bleed band-white">
    <div class="maxw py-1">
      <h3 class="fw-900 mb-05 m-0">آخر الأخبار</h3>
      <div class="grid-3">
        @foreach([
          ['تقرير السوق العقاري','bg-news-1'],
          ['نصائح شراء المنزل الأول','bg-news-2'],
          ['إطلاق مشروع جديد','bg-news-3']
        ] as $b)
        <a href="#" class="card block overflow-hidden">
          <div class="card-image-160 bg-cover {{ $b[1] }}"></div>
          <div class="body fw-900">{{ $b[0] }}</div>
        </a>
        @endforeach
      </div>
    </div>
  </section>

  <!-- 10) Contact CTA full-bleed -->
    <div class="maxw between align-center wrap py-1">
      <div>
        <h3 class="fw-900 mb-05 m-0">تواصل معنا</h3>
        <p class="muted m-0">0551234567 • info@example.com</p>
      </div>
      <a class="btn btn-primary" href="https://wa.me/966500000000" target="_blank" rel="noopener">اتصال سريع</a>
      </div>
    </section>
@endsection
