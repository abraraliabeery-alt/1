
@extends('layouts.app')

@section('head_extra')
<style>
  .contracting-page{ font-family:'Cairo',system-ui,-apple-system,Segoe UI,Roboto,sans-serif }
  .contracting-page h1{ font-weight:900; letter-spacing:-.2px; line-height:1.15 }
  .contracting-page h2,.contracting-page h3{ font-weight:900; letter-spacing:-.1px }
  .contracting-page .text-muted{ color: color-mix(in oklab, var(--fg), transparent 35%) }
  .contracting-page .section{ padding: clamp(22px, 2.8vw, 34px) 0 }
  .heroX{ background: var(--bg); border:1px solid color-mix(in oklab, var(--fg), transparent 90%); border-radius:22px; padding:24px; position:relative }
  .heroX:before{ content:""; position:absolute; inset:0; border-radius:22px; background: linear-gradient(90deg, color-mix(in oklab, var(--primary), transparent 86%), transparent 60%); pointer-events:none }
  .heroX .k{ position:relative }
  .heroMedia{ border-radius:18px; overflow:hidden; border:1px solid color-mix(in oklab, var(--fg), transparent 90%); background: color-mix(in oklab, var(--bg), var(--fg) 2%); background-size:cover; background-position:center }
  .heroMedia img{ width:100%; height:100%; display:block; object-fit:cover; aspect-ratio: 4 / 3 }
  .bg-shot{ border-radius:18px; overflow:hidden; position:relative; border:1px solid color-mix(in oklab, var(--fg), transparent 90%); min-height: 260px }
  .bg-shot:before{ content:""; position:absolute; inset:0; background: linear-gradient(180deg, color-mix(in oklab, #000, transparent 70%), color-mix(in oklab, #000, transparent 35%)); pointer-events:none }
  .bg-shot .inner{ position:relative; padding:18px }
  .bg-shot .kpi{ display:grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap:12px }
  @media (max-width:640px){ .bg-shot .kpi{ grid-template-columns: minmax(0, 1fr); } }
  .kpi .bx{ background: color-mix(in oklab, var(--bg), transparent 10%); border:1px solid color-mix(in oklab, var(--fg), transparent 88%); border-radius:16px; padding:12px }
  .kpi .n{ font-weight:900; font-size:1.35rem; letter-spacing:-.2px }
  .kpi .l{ color: color-mix(in oklab, var(--fg), transparent 25%); font-weight:900; font-size:.9rem }
  .trustline{ margin-top:14px; display:flex; flex-wrap:wrap; gap:10px; color: color-mix(in oklab, var(--fg), transparent 30%); font-weight:800 }
  .trustline span{ display:inline-flex; align-items:center; gap:.45rem; padding:.45rem .75rem; border-radius:999px; background: color-mix(in oklab, var(--bg), var(--fg) 5%); border:1px solid color-mix(in oklab, var(--fg), transparent 88%); font-size:.86rem }
  .cg{ display:grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap:14px }
  @media (max-width:1024px){ .cg{ grid-template-columns: repeat(2, minmax(0, 1fr)); } }
  @media (max-width:640px){ .cg{ grid-template-columns: minmax(0, 1fr); } }
  .cardx{ background: var(--bg); border:1px solid color-mix(in oklab, var(--fg), transparent 90%); border-radius:18px; padding:16px; box-shadow:none; transition: transform .15s ease, border-color .15s ease }
  .cardx:hover{ transform: translateY(-2px); border-color: color-mix(in oklab, var(--primary), transparent 55%) }
  .cardx .h{ margin:0 0 6px; font-weight:900; font-size:1.05rem }
  .cardx .t{ margin:0; color: color-mix(in oklab, var(--fg), transparent 35%); font-size:.9rem; line-height:1.75 }
  .badge{ display:inline-flex; align-items:center; gap:.35rem; padding:.25rem .55rem; border-radius:999px; font-size:.72rem; font-weight:900; background: color-mix(in oklab, var(--primary), #fff 45%); color:#000; border:1px solid color-mix(in oklab, var(--primary), transparent 60%) }
  .pill{ display:inline-flex; align-items:center; gap:.45rem; padding:.55rem .9rem; border-radius:999px; font-weight:900; text-decoration:none }
  .pill.p{ background: linear-gradient(135deg, var(--primary), color-mix(in oklab, var(--primary), #000 18%)); color:#000; border:1px solid color-mix(in oklab, var(--primary), transparent 40%) }
  .pill.g{ background: transparent; color: var(--fg); border:1px solid color-mix(in oklab, var(--fg), transparent 82%) }
  .quicknav{ margin-top:14px; display:flex; flex-wrap:wrap; gap:10px }
  .quicknav a{ font-size:.9rem }
  .ctaX{ border-radius:22px; overflow:hidden; border:1px solid color-mix(in oklab, var(--fg), transparent 90%); background-size:cover; background-position:center; position:relative }
  .ctaX:before{ content:""; position:absolute; inset:0; background: linear-gradient(90deg, color-mix(in oklab, #000, transparent 35%), color-mix(in oklab, #000, transparent 70%)); pointer-events:none }
  .ctaX .inner{ position:relative; padding: clamp(18px, 2.4vw, 28px) }
  .faq{ display:grid; gap:12px }
  .faq details{ background: var(--bg); border:1px solid color-mix(in oklab, var(--fg), transparent 90%); border-radius:18px; padding:14px 16px }
  .faq summary{ cursor:pointer; font-weight:900; list-style:none }
  .faq summary::-webkit-details-marker{ display:none }
  .faq summary .q{ display:flex; align-items:flex-start; justify-content:space-between; gap:10px }
  .faq summary .q i{ flex:0 0 auto; color: color-mix(in oklab, var(--primary), #000 10%) }
  .faq .a{ margin-top:10px; color: color-mix(in oklab, var(--fg), transparent 35%); line-height:1.85 }
  .infosteps{ margin-top:16px; display:grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap:14px; list-style:none; padding:0; align-items:stretch }
  .infostep{ position:relative; border-radius:20px; padding:14px 14px 16px; background: color-mix(in oklab, var(--bg), var(--fg) 2%); border:1px solid color-mix(in oklab, var(--fg), transparent 90%); overflow:hidden }
  .infostep:before{ content:""; position:absolute; inset:0; background: radial-gradient(900px 280px at 0% 0%, color-mix(in oklab, var(--primary), transparent 84%), transparent 55%); pointer-events:none }
  .infostep:after{ content:""; position:absolute; top:50%; left:-22px; width:44px; height:2px; background: linear-gradient(90deg, transparent, color-mix(in oklab, var(--primary), transparent 30%), transparent); transform: translateY(-50%); pointer-events:none }
  .infosteps .infostep:first-child:after{ display:none }
  .infostep .top{ position:relative; display:flex; align-items:center; justify-content:space-between; gap:10px; margin-bottom:10px }
  .infostep .num{ display:inline-grid; place-items:center; width:42px; height:42px; border-radius:16px; background: linear-gradient(135deg, var(--primary), color-mix(in oklab, var(--primary), #000 18%)); color:#000; border:1px solid color-mix(in oklab, var(--primary), transparent 40%); font-weight:900 }
  .infostep .ico{ width:42px; height:42px; display:grid; place-items:center; border-radius:16px; background: color-mix(in oklab, var(--bg), var(--fg) 4%); border:1px solid color-mix(in oklab, var(--fg), transparent 88%); color: color-mix(in oklab, var(--primary), #000 12%) }
  .infostep .ttl{ position:relative; margin:0 0 6px; font-weight:900; font-size:1.02rem; letter-spacing:-.1px }
  .infostep .desc{ position:relative; margin:0; color: color-mix(in oklab, var(--fg), transparent 35%); line-height:1.85; font-size:.92rem }
  @media (max-width:1024px){
    .infosteps{ grid-template-columns: repeat(2, minmax(0, 1fr)); }
    .infostep:after{ display:none }
  }
  @media (max-width:640px){
    .infosteps{ grid-template-columns: minmax(0, 1fr); }
  }
  .proj{ overflow:hidden; padding:0 }
  .proj .img{ aspect-ratio:4/3; background: color-mix(in oklab, var(--fg), transparent 92%) }
  .proj .img img{ width:100%; height:100%; object-fit:cover; display:block }
  .proj .b{ padding:12px 13px 14px }
  .proj .m{ font-size:.85rem; color: color-mix(in oklab, var(--fg), transparent 40%) }
  .ts{ display:flex; gap:14px; overflow:auto; padding-bottom:8px; scroll-snap-type:x mandatory }
  .ts::-webkit-scrollbar{ height:8px }
  .ts::-webkit-scrollbar-thumb{ background: color-mix(in oklab, var(--fg), transparent 80%); border-radius:999px }
  .tcard{ min-width: 340px; scroll-snap-align:start }
  @media (max-width:640px){ .tcard{ min-width: 85vw } }
  #process, #services, #projects, #testimonials, #faq, #contact{ scroll-margin-top: 92px }
  .pb{ padding-bottom:96px }
</style>
@endsection

@section('content')
  @php
    $services = $services ?? collect();
    $projects = $projects ?? collect();
    $testimonials = $testimonials ?? collect();
    $contractingImage = 'https://i0.wp.com/samaacontracting.com/wp-content/uploads/2025/08/%D8%B4%D8%B1%D9%83%D8%A7%D8%AA-%D9%85%D9%82%D8%A7%D9%88%D9%84%D8%A7%D8%AA-%D8%A8%D8%A7%D9%84%D8%B1%D9%8A%D8%A7%D8%B6.webp?fit=705%2C463&ssl=1';
    $services = collect($services)->filter(function ($s) {
      return (int) data_get($s, 'type', 2) === 2;
    })->values();
  @endphp

  <main class="pb contracting-page">
    <section class="section" id="hero">
      <div class="container">
        <div class="heroX">
          <div class="grid-2 k" style="align-items:center">
            <div>
            <span class="eyebrow">خدمات المقاولات</span>
            <h1>نبني وننفّذ ونُسلّم <span class="hl">بجودة</span> وبخطة واضحة.</h1>
            <p class="text-muted" style="max-width:70ch">تنفيذ مشاريع البناء والتشطيب والصيانة بإشراف ومتابعة، مع التزام بالمواعيد وشفافية في كل مرحلة حتى التسليم.</p>
            <div class="trustline" aria-label="مميزات">
              <span><i class="bi bi-calendar2-check" aria-hidden="true"></i> جدول مراحل</span>
              <span><i class="bi bi-clipboard-check" aria-hidden="true"></i> استلامات</span>
              <span><i class="bi bi-shield-check" aria-hidden="true"></i> جودة وسلامة</span>
            </div>
            </div>
            <div class="heroMedia" aria-hidden="true">
              <img src="{{ $contractingImage }}" alt="" loading="eager" onerror="this.style.opacity=.35" />
            </div>
          </div>
        </div>

        <nav class="quicknav" aria-label="روابط سريعة">
          <a class="pill p" href="#services"><i class="bi bi-tools" aria-hidden="true"></i> الخدمات</a>
          <a class="pill g" href="#projects"><i class="bi bi-building" aria-hidden="true"></i> المشاريع</a>
          <a class="pill g" href="#process"><i class="bi bi-diagram-3" aria-hidden="true"></i> آلية العمل</a>
          <a class="pill g" href="#faq"><i class="bi bi-question-circle" aria-hidden="true"></i> الأسئلة</a>
          <a class="pill g" href="#contact"><i class="bi bi-send" aria-hidden="true"></i> اطلب عرض</a>
        </nav>
      </div>
    </section>

    <section class="section alt" id="sectors">
      <div class="container">
        <div class="grid-2" style="align-items:stretch">
          <div>
            <h2 class="title-deco">قطاعات نخدمها</h2>
            <p class="text-muted">خبرة تنفيذية تغطي نطاق واسع من أعمال المقاولات، مع مرونة حسب طبيعة المشروع.</p>
            <div class="cg" style="margin-top:14px">
              <div class="cardx">
                <div class="h">سكني</div>
                <div class="t">فلل، شقق، ملاحق، تشطيبات كاملة أو جزئية.</div>
              </div>
              <div class="cardx">
                <div class="h">تجاري</div>
                <div class="t">محلات، مكاتب، واجهات، تجهيزات داخلية.</div>
              </div>
              <div class="cardx">
                <div class="h">صيانة وترميم</div>
                <div class="t">إصلاحات، معالجة رطوبة، تحديثات وتشطيبات.</div>
              </div>
            </div>
          </div>
          <div class="bg-shot" style="background-image:url('{{ $contractingImage }}'); background-size:cover; background-position:center">
            <div class="inner">
              <div style="font-weight:900; font-size:1.1rem; margin-bottom:10px">مؤشرات سريعة</div>
              <div class="kpi" aria-label="مؤشرات">
                <div class="bx">
                  <div class="n">+10</div>
                  <div class="l">سنوات خبرة</div>
                </div>
                <div class="bx">
                  <div class="n">+50</div>
                  <div class="l">مشروع مُنجز</div>
                </div>
                <div class="bx">
                  <div class="n">100%</div>
                  <div class="l">متابعة مراحل</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section" id="commitment">
      <div class="container">
        <h2 class="title-deco">التزامنا في الموقع</h2>
        <p class="text-muted">معايير واضحة لضمان جودة التنفيذ وسلامة العمل.</p>
        <div class="cg">
          <div class="cardx">
            <div class="h"><i class="bi bi-check2-circle" aria-hidden="true"></i> جودة التنفيذ</div>
            <div class="t">فحص بنود الأعمال والاستلام المرحلي قبل الانتقال للمرحلة التالية.</div>
          </div>
          <div class="cardx">
            <div class="h"><i class="bi bi-shield" aria-hidden="true"></i> سلامة</div>
            <div class="t">التزام بإجراءات السلامة بالموقع وتقليل المخاطر قدر الإمكان.</div>
          </div>
          <div class="cardx">
            <div class="h"><i class="bi bi-receipt" aria-hidden="true"></i> شفافية</div>
            <div class="t">بنود واضحة وجدول مراحل وتحديثات دورية حسب تقدم العمل.</div>
          </div>
        </div>
      </div>
    </section>

    <section class="section alt" id="process">
      <div class="container">
        <h2 class="title-deco">كيف نشتغل؟</h2>
        <p class="text-muted">مسار عمل واضح من المعاينة حتى التسليم.</p>
        <ol class="infosteps" aria-label="انفوجرافيك خطوات العمل">
          <li class="infostep">
            <div class="top">
              <span class="num" aria-hidden="true">1</span>
              <span class="ico" aria-hidden="true"><i class="bi bi-geo-alt"></i></span>
            </div>
            <h3 class="ttl">معاينة واحتياج</h3>
            <p class="desc">زيارة الموقع/مراجعة المخططات وتحديد نطاق العمل والمتطلبات بدقة.</p>
          </li>
          <li class="infostep">
            <div class="top">
              <span class="num" aria-hidden="true">2</span>
              <span class="ico" aria-hidden="true"><i class="bi bi-file-earmark-text"></i></span>
            </div>
            <h3 class="ttl">عرض سعر وخطة</h3>
            <p class="desc">بنود واضحة + جدول مراحل (مواد/تنفيذ/استلامات) قبل البدء.</p>
          </li>
          <li class="infostep">
            <div class="top">
              <span class="num" aria-hidden="true">3</span>
              <span class="ico" aria-hidden="true"><i class="bi bi-hammer"></i></span>
            </div>
            <h3 class="ttl">تنفيذ ومتابعة</h3>
            <p class="desc">تنفيذ منظم على مراحل مع متابعة الجودة والسلامة وتحديثات دورية.</p>
          </li>
          <li class="infostep">
            <div class="top">
              <span class="num" aria-hidden="true">4</span>
              <span class="ico" aria-hidden="true"><i class="bi bi-clipboard-check"></i></span>
            </div>
            <h3 class="ttl">استلام وتسليم</h3>
            <p class="desc">استلامات مرحلية ونهائية ثم تسليم المشروع وفق البنود المتفق عليها.</p>
          </li>
        </ol>
      </div>
    </section>

    <section class="section" id="services">
      <div class="container">
        <h2 class="title-deco">خدمات المقاولات</h2>
        <p class="text-muted">اختر الخدمة المناسبة وتواصل معنا من خلال نموذج الطلب في أسفل الصفحة.</p>

        @if($services->count())
          <div class="cg">
            @foreach($services as $service)
              <article class="cardx">
                <div style="display:flex; gap:10px; align-items:flex-start">
                  <div style="width:46px; height:46px; border-radius:14px; display:grid; place-items:center; background: color-mix(in oklab, var(--primary), #fff 60%); color:#000; border:1px solid color-mix(in oklab, var(--primary), transparent 55%); flex:0 0 auto">
                    @if(!empty($service->icon))
                      <i class="{{ $service->icon }}" aria-hidden="true"></i>
                    @else
                      <i class="bi bi-tools" aria-hidden="true"></i>
                    @endif
                  </div>
                  <div style="flex:1">
                    <h3 class="h">{{ $service->title }}</h3>
                    @if(!empty($service->excerpt))
                      <p class="t">{{ $service->excerpt }}</p>
                    @else
                      <p class="t">اختر هذه الخدمة وسنجهّز لك عرض سعر وخطة تنفيذ مناسبة.</p>
                    @endif
                  </div>
                </div>
              </article>
            @endforeach
          </div>
        @else
          <div class="alert">لا توجد خدمات مقاولات مضافة بعد.</div>
        @endif
      </div>
    </section>

    <section class="section alt" id="projects">
      <div class="container">
        <h2 class="title-deco">مشاريعنا</h2>
        <p class="text-muted">نماذج من أعمالنا المنجزة.</p>

        @if($projects->count())
          <div class="cg">
            @foreach($projects as $p)
              <article class="cardx proj">
                <div class="img">
                  @if(!empty($p->cover_image_url))
                    <img src="{{ $p->cover_image_url }}" alt="{{ $p->title }}" loading="lazy" onerror="this.style.opacity=.35" />
                  @else
                    <img src="{{ $contractingImage }}" alt="{{ $p->title }}" loading="lazy" onerror="this.style.opacity=.35" />
                  @endif
                </div>
                <div class="b">
                  <div class="h">{{ $p->title }}</div>
                  <div class="m">{{ $p->city ?: '—' }} @if($p->category) • {{ $p->category }} @endif</div>
                </div>
              </article>
            @endforeach
          </div>
        @else
          <div class="alert">لا توجد مشاريع مضافة بعد.</div>
        @endif
      </div>
    </section>

    <section class="section alt" id="faq">
      <div class="container">
        <h2 class="title-deco">أسئلة شائعة</h2>
        <p class="text-muted">إجابات سريعة قبل بدء المشروع.</p>
        <div class="faq" role="list">
          <details role="listitem">
            <summary>
              <div class="q">
                <span>هل تقدمون تسليم مفتاح؟</span>
                <i class="bi bi-chevron-down" aria-hidden="true"></i>
              </div>
            </summary>
            <div class="a">نعم حسب نطاق المشروع. نحدد المتطلبات ثم نبني عرض سعر يتضمن البنود والمراحل حتى التسليم.</div>
          </details>
          <details role="listitem">
            <summary>
              <div class="q">
                <span>كيف يتم تحديد السعر؟</span>
                <i class="bi bi-chevron-down" aria-hidden="true"></i>
              </div>
            </summary>
            <div class="a">يعتمد على المساحة، مستوى التشطيب، المواد، ومدى جاهزية الموقع. نرسل تسعيرًا واضحًا ببنود محددة.</div>
          </details>
          <details role="listitem">
            <summary>
              <div class="q">
                <span>هل يوجد إشراف ومتابعة؟</span>
                <i class="bi bi-chevron-down" aria-hidden="true"></i>
              </div>
            </summary>
            <div class="a">يوجد متابعة واستلامات مرحلية لضمان جودة كل مرحلة قبل الانتقال للمرحلة التالية.</div>
          </details>
          <details role="listitem">
            <summary>
              <div class="q">
                <span>كم مدة التنفيذ عادة؟</span>
                <i class="bi bi-chevron-down" aria-hidden="true"></i>
              </div>
            </summary>
            <div class="a">المدة تختلف حسب حجم المشروع ونوع التشطيب. بعد المعاينة نشاركك جدول مراحل واضح بزمن تقديري لكل مرحلة.</div>
          </details>
        </div>
      </div>
    </section>

    <section class="section" id="cta">
      <div class="container">
        <div class="ctaX" style="background-image:url('{{ $contractingImage }}')">
          <div class="inner">
            <div class="grid-2" style="align-items:center">
              <div>
                <div class="badge" style="margin-bottom:10px"><i class="bi bi-lightning" aria-hidden="true"></i> تواصل سريع</div>
                <h2 style="margin:0 0 8px">جاهز تبدأ مشروعك؟</h2>
                <p class="text-muted" style="margin:0; max-width:70ch">أرسل تفاصيل مشروعك وسنعود لك بعرض سعر وخطة تنفيذ مبدئية.</p>
              </div>
              <div style="display:flex; gap:10px; justify-content:flex-end; flex-wrap:wrap">
                <a class="pill p" href="#contact"><i class="bi bi-send" aria-hidden="true"></i> ارسل الطلب</a>
                <a class="pill g" href="https://api.whatsapp.com/send?phone={{ urlencode(config('app.whatsapp_number', '966000000000')) }}" target="_blank" rel="noopener"><i class="bi bi-whatsapp" aria-hidden="true"></i> واتساب</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section" id="contact">
      <div class="container">
        <h2 class="title-deco">اطلب عرض سعر</h2>
        <p class="text-muted">اكتب تفاصيل مشروعك وسنتواصل معك قريبًا.</p>

        <div class="grid-2" style="align-items:start">
          <div class="form-card">
            <form action="{{ route('contact.home.store') }}" method="POST" style="display:grid; gap:.8rem">
              @csrf
              <input type="hidden" name="type" value="contracting" />
              <div class="form-grid">
                <div>
                  <label>الاسم</label>
                  <input name="name" value="{{ old('name') }}" />
                </div>
                <div>
                  <label>رقم الجوال</label>
                  <input name="phone" value="{{ old('phone') }}" />
                </div>
                <div class="full">
                  <label>البريد الإلكتروني</label>
                  <input name="email" type="email" value="{{ old('email') }}" />
                </div>
                <div class="full">
                  <label>تفاصيل الطلب</label>
                  <textarea id="contracting_message" name="message" required rows="5">{{ old('message') }}</textarea>
                </div>
              </div>
              <button type="submit" class="btn btn-primary">إرسال الطلب</button>
            </form>
          </div>

          <div class="aside">
            <div class="info-item">
              <i class="bi bi-whatsapp" aria-hidden="true"></i>
              <div>
                <div style="font-weight:900">واتساب</div>
                <div class="text-muted" style="font-size:13px">تواصل عبر زر الواتساب العائم</div>
              </div>
            </div>
            <div class="info-item">
              <i class="bi bi-clipboard-check" aria-hidden="true"></i>
              <div>
                <div style="font-weight:900">استلامات مرحلية</div>
                <div class="text-muted" style="font-size:13px">تأكيد جودة كل مرحلة قبل الانتقال</div>
              </div>
            </div>
            <div class="info-item">
              <i class="bi bi-shield-check" aria-hidden="true"></i>
              <div>
                <div style="font-weight:900">سلامة وجودة</div>
                <div class="text-muted" style="font-size:13px">التزام بمعايير السلامة بالموقع</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

@endsection
