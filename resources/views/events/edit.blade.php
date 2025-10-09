@extends('layouts.app')

@section('content')
  <main class="section">
    <div class="container">
      <div class="section-title">
        <div>
          <span class="kicker">الفعاليات</span>
          <div class="accent-bar" style="margin-top:.5rem"></div>
        </div>
        <h3 style="margin:0">تعديل فعالية</h3>
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

      <form action="{{ route('events.update', $event) }}" method="POST" enctype="multipart/form-data" class="card" style="display:grid; gap:12px">
        @csrf
        @method('PUT')
        <label>العنوان
          <input type="text" name="title" value="{{ old('title', $event->title) }}" required />
        </label>
        <label>ملخص قصير
          <input type="text" name="summary" value="{{ old('summary', $event->summary) }}" />
        </label>
        <label>الوصف
          <textarea name="description" rows="6">{{ old('description', $event->description) }}</textarea>
        </label>
        <div class="grid-3">
          <label>التصنيف
            <input type="text" name="category" value="{{ old('category', $event->category) }}" />
          </label>
          <label>المدينة
            <input type="text" name="city" value="{{ old('city', $event->city) }}" />
          </label>
          <label>الموقع/القاعة
            <input type="text" name="venue" value="{{ old('venue', $event->venue) }}" />
          </label>
        </div>
        <div class="grid-3">
          <label>تاريخ البدء
            <input type="datetime-local" name="starts_at" value="{{ old('starts_at', optional($event->starts_at)->format('Y-m-d\TH:i')) }}" />
          </label>
          <label>تاريخ الانتهاء
            <input type="datetime-local" name="ends_at" value="{{ old('ends_at', optional($event->ends_at)->format('Y-m-d\TH:i')) }}" />
          </label>
          <label style="display:flex; align-items:center; gap:8px">
            <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $event->is_featured)) /> مميزة
          </label>
        </div>
        <label>الحالة
          <select name="status">
            <option value="scheduled" @selected(old('status', $event->status)==='scheduled')>مجدولة</option>
            <option value="finished" @selected(old('status', $event->status)==='finished')>منتهية</option>
            <option value="canceled" @selected(old('status', $event->status)==='canceled')>ملغاة</option>
          </select>
        </label>

        @if($event->cover_image)
          <div class="card" style="display:flex; gap:10px; align-items:center">
            <img src="{{ $event->cover_image }}" alt="current" style="width:120px; height:80px; object-fit:cover; border-radius:8px" />
            <span style="color:var(--muted)">صورة الغلاف الحالية</span>
          </div>
        @endif
        <label>صورة غلاف جديدة (اختياري)
          <input type="file" name="cover" accept="image/*" />
        </label>

        <div class="cta">
          <button type="submit" class="btn btn-primary">تحديث</button>
          <a href="{{ route('events.show', $event->slug) }}" class="btn btn-outline">إلغاء</a>
        </div>
      </form>
    </div>
  </main>
@endsection
