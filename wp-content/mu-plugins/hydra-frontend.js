(function () {
  'use strict';

  /* ── FAQ accordion ── */
  document.querySelectorAll('.wp-block-details').forEach(function (detail) {
    var summary = detail.querySelector('summary');
    if (!summary) return;

    // Build arrow span
    var arrow = document.createElement('span');
    arrow.className = 'hydra-faq-arrow';
    arrow.setAttribute('aria-hidden', 'true');
    summary.appendChild(arrow);

    // Measure content height for transition
    var content = detail.querySelector('summary ~ *') || detail.querySelector('p') || detail.querySelector('div');

    detail.addEventListener('toggle', function () {
      // Close all siblings first
      if (detail.open) {
        var parent = detail.parentElement;
        parent.querySelectorAll('.wp-block-details[open]').forEach(function (other) {
          if (other !== detail) other.removeAttribute('open');
        });
      }
    });

    summary.addEventListener('click', function (e) {
      e.preventDefault();
      var isOpen = detail.hasAttribute('open');
      // Close siblings
      var parent = detail.parentElement;
      parent.querySelectorAll('.wp-block-details').forEach(function (other) {
        if (other !== detail && other.hasAttribute('open')) {
          other.removeAttribute('open');
        }
      });
      if (isOpen) {
        detail.removeAttribute('open');
      } else {
        detail.setAttribute('open', '');
      }
    });
  });

  /* ── Mobile nav toggle ── */
  var toggle = document.querySelector(
    '.kadence-mobile-nav-toggle, button.menu-toggle, .mobile-trigger'
  );
  var navWrap = document.querySelector(
    '.kadence-mobile-nav-wrap, .mobile-navigation-wrap'
  );
  if (toggle && navWrap) {
    toggle.setAttribute('aria-expanded', 'false');
    toggle.addEventListener('click', function () {
      var open = navWrap.classList.toggle('is-active');
      toggle.setAttribute('aria-expanded', String(open));
      document.body.classList.toggle('nav-open', open);
    });
    // Close when clicking outside
    document.addEventListener('click', function (e) {
      if (
        navWrap.classList.contains('is-active') &&
        !navWrap.contains(e.target) &&
        !toggle.contains(e.target)
      ) {
        navWrap.classList.remove('is-active');
        toggle.setAttribute('aria-expanded', 'false');
        document.body.classList.remove('nav-open');
      }
    });
  }

  /* ── Sticky header scroll shadow ── */
  var header = document.getElementById('masthead') || document.querySelector('.site-header');
  if (header) {
    window.addEventListener('scroll', function () {
      if (window.scrollY > 4) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
    }, { passive: true });
  }
})();
