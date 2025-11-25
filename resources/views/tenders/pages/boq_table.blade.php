<section class="mb-2">
  <style>
    @media print {
      thead { display: table-header-group; }
      tfoot { display: table-footer-group; }
      tr { page-break-inside: avoid; }
    }
    .boq-table th, .boq-table td { border: 1.6px solid #d1d5db; }
    .boq-table th { border-color: #9ca3af; }
    .num { text-align: center; font-variant-numeric: tabular-nums; }
    .money { text-align: right; font-variant-numeric: tabular-nums; }
  </style>

  <h2 class="text-xl font-extrabold text-gray-900 mb-3">جدول الكميات</h2>
  <div class="overflow-hidden border border-gray-400" style="border-radius: 10px">
    <table class="boq-table w-full text-right" style="border-collapse:collapse; background:#fff">
      <colgroup>
        <col style="width:22mm">
        <col>
        <col style="width:24mm">
        <col style="width:26mm">
        <col style="width:36mm">
        <col style="width:36mm">
        <col style="width:36mm">
      </colgroup>
      <thead class="thead-brand">
        <tr>
          <th class="p-2">م</th>
          <th class="p-2">الصنف</th>
          <th class="p-2">الوحدة</th>
          <th class="p-2">الكمية</th>
          <th class="p-2">السعر الإفرادي قبل الضريبة</th>
          <th class="p-2">السعر الإفرادي بعد الضريبة</th>
          <th class="p-2">السعر الإجمالي</th>
        </tr>
      </thead>
      <tbody class="text-gray-800">
        @php $startIndex = $startIndex ?? 0; @endphp
        @if(!empty($rows))
          @foreach($rows as $k=>$r)
            @php
              $qty = (float)($r->quantity ?? 0);
              $unitBefore = (float)($r->unit_price ?? 0);
              $unitAfter = round($unitBefore * 1.15, 2);
              $total = $r->total_line ?? ($qty * $unitBefore);
            @endphp
            <tr>
              <td class="p-2 num">{{ $startIndex + $loop->iteration }}</td>
              <td class="p-2">{{ $r->item_name }}</td>
              <td class="p-2 num">{{ $r->unit }}</td>
              <td class="p-2 num">{{ rtrim(rtrim(number_format($qty, 3), '0'), '.') }}</td>
              <td class="p-2 money">{{ number_format($unitBefore, 2) }}</td>
              <td class="p-2 money">{{ number_format($unitAfter, 2) }}</td>
              <td class="p-2 money">{{ number_format($total, 2) }}</td>
            </tr>
          @endforeach
        @else
          @for($i=1;$i<=12;$i++)
          <tr>
            <td class="p-2 num">{{ $i }}</td>
            <td class="p-2">&nbsp;</td>
            <td class="p-2 num">&nbsp;</td>
            <td class="p-2 num">&nbsp;</td>
            <td class="p-2 money">&nbsp;</td>
            <td class="p-2 money">&nbsp;</td>
            <td class="p-2 money">&nbsp;</td>
          </tr>
          @endfor
        @endif
      </tbody>
    </table>
  </div>

  <div class="mt-3 text-xs text-gray-600">يمكن تعديل عدد الصفوف برمجياً أو تقسيم الجدول على أكثر من صفحة عند الحاجة.</div>
</section>
