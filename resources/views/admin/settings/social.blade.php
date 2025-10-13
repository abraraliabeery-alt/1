@extends('layouts.admin')

@section('admin')
<div class="admin-card" style="display:grid; gap:12px">
  <div class="row-between" style="margin-bottom:4px; align-items:center">
    <div>
      <h3 class="m-0">إعدادات السوشيال ميديا والتواصل</h3>
      <p class="muted" style="margin:4px 0 0">حدّث الروابط وستنعكس مباشرة في الفوتر وزر واتساب.</p>
    </div>
    @if(session('ok'))
      <div class="badge published">{{ session('ok') }}</div>
    @endif
  </div>

  <form action="{{ route('admin.settings.social.update') }}" method="POST" class="card" style="padding:12px; border:1px solid var(--admin-border); border-radius:12px; display:grid; gap:12px">
    @csrf
    @method('PUT')

    <fieldset style="border:1px solid var(--admin-border); border-radius:10px; padding:12px">
      <legend style="padding:0 6px; font-weight:800">بيانات التواصل</legend>
      <div class="grid-2" style="gap:10px">
        <label>
          <span><i class="bi bi-whatsapp" style="margin-inline-start:6px"></i> رقم واتساب (مع كود الدولة)</span>
          <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $whatsapp_number) }}" placeholder="9665XXXXXXXX" />
        </label>
        <label>
          <span><i class="bi bi-telephone" style="margin-inline-start:6px"></i> رقم الهاتف</span>
          <input type="text" name="contact_phone" value="{{ old('contact_phone', $contact_phone) }}" placeholder="مثال: 0112345678" />
        </label>
        <label>
          <span><i class="bi bi-envelope" style="margin-inline-start:6px"></i> البريد الإلكتروني</span>
          <input type="email" name="contact_email" value="{{ old('contact_email', $contact_email) }}" placeholder="name@example.com" />
        </label>
      </div>
    </fieldset>

    <fieldset style="border:1px solid var(--admin-border); border-radius:10px; padding:12px">
      <legend style="padding:0 6px; font-weight:800">روابط السوشيال</legend>
      <div class="grid-2" style="gap:10px">
        <label>
          <span><i class="bi bi-twitter-x" style="margin-inline-start:6px"></i> Twitter/X</span>
          <input type="url" name="social_twitter" value="{{ old('social_twitter', $social_twitter) }}" placeholder="https://x.com/username" />
        </label>
        <label>
          <span><i class="bi bi-instagram" style="margin-inline-start:6px"></i> Instagram</span>
          <input type="url" name="social_instagram" value="{{ old('social_instagram', $social_instagram) }}" placeholder="https://instagram.com/..." />
        </label>
        <label>
          <span><i class="bi bi-linkedin" style="margin-inline-start:6px"></i> LinkedIn</span>
          <input type="url" name="social_linkedin" value="{{ old('social_linkedin', $social_linkedin) }}" placeholder="https://linkedin.com/company/..." />
        </label>
        <label>
          <span><i class="bi bi-facebook" style="margin-inline-start:6px"></i> Facebook</span>
          <input type="url" name="social_facebook" value="{{ old('social_facebook', $social_facebook) }}" placeholder="https://facebook.com/..." />
        </label>
        <label>
          <span><i class="bi bi-tiktok" style="margin-inline-start:6px"></i> TikTok</span>
          <input type="url" name="social_tiktok" value="{{ old('social_tiktok', $social_tiktok) }}" placeholder="https://tiktok.com/@..." />
        </label>
        <label>
          <span><i class="bi bi-youtube" style="margin-inline-start:6px"></i> YouTube</span>
          <input type="url" name="social_youtube" value="{{ old('social_youtube', $social_youtube) }}" placeholder="https://youtube.com/@..." />
        </label>
      </div>
    </fieldset>

    <div style="display:flex; justify-content:flex-end; gap:8px">
      <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">رجوع</a>
      <button class="btn btn-primary" type="submit">حفظ</button>
    </div>
  </form>
</div>
@endsection
