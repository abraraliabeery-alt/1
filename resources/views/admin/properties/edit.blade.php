@extends('layouts.admin')

@section('admin')
<div class="admin-section" dir="rtl">
    <h1 class="text-2xl font-bold mb-4">تعديل عقار: {{ $property->title }}</h1>

    @if (session('status'))
        <div class="mb-4 p-3 bg-green-50 text-green-700 rounded">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-50 text-red-700 rounded">
            <ul class="list-disc pr-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.properties.update', $property) }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow d-flex flex-column gap-3">
        @csrf
        @method('PUT')

        <div>
            <label class="block mb-1">العنوان</label>
            <input type="text" name="title" value="{{ old('title', $property->title) }}" class="form-control">
        </div>

        <div>
            <div>
                <label class="block mb-1">المدينة</label>
                <input list="cities" name="city" value="{{ old('city', $property->city) }}" class="form-control" placeholder="اختر أو اكتب المدينة">
                @if(!empty($cities))
                  <datalist id="cities">
                    @foreach($cities as $c)
                      <option value="{{ $c }}" />
                    @endforeach
                  </datalist>
                @endif
            </div>
            <div>
                <label class="block mb-1">الحي</label>
                <input list="districts" type="text" name="district" value="{{ old('district', $property->district) }}" class="form-control" placeholder="اختر أو اكتب الحي">
                @if(!empty($districts))
                  <datalist id="districts">
                    @foreach($districts as $d)
                      <option value="{{ $d }}" />
                    @endforeach
                  </datalist>
                @endif
            </div>
            <div>
                <label class="block mb-1">النوع</label>
                <select name="type" class="form-select">
                    @if(!empty($typeOptions))
                      @foreach($typeOptions as $val=>$label)
                        <option value="{{ $val }}" @selected(old('type', $property->type)===$val)>{{ $label }}</option>
                      @endforeach
                    @else
                      <option value="{{ old('type', $property->type) }}" selected>{{ old('type', $property->type) }}</option>
                    @endif
                </select>
            </div>
        </div>

        <div>
            <label class="block mb-1">السعر</label>
            <input type="number" name="price" value="{{ old('price', $property->price) }}" class="form-control">
            <div class="text-xs text-gray-500 mt-1"><span id="priceFmt">—</span> | <span id="ppm2">—</span></div>
        </div>

        <div>
            <label class="block mb-1">المساحة (م²)</label>
            <input type="number" name="area" value="{{ old('area', $property->area) }}" class="form-control">
        </div>

        <div>
            <label class="block mb-1">الغرف</label>
            <input type="number" name="bedrooms" value="{{ old('bedrooms', $property->bedrooms) }}" class="form-control">
        </div>

        <div>
            <label class="block mb-1">الحمامات</label>
            <input type="number" name="bathrooms" value="{{ old('bathrooms', $property->bathrooms) }}" class="form-control">
        </div>

        <div>
            <label class="block mb-1">الحالة</label>
            <select name="status" class="form-select">
                <option value="">—</option>
                @foreach(($statuses ?? []) as $s)
                  <option value="{{ $s }}" @selected(old('status', $property->status)===$s)>{{ $s }}</option>
                @endforeach
            </select>
        </div>

        <div class="d-flex align-items-center gap-2">
            <input class="form-check-input" id="is_featured" type="checkbox" name="is_featured" value="1" {{ old('is_featured', $property->is_featured) ? 'checked' : '' }}> <label class="form-check-label" for="is_featured">مميز</label>
        </div>

        <div>
            <label class="block mb-1">الوصف</label>
            <textarea name="description" rows="4" class="form-control">{{ old('description', $property->description) }}</textarea>
        </div>

        <div>
            <label class="block mb-2 font-semibold">المزايا</label>
            <div class="row row-cols-6 g-1 amenities-grid">
                @foreach(($amenityOptions ?? []) as $key=>$opt)
                  <div class="col">
                    <label class="d-flex align-items-center gap-1 border rounded p-1 hover-bg-light cursor-pointer w-100 amenity">
                      <input class="form-check-input" type="checkbox" name="amenities_list[]" value="{{ $key }}" @checked(in_array($key, old('amenities_list', $property->amenities ?? [])))>
                      <i class="bi {{ $opt['icon'] ?? 'bi-check2-circle' }}"></i>
                      <span>{{ $opt['label'] ?? $key }}</span>
                    </label>
                  </div>
                @endforeach
            </div>
        </div>

        <div>
            <label class="block mb-1">رابط الموقع (الخريطة)</label>
            <input type="url" name="location_url" value="{{ old('location_url', $property->location_url) }}" class="form-control" placeholder="https://maps.google.com/...">
        </div>

        <div>
            <label class="block mb-1">صورة الغلاف</label>
            @if($property->cover_image)
                <img src="{{ $property->cover_image_url }}" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1523217582562-09d0def993a6?q=80&w=600&auto=format&fit=crop'" class="w-48 h-32 object-cover rounded mb-2 border"/>
            @endif
            <input type="file" name="cover_image" accept="image/*" class="form-control">
        </div>

        @if(!empty($property->gallery_urls))
        <div>
            <label class="block mb-2 font-semibold">معرض الصور الحالي</label>
            <div class="d-flex flex-wrap gap-2">
              @foreach($property->gallery_urls as $img)
                <div class="border rounded p-1 text-center" style="width:110px;">
                  <img src="{{ $img }}" class="w-100" style="height:90px;object-fit:cover" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1523217582562-09d0def993a6?q=80&w=600&auto=format&fit=crop'"/>
                  <div class="form-check mt-1">
                    <input class="form-check-input" type="checkbox" name="remove_gallery[]" value="{{ $img }}" id="rm_{{ md5($img) }}">
                    <label class="form-check-label small" for="rm_{{ md5($img) }}">إزالة</label>
                  </div>
                </div>
              @endforeach
            </div>
        </div>
        @endif

        <div>
            <label class="block mb-1">إضافة صور للمعرض</label>
            <input id="galleryInputEdit" type="file" name="gallery_images[]" accept="image/*" multiple class="form-control">
            <div id="galleryPreviewEdit" class="mt-2"></div>
        </div>

        <div class="p-3 bg-gray-50 rounded">
            <div class="font-semibold mb-2">الفيديو (اختر أحد الخيارين فقط)</div>
            <div class="d-flex flex-column gap-3">
                <div>
                    @if($property->video_path)
                        <video class="w-full rounded mb-2" controls>
                            <source src="{{ asset('storage/'.$property->video_path) }}" type="video/mp4">
                        </video>
                    @endif
                    <label class="block mb-1">رفع ملف فيديو</label>
                    <input type="file" name="video_file" accept="video/mp4,video/webm,video/ogg" class="form-control">
                    <div class="text-xs text-gray-500 mt-1">الحد الأقصى 50MB</div>
                </div>
                <div>
                    @if($property->video_url)
                        <div class="aspect-video mb-2">
                            <iframe class="w-full h-full rounded" src="{{ $property->video_url }}" frameborder="0" allowfullscreen></iframe>
                        </div>
                    @endif
                    <label class="block mb-1">رابط يوتيوب</label>
                    <input type="url" name="video_url" value="{{ old('video_url', $property->video_url) }}" class="form-control" placeholder="https://www.youtube.com/watch?v=...">
                </div>
            </div>
        </div>

        <div class="d-flex gap-2" style="position: sticky; bottom: 0; background: #fff; padding-top: 12px; border-top: 1px solid #eee;">
            <button class="btn btn-primary">حفظ</button>
            <a href="{{ route('admin.properties.index') }}" class="btn btn-outline-secondary">رجوع</a>
        </div>
    </form>
