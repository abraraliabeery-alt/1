@extends('layouts.admin')

@section('admin')
  <div class="admin-header">
    <div class="title">
      <h1>المناقصات</h1>
      <p class="text-muted">إدارة المناقصات وعرض نموذج example لكل مناقصة</p>
    </div>
    <div class="tools">
      <a class="btn" href="{{ route('admin.tenders.create') }}">إنشاء مناقصة</a>
      <a class="btn btn-outline" href="{{ route('admin.tenders.example', optional($tenders->first())->id ?? 1) }}" target="_blank">معاينة example لأحدث مناقصة</a>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table modern compact">
      <thead>
        <tr>
          <th>#</th>
          <th>العنوان</th>
          <th>الجهة</th>
          <th>رقم المنافسة</th>
          <th>تاريخ التقديم</th>
          <th style="width:180px">إجراءات</th>
        </tr>
      </thead>
      <tbody>
        @forelse($tenders as $t)
          <tr>
            <td>{{ $t->id }}</td>
            <td class="text-strong">{{ $t->title }}</td>
            <td>{{ $t->client_name }}</td>
            <td>{{ $t->competition_no }}</td>
            <td>{{ optional($t->submission_date)->format('Y-m-d') }}</td>
            <td class="text-end">
              <div class="actions-vertical">
                <a class="btn btn-outline btn-sm" href="{{ route('admin.tenders.example', $t) }}" target="_blank" title="معاينة example"><i class="bi bi-file-earmark-text"></i></a>
                <a class="btn btn-outline btn-sm" href="{{ route('admin.tenders.pdf.preview', $t) }}" target="_blank" title="معاينة PDF"><i class="bi bi-eye"></i></a>
                <a class="btn btn-outline btn-sm" href="{{ route('admin.tenders.pdf.download', $t) }}" title="تحميل PDF"><i class="bi bi-download"></i></a>
              </div>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="text-center text-muted">لا توجد مناقصات.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $tenders->links() }}
@endsection
