@extends('layouts.admin')

@section('content')
<section class="section">
  <div class="section-title">
    <div>
      <span class="kicker">الإدارة</span>
      <div class="accent-bar" style="margin-top:.5rem"></div>
    </div>
    <h3 style="margin:0">ترقية مستخدم إلى موظف</h3>
  </div>

  @if(session('ok'))
    <div class="card" style="border-color:#bbf7d0; background:#f0fdf4">{{ session('ok') }}</div>
  @endif
  @if ($errors->any())
    <div class="card" style="border-color:#fecaca; background:#fff7f7">
      <strong>تحقق من الحقول التالية:</strong>
      <ul class="clean">
        @foreach ($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="post" action="{{ route('admin.users.promote') }}" class="fields" style="max-width:520px">
    @csrf
    <input class="field" name="email" type="email" placeholder="بريد المستخدم" required>
    <div>
      <button class="btn" type="submit">ترقية إلى موظف</button>
    </div>
  </form>
</section>
@endsection
