<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ $siteTitle }}</title>
  <meta name="theme-color" content="{{ $colorPrimary }}" />
  <meta name="description" content="نوفّر في مؤسسة طور البناء للتجارة مجموعة متكاملة من أدوات السباكة والبناء والأدوات الصحية والكهربائية والعدد، مع البيع بالآجل والسداد على دفعات ميسرة." />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&display=swap" rel="stylesheet">
  <link rel="icon" href="{{ url($favicon) }}" />
  <!-- Bootstrap Icons for standard iconography -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <meta property="og:title" content="{{ $siteTitle }}" />
  <meta property="og:description" content="مجموعة متكاملة من أدوات السباكة والبناء والصحية والكهربائية والعدد. البيع بالآجل والسداد على دفعات ميسرة." />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="{{ url('/') }}" />
  <meta property="og:image" content="{{ $socialImage }}" />
  <meta property="og:image:width" content="1200" />
  <meta property="og:image:height" content="630" />
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="{{ $siteTitle }}" />
  <meta name="twitter:description" content="مجموعة متكاملة من أدوات السباكة والبناء والصحية والكهربائية والعدد. البيع بالآجل والسداد على دفعات ميسرة." />
  <meta name="twitter:image" content="{{ $socialImage }}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap-grid.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/styles.css?v={{ @filemtime(public_path('styles.css')) }}" />
  <link rel="stylesheet" href="/themes/{{ config('app.theme', 'theme1') }}.css?v={{ @filemtime(public_path('themes/'.config('app.theme', 'theme1').'.css')) }}" />
  @vite(['resources/css/app.css','resources/js/app.js'])
  @yield('head_extra')
  <style>
    :root{
      /* 3 ألوان للوضع الفاتح */
      --light-bg:   {{ $colorBg }};         /* خلفية الصفحات */
      --light-text: {{ $colorFg }};         /* النصوص الأساسية */
      --light-main: {{ $colorPrimary }};    /* اللون الرئيسي */

      /* 3 ألوان للوضع الداكن + لون نص قوي */
      --dark-bg:    {{ $colorBgDark }};     /* خلفية داكنة (مثلاً للفوتر) */
      --dark-text:  {{ $colorFgDark }};     /* نص في الوضع الداكن */
      --dark-main:  {{ $colorPrimaryDark }};/* لون رئيسي في الداكن */
      --strong-text-dark: {{ $colorStrongDark }}; /* نص قوي في الداكن */

      /* لون نص قوي بديل للأسود، قابل للتحكم من الإعدادات */
      --strong-text: {{ $colorStrong }};

      /* ربط المتغيرات المستخدمة في الواجهات */
      --primary: var(--light-main);
      --bg:      var(--light-bg);
      --fg:      var(--light-text);
      --card:    var(--light-bg);
      --border:  var(--light-main);

      /* الفوتر وما يشبهه يستخدم ألوان الداكن */
      --footer-bg:      var(--dark-bg);
      --footer-fg:      var(--dark-text);
      --footer-accent:  var(--dark-main);
    }

    :root[data-theme="dark"]{
      --primary: var(--dark-main);
      --bg:      var(--dark-bg);
      --fg:      var(--dark-text);
      --card:    var(--dark-bg);
      --border:  var(--dark-main);
      --strong-text: var(--strong-text-dark);
    }

    html, body{ background: var(--bg) !important; color: var(--fg) !important; }

    .logo-dark{ display:none }
    :root[data-theme="dark"] .logo-light{ display:none }
    :root[data-theme="dark"] .logo-dark{ display:inline }
  </style>
</head>
<body>

  @unless(View::hasSection('hideSiteChrome'))
    @includeFirst([
      'themes.'.config('app.theme','theme1').'.components._header',
      'themes.theme1.components._header',
      'components._header'
    ])
  @endunless

            <main class="flex-grow-1">
                {{ $slot ?? '' }}
                @yield('content')
            </main>
  @unless(View::hasSection('hideSiteChrome'))
    @includeFirst([
      'themes.'.config('app.theme','theme1').'.components._footer',
      'themes.theme1.components._footer',
      'components._footer'
    ])
  @endunless

  <!-- Back to top button -->
  @unless(View::hasSection('hideSiteChrome'))
    <button class="back-to-top" aria-label="الرجوع للأعلى">↑</button>
  @endunless

  <!-- Floating WhatsApp Button -->
  @unless(View::hasSection('hideSiteChrome'))
    <a class="whatsapp-fab" href="https://api.whatsapp.com/send?phone={{ urlencode($whatsappNumber) }}" target="_blank" rel="noopener" aria-label="التواصل عبر واتساب">
      <i class="bi bi-whatsapp" aria-hidden="true"></i>
    </a>
  @endunless

  <script src="/script.js" defer></script>
  <script src="/theme.js" defer></script>
  <style>
    .toast-wrap{ position:fixed; inset:auto 12px 12px auto; z-index:9999; display:grid; gap:8px; max-width:min(92vw, 360px) }
    .toast{ display:flex; align-items:flex-start; gap:10px; background:var(--card); color:var(--fg); border:1px solid color-mix(in oklab, var(--primary), transparent 20%); border-radius:12px; padding:10px 12px; box-shadow:0 10px 30px rgba(0,0,0,.12) }
    .toast.success{ border-color: color-mix(in oklab, var(--primary), transparent 10%) }
    .toast.error{ border-color: color-mix(in oklab, var(--fg), transparent 55%) }
    .toast.info{ border-color: color-mix(in oklab, var(--fg), transparent 55%) }
    .toast .title{ font-weight:800; margin-bottom:2px }
    .toast .close{ margin-inline-start:auto; background:transparent; border:0; cursor:pointer; color:var(--fg) }
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
        overlay.style.cssText='position:fixed;inset:0;background:color-mix(in oklab, var(--fg), transparent 55%);display:flex;align-items:center;justify-content:center;z-index:9999';
        const box=document.createElement('div');
        box.style.cssText='background:var(--card);border-radius:14px;min-width:320px;max-width:90vw;padding:16px;border:1px solid color-mix(in oklab, var(--fg), transparent 85%);box-shadow:0 10px 30px rgba(0,0,0,.15)';
        box.innerHTML=`<div style="font-weight:700;margin-bottom:8px;color:var(--fg)">تأكيد الإجراء</div>
          <div style="color:color-mix(in oklab, var(--fg), transparent 20%);margin-bottom:14px">${message}</div>
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
  @stack('scripts')
</body>
</html>

