<!-- خطاب جدول الكميات -->
<section class="relative" style="min-height:297mm">
  <div class="text-sm text-gray-700 font-extrabold mb-2">{{ config('brand.name') }} <span class="font-normal">للتجارة</span></div>

  <h1 class="text-2xl font-extrabold text-gray-900 mb-3">خطاب جدول الكميات</h1>

  <div class="text-gray-800 leading-8 mb-4">
    <div>المكرم مدير / إدارة المشتريات والعقود لإدارة الشؤون الفنية المركزية بمنطقة الرياض - (المحترم)</div>
    <div class="mt-2">“السلام عليكم و رحمة الله و بركاته”</div>
  </div>

  <div class="text-gray-800 leading-8 mb-8">
    <div>
      إشارة إلى منافسة / {{ $tender->title ?? '—' }}.
    </div>
    <div class="mt-2">
      وبعد الاطلاع على كافة البنود والشروط الموضحة من قبلكم التي تخص المنافسة المذكورة أعلاه، نتشرف نحن <strong>{{ config('brand.name') }}</strong> بتقديم عرضنا الخاص بجدول الكميات وذلك استنادًا إلى المواصفات والمتطلبات المطروحة من قبلكم في المنافسة المرفقة، وخلال مدة السريان ({{ $tender->validity_days ?? 90 }} يوم).
    </div>
  </div>

  <div class="rounded-2xl border border-gray-300 p-6 text-center text-gray-600">سيتم إرفاق جداول الكميات التفصيلية ضمن الملحقات.</div>

  <!-- ختم وملاحظة سفلية -->
  <div class="absolute inset-x-0 bottom-0 p-4 flex items-end justify-between">
    <img src="{{ asset(config('brand.stamp_path')) }}" alt="stamp" class="h-16 opacity-90" onerror="this.style.display='none'">
    <div class="text-[12px] text-gray-700"><span class="font-bold">ملاحظة:</span> العرض ساري لمدة 90 يوم من تاريخ تسليم العروض — 08 / 10 / 2025</div>
  </div>
</section>
