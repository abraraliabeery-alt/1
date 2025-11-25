<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>قالب مثال - عرض فني ومالي</title>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = { theme:{ extend:{ fontFamily:{ sans:['Cairo','ui-sans-serif','system-ui'] } } } };
  </script>
  <link rel="stylesheet" href="{{ asset('tender.css') }}">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <?php $brand = $brandColor ?? config('brand.color'); ?>
  <style>
    @media print { .no-print{display:none!important} body{-webkit-print-color-adjust:exact;print-color-adjust:exact} main{box-shadow:none!important} }
    @page{ size:A4; margin:0 }
    .hr-brand{ height:2px; background: <?= $brand ?> }
    .thead-brand th{ background: <?= $brand ?> !important; color:#fff !important }
    .brand-text{ color: <?= $brand ?> }
    table.bw th, table.bw td { border-width: 1.2px !important }
    .a4{ width:210mm; min-height:297mm; background:#fff; margin:0 auto 12px; box-shadow: 0 1px 8px rgba(0,0,0,.06); position:relative }
    .a4 .page-header{ position:absolute; top:0; left:0; right:0; height:20mm; padding:6mm 15mm; display:flex; align-items:center; justify-content:space-between; border-bottom:2px solid <?= $brand ?> }
    .a4 .page-footer{ position:absolute; bottom:0; left:0; right:0; height:15mm; padding:4mm 15mm; display:flex; align-items:center; justify-content:space-between; border-top:2px solid <?= $brand ?>; font-size:10px; color:#4b5563 }
    .a4 .content{ padding: 28mm 15mm 22mm 15mm }
    .a4:not(:last-child){ page-break-after: always }
    .page-break{ display:none }
    .subtitle{ color: #6b7280 }
  </style>
</head>
<body class="bg-gray-100 font-sans tender-doc" style="font-family:'Cairo',system-ui; --brand: <?= $brand ?>;">
  <div class="container mx-auto p-6">
    <div class="text-center mb-6 no-print">
      <a href="{{ route('admin.tenders.index') }}" class="text-sm text-gray-600">رجوع</a>
      <button id="downloadButton" class="ml-3 bg-blue-600 text-white px-6 py-2 rounded shadow">تنزيل PDF</button>
      @php($coverKey = request('cover','default'))
      <div class="mt-3 inline-flex items-center gap-2 text-sm flex-wrap justify-center">
        <span class="text-gray-600 w-full">تصميم الغلاف (الحالي: <strong>{{ $coverKey }}</strong>):</span>
        @foreach(['default','orbit','bold','minimal','hero','stripe','sidebar','wave','geometric','gradient','arch','diagonal','tiles','focus'] as $k)
          <a class="px-3 py-1 rounded border {{ $coverKey===$k?'bg-blue-600 text-white border-blue-600':'border-gray-300' }}" href="?cover={{ $k }}">{{ ucfirst($k) }}</a>
        @endforeach
      </div>
    </div>

    <main id="printable-content" class="max-w-4xl mx-auto">
      <div class="a4">
        <div class="content" style="padding:0">
          @includeFirst(['tenders.pages.covers.' . request('cover','default'), 'tenders.pages.covers.default'])
        </div>
      </div>

      <x-a4>
      @include('tenders.pages.toc')
      </x-a4>

      <x-a4>
      @include('tenders.pages.offer_letter')
      </x-a4>

      <x-a4>
      @include('tenders.pages.boq_letter')
      </x-a4>

      <x-a4>
      @include('tenders.pages.boq_table')
      </x-a4>

      <x-a4>
      @include('tenders.pages.boq_table')
      </x-a4>

      <x-a4>
      @include('tenders.pages.boq_table')
      </x-a4>

      <x-a4>
      @include('tenders.pages.boq_table')
      </x-a4>

      <x-a4>
      @include('tenders.pages.financial_cover')
      </x-a4>

      <x-a4>
      @include('tenders.pages.attachment_pdf_stub')
      </x-a4>

      <x-a4>
      @include('tenders.pages.attachment_pdf_stub')
      </x-a4>

      <x-a4>
      @include('tenders.pages.technical_intro')
      </x-a4>

      <x-a4>
      @include('tenders.pages.technical_cover')
      </x-a4>

      <x-a4>
      @include('tenders.pages.company_profile_cover')
      </x-a4>

      <x-a4>
      @include('tenders.pages.contracts_cover')
      </x-a4>

      <x-a4>
      @include('tenders.pages.previous_works_table')
      </x-a4>

      <x-a4>
      @include('tenders.pages.our_records_cover')
      </x-a4>

      <x-a4>
      @include('tenders.pages.technical_contracts_contact')
      </x-a4>

      <x-a4>
      @include('tenders.pages.financial')
      </x-a4>

      <x-a4>
      @include('tenders.pages.financial_extras')
      </x-a4>

      <x-a4>
      @include('tenders.pages.competition_records_cover')
      </x-a4>

      <x-a4>
      @include('tenders.pages.attachments_official')
      </x-a4>

      <x-a4>
      @include('tenders.pages.contact')
      </x-a4>

      <x-a4>
      @include('tenders.pages.closing')
      </x-a4>
    </main>
  </div>

  <script>
    window.onload = function(){
      const { jsPDF } = jspdf;
      const btn = document.getElementById('downloadButton');
      const content = document.getElementById('printable-content');
      const BRAND = '<?= $brand ?>';
      const logoUrl = "{{ asset('branding/logo.png') }}"; // اختياري

      function loadImageData(url){
        return new Promise((resolve)=>{
          if(!url) return resolve(null);
          const img=new Image(); img.crossOrigin='anonymous';
          img.onload=()=>{
            try{ const c=document.createElement('canvas'); c.width=img.naturalWidth; c.height=img.naturalHeight; const cx=c.getContext('2d'); cx.drawImage(img,0,0); resolve(c.toDataURL('image/png')); }catch(e){ resolve(null); }
          };
          img.onerror=()=>resolve(null);
          img.src=url;
        });
      }

      btn.addEventListener('click', async ()=>{
        btn.disabled = true; btn.textContent = 'جاري الإنشاء...';
        const a4W=210, a4H=297; // mm
        const pdf = new jsPDF({orientation:'p', unit:'mm', format:'a4'});
        const pages = Array.from(document.querySelectorAll('.a4'));
        const scale = 3;
        const logoData = await loadImageData(logoUrl);
        const titleText = (document.querySelector('h1')?.textContent || '').trim();
        for (let i=0; i<pages.length; i++){
          const page = pages[i];
          const canvas = await html2canvas(page, { scale, useCORS:true, backgroundColor:'#ffffff' });
          const img = canvas.toDataURL('image/png');
          if (i>0) pdf.addPage('a4','p');
          pdf.addImage(img,'PNG', 0, 0, a4W, a4H);
        }
        const total = pdf.getNumberOfPages();
        for(let i=1;i<=total;i++){
          pdf.setPage(i);
          pdf.setTextColor(80,80,80); pdf.setFontSize(9);
          pdf.text(`Page ${i} of ${total}`, a4W/2, a4H - 6, {align:'center'});
        }
        pdf.save('template-example.pdf');
        btn.textContent = 'تنزيل PDF'; btn.disabled=false;
      });
    };
  </script>
</body>
</html>
