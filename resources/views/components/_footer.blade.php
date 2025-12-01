<!-- Footer -->
<footer class="footer">
  <div class="container">
    @php($hasSettings = \Illuminate\Support\Facades\Schema::hasTable('settings'))
    @php($wa = $hasSettings ? \App\Models\Setting::getValue('whatsapp_number') : null)
    @php($x = $hasSettings ? \App\Models\Setting::getValue('social_twitter') : null)
    @php($ig = $hasSettings ? \App\Models\Setting::getValue('social_instagram') : null)
    @php($in = $hasSettings ? \App\Models\Setting::getValue('social_linkedin') : null)
    @php($fb = $hasSettings ? \App\Models\Setting::getValue('social_facebook') : null)
    @php($tk = $hasSettings ? \App\Models\Setting::getValue('social_tiktok') : null)
    @php($yt = $hasSettings ? \App\Models\Setting::getValue('social_youtube') : null)
    @php($waHref = $wa ? 'https://wa.me/'.preg_replace('/[^0-9]/','',$wa) : null)

    <div class="footer-grid" style="justify-content:center; text-align:center;">
      <div class="footer-col">
        <div class="footer-social">
          <a href="{{ $waHref ?? '#' }}" aria-label="واتساب" title="واتساب" target="_blank" rel="noopener" style="{{ $waHref ? '' : 'opacity:.5; pointer-events:none' }}"><i class="bi bi-whatsapp"></i></a>
          <a href="{{ $x ?? '#' }}" aria-label="منصة إكس" title="منصة إكس" target="_blank" rel="noopener" style="{{ $x ? '' : 'opacity:.5; pointer-events:none' }}"><i class="bi bi-twitter-x"></i></a>
          <a href="{{ $ig ?? '#' }}" aria-label="إنستغرام" title="إنستغرام" target="_blank" rel="noopener" style="{{ $ig ? '' : 'opacity:.5; pointer-events:none' }}"><i class="bi bi-instagram"></i></a>
          <a href="{{ $in ?? '#' }}" aria-label="لينكد إن" title="لينكد إن" target="_blank" rel="noopener" style="{{ $in ? '' : 'opacity:.5; pointer-events:none' }}"><i class="bi bi-linkedin"></i></a>
          <a href="{{ $fb ?? '#' }}" aria-label="فيسبوك" title="فيسبوك" target="_blank" rel="noopener" style="{{ $fb ? '' : 'opacity:.5; pointer-events:none' }}"><i class="bi bi-facebook"></i></a>
          <a href="{{ $tk ?? '#' }}" aria-label="تيك توك" title="تيك توك" target="_blank" rel="noopener" style="{{ $tk ? '' : 'opacity:.5; pointer-events:none' }}"><i class="bi bi-tiktok"></i></a>
          <a href="{{ $yt ?? '#' }}" aria-label="يوتيوب" title="يوتيوب" target="_blank" rel="noopener" style="{{ $yt ? '' : 'opacity:.5; pointer-events:none' }}"><i class="bi bi-youtube"></i></a>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <p>© <span id="year"></span> توب ليفل. جميع الحقوق محفوظة. · <a href="{{ route('privacy') }}" style="color:inherit">سياسة الخصوصية</a> · <span style="opacity:.7">اختبار النشر</span></p>
    </div>
  </div>
</footer>
