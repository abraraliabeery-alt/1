@extends('layouts.app')

@section('content')
  <main class="section">
    <div class="container" style="max-width:720px">
      <div class="card" style="padding:20px">
        <h2 style="margin-top:0; margin-bottom:12px">تسجيل الدخول</h2>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" style="display:grid; gap:12px">
          @csrf

          <label>
            البريد الإلكتروني
            <input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
          </label>

          <label>
            كلمة المرور
            <input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
          </label>

          <label style="display:flex; align-items:center; gap:8px">
            <input id="remember_me" type="checkbox" name="remember">
            <span>تذكرني</span>
          </label>

          <div class="cta" style="display:flex; justify-content:space-between; align-items:center; gap:8px">
            @if (Route::has('password.request'))
              <a class="btn btn-outline" href="{{ route('password.request') }}">نسيت كلمة المرور؟</a>
            @endif
            <button class="btn btn-primary" type="submit">تسجيل الدخول</button>
          </div>
        </form>
      </div>
    </div>
  </main>
@endsection
