@extends('layouts.app')

@section('content')
  <main class="section">
    <div class="container" style="max-width:720px">
      <div class="card" style="padding:20px">
        <h2 style="margin:0 0 12px">تأكيد البريد الإلكتروني</h2>
        <p style="color:var(--muted); margin-top:0">شكراً لتسجيلك! يرجى النقر على رابط التحقق الذي أرسلناه إلى بريدك الإلكتروني. لم يصلك؟ أعد الإرسال أدناه.</p>

        @if (session('status') == 'verification-link-sent')
          <div class="card" style="border-color:#22c55e; background:#f0fff4; margin-bottom:12px">
            تم إرسال رابط تحقق جديد إلى بريدك.
          </div>
        @endif

        <div class="cta" style="display:flex; justify-content:space-between; align-items:center; gap:8px">
          <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button class="btn btn-primary" type="submit">إعادة إرسال رابط التحقق</button>
          </form>

          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline">خروج</button>
          </form>
        </div>
      </div>
    </div>
  </main>
@endsection
