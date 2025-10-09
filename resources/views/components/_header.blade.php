<!-- Header / Navigation -->
<header class="header" id="top">
  <div class="container nav">
    <a class="brand" href="#top" aria-label="Top Level">
      <img src="/assets/top.png" alt="Top Level - توب ليفل للحلول التقنية" />
    </a>
    <nav class="menu" aria-label="القائمة الرئيسية">
      <button class="menu-toggle" aria-expanded="false" aria-controls="nav-list">القائمة</button>
      <ul id="nav-list">
        <li><a href="#hero">الرئيسية</a></li>
        <li><a href="#services">الخدمات</a></li>
        <li><a href="#home-solutions">المنزل الذكي</a></li>
        <li><a href="#office-solutions">المكتب الذكي</a></li>
        <li><a href="#pricing">الأسعار</a></li>
        <li><a href="{{ route('projects.index') }}">المشاريع</a></li>
        <li><a href="{{ route('gallery.index') }}">الألبوم</a></li>
        <li><a href="{{ route('events.index') }}">الفعاليات</a></li>
        <li><a href="#contact">تواصل</a></li>
        @auth
          @if(optional(auth()->user())->is_staff)
            <li><a href="{{ route('admin.marketing_requests.index') }}">طلبات التسويق</a></li>
          @endif
          @if(optional(auth()->user())->role === 'manager')
            <li><a href="{{ route('admin.users.promote.form') }}">إدارة المستخدمين</a></li>
          @endif
          <li>
            <form action="{{ route('logout') }}" method="POST" style="display:inline">
              @csrf
              <button type="submit" class="btn btn-outline">خروج</button>
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
      </ul>
    </nav>
  </div>
</header>
