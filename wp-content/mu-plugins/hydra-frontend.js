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

  /* ── Sidebar form: fix all-selected bug + pre-select by page ── */
  document.addEventListener('DOMContentLoaded', function () {
    var forms = document.querySelectorAll('.wpforms-form');
    forms.forEach(function (form) {
      var selects = form.querySelectorAll('select');
      selects.forEach(function (sel) {
        // Detect service dropdown by option count (>= 5 options)
        if (sel.options.length < 5) { return; }

        // Fix: remove selected from all options first
        Array.from(sel.options).forEach(function (opt) {
          opt.selected = false;
          opt.removeAttribute('selected');
        });

        // Determine which service matches the current page H1
        var h1 = document.querySelector('h1.wp-block-heading');
        var title = h1 ? h1.textContent.trim() : '';

        var map = [
          ['Temperature Mapping',          'Temperature Mapping'],
          ['Validation',                   'Validation & Qualification'],
          ['GDP Compliance',               'GDP Compliance'],
          ['Calibration',                  'Calibration Services'],
          ['Quality Management',           'Pharma QMS'],
          ['Computer System Validation',   'Computer System Validation'],
          ['Cold Chain',                   'Cold Chain Solutions'],
          ['Monitoring',                   'Monitoring & Data Loggers'],
          ['Temperature Data Logger',      'Temperature Data Logger'],
          ['Thermal Packaging',            'Thermal Packaging'],
        ];

        var matched = false;
        for (var i = 0; i < map.length; i++) {
          if (title.indexOf(map[i][0]) !== -1) {
            for (var j = 0; j < sel.options.length; j++) {
              if (sel.options[j].value === map[i][1] ||
                  sel.options[j].text  === map[i][1]) {
                sel.selectedIndex = j;
                matched = true;
                break;
              }
            }
            if (matched) { break; }
          }
        }
        // Default to first option if nothing matched
        if (!matched && sel.options.length > 0) {
          sel.selectedIndex = 0;
        }
      });
    });
  });
})();
