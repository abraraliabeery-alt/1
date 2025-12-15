<!-- Footer -->
<footer class="footer">
  <div class="container">
    <div class="footer-grid" style="justify-content:center; text-align:center;">
      <div class="footer-col">
        <div class="footer-social">
          <a href="{{ $socialLinks['whatsapp'] ?? '#' }}" aria-label="واتساب" title="واتساب" target="_blank" rel="noopener" style="{{ !empty($socialLinks['whatsapp']) ? '' : 'opacity:.5; pointer-events:none' }}"><i class="bi bi-whatsapp"></i></a>
          <a href="{{ $socialLinks['twitter'] ?? '#' }}" aria-label="منصة إكس" title="منصة إكس" target="_blank" rel="noopener" style="{{ !empty($socialLinks['twitter']) ? '' : 'opacity:.5; pointer-events:none' }}"><i class="bi bi-twitter-x"></i></a>
          <a href="{{ $socialLinks['instagram'] ?? '#' }}" aria-label="إنستغرام" title="إنستغرام" target="_blank" rel="noopener" style="{{ !empty($socialLinks['instagram']) ? '' : 'opacity:.5; pointer-events:none' }}"><i class="bi bi-instagram"></i></a>
          <a href="{{ $socialLinks['linkedin'] ?? '#' }}" aria-label="سناب شات" title="سناب شات" target="_blank" rel="noopener" style="{{ !empty($socialLinks['linkedin']) ? '' : 'opacity:.5; pointer-events:none' }}"><i class="bi bi-snapchat"></i></a>
          <a href="{{ $socialLinks['facebook'] ?? '#' }}" aria-label="فيسبوك" title="فيسبوك" target="_blank" rel="noopener" style="{{ !empty($socialLinks['facebook']) ? '' : 'opacity:.5; pointer-events:none' }}"><i class="bi bi-facebook"></i></a>
          <a href="{{ $socialLinks['tiktok'] ?? '#' }}" aria-label="تيك توك" title="تيك توك" target="_blank" rel="noopener" style="{{ !empty($socialLinks['tiktok']) ? '' : 'opacity:.5; pointer-events:none' }}"><i class="bi bi-tiktok"></i></a>
          <a href="{{ $socialLinks['youtube'] ?? '#' }}" aria-label="يوتيوب" title="يوتيوب" target="_blank" rel="noopener" style="{{ !empty($socialLinks['youtube']) ? '' : 'opacity:.5; pointer-events:none' }}"><i class="bi bi-youtube"></i></a>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <p>© <span id="year"></span> توب ليفل. جميع الحقوق محفوظة. · <a href="{{ route('privacy') }}" style="color:inherit">سياسة الخصوصية</a> · <span style="opacity:.7">اختبار النشر</span></p>
    </div>
  </div>
</footer>
