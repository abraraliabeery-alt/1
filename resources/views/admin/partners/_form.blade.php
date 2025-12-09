<form method="POST" action="{{ $action }}" enctype="multipart/form-data" style="display:grid; gap:12px">
  @csrf
  @if($method !== 'POST')
    @method($method)
  @endif
  <label>
    الاسم
    <input type="text" name="name" value="{{ old('name', $partner->name ?? '') }}" required class="@error('name') is-invalid @enderror" />
    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </label>
  <label>
    موقع الويب
    <input type="url" name="website_url" value="{{ old('website_url', $partner->website_url ?? '') }}" placeholder="https://..." class="@error('website_url') is-invalid @enderror" />
    @error('website_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </label>
  <label>
    الشعار
    <div class="form-row">
      <input type="text" name="logo_url" value="{{ old('logo_url') }}" placeholder="رابط الصورة (اختياري)" class="@error('logo_url') is-invalid @enderror" />
      <input type="file" name="logo_file" accept="image/*" class="@error('logo_file') is-invalid @enderror" />
    </div>
    <small class="muted">يمكنك إدخال رابط أو رفع صورة. سيُستخدم الرابط إن تم إدخاله.</small>
    @error('logo_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
    @error('logo_file')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </label>
  <div class="row-between" style="gap:12px">
    <label>
      ترتيب العرض
      <input type="number" name="sort_order" value="{{ old('sort_order', $partner->sort_order ?? 0) }}" class="@error('sort_order') is-invalid @enderror" />
      @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </label>
    <label>
      الحالة
      <select name="status">
        <option value="draft" @selected(old('status', $partner->status ?? 'published')==='draft')>مسودة</option>
        <option value="published" @selected(old('status', $partner->status ?? 'published')==='published')>منشور</option>
      </select>
    </label>
  </div>
  <div>
    <button class="btn btn-primary" type="submit">حفظ</button>
    <a class="btn btn-outline" href="{{ route('admin.partners.index') }}">إلغاء</a>
  </div>
</form>
