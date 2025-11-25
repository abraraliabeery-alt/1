@extends('layouts.admin')

@section('admin')
<div class="admin-section" dir="rtl">
    <h1 class="text-2xl font-bold mb-4">إضافة عقار</h1>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-50 text-red-700 rounded">
            <ul class="list-disc pr-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.properties.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow d-flex flex-column gap-3">
        @csrf

        <div class="card">
            <div class="admin-header" style="margin-bottom:8px">
                <div class="title"><h1>الأساسيات</h1></div>
            </div>
            <label class="block mb-1">العنوان</label>
            <input required type="text" name="title" value="{{ old('title') }}" class="form-control" placeholder="مثال: فيلا فاخرة بحي الياسمين">
        </div>

        <div class="card location-type">
            <div class="admin-header" style="margin-bottom:8px">
                <div class="title"><h1>الموقع والنوع</h1></div>
            </div>
            <div class="row g-2" dir="rtl">
                <div class="col-md-4">
                    <label class="block mb-1"><span class="d-inline-flex align-items-center gap-1"><i class="bi bi-geo-alt"></i> المدينة</span></label>
                    <input required list="cities" name="city" value="{{ old('city') }}" class="form-control" placeholder="اختر أو اكتب المدينة">
                    @if(!empty($cities))
                      <datalist id="cities">
                        @foreach($cities as $c)
                          <option value="{{ $c }}" />
                        @endforeach
                      </datalist>
                    @endif
                </div>
                <div class="col-md-4">
                    <label class="block mb-1"><span class="d-inline-flex align-items-center gap-1"><i class="bi bi-signpost-2"></i> الحي</span></label>
                    <input required list="districts" type="text" name="district" value="{{ old('district') }}" class="form-control" placeholder="اختر أو اكتب الحي">
                    @if(!empty($districts))
                      <datalist id="districts">
                        @foreach($districts as $d)
                          <option value="{{ $d }}" />
                        @endforeach
                      </datalist>
                    @endif
                    <div id="districtWarn" class="text-xs text-red-600 mt-1 hidden">تنبيه: الحي المدخل غير موجود ضمن أحياء الرياض.</div>
                </div>
                <div class="col-md-4">
                    <label class="block mb-1"><span class="d-inline-flex align-items-center gap-1"><i class="bi bi-building"></i> النوع</span></label>
                    <select required name="type" class="form-select">
                      @if(!empty($typeOptions))
                        @foreach($typeOptions as $val=>$label)
                          <option value="{{ $val }}" @selected(old('type')===$val)>{{ $label }}</option>
                        @endforeach
                      @else
                        <option value="{{ old('type') }}" selected>{{ old('type') ?: '—' }}</option>
                      @endif
                    </select>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="admin-header" style="margin-bottom:8px">
                <div class="title"><h1>التسعير والمساحة</h1></div>
            </div>
            <label class="block mb-1">السعر</label>
            <input required type="number" name="price" value="{{ old('price') }}" class="form-control" placeholder="مثال: 1250000">
            <div class="text-xs text-gray-500 mt-1"><span id="priceFmt">—</span> | <span id="ppm2">—</span></div>
        </div>

        <div class="card">
            <div class="admin-header" style="margin-bottom:8px">
                <div class="title"><h1>الأساسيات الإضافية</h1></div>
            </div>
            <div class="row g-2" dir="rtl">
                <div class="col-md-4">
                    <label class="block mb-1"><span class="d-inline-flex align-items-center gap-1"><i class="bi bi-aspect-ratio"></i> المساحة (م²)</span></label>
                    <input required type="number" name="area" value="{{ old('area') }}" class="form-control" placeholder="مثال: 350">
                </div>
                <div class="col-md-4">
                    <label class="block mb-1"><span class="d-inline-flex align-items-center gap-1"><i class="bi bi-door-open"></i> الغرف</span></label>
                    <input type="number" name="bedrooms" value="{{ old('bedrooms') }}" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="block mb-1"><span class="d-inline-flex align-items-center gap-1"><i class="bi bi-droplet"></i> الحمامات</span></label>
                    <input type="number" name="bathrooms" value="{{ old('bathrooms') }}" class="form-control">
                </div>
            </div>
        </div>


        <div class="card">
            <div class="admin-header" style="margin-bottom:8px">
                <div class="title"><h1>الحالة والمميز</h1></div>
            </div>
            <div class="row g-2" dir="rtl">
                <div class="col-md-6">
                    <label class="block mb-1">الحالة</label>
                    <select name="status" class="form-select">
                        <option value="">—</option>
                        @foreach(($statuses ?? []) as $s)
                          <option value="{{ $s }}" @selected(old('status')===$s)>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <div class="form-check d-flex align-items-center gap-2">
                        <input class="form-check-input" id="is_featured" type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">مميز</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="admin-header" style="margin-bottom:8px">
                <div class="title"><h1>الوصف</h1></div>
            </div>
            <label class="block mb-1">الوصف</label>
            <textarea name="description" rows="4" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="card">
            <div class="admin-header" style="margin-bottom:8px">
                <div class="title"><h1>المزايا</h1></div>
            </div>
            <label class="block mb-2 font-semibold">المزايا</label>
            <div class="row row-cols-6 g-1 amenities-grid">
              @foreach(($amenityOptions ?? []) as $key=>$opt)
                <div class="col">
                  <label class="d-flex align-items-center gap-1 border rounded p-1 hover-bg-light cursor-pointer w-100 amenity">
                    <input class="form-check-input" type="checkbox" name="amenities_list[]" value="{{ $key }}" @checked(in_array($key, old('amenities_list', [])))>
                    <i class="bi {{ $opt['icon'] ?? 'bi-check2-circle' }}"></i>
                    <span>{{ $opt['label'] ?? $key }}</span>
                  </label>
                </div>
              @endforeach
            </div>
            <div class="text-xs text-gray-500 mt-1">اختر ما تشاء من الميزات. سيتم حفظها كقائمة JSON.</div>
        </div>

        <div class="card">
            <div class="admin-header" style="margin-bottom:8px">
                <div class="title"><h1>الموقع</h1></div>
            </div>
            <label class="block mb-1">رابط الموقع (الخريطة)</label>
            <input type="url" name="location_url" value="{{ old('location_url') }}" class="form-control" placeholder="https://maps.google.com/...">
        </div>

        <div class="card">
            <div class="admin-header" style="margin-bottom:8px">
                <div class="title"><h1>الوسائط</h1></div>
            </div>
            <label class="block mb-1">صورة الغلاف</label>
            <input id="coverInput" type="file" name="cover_image" accept="image/*" class="form-control">
            <div id="coverPreview" class="mt-2"></div>
        </div>

        <div class="card">
            <label class="block mb-1">معرض الصور (يمكن اختيار عدة صور)</label>
            <input id="galleryInput" type="file" name="gallery_images[]" accept="image/*" multiple class="form-control">
            <div id="galleryPreview" class="mt-2 d-flex flex-wrap gap-2"></div>
            <div class="text-xs text-gray-500 mt-1">سيتم رفعها إلى التخزين وتخزين المسارات في حقل المعرض.</div>
        </div>

        <div class="card p-3 bg-gray-50 rounded">
            <div class="font-semibold mb-2">الفيديو (اختر أحد الخيارين فقط)</div>
            <div class="d-flex flex-column gap-3">
                <div>
                    <label class="block mb-1">رفع ملف فيديو</label>
                    <input type="file" name="video_file" accept="video/mp4,video/webm,video/ogg" class="form-control">
                    <div class="text-xs text-gray-500 mt-1">الحد الأقصى 50MB</div>
                </div>
                <div>
                    <label class="block mb-1">رابط يوتيوب</label>
                    <input id="ytUrl" type="url" name="video_url" value="{{ old('video_url') }}" class="form-control" placeholder="https://www.youtube.com/watch?v=...">
                    <div id="ytPrev" class="aspect-video mt-2 hidden">
                        <iframe class="w-full h-full rounded" src="" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="redirect" id="redirectAction" value="">
        <div style="position: sticky; bottom: 0; background: #fff; padding-top: 12px; border-top: 1px solid #eee;" class="d-flex gap-2 justify-content-end">
            <button class="btn btn-primary" type="submit">حفظ</button>
            <button id="saveAddNew" class="btn btn-success" type="button" title="حفظ وإضافة جديد">حفظ وإضافة جديد</button>
        </div>
    </form>
