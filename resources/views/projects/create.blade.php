@extends('layouts.admin')

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
          <input type="text" name="title" value="{{ old('title') }}" required class="@error('title') is-invalid @enderror" />
          @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </label>
        <div class="grid-3">
          <label>العميل
            <input type="text" name="client" value="{{ old('client') }}" class="@error('client') is-invalid @enderror" />
            @error('client')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </label>
          <label>المدينة
            <select name="city" class="@error('city') is-invalid @enderror">
              @php($cityOld = old('city'))
              <option value="">اختر المدينة</option>
              <option value="الرياض" {{ $cityOld==='الرياض' ? 'selected' : '' }}>الرياض</option>
            </select>
            @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </label>
          <label>التصنيف
            <select name="category" class="@error('category') is-invalid @enderror">
              @php($catOld = old('category'))
              <option value="">اختر التصنيف</option>
              <option value="فيلا" {{ $catOld==='فيلا' ? 'selected' : '' }}>فيلا</option>
              <option value="مكتب" {{ $catOld==='مكتب' ? 'selected' : '' }}>مكتب</option>
              <option value="متجر" {{ $catOld==='متجر' ? 'selected' : '' }}>متجر</option>
              <option value="مجمع" {{ $catOld==='مجمع' ? 'selected' : '' }}>مجمع</option>
              <option value="مصنع" {{ $catOld==='مصنع' ? 'selected' : '' }}>مصنع</option>
            </select>
            @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </label>
        </div>
        <label>الوصف
          <textarea name="description" rows="5" class="@error('description') is-invalid @enderror">{{ old('description') }}</textarea>
          @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </label>
        <div class="grid-3">
          <label>الحالة
            <select name="status" class="@error('status') is-invalid @enderror">
              <option value="completed" @selected(old('status')==='completed')>منجز</option>
              <option value="in_progress" @selected(old('status')==='in_progress')>قيد التنفيذ</option>
            </select>
            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </label>
          <label>تاريخ البدء
            <input type="date" name="started_at" value="{{ old('started_at') }}" class="@error('started_at') is-invalid @enderror" />
            @error('started_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </label>
          <label>تاريخ الانتهاء
            <input type="date" name="finished_at" value="{{ old('finished_at') }}" class="@error('finished_at') is-invalid @enderror" />
            @error('finished_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </label>
        </div>
        <label style="display:flex; align-items:center; gap:8px">
          <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured')) /> مشروع مميز (يظهر في الرئيسية)
        </label>
        <label>صورة الغلاف
          <input type="file" name="cover" accept="image/*" class="@error('cover') is-invalid @enderror" />
          @error('cover')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </label>
        <label>معرض الصور (متعددة)
          <input type="file" name="gallery[]" accept="image/*" multiple class="@error('gallery') is-invalid @enderror" />
          @error('gallery')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </label>
        <div class="cta">
          <button type="submit" class="btn btn-primary">حفظ</button>
          <a href="{{ route('projects.index') }}" class="btn btn-outline">إلغاء</a>
        </div>
      </form>
    </div>
  </main>
@endsection
