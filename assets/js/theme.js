/**
 * Eventpromoters — statement moment, mobile navigation, contact feedback.
 */

/* Statement: words light up as the section scrolls past (native scroll, sticky inner). */
(function () {
	'use strict';

	var section = document.querySelector('[data-statement]');
	if (!section || !window.matchMedia('(prefers-reduced-motion: no-preference)').matches) {
		return;
	}
	var words = section.querySelectorAll('.w');
	var lit = -1;
	var queued = false;

	function update() {
		queued = false;
		var rect = section.getBoundingClientRect();
		var travel = rect.height - window.innerHeight;
		var progress = travel > 0 ? Math.min(Math.max(-rect.top / travel, 0), 1) : 1;
		// Finish lighting a little before the end, so the full sentence rests on screen.
		var count = Math.round(Math.min(progress / 0.8, 1) * words.length);
		if (count === lit) {
			return;
		}
		lit = count;
		for (var i = 0; i < words.length; i++) {
			words[i].classList.toggle('is-lit', i < count);
		}
	}

	function onScroll() {
		if (!queued) {
			queued = true;
			window.requestAnimationFrame(update);
		}
	}

	window.addEventListener('scroll', onScroll, { passive: true });
	window.addEventListener('resize', onScroll);
	update();
})();

(function () {
	'use strict';

	var toggle = document.querySelector('.nav-toggle');
	var nav = document.getElementById('site-nav');
	if (!toggle || !nav) {
		return;
	}

	function setOpen(open) {
		nav.classList.toggle('is-open', open);
		toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
	}

	toggle.addEventListener('click', function () {
		setOpen(toggle.getAttribute('aria-expanded') !== 'true');
	});

	// Close after choosing an in-page link.
	nav.addEventListener('click', function (event) {
		if (event.target.closest('a')) {
			setOpen(false);
		}
	});

	// Contact form feedback after redirect: move focus to the message so it gets announced.
	var notice = document.getElementById('ep-contact-notice');
	if (notice) {
		// With invalid fields, go straight to the first one: its error is read via aria-describedby.
		var firstInvalid = document.querySelector('#contact [aria-invalid="true"]');
		(firstInvalid || notice).focus({ preventScroll: true });
	}

	document.addEventListener('keydown', function (event) {
		if (event.key === 'Escape' && nav.classList.contains('is-open')) {
			setOpen(false);
			toggle.focus();
		}
	});
})();
