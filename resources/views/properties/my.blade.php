@extends('layouts.app')

@section('content')
<section class="container py-4">
  <div class="d-flex flex-column flex-md-row align-items-end justify-content-between gap-2 mb-3">
    <div>
      <h2 class="m-0 fw-bolder" style="color:var(--ink)">عقاراتي</h2>
      <div class="text-muted">إدارة وإضافة عقاراتك بسهولة</div>
    </div>
    <div>
      <a href="#" class="btn btn-ink" data-bs-toggle="modal" data-bs-target="#createPropertyModal">إضافة عقار</a>
    </div>
  </div>
  @if (session('ok'))
    <div class="card" style="border-color:#bbf7d0; background:#f0fdf4; margin-bottom:.75rem">{{ session('ok') }}</div>
  @endif
  <div class="row g-4">
    @forelse($properties as $p)
      <div class="col-12 col-md-6 col-lg-4">
        <x-property-card :p="$p" />
        <div class="d-flex gap-2 mt-2">
          <a href="{{ route('properties.edit', $p) }}" class="btn btn-beige">تعديل</a>
          <form action="{{ route('properties.destroy', $p) }}" method="post" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-ink">حذف</button>
          </form>
        </div>
      </div>
    @empty
      <div class="col-12"><div class="card p-3">لا توجد عقارات بعد. ابدأ بإضافة أول عقار.</div></div>
    @endforelse
    <div class="col-12 mt-2">{{ $properties->links('vendor.pagination.custom') }}</div>
  </div>
</section>

