<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tender->title ?? 'صفحة جاهزة للتحميل A4' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: { extend: { fontFamily: { sans: ['Inter','ui-sans-serif','system-ui'] } } }
      };
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @php
      $brand = $brandColor ?? ($company->brand_color ?? '#0b5fad');
      $muted = '#6b7280';
      $light = '#f3f4f6';
    @endphp
    <style>
      @media print { .no-print { display: none !important; } body { -webkit-print-color-adjust: exact; print-color-adjust: exact; } main{ box-shadow:none !important; } }
      @page { size: A4; margin: 20mm; }
      .loader { border: 4px solid #f3f3f3; border-top: 4px solid #3498db; border-radius: 50%; width: 24px; height: 24px; animation: spin 1s linear infinite; display:inline-block; margin-left:10px }
      @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
      .brand-text { color: {{ $brand }}; }
      .brand-bg { background: {{ $brand }}; }
      .brand-border { border-color: {{ $brand }}; }
      .muted { color: {{ $muted }}; }
      .thead-brand th { background: {{ $brand }} !important; color: #fff !important; }
      .hr-brand { height:2px; background: {{ $brand }}; }
    </style>
</head>
<body class="bg-gray-100 font-sans leading-relaxed" style="font-family: 'Cairo', system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;">
  <div class="container mx-auto p-4 md:p-8">
    <div class="text-center mb-8 print:hidden no-print">
      <a href="{{ route('admin.tenders.index') }}" class="inline-block mr-2 text-sm text-gray-600">رجوع</a>
      <button id="downloadButton" class="bg-blue-600 text-white font-bold py-3 px-8 rounded-lg shadow-md hover:bg-blue-700 transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 inline-flex items-center" disabled>
        <span id="buttonText">جاري تحميل المكتبات...</span>
        <span id="loader" class="loader hidden"></span>
      </button>
      <p class="text-gray-600 mt-2 text-sm">سيتم إنشاء ملف PDF وتنزيله مباشرة من هذه الصفحة.</p>
    </div>

    <main class="max-w-4xl mx-auto bg-white p-10 md:p-16 rounded-lg shadow-lg" id="printable-content">
      <!-- Cover -->
      <section class="text-center mb-10">
        <div class="flex items-center justify-center gap-3 mb-4">
          @php $logoWeb = !empty($company?->logo_path) ? asset($company->logo_path) : null; @endphp
          @if($logoWeb)
            <img src="{{ $logoWeb }}" alt="logo" class="h-16 inline-block" />
          @endif
        </div>
        <div class="text-3xl md:text-4xl font-extrabold brand-text mb-2">{{ $tender->title ?? 'مستند جاهز للتحميل' }}</div>
        <div class="text-lg text-gray-600">{{ $tender->client_name ? 'الجهة: '.$tender->client_name : ($company->name ?? 'شركة مدى الذهبية') }}</div>
        <div class="flex justify-center gap-6 text-sm text-gray-500 mt-4">
          <span>التاريخ: {{ $tender->submission_date ? \Carbon\Carbon::parse($tender->submission_date)->format('Y-m-d') : now()->format('Y-m-d') }}</span>
          @if($tender->competition_no)
            <span>رقم المنافسة: {{ $tender->competition_no }}</span>
          @endif
        </div>
      </section>
      <div class="hr-brand mb-6"></div>

      <article class="prose prose-lg max-w-none">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">الخطاب المالي</h2>
        <div class="border rounded p-4 mb-8 text-gray-800">
          <div class="mb-2"><span class="font-semibold">التاريخ:</span> {{ $tender->submission_date ? \Carbon\Carbon::parse($tender->submission_date)->format('Y-m-d') : now()->format('Y-m-d') }}</div>
          <div class="mb-2"><span class="font-semibold">الجهة:</span> {{ $tender->client_name ?? '-' }}</div>
          @if(!empty($tender->competition_no))
            <div class="mb-2"><span class="font-semibold">رقم المنافسة:</span> {{ $tender->competition_no }}</div>
          @endif
          @if(!empty($tender->notes))
            <div class="mt-3 whitespace-pre-wrap">{!! nl2br(e($tender->notes)) !!}</div>
          @else
            <div class="mt-3 text-gray-600">نتشرف بتقديم عرضنا المالي وفق البنود التالية، شاملاً الضريبة بحسب الأنظمة المعمول بها.</div>
          @endif
        </div>

        <h2 class="text-2xl font-bold text-gray-800 mb-4">القسم المالي</h2>
        @php $fo = $tender->financialOffers->first(); @endphp
        @if($fo)
          <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 text-sm">
              <thead class="thead-brand">
                <tr>
                  <th class="border p-2">#</th>
                  <th class="border p-2">البند</th>
                  <th class="border p-2">الكمية</th>
                  <th class="border p-2">الوحدة</th>
                  <th class="border p-2">سعر الوحدة</th>
                  <th class="border p-2">الضريبة</th>
                  <th class="border p-2">الإجمالي</th>
                </tr>
              </thead>
              <tbody>
                @foreach($fo->offerItems->sortBy('order_index') as $i=>$it)
                <tr class="odd:bg-white even:bg-gray-50">
                  <td class="border p-2">{{ $i+1 }}</td>
                  <td class="border p-2">{{ $it->name }}</td>
                  <td class="border p-2">{{ rtrim(rtrim(number_format((float)$it->qty, 3, '.', ''), '0'), '.') }}</td>
                  <td class="border p-2">{{ $it->unit }}</td>
                  <td class="border p-2">{{ number_format((float)$it->unit_price, 2) }}</td>
                  <td class="border p-2">{{ number_format((float)$it->vat, 2) }}</td>
                  <td class="border p-2">{{ number_format((float)$it->total, 2) }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="grid grid-cols-2 gap-4 mt-6">
            <div></div>
            <div class="border rounded">
              <div class="flex justify-between border-b p-2"><span>الإجمالي قبل الضريبة</span><span>{{ number_format((float)$fo->subtotal, 2) }}</span></div>
              <div class="flex justify-between border-b p-2"><span>قيمة الضريبة</span><span>{{ number_format((float)$fo->total_vat, 2) }}</span></div>
              <div class="flex justify-between p-2 font-bold brand-text"><span>الإجمالي النهائي</span><span>{{ number_format((float)$fo->total, 2) }} {{ $fo->currency }}</span></div>
            </div>
          </div>
        @else
          <p class="text-gray-600">لا توجد بنود مالية بعد.</p>
        @endif

        <h2 class="text-2xl font-bold text-gray-800 mt-10 mb-4">القسم الفني</h2>
        @if(!empty($company))
          <div class="mb-4">
            <div class="font-semibold brand-text mb-1">نبذة عن الشركة</div>
            @if(!empty($company->about))
              <p class="text-gray-700">{!! nl2br(e($company->about)) !!}</p>
            @elseif(!empty($company->vision) || !empty($company->mission))
              @if(!empty($company->vision))<p class="text-gray-700">{!! nl2br(e($company->vision)) !!}</p>@endif
              @if(!empty($company->mission))<p class="text-gray-700 mt-2">{!! nl2br(e($company->mission)) !!}</p>@endif
            @else
              <p class="text-gray-600">نبذة تعريفية موجزة عن خبرات وإنجازات الشركة.</p>
            @endif
          </div>
        @endif

        @if(!empty($team) && count($team))
          <h3 class="text-xl font-bold text-gray-800 mt-8 mb-3">فريق العمل</h3>
          <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 text-sm">
              <thead class="thead-brand">
                <tr>
                  <th class="border p-2">الاسم</th>
                  <th class="border p-2">المسمى</th>
                  <th class="border p-2">الخبرة</th>
                  <th class="border p-2">الشهادات</th>
                </tr>
              </thead>
              <tbody>
                @foreach($team as $m)
                  <tr class="odd:bg-white even:bg-gray-50">
                    <td class="border p-2">{{ $m->name ?? '-' }}</td>
                    <td class="border p-2">{{ $m->title ?? $m->role ?? '-' }}</td>
                    <td class="border p-2">{{ $m->experience_years ? ($m->experience_years.' سنة') : ($m->experience ?? '-') }}</td>
                    <td class="border p-2">{{ $m->certifications ?? '-' }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @endif

        @if(!empty($projects) && count($projects))
          <h3 class="text-xl font-bold text-gray-800 mt-8 mb-3">أبرز المشاريع</h3>
          <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 text-sm">
              <thead class="bg-gray-50">
                <tr>
                  <th class="border p-2">اسم المشروع</th>
                  <th class="border p-2">العميل</th>
                  <th class="border p-2">السنة</th>
                  <th class="border p-2">الوصف</th>
                </tr>
              </thead>
              <tbody>
                @foreach($projects as $p)
                  <tr class="odd:bg-white even:bg-gray-50">
                    <td class="border p-2">{{ $p->name ?? '-' }}</td>
                    <td class="border p-2">{{ $p->client ?? '-' }}</td>
                    <td class="border p-2">{{ $p->year ?? '-' }}</td>
                    <td class="border p-2">{{ $p->description ?? '-' }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @endif

        @if(!empty($certificates) && count($certificates))
          <h3 class="text-xl font-bold text-gray-800 mt-8 mb-3">الشهادات والاعتمادات</h3>
          <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
            @foreach($certificates as $c)
              <div class="border rounded p-3 text-sm">
                <div class="font-semibold">{{ $c->name ?? $c->title ?? 'شهادة' }}</div>
                @if(!empty($c->issuer))<div class="text-gray-600">الجهة: {{ $c->issuer }}</div>@endif
                @if(!empty($c->year))<div class="text-gray-600">السنة: {{ $c->year }}</div>@endif
                @if(!empty($c->description))<div class="text-gray-700 mt-1">{{ $c->description }}</div>@endif
              </div>
            @endforeach
          </div>
        @endif

        <div class="mt-10 text-sm text-gray-600">
          <div>العنوان: {{ $company->address ?? '-' }}</div>
          <div>الهاتف: {{ $company->phone ?? '-' }} | البريد: {{ $company->email ?? '-' }} | الموقع: {{ $company->website ?? '-' }}</div>
        </div>
      </article>
    </main>
  </div>

  <script>
    window.onload = function() {
      const downloadButton = document.getElementById('downloadButton');
      const buttonText = document.getElementById('buttonText');
      const loader = document.getElementById('loader');
      const contentToPrint = document.getElementById('printable-content');
      if (typeof jspdf !== 'undefined' && typeof html2canvas !== 'undefined') {
        buttonText.textContent = 'تنزيل الصفحة (PDF A4)';
        downloadButton.disabled = false;
      } else {
        buttonText.textContent = 'خطأ في تحميل المكتبات';
        console.error('jsPDF or html2canvas not loaded.');
      }
      const { jsPDF } = jspdf;

      function loadImageData(url){
        return new Promise((resolve)=>{
          if(!url) return resolve(null);
          const img=new Image(); img.crossOrigin='anonymous';
          img.onload=()=>{
            try{
              const c=document.createElement('canvas'); c.width=img.naturalWidth; c.height=img.naturalHeight; const cx=c.getContext('2d'); cx.drawImage(img,0,0); resolve(c.toDataURL('image/png'));
            }catch(e){ resolve(null); }
          };
          img.onerror=()=>resolve(null);
          img.src=url;
        });
      }

      async function generateMultipagePDF(){
        buttonText.textContent = 'جاري الإنشاء...'; loader.classList.remove('hidden'); downloadButton.disabled = true;
        const a4W=210, a4H=297, margin=15, headerH=0, footerH=10; // mm
        const pdfW=a4W-(margin*2), pdfH=a4H-(margin*2)-headerH-footerH;

        const scale=3; // جودة أعلى
        const canvas = await html2canvas(contentToPrint, { scale, useCORS: true, backgroundColor: '#ffffff', onclone: (doc)=>{ const el=doc.getElementById('printable-content'); if(el){ el.style.boxShadow='none'; } } });
        const cW=canvas.width, cH=canvas.height;
        const sliceHeightPx = Math.floor(pdfH * (cW / pdfW)); // تحويل ارتفاع الصفحة بالـmm إلى بكسل نسبة لعرض الصورة

        const pdf = new jsPDF({orientation:'p', unit:'mm', format:'a4'});
        let y=0; let pageIndex=0; const slices=[];
        while (y < cH) {
          const sliceH = Math.min(sliceHeightPx, cH - y);
          const part=document.createElement('canvas'); part.width=cW; part.height=sliceH; const pctx=part.getContext('2d');
          pctx.drawImage(canvas, 0, y, cW, sliceH, 0, 0, cW, sliceH);
          const imgData = part.toDataURL('image/png');
          slices.push(imgData);
          y += sliceH;
        }

        // إضافة الشرائح كصفحات
        slices.forEach((img, idx)=>{
          if(idx>0) pdf.addPage('a4','p');
          const imgH = pdfW * (canvas.height / canvas.width);
          const pageImgH = Math.min(pdfH, imgH); // نفس حسبة التناسب
          pdf.addImage(img, 'PNG', margin, margin + headerH, pdfW, pageImgH);
        });

        // ترقيم الصفحات (لاتيني لتجنب مشاكل الخطوط)
        const total = pdf.getNumberOfPages();
        for(let i=1;i<=total;i++){
          pdf.setPage(i);
          pdf.setFontSize(9);
          pdf.text(`Page ${i} of ${total}`, a4W/2, a4H - (margin/2), {align:'center'});
        }

        pdf.save('tender-{{ $tender->id }}.pdf');
        buttonText.textContent = 'تنزيل الصفحة (PDF A4)'; loader.classList.add('hidden'); downloadButton.disabled = false;
      }

      downloadButton && downloadButton.addEventListener('click', ()=>{ generateMultipagePDF().catch(err=>{ console.error('Error generating PDF:', err); buttonText.textContent='حدث خطأ'; loader.classList.add('hidden'); downloadButton.disabled=false; }); });
    };
  </script>
</body>
</html>
