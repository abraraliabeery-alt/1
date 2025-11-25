<!-- الوثائق الرسمية والمرفقات -->
<section class="mb-8">
  <h2 class="text-2xl font-bold text-gray-800 mb-3">الوثائق الرسمية والمرفقات</h2>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    @php
      $items = ($attachments ?? collect())->sortBy(['display_order','id']);
      $items = $items->values();
    @endphp
    @forelse($items as $att)
      <div class="border rounded p-3">
        <div class="font-semibold">{{ $att->label ?? ucfirst($att->category) }}</div>
        <div class="subtitle">{{ $att->notes ?? '' }}</div>
      </div>
    @empty
      <div class="border rounded p-3">
        <div class="font-semibold">لا توجد مرفقات</div>
        <div class="subtitle">سيتم إرفاق الوثائق الرسمية عند توفرها.</div>
      </div>
    @endforelse
  </div>
</section>
