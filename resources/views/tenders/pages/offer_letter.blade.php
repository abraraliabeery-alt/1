<!-- خطاب تقديم العرض -->
<section class="relative" style="min-height:297mm">
  <!-- رأس علوي بسيط -->
  <div class="text-sm text-gray-700 font-extrabold mb-2">{{ config('brand.name') }} <span class="font-normal">للتجارة</span></div>

  <h1 class="text-2xl font-extrabold text-gray-900 mb-3">خطاب تقديم العرض</h1>

  <div class="text-gray-800 leading-8 mb-4">
    <div>المكرم مدير / إدارة المشتريات والعقود لإدارة الشؤون الفنية المركزية بمنطقة الرياض - (المحترم)</div>
    <div class="mt-2">“السلام عليكم و رحمة الله و بركاته”</div>
  </div>

  <div class="text-gray-800 leading-8 mb-4">
    <div>
      إشارة إلى منافسة / {{ $tender->title ?? '—' }}.
    </div>
    <div class="mt-2">
      وبعد الاطلاع على كافة البنود والشروط الموضحة من قبلكم التي تخص المنافسة المذكورة أعلاه، نتشرف نحن <strong>{{ config('brand.name') }}</strong> بتقديم عرض السعر الخاص بنا وفق البنود والشروط المطلوبة والمذكورة في المنافسة المرفقة وداخل المدة المذكورة ({{ $tender->validity_days ?? 90 }} يوم).
    </div>
  </div>

  <!-- جدول الإجماليات -->
  <div class="rounded-xl overflow-hidden border border-gray-300">
    <table class="w-full text-right text-gray-800" style="border-collapse: collapse;">
      <thead class="bg-gray-50">
        <tr>
          <th class="p-3 border-b border-gray-300">الوصف</th>
          <th class="p-3 border-b border-gray-300">السعر الإجمالي</th>
        </tr>
      </thead>
      <tbody>
        @php
          $subtotal = $fo->subtotal ?? $tender->total_before_vat ?? null;
          $vat      = $fo->total_vat ?? $tender->vat_amount ?? null;
          $total    = $fo->total ?? $tender->total_with_vat ?? null;
        @endphp
        <tr>
          <td class="p-3 border-b border-gray-200">منافسة / {{ $tender->title ?? '—' }}</td>
          <td class="p-3 border-b border-gray-200">{{ $subtotal !== null ? number_format($subtotal,2) : '—' }}</td>
        </tr>
        <tr class="bg-gray-50">
          <td class="p-3 border-b border-gray-200 font-extrabold">السعر الإجمالي</td>
          <td class="p-3 border-b border-gray-200 font-extrabold">{{ $subtotal !== null ? number_format($subtotal,2) : '—' }}</td>
        </tr>
        <tr>
          <td class="p-3 border-b border-gray-200">الضريبة</td>
          <td class="p-3 border-b border-gray-200">{{ $vat !== null ? number_format($vat,2) : '—' }}</td>
        </tr>
        <tr class="bg-gray-50">
          <td class="p-3 font-extrabold">الإجمالي شامل الضريبة</td>
          <td class="p-3 font-extrabold">{{ $total !== null ? number_format($total,2) : '—' }}</td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="text-gray-700 mt-3">{{ $fo->total_text ?? '' }}</div>

  <!-- ختم وملاحظة سفلية -->
  <div class="absolute inset-x-0 bottom-0 p-4 flex items-end justify-between">
    <img src="{{ asset(config('brand.stamp_path')) }}" alt="stamp" class="h-16 opacity-90" onerror="this.style.display='none'">
    <div class="text-[12px] text-gray-700"><span class="font-bold">ملاحظة:</span> العرض ساري لمدة {{ $tender->validity_days ?? 90 }} يوم من تاريخ تسليم العروض — {{ optional($tender->submission_date)->format('d / m / Y') }}</div>
  </div>
</section>
