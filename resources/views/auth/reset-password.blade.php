@extends('layouts.app')

@section('content')
  <main class="section">
    <div class="container" style="max-width:720px">
      <div class="card" style="padding:20px">
        <h2 style="margin:0 0 12px">تعيين كلمة مرور جديدة</h2>

        <form method="POST" action="{{ route('password.store') }}" style="display:grid; gap:12px">
          @csrf

          <input type="hidden" name="token" value="{{ $request->route('token') }}">

          <label>البريد الإلكتروني
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" class="@error('email') is-invalid @enderror" />
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </label>

          <label>كلمة المرور الجديدة
            <input id="password" type="password" name="password" required autocomplete="new-password" class="@error('password') is-invalid @enderror" />
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </label>

          <label>تأكيد كلمة المرور
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="@error('password_confirmation') is-invalid @enderror" />
            @error('password_confirmation')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </label>

          <div class="cta" style="display:flex; justify-content:flex-end; gap:8px">
            <button class="btn btn-primary" type="submit">تعيين كلمة المرور</button>
          </div>
        </form>
      </div>
    </div>
  </main>
@endsection