</div>
<script>
(function(){
  const price = document.querySelector('input[name="price"]');
  const area  = document.querySelector('input[name="area"]');
  const fmt   = document.getElementById('priceFmt');
  const ppm2  = document.getElementById('ppm2');
  function update(){
    const p = Number(price?.value||0); const a = Number(area?.value||0);
    fmt && (fmt.textContent = p? new Intl.NumberFormat('ar-SA').format(p)+' ر.س' : '—');
    ppm2 && (ppm2.textContent = (p&&a)? ('السعر/م²: '+ new Intl.NumberFormat('ar-SA').format(Math.round(p/a)) +' ر.س') : '—');
  }
  price && price.addEventListener('input', update);
  area && area.addEventListener('input', update);
  update();
})();

// Gallery add preview (edit) with small squares and removal before upload
(function(){
  const input = document.getElementById('galleryInputEdit');
  const grid  = document.getElementById('galleryPreviewEdit');
  if(!input || !grid) return;
  let selected = [];
  function rebuild(files){ const dt = new DataTransfer(); files.forEach(f=>dt.items.add(f)); input.files = dt.files; }
  function render(){
    grid.innerHTML='';
    grid.style.display='grid'; grid.style.gridTemplateColumns='repeat(auto-fill,72px)'; grid.style.gap='6px';
    selected.forEach((file, idx)=>{
      const url = URL.createObjectURL(file);
      const cell=document.createElement('div'); cell.style.position='relative'; cell.style.width='72px'; cell.style.height='72px';
      const img=document.createElement('img'); img.src=url; img.style.width='100%'; img.style.height='100%'; img.style.objectFit='cover'; img.style.borderRadius='8px'; img.style.border='1px solid #e5e7eb';
      const btn=document.createElement('button'); btn.type='button'; btn.textContent='×'; btn.title='إزالة';
      btn.style.position='absolute'; btn.style.top='-6px'; btn.style.right='-6px'; btn.style.width='18px'; btn.style.height='18px'; btn.style.lineHeight='16px'; btn.style.textAlign='center'; btn.style.borderRadius='999px'; btn.style.background='#ef4444'; btn.style.color='#fff'; btn.style.border='none'; btn.style.cursor='pointer';
      btn.addEventListener('click', ()=>{ selected = selected.filter((_,i)=>i!==idx); rebuild(selected); render(); });
      cell.appendChild(img); cell.appendChild(btn); grid.appendChild(cell);
    });
  }
  input.addEventListener('change', ()=>{ const newly = Array.from(input.files||[]); if(newly.length){ selected = selected.concat(newly); } rebuild(selected); render(); });
})();
</script>
@endsection
