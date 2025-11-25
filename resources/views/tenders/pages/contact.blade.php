<section class="relative" style="min-height:297mm">
  <div class="mx-auto mt-6 rounded-2xl border border-gray-200 shadow-sm bg-white" style="max-width: 620px; padding: 26px 26px 20px">
    <div class="flex items-center gap-3 mb-4">
      <img src="{{ asset(config('brand.logo_path')) }}" alt="logo" class="h-10 w-auto" onerror="this.style.display='none'">
      <div class="text-xl font-extrabold text-gray-900">{{ config('brand.name') }}</div>
    </div>
    <h2 class="text-2xl font-extrabold text-gray-900 mb-4">معلومات التواصل</h2>
    <div class="grid grid-cols-1 gap-3 text-gray-800">
      <div class="flex items-center justify-between border border-gray-200 rounded-xl p-3">
        <div class="font-semibold">البريد الإلكتروني</div>
        <div class="text-gray-700">{{ config('brand.email') }}</div>
      </div>
      <div class="flex items-center justify-between border border-gray-200 rounded-xl p-3">
        <div class="font-semibold">رقم الهاتف</div>
        <div class="text-gray-700">{{ config('brand.phone') }}</div>
      </div>
      <div class="flex items-center justify-between border border-gray-200 rounded-xl p-3">
        <div class="font-semibold">الموقع الإلكتروني</div>
        <div class="text-gray-700">{{ config('brand.website') }}</div>
      </div>
      <div class="flex items-center justify-between border border-gray-200 rounded-xl p-3">
        <div class="font-semibold">العنوان</div>
        <div class="text-gray-700">{{ config('brand.address') }}</div>
      </div>
    </div>
  </div>
  <div class="absolute bottom-0 left-0 w-full h-6" style="background: {{ config('brand.color') }}"></div>
</section>
