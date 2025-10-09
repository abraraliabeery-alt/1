@extends('layouts.app')

@section('content')
  <main class="section">
    <div class="container">
      <div class="section-title">
        <div>
          <span class="kicker">تعديل</span>
          <div class="accent-bar" style="margin-top:.5rem"></div>
        </div>
        <h3 style="margin:0">تعديل مشروع</h3>
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

      <form action="{{ route('projects.update', $project) }}" method="POST" enctype="multipart/form-data" class="card" style="display:grid; gap:12px">
        @csrf
        @method('PUT')
        <label>العنوان
          <input type="text" name="title" value="{{ old('title', $project->title) }}" required />
        </label>
        <div class="grid-3">
          <label>العميل
            <input type="text" name="client" value="{{ old('client', $project->client) }}" />
          </label>
          <label>المدينة
            <input type="text" name="city" value="{{ old('city', $project->city) }}" />
          </label>
          <label>التصنيف
            <input type="text" name="category" value="{{ old('category', $project->category) }}" />
          </label>
        </div>
        <label>الوصف
          <textarea name="description" rows="5">{{ old('description', $project->description) }}</textarea>
        </label>
        <div class="grid-3">
          <label>الحالة
            <select name="status">
              <option value="completed" @selected(old('status', $project->status)==='completed')>منجز</option>
              <option value="in_progress" @selected(old('status', $project->status)==='in_progress')>قيد التنفيذ</option>
            </select>
          </label>
          <label>تاريخ البدء
            <input type="date" name="started_at" value="{{ old('started_at', optional($project->started_at)->format('Y-m-d')) }}" />
          </label>
          <label>تاريخ الانتهاء
            <input type="date" name="finished_at" value="{{ old('finished_at', optional($project->finished_at)->format('Y-m-d')) }}" />
          </label>
        </div>
        <label style="display:flex; align-items:center; gap:8px">
          <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $project->is_featured)) /> مشروع مميز (يظهر في الرئيسية)
        </label>
        @if($project->cover_image)
          <div class="card" style="display:flex; gap:10px; align-items:center">
            <img src="{{ $project->cover_image }}" alt="cover" style="width:120px; height:80px; object-fit:cover; border-radius:8px" />
            <span style="color:var(--muted)">صورة الغلاف الحالية</span>
          </div>
        @endif
        <label>صورة غلاف جديدة (اختياري)
          <input type="file" name="cover" accept="image/*" />
        </label>
        <label>إضافة صور للمعرض (اختياري)
          <input type="file" name="gallery[]" accept="image/*" multiple />
        </label>
        <div class="cta">
          <button type="submit" class="btn btn-primary">تحديث</button>
          <a href="{{ route('projects.show', $project->slug) }}" class="btn btn-outline">إلغاء</a>
        </div>
      </form>
    </div>
  </main>
@endsection
