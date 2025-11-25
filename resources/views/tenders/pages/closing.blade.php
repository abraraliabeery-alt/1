<!-- الختام والختم -->
<section class="mb-8">
  <h3 class="text-2xl font-bold text-gray-800 mb-3">الختام</h3>
  <p class="text-gray-700">جميع الأسعار تشمل ضريبة القيمة المضافة وسارية لمدة 90 يومًا من تاريخ تقديم العرض. يسعدنا خدمتكم والإجابة عن أي استفسارات.</p>
  <div class="mt-4 flex items-center gap-4">
    <img src="{{ asset(config('brand.stamp_path')) }}" onerror="this.style.display='none'" class="h-16" alt="stamp">
    <div class="text-gray-700">
      {{ config('brand.name') }} — {{ config('brand.address') }} — {{ config('brand.phone') }}
    </div>
  </div>
</section>
