@extends('layouts.admin')

@section('admin')
  <div class="admin-header">
    <div class="title">
      <h1>المستخدمون غير الموظفين</h1>
    </div>
    <div class="tools">
      <form method="get" action="{{ route('admin.users.non_employees') }}" class="admin-search">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="بحث بالاسم أو البريد" />
        <button class="btn btn-outline" type="submit">بحث</button>
        <a class="btn btn-outline" href="{{ route('admin.users.non_employees') }}">إعادة تعيين</a>
      </form>
    </div>
  </div>

  @if(session('ok'))
    <div class="alert alert-success" role="status"><strong>تم:</strong> {{ session('ok') }}</div>
  @endif

  <div class="table-responsive">
    <table class="table modern compact" style="width:100%">
      <thead>
        <tr>
          <th style="width:40%">الاسم</th>
          <th style="width:40%">البريد</th>
          <th style="width:20%">إجراء</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $u)
          <tr>
            <td>{{ $u->name }}</td>
            <td>{{ $u->email }}</td>
            <td class="text-end">
              <form method="post" action="{{ route('admin.users.promote') }}" style="display:inline" onsubmit="return confirm('ترقية {{ $u->name }} إلى موظف؟')">
                @csrf
                <input type="hidden" name="email" value="{{ $u->email }}">
                <button class="btn btn-primary" type="submit">ترقية لموظف</button>
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

  <div style="margin-top:12px">{{ $users->links() }}</div>
@endsection
