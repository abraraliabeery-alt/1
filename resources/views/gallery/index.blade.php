@extends('layouts.app')

@section('content')
  <main class="section">
    <div class="container">
      @if(session('ok'))
        <div class="card" style="margin-bottom:12px; border-color:#22c55e"><strong>تم:</strong> {{ session('ok') }}</div>
      @endif

      <div style="display:flex; justify-content:space-between; align-items:center; gap:8px; flex-wrap:wrap">
        <h2 style="margin:0">ألبوم الأعمال</h2>
        @auth
          @if(optional(auth()->user())->is_staff)
            <a class="btn btn-outline" href="{{ route('gallery.create') }}">إضافة صورة</a>
          @endif
        @endauth
      </div>

      <form method="GET" class="card" style="margin:12px 0; display:grid; gap:8px; grid-template-columns: repeat(3, 1fr);">
        <input type="text" name="city" value="{{ request('city') }}" placeholder="المدينة" />
        <input type="text" name="category" value="{{ request('category') }}" placeholder="التصنيف" />
        <div style="grid-column: 1 / -1; display:flex; gap:8px;">
          <button class="btn btn-primary" type="submit">تصفية</button>
          <a class="btn btn-outline" href="{{ route('gallery.index') }}">إعادة ضبط</a>
        </div>
      </form>

      @if($items->count())
        <div class="gallery">
          @foreach($items as $it)
            <article class="tile" style="position:relative; overflow:hidden; display:block;">
              <a href="{{ route('gallery.show', $it->slug) }}" style="display:block; text-decoration:none; color:inherit">
                <img src="{{ $it->image_path }}" alt="{{ $it->title }}" style="width:100%; height:100%; object-fit:cover; border-radius:14px;"/>
                <div style="position:absolute; inset:auto 8px 8px 8px; background:rgba(255,255,255,0.9); border:1px solid var(--border); border-radius:12px; padding:8px 10px; display:flex; justify-content:space-between; gap:8px; align-items:center;">
                  <strong style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:60%">{{ $it->title }}</strong>
                  <span style="font-weight:800; color:var(--primary);">{{ $it->city ?? $it->category }}</span>
                </div>
              </a>
            </article>
          @endforeach
        </div>
        <div style="margin-top:16px;">{{ $items->links() }}</div>
      @else
        <p style="text-align:center; color:var(--muted)">لا توجد صور حالياً.</p>
      @endif
    </div>
  </main>
@endsection
