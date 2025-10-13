@extends('layouts.app')

@section('content')
  <main class="section">
    <div class="container">
      <div class="section-title" style="display:flex;justify-content:space-between;align-items:center;gap:8px;flex-wrap:wrap">
        <h3 style="margin:0">ترتيب الصور</h3>
        <a href="{{ route('gallery.index') }}" class="btn btn-outline">العودة للألبوم</a>
      </div>

      @if(session('ok'))
        <div class="card" style="margin-bottom:12px; border-color:#22c55e"><strong>تم:</strong> {{ session('ok') }}</div>
      @endif

      <form action="{{ route('gallery.sort.save') }}" method="POST" class="card" style="display:grid; gap:12px">
        @csrf
        <p class="muted" style="margin:0">عدّل القيم بالأرقام (0,1,2...)؛ الأصغر يظهر أولاً.</p>
        <div class="gallery">
          @foreach($items as $it)
            <article class="tile" style="display:flex; flex-direction:column; gap:8px;">
              <img src="{{ $it->image_path }}" alt="{{ $it->title }}" style="width:100%; height:100%; object-fit:cover; border-radius:14px;"/>
              <label style="display:flex; align-items:center; gap:8px;">
                <span style="min-width:60px">ترتيب</span>
                <input type="number" name="orders[{{ $it->id }}]" value="{{ $it->sort_order }}" min="0" style="flex:1" />
              </label>
            </article>
          @endforeach
        </div>
        <div class="cta">
          <button class="btn btn-primary" type="submit">حفظ الترتيب</button>
        </div>
      </form>
    </div>
  </main>
@endsection
