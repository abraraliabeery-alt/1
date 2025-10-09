@extends('layouts.app')

@section('content')
<section class="section">
  <div class="section-title">
    <div>
      <span class="kicker">الإدارة</span>
      <div class="accent-bar" style="margin-top:.5rem"></div>
    </div>
    <h3 style="margin:0">طلبات التسويق العقاري</h3>
  </div>

  @if(session('ok'))
    <div class="card" style="border-color:#bbf7d0; background:#f0fdf4">{{ session('ok') }}</div>
  @endif

  <div class="card" style="overflow:auto">
    <table class="table" style="width:100%">
      <thead>
        <tr>
          <th>#</th>
          <th>الاسم</th>
          <th>الجوال</th>
          <th>العنوان</th>
          <th>المدينة</th>
          <th>الحالة</th>
          <th>آخر تحديث</th>
          <th>إجراء</th>
        </tr>
      </thead>
      <tbody>
        @forelse($items as $mr)
          <tr>
            <td>{{ $mr->id }}</td>
            <td>{{ $mr->name }}</td>
            <td dir="ltr">{{ $mr->phone }}</td>
            <td>{{ $mr->property_title }}</td>
            <td>{{ $mr->city }}</td>
            <td>{{ $mr->status }}</td>
            <td>{{ optional($mr->updated_at)->format('Y-m-d') }}</td>
            <td><a class="btn btn-outline-ink btn-sm" href="{{ route('admin.marketing_requests.show', $mr) }}">عرض</a></td>
          </tr>
        @empty
          <tr><td colspan="8" class="text-center">لا توجد طلبات</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div style="margin-top:1rem">
    {{ $items->links() }}
  </div>
</section>
@endsection
