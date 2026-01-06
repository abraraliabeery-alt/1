<footer class="footer t5-footer">
  <div class="container">
    <div class="footer-grid" style="justify-content:center; text-align:center;">
      <div class="footer-col">
        <div class="footer-social t5-footer-social">
          @if(!empty($socialLinks['whatsapp'] ?? null))
            <a href="{{ $socialLinks['whatsapp'] }}" aria-label="واتساب" title="واتساب" target="_blank" rel="noopener"><i class="bi bi-whatsapp"></i></a>
          @endif
          @if(!empty($socialLinks['twitter'] ?? null))
            <a href="{{ $socialLinks['twitter'] }}" aria-label="منصة إكس" title="منصة إكس" target="_blank" rel="noopener"><i class="bi bi-twitter-x"></i></a>
          @endif
          @if(!empty($socialLinks['instagram'] ?? null))
            <a href="{{ $socialLinks['instagram'] }}" aria-label="إنستغرام" title="إنستغرام" target="_blank" rel="noopener"><i class="bi bi-instagram"></i></a>
          @endif
          @if(!empty($socialLinks['linkedin'] ?? null))
            <a href="{{ $socialLinks['linkedin'] }}" aria-label="سناب شات" title="سناب شات" target="_blank" rel="noopener"><i class="bi bi-snapchat"></i></a>
          @endif
          @if(!empty($socialLinks['facebook'] ?? null))
            <a href="{{ $socialLinks['facebook'] }}" aria-label="فيسبوك" title="فيسبوك" target="_blank" rel="noopener"><i class="bi bi-facebook"></i></a>
          @endif
          @if(!empty($socialLinks['tiktok'] ?? null))
            <a href="{{ $socialLinks['tiktok'] }}" aria-label="تيك توك" title="تيك توك" target="_blank" rel="noopener"><i class="bi bi-tiktok"></i></a>
          @endif
          @if(!empty($socialLinks['youtube'] ?? null))
            <a href="{{ $socialLinks['youtube'] }}" aria-label="يوتيوب" title="يوتيوب" target="_blank" rel="noopener"><i class="bi bi-youtube"></i></a>
          @endif
        </div>
      </div>
    </div>
    <div class="footer-bottom t5-footer-bottom">
      <p>© <span id="year"></span> {{ $siteTitle ?? 'Epdaa' }}. جميع الحقوق محفوظة. · <a href="{{ route('privacy') }}" style="color:inherit">سياسة الخصوصية</a></p>
    </div>
  </div>
</footer>
