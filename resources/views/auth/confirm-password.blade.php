@extends('layouts.app')

@section('content')
  <main class="section">
    <div class="container" style="max-width:720px">
      <div class="card" style="padding:20px">
        <h2 style="margin:0 0 12px">تأكيد كلمة المرور</h2>
        <p style="color:var(--muted); margin-top:0">هذه منطقة آمنة. يرجى إدخال كلمة المرور للمتابعة.</p>

        <form method="POST" action="{{ route('password.confirm') }}" style="display:grid; gap:12px">
          @csrf

          <label>كلمة المرور
            <input id="password" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
          </label>

          <div class="cta" style="display:flex; justify-content:flex-end; gap:8px">
            <button class="btn btn-primary" type="submit">تأكيد</button>
          </div>
        </form>
      </div>
    </div>
  </main>
@endsection
