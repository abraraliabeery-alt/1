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

      

      @if($items->count())
        <div class="gallery" style="gap:8px">
          @foreach($items as $it)
            <article class="tile" style="padding:0; margin:0; background:transparent; border:none; box-shadow:none">
              <a href="{{ $it->image_path }}" data-lightbox="gallery" style="display:block">
                <div style="position:relative; width:100%; aspect-ratio: 4 / 3; overflow:hidden; border-radius:10px">
                  <img src="{{ $it->image_path }}" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; display:block;"/>
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
