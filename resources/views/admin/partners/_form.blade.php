<form method="POST" action="{{ $action }}" style="display:grid; gap:12px">
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
    المعرف (slug)
    <input type="text" name="slug" value="{{ old('slug', $partner->slug ?? '') }}" class="@error('slug') is-invalid @enderror" />
    @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </label>
  <label>
    موقع الويب
    <input type="url" name="website_url" value="{{ old('website_url', $partner->website_url ?? '') }}" placeholder="https://..." class="@error('website_url') is-invalid @enderror" />
    @error('website_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </label>
  <label>
    شعار (رابط صورة)
    <input type="text" name="logo" value="{{ old('logo', $partner->logo ?? '') }}" placeholder="/assets/.. أو /uploads/..." class="@error('logo') is-invalid @enderror" />
    @error('logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </label>
  <div class="row-between" style="gap:12px">
    <label>
      ترتيب العرض
      <input type="number" name="sort_order" value="{{ old('sort_order', $partner->sort_order ?? 0) }}" class="@error('sort_order') is-invalid @enderror" />
      @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </label>
    <label>
      الحالة
      @php($st = old('status', $partner->status ?? 'published'))
      <select name="status">
        <option value="draft" {{ $st==='draft' ? 'selected' : '' }}>مسودة</option>
        <option value="published" {{ $st==='published' ? 'selected' : '' }}>منشور</option>
      </select>
    </label>
  </div>
  <div>
    <button class="btn btn-primary" type="submit">حفظ</button>
    <a class="btn btn-outline" href="{{ route('admin.partners.index') }}">إلغاء</a>
  </div>
</form>
