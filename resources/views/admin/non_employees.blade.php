@extends('layouts.app')

@section('content')
<section class="section">
  <div class="section-title">
    <div>
      <span class="kicker">الإدارة</span>
      <div class="accent-bar" style="margin-top:.5rem"></div>
    </div>
    <h3 style="margin:0">قائمة المستخدمين غير الموظفين</h3>
  </div>

  <form method="get" action="{{ route('admin.users.non_employees') }}" class="fields" style="max-width:520px; margin-bottom:1rem">
    <input class="field" name="q" value="{{ request('q') }}" placeholder="بحث بالاسم أو البريد">
    <div>
      <button class="btn" type="submit">بحث</button>
      <a class="btn" href="{{ route('admin.users.non_employees') }}" style="margin-inline-start:.5rem">إعادة تعيين</a>
    </div>
  </form>

  @if(session('ok'))
    <div class="card" style="border-color:#bbf7d0; background:#f0fdf4">{{ session('ok') }}</div>
  @endif

  <div class="card" style="overflow:auto">
    <table class="table" style="width:100%">
      <thead>
        <tr>
          <th>الاسم</th>
          <th>البريد</th>
          <th>تاريخ التسجيل</th>
          <th>إجراء</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $u)
          <tr>
            <td>{{ $u->name }}</td>
            <td>{{ $u->email }}</td>
            <td>{{ optional($u->created_at)->format('Y-m-d') }}</td>
            <td>
              <form method="post" action="{{ route('admin.users.promote') }}" onsubmit="return confirm('ترقية {{ $u->name }} إلى موظف؟')">
                @csrf
                <input type="hidden" name="email" value="{{ $u->email }}">
                <button class="btn" type="submit">ترقية لموظف</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4" style="text-align:center">لا يوجد مستخدمون</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div style="margin-top:1rem">
    {{ $users->links() }}
  </div>
</section>
@endsection
