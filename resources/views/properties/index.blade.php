@extends('layouts.app')

@section('content')
<h2 class="mt-4 mb-3 fw-bolder" style="color:var(--ink)">العقارات</h2>
<form method="get" class="card p-3" style="box-shadow: var(--shadow-sm)">
  <div class="row g-2">
  <div class="col-12 col-md">
    <input name="city" placeholder="المدينة" value="{{ request('city') }}" class="form-control" />
  </div>
  <div class="col-12 col-md">
  <select name="type" class="form-select">
    <option value="">النوع</option>
    @foreach(['apartment'=>'شقة','villa'=>'فيلا','land'=>'أرض','office'=>'مكتب','shop'=>'محل'] as $k=>$v)
      <option value="{{ $k }}" @selected(request('type')==$k)>{{ $v }}</option>
    @endforeach
  </select>
  </div>
  <div class="col-6 col-md"><input name="min" placeholder="أدنى سعر" value="{{ request('min') }}" class="form-control" /></div>
  <div class="col-6 col-md"><input name="max" placeholder="أعلى سعر" value="{{ request('max') }}" class="form-control" /></div>
  <div class="col-6 col-md"><input name="beds" placeholder="عدد الغرف" value="{{ request('beds') }}" class="form-control" /></div>
  <div class="col-12 d-flex gap-2 justify-content-end mt-2">
    <a href="{{ route('properties.index') }}" class="btn btn-outline-ink">إعادة ضبط</a>
    <button class="btn btn-ink">بحث</button>
  </div>
  </div>
</form>

<div class="row g-4 mt-2">
  @forelse($properties as $p)
    <div class="col-12 col-md-6 col-lg-4">
      <x-property-card :p="$p" />
    </div>
  @empty
    <div class="col-12"><div class="card p-3">لا توجد نتائج مطابقة.</div></div>
  @endforelse
  <div class="col-12">{{ $properties->links('vendor.pagination.custom') }}</div>
</div>
@endsection
