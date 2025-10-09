@extends('layouts.app')

@section('content')
  <main class="section">
    <div class="container" style="max-width:720px">
      <div class="card" style="padding:20px">
        <h2 style="margin-top:0; margin-bottom:12px">إنشاء حساب</h2>

        <form method="POST" action="{{ route('register') }}" style="display:grid; gap:12px">
          @csrf

          <label>الاسم
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
          </label>

          <label>البريد الإلكتروني
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
          </label>

          <label>كلمة المرور
            <input id="password" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
          </label>

          <label>تأكيد كلمة المرور
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
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
