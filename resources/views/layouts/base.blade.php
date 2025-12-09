<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name','شركة مدى الذهبية') }}</title>
    <link rel="icon" href="{{ $favicon }}" />
    @vite(['resources/css/app.css','resources/js/app.js'])
  </head>
  <body class="bg-slate-50 text-slate-800 font-sans">
    <!-- Header -->
    <header class="sticky top-0 z-40 bg-white/90 backdrop-blur border-b border-slate-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center gap-2 font-extrabold text-slate-800">
          @if(!empty($siteLogoUrl))
            <img src="{{ $siteLogoUrl }}" class="w-8 h-8 rounded-lg hidden sm:block" onerror="this.style.display='none'" alt="logo">
          @endif
          <span>{{ config('app.name','شركة مدى الذهبية') }}</span>
        </a>
        <div class="flex items-center gap-2">
          <a href="{{ route('home') }}" class="btn btn-outline @if(request()->routeIs('home')) !bg-slate-900 !text-white @endif">الرئيسية</a>
          <a href="{{ route('properties.index') }}" class="btn btn-outline @if(request()->routeIs('properties.index')) !bg-slate-900 !text-white @endif">العقارات</a>
          @auth
            @if(auth()->user()->is_staff)
              <a href="{{ route('properties.create') }}" class="btn">إضافة عقار</a>
              <a href="{{ route('properties.my') }}" class="btn btn-outline @if(request()->routeIs('properties.my')) !bg-slate-900 !text-white @endif">عقاراتي</a>
            @endif
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button class="btn btn-primary" type="submit">خروج</button>
            </form>
          @else
            <a href="{{ route('login') }}" class="btn">دخول</a>
          @endauth
        </div>
      </div>
    </header>

    <!-- Main -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
      {{ $slot ?? '' }}
      @yield('content')
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-200 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-14 flex items-center justify-between text-slate-600">
        <span>© {{ date('Y') }} {{ config('app.name','شركة مدى الذهبية') }}</span>
        <div class="flex items-center gap-2">
          <a class="btn btn-outline" href="{{ route('properties.index') }}">العقارات</a>
          <a class="btn btn-outline" href="#contact">تواصل</a>
        </div>
      </div>
    </footer>

    <!-- Minimal CSS helpers (no build step needed) -->
    <style>
      .btn{ display:inline-flex; align-items:center; gap:.5rem; border:1px solid transparent; background:var(--primary); color:#000; padding:.6rem 1.1rem; border-radius:.8rem; font-weight:800; font-size:.95rem; box-shadow:0 6px 16px rgba(0,0,0,.08); transition:transform .15s ease, box-shadow .15s ease }
      .btn:hover{ transform:translateY(-1px); box-shadow:0 10px 24px rgba(0,0,0,.12) }
      .btn-outline{ background:transparent; color:var(--fg); border:1px solid color-mix(in oklab, var(--fg), transparent 80%); }
      .card{ border:1px solid color-mix(in oklab, var(--fg), transparent 85%); background:var(--card); border-radius:16px; box-shadow:var(--shadow-sm) }
      .field{ height:44px; border:1px solid #e5e7eb; background:#fff; border-radius:.6rem; padding:.5rem .75rem; outline:none }
      .muted{ color:#64748b }
      .grid-3{ display:grid; gap:1rem }
      @media (min-width:768px){ .grid-3{ grid-template-columns: repeat(2, minmax(0,1fr)) } }
      @media (min-width:1024px){ .grid-3{ grid-template-columns: repeat(3, minmax(0,1fr)) } }
      .section-title{ display:flex; align-items:flex-end; justify-content:space-between; margin-bottom:1rem }
      .section{ padding-block: 64px }
      .section.alt{ background: color-mix(in oklab, var(--bg), var(--fg) 4%) }
      .logo-dark{ display:none }
      [data-theme="dark"] .logo-light{ display:none }
      [data-theme="dark"] .logo-dark{ display:inline }
    </style>
    <style>
      .toast-wrap{ position:fixed; inset:auto 12px 12px auto; z-index:9999; display:grid; gap:8px; max-width:min(92vw, 360px) }
      .toast{ display:flex; align-items:flex-start; gap:10px; background:#fff; color:#0f172a; border:1px solid #e5e7eb; border-radius:12px; padding:10px 12px; box-shadow:0 10px 30px rgba(0,0,0,.12) }
      .toast.success{ border-color:#22c55e }
      .toast.error{ border-color:#ef4444 }
      .toast.info{ border-color:#3b82f6 }
      .toast .title{ font-weight:800; margin-bottom:2px }
      .toast .close{ margin-inline-start:auto; background:transparent; border:0; cursor:pointer; color:#64748b }
    </style>
    <div class="toast-wrap" id="toast-wrap" aria-live="polite"></div>
    <script>
      (function(){
        const data = {
          ok: @json(session('ok')),
          status: @json(session('status')),
          error: @json(session('error')),
          warnings: @json(session('warning')),
          errorsList: @json(($errors ?? null)?->all() ?? [])
        };
        const wrap = document.getElementById('toast-wrap');
        function push(type, title, msg){
          if(!msg) return;
          const el = document.createElement('div');
          el.className = 'toast ' + type;
          el.innerHTML = `<div><div class="title">${title}</div><div>${msg}</div></div><button class="close" aria-label="إغلاق">×</button>`;
          el.querySelector('.close').addEventListener('click', ()=> el.remove());
          wrap.appendChild(el);
          setTimeout(()=>{ el.remove(); }, 5000);
        }
        if(data.ok) push('success','تم', data.ok);
        if(data.status) push('success','تم', data.status);
        if(data.error) push('error','خطأ', data.error);
        if(data.warnings) push('info','تنبيه', data.warnings);
        if((data.errorsList||[]).length){
          data.errorsList.slice(0,3).forEach(m=> push('error','خطأ', m));
          if(data.errorsList.length>3) push('error','خطأ', `و${data.errorsList.length-3} أخطاء أخرى`);
        }
      })();
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
              <button type="button" data-act="ok" class="btn btn-danger">تأكيد</button>
            </div>`;
          overlay.appendChild(box);
          return {overlay, box};
        }
        document.addEventListener('click', function(e){
          const btn = e.target.closest('[data-confirm]');
          if(!btn) return;
          if(btn.tagName==='A'){
            e.preventDefault();
            const {overlay,box}=buildModal(btn.getAttribute('data-confirm'));
            document.body.appendChild(overlay);
            overlay.addEventListener('click', (ev)=>{ if(ev.target===overlay) overlay.remove(); });
            box.querySelector('[data-act="cancel"]').addEventListener('click',()=> overlay.remove());
            box.querySelector('[data-act="ok"]').addEventListener('click',()=>{ overlay.remove(); window.location.href = btn.getAttribute('href'); });
          }
        }, true);
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
  </body>
</html>
