<!-- Header / Simple top navigation -->
<header class="header" id="top">
  <div class="container nav">
    @php($hasSettings = \Illuminate\Support\Facades\Schema::hasTable('settings'))
    <a class="brand" href="{{ url('/') }}#top" aria-label="Top Level">
      <img src="/img/logo/1.png" class="logo-light" alt="الشعار" />
      <img src="/img/logo/2.png" class="logo-dark" alt="الشعار (الوضع الداكن)" />
    </a>
    <nav class="menu" aria-label="القائمة الرئيسية">
      <button class="menu-toggle" type="button" aria-label="فتح/إغلاق القائمة" aria-expanded="false">
        <i class="bi bi-list"></i>
      </button>
      <ul id="nav-list">
        <li><a href="{{ url('/') }}#hero">الرئيسية</a></li>
        <li><a href="{{ route('products.index') }}">المنتجات</a></li>
        <li><a href="{{ route('properties.index') }}">العقارات</a></li>
        <li><a href="{{ url('/') }}#services">منتجاتنا</a></li>
        <li><a href="{{ url('/') }}#about-brief">من نحن</a></li>
        <li><a href="{{ url('/') }}#contact">تواصل</a></li>
        @auth
          @if(optional(auth()->user())->is_staff || optional(auth()->user())->role === 'manager')
            <li>
              <a class="btn btn-primary" href="{{ url('/admin') }}" aria-label="لوحة التحكم">
                <i class="bi bi-speedometer2" aria-hidden="true"></i>
                <span>لوحة التحكم</span>
              </a>
            </li>
          @endif
          <li>
            <form action="{{ route('logout') }}" method="POST" style="display:inline">
              @csrf
              <button type="submit" class="btn btn-primary" aria-label="تسجيل الخروج">
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
    <!-- Mobile drawer -->
    <div class="drawer-overlay" id="drawer-overlay" hidden></div>
    <aside class="drawer" id="mobile-drawer" aria-hidden="true">
      <div class="drawer-header">
        <strong>القائمة</strong>
        <button class="drawer-close" type="button" aria-label="إغلاق"><i class="bi bi-x"></i></button>
      </div>
      <nav class="drawer-nav" aria-label="القائمة الجانبية">
        <ul>
          <li><a href="{{ url('/') }}#hero">الرئيسية</a></li>
          <li><a href="{{ route('products.index') }}">المنتجات</a></li>
          <li><a href="{{ route('properties.index') }}">العقارات</a></li>
          <li><a href="{{ url('/') }}#services">منتجاتنا</a></li>
          <li><a href="{{ url('/') }}#about-brief">من نحن</a></li>
          <li><a href="{{ url('/') }}#contact">تواصل</a></li>
        </ul>
      </nav>
    </aside>
  </div>
</header>
