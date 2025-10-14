@extends('layouts.app')

@section('content')
  <main class="section">
    <div class="container">
      {{-- Flash messages --}}
      @if(session('ok'))
        <div class="card" style="margin-bottom:12px; border-color:#22c55e"><strong>تم:</strong> {{ session('ok') }}</div>
      @endif

      <h2>المشاريع</h2>
      @auth
        @if(optional(auth()->user())->is_staff)
          <div class="card" style="margin-bottom:12px; padding:10px">
            <a class="btn btn-outline" href="{{ route('projects.create') }}">إضافة مشروع</a>
          </div>
        @endif
      @endauth

      @if($projects->count())
        <div class="gallery">
          @foreach($projects as $proj)
            <article class="tile" style="position:relative; overflow:hidden; display:block;">
              <a href="{{ route('projects.show', $proj->slug) }}" style="display:block; text-decoration:none; color:inherit">
                @if($proj->cover_image)
                  <img src="{{ $proj->cover_image }}" alt="{{ $proj->title }}" style="width:100%; height:100%; object-fit:cover; border-radius:14px;"/>
                @else
                  <div style="width:100%; height:100%; border-radius:14px; background:linear-gradient(135deg,#eaf2ff,#fff)"></div>
                @endif
                <div style="position:absolute; inset:auto 8px 8px 8px; background:rgba(255,255,255,0.9); border:1px solid var(--border); border-radius:12px; padding:8px 10px; display:flex; justify-content:space-between; gap:8px; align-items:center;">
                  <strong style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:60%">{{ $proj->title }}</strong>
                  <span style="font-weight:800; color:var(--primary);">{{ $proj->city ?? $proj->category }}</span>
                </div>
              </a>
            </article>
          @endforeach
        </div>
        <div style="margin-top:16px;">{{ $projects->links() }}</div>
      @else
        <p style="text-align:center; color:var(--muted)">لا توجد مشاريع حالياً.</p>
      @endif
    </div>
  </main>
@endsection
