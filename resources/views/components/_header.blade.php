<!-- Header / Simple top navigation -->
<header class="header" id="top">
  <div class="container nav">
    @php($hasSettings = \Illuminate\Support\Facades\Schema::hasTable('settings'))
    @php($siteLogo = $hasSettings ? \App\Models\Setting::getValue('site_logo', '/assets/top.png') : '/assets/top.png')
    <a class="brand" href="#top" aria-label="Top Level">
      <img src="{{ $siteLogo }}" alt="Top Level - توب ليفل" />
    </a>
    <nav class="menu" aria-label="القائمة الرئيسية">
      <ul id="nav-list">
        <li><a href="#hero">الرئيسية</a></li>
        <li><a href="{{ route('about') }}">من نحن</a></li>
        <li><a href="{{ route('services.index') }}">الخدمات</a></li>
        <li><a href="#home-solutions">المنزل الذكي</a></li>
        <li><a href="#office-solutions">المكتب الذكي</a></li>
        <li><a href="#pricing">الأسعار</a></li>
        <li><a href="{{ route('projects.index') }}">المشاريع</a></li>
        <li><a href="{{ route('gallery.index') }}">الألبوم</a></li>
        <li><a href="#contact">تواصل</a></li>
        @auth
          @if(optional(auth()->user())->is_staff || optional(auth()->user())->role === 'manager')
            <li>
              <a class="dash-link" href="{{ url('/admin') }}" aria-label="لوحة التحكم">
                <i class="bi bi-speedometer2" aria-hidden="true"></i>
                <span>لوحة التحكم</span>
              </a>
            </li>
          @endif
          <li>
            <form action="{{ route('logout') }}" method="POST" style="display:inline">
              @csrf
              <button type="submit" class="dash-link" aria-label="تسجيل الخروج">
                <i class="bi bi-box-arrow-right" aria-hidden="true"></i>
                <span>خروج</span>
              </button>
            </form>
          </li>
        @else
          <li>
            <a class="icon-btn whatsapp" href="https://api.whatsapp.com/send?phone={{ urlencode(config('app.whatsapp_number', '966000000000')) }}" target="_blank" rel="noopener" aria-label="واتساب">
              <i class="bi bi-whatsapp" aria-hidden="true"></i>
              <span class="visually-hidden">واتساب</span>
            </a>
          </li>
          <li>
            <a class="icon-btn" href="{{ route('login') }}" aria-label="تسجيل الدخول">
              <i class="bi bi-box-arrow-in-left" aria-hidden="true"></i>
              <span class="visually-hidden">تسجيل الدخول</span>
            </a>
          </li>
          <li>
            <a class="icon-btn" href="{{ route('register') }}" aria-label="إنشاء حساب">
              <i class="bi bi-person-plus" aria-hidden="true"></i>
              <span class="visually-hidden">إنشاء حساب</span>
            </a>
          </li>
        @endauth
        <li>
          <button id="themeToggle" class="theme-toggle" type="button" aria-label="تبديل الوضع"><i class="bi bi-moon"></i></button>
        </li>
      </ul>
    </nav>
  </div>
</header>
