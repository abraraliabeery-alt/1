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
    <!-- Template-Matched Layout -->
    <section class="tpl-hero section">
      <div class="container grid-2" style="align-items:center">
        <div>
          <h1 class="tpl-title">شركة مدى الذهبية<br><span class="tpl-emph">بيع وشراء وتأجير وإدارة أملاك باحترافية</span></h1>
          <p class="tpl-lead">نقدّم حلولاً عقارية متكاملة تشمل التسويق العقاري والوساطة وإدارة الأملاك والتقييم والاستشارات الاستثمارية. نلتزم بالشفافية والموثوقية ونبني شراكات طويلة الأمد مع عملائنا.</p>
          <div class="hero-actions">
            <a href="#contact" class="btn btn-primary magnet">تواصل معنا الآن</a>
            <a href="#services" class="btn btn-ghost">استعرض الخدمات</a>
            <a href="{{ route('contracting') }}" class="btn btn-subtle">خدمات المقاولات</a>
          </div>
        </div>
        <div class="hero-media">
          <img
            src="{{ \App\Models\Setting::getValue('hero_image') ?: asset('assets/hero-smart-home.jpg') }}"
            alt="صورة هيرو"
            class="tpl-hero-img"
            onerror="this.onerror=null; this.src='{{ asset('assets/hero-smart-home.jpg') }}'"
          />
        </div>
      </div>
    </section>

    

 

    <section class="section" id="properties-grid">
      <div class="ep-wrap">
        <div class="ep-head">
          <h3><i class="fa-solid fa-city" style="color:var(--primary)"></i> أحدث العقارات</h3>
          <a href="{{ route('properties.index') }}" class="btn btn-outline">عرض الكل</a>
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
    

    <section class="tpl-tiles section reveal">
      <div class="container tiles">
        <article class="tile light">
          <span class="ico"><i class="fa-solid fa-building"></i></span>
          <h3>استشارات واستثمار</h3>
          <p>توجيه استثماري مبني على بيانات السوق لتحقيق أفضل عائد.</p>
        </article>
        <article class="tile dark featured">
          <span class="ico" style="background: color-mix(in oklab, var(--primary), #fff 35%)"><i class="fa-solid fa-shield-check"></i></span>
          <h3>شفافية وموثوقية</h3>
          <p>إجراءات واضحة وتقارير دقيقة تحفظ حقوق جميع الأطراف.</p>
        </article>
        <article class="tile light">
          <span class="ico"><i class="fa-solid fa-key"></i></span>
          <h3>إدارة التأجير</h3>
          <p>إدارة عقود وتحصيل ومتابعة صيانة لضمان استدامة الأصل.</p>
        </article>
      </div>
    </section>

    <section class="tpl-about section">
      <div class="container center">
        <h2 class="title-deco">عن الشركة</h2>
        <p class="narrow">نحن شركة عقارية سعودية تقدّم حلول بيع وشراء وتأجير وإدارة أملاك وتسويق عقاري وتقييم واستشارات استثمارية، برؤية تركز على الشفافية والنتائج وبناء علاقات طويلة الأمد.</p>
        <a href="#services" class="btn btn-outline">اقرأ المزيد</a>
      </div>
    </section>

    <section id="services" class="tpl-services section reveal">
      <div class="container center">
        <h2 class="title-deco">خدماتنا</h2>
         <div class="icons-grid">
          <div class="icon-card"><i class="fa-solid fa-bullhorn"></i><strong>التسويق العقاري</strong><p>حملات موجهة وتصوير احترافي وإعلانات مدفوعة لرفع الوصول.</p></div>
          <div class="icon-card"><i class="fa-regular fa-handshake"></i><strong>الوساطة العقارية</strong><p>توفيق البائعين والمشترين وإتمام الصفقات بسلاسة وأمان.</p></div>
          <div class="icon-card"><i class="fa-solid fa-key"></i><strong>إدارة الأملاك</strong><p>تحصيل وإدارة عقود ومتابعة صيانة وتقرير أداء دوري.</p></div>
          <div class="icon-card"><i class="fa-solid fa-scale-balanced"></i><strong>التقييم العقاري</strong><p>تقارير تقييم معتمدة تدعم القرارات الاستثمارية والتمويل.</p></div>
          <div class="icon-card"><i class="fa-solid fa-diagram-project"></i><strong>إدارة المشاريع</strong><p>تنسيق تنفيذ وتطوير وحدات واستغلال أمثل للأصول.</p></div>
          <div class="icon-card"><i class="fa-solid fa-chart-line"></i><strong>استشارات واستثمار</strong><p>تحليل سوق وفرص استثمارية وبناء محافظ عقارية متوازنة.</p></div>
        </div>
        <a href="#contact" class="btn btn-subtle">اعرف المزيد</a>
      </div>
    </section>

    <!-- Clients strip (moved below services) -->
    <section class="tpl-clients section reveal">
      <div class="container">
        <div class="clients-row">
          <div class="client"><img src="{{ asset('assets/top.png') }}" alt="عميل" onerror="this.style.opacity=.35"></div>
          <div class="client"><img src="{{ asset('assets/top.png') }}" alt="عميل" onerror="this.style.opacity=.35"></div>
          <div class="client"><img src="{{ asset('assets/top.png') }}" alt="عميل" onerror="this.style.opacity=.35"></div>
          <div class="client"><img src="{{ asset('assets/top.png') }}" alt="عميل" onerror="this.style.opacity=.35"></div>
          <div class="client"><img src="{{ asset('assets/top.png') }}" alt="عميل" onerror="this.style.opacity=.35"></div>
          <div class="client"><img src="{{ asset('assets/top.png') }}" alt="عميل" onerror="this.style.opacity=.35"></div>
        </div>
      </div>
    </section>

    <section class="tpl-comm section">
      <div class="container grid-2" style="align-items:center">
        <div>
          <h3>نسعى للتميّز بخدمة احترافية</h3>
          <p>فريقنا المتخصص يعمل بروح التعاون والالتزام لتحقيق رضا العملاء وبناء علاقات متينة ومستدامة معهم.</p>
          <a href="#contact" class="btn btn-primary">اتصل بنا</a>
        </div>
        <div><img src="{{ asset('assets/hero-smart-home.jpg') }}" alt="تواصل" class="band-img" loading="lazy" decoding="async" onerror="this.style.display='none'" /></div>
      </div>
    </section>


    <!-- Clients strip -->
    <section class="tpl-clients section">
      <div class="container">
        <div class="clients-row">
          <div class="client"><img src="{{ asset('assets/top.png') }}" alt="عميل" onerror="this.style.opacity=.35"></div>
          <div class="client"><img src="{{ asset('assets/top.png') }}" alt="عميل" onerror="this.style.opacity=.35"></div>
          <div class="client"><img src="{{ asset('assets/top.png') }}" alt="عميل" onerror="this.style.opacity=.35"></div>
          <div class="client"><img src="{{ asset('assets/top.png') }}" alt="عميل" onerror="this.style.opacity=.35"></div>
          <div class="client"><img src="{{ asset('assets/top.png') }}" alt="عميل" onerror="this.style.opacity=.35"></div>
          <div class="client"><img src="{{ asset('assets/top.png') }}" alt="عميل" onerror="this.style.opacity=.35"></div>
        </div>
      </div>
    </section>

    <!-- Testimonials -->
    <section class="tpl-testimonials section">
      <div class="container">
        <h2 class="title-deco">ماذا يقول عملاؤنا</h2>
        <div class="t-grid">
          <article class="t-card">
            <p class="quote">بيعنا وحدتنا خلال أسابيع مع تغطية تسويقية ممتازة وتفاوض محترف.</p>
            <div class="author"><span class="avatar"></span><span>مالك شقة سكنية</span></div>
          </article>
          <article class="t-card">
            <p class="quote">إدارة أملاك دقيقة وتقارير شهرية أوضحت لنا العوائد والتكاليف.</p>
            <div class="author"><span class="avatar"></span><span>شركة استثمار عقاري</span></div>
          </article>
          <article class="t-card">
            <p class="quote">تقييم عقاري مهني ساعدنا في الحصول على تمويل مناسب للمشروع.</p>
            <div class="author"><span class="avatar"></span><span>مطور مشروع تجاري</span></div>
          </article>
        </div>
      </div>
    </section>

    <section class="tpl-cta">
      <div class="container cta-inner">
        <div>
          <h4>لنبدأ اليوم!</h4>
          <p>أخبرنا باحتياجك لنقدّم لك أفضل عرض.</p>
        </div>
        <div class="cta-actions">
          <a href="#contact" class="btn btn-primary">تواصل معنا</a>
          <a href="{{ $whatsappLink ?? '#' }}" class="btn btn-outline" target="_blank" rel="noopener" @if(empty($whatsappLink)) style="pointer-events:none; opacity:.5" @endif>WhatsApp</a>
        </div>
      </div>
    </section>

    <!-- New Contact section (modern) -->
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
