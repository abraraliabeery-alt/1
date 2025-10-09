@extends('layouts.app')

@section('content')
  <main class="section">
    <div class="container">
      <div class="section-title">
        <div>
          <span class="kicker">الفعاليات</span>
          <div class="accent-bar" style="margin-top:.5rem"></div>
        </div>
        <h3 style="margin:0">إضافة فعالية</h3>
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

      <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data" class="card" style="display:grid; gap:12px">
        @csrf
        <label>العنوان
          <input type="text" name="title" value="{{ old('title') }}" required />
        </label>
        <label>ملخص قصير
          <input type="text" name="summary" value="{{ old('summary') }}" />
        </label>
        <label>الوصف
          <textarea name="description" rows="6">{{ old('description') }}</textarea>
        </label>
        <div class="grid-3">
          <label>التصنيف
            <input type="text" name="category" value="{{ old('category') }}" />
          </label>
          <label>المدينة
            <input type="text" name="city" value="{{ old('city') }}" />
          </label>
          <label>الموقع/القاعة
            <input type="text" name="venue" value="{{ old('venue') }}" />
          </label>
        </div>
        <div class="grid-3">
          <label>تاريخ البدء
            <input type="datetime-local" name="starts_at" value="{{ old('starts_at') }}" />
          </label>
          <label>تاريخ الانتهاء
            <input type="datetime-local" name="ends_at" value="{{ old('ends_at') }}" />
          </label>
          <label style="display:flex; align-items:center; gap:8px">
            <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured')) /> مميزة
          </label>
        </div>
        <label>الحالة
          <select name="status">
            <option value="scheduled" @selected(old('status')==='scheduled')>مجدولة</option>
            <option value="finished" @selected(old('status')==='finished')>منتهية</option>
            <option value="canceled" @selected(old('status')==='canceled')>ملغاة</option>
          </select>
        </label>
        <label>صورة الغلاف (اختياري)
          <input type="file" name="cover" accept="image/*" />
        </label>
        <div class="cta">
          <button type="submit" class="btn btn-primary">حفظ</button>
          <a href="{{ route('events.index') }}" class="btn btn-outline">إلغاء</a>
        </div>
      </form>
    </div>
  </main>
@endsection
