<form method="POST" action="{{ $action }}" style="display:grid; gap:12px">
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
    المعرف (slug)
    <input type="text" name="slug" value="{{ old('slug', $service->slug ?? '') }}" class="@error('slug') is-invalid @enderror" />
    @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </label>
  <label>
    ملخص مختصر
    <input type="text" name="excerpt" value="{{ old('excerpt', $service->excerpt ?? '') }}" class="@error('excerpt') is-invalid @enderror" />
    @error('excerpt')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </label>
  <label>
    الأيقونة
    <input type="text" name="icon" value="{{ old('icon', $service->icon ?? '') }}" placeholder="bi bi-shield" class="@error('icon') is-invalid @enderror" />
    @error('icon')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </label>
  <label>
    صورة الغلاف (رابط)
    <input type="text" name="cover_image" value="{{ old('cover_image', $service->cover_image ?? '') }}" placeholder="/assets/.. أو /uploads/..." class="@error('cover_image') is-invalid @enderror" />
    @error('cover_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
