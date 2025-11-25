<!-- صفحة مرفق PDF (ثابتة مؤقتًا) -->
<section class="relative" style="min-height:297mm">
  <header class="mb-4">
    <h2 class="text-xl font-extrabold text-gray-900">مرفق: اسم الملف.pdf</h2>
    <div class="text-sm text-gray-600">نسخة توضيحية لعرض الصفحة كما ستظهر عند الدمج الفعلي</div>
  </header>

  <!-- منطقة معاينة تمثل صفحة PDF مدرجة -->
  <div class="relative rounded-lg border border-gray-300 bg-gray-50 overflow-hidden" style="height:240mm">
    <div class="absolute inset-0 grid place-items-center text-gray-400">
      <div class="text-center">
        <div class="text-6xl font-extrabold opacity-20">PDF</div>
        <div class="mt-2">هنا تُعرض صفحة المرفق عند الدمج الفعلي</div>
      </div>
    </div>
  </div>

  <!-- شريط سفلي بلون الهوية -->
  <div class="absolute bottom-0 left-0 right-0 h-6" style="background: {{ config('brand.color') }}"></div>
</section>
