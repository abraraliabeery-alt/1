@extends('layouts.admin')

@section('admin')
<div class="admin-section" dir="rtl">
  <div class="d-flex align-items-center justify-content-between gap-2 mb-3">
    <h1 class="fw-bold m-0">إدارة العقارات</h1>
    <a href="{{ route('admin.properties.create') }}" class="btn btn-primary">إضافة عقار</a>
  </div>

  

  <form method="POST" action="{{ route('admin.properties.bulk_destroy') }}" onsubmit="return confirm('حذف العناصر المحددة؟');">
    @csrf
    <div class="table-responsive bg-white rounded shadow-sm">
      <table class="table align-middle text-sm">
        <thead class="table-light">
          <tr>
            <th style="width:32px"><input type="checkbox" id="chk-all"></th>
            <th>#</th>
            <th>العنوان</th>
            <th>المدينة</th>
            <th>الوسائط</th>
            <th>السعر</th>
            <th>الصور</th>
            <th>خيارات</th>
          </tr>
        </thead>
        <tbody>
        @forelse($properties as $p)
          <tr>
            <td><input type="checkbox" name="ids[]" value="{{ $p->id }}" class="chk-row"></td>
            <td>{{ $p->id }}</td>
            <td>
              <div class="d-flex flex-column">
                <strong>{{ $p->title }}</strong>
                <div class="small text-muted">
                  <span class="badge bg-secondary">{{ $p->type }}</span>
                  @if($p->status)<span class="badge bg-light text-dark">{{ $p->status }}</span>@endif
                </div>
              </div>
            </td>
            <td>{{ $p->city }} @if($p->district) - {{ $p->district }} @endif</td>
            <td>
              <span class="badge bg-info text-dark" title="صور">{{ is_array($p->gallery ?? null) ? count($p->gallery) : 0 }} صور</span>
              @if($p->video_url || $p->video_path)<span class="badge bg-warning text-dark" title="فيديو">فيديو</span>@endif
              @if(!empty($p->location_url))<span class="badge bg-success" title="موقع">خريطة</span>@endif
            </td>
            <td><strong>{{ number_format($p->price) }}</strong></td>
            <td>
              <div class="d-flex align-items-center gap-2">
                <img src="{{ $p->primary_image_url }}" alt="cover" style="width:48px;height:48px;object-fit:cover;border-radius:6px;border:1px solid #e5e7eb;" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1523217582562-09d0def993a6?q=80&w=600&auto=format&fit=crop'"/>
                <span class="badge bg-info text-dark" title="عدد صور المعرض">{{ is_array($p->gallery ?? null) ? count($p->gallery) : 0 }} صور</span>
              </div>
            </td>
            <td class="d-flex gap-1">
              <a class="btn-icon" href="{{ route('admin.properties.edit', $p) }}" title="تعديل" aria-label="تعديل">
                <i class="bi bi-pencil"></i>
              </a>
              <a class="btn-icon" href="{{ route('properties.show', $p) }}" target="_blank" title="عرض" aria-label="عرض">
                <i class="bi bi-box-arrow-up-right"></i>
              </a>
              <form method="POST" action="{{ route('admin.properties.destroy', $p) }}" onsubmit="return confirm('تأكيد الحذف؟');">
                @csrf @method('DELETE')
                <button class="btn-icon" title="حذف" aria-label="حذف">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="8" class="text-center text-muted">لا توجد سجلات.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
    <div class="d-flex align-items-center justify-content-between mt-2">
      <button class="btn btn-outline-danger" type="submit">حذف المحدد</button>
      <div>{{ $properties->links() }}</div>
    </div>
  </form>

  <script>
  (function(){
    const chkAll = document.getElementById('chk-all');
    if(chkAll){
      chkAll.addEventListener('change',()=>{ document.querySelectorAll('.chk-row').forEach(c=>c.checked=chkAll.checked); });
    }
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    document.querySelectorAll('.js-toggle-featured').forEach(btn=>{
      btn.addEventListener('click', async ()=>{
        const id = btn.getAttribute('data-id');
        const res = await fetch(`{{ url('/admin/properties') }}/${id}/toggle-featured`, {method:'POST', headers:{'X-CSRF-TOKEN':token,'Accept':'application/json'}});
        if(res.ok){ const j = await res.json(); btn.textContent = j.is_featured ? 'نعم' : 'لا'; btn.classList.toggle('btn-success', j.is_featured); btn.classList.toggle('btn-outline-secondary', !j.is_featured); }
      });
    });
  })();
  </script>
</div>
@endsection
