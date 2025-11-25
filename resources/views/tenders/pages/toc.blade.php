<!-- الفهرس -->
<section class="relative" style="min-height: 270mm;">
  <!-- Top-left brand block -->
  <div class="absolute -top-2 left-0">
    <div class="inline-flex items-center gap-3 bg-white shadow px-3 py-2 rounded-xl border border-gray-200">
      <img src="{{ asset(config('brand.logo_path')) }}" alt="logo" class="h-8 w-auto" onerror="this.style.display='none'">
      <div class="text-sm font-extrabold text-gray-900 leading-4">{{ config('brand.name') }}<br><span class="font-normal text-gray-600">للتجارة</span></div>
    </div>
  </div>

  <!-- Center panel -->
  <div class="mx-auto mt-16 rounded-2xl border border-gray-200 shadow-sm bg-gray-50" style="max-width: 540px; padding: 28px 28px 22px">
    <h2 class="text-3xl font-extrabold text-gray-900 mb-6" style="letter-spacing:.3px">الفهرس</h2>

    <!-- Covers overview -->
    <div class="mb-5">
      <div class="flex items-center gap-3 mb-2">
        <span class="inline-block w-8 h-[3px] rounded" style="background: {{ config('brand.color') }}"></span>
        <strong class="text-lg" style="color: {{ config('brand.color') }}">أغلفة الأقسام</strong>
      </div>
      <ul class="grid gap-2 text-gray-800">
        <li class="flex items-center justify-between gap-2"><span>الغلاف الرئيسي</span><span class="grow border-t border-dotted border-gray-300"></span><span class="text-gray-500">01</span></li>
        <li class="flex items-center justify-between gap-2"><span>غلاف العرض المالي</span><span class="grow border-t border-dotted border-gray-300"></span><span class="text-gray-500">09</span></li>
        <li class="flex items-center justify-between gap-2"><span>غلاف العرض الفني</span><span class="grow border-t border-dotted border-gray-300"></span><span class="text-gray-500">13</span></li>
        <li class="flex items-center justify-between gap-2"><span>غلاف الملف التعريفي</span><span class="grow border-t border-dotted border-gray-300"></span><span class="text-gray-500">14</span></li>
        <li class="flex items-center justify-between gap-2"><span>غلاف العقود السابقة</span><span class="grow border-t border-dotted border-gray-300"></span><span class="text-gray-500">15</span></li>
        <li class="flex items-center justify-between gap-2"><span>غلاف السجلات الخاصة بنا</span><span class="grow border-t border-dotted border-gray-300"></span><span class="text-gray-500">17</span></li>
        <li class="flex items-center justify-between gap-2"><span>غلاف السجلات الخاصة بالمنافسة</span><span class="grow border-t border-dotted border-gray-300"></span><span class="text-gray-500">21</span></li>
      </ul>
    </div>

    <!-- Financial section -->
    <div class="mb-5">
      <div class="flex items-center gap-3 mb-2">
        <span class="inline-block w-8 h-[3px] rounded" style="background: {{ config('brand.color') }}"></span>
        <strong class="text-lg" style="color: {{ config('brand.color') }}">العرض المالي</strong>
      </div>
      <ul class="grid gap-2 text-gray-800">
        <li class="flex items-center justify-between gap-2"><span>خطاب تقديم العرض</span><span class="grow border-t border-dotted border-gray-300"></span><span class="text-gray-500">03</span></li>
        <li class="flex items-center justify-between gap-2"><span>خطاب وجدول الكميات</span><span class="grow border-t border-dotted border-gray-300"></span><span class="text-gray-500">04–08</span></li>
        <li class="flex items-center justify-between gap-2"><span>الغلاف المالي</span><span class="grow border-t border-dotted border-gray-300"></span><span class="text-gray-500">09</span></li>
        <li class="flex items-center justify-between gap-2"><span>مرفقات مالية (نماذج)</span><span class="grow border-t border-dotted border-gray-300"></span><span class="text-gray-500">10–11</span></li>
      </ul>
    </div>

    <!-- Technical section -->
    <div class="mt-3">
      <div class="flex items-center gap-3 mb-2">
        <span class="inline-block w-8 h-[3px] rounded" style="background: {{ config('brand.color') }}"></span>
        <strong class="text-lg" style="color: {{ config('brand.color') }}">العرض الفني</strong>
      </div>
      <ul class="grid gap-2 text-gray-800">
        <li class="flex items-center justify-between gap-2"><span>مقدمة فنية</span><span class="grow border-t border-dotted border-gray-300"></span><span class="text-gray-500">12</span></li>
        <li class="flex items-center justify-between gap-2"><span>غلاف العرض الفني</span><span class="grow border-t border-dotted border-gray-300"></span><span class="text-gray-500">13</span></li>
        <li class="flex items-center justify-between gap-2"><span>غلاف الملف التعريفي</span><span class="grow border-t border-dotted border-gray-300"></span><span class="text-gray-500">14</span></li>
        <li class="flex items-center justify-between gap-2"><span>غلاف العقود السابقة</span><span class="grow border-t border-dotted border-gray-300"></span><span class="text-gray-500">15</span></li>
        <li class="flex items-center justify-between gap-2"><span>أعمالنا السابقة (جدول)</span><span class="grow border-t border-dotted border-gray-300"></span><span class="text-gray-500">16</span></li>
        <li class="flex items-center justify-between gap-2"><span>غلاف السجلات الخاصة بنا</span><span class="grow border-t border-dotted border-gray-300"></span><span class="text-gray-500">17</span></li>
        <li class="flex items-center justify-between gap-2"><span>العقود والخطابات ومعلومات التواصل</span><span class="grow border-t border-dotted border-gray-300"></span><span class="text-gray-500">18</span></li>
        <li class="flex items-center justify-between gap-2"><span>العرض المالي (تفاصيل إضافية)</span><span class="grow border-t border-dotted border-gray-300"></span><span class="text-gray-500">19–20</span></li>
        <li class="flex items-center justify-between gap-2"><span>غلاف السجلات الخاصة بالمنافسة</span><span class="grow border-t border-dotted border-gray-300"></span><span class="text-gray-500">21</span></li>
        <li class="flex items-center justify-between gap-2"><span>مرفقات رسمية</span><span class="grow border-t border-dotted border-gray-300"></span><span class="text-gray-500">22</span></li>
        <li class="flex items-center justify-between gap-2"><span>معلومات التواصل</span><span class="grow border-t border-dotted border-gray-300"></span><span class="text-gray-500">23</span></li>
        <li class="flex items-center justify-between gap-2"><span>إغلاق الغلاف</span><span class="grow border-t border-dotted border-gray-300"></span><span class="text-gray-500">24</span></li>
      </ul>
    </div>
  </div>

  <!-- Bottom brand band -->
  <div class="absolute bottom-0 left-0 w-full h-6" style="background: {{ config('brand.color') }}"></div>
</section>
