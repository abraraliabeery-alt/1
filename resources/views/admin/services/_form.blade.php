<form method="POST" action="{{ $action }}" enctype="multipart/form-data" style="display:grid; gap:12px">
  @csrf
  @if($method !== 'POST')
    @method($method)
  @endif
  <label>
    العنوان
    <input type="text" name="title" value="{{ old('title', $service->title ?? '') }}" required class="@error('title') is-invalid @enderror" />
    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </label>
  <label>
    ملخص مختصر
    <input type="text" name="excerpt" value="{{ old('excerpt', $service->excerpt ?? '') }}" class="@error('excerpt') is-invalid @enderror" />
    @error('excerpt')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </label>
  <label>
    الأيقونة
    <div style="display:flex; gap:8px; align-items:center">
      <span id="icon-preview" class="bi {{ old('icon', $service->icon ?? '') }}" style="font-size:22px"></span>
      <input id="icon-input" type="text" name="icon" value="{{ old('icon', $service->icon ?? '') }}" placeholder="bi bi-shield" class="@error('icon') is-invalid @enderror" style="flex:1" />
      <button type="button" id="open-icon-picker" class="btn btn-outline">اختيار</button>
    </div>
    @error('icon')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </label>
  <dialog id="icon-picker" style="border:0; border-radius:16px; padding:16px; max-width:min(92vw,720px); width:720px">
    <div style="display:flex; gap:8px; align-items:center; margin-bottom:10px">
      <input id="icon-search" type="search" placeholder="ابحث عن أيقونة" class="field" style="flex:1" />
      <button type="button" id="close-icon-picker" class="btn btn-outline">إغلاق</button>
    </div>
    <div id="icon-grid" style="display:grid; grid-template-columns:repeat(auto-fill,minmax(88px,1fr)); gap:8px; max-height:52vh; overflow:auto"></div>
  </dialog>
  <script>
    (function(){
      const dlg=document.getElementById('icon-picker');
      const openBtn=document.getElementById('open-icon-picker');
      const closeBtn=document.getElementById('close-icon-picker');
      const grid=document.getElementById('icon-grid');
      const q=document.getElementById('icon-search');
      const input=document.getElementById('icon-input');
      const prev=document.getElementById('icon-preview');

      const biLink = document.querySelector('link[href*="bootstrap-icons"]');
      const key = 'bi_list_' + (biLink ? (new URL(biLink.href)).pathname : 'local');

      let all = [];
      let view = [];
      let shown = 0;
      const page = 120;

      function paintMore(){
        const slice = view.slice(shown, shown + page);
        shown += slice.length;
        const frag = document.createDocumentFragment();
        slice.forEach(fullClass=>{
          const name = fullClass.replace('bi bi-','bi-');
          const item=document.createElement('button');
          item.type='button';
          item.style.cssText='display:flex;flex-direction:column;align-items:center;gap:6px;border:1px solid #e5e7eb;background:#fff;border-radius:12px;padding:10px;cursor:pointer';
          item.innerHTML=`<i class="${fullClass}" style="font-size:24px"></i><span style="font-size:11px;direction:ltr">${name}</span>`;
          item.addEventListener('click',()=>{ input.value=fullClass; prev.className=fullClass; dlg.close(); });
          frag.appendChild(item);
        });
        grid.appendChild(frag);
      }

      function applyFilter(term){
        const terms=(term||'').toLowerCase().trim().split(/\s+/).filter(Boolean);
        view = all.filter(cls => terms.length ? terms.every(t => cls.toLowerCase().includes(t)) : true);
        grid.innerHTML='';
        shown = 0;
        paintMore();
      }

      async function loadList(){
        const cached = localStorage.getItem(key);
        if(cached){ try{ all = JSON.parse(cached); }catch{ all=[]; } }
        if(!all.length && biLink){
          try{
            const res = await fetch(biLink.href, { cache:'force-cache' });
            const css = await res.text();
            const re = /\.bi-([a-z0-9-]+)\s*::?before/g; // bi-xxx:before
            const set = new Set();
            let m;
            while((m=re.exec(css))){ set.add('bi bi-'+m[1]); }
            all = Array.from(set).sort();
            if(all.length) localStorage.setItem(key, JSON.stringify(all));
          }catch(e){ /* ignore */ }
        }
        if(!all.length){
          all = [
            'bi bi-shield','bi bi-shield-lock','bi bi-shield-check','bi bi-gear','bi bi-gear-fill','bi bi-hammer','bi bi-wrench','bi bi-screwdriver','bi bi-house','bi bi-lightning','bi bi-plug','bi bi-droplet','bi bi-lightbulb','bi bi-briefcase','bi bi-building','bi bi-truck','bi bi-bag','bi bi-basket','bi bi-brush','bi bi-palette','bi bi-check-circle','bi bi-exclamation-triangle','bi bi-x-circle','bi bi-clipboard-check','bi bi-list-check'
          ];
        }
        applyFilter(q.value);
      }

      openBtn.addEventListener('click',()=>{ if(typeof dlg.showModal==='function'){ dlg.showModal(); } else { dlg.setAttribute('open',''); } if(!all.length){ loadList(); } else { applyFilter(q.value); } q.focus(); });
      closeBtn.addEventListener('click',()=> dlg.close());
      q.addEventListener('input',()=> applyFilter(q.value));
      input.addEventListener('input',()=>{ prev.className=input.value; });
      grid.addEventListener('scroll',()=>{ if(grid.scrollTop + grid.clientHeight >= grid.scrollHeight - 20){ paintMore(); } });

      // Initialize preview with current value
      if(input.value){ prev.className = input.value; }
    })();
  </script>
  <label>
    صورة الغلاف
    <div class="form-row">
      <input type="text" name="cover_image_url" value="{{ old('cover_image_url') }}" placeholder="رابط الصورة (اختياري)" class="@error('cover_image_url') is-invalid @enderror" />
      <input type="file" name="cover_image_file" accept="image/*" class="@error('cover_image_file') is-invalid @enderror" />
    </div>
    <small class="muted">يمكنك إدخال رابط أو رفع صورة. سيُستخدم الرابط إن تم إدخاله.</small>
    @error('cover_image_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
    @error('cover_image_file')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </label>
  <label>
    المحتوى
    <textarea name="body" rows="8" class="@error('body') is-invalid @enderror">{{ old('body', $service->body ?? '') }}</textarea>
    @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </label>
  <div class="row-between" style="gap:12px">
    <label style="display:flex; align-items:center; gap:6px">
      <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', ($service->is_featured ?? false)) ? 'checked' : '' }} />
      بارز
    </label>
    <label>
      ترتيب العرض
      <input type="number" name="sort_order" value="{{ old('sort_order', $service->sort_order ?? 0) }}" class="@error('sort_order') is-invalid @enderror" />
      @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </label>
    <label>
      الحالة
      <select name="status">
        @php($st = old('status', $service->status ?? 'published'))
        <option value="draft" {{ $st==='draft' ? 'selected' : '' }}>مسودة</option>
        <option value="published" {{ $st==='published' ? 'selected' : '' }}>منشور</option>
      </select>
    </label>
  </div>
  <div>
    <button class="btn btn-primary" type="submit">حفظ</button>
    <a class="btn btn-outline" href="{{ route('admin.services.index') }}">إلغاء</a>
  </div>
</form>
