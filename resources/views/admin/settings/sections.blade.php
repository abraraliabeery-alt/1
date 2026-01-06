@extends('layouts.admin')

@section('admin')
<div class="admin-card" dir="rtl">
  <div class="d-flex justify-content-between align-items-start gap-2 flex-wrap mb-3">
    <div>
      <h3 class="m-0">إظهار/إخفاء أقسام الصفحة الرئيسية</h3>
      <p class="muted" style="margin:6px 0 0">حدّد الأقسام التي تريد ظهورها في الصفحة الرئيسية.</p>
    </div>
    @if(session('ok'))
      <div class="badge published">{{ session('ok') }}</div>
    @endif
  </div>

  <form action="{{ route('admin.settings.sections.update') }}" method="POST" class="card" style="padding:14px; border:1px solid var(--admin-border); border-radius:14px">
    @csrf
    @method('PUT')

    <div class="row g-3">
      <div class="col-12 col-md-6 col-lg-4">
        <div class="border rounded-3 p-3 h-100">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="fw-bold">أحدث العقارات</div>
              <div class="text-muted" style="font-size:12px">إظهار قسم العقارات في الصفحة الرئيسية</div>
            </div>
            <div class="form-check form-switch m-0">
              <input class="form-check-input" type="checkbox" role="switch" name="show_properties" id="show_properties" @checked($show_properties ?? false)>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-6 col-lg-4">
        <div class="border rounded-3 p-3 h-100">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="fw-bold">الإحصائيات</div>
              <div class="text-muted" style="font-size:12px">إظهار قسم الأرقام والمؤشرات</div>
            </div>
            <div class="form-check form-switch m-0">
              <input class="form-check-input" type="checkbox" role="switch" name="show_kpis" id="show_kpis" @checked($show_kpis ?? false)>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-6 col-lg-4">
        <div class="border rounded-3 p-3 h-100">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="fw-bold">بطاقات المميزات</div>
              <div class="text-muted" style="font-size:12px">إظهار بطاقات المميزات</div>
            </div>
            <div class="form-check form-switch m-0">
              <input class="form-check-input" type="checkbox" role="switch" name="show_tiles" id="show_tiles" @checked($show_tiles ?? false)>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-6 col-lg-4">
        <div class="border rounded-3 p-3 h-100">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="fw-bold">عن الشركة</div>
              <div class="text-muted" style="font-size:12px">إظهار قسم التعريف بالشركة</div>
            </div>
            <div class="form-check form-switch m-0">
              <input class="form-check-input" type="checkbox" role="switch" name="show_about" id="show_about" @checked($show_about ?? false)>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-6 col-lg-4">
        <div class="border rounded-3 p-3 h-100">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="fw-bold">الخدمات</div>
              <div class="text-muted" style="font-size:12px">إظهار قسم الخدمات</div>
            </div>
            <div class="form-check form-switch m-0">
              <input class="form-check-input" type="checkbox" role="switch" name="show_services" id="show_services" @checked($show_services ?? false)>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-6 col-lg-4">
        <div class="border rounded-3 p-3 h-100">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="fw-bold">المشاريع</div>
              <div class="text-muted" style="font-size:12px">إظهار قسم المشاريع</div>
            </div>
            <div class="form-check form-switch m-0">
              <input class="form-check-input" type="checkbox" role="switch" name="show_projects" id="show_projects" @checked($show_projects ?? false)>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-6 col-lg-4">
        <div class="border rounded-3 p-3 h-100">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="fw-bold">الشركاء</div>
              <div class="text-muted" style="font-size:12px">إظهار قسم الشركاء</div>
            </div>
            <div class="form-check form-switch m-0">
              <input class="form-check-input" type="checkbox" role="switch" name="show_partners" id="show_partners" @checked($show_partners ?? false)>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-6 col-lg-4">
        <div class="border rounded-3 p-3 h-100">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="fw-bold">آراء العملاء</div>
              <div class="text-muted" style="font-size:12px">إظهار قسم التقييمات</div>
            </div>
            <div class="form-check form-switch m-0">
              <input class="form-check-input" type="checkbox" role="switch" name="show_testimonials" id="show_testimonials" @checked($show_testimonials ?? false)>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-6 col-lg-4">
        <div class="border rounded-3 p-3 h-100">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="fw-bold">شريط الدعوة للتواصل</div>
              <div class="text-muted" style="font-size:12px">إظهار الشريط قبل قسم التواصل</div>
            </div>
            <div class="form-check form-switch m-0">
              <input class="form-check-input" type="checkbox" role="switch" name="show_cta" id="show_cta" @checked($show_cta ?? false)>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-6 col-lg-4">
        <div class="border rounded-3 p-3 h-100">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="fw-bold">الأسئلة الشائعة</div>
              <div class="text-muted" style="font-size:12px">إظهار قسم الأسئلة والأجوبة</div>
            </div>
            <div class="form-check form-switch m-0">
              <input class="form-check-input" type="checkbox" role="switch" name="show_faqs" id="show_faqs" @checked($show_faqs ?? false)>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-6 col-lg-4">
        <div class="border rounded-3 p-3 h-100">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="fw-bold">التواصل</div>
              <div class="text-muted" style="font-size:12px">إظهار قسم نموذج التواصل</div>
            </div>
            <div class="form-check form-switch m-0">
              <input class="form-check-input" type="checkbox" role="switch" name="show_contact" id="show_contact" @checked($show_contact ?? false)>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-3">
      <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">رجوع</a>
      <button class="btn btn-primary" type="submit">حفظ</button>
    </div>
  </form>
</div>
@endsection
