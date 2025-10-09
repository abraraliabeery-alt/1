@extends('layouts.app')

@section('content')
  <main class="section">
    <div class="container">
      @if(session('ok'))
        <div class="card" style="margin-bottom:12px; border-color:#22c55e"><strong>تم:</strong> {{ session('ok') }}</div>
      @endif

      <div style="display:flex; justify-content:space-between; align-items:center; gap:8px; flex-wrap:wrap">
        <h2 style="margin:0">الفعاليات</h2>
        @auth
          @if(optional(auth()->user())->is_staff)
            <a class="btn btn-outline" href="{{ route('events.create') }}">إضافة فعالية</a>
          @endif
        @endauth
      </div>

      <form method="GET" class="card" style="margin:12px 0; display:grid; gap:8px; grid-template-columns: repeat(4, 1fr);">
        <input type="text" name="city" value="{{ request('city') }}" placeholder="المدينة" />
        <input type="text" name="category" value="{{ request('category') }}" placeholder="التصنيف" />
        <label style="display:flex; align-items:center; gap:6px"><input type="checkbox" name="upcoming" value="1" @checked(request('upcoming'))> القادمة فقط</label>
        <div style="grid-column: 1 / -1; display:flex; gap:8px;">
          <button class="btn btn-primary" type="submit">تصفية</button>
          <a class="btn btn-outline" href="{{ route('events.index') }}">إعادة ضبط</a>
        </div>
      </form>

      @if($events->count())
        <div class="grid-3">
          @foreach($events as $ev)
            <article class="card" style="display:flex; flex-direction:column; gap:8px">
              @if($ev->cover_image)
                <a href="{{ route('events.show', $ev->slug) }}">
                  <img src="{{ $ev->cover_image }}" alt="{{ $ev->title }}" style="width:100%; height:180px; object-fit:cover; border-radius:12px" />
                </a>
              @endif
              <div style="display:flex; justify-content:space-between; align-items:center">
                <h3 style="margin:0; font-size:1.1rem"><a href="{{ route('events.show', $ev->slug) }}">{{ $ev->title }}</a></h3>
                @if($ev->starts_at)
                  <time style="color:var(--muted)">{{ $ev->starts_at->format('Y-m-d') }}</time>
                @endif
              </div>
              <p style="color:var(--muted); margin:0">{{ $ev->city }} @if($ev->venue) • {{ $ev->venue }} @endif</p>
              @if($ev->summary)
                <p style="margin:0">{{ \Illuminate\Support\Str::limit($ev->summary, 120) }}</p>
              @endif
            </article>
          @endforeach
        </div>
        <div style="margin-top:16px">{{ $events->links() }}</div>
      @else
        <p style="text-align:center; color:var(--muted)">لا توجد فعاليات حالياً.</p>
      @endif
    </div>
  </main>
@endsection
