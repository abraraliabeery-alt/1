@extends('layouts.app')

@section('head_extra')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<style>
  .c-section{ padding-block:72px }
  .c-section.alt{ background: color-mix(in oklab, var(--bg), var(--fg) 4%) }
  .c-container{ width:min(1160px, 92vw); margin-inline:auto }

  /* Hero (new design) */
  #c-hero{ position:relative; padding-block:80px; overflow:hidden; background:
    radial-gradient(900px 600px at 10% -10%, color-mix(in oklab, var(--primary), transparent 70%), transparent 60%),
    radial-gradient(900px 600px at 110% 110%, color-mix(in oklab, var(--primary), transparent 76%), transparent 60%),
    var(--bg);
  }
  .c-hero-wrap{ display:grid; grid-template-columns: minmax(0,1.25fr) minmax(0,1fr); gap:2rem; align-items:center }
  @media (max-width:992px){ .c-hero-wrap{ grid-template-columns:minmax(0,1fr); text-align:center } .c-hero-meta{ justify-content:center } .c-hero-nums{ justify-content:center } }
  .c-hero-eyebrow{ display:inline-flex; align-items:center; gap:.4rem; padding:.25rem .85rem; border-radius:999px; background: color-mix(in oklab, var(--primary), #fff 35%); color:#000; font-weight:800; font-size:.8rem }
  .c-hero-eyebrow i{ font-size:.9rem }
  .c-hero-title{ font-weight:900; font-size:clamp(28px,3.8vw,44px); margin:.8rem 0 .5rem; line-height:1.3 }
  .c-hero-title span{ color:var(--primary) }
  .c-hero-lead{ color: color-mix(in oklab, var(--fg), transparent 30%); font-size:.98rem; max-width:60ch }
  @media (max-width:992px){ .c-hero-lead{ margin-inline:auto } }
  .c-hero-meta{ display:flex; flex-wrap:wrap; gap:.6rem; margin-top:1rem; font-size:.85rem; color: color-mix(in oklab, var(--fg), transparent 35%) }
  .c-hero-meta span{ display:inline-flex; align-items:center; gap:.35rem; padding:.25rem .65rem; border-radius:999px; background: color-mix(in oklab, var(--fg), transparent 94%) }
  .c-hero-meta i{ color:var(--primary) }

  .c-hero-actions{ display:flex; flex-wrap:wrap; gap:.7rem; margin-top:1.4rem }
  @media (max-width:992px){ .c-hero-actions{ justify-content:center } }
  .c-cta-primary{ display:inline-flex; align-items:center; gap:.4rem; padding:.65rem 1.3rem; border-radius:999px; border:none; background:linear-gradient(135deg, var(--primary), color-mix(in oklab, var(--primary), #000 18%)); color:#000; font-weight:800; text-decoration:none }
  .c-cta-secondary{ display:inline-flex; align-items:center; gap:.4rem; padding:.6rem 1.1rem; border-radius:999px; border:1px solid color-mix(in oklab, var(--fg), transparent 80%); background:var(--card); color:var(--fg); font-weight:700; text-decoration:none }

  .c-hero-footer{ display:flex; flex-wrap:wrap; gap:1.2rem; margin-top:1.4rem; font-size:.86rem; color: color-mix(in oklab, var(--fg), transparent 38%) }
  @media (max-width:992px){ .c-hero-footer{ justify-content:center } }
  .c-hero-footer span{ display:inline-flex; align-items:center; gap:.35rem }
  .c-hero-footer i{ color:var(--primary) }

  .c-hero-card{ position:relative; border-radius:22px; padding:18px 18px 20px; background: color-mix(in oklab, var(--bg), var(--primary) 8%); box-shadow:0 22px 60px rgba(0,0,0,.18); border:1px solid color-mix(in oklab, var(--fg), transparent 85%); overflow:hidden }
  .c-hero-card-head{ display:flex; align-items:center; justify-content:space-between; gap:.8rem; margin-bottom:10px }
  .c-hero-card-head h3{ margin:0; font-weight:900; font-size:1rem }
  .c-hero-badge{ font-size:.75rem; padding:.25rem .6rem; border-radius:999px; background: color-mix(in oklab, var(--primary), #fff 35%); color:#000; font-weight:800 }
  .c-hero-note{ font-size:.85rem; color: color-mix(in oklab, var(--fg), transparent 35%); margin-bottom:1rem }

  .c-hero-nums{ display:flex; flex-wrap:wrap; gap:.8rem }
  .c-hero-num{ flex:1 1 90px; min-width:90px; padding:10px 10px 12px; border-radius:14px; background: color-mix(in oklab, var(--bg), var(--fg) 4%); border:1px solid color-mix(in oklab, var(--fg), transparent 86%) }
  .c-hero-num strong{ display:block; font-size:1.1rem; font-weight:900 }
  .c-hero-num span{ display:block; font-size:.78rem; color: color-mix(in oklab, var(--fg), transparent 40%) }

  .c-hero-steps{ margin-top:1.1rem; border-top:1px dashed color-mix(in oklab, var(--fg), transparent 80%); padding-top:.8rem; display:grid; gap:.45rem; font-size:.82rem }
  .c-hero-step{ display:flex; align-items:flex-start; gap:.4rem }
  .c-hero-step .dot{ width:18px; height:18px; border-radius:999px; display:grid; place-items:center; background:var(--primary); color:#000; font-size:.7rem; font-weight:800 }
  .c-hero-step span{ color: color-mix(in oklab, var(--fg), transparent 30%) }

  .c-section-title{ font-weight:900; font-size:clamp(22px,3vw,30px); margin-bottom:.4rem }
  .c-section-sub{ color: color-mix(in oklab, var(--fg), transparent 35%); margin-bottom:1.4rem; max-width:60ch }

  .c-services-grid{ display:grid; grid-template-columns: repeat(3,minmax(0,1fr)); gap:1rem }
  @media (max-width:992px){ .c-services-grid{ grid-template-columns: repeat(2,minmax(0,1fr)); } }
  @media (max-width:640px){ .c-services-grid{ grid-template-columns: minmax(0,1fr); } }
  .c-service-card{ position:relative; background:var(--card); border-radius:16px; padding:16px 14px 18px; border:1px solid color-mix(in oklab, var(--fg), transparent 86%); box-shadow:0 10px 30px rgba(0,0,0,.06); display:flex; flex-direction:column; gap:.4rem }
  .c-service-icon{ width:34px; height:34px; border-radius:12px; display:grid; place-items:center; background: color-mix(in oklab, var(--primary), #fff 40%); color:#000; margin-bottom:.4rem }
  .c-service-title{ font-weight:800; margin:0; font-size:1rem }
  .c-service-text{ font-size:.9rem; color: color-mix(in oklab, var(--fg), transparent 35%) }
  .c-chip-row{ display:flex; flex-wrap:wrap; gap:.35rem; margin-top:.4rem }
  .c-chip{ font-size:.78rem; padding:.15rem .55rem; border-radius:999px; border:1px solid color-mix(in oklab, var(--fg), transparent 80%); color: color-mix(in oklab, var(--fg), transparent 25%) }

  .c-steps{ display:grid; grid-template-columns: repeat(4,minmax(0,1fr)); gap:1rem }
  @media (max-width:992px){ .c-steps{ grid-template-columns: repeat(2,minmax(0,1fr)); } }
  @media (max-width:640px){ .c-steps{ grid-template-columns: minmax(0,1fr); } }
  .c-step{ position:relative; background:var(--card); border-radius:14px; padding:16px 14px 18px; border:1px solid color-mix(in oklab, var(--fg), transparent 86%); display:flex; flex-direction:column; gap:.3rem }
  .c-step-num{ width:24px; height:24px; border-radius:999px; display:grid; place-items:center; background:var(--primary); color:#000; font-size:.8rem; font-weight:800 }
  .c-step-title{ font-weight:800; font-size:.98rem; margin:0 }
  .c-step-text{ font-size:.86rem; color: color-mix(in oklab, var(--fg), transparent 35%) }

  .c-projects-grid{ display:grid; grid-template-columns: repeat(3,minmax(0,1fr)); gap:1rem }
  @media (max-width:992px){ .c-projects-grid{ grid-template-columns: repeat(2,minmax(0,1fr)); } }
  @media (max-width:640px){ .c-projects-grid{ grid-template-columns: minmax(0,1fr); } }
  .c-project-card{ border-radius:16px; overflow:hidden; background:var(--card); border:1px solid color-mix(in oklab, var(--fg), transparent 88%); box-shadow:0 12px 32px rgba(0,0,0,.08); display:flex; flex-direction:column }
  .c-project-img{ aspect-ratio:4/3; background: color-mix(in oklab, var(--fg), transparent 92%); }
  .c-project-img img{ width:100%; height:100%; object-fit:cover; display:block }
  .c-project-body{ padding:12px 13px 14px }
  .c-project-meta{ display:flex; flex-wrap:wrap; gap:.4rem; font-size:.8rem; color: color-mix(in oklab, var(--fg), transparent 40%) }
  .c-project-title{ font-weight:800; margin:.2rem 0 .25rem; font-size:.98rem }

  .c-why-grid{ display:grid; grid-template-columns: repeat(4,minmax(0,1fr)); gap:1rem }
  @media (max-width:992px){ .c-why-grid{ grid-template-columns: repeat(2,minmax(0,1fr)); } }
  @media (max-width:640px){ .c-why-grid{ grid-template-columns: minmax(0,1fr); } }
  .c-why-card{ background:var(--card); border-radius:14px; padding:14px 13px 16px; border:1px solid color-mix(in oklab, var(--fg), transparent 88%); display:flex; flex-direction:column; gap:.3rem }
  .c-why-icon{ width:30px; height:30px; border-radius:10px; display:grid; place-items:center; background: color-mix(in oklab, var(--primary), #fff 35%); color:#000 }
  .c-why-title{ font-weight:800; font-size:.96rem; margin:0 }
  .c-why-text{ font-size:.86rem; color: color-mix(in oklab, var(--fg), transparent 35%) }

  .c-contact-grid{ display:grid; grid-template-columns: minmax(0,1.2fr) minmax(0,1fr); gap:1.4rem; align-items:flex-start }
  @media (max-width:992px){ .c-contact-grid{ grid-template-columns: minmax(0,1fr); } }
  .c-form-card{ background:var(--card); border-radius:18px; padding:18px 16px 20px; border:1px solid color-mix(in oklab, var(--fg), transparent 86%); box-shadow:0 16px 40px rgba(0,0,0,.08) }
  .c-form-row{ display:grid; grid-template-columns: repeat(2,minmax(0,1fr)); gap:.8rem }
  @media (max-width:640px){ .c-form-row{ grid-template-columns:minmax(0,1fr); } }
  .c-form-label{ font-weight:700; font-size:.9rem; margin-bottom:.25rem }
  .c-form-control,.c-form-select,.c-form-textarea{ width:100%; border-radius:10px; border:1px solid color-mix(in oklab, var(--fg), transparent 86%); background:var(--bg); color:var(--fg); padding:.55rem .65rem; font-size:.9rem }
  .c-form-textarea{ min-height:110px; resize:vertical }
  .c-aside-list{ display:grid; gap:.55rem; font-size:.9rem }
  .c-aside-item{ display:flex; gap:.5rem; align-items:flex-start }
  .c-aside-icon{ width:28px; height:28px; border-radius:10px; display:grid; place-items:center; background: color-mix(in oklab, var(--primary), #fff 45%); color:#000 }
  .c-aside-body strong{ display:block; font-weight:800; margin-bottom:.1rem }
  .c-aside-body span{ color: color-mix(in oklab, var(--fg), transparent 35%) }
</style>
@endsection

@section('content')
<section class="c-section" id="home">
  <div class="c-container c-hero-wrap">
    <div>
      <div class="c-hero-eyebrow">
        <i class="fa-solid fa-helmet-safety"></i>
        <span>قسم المقاولات</span>
      </div>
      <h1 class="c-hero-title">نخطّط وننفّذ <span>مشروع البناء</span> من أول حجر حتى التسليم.</h1>
      <p class="c-hero-lead">نعمل معك خطوة بخطوة لتجهيز الأرض، تنفيذ الهيكل، التشطيبات، وأعمال الخدمات المساندة مع متابعة هندسية واضحة وتقارير دورية.</p>

      <div class="c-hero-meta">
        <span><i class="fa-solid fa-building"></i> فلل، شقق، ومشاريع تجارية</span>
        <span><i class="fa-solid fa-location-dot"></i> تنفيذ داخل المملكة</span>
        <span><i class="fa-solid fa-shield-heart"></i> ضمان على الأعمال حسب الاتفاق</span>
      </div>

      <div class="c-hero-actions">
        <a href="#contact" class="c-cta-primary">
          <i class="fa-solid fa-file-signature"></i>
          <span>ابدأ بطلب عرض سعر</span>
        </a>
        <a href="{{ $whatsappLink ?? '#' }}" target="_blank" rel="noopener" class="c-cta-secondary" @if(empty($whatsappLink)) style="pointer-events:none; opacity:.5" @endif>
          <i class="fa-brands fa-whatsapp"></i>
          <span>تواصل فوري عبر واتساب</span>
        </a>
      </div>

      <div class="c-hero-footer">
        <span><i class="fa-solid fa-circle-check"></i> متابعة من مهندس/مسؤول واحد للمشروع</span>
        <span><i class="fa-solid fa-calendar-days"></i> خطة تنفيذ بمراحل وزمن تقريبي واضح</span>
      </div>
    </div>
    <div>
      <div class="c-hero-card" aria-label="ملخص سريع لمشاريع المقاولات">
        <div class="c-hero-card-head">
          <h3><i class="fa-solid fa-diagram-project"></i> لمحة عن مشاريع المقاولات</h3>
          <span class="c-hero-badge">تنفيذ وإشراف كامل</span>
        </div>
        <p class="c-hero-note">هذا القسم يوضح بشكل سريع ما الذي نقدمه عادةً في مشاريع البناء والتشطيبات والترميم.</p>
        <div class="c-hero-nums">
          <div class="c-hero-num">
            <strong>+10</strong>
            <span>أنواع أعمال (عظم، تشطيب، ترميم، تجهيز محلات)</span>
          </div>
          <div class="c-hero-num">
            <strong>مراحل</strong>
            <span>خطة عمل مقسّمة على خطوات يمكن متابعتها بسهولة</span>
          </div>
        </div>
        <div class="c-hero-steps">
          <div class="c-hero-step">
            <div class="dot">1</div>
            <span>جلسة تعريفية لفهم فكرة المشروع، الميزانية التقريبية، والجدول الزمني المطلوب.</span>
          </div>
          <div class="c-hero-step">
            <div class="dot">2</div>
            <span>زيارة ميدانية للموقع ودراسة أفضل طريقة لتنفيذ الأعمال.</span>
          </div>
          <div class="c-hero-step">
            <div class="dot">3</div>
            <span>إعداد عرض سعر مفصّل وخطة تنفيذ بمراحل واضحة.</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@if($show_properties ?? true)
<section class="c-section alt" id="properties">
  <div class="c-container">
    <h2 class="c-section-title">أحدث العقارات</h2>
    <p class="c-section-sub">تصفح آخر العقارات المضافة، ويمكنك عرض الأراضي فقط من الرابط المخصص.</p>
    <div style="display:flex; gap:.6rem; flex-wrap:wrap; margin-bottom:1rem">
      <a href="{{ route('properties.index') }}" class="c-cta-secondary">عرض الكل</a>
      <a href="{{ route('lands.index') }}" class="c-cta-secondary">الأراضي</a>
    </div>

    <div class="c-projects-grid">
      @forelse(($properties ?? collect()) as $p)
        <article class="c-project-card">
          <div class="c-project-img">
            <img src="{{ $p->primary_image_url }}" alt="{{ $p->title }}">
          </div>
          <div class="c-project-body">
            <div class="c-project-meta">
              <span><i class="fa-solid fa-location-dot"></i> {{ $p->city }}@if($p->district) - {{ $p->district }}@endif</span>
            </div>
            <h3 class="c-project-title">{{ $p->title }}</h3>
            <div class="c-chip-row">
              <span class="c-chip">{{ $p->bedrooms ?? '-' }} غرف</span>
              <span class="c-chip">{{ $p->bathrooms ?? '-' }} حمام</span>
              <span class="c-chip">{{ $p->area ?? '-' }} م²</span>
              <span class="c-chip">{{ number_format($p->price) }} ر.س</span>
              <a class="c-chip" href="{{ route('properties.show', $p) }}">التفاصيل</a>
            </div>
          </div>
        </article>
      @empty
        <div class="text-muted">لا توجد عقارات حالياً.</div>
      @endforelse
    </div>
  </div>
</section>
@endif

@if($show_about ?? true)
<section class="c-section" id="about">
  <div class="c-container">
    <div class="c-hero-wrap">
      <div>
        <h2 class="c-section-title">{{ $aboutTitle ?? 'من نحن' }}</h2>
        <p class="c-section-sub">{{ $aboutDescription ?? '' }}</p>
      </div>
      <div>
        @if(!empty($aboutImageUrl))
          <div class="c-hero-card">
            <div class="c-project-img" style="aspect-ratio: 16/10; border-radius:16px; overflow:hidden">
              <img src="{{ $aboutImageUrl }}" alt="صورة عن الشركة">
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>
</section>
@endif

@if($show_kpis ?? true)
<section class="c-section alt" id="stats">
  <div class="c-container">
    <h2 class="c-section-title">الإحصائيات</h2>
    <p class="c-section-sub">نِسب وأرقام مختصرة تعكس حجم العمل والخبرة.</p>
    <div class="c-hero-nums">
      @forelse(($stats ?? []) as $s)
        <div class="c-hero-num">
          <strong>{{ $s['value'] ?? '' }}</strong>
          <span>{{ $s['label'] ?? '' }}</span>
        </div>
      @empty
      @endforelse
    </div>
  </div>
</section>
@endif

@if($show_services ?? true)
<section class="c-section alt" id="services">
  <div class="c-container">
    <h2 class="c-section-title">خدمات المقاولات التي نقدمها</h2>
    <p class="c-section-sub">مجموعة متكاملة من خدمات التنفيذ والإشراف تغطي دورة المشروع بالكامل، من دراسة المتطلبات وحتى التسليم النهائي.</p>
    <div class="c-services-grid">
      @forelse(($services ?? collect()) as $svc)
        <article class="c-service-card">
          <div class="c-service-icon">
            @if($svc->icon)
              <i class="{{ $svc->icon }}"></i>
            @else
              <i class="fa-solid fa-screwdriver-wrench"></i>
            @endif
          </div>
          <h3 class="c-service-title">{{ $svc->title }}</h3>
          @if($svc->excerpt)
            <p class="c-service-text">{{ $svc->excerpt }}</p>
          @endif
          <div class="c-chip-row">
            <a class="c-chip" href="{{ route('services.show', $svc->slug) }}">التفاصيل</a>
          </div>
        </article>
      @empty
        <div class="text-muted">لا توجد خدمات حالياً.</div>
      @endforelse
    </div>
  </div>
</section>
@endif

@if($show_projects ?? true)
<section class="c-section alt" id="projects">
  <div class="c-container">
    <h2 class="c-section-title">نماذج من الأعمال التي يمكن تنفيذها</h2>
    <p class="c-section-sub">الصور التالية أمثلة توضيحية لنوع ومستوى الأعمال التي يمكن تنفيذها حسب احتياج مشروعك.</p>
    <div class="c-projects-grid">
      @forelse(($projects ?? collect()) as $proj)
        <a href="{{ route('projects.show', $proj->slug) }}" class="c-project-card" style="text-decoration:none; color:inherit">
          <div class="c-project-img">
            @if($proj->cover_image_url)
              <img src="{{ $proj->cover_image_url }}" alt="{{ $proj->title }}">
            @endif
          </div>
          <div class="c-project-body">
            <div class="c-project-meta">
              @if($proj->city)
                <span><i class="fa-solid fa-location-dot"></i> {{ $proj->city }}</span>
              @endif
            </div>
            <h3 class="c-project-title">{{ $proj->title }}</h3>
          </div>
        </a>
      @empty
        <div class="text-muted">لا توجد مشاريع حالياً.</div>
      @endforelse
    </div>
  </div>
</section>
@endif

@if($show_testimonials ?? true)
<section class="c-section" id="testimonials">
  <div class="c-container">
    <h2 class="c-section-title">آراء العملاء</h2>
    <p class="c-section-sub">ثقة العملاء ورضاهم هو أكبر دليل على جودة خدماتنا.</p>
    <div class="c-why-grid">
      @forelse(($testimonials ?? collect()) as $t)
        <article class="c-why-card">
          <div class="c-why-icon">
            @if($t->image_url)
              <img src="{{ $t->image_url }}" alt="{{ $t->title }}" style="width:100%; height:100%; object-fit:cover; border-radius:10px">
            @else
              <i class="fa-solid fa-user"></i>
            @endif
          </div>
          <h3 class="c-why-title">{{ $t->title }}</h3>
          @if($t->caption)
            <p class="c-why-text">{{ $t->caption }}</p>
          @endif
        </article>
      @empty
        <div class="text-muted">لا توجد آراء عملاء حالياً.</div>
      @endforelse
    </div>
  </div>
</section>
@endif

@if($show_partners ?? true)
<section class="c-section alt" id="partners">
  <div class="c-container">
    <h2 class="c-section-title">شركاؤنا</h2>
    <p class="c-section-sub">شركاء نعتز بالتعاون معهم.</p>
    <div class="c-services-grid">
      @forelse(($partners ?? collect()) as $p)
        <a href="{{ $p->website_url ?: '#' }}" target="_blank" rel="noopener" class="c-service-card" style="text-decoration:none; color:inherit">
          <div class="c-service-icon">
            @if($p->logo_url)
              <img src="{{ $p->logo_url }}" alt="{{ $p->name }}" style="width:100%; height:100%; object-fit:contain">
            @else
              <i class="fa-solid fa-handshake"></i>
            @endif
          </div>
          <h3 class="c-service-title">{{ $p->name }}</h3>
        </a>
      @empty
        <div class="text-muted">لا يوجد شركاء حالياً.</div>
      @endforelse
    </div>
  </div>
</section>
@endif

@if($show_faqs ?? true)
<section class="c-section" id="faqs">
  <div class="c-container">
    <h2 class="c-section-title">الأسئلة الشائعة</h2>
    <p class="c-section-sub">إجابات سريعة لأكثر الأسئلة تكرارًا.</p>
    <div class="c-steps">
      @forelse(($faqs ?? collect()) as $faq)
        <div class="c-step">
          <h3 class="c-step-title">{{ $faq->question }}</h3>
          <div class="c-step-text">{!! $faq->answer !!}</div>
        </div>
      @empty
        <div class="text-muted">لا توجد أسئلة شائعة حالياً.</div>
      @endforelse
    </div>
  </div>
</section>
@endif

@if($show_contact ?? true)
<section class="c-section alt" id="contact">
  <div class="c-container">
    <h2 class="c-section-title">اطلب عرض سعر لمشروع المقاولات الآن</h2>
    <p class="c-section-sub">عبّئ النموذج التالي وسيتواصل معك الفريق لمناقشة تفاصيل المشروع وتقديم عرض سعر مناسب.</p>
    <div class="c-contact-grid">
      <div class="c-form-card">
        <form action="{{ route('contact.home.store') }}" method="POST">
          @csrf
          <input type="hidden" name="subject" value="طلب عرض سعر لمشروع مقاولات">
          <div class="c-form-row">
            <div>
              <label class="c-form-label" for="c_name">الاسم الكامل</label>
              <input id="c_name" name="name" type="text" class="c-form-control" required>
            </div>
            <div>
              <label class="c-form-label" for="c_phone">رقم الجوال</label>
              <input id="c_phone" name="phone" type="tel" class="c-form-control" required>
            </div>
          </div>
          <div class="c-form-row" style="margin-top:.8rem;">
            <div>
              <label class="c-form-label" for="c_city">المدينة</label>
              <input id="c_city" name="city" type="text" class="c-form-control">
            </div>
            <div>
              <label class="c-form-label" for="c_type">نوع المشروع</label>
              <select id="c_type" name="project_type" class="c-form-select">
                <option value="">اختر نوع المشروع</option>
                <option value="سكني">سكني (فيلا، شقة، عمارة)</option>
                <option value="تجاري">تجاري (معرض، مكتب، مستودع)</option>
                <option value="ترميم">ترميم وتطوير مبنى قائم</option>
                <option value="تشطيبات">تشطيبات داخلية وخارجية</option>
              </select>
            </div>
          </div>
          <div style="margin-top:.8rem;">
            <label class="c-form-label" for="c_details">وصف مختصر للمشروع</label>
            <textarea id="c_details" name="message" class="c-form-textarea" placeholder="مثال: تنفيذ فيلا سكنية دورين على أرض مساحتها ... مع تشطيب كامل."></textarea>
          </div>
          <div style="margin-top:1rem; display:flex; flex-wrap:wrap; gap:.7rem; align-items:center; justify-content:space-between;">
            <button type="submit" class="c-cta-primary">
              <i class="fa-solid fa-paper-plane"></i>
              <span>إرسال الطلب</span>
            </button>
            <a href="{{ $whatsappLink ?? '#' }}" target="_blank" rel="noopener" class="c-cta-secondary" @if(empty($whatsappLink)) style="pointer-events:none; opacity:.5" @endif>
              <i class="fa-brands fa-whatsapp"></i>
              <span>أو تواصل مباشرة عبر واتساب</span>
            </a>
          </div>
        </form>
      </div>
      <aside>
        <div class="c-aside-list">
          <div class="c-aside-item">
            <div class="c-aside-icon"><i class="fa-solid fa-phone-volume"></i></div>
            <div class="c-aside-body">
              <strong>مناسب لطلبات التنفيذ الجديدة</strong>
              <span>إذا كان لديك مشروع جديد وتحتاج لتنفيذه من البداية حتى التسليم.</span>
            </div>
          </div>
          <div class="c-aside-item">
            <div class="c-aside-icon"><i class="fa-solid fa-house-chimney-crack"></i></div>
            <div class="c-aside-body">
              <strong>مناسب لأعمال الترميم والتطوير</strong>
              <span>رفع كفاءة المباني الحالية، تغيير التشطيبات، أو إعادة تقسيم المساحات.</span>
            </div>
          </div>
          <div class="c-aside-item">
            <div class="c-aside-icon"><i class="fa-solid fa-circle-info"></i></div>
            <div class="c-aside-body">
              <strong>استشارة أولية</strong>
              <span>يمكنك استخدام النموذج لطلب استشارة مبدئية حول آلية التنفيذ أو الخيارات المناسبة لمشروعك.</span>
            </div>
          </div>
        </div>
      </aside>
    </div>
  </div>
</section>
@endif
@endsection
