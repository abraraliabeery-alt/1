@extends('layouts.app')

@section('content')
  <main class="section">
    <div class="container" style="max-width:960px">
      <header style="margin-bottom:16px">
        <h1 style="margin:0">من نحن</h1>
        <p class="text-muted" style="margin:8px 0 0 0">شركة تقنية متخصصة في البنية التحتية والأنظمة الذكية وأنظمة الأمان.</p>
      </header>

      <section class="card" style="padding:16px; margin-bottom:16px">
        <h2 class="h3-compact">نحن من</h2>
        <p>شركة تقنية متخصصة في أنظمة الأمان والأنظمة الذكية (IoT) والشبكات ونقاط الوصول والاتصالات IP/PBX والخوادم. نعمل باحترافية عالية وبتفانٍ لنواكب التطور التقني ونُسهّل حياة العملاء اليومية ونرفع مستوى الأمان لديهم.</p>
      </section>

      <section class="card" style="padding:16px; margin-bottom:16px">
        <h2 class="h3-compact">رؤيتنا وأهدافنا</h2>
        <p>نسعى باستمرار لنكون من أفضل الشركات الرائدة، عبر تقديم حلول تقنية ذكية ومتجددة لعملائنا، مع ضمان الأمان والجودة والموثوقية.</p>
      </section>

      <section class="card" style="padding:16px; margin-bottom:16px">
        <h2 class="h3-compact">مهمتنا</h2>
        <p>توفير حلول أمان وذكاء متكاملة، تشمل الاستشارات والتصميم والتوريد والتركيب والاختبار والتدريب والدعم المستمر، لتلبية الاحتياجات الفعلية لعملائنا بأفضل جودة.</p>
      </section>

      <section class="card" style="padding:16px; margin-bottom:16px">
        <h2 class="h3-compact">مجالات الخدمة</h2>
        <ul class="list-compact">
          <li>حلول كاميرات المراقبة عالية الدقة (متحركة/ثابتة) مع تسجيل وتخزين محلي/سحابي</li>
          <li>أنظمة مكافحة السرقة والإنذار مع حساسات الحركة والدخان والغاز وتنبيهات فورية</li>
          <li>الأنظمة الذكية (IoT) للمنازل والمكاتب: أقفال/إضاءة/ستائر/تكييف/صوت/إنتركم</li>
          <li>شبكات Wi‑Fi ونقاط الوصول وإدارة مركزية وتغطية محسّنة</li>
          <li>سنترالات الاتصالات IP/PBX وربط الفروع وإدارة المكالمات</li>
          <li>الخوادم واستضافة المواقع مع حماية ومراقبة ونسخ احتياطي</li>
          <li>أجهزة البصمة والحضور والتحكم في الدخول</li>
        </ul>
        <div style="margin-top:8px">
          <a class="btn btn-primary" href="{{ route('services.index') }}">استعراض الخدمات</a>
        </div>
      </section>

      <section class="card" style="padding:16px; margin-bottom:16px">
        <h2 class="h3-compact">تواصل معنا</h2>
        <p class="m-0">البريد: <a href="mailto:info@toplevel.sa">info@toplevel.sa</a></p>
      </section>
    </div>
  </main>
@endsection
