<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name','بوابة الإبداع العقارية') }}</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
  </head>
  <body class="bg-slate-50 text-slate-800 font-sans">
    <!-- Header -->
    <header class="sticky top-0 z-40 bg-white/90 backdrop-blur border-b border-slate-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center gap-2 font-extrabold text-slate-800">
          <img src="/logo.png" class="w-7 h-7 rounded-lg hidden sm:block" onerror="this.style.display='none'" alt="logo">
          <span>{{ config('app.name','بوابة الإبداع العقارية') }}</span>
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
              <button class="btn btn-outline" type="submit">خروج</button>
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
        <span>© {{ date('Y') }} {{ config('app.name','بوابة الإبداع العقارية') }}</span>
        <div class="flex items-center gap-2">
          <a class="btn btn-outline" href="{{ route('properties.index') }}">العقارات</a>
          <a class="btn btn-outline" href="#contact">تواصل</a>
        </div>
      </div>
    </footer>

    <!-- Minimal CSS helpers (no build step needed) -->
    <style>
      .btn{ display:inline-flex; align-items:center; gap:.5rem; border:1px solid transparent; background:#0f172a; color:#fff; padding:.5rem 1rem; border-radius:.6rem; font-weight:800; font-size:.9rem; box-shadow:0 1px 2px rgba(0,0,0,.08); transition:transform .15s ease, box-shadow .15s ease }
      .btn:hover{ transform:translateY(-1px); box-shadow:0 6px 16px rgba(0,0,0,.12) }
      .btn-outline{ background:#fff; color:#0f172a; border-color:#e5e7eb }
      .card{ border:1px solid #e5e7eb; background:#fff; border-radius:14px; box-shadow:0 1px 2px rgba(17,24,39,.06) }
      .field{ height:44px; border:1px solid #e5e7eb; background:#fff; border-radius:.6rem; padding:.5rem .75rem; outline:none }
      .muted{ color:#64748b }
      .grid-3{ display:grid; gap:1rem }
      @media (min-width:768px){ .grid-3{ grid-template-columns: repeat(2, minmax(0,1fr)) } }
      @media (min-width:1024px){ .grid-3{ grid-template-columns: repeat(3, minmax(0,1fr)) } }
      .bg-navy{ background:#0b2f4a; color:#fff }
      .text-navy{ color:#0b2f4a }
      .section-title{ display:flex; align-items:flex-end; justify-content:space-between; margin-bottom:.5rem }
    </style>
  </body>
</html>
