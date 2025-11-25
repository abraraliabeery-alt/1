<!-- جدول الأعمال/العقود السابقة -->
<section class="mb-2">
  <!-- شريط هوية أعلى الجدول -->
  <div class="mb-3">
    <div class="inline-flex items-center gap-2 px-3 py-1 rounded" style="background: color-mix(in oklab, {{ config('brand.color') }}, #000 12%); color:#fff">
      <img src="{{ asset(config('brand.logo_path')) }}" alt="logo" class="h-6" onerror="this.style.display='none'">
      <span class="text-sm font-extrabold">{{ config('brand.name') }} للتجارة</span>
    </div>
  </div>

  <div class="bg-gray-50 rounded-t-xl border border-gray-300 border-b-0 px-4 py-2">
    <div class="text-lg font-extrabold text-gray-900">اعمالنا السابقة</div>
  </div>

  <div class="overflow-hidden rounded-b-xl border border-gray-300">
    <table class="w-full text-right" style="border-collapse:collapse">
      <thead class="thead-brand">
        <tr>
          <th class="p-2 border border-gray-300">م</th>
          <th class="p-2 border border-gray-300">اسم المشروع</th>
          <th class="p-2 border border-gray-300">الجهة</th>
          <th class="p-2 border border-gray-300">تفاصيل المشروع</th>
          <th class="p-2 border border-gray-300">سنة التنفيذ</th>
          <th class="p-2 border border-gray-300">مدة التنفيذ</th>
          <th class="p-2 border border-gray-300">تكلفة المشروع</th>
        </tr>
      </thead>
      <tbody class="text-gray-800">
        @if(!empty($previousWorks) && count($previousWorks))
          @foreach($previousWorks as $idx=>$pw)
          <tr class="odd:bg-white even:bg-gray-50">
            <td class="p-2 border border-gray-200">{{ $loop->iteration }}</td>
            <td class="p-2 border border-gray-200">{{ $pw->project_name }}</td>
            <td class="p-2 border border-gray-200">{{ $pw->client_name }}</td>
            <td class="p-2 border border-gray-200">{{ $pw->description }}</td>
            <td class="p-2 border border-gray-200">{{ $pw->year }}</td>
            <td class="p-2 border border-gray-200">{{ $pw->team_members ? ($pw->team_members.' أفراد') : '' }}</td>
            <td class="p-2 border border-gray-200">{{ $pw->cost ? number_format($pw->cost, 2) : '' }}</td>
          </tr>
          @endforeach
        @else
          @for($i=1;$i<=8;$i++)
          <tr class="odd:bg-white even:bg-gray-50">
            <td class="p-2 border border-gray-200">{{ $i }}</td>
            <td class="p-2 border border-gray-200">مشروع {{ $i }}</td>
            <td class="p-2 border border-gray-200">جهة حكومية</td>
            <td class="p-2 border border-gray-200">أعمال توريد وتنفيذ بمواصفات قياسية</td>
            <td class="p-2 border border-gray-200">202{{ $i%10 }}</td>
            <td class="p-2 border border-gray-200">{{ 3 + $i }} أشهر</td>
            <td class="p-2 border border-gray-200">{{ number_format(25000 + $i*15000, 2) }}</td>
          </tr>
          @endfor
        @endif
      </tbody>
    </table>
  </div>
</section>
