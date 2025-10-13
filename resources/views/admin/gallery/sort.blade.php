@extends('layouts.admin')

@section('admin')
  <div class="admin-header">
    <div class="title">
      <h1>ترتيب الصور</h1>
      <div class="subtitle">عدّل القيم بالأرقام (0,1,2...)، الأصغر يظهر أولاً.</div>
    </div>
    <div class="tools">
      <a class="btn btn-primary" href="{{ route('gallery.index') }}">العودة للألبوم</a>
    </div>
  </div>

  <div class="admin-content">
    @if(session('ok'))
      <div class="alert alert-success" role="status"><strong>تم:</strong> {{ session('ok') }}</div>
    @endif

    {{-- Upload form (single or multiple images) with Drag & Drop --}}
    <form id="uploadForm" action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data" class="card" style="padding:12px; margin-bottom:12px">
      @csrf
      <div class="vstack" style="gap:10px">
        <div class="row-between" style="gap:10px; align-items:center; flex-wrap:wrap">
          <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap">
            <label style="margin:0; font-weight:800">رفع صور</label>
            <input id="fileInput" type="file" name="images[]" multiple accept="image/*" />
            <span class="text-muted" style="font-size:12px">اسحب الصور هنا أو اخترها من جهازك</span>
          </div>
          <button class="btn btn-primary" type="submit">إضافة</button>
        </div>
        <div id="dropzone" class="dz" style="border:1px dashed var(--admin-border); border-radius:12px; padding:16px; background: color-mix(in oklab, var(--admin-surface), transparent 20%); text-align:center">
          <div class="text-muted" style="font-weight:700">اسحب وأفلت الصور هنا</div>
          <div id="previews" style="display:flex; gap:8px; flex-wrap:wrap; margin-top:10px"></div>
        </div>
      </div>
    </form>

    <form action="{{ route('gallery.sort.save') }}" method="POST">
      @csrf
      <div id="grid" class="grid-3" style="gap:12px">
        @forelse($items as $it)
          <div class="card" style="padding:12px; cursor:move" data-id="{{ $it->id }}" draggable="true">
            <div class="illustration small" style="height:160px; margin-bottom:8px; overflow:hidden">
              <img src="{{ $it->image_path }}" alt="{{ $it->title }}" style="width:100%; height:100%; object-fit:cover">
            </div>
            <div style="font-weight:800; margin-bottom:6px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis" title="{{ $it->title }}">{{ $it->title }}</div>
            <div class="row-between" style="gap:8px">
              <label style="display:flex; align-items:center; gap:6px; margin:0">
                <span class="text-muted" style="font-size:12px">ترتيب</span>
                <input type="number" name="orders[{{ $it->id }}]" value="{{ $it->sort_order }}" min="0" step="1" style="width:80px">
              </label>
              <a class="btn btn-link btn-sm" href="{{ route('gallery.show', $it->slug) }}" target="_blank">عرض</a>
            </div>
          </div>
        @empty
          <div class="text-muted">لا توجد صور.</div>
        @endforelse
      </div>

      <div style="margin-top:12px" class="row-between">
        <div></div>
        <button class="btn btn-primary" type="submit">حفظ الترتيب</button>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
<script>
(function(){
  const form = document.getElementById('uploadForm');
  const input = document.getElementById('fileInput');
  const dz = document.getElementById('dropzone');
  const previews = document.getElementById('previews');
  const bucket = []; // hold dropped files

  function addFiles(files){
    for(const file of files){
      if(!file.type.startsWith('image/')) continue;
      bucket.push(file);
      const reader = new FileReader();
      reader.onload = (e)=>{
        const wrap = document.createElement('div');
        wrap.style.cssText = 'width:88px;height:66px;border:1px solid var(--admin-border);border-radius:8px;overflow:hidden;position:relative;';
        wrap.innerHTML = `<img src="${e.target.result}" alt="" style="width:100%;height:100%;object-fit:cover">`;
        previews.appendChild(wrap);
      };
      reader.readAsDataURL(file);
    }
  }

  dz.addEventListener('dragover', (e)=>{ e.preventDefault(); dz.style.background='rgba(10,102,255,.06)'; });
  dz.addEventListener('dragleave', ()=>{ dz.style.background=''; });
  dz.addEventListener('drop', (e)=>{ e.preventDefault(); dz.style.background=''; addFiles(e.dataTransfer.files); });

  input.addEventListener('change', ()=>{ addFiles(input.files); });

  form.addEventListener('submit', function(e){
    if(bucket.length===0){ return; } // fallback to normal submit if user used only the input
    e.preventDefault();
    const fd = new FormData();
    bucket.forEach(f=> fd.append('images[]', f));
    fetch(form.action, { method:'POST', headers:{ 'X-Requested-With':'XMLHttpRequest' }, body: fd })
      .then(r=>{ if(!r.ok) throw new Error('Upload failed'); return r.text(); })
      .then(()=>{ location.reload(); })
      .catch(err=>{ alert('تعذر رفع الصور، حاول مرة أخرى'); console.error(err); });
  });
  // Drag & Drop reorder with auto-save
  const grid = document.getElementById('grid');
  let dragEl = null;
  grid.addEventListener('dragstart', (e)=>{
    const t = e.target.closest('[draggable]');
    if(!t) return; dragEl = t; t.style.opacity = '.6';
  });
  grid.addEventListener('dragend', (e)=>{ const t = e.target.closest('[draggable]'); if(t){ t.style.opacity=''; }});
  grid.addEventListener('dragover', (e)=>{
    e.preventDefault();
    const after = getDragAfterElement(grid, e.clientY);
    if(after == null){ grid.appendChild(dragEl); }
    else { grid.insertBefore(dragEl, after); }
  });

  function getDragAfterElement(container, y){
    const els = [...container.querySelectorAll('[draggable]:not(.dragging)')];
    return els.reduce((closest, child)=>{
      const box = child.getBoundingClientRect();
      const offset = y - box.top - box.height/2;
      if(offset < 0 && offset > closest.offset){ return { offset, element: child }; }
      else { return closest; }
    }, { offset: Number.NEGATIVE_INFINITY }).element;
  }

  function computeOrders(){
    const map = {};
    [...grid.querySelectorAll('[data-id]')].forEach((el, idx)=>{ map[el.dataset.id] = idx; });
    return map;
  }

  let saveTimer = null;
  grid.addEventListener('drop', ()=>{
    if(saveTimer) clearTimeout(saveTimer);
    saveTimer = setTimeout(()=>{
      const orders = computeOrders();
      const fd = new FormData();
      Object.keys(orders).forEach(id=> fd.append(`orders[${id}]`, orders[id]));
      fetch(`{{ route('gallery.sort.save') }}`, { method:'POST', headers:{ 'X-Requested-With':'XMLHttpRequest', 'X-CSRF-TOKEN': `{{ csrf_token() }}` }, body: fd })
        .then(r=> r.ok ? null : Promise.reject('save failed'))
        .catch(console.error);
    }, 200);
  });
})();
</script>
@endpush
