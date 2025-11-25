@extends('layouts.admin')

@section('admin')
  <div class="admin-header">
    <div class="title">
      <h1>الأسئلة الشائعة</h1>
    </div>
    <div class="tools">
      <a class="btn btn-primary" href="{{ route('admin.faqs.create') }}">إضافة سؤال</a>
    </div>
  </div>

  @if(session('ok'))
    <div class="card" style="margin:12px 0; border-color:#22c55e"><strong>تم:</strong> {{ session('ok') }}</div>
  @endif

  <div class="table-responsive">
    <table class="table modern compact" style="width:100%">
      <thead>
        <tr>
          <th style="width:56px">#</th>
          <th>السؤال</th>
          <th style="width:120px">الحالة</th>
          <th style="width:120px">الترتيب</th>
          <th style="width:200px">إجراءات</th>
        </tr>
      </thead>
      <tbody>
        @forelse($faqs as $f)
          <tr>
            <td>{{ $f->id }}</td>
            <td style="max-width:520px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis">{{ $f->question }}</td>
            <td>{{ $f->status === 'published' ? 'منشور' : 'مسودة' }}</td>
            <td>{{ $f->sort_order }}</td>
            <td class="text-end">
              <div class="actions-vertical">
                <a class="btn btn-outline btn-sm" href="{{ route('admin.faqs.edit', $f) }}">تعديل</a>
                <form action="{{ route('admin.faqs.destroy', $f) }}" method="POST" data-confirm="حذف؟">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger btn-sm" type="submit">حذف</button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr><td colspan="5" class="text-center text-muted">لا توجد أسئلة حالياً.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div style="margin-top:12px">{{ $faqs->links() }}</div>
@endsection
