@extends('layouts.app')

@section('content')
  <main class="section">
    <div class="container">
      <nav style="margin-bottom:12px"><a href="{{ route('gallery.index') }}">← الرجوع للألبوم</a></nav>

      <h1 style="margin:0 0 8px">{{ $item->title }}</h1>
      <p style="color:var(--muted); margin:0 0 12px">
        @if($item->city) {{ $item->city }} • @endif
        @if($item->category) {{ $item->category }} • @endif
        @if($item->taken_at) {{ optional($item->taken_at)->format('Y-m-d') }} @endif
      </p>

      <div class="grid-2" style="gap:16px">
        <div>
          <img src="{{ $item->image_path }}" alt="{{ $item->title }}" style="border-radius:14px; width:100%; height:auto" />
        </div>
        <div>
          @if($item->caption)
            <div class="card" style="margin-bottom:12px">
              <h4 style="margin:0 0 8px">الوصف</h4>
              <p style="margin:0">{{ $item->caption }}</p>
            </div>
          @endif
          @auth
            @if(optional(auth()->user())->is_staff)
              <div class="cta" style="display:flex; gap:8px; flex-wrap:wrap">
                <a class="btn btn-outline" href="{{ route('gallery.edit', $item) }}">تعديل</a>
                <form action="{{ route('gallery.destroy', $item) }}" method="POST" data-confirm="حذف الصورة؟">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-outline" type="submit">حذف</button>
                </form>
              </div>
            @endif
          @endauth
        </div>
      </div>
    </div>
  </main>
@endsection
