@extends('layouts.admin')

@section('admin')
  <div class="admin-header">
    <div class="title">
      <h1>الخدمات</h1>
    </div>
    <div class="tools">
      <a class="btn btn-primary" href="{{ route('admin.services.create') }}">+ خدمة جديدة</a>
    </div>
  </div>

  <form method="get" class="row-between" style="gap:8px; margin:12px 0">
    <input type="search" name="q" value="{{ request('q') }}" placeholder="بحث" />
    <button class="btn btn-outline" type="submit">بحث</button>
  </form>

  <div class="table-responsive">
    <table class="table modern compact">
      <thead>
        <tr>
          <th>#</th>
          <th>العنوان</th>
          <th>الحالة</th>
          <th>بارز</th>
          <th>ترتيب</th>
          <th style="width:90px">إجراءات</th>
        </tr>
      </thead>
      <tbody>
        @forelse($services as $svc)
          <tr>
            <td>{{ $svc->id }}</td>
            <td><a href="{{ route('admin.services.edit', $svc) }}">{{ $svc->title }}</a></td>
            <td><span class="badge">{{ $svc->status }}</span></td>
            <td>{{ $svc->is_featured ? 'نعم' : 'لا' }}</td>
            <td>{{ $svc->sort_order }}</td>
            <td class="text-end">
              <div class="actions-vertical">
                <a class="btn btn-outline btn-sm" href="{{ route('services.show', $svc->slug) }}" target="_blank" title="عرض"><i class="bi bi-eye"></i></a>
                <a class="btn btn-outline btn-sm" href="{{ route('admin.services.edit', $svc) }}" title="تعديل"><i class="bi bi-pencil"></i></a>
                <form action="{{ route('admin.services.destroy', $svc) }}" method="POST" onsubmit="return confirm('حذف الخدمة؟');">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger btn-sm" type="submit" title="حذف"><i class="bi bi-trash"></i></button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="text-center text-muted">لا توجد خدمات.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $services->links() }}
@endsection
