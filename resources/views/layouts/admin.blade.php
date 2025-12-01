@extends('layouts.app')

@section('head_extra')
  <link rel="stylesheet" href="/admin.css?v={{ @filemtime(public_path('admin.css')) }}" />
@endsection

@section('content')
  <main class="section admin-shell" style="padding:0">
    <div class="container admin-grid">
      <aside aria-label="قائمة الإدارة" class="admin-aside">
        <div class="row-between" style="align-items:center; gap:8px">
          <h5 class="admin-aside-title" style="margin:0">الإدارة</h5>
        </div>
        <nav>
          <ul class="admin-nav">
            <li><a class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}" title="لوحة التحكم" aria-label="لوحة التحكم"><i class="bi bi-speedometer2"></i><span> لوحة التحكم</span></a></li>
            <li class="sep"></li>
            
            @auth
              @if(auth()->user()->is_staff)
                <!-- المحتوى -->
                <li><a class="{{ request()->routeIs('admin.services.*') ? 'active' : '' }}" href="{{ route('admin.services.index') }}" title="الخدمات" aria-label="الخدمات"><i class="bi bi-grid-1x2"></i><span> الخدمات</span></a></li>
                <li><a class="{{ request()->routeIs('admin.partners.*') ? 'active' : '' }}" href="{{ route('admin.partners.index') }}" title="شركاء النجاح" aria-label="شركاء النجاح"><i class="bi bi-people"></i><span> شركاء النجاح</span></a></li>
                <li><a class="{{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}" href="{{ route('admin.faqs.index') }}" title="الأسئلة الشائعة" aria-label="الأسئلة الشائعة"><i class="bi bi-question-circle"></i><span> الأسئلة الشائعة</span></a></li>
                <li><a class="{{ request()->routeIs('gallery.sort*') ? 'active' : '' }}" href="{{ route('gallery.sort') }}" title="إدارة الألبوم" aria-label="إدارة الألبوم"><i class="bi bi-images"></i><span> إدارة الألبوم</span></a></li>
                <li><a class="{{ request()->routeIs('admin.properties.*') ? 'active' : '' }}" href="{{ route('admin.properties.index') }}" title="إدارة العقارات" aria-label="إدارة العقارات"><i class="bi bi-building"></i><span> إدارة العقارات</span></a></li>
                <li class="sep"></li>
                <!-- التواصل -->
                <li><a class="{{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}" href="{{ route('admin.contacts.index') }}" title="رسائل التواصل" aria-label="رسائل التواصل"><i class="bi bi-envelope"></i><span> رسائل التواصل</span></a></li>
                <li class="sep"></li>
                <!-- الإعدادات -->
                <li><a class="{{ request()->routeIs('admin.settings.branding.*') ? 'active' : '' }}" href="{{ route('admin.settings.branding.edit') }}" title="الهوية والشعارات" aria-label="الهوية والشعارات"><i class="bi bi-brush"></i><span> الهوية والشعارات</span></a></li>
                <li><a class="{{ request()->routeIs('admin.settings.social.*') ? 'active' : '' }}" href="{{ route('admin.settings.social.edit') }}" title="إعدادات السوشيال" aria-label="إعدادات السوشيال"><i class="bi bi-share"></i><span> إعدادات السوشيال</span></a></li>
                <li><a class="{{ request()->routeIs('admin.settings.sections.*') ? 'active' : '' }}" href="{{ route('admin.settings.sections.edit') }}" title="إعدادات الأقسام" aria-label="إعدادات الأقسام"><i class="bi bi-sliders"></i><span> إعدادات الأقسام</span></a></li>
              @endif
              @if(optional(auth()->user())->role === 'manager')
                <li class="sep"></li>
                <!-- الإدارة -->
                <li><a class="{{ request()->routeIs('admin.users.index') ? 'active' : '' }}" href="{{ route('admin.users.index') }}" title="جميع المستخدمين" aria-label="جميع المستخدمين"><i class="bi bi-people"></i><span> جميع المستخدمين</span></a></li>
              @endif
            @endauth
          </ul>
        </nav>
      </aside>
      <section class="admin-content">
        @yield('admin')
      </section>
    </div>
  </main>
@endsection

@push('scripts')
@endpush
