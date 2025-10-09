@extends('layouts.app')

@section('content')
  <main class="section">
    <div class="container">
      <div class="section-title">
        <div>
          <span class="kicker">إضافة</span>
          <div class="accent-bar" style="margin-top:.5rem"></div>
        </div>
        <h3 style="margin:0">إضافة مشروع</h3>
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

      <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data" class="card" style="display:grid; gap:12px">
        @csrf
        <label>العنوان
          <input type="text" name="title" value="{{ old('title') }}" required />
        </label>
        <div class="grid-3">
          <label>العميل
            <input type="text" name="client" value="{{ old('client') }}" />
          </label>
          <label>المدينة
            <input type="text" name="city" value="{{ old('city') }}" />
          </label>
          <label>التصنيف
            <input type="text" name="category" value="{{ old('category') }}" placeholder="فيلا، مكتب، متجر..." />
          </label>
        </div>
        <label>الوصف
          <textarea name="description" rows="5">{{ old('description') }}</textarea>
        </label>
        <div class="grid-3">
          <label>الحالة
            <select name="status">
              <option value="completed" @selected(old('status')==='completed')>منجز</option>
              <option value="in_progress" @selected(old('status')==='in_progress')>قيد التنفيذ</option>
            </select>
          </label>
          <label>تاريخ البدء
            <input type="date" name="started_at" value="{{ old('started_at') }}" />
          </label>
          <label>تاريخ الانتهاء
            <input type="date" name="finished_at" value="{{ old('finished_at') }}" />
          </label>
        </div>
        <label style="display:flex; align-items:center; gap:8px">
          <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured')) /> مشروع مميز (يظهر في الرئيسية)
        </label>
        <label>صورة الغلاف
          <input type="file" name="cover" accept="image/*" />
        </label>
        <label>معرض الصور (متعددة)
          <input type="file" name="gallery[]" accept="image/*" multiple />
        </label>
        <div class="cta">
          <button type="submit" class="btn btn-primary">حفظ</button>
          <a href="{{ route('projects.index') }}" class="btn btn-outline">إلغاء</a>
        </div>
      </form>
    </div>
  </main>
@endsection
