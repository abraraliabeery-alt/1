@extends('layouts.admin')

@section('admin')
  <div class="admin-header">
    <div class="title">
      <h1>شركاء التقنية</h1>
    </div>
    <div class="tools">
      <a class="btn btn-primary" href="{{ route('admin.partners.create') }}">+ شريك جديد</a>
    </div>
  </div>

  <form method="get" class="row-between" style="gap:8px; margin:12px 0">
    <input type="search" name="q" value="{{ request('q') }}" placeholder="بحث بالاسم أو الموقع" />
    <button class="btn btn-outline" type="submit">بحث</button>
  </form>

  <div class="table-responsive">
    <table class="table modern compact">
      <thead>
        <tr>
          <th>#</th>
          <th>الاسم</th>
          <th>الموقع</th>
          <th>الحالة</th>
          <th>ترتيب</th>
          <th style="width:90px">إجراءات</th>
        </tr>
      </thead>
      <tbody>
        @forelse($partners as $p)
          <tr>
            <td>{{ $p->id }}</td>
            <td>{{ $p->name }}</td>
            <td><a href="{{ $p->website_url }}" target="_blank">{{ $p->website_url }}</a></td>
            <td><span class="badge">{{ $p->status }}</span></td>
            <td>{{ $p->sort_order }}</td>
            <td class="text-end">
              <div class="actions-vertical">
                <a class="btn btn-outline btn-sm" href="{{ $p->website_url ?: route('admin.partners.edit', $p) }}" target="_blank" title="عرض"><i class="bi bi-eye"></i></a>
                <a class="btn btn-outline btn-sm" href="{{ route('admin.partners.edit', $p) }}" title="تعديل"><i class="bi bi-pencil"></i></a>
                <form action="{{ route('admin.partners.destroy', $p) }}" method="POST" onsubmit="return confirm('حذف الشريك؟');">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger btn-sm" type="submit" title="حذف"><i class="bi bi-trash"></i></button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="text-center text-muted">لا يوجد شركاء.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $partners->links() }}
@endsection
