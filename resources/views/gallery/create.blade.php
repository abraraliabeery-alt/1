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
        <label>الصورة
          <input type="file" name="image" accept="image/*" required class="@error('image') is-invalid @enderror" />
          @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
          <small class="muted">اختر صورة واحدة وسيتم إضافتها للألبوم.</small>
        </label>
        <div class="cta">
          <button type="submit" class="btn btn-primary">حفظ</button>
          <a href="{{ route('gallery.index') }}" class="btn btn-outline">إلغاء</a>
        </div>
      </form>
    </div>
  </main>
@endsection
