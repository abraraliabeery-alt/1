@extends('layouts.app')

@section('content')
  <main class="section">
    <div class="container">
      <div class="section-title">
        <div>
          <span class="kicker">الألبوم</span>
          <div class="accent-bar" style="margin-top:.5rem"></div>
        </div>
        <h3 style="margin:0">تعديل صورة</h3>
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

      <form action="{{ route('gallery.update', $item) }}" method="POST" enctype="multipart/form-data" class="card" style="display:grid; gap:12px">
        @csrf
        @method('PUT')
        <label>العنوان
          <input type="text" name="title" value="{{ old('title', $item->title) }}" required />
        </label>
        <div class="grid-3">
          <label>وصف قصير
            <input type="text" name="caption" value="{{ old('caption', $item->caption) }}" />
          </label>
          <label>التصنيف
            <input type="text" name="category" value="{{ old('category', $item->category) }}" />
          </label>
          <label>المدينة
            <input type="text" name="city" value="{{ old('city', $item->city) }}" />
          </label>
        </div>
        <div class="grid-3">
          <label>تاريخ الالتقاط
            <input type="date" name="taken_at" value="{{ old('taken_at', optional($item->taken_at)->format('Y-m-d')) }}" />
          </label>
          <label>ترتيب العرض
            <input type="number" min="0" name="sort_order" value="{{ old('sort_order', $item->sort_order) }}" />
          </label>
          <label style="display:flex; align-items:center; gap:8px">
            <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $item->is_featured)) /> صورة مميزة (تظهر أولاً)
          </label>
        </div>

        @if($item->image_path)
          <div class="card" style="display:flex; gap:10px; align-items:center">
            <img src="{{ $item->image_path }}" alt="current" style="width:120px; height:80px; object-fit:cover; border-radius:8px" />
            <span style="color:var(--muted)">الصورة الحالية</span>
          </div>
        @endif
        <label>صورة جديدة (اختياري)
          <input type="file" name="image" accept="image/*" />
        </label>

        <div class="cta">
          <button type="submit" class="btn btn-primary">تحديث</button>
          <a href="{{ route('gallery.show', $item->slug) }}" class="btn btn-outline">إلغاء</a>
        </div>
      </form>
    </div>
  </main>
@endsection
