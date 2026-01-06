@extends('layouts.app')

@section('hideSiteChrome', true)

@section('head_extra')
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
<style>
  .t4ps-bg{ background: radial-gradient(900px 420px at 70% 10%, color-mix(in oklab, var(--primary), transparent 88%), transparent 60%), linear-gradient(180deg, color-mix(in oklab, var(--bg), var(--fg) 86%), color-mix(in oklab, var(--bg), var(--fg) 92%)); }
  .t4ps-panel{ background: color-mix(in oklab, var(--bg), transparent 4%); }
  .t4ps-text-on-dark{ color: var(--footer-fg) }
  .t4ps-accent{ color: var(--primary) }
  .t4ps-pill{ background: color-mix(in oklab, var(--fg), transparent 70%); color: var(--footer-fg) }
  .t4ps-pill .t4ps-accent{ color: var(--primary) }
  .t4ps-media-ph{ background: color-mix(in oklab, var(--bg), var(--fg) 10%) }
  .t4ps-price{ color: var(--primary) }
  .t4ps-surface{ color: var(--strong-text) }
  .t4ps-subtle{ color: color-mix(in oklab, var(--strong-text), transparent 30%) }
  .t4ps-border{ border-color: color-mix(in oklab, var(--fg), transparent 86%) }
  .t4ps-tag{ background: color-mix(in oklab, var(--bg), var(--fg) 8%); border-color: color-mix(in oklab, var(--fg), transparent 86%); color: color-mix(in oklab, var(--strong-text), transparent 20%) }
  .t4ps-btn-primary{ background: var(--primary); color: var(--strong-text) }
  .t4ps-btn-primary:hover{ background: color-mix(in oklab, var(--primary), var(--fg) 12%) }
  .t4ps-btn-dark{ background: color-mix(in oklab, var(--bg), var(--fg) 86%); color: var(--footer-fg) }
  .t4ps-btn-dark:hover{ background: color-mix(in oklab, var(--bg), var(--fg) 82%) }
  .t4ps-btn-map{ background: color-mix(in oklab, var(--bg), transparent 0%); color: var(--strong-text); border-color: color-mix(in oklab, var(--fg), transparent 86%) }
</style>
@endsection

