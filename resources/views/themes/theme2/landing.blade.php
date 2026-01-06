@extends('layouts.app')
@section('head_extra')
<script type="application/ld+json">
@json($organizationSchema, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES)
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
@endsection

@section('content')
  <!-- Scroll Progress Bar -->
  <div class="scroll-progress" aria-hidden="true"><span></span></div>

<!-- Floating action button (phone only) -->
<div id="fab" aria-label="اختصار الاتصال">
  <a href="{{ !empty($contactPhone) ? 'tel:'.preg_replace('/\s+/', '', $contactPhone) : '#' }}" class="secondary" title="اتصل" @if(empty($contactPhone)) style="pointer-events:none; opacity:.5" @endif>☎</a>
  <div id="cursor-blob" aria-hidden="true"></div>
</div>
  

  <main>
    {{-- Flash messages and validation errors --}}
    <div class="container mt-16">
      @if(session('ok'))
        <div class="alert alert-success mb-12" role="status" aria-live="polite">
          <strong>تم:</strong> {{ session('ok') }}
        </div>
      @endif
      @if($errors->any())
        <div class="alert alert-danger mb-12" role="alert">
          <strong>حدثت أخطاء:</strong>
          <ul class="list-compact">
            @foreach($errors->all() as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
        </div>
      @endif
    </div>
    <!-- Homelo Hero -->
    <section class="homelo-hero section" id="home">
      <div class="container">
        <div class="homelo-panel">
          <div class="homelo-bgword" aria-hidden="true">HOMELO</div>
          <div class="homelo-topline">Transforming the future of home living</div>

          <div class="homelo-media" aria-hidden="true">
            <img
              src="{{ $heroImageUrl ?? asset('assets/hero-smart-home.jpg') }}"
              alt="صورة هيرو"
              onerror="this.onerror=null; this.src='{{ asset('assets/hero-smart-home.jpg') }}'"
            />
          </div>

          <div class="homelo-sides">
            <div class="homelo-left">
              <div class="homelo-left-title">Start your journey towards<br>homeownership today!</div>
              <div class="homelo-actions">
                <a href="#contact" class="btn btn-primary">Get Started</a>
              </div>
            </div>

            <div class="homelo-right">
              <div class="homelo-pills">
                <span class="homelo-pill">Modern Home</span>
                <span class="homelo-pill">Luxury</span>
                <span class="homelo-pill">Eco Friendly</span>
              </div>
              <a class="homelo-explore" href="#properties">Explore</a>
            </div>
          </div>
        </div>
      </div>
    </section>

    @if($show_properties ?? true)
    <section class="section" id="properties">
      <div class="ep-wrap">
        <div class="ep-head">
          <h3><i class="fa-solid fa-city" style="color:var(--primary)"></i> أحدث العقارات</h3>
          <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap">
            <a href="{{ route('properties.index') }}" class="btn btn-outline">عرض الكل</a>
            <a href="{{ route('lands.index') }}" class="btn btn-outline">الأراضي</a>
          </div>
        </div>
        <div class="ep-grid">
          @forelse(($properties ?? collect()) as $p)
            <div class="ep-card">
              <a href="{{ route('properties.show', $p) }}" class="d-block">
                <img
                  src="{{ $p->primary_image_url }}"
                  alt="{{ $p->title }}"
                >
              </a>
              <div class="ep-body">
                <h4><i class="fa-solid fa-house-chimney" style="color:var(--primary)"></i> {{ $p->title }}</h4>
                <div class="ep-loc"><i class="fa-solid fa-location-dot" style="color:var(--primary)"></i> {{ $p->city }} @if($p->district) - {{ $p->district }} @endif</div>
                <div class="ep-feats">
                  <span class="ep-badge"><i class="fa-solid fa-bed"></i>{{ $p->bedrooms ?? '-' }} غرف</span>
                  <span class="ep-badge"><i class="fa-solid fa-toilet"></i>{{ $p->bathrooms ?? '-' }} حمام</span>
                  <span class="ep-badge"><i class="fa-solid fa-ruler-combined"></i>{{ $p->area ?? '-' }} م²</span>
                </div>
                <div class="ep-price"><i class="fa-solid fa-coins"></i>{{ number_format($p->price) }} ر.س</div>
                <div class="ep-actions">
                  <a href="{{ route('properties.show', $p) }}" class="ep-btn details"><i class="fa-solid fa-circle-info"></i> تفاصيل</a>
                  <a href="{{ !empty($contactPhone) ? 'tel:'.preg_replace('/\s+/', '', $contactPhone) : '#' }}" class="ep-btn contact" @if(empty($contactPhone)) style="pointer-events:none; opacity:.5" @endif><i class="fa-solid fa-phone"></i> تواصل</a>
                </div>
              </div>
            </div>
          @empty
            <div class="center" style="color: color-mix(in oklab, var(--fg), transparent 45%)">لا توجد عقارات حالياً.</div>
          @endforelse
        </div>
      </div>
    </section>
    @endif

    @if($show_about ?? true)
    <section id="about" class="tpl-about section">
      <div class="container center">
        <h2 class="title-deco">{{ $aboutTitle ?? 'من نحن' }}</h2>
        <p class="narrow">{{ $aboutDescription ?? '' }}</p>
        @if(!empty($aboutImageUrl))
          <div style="margin-top:12px">
            <img src="{{ $aboutImageUrl }}" alt="صورة عن الشركة" style="max-width:560px; width:100%; height:auto; border-radius:16px; margin-inline:auto" onerror="this.style.display='none'" />
          </div>
        @endif
        <a href="#services" class="btn btn-outline">اقرأ المزيد</a>
      </div>
    </section>
    @endif

    <!-- KPIs (moved up under hero) -->
    @if($show_kpis ?? true)
    <section id="stats" class="tpl-kpis section reveal">
      <div class="container">
        <div class="kpi-grid">
          @forelse(($stats ?? []) as $s)
            <div class="kpi"><span class="num">{{ $s['value'] ?? '' }}</span><span class="lbl">{{ $s['label'] ?? '' }}</span></div>
          @empty
          @endforelse
        </div>
      </div>
    </section>
    @endif

    @if($show_services ?? true)
    <section id="services" class="tpl-services section reveal">
      <div class="container center">
        <h2 class="title-deco">خدماتنا</h2>
         <div class="icons-grid">
          @forelse(($services ?? collect()) as $svc)
            <div class="icon-card">
              @if($svc->icon)
                <i class="{{ $svc->icon }}"></i>
              @else
                <i class="fa-solid fa-screwdriver-wrench"></i>
              @endif
              <strong>{{ $svc->title }}</strong>
              @if($svc->excerpt)
                <p>{{ $svc->excerpt }}</p>
              @endif
            </div>
          @empty
            <div class="center" style="color: color-mix(in oklab, var(--fg), transparent 45%)">لا توجد خدمات حالياً.</div>
          @endforelse
        </div>
        <a href="#contact" class="btn btn-subtle">اعرف المزيد</a>
      </div>
    </section>
    @endif

    @if($show_projects ?? true)
    <section id="projects" class="section">
      <div class="container center">
        <h2 class="title-deco">المشاريع</h2>
        <div class="ep-grid" style="grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));">
          @forelse(($projects ?? collect()) as $proj)
            <div class="ep-card">
              <a href="{{ route('projects.show', $proj->slug) }}" class="d-block">
                @if($proj->cover_image_url)
                  <img src="{{ $proj->cover_image_url }}" alt="{{ $proj->title }}">
                @else
                  <div style="height:200px; background: color-mix(in oklab, var(--fg), transparent 92%)"></div>
                @endif
              </a>
              <div class="ep-body">
                <h4>{{ $proj->title }}</h4>
                @if($proj->city)
                  <div class="ep-loc">{{ $proj->city }}</div>
                @endif
              </div>
            </div>
          @empty
            <div class="center" style="color: color-mix(in oklab, var(--fg), transparent 45%)">لا توجد مشاريع حالياً.</div>
          @endforelse
        </div>
      </div>
    </section>
    @endif

    <!-- Testimonials -->
    @if($show_testimonials ?? true)
    <section id="testimonials" class="tpl-testimonials section">
      <div class="container">
        <h2 class="title-deco">ماذا يقول عملاؤنا</h2>
        <div class="t-grid">
          @forelse(($testimonials ?? collect()) as $t)
            <article class="t-card">
              @if($t->caption)
                <p class="quote">{{ $t->caption }}</p>
              @endif
              <div class="author"><span class="avatar"></span><span>{{ $t->title }}</span></div>
            </article>
          @empty
            <div class="text-muted">لا توجد آراء عملاء حالياً.</div>
          @endforelse
        </div>
      </div>
    </section>
    @endif

    @if($show_partners ?? true)
    <section id="partners" class="section">
      <div class="container center">
        <h2 class="title-deco">الشركاء</h2>
        <div class="clients-row">
          @forelse(($partners ?? collect()) as $p)
            <div class="client">
              @if($p->logo_url)
                <a href="{{ $p->website_url ?: '#' }}" target="_blank" rel="noopener"><img src="{{ $p->logo_url }}" alt="{{ $p->name }}" onerror="this.style.opacity=.35"></a>
              @else
                <div style="opacity:.7">{{ $p->name }}</div>
              @endif
            </div>
          @empty
            <div class="text-muted">لا يوجد شركاء حالياً.</div>
          @endforelse
        </div>
      </div>
    </section>
    @endif

    @if($show_faqs ?? true)
    <section id="faqs" class="section">
      <div class="container" style="max-width:960px">
        <h2 class="title-deco">الأسئلة الشائعة</h2>
        <div class="card" style="padding:16px">
          @forelse(($faqs ?? collect()) as $faq)
            <div style="padding:12px 0; border-bottom:1px solid color-mix(in oklab, var(--fg), transparent 85%)">
              <strong>{{ $faq->question }}</strong>
              <div class="text-muted" style="margin-top:6px">{!! $faq->answer !!}</div>
            </div>
          @empty
            <div class="text-muted">لا توجد أسئلة شائعة حالياً.</div>
          @endforelse
        </div>
      </div>
    </section>
    @endif

    <!-- New Contact section (modern) -->
    @if($show_contact ?? true)
    <section id="contact" class="section">
      <div class="container grid-2">
        <div class="aside">
          <h2><span class="title-deco">تواصل معنا</span></h2>
          <p>تواصل معنا لحجز معاينة عقارية أو طلب استشارة حول بيع، شراء أو تأجير عقارك، وفريقنا جاهز للرد على جميع استفساراتك.</p>
          <div class="info-list">
            <div class="info-item"><i class="fa-solid fa-phone"></i><div><strong>رقم التواصل</strong><div><a href="{{ !empty($contactPhone) ? 'tel:'.preg_replace('/\s+/', '', $contactPhone) : '#' }}">{{ $contactPhone ?? '—' }}</a></div></div></div>
            <div class="info-item"><i class="fa-regular fa-envelope"></i><div><strong>البريد</strong><div><a href="{{ !empty($contactEmail) ? 'mailto:'.$contactEmail : '#' }}">{{ $contactEmail ?? '—' }}</a></div></div></div>
          </div>
        </div>
        <div class="form-card">
          <form id="contact-form-new" action="{{ route('contact.home.store') }}" method="POST" novalidate>
            @csrf
            <div class="form-grid">
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
            <div style="margin-top:.8rem; display:flex; gap:.6rem; flex-wrap:wrap">
              <button class="btn btn-primary" type="submit">إرسال</button>
              <a class="btn btn-outline" href="{{ $whatsappLink ?? '#' }}" target="_blank" rel="noopener" @if(empty($whatsappLink)) style="pointer-events:none; opacity:.5" @endif>WhatsApp</a>
            </div>
          </form>
        </div>
      </div>
    </section>
    @endif

  </main>

<script>
  document.addEventListener('DOMContentLoaded', function(){
    const track = document.getElementById('pc-track');
    const prev = document.getElementById('pc-prev');
    const next = document.getElementById('pc-next');
    if(track && prev && next){
      const step = 320;
      prev.addEventListener('click', () => track.scrollBy({ left: -step, behavior: 'smooth' }));
      next.addEventListener('click', () => track.scrollBy({ left: step, behavior: 'smooth' }));
    }
    // Reveal on scroll
    const ro = new IntersectionObserver((entries)=>{
      entries.forEach(e=>{
        if(e.isIntersecting){ e.target.classList.add('in'); ro.unobserve(e.target); }
      });
    }, { threshold: .12 });
    document.querySelectorAll('.reveal').forEach(el=>ro.observe(el));
    // Tilt on hover (pointer devices)
    const tilts = Array.from(document.querySelectorAll('.tilt'));
    const max = 10;
    tilts.forEach(card=>{
      card.addEventListener('mousemove', (ev)=>{
        const r = card.getBoundingClientRect();
        const x = ev.clientX - r.left; const y = ev.clientY - r.top;
        const rx = ((y / r.height) - .5) * -2 * max;
        const ry = ((x / r.width) - .5) * 2 * max;
        card.style.transform = `perspective(800px) rotateX(${rx}deg) rotateY(${ry}deg)`;
      });
      card.addEventListener('mouseleave', ()=>{
        card.style.transform = 'perspective(800px) rotateX(0deg) rotateY(0deg)';
      });
    });
    // Before/After slider control
    const ba = document.querySelector('#beforeAfter');
    if(ba){
      const range = ba.querySelector('input[type=range]');
      const after = ba.querySelector('.after');
      const update = ()=>{ const v = +range.value; after.style.clipPath = `inset(0 ${100-v}% 0 0)`; };
      range.addEventListener('input', update); update();
    }
    // Show newsbar when JS ready
    const nb = document.getElementById('newsbar'); if(nb){ nb.style.display = 'block'; }
    // Lucide icons init
    if(window.lucide && typeof window.lucide.createIcons === 'function'){
      window.lucide.createIcons();
    }

  });
</script>

<!-- Mobile sticky CTA bar -->
<div id="mobile-cta" hidden>
  <div class="bar">
    <a class="btn" href="{{ !empty($contactPhone) ? 'tel:'.preg_replace('/\s+/', '', $contactPhone) : '#' }}" @if(empty($contactPhone)) style="pointer-events:none; opacity:.5" @endif>اتصل الآن</a>
    <a class="btn btn-outline" href="{{ $whatsappLink ?? '#' }}" target="_blank" rel="noopener" @if(empty($whatsappLink)) style="pointer-events:none; opacity:.5" @endif>WhatsApp</a>
    <a class="btn btn-outline" href="#contact">تواصل معنا</a>
  </div>
</div>
@endsection
