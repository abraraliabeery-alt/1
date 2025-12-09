@extends('layouts.admin')

@section('admin')
  <div class="row-between" style="align-items:center; gap:12px">
    <h1 style="margin-top:0">رسالة #{{ $contact->id }}</h1>
    <a class="btn btn-outline" href="{{ route('admin.contacts.index') }}">← رجوع</a>
  </div>

  <div class="card" style="padding:16px; margin-bottom:16px">
    <div><strong>الاسم:</strong> {{ $contact->name ?? '—' }}</div>
    <div><strong>البريد:</strong> {{ $contact->email ?? '—' }}</div>
    <div><strong>الهاتف:</strong> {{ $contact->phone ?? '—' }}</div>
    <div><strong>التاريخ:</strong> {{ $contact->created_at->format('Y-m-d H:i') }}</div>
  </div>

  <article class="card" style="padding:16px; margin-bottom:16px">
    <h3 class="h3-compact">الرسالة</h3>
    <p style="white-space:pre-wrap">{{ $contact->message }}</p>
  </article>

  <form method="POST" action="{{ route('admin.contacts.update', $contact) }}" class="card" style="padding:16px; display:grid; gap:12px">
    @method('PUT')
    <h3 class="h3-compact">إدارة المتابعة</h3>
    <label>
      الحالة
      <select name="status" class="@error('status') is-invalid @enderror">
        <option value="new" @selected(old('status', $contact->status ?? 'new')==='new')>جديد</option>
        <option value="in_progress" @selected(old('status', $contact->status ?? 'new')==='in_progress')>قيد المتابعة</option>
        <option value="closed" {{ $st==='closed' ? 'selected' : '' }}>مغلق</option>
      </select>
      @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </label>
    <label>
      موعد متابعة
      <input type="datetime-local" name="follow_up_at" value="{{ old('follow_up_at', optional($contact->follow_up_at)->format('Y-m-d\\TH:i')) }}" class="@error('follow_up_at') is-invalid @enderror" />
      @error('follow_up_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </label>
    <label>
      تعيين لموظف
      <select name="assigned_employee_id" class="@error('assigned_employee_id') is-invalid @enderror">
        <option value="">— غير معيّن —</option>
        @foreach($staff as $u)
          <option value="{{ $u->id }}" {{ (old('assigned_employee_id', $contact->assigned_employee_id) == $u->id) ? 'selected' : '' }}>{{ $u->name }}</option>
        @endforeach
      </select>
      @error('assigned_employee_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </label>
    <label>
      ملاحظة داخلية
      <textarea name="note" rows="4" placeholder="اكتب ملاحظة لزملائك (لا تُرسل للعميل)" class="@error('note') is-invalid @enderror">{{ old('note', $contact->note) }}</textarea>
      @error('note')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </label>
    <div>
      <button class="btn btn-primary" type="submit">حفظ</button>
    </div>
  </form>
{{ ... }}
