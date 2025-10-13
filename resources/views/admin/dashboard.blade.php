@extends('layouts.admin')

@section('admin')
  <h1 style="margin-top:0">لوحة التحكم</h1>
  <p class="text-muted">اختَر وحدة لإدارتها.</p>

  <div class="grid-3" style="display:grid; grid-template-columns: repeat(auto-fill,minmax(220px,1fr)); gap:12px">
    <a class="card" href="{{ route('admin.partners.index') }}" style="padding:16px; display:block; text-decoration:none">
      <strong>شركاء التقنية</strong>
      <span class="text-muted" style="display:block">إضافة/تعديل الشركاء</span>
    </a>
    <a class="card" href="{{ route('admin.contacts.index') }}" style="padding:16px; display:block; text-decoration:none">
      <strong>رسائل التواصل</strong>
      <span class="text-muted" style="display:block">عرض/متابعة الرسائل</span>
    </a>
    <a class="card" href="{{ route('admin.services.index') }}" style="padding:16px; display:block; text-decoration:none">
      <strong>الخدمات</strong>
      <span class="text-muted" style="display:block">إضافة/تعديل الخدمات</span>
    </a>
    <a class="card" href="{{ route('projects.create') }}" style="padding:16px; display:block; text-decoration:none">
      <strong>المشاريع</strong>
      <span class="text-muted" style="display:block">إضافة/تعديل المشاريع</span>
    </a>
    <a class="card" href="{{ route('gallery.create') }}" style="padding:16px; display:block; text-decoration:none">
      <strong>الألبوم</strong>
      <span class="text-muted" style="display:block">إضافة صور وترتيب</span>
    </a>
    @if(optional(auth()->user())->role === 'manager')
      <a class="card" href="{{ route('admin.users.promote.form') }}" style="padding:16px; display:block; text-decoration:none">
        <strong>إدارة المستخدمين</strong>
        <span class="text-muted" style="display:block">ترقية/إدارة صلاحيات</span>
      </a>
    @endif
  </div>
@endsection
