<!-- Footer -->
<footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-col">
        <a class="brand" href="#top" aria-label="Top Level" style="text-decoration:none; color:inherit">
          <img src="/assets/top.png" alt="Top Level - توب ليفل" style="height:36px; width:auto" />
        </a>
        <p class="footer-desc">حلول متكاملة للإنشاءات والتشطيبات وMEP، مع تخصص في المنازل والمكاتب الذكية.</p>
      </div>
      <div class="footer-col">
        <h5 class="footer-title">روابط سريعة</h5>
        <ul class="footer-links">
          <li><a href="#services">الخدمات</a></li>
          <li><a href="#home-solutions">المنزل الذكي</a></li>
          <li><a href="#office-solutions">المكتب الذكي</a></li>
          <li><a href="{{ route('properties.index') }}">العقارات</a></li>
          <li><a href="{{ route('projects.index') }}">المشاريع</a></li>
          <li><a href="#contact">تواصل</a></li>
          <li><a href="{{ route('privacy') }}">سياسة الخصوصية</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h5 class="footer-title">تواصل</h5>
        @php($hasSettings = \Illuminate\Support\Facades\Schema::hasTable('settings'))
        @php($phone = $hasSettings ? \App\Models\Setting::getValue('contact_phone') : null)
        @php($email = $hasSettings ? \App\Models\Setting::getValue('contact_email') : null)
        @php($wa = $hasSettings ? \App\Models\Setting::getValue('whatsapp_number') : null)
        <ul class="footer-links">
          @if($phone)
            <li><a href="tel:{{ preg_replace('/\s+/', '', $phone) }}">{{ $phone }}</a></li>
          @endif
          @if($email)
            <li><a href="mailto:{{ $email }}">{{ $email }}</a></li>
          @endif
          @if($wa)
            <li><a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $wa) }}" target="_blank" rel="noopener">واتساب مباشر</a></li>
          @endif
        </ul>
        @php($x = $hasSettings ? \App\Models\Setting::getValue('social_twitter') : null)
        @php($ig = $hasSettings ? \App\Models\Setting::getValue('social_instagram') : null)
        @php($in = $hasSettings ? \App\Models\Setting::getValue('social_linkedin') : null)
        @php($fb = $hasSettings ? \App\Models\Setting::getValue('social_facebook') : null)
        @php($tk = $hasSettings ? \App\Models\Setting::getValue('social_tiktok') : null)
        @php($yt = $hasSettings ? \App\Models\Setting::getValue('social_youtube') : null)
        @php($waHref = $wa ? 'https://wa.me/'.preg_replace('/[^0-9]/','',$wa) : null)
        <div class="footer-social">
          <a href="{{ $waHref ?? '#' }}" aria-label="WhatsApp" title="WhatsApp" target="_blank" rel="noopener" style="{{ $waHref ? '' : 'opacity:.5; pointer-events:none' }}"><i class="bi bi-whatsapp"></i></a>
          <a href="{{ $x ?? '#' }}" aria-label="Twitter/X" title="Twitter/X" target="_blank" rel="noopener" style="{{ $x ? '' : 'opacity:.5; pointer-events:none' }}"><i class="bi bi-twitter-x"></i></a>
          <a href="{{ $ig ?? '#' }}" aria-label="Instagram" title="Instagram" target="_blank" rel="noopener" style="{{ $ig ? '' : 'opacity:.5; pointer-events:none' }}"><i class="bi bi-instagram"></i></a>
          <a href="{{ $in ?? '#' }}" aria-label="LinkedIn" title="LinkedIn" target="_blank" rel="noopener" style="{{ $in ? '' : 'opacity:.5; pointer-events:none' }}"><i class="bi bi-linkedin"></i></a>
          <a href="{{ $fb ?? '#' }}" aria-label="Facebook" title="Facebook" target="_blank" rel="noopener" style="{{ $fb ? '' : 'opacity:.5; pointer-events:none' }}"><i class="bi bi-facebook"></i></a>
          <a href="{{ $tk ?? '#' }}" aria-label="TikTok" title="TikTok" target="_blank" rel="noopener" style="{{ $tk ? '' : 'opacity:.5; pointer-events:none' }}"><i class="bi bi-tiktok"></i></a>
          <a href="{{ $yt ?? '#' }}" aria-label="YouTube" title="YouTube" target="_blank" rel="noopener" style="{{ $yt ? '' : 'opacity:.5; pointer-events:none' }}"><i class="bi bi-youtube"></i></a>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <p>© <span id="year"></span> توب ليفل. جميع الحقوق محفوظة. · <a href="{{ route('privacy') }}" style="color:inherit">سياسة الخصوصية</a></p>
    </div>
  </div>
</footer>