<!-- Create Property Modal -->
<div class="modal fade" id="createPropertyModal" tabindex="-1" aria-labelledby="createPropertyLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bolder" id="createPropertyLabel" style="color:var(--ink)">إضافة عقار</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('properties.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          @if ($errors->any())
            <div class="alert alert-danger">
              <div class="fw-bold mb-1">تحقق من الحقول التالية:</div>
              <ul class="mb-0">
                @foreach ($errors->all() as $e)
                  <li>{{ $e }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          @if (session('ok'))
            <div class="alert alert-success mb-3">{{ session('ok') }}</div>
          @endif

          <div class="row g-3">
            <div class="col-md-6">
              <input class="form-control" name="title" value="{{ old('title') }}" placeholder="عنوان العقار" required>
            </div>
            <div class="col-md-6">
              <select class="form-select" name="type" required>
                <option value="">النوع</option>
                @foreach(['apartment'=>'شقة','villa'=>'فيلا','land'=>'أرض','office'=>'مكتب','shop'=>'محل'] as $k=>$v)
                  <option value="{{ $k }}" @selected(old('type')===$k)>{{ $v }}</option>
                @endforeach
              </select>
            </div>
            {{-- تثبيت المدينة إلى الرياض --}}
            <input type="hidden" name="city" value="الرياض">
            <div class="col-md-6">
              <input class="form-control" value="الرياض" placeholder="المدينة" disabled>
            </div>
            {{-- أحياء الرياض --}}
            @php($riyadhDistricts = [
              'العليا','الملز','السويدي','النخيل','الورود','الياسمين','العقيق','حطين','الصحافة','المروج','السلام','المصيف','السليمانية','المعذر','القيروان','الحمراء','النهضة','المونسية','قرطبة','اليرموك','الفلاح','التعاون','الريان','الروضة','العزيزية','العزيزية الجنوبية','الشفا','البديعة','النسيم','غرناطة','ظهرة لبن','لبن','عرقة','طويق','نمار','ديراب','العريجاء','أشبيليا','المروة','النرجس','الندى','الياسمين الشمالي','الياسمين الجنوبي','الواحة','الرائد','الغدير','المعالي','العليا الشمالية','العليا الجنوبية'
            ])
            <div class="col-md-6">
              <select class="form-select" name="district" required>
                <option value="">اختر الحي</option>
                @foreach($riyadhDistricts as $d)
                  <option value="{{ $d }}" @selected(old('district')===$d)>{{ $d }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <input class="form-control" type="number" name="price" value="{{ old('price') }}" placeholder="السعر" required>
            </div>
            <div class="col-md-6">
              <input class="form-control" type="number" name="area" value="{{ old('area') }}" placeholder="المساحة (م²)">
            </div>
            <div class="col-md-6">
              <input class="form-control" type="number" name="bedrooms" value="{{ old('bedrooms') }}" placeholder="عدد الغرف">
            </div>
            <div class="col-md-6">
              <input class="form-control" type="number" name="bathrooms" value="{{ old('bathrooms') }}" placeholder="عدد الحمامات">
            </div>
            <div class="col-12">
              <textarea class="form-control" name="description" rows="3" placeholder="وصف مختصر">{{ old('description') }}</textarea>
            </div>
            <div class="col-12">
              <input class="form-control" type="url" name="location_url" value="{{ old('location_url') }}" placeholder="رابط الموقع على الخريطة (اختياري)">
              <div class="text-muted small mt-1">مثال: رابط Google Maps للموقع الدقيق للعقار</div>
            </div>
            <div class="col-12 d-flex align-items-center gap-2">
              <label class="btn btn-outline-ink mb-0" style="cursor:pointer">
                <input type="file" name="cover" accept="image/*" hidden>
                رفع صورة الغلاف
              </label>
              <span class="text-muted small">صيغ: jpg, png, webp — حد أقصى 4MB</span>
            </div>
            <div class="col-12">
              <label class="btn btn-outline-ink mb-0" style="cursor:pointer">
                <input id="galleryInputModal" type="file" name="gallery[]" accept="image/*" multiple hidden>
                إضافة صور للمعرض (متعددة)
              </label>
              <div class="text-muted small mt-1">يمكنك اختيار عدة صور دفعة واحدة. صيغ: jpg, png, webp — كل ملف حتى 4MB</div>
              <div id="galleryPreviewModal" class="mt-2" style="display:flex; gap:.5rem; flex-wrap:wrap"></div>
            </div>
            <div class="col-md-6">
              <input class="form-control" type="url" name="video_url" value="{{ old('video_url') }}" placeholder="رابط فيديو من يوتيوب (اختياري)">
              <div class="text-muted small mt-1">يمكنك إدخال رابط يوتيوب أو تركه فارغًا واستخدام خيار الرفع</div>
            </div>
            <div class="col-md-6">
              <label class="btn btn-outline-ink w-100 text-start" style="cursor:pointer">
                <input type="file" name="video" accept="video/mp4,video/webm" hidden>
                رفع ملف فيديو (MP4/WebM)
              </label>
              <div class="text-muted small mt-1">إذا أدخلت رابطًا فلا يلزم رفع ملف، والعكس صحيح</div>
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
            <div class="col-12">
              <div class="card p-2">
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
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-ink" data-bs-dismiss="modal">إلغاء</button>
          <button class="btn btn-ink" type="submit">حفظ العقار</button>
        </div>
      </form>
    </div>
  </div>
  </div>

@if ($errors->any())
  <script>
    document.addEventListener('DOMContentLoaded', function(){
      var el = document.getElementById('createPropertyModal');
      if (el) { var modal = new bootstrap.Modal(el); modal.show(); }
    });
  </script>
@endif
<script>
  (function(){
    const input = document.getElementById('galleryInputModal');
    const preview = document.getElementById('galleryPreviewModal');
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
          img.style.width = '64px';
          img.style.height = '64px';
          img.style.objectFit = 'cover';
          img.style.borderRadius = '6px';
          img.style.boxShadow = '0 0 0 1px rgba(0,0,0,.06)';
          preview.appendChild(img);
        };
        reader.readAsDataURL(file);
      });
    });
  })();
  </script>
@endsection
