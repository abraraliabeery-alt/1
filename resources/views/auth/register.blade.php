@extends('layouts.app')

@section('content')
  <main class="section">
    <div class="container" style="max-width:720px">
      <div class="card" style="padding:20px">
        <h2 style="margin:0 0 12px">إنشاء حساب</h2>

        <form method="POST" action="{{ route('register') }}" style="display:grid; gap:12px">
          @csrf

          <label>الاسم
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="@error('name') is-invalid @enderror" />
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </label>

          <label>البريد الإلكتروني
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="@error('email') is-invalid @enderror" />
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </label>

          <label>كلمة المرور
            <input id="password" type="password" name="password" required autocomplete="new-password" class="@error('password') is-invalid @enderror" />
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </label>

          <label>تأكيد كلمة المرور
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="@error('password_confirmation') is-invalid @enderror" />
            @error('password_confirmation')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </label>

          <div class="cta" style="display:flex; justify-content:space-between; align-items:center; gap:8px">
            <a class="btn btn-outline" href="{{ route('login') }}">لديك حساب؟ تسجيل الدخول</a>
            <button class="btn btn-primary" type="submit">إنشاء حساب</button>
          </div>
        </form>
      </div>
    </div>
  </main>
@endsection
