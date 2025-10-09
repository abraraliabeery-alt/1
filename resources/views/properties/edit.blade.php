@extends('layouts.app')

@section('content')
<section class="section">
  <div class="section-title">
    <div>
      <span class="kicker">تعديل</span>
      <div class="accent-bar" style="margin-top:.5rem"></div>
    </div>
    <h3 style="margin:0">تعديل عقار</h3>
  </div>
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
  @if (session('ok'))
    <div class="card" style="border-color:#bbf7d0; background:#f0fdf4">{{ session('ok') }}</div>
  @endif

  <form action="{{ route('properties.update', $property) }}" method="post" enctype="multipart/form-data" class="fields">
    @csrf
    @method('PUT')
    <div class="fields" style="grid-template-columns: 1fr 1fr">
      <input class="field" name="title" value="{{ old('title', $property->title) }}" placeholder="عنوان العقار" required>
      <select class="field" name="type" required>
        <option value="">النوع</option>
        @foreach(['apartment'=>'شقة','villa'=>'فيلا','land'=>'أرض','office'=>'مكتب','shop'=>'محل'] as $k=>$v)
          <option value="{{ $k }}" @selected(old('type', $property->type)===$k)>{{ $v }}</option>
        @endforeach
      </select>
      {{-- تثبيت المدينة إلى الرياض --}}
      <input type="hidden" name="city" value="الرياض">
      <input class="field" value="الرياض" placeholder="المدينة" disabled>
      {{-- أحياء الرياض --}}
      @php($riyadhDistricts = [
        'العليا','الملز','السويدي','النخيل','الورود','الياسمين','العقيق','حطين','الصحافة','المروج','السلام','المصيف','السليمانية','المعذر','القيروان','الحمراء','النهضة','المونسية','قرطبة','اليرموك','الفلاح','التعاون','الريان','الروضة','العزيزية','العزيزية الجنوبية','الشفا','البديعة','النسيم','غرناطة','ظهرة لبن','لبن','عرقة','طويق','نمار','ديراب','العريجاء','أشبيليا','المروة','النرجس','الندى','الياسمين الشمالي','الياسمين الجنوبي','الواحة','الرائد','الغدير','المعالي','العليا الشمالية','العليا الجنوبية'
      ])
      <select class="field" name="district" required>
        <option value="">اختر الحي</option>
        @foreach($riyadhDistricts as $d)
          <option value="{{ $d }}" @selected(old('district', $property->district)===$d)>{{ $d }}</option>
        @endforeach
      <input class="field" type="number" name="price" value="{{ old('price', $property->price) }}" placeholder="السعر" required>
      <input class="field" type="number" name="area" value="{{ old('area', $property->area) }}" placeholder="المساحة (م²)">
      <input class="field" type="number" name="bedrooms" value="{{ old('bedrooms', $property->bedrooms) }}" placeholder="عدد الغرف">
      <input class="field" type="number" name="bathrooms" value="{{ old('bathrooms', $property->bathrooms) }}" placeholder="عدد الحمامات">
    </div>
    <textarea class="field" name="description" rows="4" placeholder="وصف مختصر">{{ old('description', $property->description) }}</textarea>
    </div>
    <div class="fields" style="grid-template-columns: 1fr">
      <input class="field" type="url" name="location_url" value="{{ old('location_url', $property->location_url) }}" placeholder="رابط الموقع على الخريطة (اختياري)">
      <div class="muted" style="margin-top:.25rem; font-size:.9rem">مثال: رابط Google Maps للموقع الدقيق للعقار</div>
    </div>
    <div class="fields" style="grid-template-columns: 1fr 1fr">
      <div>
        <label class="btn outline" style="cursor:pointer">
          <input type="file" name="video" accept="video/mp4,video/webm" hidden>
          @if($property->video_path)
            تغيير ملف الفيديو (الحالي محفوظ)
          @else
            رفع ملف فيديو (MP4/WebM)
          @endif
        </label>
        <div class="muted" style="margin-top:.25rem; font-size:.9rem">إذا أدخلت رابطًا فلا يلزم رفع ملف، والعكس صحيح</div>
        @if($property->video_path)
          <div class="muted" style="margin-top:.25rem; font-size:.9rem">الفيديو الحالي: {{ $property->video_path }}</div>
        @endif
      </div>
    </div>
    <div>
      <button class="btn" type="submit">حفظ التغييرات</button>
      <a href="{{ route('properties.my') }}" class="btn outline">إلغاء</a>
    </div>
  </form>
</section>
@endsection