</div>
<script>
// Price helpers
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
// YouTube normalize preview
(function(){
  const inp = document.getElementById('ytUrl');
  const box = document.getElementById('ytPrev');
  const frame = box? box.querySelector('iframe'):null;
  function toEmbed(u){
    if(!u) return '';
    const m = u.match(/(?:youtu\.be\/|v=)([A-Za-z0-9_-]{11})/); return m? 'https://www.youtube.com/embed/'+m[1] : '';
  }
  function refresh(){ const e = toEmbed(inp.value.trim()); if(frame){ frame.src=e||''; box.classList.toggle('hidden', !e); } }
  inp && inp.addEventListener('blur', refresh); refresh();
})();

// Save & Add New
(function(){
  const btn = document.getElementById('saveAddNew');
  const red = document.getElementById('redirectAction');
  const form = btn ? btn.closest('form') : null;
  if(btn && red && form){
    btn.addEventListener('click', ()=>{ red.value='create'; form.submit(); });
  }
})();

// District vs City simple warning (Riyadh)
(function(){
  const city = document.querySelector('input[name="city"]');
  const district = document.querySelector('input[name="district"]');
  const warn = document.getElementById('districtWarn');
  const list = document.getElementById('districts');
  function knownDistrict(v){
    if(!list) return true;
    const opts = Array.from(list.querySelectorAll('option')).map(o=>o.value.trim());
    return v && opts.includes(v.trim());
  }
  function check(){
    const c = (city?.value||'').trim();
    const d = (district?.value||'').trim();
    const show = c==='الرياض' && d && !knownDistrict(d);
    if(warn){ warn.classList.toggle('hidden', !show); }
  }
  city && city.addEventListener('change', check);
  district && district.addEventListener('blur', check);
  check();
})();

