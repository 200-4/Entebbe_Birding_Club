document.addEventListener('DOMContentLoaded', function () {

  /* ---------- HERO CAROUSEL ---------- */
  var slides = Array.prototype.slice.call(document.querySelectorAll('.hero-slide'));
  var dotsWrap = document.getElementById('heroDots');
  if (slides.length && dotsWrap) {
    var current = 0;
    var timer;

    slides.forEach(function (_, i) {
      var dot = document.createElement('button');
      dot.className = 'hero-dot' + (i === 0 ? ' is-active' : '');
      dot.setAttribute('aria-label', 'Go to slide ' + (i + 1));
      dot.addEventListener('click', function () { goTo(i); });
      dotsWrap.appendChild(dot);
    });
    var dots = Array.prototype.slice.call(dotsWrap.children);

    function goTo(index) {
      slides[current].classList.remove('is-active');
      dots[current].classList.remove('is-active');
      current = (index + slides.length) % slides.length;
      slides[current].classList.add('is-active');
      dots[current].classList.add('is-active');
      resetTimer();
    }
    function next() { goTo(current + 1); }
    function prev() { goTo(current - 1); }
    function resetTimer() {
      clearInterval(timer);
      timer = setInterval(next, 6500);
    }

    var nextButton = document.getElementById('heroNext');
    var prevButton = document.getElementById('heroPrev');
    if (nextButton && prevButton) {
      nextButton.addEventListener('click', next);
      prevButton.addEventListener('click', prev);
    }
    resetTimer();
  }

  /* ---------- MOBILE NAV ---------- */
  var navToggle = document.getElementById('navToggle');
  var navList = document.getElementById('navList');
  navToggle.addEventListener('click', function () {
    navList.classList.toggle('is-open');
  });
  navList.querySelectorAll('a').forEach(function (a) {
    a.addEventListener('click', function () { navList.classList.remove('is-open'); });
  });

  /* ---------- ACTIVE NAV ON SCROLL ---------- */
  var navLinks = Array.prototype.slice.call(document.querySelectorAll('.nav-link'));
  var sections = navLinks.map(function (l) {
    return document.querySelector(l.getAttribute('href'));
  }).filter(Boolean);

  function onScroll() {
    if (!sections.length) return;
    var scrollPos = window.scrollY + 140;
    var activeIndex = 0;
    sections.forEach(function (sec, i) {
      if (sec.offsetTop <= scrollPos) activeIndex = i;
    });
    navLinks.forEach(function (l) { l.classList.remove('active'); });
    navLinks[activeIndex].classList.add('active');
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  /* ---------- SCROLL REVEAL ---------- */
  var revealEls = document.querySelectorAll('.reveal');
  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        io.unobserve(entry.target);
      }
    });
  }, { threshold: 0.14 });
  revealEls.forEach(function (el) { io.observe(el); });

});
