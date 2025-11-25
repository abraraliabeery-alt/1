<!-- الغلاف المالي -->
<section class="relative" style="min-height:297mm">
  <!-- رأس علوي بسيط -->
  <div class="text-sm text-gray-700 font-extrabold mb-2">{{ config('brand.name') }} <span class="font-normal">للتجارة</span></div>

  <div class="section-title">
    <span class="dot"></span>
    <h3>العرض المالي</h3>
  </div>
  <div class="accent-band"></div>

  <div class="text-gray-800 leading-8 mb-4">
    <div class="font-extrabold">منافسة/</div>
    <div>
      {{ $tender->title ?? '' }}
    </div>
    <div class="mt-2 brand-text">{{ $tender->client_name }}</div>
  </div>

  <div class="rounded-xl overflow-hidden border border-gray-300 mb-6">
    <img src="{{ asset('assets/financial-cover.jpg') }}" alt="" class="w-full h-64 object-cover" onerror="this.style.display='none'">
  </div>

  <!-- ختم وملاحظة سفلية -->
  <div class="absolute inset-x-0 bottom-0 p-4 flex items-end justify-between">
    <img src="{{ asset(config('brand.stamp_path')) }}" alt="stamp" class="h-16 opacity-90" onerror="this.style.display='none'">
    <div class="text-[12px] text-gray-700"><span class="font-bold">ملاحظة:</span> العرض ساري لمدة {{ $tender->validity_days ?? 90 }} يوم من تاريخ تسليم العروض — {{ optional($tender->submission_date)->format('d / m / Y') }}</div>
  </div>
</section>
