@extends('layouts.app')

@section('content')
<section class="section">
  <div class="section-title">
    <div>
      <span class="kicker">إضافة</span>
      <div class="accent-bar" style="margin-top:.5rem"></div>
    </div>
    <h3 style="margin:0">إضافة عقار</h3>
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

  <form action="{{ route('properties.store') }}" method="post" enctype="multipart/form-data" class="fields">
    @csrf
    <div class="fields" style="grid-template-columns: 1fr 1fr">
      <input class="field" name="title" value="{{ old('title') }}" placeholder="عنوان العقار" required>
      <select class="field" name="type" required>
        <option value="">النوع</option>
        @foreach(['apartment'=>'شقة','villa'=>'فيلا','land'=>'أرض','office'=>'مكتب','shop'=>'محل'] as $k=>$v)
          <option value="{{ $k }}" @selected(old('type')===$k)>{{ $v }}</option>
        @endforeach
      </select>
      {{-- المدينة قائمة ثابتة (الرياض) --}}
      <select class="field" name="city" required>
        <option value="">اختر المدينة</option>
        <option value="الرياض" @selected(old('city')==='الرياض')>الرياض</option>
      </select>
      {{-- أحياء الرياض --}}
      @php($riyadhDistricts = [
        'العليا','الملز','السويدي','النخيل','الورود','الياسمين','العقيق','حطين','الصحافة','المروج','السلام','المصيف','السليمانية','المعذر','القيروان','الحمراء','النهضة','المونسية','قرطبة','اليرموك','الفلاح','التعاون','الريان','الروضة','العزيزية','العزيزية الجنوبية','الشفا','البديعة','النسيم','غرناطة','ظهرة لبن','لبن','عرقة','طويق','نمار','ديراب','العريجاء','أشبيليا','المروة','النرجس','الندى','الياسمين الشمالي','الياسمين الجنوبي','الواحة','الرائد','الغدير','المعالي','العليا الشمالية','العليا الجنوبية'
      ])
      <select class="field" name="district" required>
        <option value="">اختر الحي</option>
        @foreach($riyadhDistricts as $d)
          <option value="{{ $d }}" @selected(old('district')===$d)>{{ $d }}</option>
        @endforeach
      </select>
      <input class="field" type="number" name="price" value="{{ old('price') }}" placeholder="السعر" required>
      <input class="field" type="number" name="area" value="{{ old('area') }}" placeholder="المساحة (م²)">
      <input class="field" type="number" name="bedrooms" value="{{ old('bedrooms') }}" placeholder="عدد الغرف">
      <input class="field" type="number" name="bathrooms" value="{{ old('bathrooms') }}" placeholder="عدد الحمامات">
    </div>
    <textarea class="field" name="description" rows="4" placeholder="وصف مختصر">{{ old('description') }}</textarea>
    <div>
      <label class="btn outline" style="cursor:pointer">
        <input type="file" name="cover" accept="image/*" hidden>
        رفع صورة الغلاف
      </label>
      <span class="muted">صيغ: jpg, png, webp — حد أقصى 4MB</span>
    </div>

    <div>
      <label class="btn outline" style="cursor:pointer">
        <input id="galleryInputCreate" type="file" name="gallery[]" accept="image/*" multiple hidden>
        إضافة صور للمعرض (متعددة)
      </label>
      <div class="muted" style="margin-top:.25rem; font-size:.9rem">يمكنك اختيار عدة صور دفعة واحدة. صيغ: jpg, png, webp — كل ملف حتى 4MB</div>
      <div id="galleryPreviewCreate" style="display:flex; gap:.5rem; flex-wrap:wrap; margin-top:.5rem"></div>
    </div>

    <div class="fields" style="grid-template-columns: 1fr">
      <input class="field" type="url" name="location_url" value="{{ old('location_url') }}" placeholder="رابط الموقع على الخريطة (اختياري)">
      <div class="muted" style="margin-top:.25rem; font-size:.9rem">مثال: رابط Google Maps للموقع الدقيق للعقار</div>
    </div>

    <div class="fields" style="grid-template-columns: 1fr 1fr">
      <div>
        <input class="field" type="url" name="video_url" value="{{ old('video_url') }}" placeholder="رابط فيديو من يوتيوب (اختياري)">
        <div class="muted" style="margin-top:.25rem; font-size:.9rem">يمكنك إدخال رابط يوتيوب أو تركه فارغًا واستخدام خيار الرفع</div>
      </div>
      <div>
        <label class="btn outline" style="cursor:pointer">
          <input type="file" name="video" accept="video/mp4,video/webm" hidden>
          رفع ملف فيديو (MP4/WebM)
        </label>
        <div class="muted" style="margin-top:.25rem; font-size:.9rem">إذا أدخلت رابطًا فلا يلزم رفع ملف، والعكس صحيح</div>
      </div>
    </div>
    {{-- المميزات --}}
    @php($amenityOptions = [
      'parking' => ['label' => 'موقف سيارات', 'icon' => 'bx-parking'],
      'elevator' => ['label' => 'مصعد', 'icon' => 'bx-elevator'],
      'pool' => ['label' => 'مسبح', 'icon' => 'bx-water'],
      'garden' => ['label' => 'حديقة', 'icon' => 'bx-leaf'],
      'maid' => ['label' => 'غرفة خادمة', 'icon' => 'bx-female-sign'],
      'furnished' => ['label' => 'مؤثثة', 'icon' => 'bx-chair'],
      'ac' => ['label' => 'تكييف مركزي', 'icon' => 'bx-wind'],
      'security' => ['label' => 'حراسة', 'icon' => 'bx-shield'],
      'balcony' => ['label' => 'شرفة', 'icon' => 'bx-building-house'],
      'rooftop' => ['label' => 'سطح', 'icon' => 'bx-home-alt-2'],
    ])
    <div class="card" style="margin-top:.5rem">
      <div class="fw-bolder mb-2" style="color:var(--ink)">المميزات</div>
      <div class="row g-2">
        @foreach($amenityOptions as $key=>$opt)
          <div class="col-6 col-md-4">
            <label class="d-flex align-items-center gap-2" style="cursor:pointer">
              <input type="checkbox" name="amenities[]" value="{{ $key }}" @checked(collect(old('amenities',[]))->contains($key))>
              <i class='bx {{ $opt['icon'] }}'></i>
              <span>{{ $opt['label'] }}</span>
            </label>
          </div>
        @endforeach
      </div>
    </div>
    <div>
      <button class="btn" type="submit">حفظ العقار</button>
      <a href="{{ route('properties.my') }}" class="btn outline">إلغاء</a>
    </div>
  </form>
</section>
<script>
  (function(){
    const input = document.getElementById('galleryInputCreate');
    const preview = document.getElementById('galleryPreviewCreate');
    if (!input || !preview) return;
    input.addEventListener('change', function(){
      preview.innerHTML = '';
      const files = Array.from(this.files || []);
      files.forEach(file => {
        if(!file.type.startsWith('image/')) return;
        const reader = new FileReader();
        reader.onload = e => {
          const img = document.createElement('img');
          img.src = e.target.result;
          img.style.width = '80px';
          img.style.height = '80px';
          img.style.objectFit = 'cover';
          img.style.borderRadius = '8px';
          img.style.boxShadow = '0 0 0 1px rgba(0,0,0,.06)';
          preview.appendChild(img);
        };
        reader.readAsDataURL(file);
      });
    });
  })();
  </script>
@endsection
