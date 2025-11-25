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
          <span>صورة الهيرو (Hero Image)</span>
          <input type="file" name="hero_image" accept="image/*">
        </label>
        <div class="row-between" style="margin-top:8px">
          <div class="text-muted" style="font-size:12px">الحالية:</div>
          <img src="{{ $hero_image }}" alt="صورة الهيرو الحالية" style="height:60px; width:auto; border-radius:8px">
        </div>
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

      <div class="card" style="padding:12px">
        <h4 class="h3-compact">ألوان الموقع</h4>
        <div class="form-row" style="margin-top:8px">
          <label>
            <span>اللون الأساسي (primary)</span>
            <div style="display:flex; gap:8px; align-items:center">
              <input type="color" data-color="color_primary" value="{{ old('color_primary', $color_primary) }}">
              <input type="text" name="color_primary" data-color-text="color_primary" value="{{ old('color_primary', $color_primary) }}" placeholder="#fcae41" class="field" style="direction:ltr; text-transform:lowercase">
            </div>
          </label>
          <label>
            <span>خلفية الصفحة (bg)</span>
            <div style="display:flex; gap:8px; align-items:center">
              <input type="color" data-color="color_bg" value="{{ old('color_bg', $color_bg) }}">
              <input type="text" name="color_bg" data-color-text="color_bg" value="{{ old('color_bg', $color_bg) }}" placeholder="#ffffff" class="field" style="direction:ltr; text-transform:lowercase">
            </div>
          </label>
        </div>
        <div class="form-row">
          <label>
            <span>لون النص (fg)</span>
            <div style="display:flex; gap:8px; align-items:center">
              <input type="color" data-color="color_fg" value="{{ old('color_fg', $color_fg) }}">
              <input type="text" name="color_fg" data-color-text="color_fg" value="{{ old('color_fg', $color_fg) }}" placeholder="#000000" class="field" style="direction:ltr; text-transform:lowercase">
            </div>
          </label>
          <label>
            <span>خلفية البطاقات (card)</span>
            <div style="display:flex; gap:8px; align-items:center">
              <input type="color" data-color="color_card" value="{{ old('color_card', $color_card) }}">
              <input type="text" name="color_card" data-color-text="color_card" value="{{ old('color_card', $color_card) }}" placeholder="#ffffff" class="field" style="direction:ltr; text-transform:lowercase">
            </div>
          </label>
        </div>
        <div class="form-row">
          <label>
            <span>لون الحدود (border)</span>
            <div style="display:flex; gap:8px; align-items:center">
              <input type="color" data-color="color_border" value="{{ old('color_border', $color_border) }}">
              <input type="text" name="color_border" data-color-text="color_border" value="{{ old('color_border', $color_border) }}" placeholder="#e6ecff" class="field" style="direction:ltr; text-transform:lowercase">
            </div>
          </label>
          <label>
            <span>تذييل: الخلفية</span>
            <div style="display:flex; gap:8px; align-items:center">
              <input type="color" data-color="color_footer_bg" value="{{ old('color_footer_bg', $color_footer_bg) }}">
              <input type="text" name="color_footer_bg" data-color-text="color_footer_bg" value="{{ old('color_footer_bg', $color_footer_bg) }}" placeholder="#000000" class="field" style="direction:ltr; text-transform:lowercase">
            </div>
          </label>
        </div>
        <div class="form-row">
          <label>
            <span>تذييل: النص</span>
            <div style="display:flex; gap:8px; align-items:center">
              <input type="color" data-color="color_footer_fg" value="{{ old('color_footer_fg', $color_footer_fg) }}">
              <input type="text" name="color_footer_fg" data-color-text="color_footer_fg" value="{{ old('color_footer_fg', $color_footer_fg) }}" placeholder="#ffffff" class="field" style="direction:ltr; text-transform:lowercase">
            </div>
          </label>
          <label>
            <span>تذييل: اللون المميز</span>
            <div style="display:flex; gap:8px; align-items:center">
              <input type="color" data-color="color_footer_accent" value="{{ old('color_footer_accent', $color_footer_accent) }}">
              <input type="text" name="color_footer_accent" data-color-text="color_footer_accent" value="{{ old('color_footer_accent', $color_footer_accent) }}" placeholder="#fcae41" class="field" style="direction:ltr; text-transform:lowercase">
            </div>
          </label>
        </div>
        <script>
          (function(){
            function norm(v){ v=(v||'').trim(); if(!v) return ''; if(/^#?[0-9a-fA-F]{3,8}$/.test(v)){ return v.startsWith('#')? v : ('#'+v); } return v; }
            document.querySelectorAll('[data-color]').forEach(picker=>{
              const name=picker.getAttribute('data-color');
              const txt=document.querySelector('[data-color-text="'+name+'"]');
              if(!txt) return;
              picker.addEventListener('input',()=>{ txt.value = picker.value; });
              txt.addEventListener('input',()=>{ const v=norm(txt.value); if(/^#([0-9a-fA-F]{3,8})$/.test(v)) picker.value=v; });
            });
          })();
        </script>
      </div>

      <div class="row-between" style="grid-column:1 / -1">
        <div></div>
        <button class="btn btn-primary" type="submit">حفظ</button>
      </div>
    </form>
  </div>
@endsection
