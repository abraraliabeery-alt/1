<!-- العقود السابقة + خطابات + معلومات التواصل -->
<section class="mb-8">
  <h3 class="text-xl font-bold text-gray-800 mt-6 mb-2">العقود السابقة</h3>
  <div class="overflow-x-auto">
    <table class="min-w-full border border-gray-200 text-sm bw">
      <thead class="thead-brand">
        <tr>
          <th class="border p-2">الجهة</th>
          <th class="border p-2">سنة التنفيذ</th>
          <th class="border p-2">التكلفة</th>
          <th class="border p-2">عدد الفريق</th>
        </tr>
      </thead>
      <tbody>
        @for($i=1;$i<=5;$i++)
        <tr class="odd:bg-white even:bg-gray-50">
          <td class="border p-2">جهة حكومية {{ $i }}</td>
          <td class="border p-2">202{{ $i%10 }}</td>
          <td class="border p-2">{{ number_format(25000 + $i*5000, 2) }}</td>
          <td class="border p-2">{{ 5 + $i }}</td>
        </tr>
        @endfor
      </tbody>
    </table>
  </div>

  <h3 class="text-xl font-bold text-gray-800 mt-6 mb-2">خطابات القبول والعقود</h3>
  <p class="text-gray-700">نسخ مختارة من خطابات تعميد رسمية (مثال: نادي سباقات الخيل).</p>

  <h3 class="text-xl font-bold text-gray-800 mt-6 mb-2">معلومات التواصل</h3>
  <p class="text-gray-700">البريد: {{ config('brand.email') }} — الموقع: {{ config('brand.website') }} — الجوال: {{ config('brand.phone') }} — العنوان: {{ config('brand.address') }}.</p>
</section>
