@extends('layouts.app')

@section('content')
  <main class="section">
    <div class="container" style="max-width:720px">
      <div class="card" style="padding:20px">
        <h2 style="margin:0 0 12px">تسجيل الدخول</h2>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" style="display:grid; gap:12px">
          @csrf

          <label>
            البريد الإلكتروني
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="@error('email') is-invalid @enderror" />
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </label>

          <label>
            كلمة المرور
            <input id="password" type="password" name="password" required autocomplete="current-password" class="@error('password') is-invalid @enderror" />
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
