<header class="header t5-header" id="top">
  <div class="container nav t5-nav">
    <a class="brand t5-brand" href="{{ url('/') }}#top" aria-label="Top Level">
      @if(!empty($siteLogo ?? null))
        <img src="{{ $siteLogo }}" class="logo-light t5-logo" alt="الشعار" onerror="this.style.display='none'" />
      @endif
      @if(!empty($siteLogoDark ?? null))
        <img src="{{ $siteLogoDark }}" class="logo-dark t5-logo" alt="الشعار" onerror="this.style.display='none'" />
      @endif
      <span class="t5-brand-text">
        <span class="t5-brand-title">{{ $siteTitle ?? 'Epdaa' }}</span>
        <span class="t5-brand-sub">Premium Experience</span>
      </span>
    </a>

    <nav class="menu t5-menu" aria-label="القائمة الرئيسية">
      <button class="menu-toggle t5-menu-toggle" type="button" aria-label="فتح/إغلاق القائمة" aria-expanded="false">
        <i class="bi bi-list"></i>
      </button>
      <ul id="nav-list" class="t5-nav-list">
        <li><a href="{{ route('home') }}">الرئيسية</a></li>
        <li><a href="{{ route('properties.index') }}">العقارات</a></li>
        <li><a href="{{ route('lands.index') }}">الأراضي</a></li>
        <li><a href="{{ route('contracting') }}">المقاولات</a></li>
        <li><a href="{{ route('gallery.index') }}">المعرض</a></li>
        @auth
          @if(optional(auth()->user())->is_staff || optional(auth()->user())->role === 'manager')
            <li>
              <a class="btn btn-primary t5-btn" href="{{ url('/admin') }}" aria-label="لوحة التحكم">
                <i class="bi bi-speedometer2" aria-hidden="true"></i>
                <span>لوحة التحكم</span>
              </a>
            </li>
          @endif
          <li>
            <form action="{{ route('logout') }}" method="POST" style="display:inline">
              @csrf
              <button type="submit" class="btn btn-primary t5-btn" aria-label="تسجيل الخروج">
                <i class="bi bi-box-arrow-right" aria-hidden="true"></i>
                <span>خروج</span>
              </button>
            </form>
          </li>
        @else
          <li>
            <a class="icon-btn whatsapp t5-icon-btn" href="https://api.whatsapp.com/send?phone={{ urlencode(config('app.whatsapp_number', '966000000000')) }}" target="_blank" rel="noopener" aria-label="واتساب">
              <i class="bi bi-whatsapp" aria-hidden="true"></i>
              <span class="visually-hidden">واتساب</span>
            </a>
          </li>
          <li>
            <a class="icon-btn t5-icon-btn" href="{{ route('login') }}" aria-label="تسجيل الدخول">
              <i class="bi bi-box-arrow-in-left" aria-hidden="true"></i>
              <span class="visually-hidden">تسجيل الدخول</span>
            </a>
          </li>
          <li>
            <a class="icon-btn t5-icon-btn" href="{{ route('register') }}" aria-label="إنشاء حساب">
              <i class="bi bi-person-plus" aria-hidden="true"></i>
              <span class="visually-hidden">إنشاء حساب</span>
            </a>
          </li>
        @endauth
        <li>
          <button id="themeToggle" class="theme-toggle t5-theme-toggle" type="button" aria-label="تبديل الوضع"><i class="bi bi-moon"></i></button>
        </li>
        <li>
          <form action="{{ route('theme.set') }}" method="POST" style="display:inline">
            @csrf
            <select name="theme" onchange="this.form.submit()" aria-label="تبديل الثيم" class="t5-theme-select" style="padding:6px 10px; border-radius:10px; border:1px solid color-mix(in oklab, var(--fg), transparent 75%); background:transparent; color:inherit">
              @foreach((array) config('app.themes', []) as $key => $label)
                <option value="{{ $key }}" @selected(config('app.theme','theme1')===$key)>{{ $label }}</option>
              @endforeach
            </select>
          </form>
        </li>
      </ul>
    </nav>

    <!-- Mobile drawer -->
    <div class="drawer-overlay" id="drawer-overlay" hidden></div>
    <aside class="drawer t5-drawer" id="mobile-drawer" aria-hidden="true">
      <div class="drawer-header t5-drawer-header">
        <strong>القائمة</strong>
        <button class="drawer-close" type="button" aria-label="إغلاق"><i class="bi bi-x"></i></button>
      </div>
      <nav class="drawer-nav" aria-label="القائمة الجانبية">
        <ul>
          <li><a href="{{ route('home') }}">الرئيسية</a></li>
          <li><a href="{{ route('properties.index') }}">العقارات</a></li>
          <li><a href="{{ route('lands.index') }}">الأراضي</a></li>
          <li><a href="{{ route('contracting') }}">المقاولات</a></li>
          <li><a href="{{ route('gallery.index') }}">المعرض</a></li>
        </ul>
      </nav>
    </aside>
  </div>
</header>
