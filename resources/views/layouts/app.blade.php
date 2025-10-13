<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  @php($hasSettings = \Illuminate\Support\Facades\Schema::hasTable('settings'))
  @php($siteTitle = $hasSettings ? \App\Models\Setting::getValue('site_title', 'توب ليفل | حلول المنازل والمكاتب الذكية') : 'توب ليفل | حلول المنازل والمكاتب الذكية')
  @php($siteLogo = $hasSettings ? \App\Models\Setting::getValue('site_logo', '/assets/top.png') : '/assets/top.png')
  @php($favicon = '/assets/top.png')
  <title>{{ $siteTitle }}</title>
  <meta name="theme-color" content="#0a66ff" />
  <meta name="description" content="توب ليفل - شركة مقاولات معمارية متكاملة تقدم أعمال الإنشاءات والتشطيبات وMEP، ومتخصصة في حلول المنازل والمكاتب الذكية." />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&display=swap" rel="stylesheet">
  <link rel="icon" href="{{ $favicon }}" />
  <!-- Bootstrap Icons for standard iconography -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <meta property="og:title" content="{{ $siteTitle }}" />
  <meta property="og:description" content="شركة مقاولات معمارية متكاملة: إنشاءات وتشطيبات وMEP، مع تخصص عميق في حلول Smart Home & Office." />
  <meta property="og:type" content="website" />
  <meta property="og:image" content="/assets/og-image.svg" />
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="{{ $siteTitle }}" />
  <meta name="twitter:description" content="شركة مقاولات معمارية متكاملة: إنشاءات وتشطيبات وMEP، مع تخصص عميق في حلول Smart Home & Office." />
  <meta name="twitter:image" content="/assets/og-image.svg" />
  <link rel="stylesheet" href="/styles.css?v={{ @filemtime(public_path('styles.css')) }}" />
  @yield('head_extra')
</head>
<body>

  @include('components._header')

            <main class="flex-grow-1">
                {{ $slot ?? '' }}
                @yield('content')
            </main>
  @include('components._footer')

  <!-- Back to top button -->
  <button class="back-to-top" aria-label="الرجوع للأعلى">↑</button>

  <!-- Floating WhatsApp Button -->
  @php($hasSettings = \Illuminate\Support\Facades\Schema::hasTable('settings'))
  @php($wa = $hasSettings ? \App\Models\Setting::getValue('whatsapp_number', config('app.whatsapp_number', '966000000000')) : config('app.whatsapp_number', '966000000000'))
  <a class="whatsapp-fab" href="https://api.whatsapp.com/send?phone={{ urlencode($wa) }}" target="_blank" rel="noopener" aria-label="التواصل عبر واتساب">
    <i class="bi bi-whatsapp" aria-hidden="true"></i>
  </a>

  <script src="/script.js"></script>
  @stack('scripts')
  <script>
    (function(){
      const key='site_theme';
      const root=document.documentElement;
      const btn=document.getElementById('themeToggle');
      const set=(v)=>{ root.setAttribute('data-theme', v); if(btn){ btn.innerHTML = v==='dark' ? '<i class="bi bi-sun"></i>' : '<i class="bi bi-moon"></i>'; } };
      const stored=localStorage.getItem(key);
      if(stored){ set(stored); }
      btn && btn.addEventListener('click', ()=>{ const cur=root.getAttribute('data-theme')==='dark'?'dark':'light'; const next=cur==='dark'?'light':'dark'; localStorage.setItem(key,next); set(next); });
    })();
  </script>
</body>
</html>