// Cover preview with clear
(function(){
  const input = document.getElementById('coverInput');
  const wrap  = document.getElementById('coverPreview');
  if(!input || !wrap) return;
  function render(file){
    wrap.innerHTML='';
    if(!file) return;
    const url = URL.createObjectURL(file);
    const img = document.createElement('img'); img.src=url; img.className='w-48 h-32 object-cover rounded border';
    const btn = document.createElement('button'); btn.type='button'; btn.textContent='إزالة'; btn.className='ml-2 px-2 py-1 bg-red-600 text-white rounded';
    btn.addEventListener('click', ()=>{ input.value=''; wrap.innerHTML=''; });
    const row = document.createElement('div'); row.className='flex items-center gap-2'; row.appendChild(img); row.appendChild(btn);
    wrap.appendChild(row);
  }
  input.addEventListener('change', ()=>{ const f=input.files?.[0]; render(f); });
})();

// Gallery previews with remove using DataTransfer
(function(){
  const input = document.getElementById('galleryInput');
  const grid  = document.getElementById('galleryPreview');
  if(!input || !grid) return;
  // Persist selected files across multiple selections
  let selected = [];
  function rebuild(files){
    const dt = new DataTransfer();
    files.forEach(f=>dt.items.add(f));
    input.files = dt.files;
  }
  function render(){
    grid.innerHTML='';
    const files = selected;
    // layout as small squares grid
    grid.style.display = 'grid';
    grid.style.gridTemplateColumns = 'repeat(auto-fill, 72px)';
    grid.style.gap = '6px';
    files.forEach((file, idx)=>{
      const url = URL.createObjectURL(file);
      const cell = document.createElement('div');
      cell.style.position='relative'; cell.style.width='72px'; cell.style.height='72px';
      const img = document.createElement('img');
      img.src=url; img.style.width='100%'; img.style.height='100%'; img.style.objectFit='cover'; img.style.borderRadius='8px'; img.style.border='1px solid #e5e7eb';
      const btn = document.createElement('button');
      btn.type='button'; btn.textContent='×'; btn.title='إزالة';
      btn.style.position='absolute'; btn.style.top='-6px'; btn.style.right='-6px';
      btn.style.width='18px'; btn.style.height='18px'; btn.style.lineHeight='16px'; btn.style.textAlign='center';
      btn.style.borderRadius='999px'; btn.style.background='#ef4444'; btn.style.color='#fff'; btn.style.border='none'; btn.style.cursor='pointer';
      btn.addEventListener('click', ()=>{
        selected = selected.filter((_,i)=>i!==idx);
        rebuild(selected);
        render();
      });
      cell.appendChild(img); cell.appendChild(btn); grid.appendChild(cell);
    });
  }
  input.addEventListener('change', ()=>{
    const newly = Array.from(input.files||[]);
    if(newly.length){ selected = selected.concat(newly); }
    rebuild(selected);
    render();
  });
})();

// Amenities chips UI synced to input
(function(){
  const input = document.querySelector('input[name="amenities"]');
  if(!input) return;
  const wrap = document.createElement('div'); wrap.className='flex flex-wrap gap-2 mt-2';
  input.insertAdjacentElement('afterend', wrap);
  const helper = document.createElement('div'); helper.className='text-xs text-gray-500'; helper.textContent='إضغط Enter أو فاصلة لإضافة ميزة، وأنقر على الشارة لإزالتها';
  wrap.insertAdjacentElement('afterend', helper);
  function parse(){ return (input.value||'').split(',').map(v=>v.trim()).filter(Boolean); }
  function sync(arr){ input.value = arr.join(', '); }
  function render(){
    wrap.innerHTML='';
    parse().forEach(v=>{
      const b=document.createElement('button'); b.type='button'; b.textContent=v; b.className='px-2 py-1 rounded-full bg-gray-200 hover:bg-gray-300';
      b.addEventListener('click', ()=>{ const arr=parse().filter(x=>x!==v); sync(arr); render(); });
      wrap.appendChild(b);
    });
  }
  input.addEventListener('keydown', (e)=>{
    if(e.key==='Enter' || e.key===','){
      e.preventDefault();
      const val=input.value.trim();
      const arr=parse();
      if(val && !arr.includes(val)) arr.push(val);
      sync(arr); render(); input.value='';
    }
  });
  render();
})();
</script>
@endsection
