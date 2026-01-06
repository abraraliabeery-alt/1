@extends('layouts.app')
@section('head_extra')
<script type="application/ld+json">
@json($organizationSchema, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES)
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
@endsection

@section('content')
<main class="t5" dir="rtl">
  <section class="t5-hero" id="home">
    <div class="container t5-hero-grid">
      <div class="t5-hero-copy">
        <div class="t5-eyebrow">{{ $heroSubtitle ?? 'تجربة عقارية بمعايير جديدة' }}</div>
        <h1 class="t5-h1">
          {{ $heroTitle ?? 'عقارك التالي' }}
          <span class="t5-hl">بلمسة احترافية</span>
        </h1>
        <p class="t5-lead">{{ $heroDescription ?? 'استعرض أحدث العروض، قارن بسهولة، وتواصل مباشرة. تصميم متوازن وتجربة سلسة من أول زيارة.' }}</p>

        <div class="t5-hero-actions">
          <a class="btn btn-primary t5-btn" href="#properties">استعرض العقارات</a>
          <a class="btn btn-outline t5-btn" href="#contact">تواصل معنا</a>
        </div>

        @if($show_kpis ?? true)
        <div class="t5-metrics" aria-label="ملخص سريع">
          @if(!empty($stats))
            @foreach(array_slice($stats, 0, 3) as $s)
              <div class="t5-metric">
                <div class="t5-metric-num">{{ $s['value'] ?? '' }}</div>
                <div class="t5-metric-lbl">{{ $s['label'] ?? '' }}</div>
              </div>
            @endforeach
          @endif
        </div>
        @endif
      </div>

      <div class="t5-hero-media" aria-hidden="true">
        <div class="t5-media-frame">
          <img src="{{ $heroImageUrl ?? asset('assets/hero-smart-home.jpg') }}" alt="" onerror="this.onerror=null; this.src='{{ asset('assets/hero-smart-home.jpg') }}'" />
        </div>
      </div>
    </div>
  </section>

  @if($show_properties ?? true)
  <section class="t5-section" id="properties">
    <div class="container">
      <div class="t5-head">
        <div>
          <h2 class="t5-h2">أحدث العقارات</h2>
          <div class="t5-sub">مختارات جديدة بتفاصيل واضحة وتجربة تصفّح سريعة.</div>
        </div>
        <div class="t5-head-actions">
          <a href="{{ route('properties.index') }}" class="btn btn-outline t5-btn">عرض الكل</a>
          <a href="{{ route('lands.index') }}" class="btn btn-outline t5-btn">الأراضي</a>
        </div>
      </div>

      <div class="t5-grid">
        @forelse(($properties ?? collect()) as $p)
          <article class="t5-card">
            <a href="{{ route('properties.show', $p) }}" class="t5-card-media">
              <img src="{{ $p->primary_image_url }}" alt="{{ $p->title }}" loading="lazy" onerror="this.style.opacity=.35" />
            </a>
            <div class="t5-card-body">
              <div class="t5-card-title">{{ $p->title }}</div>
              <div class="t5-card-meta">
                <span><i class="fa-solid fa-location-dot"></i> {{ $p->city }} @if($p->district) - {{ $p->district }} @endif</span>
              </div>
              <div class="t5-chips">
                <span class="t5-chip"><i class="fa-solid fa-bed"></i>{{ $p->bedrooms ?? '-' }}</span>
                <span class="t5-chip"><i class="fa-solid fa-toilet"></i>{{ $p->bathrooms ?? '-' }}</span>
                <span class="t5-chip"><i class="fa-solid fa-ruler-combined"></i>{{ $p->area ?? '-' }} م²</span>
              </div>
              <div class="t5-card-footer">
                <div class="t5-price">{{ number_format($p->price) }} ر.س</div>
                <a class="t5-link" href="{{ route('properties.show', $p) }}">تفاصيل</a>
              </div>
            </div>
          </article>
        @empty
          <div class="t5-empty">لا توجد عقارات حالياً.</div>
        @endforelse
      </div>
    </div>
  </section>
  @endif

  @if($show_about ?? true)
  <section class="t5-section" id="about">
    <div class="container t5-split">
      <div>
        <h2 class="t5-h2">{{ $aboutTitle ?? 'من نحن' }}</h2>
        <p class="t5-sub" style="margin-top:10px">{{ $aboutDescription ?? '' }}</p>
        <div class="t5-hero-actions" style="margin-top:14px">
          <a class="btn btn-outline t5-btn" href="#services">اكتشف خدماتنا</a>
        </div>
      </div>
      <div class="t5-about-media">
        @if(!empty($aboutImageUrl))
          <img src="{{ $aboutImageUrl }}" alt="" loading="lazy" onerror="this.style.display='none'" />
        @else
          <div class="t5-media-ph" aria-hidden="true"></div>
        @endif
      </div>
    </div>
  </section>
  @endif

  @if($show_services ?? true)
  <section class="t5-section" id="services">
    <div class="container">
      <div class="t5-head">
        <div>
          <h2 class="t5-h2">خدماتنا</h2>
          <div class="t5-sub">خدمات مدروسة لرحلتك من البحث حتى الإغلاق.</div>
        </div>
      </div>

      <div class="t5-grid t5-grid-3">
        @forelse(($services ?? collect()) as $svc)
          <div class="t5-card t5-service">
            <div class="t5-service-ico">
              @if($svc->icon)
                <i class="{{ $svc->icon }}"></i>
              @else
                <i class="fa-solid fa-screwdriver-wrench"></i>
              @endif
            </div>
            <div class="t5-card-body">
              <div class="t5-card-title">{{ $svc->title }}</div>
              @if($svc->excerpt)
                <div class="t5-sub" style="margin-top:8px">{{ $svc->excerpt }}</div>
              @endif
            </div>
          </div>
        @empty
          <div class="t5-empty">لا توجد خدمات حالياً.</div>
        @endforelse
      </div>
    </div>
  </section>
  @endif

  @if($show_projects ?? true)
  <section class="t5-section" id="projects">
    <div class="container">
      <div class="t5-head">
        <div>
          <h2 class="t5-h2">المشاريع</h2>
          <div class="t5-sub">نماذج مختارة من أعمالنا.</div>
        </div>
      </div>

      <div class="t5-grid">
        @forelse(($projects ?? collect()) as $proj)
          <article class="t5-card">
            <a href="{{ route('projects.show', $proj->slug) }}" class="t5-card-media">
              @if($proj->cover_image_url)
                <img src="{{ $proj->cover_image_url }}" alt="{{ $proj->title }}" loading="lazy" onerror="this.style.opacity=.35" />
              @else
                <div class="t5-media-ph" aria-hidden="true"></div>
              @endif
            </a>
            <div class="t5-card-body">
              <div class="t5-card-title">{{ $proj->title }}</div>
              @if($proj->city)
                <div class="t5-sub" style="margin-top:8px"><i class="fa-solid fa-location-dot"></i> {{ $proj->city }}</div>
              @endif
            </div>
          </article>
        @empty
          <div class="t5-empty">لا توجد مشاريع حالياً.</div>
        @endforelse
      </div>
    </div>
  </section>
  @endif

  @if($show_testimonials ?? true)
  <section class="t5-section" id="testimonials">
    <div class="container">
      <div class="t5-head">
        <div>
          <h2 class="t5-h2">ماذا يقول عملاؤنا</h2>
          <div class="t5-sub">ثقة مبنية على تجربة.</div>
        </div>
      </div>

      <div class="t5-grid t5-grid-3">
        @forelse(($testimonials ?? collect()) as $t)
          <article class="t5-card t5-quote">
            <div class="t5-card-body">
              @if($t->caption)
                <div class="t5-quote-text">{{ $t->caption }}</div>
              @endif
              <div class="t5-quote-author">{{ $t->title }}</div>
            </div>
          </article>
        @empty
          <div class="t5-empty">لا توجد آراء عملاء حالياً.</div>
        @endforelse
      </div>
    </div>
  </section>
  @endif

  @if($show_partners ?? true)
  <section class="t5-section" id="partners">
    <div class="container">
      <div class="t5-head">
        <div>
          <h2 class="t5-h2">الشركاء</h2>
          <div class="t5-sub">شراكات تدعم الجودة والاستمرارية.</div>
        </div>
      </div>

      <div class="t5-partners">
        @forelse(($partners ?? collect()) as $p)
          <div class="t5-partner">
            @if($p->logo_url)
              <a href="{{ $p->website_url ?: '#' }}" target="_blank" rel="noopener">
                <img src="{{ $p->logo_url }}" alt="{{ $p->name }}" loading="lazy" onerror="this.style.opacity=.35" />
              </a>
            @else
              <div class="t5-sub">{{ $p->name }}</div>
            @endif
          </div>
        @empty
          <div class="t5-empty">لا يوجد شركاء حالياً.</div>
        @endforelse
      </div>
    </div>
  </section>
  @endif

  @if($show_faqs ?? true)
  <section class="t5-section" id="faqs">
    <div class="container" style="max-width: 980px">
      <div class="t5-head">
        <div>
          <h2 class="t5-h2">الأسئلة الشائعة</h2>
          <div class="t5-sub">إجابات مختصرة لأكثر الأسئلة تكراراً.</div>
        </div>
      </div>

      <div class="t5-faq">
        @forelse(($faqs ?? collect()) as $faq)
          <details class="t5-faq-item">
            <summary class="t5-faq-q">{{ $faq->question }}</summary>
            <div class="t5-faq-a">{!! $faq->answer !!}</div>
          </details>
        @empty
          <div class="t5-empty">لا توجد أسئلة شائعة حالياً.</div>
        @endforelse
      </div>
    </div>
  </section>
  @endif

  @if($show_contact ?? true)
  <section class="t5-section" id="contact">
    <div class="container t5-contact">
      <div class="t5-contact-aside">
        <h2 class="t5-h2">تواصل معنا</h2>
        <p class="t5-sub">تواصل معنا لحجز معاينة عقارية أو طلب استشارة حول بيع، شراء أو تأجير عقارك.</p>

        <div class="t5-info">
          <div class="t5-info-row">
            <i class="fa-solid fa-phone"></i>
            <div>
              <div class="t5-info-title">رقم التواصل</div>
              <a href="{{ !empty($contactPhone) ? 'tel:'.preg_replace('/\s+/', '', $contactPhone) : '#' }}" class="t5-sub">{{ $contactPhone ?? '—' }}</a>
            </div>
          </div>
          <div class="t5-info-row">
            <i class="fa-regular fa-envelope"></i>
            <div>
              <div class="t5-info-title">البريد</div>
              <a href="{{ !empty($contactEmail) ? 'mailto:'.$contactEmail : '#' }}" class="t5-sub">{{ $contactEmail ?? '—' }}</a>
            </div>
          </div>
        </div>
      </div>

      <div class="t5-form">
        <form action="{{ route('contact.home.store') }}" method="POST" novalidate>
          @csrf
          <div class="t5-form-grid">
            <div>
              <label for="name">الاسم</label>
              <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="اسمك الكامل" required minlength="2" autocomplete="name" class="@error('name') is-invalid @enderror">
              @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div>
              <label for="phone">رقم الجوال</label>
              <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" placeholder="05xxxxxxxx" required inputmode="numeric" pattern="^0?5\d{8}$" autocomplete="tel" class="@error('phone') is-invalid @enderror">
              @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="full">
              <label for="email">البريد الإلكتروني (اختياري)</label>
              <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="you@example.com" autocomplete="email" class="@error('email') is-invalid @enderror">
              @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="full">
              <label for="type">نوع الخدمة العقارية</label>
              <select id="type" name="type" required class="@error('type') is-invalid @enderror">
                <option value="">اختر النوع</option>
                <option {{ old('type')==='شراء عقار' ? 'selected' : '' }}>شراء عقار</option>
                <option {{ old('type')==='بيع عقار' ? 'selected' : '' }}>بيع عقار</option>
                <option {{ old('type')==='تأجير/استئجار' ? 'selected' : '' }}>تأجير/استئجار</option>
                <option {{ old('type')==='إدارة أملاك' ? 'selected' : '' }}>إدارة أملاك</option>
                <option {{ old('type')==='تقييم عقاري' ? 'selected' : '' }}>تقييم عقاري</option>
                <option {{ old('type')==='استشارات واستثمار' ? 'selected' : '' }}>استشارات واستثمار</option>
                <option {{ old('type')==='أخرى' ? 'selected' : '' }}>أخرى</option>
              </select>
              @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="full">
              <label for="message">رسالتك</label>
              <textarea id="message" name="message" rows="5" placeholder="اكتب تفاصيل استفسارك" required maxlength="2000" class="@error('message') is-invalid @enderror">{{ old('message') }}</textarea>
              @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="t5-form-actions">
            <button class="btn btn-primary t5-btn" type="submit">إرسال</button>
            <a class="btn btn-outline t5-btn" href="{{ $whatsappLink ?? '#' }}" target="_blank" rel="noopener" @if(empty($whatsappLink)) style="pointer-events:none; opacity:.5" @endif>WhatsApp</a>
          </div>
        </form>
      </div>
    </div>
  </section>
  @endif
</main>
@endsection
