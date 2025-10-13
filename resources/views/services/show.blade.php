@extends('layouts.app')

@section('content')
  <main class="section">
    <div class="container" style="max-width:880px">
      <nav style="margin-bottom:12px"><a class="btn btn-link" href="{{ route('services.index') }}">← كل الخدمات</a></nav>
      <header>
        <h1 style="margin-top:0">{{ $service->title }}</h1>
        @if($service->excerpt)
          <p class="text-muted">{{ $service->excerpt }}</p>
        @endif
      </header>
      @if($service->cover_image)
        <img src="{{ $service->cover_image }}" alt="{{ $service->title }}" style="width:100%;height:auto;border-radius:8px;margin:12px 0" />
      @endif
      <article class="prose">
        {!! nl2br(e($service->body)) !!}
      </article>
    </div>
  </main>
@endsection
