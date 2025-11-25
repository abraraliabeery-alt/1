@extends('layouts.app')

@section('content')
  <main class="section">
    <div class="container">
      <nav style="margin-bottom:12px"><a href="{{ route('events.index') }}">← كل الفعاليات</a></nav>

      <h1 style="margin:0 0 8px">{{ $event->title }}</h1>
      <p style="color:var(--muted); margin:0 0 12px">
        @if($event->city) {{ $event->city }} @endif
        @if($event->venue) • {{ $event->venue }} @endif
        @if($event->starts_at) • {{ $event->starts_at->format('Y-m-d H:i') }} @endif
        @if($event->ends_at) — {{ $event->ends_at->format('Y-m-d H:i') }} @endif
      </p>

      <div class="grid-2" style="gap:16px">
        <div>
          @if($event->cover_image)
            <img src="{{ $event->cover_image }}" alt="{{ $event->title }}" style="border-radius:14px; width:100%; height:auto" />
          @endif
          @if($event->description)
            <div class="card" style="margin-top:12px">
              {!! nl2br(e($event->description)) !!}
            </div>
          @endif
        </div>
        <aside>
          @if($event->summary)
            <div class="card" style="margin-bottom:12px">
              <h4 style="margin:0 0 8px">الملخص</h4>
              <p style="margin:0">{{ $event->summary }}</p>
            </div>
          @endif
          @auth
            @if(optional(auth()->user())->is_staff)
              <div class="cta" style="display:flex; gap:8px; flex-wrap:wrap">
                <a class="btn btn-outline" href="{{ route('events.edit', $event) }}">تعديل</a>
                <form action="{{ route('events.destroy', $event) }}" method="POST" data-confirm="حذف الفعالية؟">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-outline" type="submit">حذف</button>
                </form>
              </div>
            @endif
          @endauth
        </aside>
      </div>
    </div>
  </main>
@endsection
