@extends('layouts.app')

@section('content')
  <main class="section">
    <div class="container">
      <div class="section-title">
        <div>
          <span class="kicker">الألبوم</span>
          <div class="accent-bar" style="margin-top:.5rem"></div>
        </div>
        <h3 style="margin:0">إضافة صورة</h3>
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

      <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data" class="card" style="display:grid; gap:12px">
        @csrf
        <label>العنوان
          <input type="text" name="title" value="{{ old('title') }}" required />
        </label>
        <div class="grid-3">
          <label>وصف قصير
            <input type="text" name="caption" value="{{ old('caption') }}" />
          </label>
          <label>التصنيف
            <input type="text" name="category" value="{{ old('category') }}" placeholder="فيلا، مكتب، متجر..." />
          </label>
          <label>المدينة
            <input type="text" name="city" value="{{ old('city') }}" />
          </label>
        </div>
        <div class="grid-3">
          <label>تاريخ الالتقاط
            <input type="date" name="taken_at" value="{{ old('taken_at') }}" />
          </label>
          <label>ترتيب العرض
            <input type="number" min="0" name="sort_order" value="{{ old('sort_order', 0) }}" />
          </label>
          <label style="display:flex; align-items:center; gap:8px">
            <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured')) /> صورة مميزة (تظهر أولاً)
          </label>
        </div>
        <label>الصور (يمكن اختيار عدة صور)
          <input type="file" name="images[]" accept="image/*" multiple required />
          <small class="muted">اختر صورة أو أكثر وسيتم إنشاء عنصر لكل صورة تلقائياً.</small>
        </label>
        <div class="cta">
          <button type="submit" class="btn btn-primary">حفظ</button>
          <a href="{{ route('gallery.index') }}" class="btn btn-outline">إلغاء</a>
        </div>
      </form>
    </div>
  </main>
@endsection
