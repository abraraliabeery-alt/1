@extends('layouts.admin')

@section('admin')
  <div class="admin-header">
    <div class="title">
      <h1>جميع المستخدمين</h1>
    </div>
    <div class="tools">
      <form method="get" action="{{ route('admin.users.index') }}" class="admin-search">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="بحث بالاسم أو البريد" />
        <select name="staff" style="padding:6px 10px; border-radius:10px; border:1px solid var(--admin-border); height:34px">
          <option value="">الكل</option>
          <option value="1" @selected(request('staff')==='1')>الموظفون فقط</option>
          <option value="0" @selected(request('staff')==='0')>غير الموظفين</option>
        </select>
        <button class="btn btn-outline" type="submit">بحث</button>
        <a class="btn btn-outline" href="{{ route('admin.users.index') }}">إعادة تعيين</a>
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
          <th style="width:30%"><a href="#" data-sort="name">الاسم</a></th>
          <th style="width:30%"><a href="#" data-sort="email">البريد</a></th>
          <th style="width:20%"><a href="#" data-sort="is_staff">حالة</a></th>
          <th style="width:20%"><a href="#" data-sort="created_at">أُضيف</a></th>
        </tr>
      </thead>
      <tbody id="users-body">
        @include('admin.partials.users_tbody')
      </tbody>
    </table>
  </div>

  <div style="margin-top:12px">{{ $users->links() }}</div>
  @push('scripts')
  <script>
    (function(){
      const body = document.getElementById('users-body');
      const headers = document.querySelectorAll('thead a[data-sort]');
      let dir = new URLSearchParams(location.search).get('dir') || 'desc';
      let sort = new URLSearchParams(location.search).get('sort') || 'created_at';
      headers.forEach(a=>{
        a.addEventListener('click', function(ev){
          ev.preventDefault();
          const newSort = this.dataset.sort;
          dir = (sort===newSort && dir==='desc') ? 'asc' : 'desc';
          sort = newSort;
          const params = new URLSearchParams(location.search);
          params.set('sort', sort); params.set('dir', dir);
          fetch(`${location.pathname}?${params.toString()}`, { headers: { 'X-Requested-With':'XMLHttpRequest' } })
            .then(r=>r.text())
            .then(html=>{ body.innerHTML = html; history.replaceState({}, '', `${location.pathname}?${params.toString()}`); })
            .catch(console.error);
        });
      });
    })();
  </script>
  @endpush
@endsection
