@php($p = $p ?? null)
@if($p)
@php($hasImg = filled($p->cover_image))
<a href="{{ route('properties.show',$p->slug) }}" class="card card-zoom text-decoration-none" style="display:block; overflow:hidden">
  <div class="img-wrap" style="position:relative">
    <div style="position:relative; height:0; padding-bottom:66.66%; background:#f5f5f5; border-bottom:1px solid var(--border); @if($hasImg) background:url('{{ $p->cover_image }}') center/cover no-repeat; @endif"></div>
    @if(!empty($p->type))
      <span class="badge bg-accent" style="position:absolute; top:.6rem; inset-inline-start:.6rem">{{ $p->type_label }}</span>
    @endif
    <span class="badge price-badge" style="position:absolute; bottom:.6rem; inset-inline-start:.6rem">{{ number_format((int)$p->price) }} ر.س</span>
    @if(!empty($p->is_featured))
      <span class="badge" style="position:absolute; top:.6rem; inset-inline-end:.6rem; background:var(--ink); color:#fff">مميز</span>
    @endif
  </div>
  <div class="p-3 content">
    <div class="fw-bolder" style="color:var(--ink); line-height:1.4">{{ $p->title }}</div>
    <div class="mt-1 d-flex align-items-center gap-2 text-muted small">
      @if($p->city)
        <span><i class='bx bx-map-pin align-middle'></i> {{ $p->city }}@if($p->district) — {{ $p->district }} @endif</span>
      @endif
    </div>
    <div class="meta mt-2 d-flex align-items-center gap-3 text-muted">
      @if($p->bedrooms)
        <span><i class='bx bx-bed align-middle'></i> {{ (int)$p->bedrooms }}</span>
      @endif
      @if($p->bathrooms)
        <span><i class='bx bx-bath align-middle'></i> {{ (int)$p->bathrooms }}</span>
      @endif
      @if($p->area)
        <span><i class='bx bx-ruler align-middle'></i> {{ (int)$p->area }} م²</span>
      @endif
      @if($p->location_url)
        <span class="ms-auto"><i class='bx bx-navigation align-middle'></i></span>
      @endif
    </div>
  </div>
</a>
@endif
