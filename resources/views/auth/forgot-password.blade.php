@extends('layouts.app')

@section('content')
  <main class="section">
    <div class="container" style="max-width:720px">
      <div class="card" style="padding:20px">
        <h2 style="margin:0 0 12px">إعادة تعيين كلمة المرور</h2>
        <p style="color:var(--muted); margin-top:0">أدخل بريدك الإلكتروني وسنرسل لك رابط إعادة التعيين.</p>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" style="display:grid; gap:12px">
          @csrf

          <label>البريد الإلكتروني
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="@error('email') is-invalid @enderror" />
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </label>

          <div class="cta" style="display:flex; justify-content:flex-end; gap:8px">
            <button class="btn btn-primary" type="submit">إرسال رابط الاستعادة</button>
          </div>
        </form>
      </div>
    </div>
  </main>
@endsection
