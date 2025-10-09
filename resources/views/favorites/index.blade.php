@extends('layouts.app')

@section('content')
<section class="section">
  <div class="section-title">
    <div>
      <span class="kicker">المفضلة</span>
      <div class="accent-bar" style="margin-top:.5rem"></div>
    </div>
    <h3 style="margin:0">عقاراتي المفضلة</h3>
  </div>

  @if(session('ok'))
    <div class="card" style="border-color:#bbf7d0; background:#f0fdf4">{{ session('ok') }}</div>
  @endif

  <div class="row g-4">
    @forelse($favs as $fav)
      <div class="col-12 col-md-6 col-lg-4">
        @if($fav->property)
          <x-property-card :p="$fav->property" />
        @else
          <div class="card p-3">هذا العقار لم يعد متاحًا.</div>
        @endif
      </div>
    @empty
      <div class="col-12">
        <div class="card" style="padding:1rem">لا توجد عناصر في المفضلة بعد.</div>
      </div>
    @endforelse
  </div>

  <div style="margin-top:1rem">
    {{ $favs->links() }}
  </div>
</section>
@endsection