@section('content')
<div dir="rtl" class="t4ps-bg min-h-screen t4ps-text-on-dark">
  <div class="container mx-auto px-4 py-10">
    <div class="flex flex-wrap items-start justify-between gap-4 mb-4">
      <div>
        <a href="{{ route('properties.index') }}" class="inline-flex items-center gap-2 t4ps-accent font-bold" style="text-decoration:none">
          <i class="fa-solid fa-arrow-right"></i> رجوع للعقارات
        </a>
        <h1 class="t4ps-text-on-dark text-3xl md:text-5xl font-extrabold mt-3">{{ $property->title }}</h1>
        <div class="mt-2 flex flex-wrap gap-2 text-sm">
          <span class="inline-flex items-center gap-2 t4ps-pill px-3 py-1 rounded-full"><i class="fa-solid fa-location-dot t4ps-accent"></i> {{ $property->address }}</span>
          <span class="inline-flex items-center gap-2 t4ps-pill px-3 py-1 rounded-full"><i class="fa-solid fa-tag t4ps-accent"></i> {{ $property->type_label ?? $property->type }}</span>
          @if($property->status)
            <span class="inline-flex items-center gap-2 t4ps-pill px-3 py-1 rounded-full"><i class="fa-solid fa-circle-check t4ps-accent"></i> {{ $property->status }}</span>
          @endif
        </div>
      </div>
      <div class="t4ps-price font-extrabold text-2xl md:text-3xl">{{ number_format($property->price) }} ر.س</div>
    </div>

    <div class="grid lg:grid-cols-3 gap-4">
      <div class="lg:col-span-2">
        <div class="t4ps-panel rounded-2xl overflow-hidden">
          <div class="aspect-[16/10] t4ps-media-ph">
            @if($property->primary_image_url)
              <a href="{{ $property->primary_image_url }}" class="glightbox" data-gallery="prop-{{ $property->id }}">
                <img src="{{ $property->primary_image_url }}" alt="{{ $property->title }}" class="w-full h-full object-cover" loading="lazy" />
              </a>
            @endif
          </div>
          @if(!empty($property->gallery_urls))
            <div class="p-4 grid grid-cols-3 sm:grid-cols-5 gap-2">
              @foreach($property->gallery_urls as $img)
                <a href="{{ $img }}" class="glightbox" data-gallery="prop-{{ $property->id }}">
                  <img src="{{ $img }}" alt="صورة" class="w-full h-20 object-cover rounded-lg" loading="lazy" />
                </a>
              @endforeach
            </div>
          @endif
        </div>

        @if($property->description)
          <div class="t4ps-panel rounded-2xl p-5 mt-4">
            <div class="t4ps-surface font-extrabold text-lg mb-2">وصف العقار</div>
            <div class="t4ps-subtle leading-relaxed">{!! nl2br(e($property->description)) !!}</div>
          </div>
        @endif

        @if(($similar ?? collect())->count())
          <div class="mt-4">
            <div class="t4ps-text-on-dark font-extrabold text-xl mb-2">عقارات مشابهة</div>
            <div class="grid sm:grid-cols-2 gap-3">
              @foreach($similar as $p)
                <a href="{{ route('properties.show', $p) }}" class="block rounded-2xl overflow-hidden t4ps-panel hover:shadow-2xl transition" style="text-decoration:none">
                  <div class="relative">
                    @if($p->primary_image_url)
                      <img src="{{ $p->primary_image_url }}" alt="{{ $p->title }}" class="w-full h-40 object-cover" loading="lazy" />
                    @else
                      <div class="w-full h-40 t4ps-media-ph"></div>
                    @endif
                    <div class="absolute bottom-2 right-2 t4ps-btn-primary px-2 py-1 rounded font-bold text-xs">{{ number_format($p->price) }} ر.س</div>
                  </div>
                  <div class="p-3 t4ps-surface">
                    <div class="font-extrabold">{{ $p->title }}</div>
                    <div class="text-sm t4ps-subtle mt-1">{{ $p->address }}</div>
                  </div>
                </a>
              @endforeach
            </div>
          </div>
        @endif
      </div>

      <aside class="lg:col-span-1">
        <div class="t4ps-panel rounded-2xl p-5">
          <div class="t4ps-surface font-extrabold text-lg mb-3">المواصفات</div>
          <div class="grid gap-2 text-sm font-bold">
            <div class="flex justify-between border t4ps-border rounded-lg px-3 py-2"><span class="t4ps-subtle">المساحة</span><span class="t4ps-surface">{{ $property->area ? number_format($property->area).' م²' : '-' }}</span></div>
            <div class="flex justify-between border t4ps-border rounded-lg px-3 py-2"><span class="t4ps-subtle">غرف النوم</span><span class="t4ps-surface">{{ $property->bedrooms ?? '-' }}</span></div>
            <div class="flex justify-between border t4ps-border rounded-lg px-3 py-2"><span class="t4ps-subtle">دورات المياه</span><span class="t4ps-surface">{{ $property->bathrooms ?? '-' }}</span></div>
          </div>

          @if(!empty($property->amenities_list))
            <div class="mt-4">
              <div class="t4ps-surface font-extrabold text-lg mb-2">المزايا</div>
              <div class="flex flex-wrap gap-2 text-xs font-bold">
                @foreach($property->amenities_list as $am)
                  <span class="t4ps-tag border px-3 py-1 rounded-full">{{ is_array($am) ? ($am['name'] ?? '') : $am }}</span>
                @endforeach
              </div>
            </div>
          @endif

          <div class="mt-5 flex flex-col gap-2">
            <a href="{{ $whatsappLink ? $whatsappLink.'?text='.urlencode('استفسار حول العقار: '.$property->title.' - '.request()->fullUrl()) : '#' }}" target="_blank" rel="noopener" class="t4ps-btn-primary font-extrabold px-4 py-3 rounded-xl text-center transition" @if(empty($whatsappLink)) style="pointer-events:none; opacity:.5" @endif>
              <i class="fa-brands fa-whatsapp"></i> تواصل واتساب
            </a>
            <button id="share-prop-btn" type="button" class="t4ps-btn-dark font-extrabold px-4 py-3 rounded-xl transition">
              <i class="fa-solid fa-share-nodes"></i> مشاركة
            </button>
          </div>

          @if($property->location_url)
            <div class="mt-4">
              <a href="{{ $property->location_url }}" target="_blank" rel="noopener" class="block t4ps-btn-map font-bold px-4 py-3 rounded-xl border text-center">
                <i class="fa-solid fa-map-location-dot"></i> فتح على الخريطة
              </a>
              @if($property->is_location_embeddable)
                <div class="mt-3 rounded-2xl overflow-hidden border t4ps-border">
                  <div class="aspect-[16/10]">
                    <iframe src="{{ $property->location_url }}" class="w-full h-full" style="border:0" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                  </div>
                </div>
              @endif
            </div>
          @endif
        </div>
      </aside>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded',()=>{
        if(window.GLightbox){ GLightbox({ selector: '.glightbox' }); }
        const shareBtn = document.getElementById('share-prop-btn');
        if(shareBtn){
          shareBtn.addEventListener('click', function(e){
            e.preventDefault();
            const data = { title: '{{ addslashes($property->title) }}', text: 'اطلع على هذا العقار', url: '{{ request()->fullUrl() }}' };
            if(navigator.share){ navigator.share(data).catch(()=>{}); }
            else if(navigator.clipboard){ navigator.clipboard.writeText(data.url).then(()=>{ shareBtn.textContent='تم نسخ الرابط'; setTimeout(()=>{ shareBtn.innerHTML='<i class="fa-solid fa-share-nodes"></i> مشاركة'; }, 1400); }); }
            else { window.prompt('انسخ الرابط:', data.url); }
          });
        }
      });
    </script>
  </div>
</div>
@endsection
