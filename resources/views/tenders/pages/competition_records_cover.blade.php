<!-- غلاف السجلات الخاصة بالمنافسة -->
<section class="relative" style="min-height:297mm;">
  <div class="absolute top-0 left-0 right-0 h-10" style="background: {{ config('brand.color') }}"></div>
  <div class="relative grid grid-cols-12" style="height:297mm">
    <div class="col-span-7 relative h-full overflow-hidden">
      <img src="{{ asset('assets/competition-records-cover.jpg') }}" alt="" class="absolute inset-0 w-full h-full object-cover" onerror="this.style.display='none'">
      <div class="absolute inset-0" style="background: linear-gradient(180deg, rgba(0,0,0,.35), rgba(0,0,0,.45))"></div>
    </div>
    <div class="col-span-5 bg-white h-full"></div>

    <div class="absolute top-8 right-8 bg-white/95 border border-gray-200 rounded-xl shadow px-3 py-2 flex items-center gap-2">
      <img src="{{ asset(config('brand.logo_path')) }}" alt="logo" class="h-10 w-auto" onerror="this.style.display='none'">
      <div class="text-right leading-5">
        <div class="text-sm font-extrabold text-gray-900">{{ config('brand.name') }}</div>
        <div class="text-xs text-gray-600">للتجارة</div>
      </div>
    </div>

    <div class="absolute left-1/3 right-6 top-1/2 -translate-y-1/2">
      <div class="inline-block bg-white shadow-xl border border-gray-200 rounded-lg px-6 py-4">
        <div class="text-2xl font-extrabold text-gray-900">السجلات الخاصة بالمنافسة</div>
      </div>
    </div>
  </div>
</section>
