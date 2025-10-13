@php($isEdit = isset($faq) && $faq && $faq->exists)
<form action="{{ $action }}" method="POST" class="card" style="display:grid; gap:12px; padding:16px">
  @csrf
  @if(($method ?? 'POST') !== 'POST')
    @method($method)
  @endif

  <label>
    السؤال
    <input type="text" name="question" value="{{ old('question', $faq->question ?? '') }}" required class="@error('question') is-invalid @enderror" />
    @error('question')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </label>

  <label>
    الإجابة
    <textarea name="answer" rows="5" required class="@error('answer') is-invalid @enderror">{{ old('answer', $faq->answer ?? '') }}</textarea>
    @error('answer')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </label>

  <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px">
    <label>
      الحالة
      <select name="status" class="@error('status') is-invalid @enderror">
        @php($st = old('status', $faq->status ?? 'published'))
        <option value="published" {{ $st==='published'?'selected':'' }}>منشور</option>
        <option value="draft" {{ $st==='draft'?'selected':'' }}>مسودة</option>
      </select>
      @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </label>
    <label>
      الترتيب
      <input type="number" name="sort_order" min="0" value="{{ old('sort_order', $faq->sort_order ?? 0) }}" class="@error('sort_order') is-invalid @enderror" />
      @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </label>
  </div>

  <div style="display:flex; gap:8px; align-items:center">
    <button class="btn btn-primary" type="submit">حفظ</button>
    <a class="btn btn-outline" href="{{ route('admin.faqs.index') }}">إلغاء</a>
  </div>
</form>
