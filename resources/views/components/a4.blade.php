@props(['title' => null, 'showLogo' => true])
@php($brand = config('brand'))
<div class="a4" style="position:relative;width:210mm;min-height:297mm;background:#fff;margin:0 auto 12px;box-shadow:0 1px 8px rgba(0,0,0,.06)">
  @include('tenders.partials.header')
  @include('tenders.partials.footer')
  <div class="content" style="padding:28mm 15mm 22mm 15mm">
    @if($title)
      <div class="text-sm text-gray-500 mb-2">{{ $title }}</div>
    @endif
    {{ $slot }}
  </div>
</div>
