@extends('layouts.app')

@section('content')
<section class="section container py-4">
  <div class="section-title">
    <div>
      <span class="kicker">الخدمات</span>
      <div class="accent-bar" style="margin-top:.5rem"></div>
    </div>
    <h3 style="margin:0">طلب تسويق عقاري</h3>
  </div>

  @if(session('ok'))
    <div class="card" style="border-color:#bbf7d0; background:#f0fdf4">{{ session('ok') }}</div>
  @endif
  @if ($errors->any())
    <div class="card" style="border-color:#fecaca; background:#fff7f7">
      <strong>تحقق من الحقول التالية:</strong>
      <ul class="clean">
        @foreach ($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="post" action="{{ route('marketing.request.store') }}" enctype="multipart/form-data" class="fields" style="max-width:820px">
    @csrf
    <h4 class="m-0">بيانات التواصل</h4>
    <div class="row g-2 mt-1">
      <div class="col-md-6"><input class="field" name="name" value="{{ old('name', optional(auth()->user())->name) }}" placeholder="الاسم"></div>
      <div class="col-md-6"><input class="field" name="phone" value="{{ old('phone') }}" placeholder="رقم الجوال"></div>
      <div class="col-md-12"><input class="field" type="email" name="email" value="{{ old('email') }}" placeholder="البريد الإلكتروني"></div>
    </div>

    <h4 class="mt-3 m-0">بيانات العقار</h4>
    <div class="row g-2 mt-1">
      <div class="col-md-8"><input class="field" name="property_title" value="{{ old('property_title') }}" placeholder="عنوان العقار"></div>
      <div class="col-md-4">
        <select class="field" name="type">
          <option value="">نوع العقار</option>
          @foreach($types as $k=>$v)
            <option value="{{ $k }}" @selected(old('type')===$k)>{{ $v }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-6"><input class="field" name="city" value="{{ old('city') }}" placeholder="المدينة"></div>
      <div class="col-md-6"><input class="field" name="district" value="{{ old('district') }}" placeholder="الحي"></div>
      <div class="col-md-6"><input class="field" name="price" value="{{ old('price') }}" placeholder="السعر (اختياري)"></div>
      <div class="col-md-6"><input class="field" name="area" value="{{ old('area') }}" placeholder="المساحة (م²)"></div>
      <div class="col-12"><textarea class="field" name="description" rows="4" placeholder="وصف مختصر">{{ old('description') }}</textarea></div>
    </div>

    <h4 class="mt-3 m-0">مرفقات</h4>
    <div class="row g-2 mt-1">
      <div class="col-12"><input class="field" type="file" name="files[]" multiple></div>
    </div>

    <div class="mt-3">
      <button class="btn" type="submit">إرسال الطلب</button>
    </div>
  </form>
</section>
@endsection
