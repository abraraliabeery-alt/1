@extends('layouts.admin')

@section('title','إنشاء عرض جديد')

@section('admin')
  <div class="admin-header">
    <div class="title"><h1>إنشاء عرض جديد</h1></div>
  </div>

  <form method="post" action="{{ route('admin.tenders.store') }}">
    @csrf
    <label>العنوان</label>
    <input name="title" required />

    <div class="row">
      <div class="col">
        <label>الجهة (من القائمة)</label>
        <select name="client_id">
          <option value="">— اختر جهة —</option>
          @foreach(($clients ?? collect()) as $c)
            <option value="{{ $c->id }}">{{ $c->name }}</option>
          @endforeach
        </select>
        <div class="muted">إن لم تكن الجهة مدرجة، اكتب اسمها يدويًا أدناه</div>
      </div>
      <div class="col">
        <label>رقم المنافسة</label>
        <input name="competition_no" />
      </div>
      <div class="col">
        <label>تاريخ التقديم</label>
        <input type="date" name="submission_date" />
      </div>
    </div>

    <div class="row">
      <div class="col">
        <label>اسم الجهة (يدوي)</label>
        <input name="client_name" />
      </div>
      <div class="col">
        <label>رقم المناقصة</label>
        <input name="tender_no" />
      </div>
      <div class="col">
        <label>مدة السريان (أيام)</label>
        <input type="number" name="validity_days" value="90" />
      </div>
    </div>

    <label>ملاحظات</label>
    <textarea name="notes" rows="3"></textarea>

    <div class="card">
      <h3 style="margin:0 0 8px">العرض المالي (اختياري)</h3>
      <div class="row">
        <div class="col">
          <label>نسبة الضريبة %</label>
          <input type="number" step="0.01" name="financial_offer[vat_rate]" value="15" />
        </div>
        <div class="col">
          <label>خصم</label>
          <input type="number" step="0.01" name="financial_offer[discount]" />
        </div>
      </div>
      <div class="row">
        <div class="col">
          <label>الإجمالي قبل الضريبة</label>
          <input type="number" step="0.01" name="financial_offer[subtotal]" />
        </div>
        <div class="col">
          <label>قيمة الضريبة</label>
          <input type="number" step="0.01" name="financial_offer[total_vat]" />
        </div>
        <div class="col">
          <label>الإجمالي النهائي</label>
          <input type="number" step="0.01" name="financial_offer[total]" />
        </div>
      </div>
      <label>الإجمالي كتابة</label>
      <input name="financial_offer[total_text]" placeholder="مثال: مائة وخمسون ألف ريال سعودي" />

      <div class="table-responsive" style="margin-top:8px">
        <table class="table modern compact">
          <thead>
            <tr>
              <th>البند</th>
              <th>الوصف</th>
              <th>الكمية</th>
              <th>الوحدة</th>
              <th>السعر الإفرادي</th>
              <th>ضريبة</th>
              <th>الإجمالي</th>
            </tr>
          </thead>
          <tbody id="fo-items">
            @for($i=0;$i<5;$i++)
              <tr>
                <td><input name="financial_items[{{ $i }}][name]" /></td>
                <td><input name="financial_items[{{ $i }}][description]" /></td>
                <td><input type="number" step="0.001" name="financial_items[{{ $i }}][qty]" /></td>
                <td><input name="financial_items[{{ $i }}][unit]" /></td>
                <td><input type="number" step="0.01" name="financial_items[{{ $i }}][unit_price]" /></td>
                <td><input type="number" step="0.01" name="financial_items[{{ $i }}][vat]" /></td>
                <td><input type="number" step="0.01" name="financial_items[{{ $i }}][total]" /></td>
              </tr>
            @endfor
          </tbody>
        </table>
      </div>
      <button type="button" class="btn" id="add-fo-item" style="margin-top:8px">+ إضافة بند مالي</button>
    </div>

    <div class="card">
      <h3 style="margin:0 0 8px">جدول الكميات (اختياري)</h3>
      
      <div class="table-responsive">
        <table class="table modern compact">
          <thead>
            <tr>
              <th>الصنف</th>
              <th>الوحدة</th>
              <th>الكمية</th>
              <th>السعر الإفرادي</th>
            </tr>
          </thead>
          <tbody id="boq-rows">
            @for($i=0;$i<10;$i++)
              <tr>
                <td><input name="boq[rows][{{ $i }}][item_name]" /></td>
                <td><input name="boq[rows][{{ $i }}][unit]" /></td>
                <td><input type="number" step="0.003" name="boq[rows][{{ $i }}][quantity]" /></td>
                <td><input type="number" step="0.01" name="boq[rows][{{ $i }}][unit_price]" /></td>
              </tr>
            @endfor
          </tbody>
        </table>
      </div>
      <button type="button" class="btn" id="add-boq-row" style="margin-top:8px">+ إضافة بند</button>
    </div>

    <div class="card">
      <h3 style="margin:0 0 8px">المرفقات الرسمية (اختياري)</h3>
      <div class="table-responsive">
        <table class="table modern compact">
          <thead>
            <tr>
              <th>التصنيف</th>
              <th>التسمية</th>
              <th>ملاحظات</th>
              <th>ترتيب العرض</th>
            </tr>
          </thead>
          <tbody id="att-rows">
            @for($i=0;$i<6;$i++)
              <tr>
                <td><input name="attachments[{{ $i }}][category]" placeholder="license/certificate/other" /></td>
                <td><input name="attachments[{{ $i }}][label]" /></td>
                <td><input name="attachments[{{ $i }}][notes]" /></td>
                <td><input type="number" name="attachments[{{ $i }}][display_order]" value="{{ $i+1 }}" /></td>
              </tr>
            @endfor
          </tbody>
        </table>
      </div>
      <button type="button" class="btn" id="add-att-row" style="margin-top:8px">+ إضافة مرفق</button>
    </div>

    <div class="card">
      <h3 style="margin:0 0 8px">الأعمال السابقة (اختياري)</h3>
      <div class="table-responsive">
        <table class="table modern compact">
          <thead>
            <tr>
              <th>اسم المشروع</th>
              <th>الجهة</th>
              <th>تفاصيل</th>
              <th>السنة</th>
              <th>المدة (أشهر)</th>
              <th>قيمة تقريبية</th>
            </tr>
          </thead>
          <tbody id="prev-rows">
            @for($i=0;$i<5;$i++)
              <tr>
                <td><input name="prev[{{ $i }}][project_name]" /></td>
                <td><input name="prev[{{ $i }}][client_name]" /></td>
                <td><input name="prev[{{ $i }}][details]" /></td>
                <td><input type="number" name="prev[{{ $i }}][year]" /></td>
                <td><input type="number" step="1" name="prev[{{ $i }}][duration_months]" /></td>
                <td><input type="number" step="0.01" name="prev[{{ $i }}][value_amount]" /></td>
              </tr>
            @endfor
          </tbody>
        </table>
      </div>
      <button type="button" class="btn" id="add-prev-row" style="margin-top:8px">+ إضافة عمل سابق</button>
    </div>

    <div style="margin-top:12px">
      <button class="btn" type="submit">حفظ</button>
      <a class="btn" href="{{ route('admin.tenders.index') }}">عودة</a>
    </div>
  </form>

  <script>
    (function(){
      function nextIndex(tbody, prefix){
        var inputs = tbody.querySelectorAll('input[name^="'+prefix+'"]');
        var max = -1;
        inputs.forEach(function(el){
          var m = el.name.match(/\[(\d+)\]/);
          if(m){ var i = parseInt(m[1]); if(i>max) max=i; }
        });
        return max+1;
      }
      var boqBtn = document.getElementById('add-boq-row');
      var boqTbody = document.getElementById('boq-rows');
      if(boqBtn && boqTbody){
        boqBtn.addEventListener('click', function(){
          var i = nextIndex(boqTbody, 'boq[rows]');
          var tr = document.createElement('tr');
          tr.innerHTML = '\
            <td><input name="boq[rows]['+i+'][item_name]" /></td>\
            <td><input name="boq[rows]['+i+'][unit]" /></td>\
            <td><input type="number" step="0.003" name="boq[rows]['+i+'][quantity]" /></td>\
            <td><input type="number" step="0.01" name="boq[rows]['+i+'][unit_price]" /></td>';
          boqTbody.appendChild(tr);
        });
      }
      var attBtn = document.getElementById('add-att-row');
      var attTbody = document.getElementById('att-rows');
      if(attBtn && attTbody){
        attBtn.addEventListener('click', function(){
          var i = nextIndex(attTbody, 'attachments');
          var tr = document.createElement('tr');
          tr.innerHTML = '\
            <td><input name="attachments['+i+'][category]" placeholder="license/certificate/other" /></td>\
            <td><input name="attachments['+i+'][label]" /></td>\
            <td><input name="attachments['+i+'][notes]" /></td>\
            <td><input type="number" name="attachments['+i+'][display_order]" value="'+(i+1)+'" /></td>';
          attTbody.appendChild(tr);
        });
      }
      var prevBtn = document.getElementById('add-prev-row');
      var prevTbody = document.getElementById('prev-rows');
      if(prevBtn && prevTbody){
        prevBtn.addEventListener('click', function(){
          var i = nextIndex(prevTbody, 'prev');
          var tr = document.createElement('tr');
          tr.innerHTML = '\
            <td><input name="prev['+i+'][project_name]" /></td>\
            <td><input name="prev['+i+'][client_name]" /></td>\
            <td><input name="prev['+i+'][details]" /></td>\
            <td><input type="number" name="prev['+i+'][year]" /></td>\
            <td><input type="number" step="1" name="prev['+i+'][duration_months]" /></td>\
            <td><input type="number" step="0.01" name="prev['+i+'][value_amount]" /></td>';
          prevTbody.appendChild(tr);
        });
      }
    })();
  </script>
@endsection
