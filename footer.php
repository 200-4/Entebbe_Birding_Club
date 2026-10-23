<!-- ============ FOOTER ============ -->
<footer class="site-footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <a href="<?= !empty($isHomePage) ? '#home' : '/index.php#home' ?>" class="logo">
          <img src="/images/ebc_logo_final.svg" alt="Entebbe Birding Club logo" class="logo-mark" />
        </a>
        <p>Entebbe Birding Club is a community-based organisation focused on improving awareness of Uganda's communities about birds and their habitats.</p>
        <div class="footer-social">
          <a href="https://facebook.com/groups/1468991843763593/?mibextid=rS40aB7S9Ucbxw6v" aria-label="Facebook"><i class="fa-brands fa-facebook-f" aria-hidden="true"></i></a>
          <a href="https://x.com/Entebbebirdclub" aria-label="X"><i class="fa-brands fa-x" aria-hidden="true"></i></a>
        </div>
      </div>

      <div class="footer-col">
        <h4>Expect These on Excursions</h4>
        <ul>
          <li>Shoebill Trips</li>
          <li>Birdingg in National Parks</li>
          <li>Birding at UWEC_CA</li>
          <li>Birding at Entebbe Botanical Gardens</li>
          <li>Birding at Lutembe Swamp</li>
        </ul>
      </div>

      <div class="footer-col">
        <h4>Need to Know About Us</h4>
        <ul>
          <li><a href="<?= !empty($isHomePage) ? '#about' : '/index.php#about' ?>">About Us</a></li>
          <li><a href="<?= !empty($isHomePage) ? '#contact' : '/index.php#contact' ?>">Contact Us</a></li>
          <li><a href="<?= !empty($isHomePage) ? '#contact' : '/index.php#contact' ?>">Become a Member</a></li>
          <li><a href="#">Frequently Asked Questions</a></li>
        </ul>
      </div>

      <div class="footer-col">
        <h4>How to Get in Touch</h4>
        <div class="footer-contact-item">
          <span class="ico"><i class="fa-brands fa-whatsapp" aria-hidden="true"></i></span>
          <span>+256 768 302806 (WhatsApp)</span>
        </div>
        <div class="footer-contact-item">
          <span class="ico"><i class="fa-solid fa-phone" aria-hidden="true"></i></span>
          <span>+256 700 603938 (Call)</span>
        </div>
        <div class="footer-contact-item">
          <span class="ico"><i class="fa-solid fa-envelope" aria-hidden="true"></i></span>
          <span>entebbebirdingclub@gmail.com</span>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <span>© 2026 Entebbe Birding Club. All rights reserved.</span>
      <span>Bird. Explore. Excursions.</span>
    </div>
  </div>
</footer>

<script src="/script.js"></script>
</body>
</html>
