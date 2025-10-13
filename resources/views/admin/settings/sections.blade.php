@extends('layouts.admin')

@section('admin')
<div class="admin-card" style="display:grid; gap:12px">
  <div class="row-between" style="margin-bottom:4px; align-items:center">
    <div>
      <h3 class="m-0">إظهار/إخفاء أقسام الصفحة الرئيسية</h3>
      <p class="muted" style="margin:4px 0 0">حدّد الأقسام التي تريد ظهورها في الصفحة الرئيسية.</p>
    </div>
    @if(session('ok'))
      <div class="badge published">{{ session('ok') }}</div>
    @endif
  </div>

  <form action="{{ route('admin.settings.sections.update') }}" method="POST" class="card" style="padding:12px; border:1px solid var(--admin-border); border-radius:12px; display:grid; gap:12px">
    @csrf
    @method('PUT')

    <fieldset style="border:1px solid var(--admin-border); border-radius:10px; padding:12px">
      <legend style="padding:0 6px; font-weight:800">الأقسام</legend>
      <div class="grid-3" style="gap:10px">
        <label style="display:flex; align-items:center; gap:8px">
          <input type="checkbox" name="show_testimonials" @checked($show_testimonials) /> آراء العملاء
        </label>
        <label style="display:flex; align-items:center; gap:8px">
          <input type="checkbox" name="show_ip_pbx" @checked($show_ip_pbx) /> حلول الاتصالات والسنترالات (IP/PBX)
        </label>
        <label style="display:flex; align-items:center; gap:8px">
          <input type="checkbox" name="show_servers" @checked($show_servers) /> الخوادم واستضافة المواقع
        </label>
        <label style="display:flex; align-items:center; gap:8px">
          <input type="checkbox" name="show_fingerprint" @checked($show_fingerprint) /> أنظمة البصمة والحضور
        </label>
        <label style="display:flex; align-items:center; gap:8px">
          <input type="checkbox" name="show_portfolio" @checked($show_portfolio) /> لمحات من أعمالنا (الألبوم)
        </label>
        <label style="display:flex; align-items:center; gap:8px">
          <input type="checkbox" name="show_faqs" @checked($show_faqs) /> الأسئلة الشائعة
        </label>
      </div>
    </fieldset>

    <div style="display:flex; justify-content:flex-end; gap:8px">
      <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">رجوع</a>
      <button class="btn btn-primary" type="submit">حفظ</button>
    </div>
  </form>
</div>
@endsection
