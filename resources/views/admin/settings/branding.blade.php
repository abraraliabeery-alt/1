@extends('layouts.admin')

@section('admin')
  <div class="admin-header">
    <div class="title">
      <h1>الهوية والشعارات</h1>
      <div class="subtitle">حدّث الشعار الظاهر في الموقع والرمز الذي يظهر في تبويب المتصفح، والعنوان الافتراضي.</div>
    </div>
  </div>

  <div class="admin-content">
    <form action="{{ route('admin.settings.branding.update') }}" method="POST" enctype="multipart/form-data" class="grid-2" style="gap:12px">
      @csrf
      <div class="card" style="padding:12px">
        <label>
          <span>عنوان الموقع (title)</span>
          <input type="text" name="site_title" value="{{ old('site_title', $site_title) }}" placeholder="مثال: توب ليفل | حلول المنازل والمكاتب الذكية">
        </label>
      </div>

      <div class="card" style="padding:12px">
        <label>
          <span>الشعار (Logo)</span>
          <input type="file" name="site_logo" accept="image/*">
        </label>
        <div class="row-between" style="margin-top:8px">
          <div class="text-muted" style="font-size:12px">الحالي:</div>
          <img src="{{ $site_logo }}" alt="الشعار الحالي" style="height:42px; width:auto">
        </div>
      </div>

      <div class="card" style="padding:12px">
        <label>
          <span>رمز التبويب (Favicon)</span>
          <input type="file" name="site_favicon" accept="image/*,.ico,.svg">
        </label>
        <label style="margin-top:8px; display:flex; align-items:center; gap:8px">
          @php($same = empty($site_favicon) || $site_favicon === $site_logo)
          <input type="checkbox" name="favicon_same_logo" {{ $same ? 'checked' : '' }}>
          <span>استخدام نفس الشعار كأيقونة تبويب</span>
        </label>
        <div class="row-between" style="margin-top:8px">
          <div class="text-muted" style="font-size:12px">الحالي:</div>
          <img src="{{ $same ? $site_logo : $site_favicon }}" alt="الرمز الحالي" style="height:24px; width:auto">
        </div>
      </div>

      <div class="row-between" style="grid-column:1 / -1">
        <div></div>
        <button class="btn btn-primary" type="submit">حفظ</button>
      </div>
    </form>
  </div>
@endsection
