@extends('layouts.admin')

@section('admin')
  <div class="admin-header">
    <div class="title">
      <h1>الرسائل الواردة</h1>
      <div class="subtitle">الإجمالي: {{ $contacts->total() }}</div>
    </div>
    <div class="tools"></div>
  </div>

  <div class="card" style="padding:0">
    <div class="table-responsive">
      <table class="table modern compact">
        <colgroup>
          <col style="width:60px">
          <col style="width:12%">
          <col style="width:16%">
          <col style="width:30%">
          <col style="width:20%">
          <col style="width:8%">
          <col style="width:10%">
          <col style="width:10%">
          <col style="width:14%">
        </colgroup>
        <thead>
          <tr>
            <th style="width:70px">#</th>
            <th>المرسل</th>
            <th>التواصل</th>
            <th>الرسالة</th>
            <th>ملاحظة</th>
            <th style="width:140px">الحالة</th>
            <th style="width:180px">المتابعة</th>
            <th style="width:160px">التحديث</th>
            <th style="width:200px">إجراءات</th>
          </tr>
        </thead>
        <tbody>
          @forelse($contacts as $c)
            <tr>
              <td>{{ $c->id }}</td>
              <td>
                <div style="font-weight:700">{{ $c->name }}</div>
                @if($c->company)
                  <div class="text-muted" style="font-size:12px">{{ $c->company }}</div>
                @endif
              </td>
              <td>
                <div class="wrap"><a href="mailto:{{ $c->email }}">{{ $c->email }}</a></div>
                @if($c->phone)
                  <div class="text-muted wrap">{{ $c->phone }}</div>
                @endif
              </td>
              <td class="wrap" title="{{ $c->message }}">{{ $c->message }}</td>
              <td class="wrap" title="{{ $c->note }}">{{ $c->note }}</td>
              <td>
                @php($st = $c->status ?? 'new')
                @php($stLabel = $st==='new' ? 'جديد' : ($st==='in_progress' ? 'قيد المتابعة' : 'مغلقة'))
                <span class="badge {{ $st==='new'?'draft':($st==='in_progress'?'published':'') }}">{{ $stLabel }}</span>
              </td>
              <td>
                <div class="text-muted" style="font-size:12px">{{ optional($c->follow_up_at)->format('Y-m-d H:i') ?: '—' }}</div>
                <div style="font-size:12px">{{ optional($c->assignedEmployee)->name ?: '' }}</div>
              </td>
              <td class="wrap">{{ optional($c->updated_at)->format('Y-m-d H:i:s') }}</td>
              <td class="text-end" style="white-space:nowrap">
                <div class="actions-vertical">
                  <a class="btn btn-outline btn-sm" href="{{ route('admin.contacts.show', $c) }}" title="عرض التفاصيل"><i class="bi bi-eye"></i></a>
                  <form action="{{ route('admin.contacts.destroy', $c) }}" method="POST" data-confirm="حذف الرسالة؟">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" type="submit" title="حذف"><i class="bi bi-trash"></i></button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr><td colspan="9" class="text-center text-muted">لا توجد رسائل.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div style="margin-top:12px">{{ $contacts->links() }}</div>
@endsection
