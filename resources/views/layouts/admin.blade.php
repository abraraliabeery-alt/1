@extends('layouts.app')

@section('head_extra')
  <link rel="stylesheet" href="/admin.css?v={{ @filemtime(public_path('admin.css')) }}" />
@endsection

@section('content')
  <main class="section admin-shell" style="padding-top:24px">
    <div class="container admin-grid">
      <aside aria-label="قائمة الإدارة" class="admin-aside">
        <div class="row-between" style="align-items:center; gap:8px">
          <h5 class="admin-aside-title" style="margin:0">الإدارة</h5>
          <button id="admin-theme-toggle" class="btn btn-outline" type="button" style="padding:6px 10px">الوضع الداكن</button>
        </div>
        <nav>
          <ul class="admin-nav">
            <li><a class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> لوحة التحكم</a></li>
            <li class="sep"></li>
            
            @auth
              @if(auth()->user()->is_staff)
                <!-- المحتوى -->
                <li><a class="{{ request()->routeIs('admin.services.*') ? 'active' : '' }}" href="{{ route('admin.services.index') }}"><i class="bi bi-grid-1x2"></i> الخدمات</a></li>
                <li><a class="{{ request()->routeIs('admin.partners.*') ? 'active' : '' }}" href="{{ route('admin.partners.index') }}"><i class="bi bi-people"></i> شركاء النجاح</a></li>
                <li><a class="{{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}" href="{{ route('admin.faqs.index') }}"><i class="bi bi-question-circle"></i> الأسئلة الشائعة</a></li>
                <li><a class="{{ request()->routeIs('gallery.sort*') ? 'active' : '' }}" href="{{ route('gallery.sort') }}"><i class="bi bi-images"></i> إدارة الألبوم</a></li>
                <li class="sep"></li>
                <!-- التواصل -->
                <li><a class="{{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}" href="{{ route('admin.contacts.index') }}"><i class="bi bi-envelope"></i> رسائل التواصل</a></li>
                <li class="sep"></li>
                <!-- الإعدادات -->
                <li><a class="{{ request()->routeIs('admin.settings.branding.*') ? 'active' : '' }}" href="{{ route('admin.settings.branding.edit') }}"><i class="bi bi-brush"></i> الهوية والشعارات</a></li>
                <li><a class="{{ request()->routeIs('admin.settings.social.*') ? 'active' : '' }}" href="{{ route('admin.settings.social.edit') }}"><i class="bi bi-share"></i> إعدادات السوشيال</a></li>
                <li><a class="{{ request()->routeIs('admin.settings.sections.*') ? 'active' : '' }}" href="{{ route('admin.settings.sections.edit') }}"><i class="bi bi-sliders"></i> إعدادات الأقسام</a></li>
              @endif
              @if(optional(auth()->user())->role === 'manager')
                <li class="sep"></li>
                <!-- الإدارة -->
                <li><a class="{{ request()->routeIs('admin.users.index') ? 'active' : '' }}" href="{{ route('admin.users.index') }}"><i class="bi bi-people"></i> جميع المستخدمين</a></li>
              @endif
            @endauth
          </ul>
        </nav>
      </aside>
      <section class="admin-content">
        @if(session('ok'))
          <div class="alert alert-success" role="status"><strong>تم:</strong> {{ session('ok') }}</div>
        @endif
        @if($errors->any())
          <div class="alert alert-danger" role="alert">
            <ul class="list-compact">
              @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        @yield('admin')
      </section>
    </div>
  </main>
@endsection

@push('scripts')
<script>
  (function(){
    const key='admin_theme';
    const btn=document.getElementById('admin-theme-toggle');
    const apply=(v)=>{ document.documentElement.setAttribute('data-theme', v==='dark'?'dark':'light'); btn && (btn.textContent = v==='dark'?'الوضع الفاتح':'الوضع الداكن'); };
    const stored=localStorage.getItem(key)||'light';
    apply(stored);
    btn && btn.addEventListener('click',()=>{ const cur=document.documentElement.getAttribute('data-theme')==='dark'?'dark':'light'; const next=cur==='dark'?'light':'dark'; localStorage.setItem(key,next); apply(next); });
  })();

  // Pretty confirm for forms with data-confirm
  (function(){
    function buildModal(message){
      const overlay=document.createElement('div');
      overlay.style.cssText='position:fixed;inset:0;background:rgba(15,23,42,.45);display:flex;align-items:center;justify-content:center;z-index:9999';
      const box=document.createElement('div');
      box.style.cssText='background:#fff;border-radius:14px;min-width:320px;max-width:90vw;padding:16px;border:1px solid #e5e7eb;box-shadow:0 10px 30px rgba(0,0,0,.15)';
      box.innerHTML=`<div style="font-weight:700;margin-bottom:8px;color:#0f172a">تأكيد الإجراء</div>
        <div style="color:#374151;margin-bottom:14px">${message}</div>
        <div style="display:flex;gap:8px;justify-content:flex-end">
          <button type="button" data-act="cancel" class="btn btn-outline">إلغاء</button>
          <button type="button" data-act="ok" class="btn btn-danger">حذف</button>
        </div>`;
      overlay.appendChild(box);
      return {overlay, box};
    }
    document.addEventListener('submit', function(e){
      const f=e.target;
      if(!(f instanceof HTMLFormElement)) return;
      const msg=f.getAttribute('data-confirm');
      if(!msg) return;
      e.preventDefault();
      const {overlay,box}=buildModal(msg);
      document.body.appendChild(overlay);
      overlay.addEventListener('click', (ev)=>{ if(ev.target===overlay){ document.body.removeChild(overlay); }});
      box.querySelector('[data-act="cancel"]').addEventListener('click',()=>{ document.body.removeChild(overlay); });
      box.querySelector('[data-act="ok"]').addEventListener('click',()=>{ overlay.remove(); f.removeAttribute('data-confirm'); f.submit(); });
    }, true);
  })();
  </script>
@endpush
