@extends('layouts.app')

@section('content')
  <main class="section">
    <div class="container">
      <h1>الخدمات</h1>
      <form method="get" class="row-between" style="gap:8px; margin:12px 0">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="ابحث عن خدمة" />
        <button class="btn btn-outline" type="submit">بحث</button>
      </form>
      @if($services->count())
        <div class="grid-3">
          @foreach($services as $svc)
            <article class="card" style="padding:16px">
              <h3 class="h3-compact"><a href="{{ route('services.show', $svc->slug) }}">{{ $svc->title }}</a></h3>
              @if($svc->excerpt)
                <p class="text-muted">{{ $svc->excerpt }}</p>
              @endif
            </article>
          @endforeach
        </div>
        <div style="margin-top:16px">{{ $services->links() }}</div>
      @else
        <p class="text-muted">لا توجد خدمات حالياً.</p>
      @endif
    </div>
  </main>
@endsection
