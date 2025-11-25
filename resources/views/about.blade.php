@extends('layouts.app')

@section('content')
  <main class="section">
    <div class="container" style="max-width:960px">
      <header style="margin-bottom:16px">
        <h1 style="margin:0">مؤسسة طور البناء للتجارة</h1>
        <p class="text-muted" style="margin:8px 0 0 0">مجموعة متكاملة من أدوات السباكة والبناء والأدوات الصحية والكهربائية والعدد — البيع بالآجل والسداد على دفعات ميسرة.</p>
      </header>

      <section class="card" style="padding:16px; margin-bottom:16px">
        <h2 class="h3-compact">من نحن</h2>
        <p>نعتز في مؤسسة طور البناء للتجارة بتقديم مجموعة متكاملة وشاملة من أدوات السباكة وأدوات البناء والأدوات الصحية والكهربائية والعدد التي تلبي احتياجات عملائنا المتنوعة. نسعى لتوفير منتجات عالية الجودة وموثوقة تسهم في إنجاز المشاريع بدقة وكفاءة، وبفضل خبرتنا الواسعة وفريقنا المحترف نحرص على تقديم حلول مبتكرة ومناسبة لاحتياجات السوق المحلية وبناء علاقات طويلة الأمد مع عملائنا.</p>
        <p class="m-0">ومن أهم ما نميز به عملاءنا: <strong>البيع بالآجل والسداد على دفعات ميسّرة</strong>.</p>
      </section>

      <section class="card" style="padding:16px; margin-bottom:16px">
        <h2 class="h3-compact">رؤيتنا وأهدافنا</h2>
        <p>أن نكون الرواد في مجال توفير أدوات السباكة وأدوات البناء والأدوات الصحية والكهربائية والعدد في السوق المحلي والإقليمي، عبر الالتزام بأعلى معايير الجودة والابتكار.</p>
      </section>

      <section class="card" style="padding:16px; margin-bottom:16px">
        <h2 class="h3-compact">مهمتنا</h2>
        <p>تحقيق التميز من خلال الابتكار المستمر وتطوير حلول متكاملة تسهم في إنجاح مشاريع عملائنا، مع تقديم خدمات استثنائية بفريق محترف ومتخصص يعمل بروح التعاون والالتزام.</p>
      </section>

      <section class="card" style="padding:16px; margin-bottom:16px">
        <h2 class="h3-compact">مجالات الخدمة</h2>
        <ul class="list-compact">
          <li>أدوات البناء (Construction Tools): مطارق، مسامير، مثاقب، مجارف، أجهزة قياس، رافعات وغيرها.</li>
          <li>أدوات السباكة (Plumbing Tools): أنابيب، صمامات، محابس، وصلات وغيرها.</li>
          <li>الأدوات الصحية (Sanitary Ware): صنابير، مغاسل، أحواض استحمام، دشات، وأنظمة تسخين وتبريد المياه.</li>
          <li>الأدوات الكهربائية (Electrical Tools): أسلاك وكابلات، مفاتيح كهربائية، قواطع، أجهزة تحكم وسلامة، مصابيح ولوحات كهربائية.</li>
          <li>العدد اليدوية والكهربائية (Hand & Power Tools): مفكات، مثاقب، مناشير، مفاتيح وغيرها.</li>
        </ul>
        <div style="margin-top:8px">
          <a class="btn btn-primary" href="{{ url('/') }}#services">استعراض المنتجات</a>
        </div>
      </section>

      <section class="card" style="padding:16px; margin-bottom:16px">
        <h2 class="h3-compact">تواصل معنا</h2>
        <p class="m-0">رقم السجل التجاري: <strong>1010851048</strong></p>
        <p class="m-0">البريد الإلكتروني: <a href="mailto:tour@tourcons.com">tour@tourcons.com</a></p>
        <p class="m-0">رقم الجوال: <a href="tel:0503310071">0503310071</a></p>
        <p class="m-0">الموقع الإلكتروني: <a href="https://touralbina.com/" target="_blank" rel="noopener">https://touralbina.com/</a></p>
      </section>
    </div>
  </main>
@endsection
