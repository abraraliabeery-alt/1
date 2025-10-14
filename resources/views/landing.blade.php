@extends('layouts.app')

@section('head_extra')
@verbatim
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "توب ليفل",
  "url": "",
  "logo": "/assets/top.png",
  "description": "شركة تقنية متخصصة في أنظمة المراقبة والأمان والأنظمة الذكية (IoT) والشبكات ونقاط الوصول والاتصالات IP/PBX والخوادم وأجهزة البصمة",
  "sameAs": []
}
</script>
@endverbatim
@endsection

@section('content')
  <!-- Scroll Progress Bar -->
  <div class="scroll-progress" aria-hidden="true"><span></span></div>
  

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
    <!-- 1. Hero (Redesigned) -->
    <section id="hero" class="section hero">
      <div class="container grid-2">
        <div class="hero-copy">
          <span class="eyebrow">حلول الأمان والأنظمة الذكية</span>
          <h1>حلول ذكية وأمان شامل لمؤسستك ومنزلك</h1>
          <p>كاميرات، إنذار، شبكات Wi‑Fi، سنترالات IP/PBX، وأنظمة منزل/مكتب ذكي — تكامل موثوق وسلس.</p>
          <ul>
            <li>سرعة تنفيذ</li>
            <li>دعم 24/7</li>
            <li>تصميم قبل التنفيذ</li>
          </ul>
          <div class="cta">
            <a class="btn btn-primary" href="#contact">احجز استشارة</a>
            <a class="btn btn-outline" href="#services">تعرف على خدماتنا</a>
          </div>
        </div>
        <div class="hero-media" aria-hidden="true">
          <div class="surface-box">
            <img class="hero-media-img" src="/assets/hero-smart-home.jpg" alt="منزل ذكي — لوحة تحكم وأنظمة متصلة" />
          </div>
        </div>
      </div>
    </section>

    <!-- Featured Projects -->
    <section id="featured-projects" class="section alt fade-in">
      <div class="container">
        <h2>أعمالنا السابقة</h2>
        <div class="gallery">
          @forelse(($projects ?? []) as $proj)
            <article class="tile">
              <a href="{{ route('projects.show', $proj->slug) }}">
                @if($proj->cover_image)
                  <img src="{{ $proj->cover_image }}" alt="{{ $proj->title }}" />
                @else
                  <div class="tile-fallback"></div>
                @endif
                <div class="tile-caption">
                  <strong>{{ $proj->title }}</strong>
                  <span>{{ $proj->city ?? $proj->category }}</span>
                </div>
              </a>
            </article>
          @empty
            <p class="text-center text-muted">سيتم إضافة المشاريع قريبًا.</p>
          @endforelse
        </div>
        <div class="centered-actions">
          <a class="btn btn-outline" href="{{ route('projects.index') }}">شاهد كل المشاريع</a>
        </div>
      </div>
    </section>
  <!-- 2. Trust / Logos -->
    <section id="trust" class="section trust">
      <div class="container">
        <p class="eyebrow">موثوقون من شركاء التقنية</p>
        <div class="logos">
          <span>Alexa</span>
          <span>Google</span>
          <span>Apple</span>
          <span>Matter</span>
          <span>Zigbee</span>
          <span>KNX</span>
        </div>
      </div>
    </section>

    <!-- 3. Value Proposition -->
    <section id="value" class="section value fade-in">
      <div class="container grid-3">
        <div class="card">
          <h3>حلول أمان شاملة</h3>
          <p>كاميرات مراقبة عالية الدقة، أنظمة تسجيل وتخزين، وإنذارات وكواشف لرفع مستوى الأمان.</p>
        </div>
        <div class="card">
          <h3>أنظمة ذكية متكاملة</h3>
          <p>لوحات تحكم، أقفال ومفاتيح وإضاءة ذكية، تكييف وستائر وصوت وإنتركم بتكامل سلس.</p>
        </div>
        <div class="card">
          <h3>شبكات واتصالات موثوقة</h3>
          <p>تصميم شبكات Wi‑Fi ونقاط وصول وإدارة مركزية، مع سنترالات IP/PBX لربط الفروع.</p>
        </div>
      </div>
    </section>

    <!-- 4. Services -->
    <section id="services" class="section services fade-in">
      <div class="container">
        <h2>خدماتنا</h2>
        <div class="grid-3">
          <div class="feature">
            <div class="icon" aria-hidden="true" style="width:28px;height:28px;display:inline-block;vertical-align:middle;margin-inline-end:6px">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5"/><path d="M7 12h10M12 7v10" stroke="currentColor" stroke-width="1.5"/></svg>
            </div>
            <h4 style="display:inline">أنظمة المراقبة</h4>
            <p>كاميرات متحركة وعالية الدقة مع تسجيل وتخزين محلي أو سحابي لمستوى أمان أعلى.</p>
            <a href="#contact" class="btn btn-link">اطلب استشارة</a>
          </div>
          <div class="feature">
            <div class="icon" aria-hidden="true" style="width:28px;height:28px;display:inline-block;vertical-align:middle;margin-inline-end:6px">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="7" width="18" height="10" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M7 12h10" stroke="currentColor" stroke-width="1.5"/></svg>
            </div>
            <h4 style="display:inline">مكافحة السرقة</h4>
            <p>حساسات حركة وصوت/صورة وأنظمة إنذار متصلة بالتطبيقات والإنترنت للتنبيه الفوري.</p>
            <a href="#contact" class="btn btn-link">اطلب استشارة</a>
          </div>
          <div class="feature">
            <div class="icon" aria-hidden="true" style="width:28px;height:28px;display:inline-block;vertical-align:middle;margin-inline-end:6px">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 3l8 4v6c0 4.418-3.582 8-8 8s-8-3.582-8-8V7l8-4z" stroke="currentColor" stroke-width="1.5"/></svg>
            </div>
            <h4 style="display:inline">الأنظمة الذكية (IoT)</h4>
            <p>لوحات تحكم وأقفال ومفاتيح وإضاءة ذكية، تكييف وستائر وصوت وإنتركم بتكامل سلس.</p>
            <a href="#contact" class="btn btn-link">اطلب استشارة</a>
          </div>
          <div class="feature">
            <div class="icon" aria-hidden="true" style="width:28px;height:28px;display:inline-block;vertical-align:middle;margin-inline-end:6px">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 10h16M6 6h12M8 14h8M10 18h4" stroke="currentColor" stroke-width="1.5"/></svg>
            </div>
            <h4 style="display:inline">شبكات Wi‑Fi ونقاط الوصول</h4>
            <p>تصميم الشبكات، توزيع التغطية، وإدارة مركزية للقنوات والطاقة لضمان اتصال مستقر.</p>
            <a href="#contact" class="btn btn-link">اطلب استشارة</a>
          </div>
          <div class="feature">
            <div class="icon" aria-hidden="true" style="width:28px;height:28px;display:inline-block;vertical-align:middle;margin-inline-end:6px">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="4" y="4" width="16" height="16" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M8 8h8v8H8z" stroke="currentColor" stroke-width="1.5"/></svg>
            </div>
            <h4 style="display:inline">سنترالات IP/PBX</h4>
            <p>اتصالات داخلية متقدمة وربط للفروع عالميًا لتقليل التكاليف وتحسين التواصل.</p>
            <a href="#contact" class="btn btn-link">اطلب استشارة</a>
          </div>
          <div class="feature">
            <div class="icon" aria-hidden="true" style="width:28px;height:28px;display:inline-block;vertical-align:middle;margin-inline-end:6px">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7 12a5 5 0 1010 0 5 5 0 10-10 0z" stroke="currentColor" stroke-width="1.5"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3" stroke="currentColor" stroke-width="1.5"/></svg>
            </div>
            <h4 style="display:inline">أجهزة البصمة والحضور</h4>
            <p>تحكم بالدخول وإدارة حضور وانصراف بدقة مع تكامل مع أنظمة الأمن والمراقبة.</p>
            <a href="#contact" class="btn btn-link">اطلب استشارة</a>
          </div>
        </div>
      </div>
    </section>

    <!-- 5. Smart Home Solutions -->
    <section id="home-solutions" class="section alt fade-in">
      <div class="container grid-2">
        <div>
          <h2>حلول المنزل الذكي</h2>
          <ul class="checked">
            <li>لوحات تحكم ذكية ومفاتيح إنارة وموسيقى متعددة الغرف.</li>
            <li>أقفال ذكية وستائر، وأزرار طوارئ ووحدات تحكم عن بُعد.</li>
            <li>تكامل Alexa/Google وMatter/Zigbee لتحكم محلي وسحابي مرن.</li>
          </ul>
        </div>
        <div class="illustration small" aria-hidden="true">
          <img src="/assets/smart-home.jpg" alt="حلول المنزل الذكي" />
        </div>
      </div>
    </section>

    <!-- 6. Smart Office Solutions -->
    <section id="office-solutions" class="section fade-in">
      <div class="container grid-2">
        <div class="illustration small" aria-hidden="true">
          <img src="/assets/smart-office.jpg" alt="حلول المكتب الذكي" />
        </div>
        <div>
          <h2>حلول المكتب الذكي</h2>
          <ul class="checked">
            <li>سنترالات IP/PBX واتصالات داخلية تربط الفروع عالميًا.</li>
            <li>شبكات Wi‑Fi مُدارة مركزيًا مع توزيع تغطية احترافي.</li>
            <li>أنظمة حضور وبصمة وإدارة وصول متكاملة مع الأمن.</li>
          </ul>
          <a href="#contact" class="btn btn-outline">اطلب استشارة لمكتبك</a>
        </div>
      </div>
    </section>

    <!-- 6b. IP/PBX Telephony Solutions -->
    @if(!empty($show_ip_pbx))
    <section id="ip-pbx" class="section alt fade-in">
      <div class="container grid-2">
        <div>
          <h2>حلول الاتصالات والسنترالات (IP/PBX)</h2>
          <p>أنظمة اتصال داخلية متقدمة لربط الفروع أينما كانت مع إدارة مكالمات احترافية وتقليل التكاليف.</p>
          <ul class="checked">
            <li>تصميم وتنفيذ سنترالات رقمية مع ربط بالحواسيب والإنترنت.</li>
            <li>شبكة اتصالات داخلية سلسة ومرنة تدعم نمو المنشأة.</li>
            <li>تكامل مع أنظمة المكتب الذكي وباقي البنية التحتية.</li>
          </ul>
          <a href="#contact" class="btn btn-primary">اطلب عرض السنترال</a>
        </div>
        <div class="illustration small" aria-hidden="true">
          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQskdtMG9GzLaiiLfefolf3T30vaGJgW1vClg&s" alt="حلول الاتصالات والسنترالات" />
        </div>
      </div>
    </section>
    @endif
    <!-- 6c. Servers & Hosting -->
    @if(!empty($show_servers))
    <section id="servers" class="section fade-in">
      <div class="container grid-2">
        <div class="illustration small" aria-hidden="true">
          <img src="https://www.sifytechnologies.com/wp-content/uploads/2022/06/server_hosting_blog_fod-1.jpeg" alt="خوادم واستضافة مواقع" />
        </div>
        <div>
          <h2>الخوادم واستضافة المواقع</h2>
          <p>إعداد خوادم احترافية لاستضافة المواقع والخدمات مع استجابة عالية وحماية فورية.</p>
          <ul class="checked">
            <li>تهيئة وحماية لحظية ضد البرمجيات الخبيثة.</li>
            <li>إعداد بنية الاستضافة ونسخ احتياطي ومراقبة.</li>
            <li>تكامل مع الأنظمة الذكية والتطبيقات المؤسسية.</li>
          </ul>
          <a href="#contact" class="btn btn-outline">استشارة استضافة</a>
        </div>
      </div>
    </section>
    @endif

    <!-- 6d. Fingerprint & Attendance -->
    @if(!empty($show_fingerprint))
    <section id="fingerprint" class="section alt fade-in">
      <div class="container grid-2">
        <div>
          <h2>أنظمة البصمة والحضور</h2>
          <p>حلول دقيقة للتحكم بالدخول وإدارة الحضور والانصراف مع تكامل كامل مع أنظمة الأمن.</p>
          <ul class="checked">
            <li>تسجل حضور وانصراف الموظفين بدقة عالية.</li>
            <li>إدارة وصول للمناطق المصرح بها فقط.</li>
            <li>تركيب وصيانة وتحديثات مستمرة ولدعم فني احترافي.</li>
          </ul>
          <a href="#contact" class="btn btn-primary">اطلب نظام بصمة</a>
        </div>
        <div>
          <div class="illustration small" aria-hidden="true">
            <img src="https://www.cctv-cam.com/media/service_details_images/%D8%A7%D8%AC%D9%87%D8%B2%D8%A9_%D8%A7%D9%84%D8%A8%D8%B5%D9%85%D8%A9_HIegn9e.jpg" alt="أجهزة البصمة والحضور" />
          </div>
        </div>
      </div>
    </section>

    @endif

    <!-- 7b. Case Studies -->
    <section id="case-studies" class="section alt fade-in">
      <div class="container">
        <h2>دراسات حالة</h2>
        <div class="grid-3 cases">
          <article class="case">
            <h4>فيلا حديثة</h4>
            <p>إنشاء وتشطيب متكامل مع منظومة ذكية — تسليم على الوقت وتقليل استهلاك الطاقة 22%.</p>
          </article>
          <article class="case">
            <h4>مكتب شركة تقنية</h4>
            <p>تهيئة بنية تحتية وMEP مع مكتب ذكي — رفع كفاءة الاستخدام 35% وتقليل الأعطال.</p>
          </article>
          <article class="case">
            <h4>متجر تجزئة</h4>
            <p>تشطيبات واجهات وإضاءة عرض + تكامل أمني — تجربة شراء محسّنة وتكاليف أقل.</p>
          </article>
        </div>
      </div>
    </section>

    <!-- 8. Process -->
    <section id="process" class="section fade-in">
      <div class="container">
        <h2>رحلة التنفيذ</h2>
        <ol class="steps">
          <li>استشارة وتحليل احتياجات</li>
          <li>تصميم الحل والمخططات</li>
          <li>توريد وتركيب واختبار</li>
          <li>تسليم وتدريب وضمان</li>
        </ol>
      </div>
    </section>

    <!-- 9. Tech Stack -->
    <section id="tech" class="section alt fade-in">
      <div class="container grid-3">
        <div class="card">
          <h3>البروتوكولات</h3>
          <p>Matter, Zigbee, Z-Wave, Thread, KNX</p>
        </div>
        <div class="card">
          <h3>التكاملات</h3>
          <p>Alexa, Google, Apple Home, MQTT, Modbus</p>
        </div>
        <div class="card">
          <h3>الشبكات</h3>
          <p>VLAN, Wi‑Fi Mesh, PoE, أمان متعدد الطبقات</p>
        </div>
      </div>
    </section>

    <!-- 10. Pricing -->
    <section id="pricing" class="section fade-in">
      <div class="container">
        <h2>باقات مرنة</h2>
        <div class="grid-3 pricing">
          <div class="price-card">
            <h4>Basic</h4>
            <p class="price">حسب المشروع</p>
            <ul>
              <li>إنارة ذكية أساسية</li>
              <li>منطقة مناخ واحدة</li>
              <li>تكامل صوتي</li>
            </ul>
            <a href="#contact" class="btn btn-outline">اطلب عرض</a>
          </div>
          <div class="price-card featured">
            <h4>Pro</h4>
            <p class="price">حسب المشروع</p>
            <ul>
              <li>إنارة متعددة المناطق</li>
              <li>ستائر وأقفال</li>
              <li>صوت متعدد الغرف</li>
            </ul>
            <a href="#contact" class="btn btn-primary">اطلب عرض</a>
          </div>
          <div class="price-card">
            <h4>Enterprise</h4>
            <p class="price">حسب المشروع</p>
            <ul>
              <li>غرف اجتماعات ذكية</li>
              <li>تكامل KNX/BMS</li>
              <li>تقارير إدارة طاقة</li>
            </ul>
            <a href="#contact" class="btn btn-outline">اطلب عرض</a>
          </div>
        </div>
      </div>
    </section>

    <!-- 11. Testimonials -->
    @if(!empty($show_testimonials))
    <section id="testimonials" class="section alt fade-in">
      <div class="container">
        <h2>آراء العملاء</h2>
        <div class="gallery">
          @forelse(($testimonials ?? []) as $ti)
            <article class="gallery-item" style="background:transparent; border:none; box-shadow:none">
              @if(!empty($ti->image_path))
                <div style="position:relative; width:100%; aspect-ratio: 4 / 3; overflow:hidden; border-radius:10px">
                  <img src="{{ $ti->image_path }}" alt="{{ $ti->title }}" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; display:block;" />
                </div>
              @endif
            </article>
          @empty
            <p class="text-center text-muted">أضف صور محادثات لآراء العملاء من الألبوم مع التصنيف "testimonials".</p>
          @endforelse
        </div>
        <div class="centered-actions">
          <a class="btn btn-outline" href="{{ route('gallery.index') }}">إدارة الألبوم</a>
        </div>
      </div>
    </section>
    @endif
    <!-- 12. Gallery (dynamic) -->
    @if(!empty($show_portfolio))
    <section id="portfolio" class="section fade-in">
      <div class="container">
        <h2>لمحات من أعمالنا</h2>
        <div class="gallery">
          @forelse(($gallery ?? []) as $gi)
            <article class="gallery-item" style="background:transparent; border:none; box-shadow:none">
              @if(!empty($gi->image_path))
                <a href="{{ $gi->image_path }}" data-lightbox="gallery" style="display:block">      <div style="position:relative; width:100%; aspect-ratio: 4 / 3; overflow:hidden; border-radius:10px">      <img src="{{ $gi->image_path }}" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; display:block;" />      </div>    </a>
              @else
              
              @endif
            </article>
          @empty
            <p class="text-center text-muted">سيتم إضافة صور للأعمال قريبًا.</p>
          @endforelse
        </div>
        <div class="centered-actions">
          <a class="btn btn-outline" href="{{ route('gallery.index') }}">عرض كل الصور</a>
        </div>
      </div>
    </section>
    @endif
    

    <!-- 14. FAQs -->
    @if(!empty($show_faqs))
    <section id="faqs" class="section alt fade-in">
      <div class="container">
        <h2>الأسئلة الشائعة</h2>
        <details>
          <summary>هل تعمل الحلول بدون إنترنت؟</summary>
          <p>نعم، نفضل التحكم المحلي حيثما أمكن لضمان السرعة والاعتمادية.</p>
        </details>
        <details>
          <summary>هل يمكن الترقية مستقبلاً؟</summary>
          <p>نعم، نعتمد معايير مفتوحة قابلة للتوسع مثل Matter وZigbee.</p>
        </details>
      </div>
    </section>
    @endif
    <!-- 14. About -->
    <section id="about" class="section fade-in">
      <div class="container grid-2">
        <div>
          <h2>عن توب ليفل</h2>
          <p>شركة مقاولات معمارية متكاملة تقدّم الإنشاءات والتشطيبات وMEP بإدارة مشروع احترافية، ونكمل ذلك بحلول المنازل والمكاتب الذكية لتسليم تجربة حديثة متناسقة.</p>
        </div>
        <div class="stats">
          <div class="stat"><strong>+120</strong><span>مشروع</span></div>
          <div class="stat"><strong>+6</strong><span>سنوات خبرة</span></div>
          <div class="stat"><strong>24/7</strong><span>دعم</span></div>
        </div>
      </div>
    </section>

    <!-- 15. Contact CTA -->
    <section id="contact" class="section contact fade-in">
      <div class="container grid-2">
        <div>
          <h2>تواصل معنا</h2>
          <p>لنبدأ في مشروعك اليوم. املأ النموذج وسنتواصل خلال 24 ساعة.</p>
          <form id="contact-form" action="{{ route('contact.home.store') }}" method="POST" novalidate>
            @csrf
            <div class="form-grid">
              <label>
                الاسم الكامل
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="الاسم" class="@error('name') is-invalid @enderror" />
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </label>
              <label>
                رقم الجوال
                <input type="tel" name="phone" value="{{ old('phone') }}" required placeholder="05XXXXXXXX" class="@error('phone') is-invalid @enderror" />
                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </label>
              <label class="full">
                البريد الإلكتروني (اختياري)
                <input type="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" class="@error('email') is-invalid @enderror" />
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </label>
              <label class="full">
                نوع المشروع
                <select name="type" required class="@error('type') is-invalid @enderror">
                  <option value="">اختر نوع المشروع</option>
                  <option {{ old('type')==='منزل ذكي' ? 'selected' : '' }}>منزل ذكي</option>
                  <option {{ old('type')==='مكتب ذكي' ? 'selected' : '' }}>مكتب ذكي</option>
                  <option {{ old('type')==='أخرى' ? 'selected' : '' }}>أخرى</option>
                </select>
                @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </label>
              <label class="full">
                وصف مختصر
                <textarea name="message" rows="4" placeholder="اخبرنا عن احتياجك..." class="@error('message') is-invalid @enderror">{{ old('message') }}</textarea>
                @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </label>
            </div>
            <button type="submit" class="btn btn-primary">إرسال الطلب</button>
            @php($hasSettings = \Illuminate\Support\Facades\Schema::hasTable('settings'))
            @php($wa = $hasSettings ? \App\Models\Setting::getValue('whatsapp_number') : null)
            <p class="form-note">أو تواصل مباشرة عبر واتساب: 
              @if($wa)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/','',$wa) }}" target="_blank" rel="noopener">اضغط هنا</a>
              @else
                <a href="https://wa.me/" target="_blank" rel="noopener">اضغط هنا</a>
              @endif
            </p>
          </form>
        </div>
        <div class="map" aria-hidden="true"></div>
      </div>
    </section>
  </main>
@endsection


