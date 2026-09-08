/* NOOR front-end behavior — mobile drawer, region switcher, lead popup, copy-link share. */
(function () {
	'use strict';

	/* ---------- mobile drawer ---------- */
	(function initDrawer() {
		var burger = document.querySelector('.noor-burger');
		var drawer = document.getElementById('noor-drawer');
		if (!burger || !drawer) return;

		var close = drawer.querySelector('.noor-drawer-close');
		var backdrop = drawer.querySelector('.noor-drawer-backdrop');

		function setOpen(open) {
			drawer.classList.toggle('open', open);
			drawer.setAttribute('aria-hidden', open ? 'false' : 'true');
			burger.setAttribute('aria-expanded', open ? 'true' : 'false');
			document.body.style.overflow = open ? 'hidden' : '';
		}

		burger.addEventListener('click', function () {
			setOpen(!drawer.classList.contains('open'));
		});
		if (close) close.addEventListener('click', function () { setOpen(false); });
		if (backdrop) backdrop.addEventListener('click', function () { setOpen(false); });
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape') setOpen(false);
		});
	})();

	/* ---------- helpers ---------- */
	function getCookie(name) {
		var m = document.cookie.match('(^|;)\\s*' + name + '\\s*=\\s*([^;]+)');
		return m ? m.pop() : '';
	}
	function setCookie(name, value, days) {
		var d = new Date();
		d.setTime(d.getTime() + days * 864e5);
		document.cookie = name + '=' + value + ';expires=' + d.toUTCString() + ';path=/';
	}

	/* ---------- region switcher (open/close) ---------- */
	document.addEventListener('click', function (e) {
		var sw = document.querySelector('.noor-region-switcher');
		if (!sw) return;
		if (sw.contains(e.target) && e.target.closest('button')) {
			sw.classList.toggle('open');
		} else if (!sw.contains(e.target)) {
			sw.classList.remove('open');
		}
	});

	/* ---------- lead popup ---------- */
	var overlay = document.getElementById('noor-popup');
	if (overlay && typeof NOOR_CFG !== 'undefined' && !getCookie('noor_popup_seen')) {
		setTimeout(function () {
			overlay.classList.add('show');
		}, NOOR_CFG.popupDelay || 9000);

		function dismiss() {
			overlay.classList.remove('show');
			setCookie('noor_popup_seen', '1', NOOR_CFG.popupCookieDays || 14);
		}
		overlay.querySelector('.noor-popup-close').addEventListener('click', dismiss);
		overlay.addEventListener('click', function (e) {
			if (e.target === overlay) dismiss();
		});

		var form = document.getElementById('noor-popup-form');
		form.addEventListener('submit', function (e) {
			e.preventDefault();
			var fd = new FormData();
			fd.append('action', 'noor_lead');
			fd.append('name', form.querySelector('[name=noor_name]').value);
			fd.append('email', form.querySelector('[name=noor_email]').value);
			fetch(NOOR_CFG.ajaxUrl, { method: 'POST', body: fd })
				.then(function (r) { return r.json(); })
				.then(function (res) {
					if (res.success) {
						form.style.display = 'none';
						overlay.querySelector('.noor-popup-done').style.display = 'block';
						setCookie('noor_popup_seen', '1', 365);
					}
				});
		});
	}


	/* ---------- rental booking: French calendar ----------
	   Cost labels are translated server-side (inc/rental.php). Do NOT relabel
	   them here: rewriting the DOM after each AJAX render fights the browser's
	   auto-translate and makes the totals box visibly flicker. */
	(function initBookingCalendarFrench() {
		var FR = {
			weekdays: {
				shorthand: ['dim', 'lun', 'mar', 'mer', 'jeu', 'ven', 'sam'],
				longhand: ['dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi']
			},
			months: {
				shorthand: ['janv', 'févr', 'mars', 'avr', 'mai', 'juin', 'juil', 'août', 'sept', 'oct', 'nov', 'déc'],
				longhand: ['janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre']
			},
			firstDayOfWeek: 1,
			rangeSeparator: ' au ',
			weekAbbreviation: 'sem',
			time_24hr: true
		};

		function applyLocale() {
			document.querySelectorAll('.flatpickr-input').forEach(function (input) {
				if (!input._flatpickr || input.dataset.noorFr) return;
				input.dataset.noorFr = '1';
				try { input._flatpickr.set('locale', FR); } catch (e) {}
			});
		}

		applyLocale();
		setTimeout(applyLocale, 800);
	})();


	/* ---------- rental: dates + deposit tick gate the booking button ----------
	   PHP refuses both cases on its own (inc/rental.php); this just makes the
	   rules visible instead of letting people click and get an error page.
	   The booking plugin leaves its own date fields unvalidated, so an empty
	   pair used to sail through into the cart. */
	(function initBookingGate() {
		var box = document.querySelector('.noor-deposit-notice--product input[type=checkbox]');
		var form = box ? box.closest('form.cart') : document.querySelector('form.cart .mbfw-date-picker-section');
		if (form && !form.matches('form.cart')) form = form.closest('form.cart');
		if (!form) return;
		var btn = form.querySelector('.single_add_to_cart_button');
		if (!btn) return;

		var from = form.querySelector('[name="mwb_mbfw_booking_from_time"]');
		var to = form.querySelector('[name="mwb_mbfw_booking_to_time"]');
		var hint = document.querySelector('.noor-date-required');

		function datesOk() {
			if (!from && !to) return true;               // not a booking product
			return !!(from && from.value.trim()) && !!(to && to.value.trim());
		}
		function depositOk() {
			return !box || box.checked;
		}

		function sync() {
			var ok = datesOk() && depositOk();
			btn.classList.toggle('noor-btn-locked', !ok);
			btn.setAttribute('aria-disabled', ok ? 'false' : 'true');
			btn.title = datesOk()
				? (depositOk() ? '' : 'Merci d\u2019accepter la condition de caution.')
				: 'Merci de choisir vos dates de location.';
			if (hint && datesOk()) hint.hidden = true;
		}

		if (box) box.addEventListener('change', sync);
		[from, to].forEach(function (input) {
			if (!input) return;
			input.addEventListener('change', sync);
			input.addEventListener('input', sync);
		});

		/* Show the missing-dates message. */
		function flagDates() {
			if (hint) hint.hidden = false;
		}
		function flagDeposit() {
			if (box) box.closest('.noor-deposit-notice').classList.add('noor-deposit-notice--error');
		}

		/* The deposit tick carries `required`, so when it is unticked the browser's
		   own constraint validation aborts the submission and `submit` NEVER fires
		   — which used to swallow the date message the client asked for. `click` on
		   the button fires before that check, so the message is shown either way. */
		btn.addEventListener('click', function () {
			if (!datesOk()) flagDates();
		});

		form.addEventListener('submit', function (e) {
			if (!datesOk()) {
				e.preventDefault();
				flagDates();
				(from || btn).focus();
				return;
			}
			if (!depositOk()) {
				e.preventDefault();
				flagDeposit();
				box.focus();
			}
		});

		/* flatpickr writes the value without firing `input`, and the plugin
		   re-renders its price box by AJAX \u2014 poll briefly so the button unlocks
		   as soon as a date lands in the field. */
		var ticks = 0;
		var poll = setInterval(function () {
			sync();
			if (++ticks > 60) clearInterval(poll);
		}, 500);

		sync();
	})();

	/* ---------- rental: strike out the days already booked ----------
	   PHP works the list out and hands it over in NOOR_RENTAL. The booking
	   plugin owns the two flatpickr instances, so we wait for them to exist,
	   then add our own rule on top of whatever the plugin already set. */
	(function initRentalAvailability() {
		if (typeof NOOR_RENTAL === 'undefined' || !NOOR_RENTAL.unavailable || !NOOR_RENTAL.unavailable.length) return;
		var blocked = NOOR_RENTAL.unavailable;

		function key(date) {
			return date.getFullYear() + '-' +
				('0' + (date.getMonth() + 1)).slice(-2) + '-' +
				('0' + date.getDate()).slice(-2);
		}
		function isBlocked(date) {
			return blocked.indexOf(key(date)) !== -1;
		}

		var tries = 0;
		var timer = setInterval(function () {
			var inputs = document.querySelectorAll('#mwb-mbfw-booking-from-time, #mwb-mbfw-booking-to-time');
			var patched = 0;
			Array.prototype.forEach.call(inputs, function (input) {
				var fp = input._flatpickr;
				if (!fp) return;
				patched++;
				if (fp.noorAvailability) return;
				fp.noorAvailability = true;

				fp.config.onDayCreate.push(function (dObj, dStr, inst, dayElem) {
					if (dayElem.dateObj && isBlocked(dayElem.dateObj)) {
						dayElem.classList.add('noor-day-booked');
						dayElem.title = 'Déjà réservé';
					}
				});
				/* Function form on purpose: flatpickr parses plain date strings
				   with the field format (d-m-Y), which our keys are not.
				   The rule is pushed straight onto the config rather than
				   through fp.set(), which fires the change hooks and makes the
				   booking plugin request a total for dates nobody picked yet
				   (the price box would then show 0,00 € on arrival). */
				fp.config.disable = (fp.config.disable || []).concat([isBlocked]);
				fp.config._disable = (fp.config._disable || []).concat([isBlocked]);
				fp.redraw();
			});
			if (patched >= inputs.length && inputs.length) clearInterval(timer);
			if (++tries > 40) clearInterval(timer);
		}, 250);
	})();

	/* ---------- product: live total of the "bought together" pack ----------
	   Display only. PHP recomputes every amount when the cart is built, so a
	   tampered figure here changes nothing. */
	(function initBundleTotal() {
		var box = document.querySelector('[data-noor-bundle]');
		if (!box) return;

		var totalEl = box.querySelector('[data-bundle-total]');
		var selfEl = box.querySelector('[data-self-price]');
		var boxes = box.querySelectorAll('input[name="noor_bundle[]"]');
		if (!totalEl) return;

		var basePrice = parseFloat(box.getAttribute('data-base')) || 0;

		/* Read the currency format back from the price already rendered by PHP,
		   so we never hard-code a symbol, separator or decimal count. */
		var sample = selfEl ? selfEl.textContent.trim() : '';
		var digits = sample.match(/[\d\s .,]+/);
		var decimals = 2;
		if (digits) {
			var tail = digits[0].trim().split(/[.,]/).pop();
			decimals = (tail && tail.length <= 2) ? tail.length : 0;
		}

		function money(value) {
			if (!sample) return value.toFixed(decimals);
			var formatted = value.toFixed(decimals).replace('.', ',');
			return sample.replace(/[\d\s .,]*\d/, formatted);
		}

		function refresh() {
			var total = basePrice;
			Array.prototype.forEach.call(boxes, function (input) {
				if (input.checked) total += parseFloat(input.getAttribute('data-price')) || 0;
			});
			totalEl.innerHTML = money(total);
		}

		Array.prototype.forEach.call(boxes, function (input) {
			input.addEventListener('change', refresh);
		});

		/* A variable product has no price until an option is chosen. */
		if (window.jQuery) {
			jQuery(document.body).on('found_variation', function (event, variation) {
				if (variation && variation.display_price) {
					basePrice = parseFloat(variation.display_price);
					if (selfEl) selfEl.innerHTML = money(basePrice);
					refresh();
				}
			});
			jQuery(document.body).on('reset_data', function () {
				basePrice = parseFloat(box.getAttribute('data-base')) || 0;
				if (selfEl) selfEl.innerHTML = money(basePrice);
				refresh();
			});
		}

		refresh();
	})();

	/* ---------- shop: filter panel folds away on phones ---------- */
	(function initShopFilters() {
		var toggle = document.querySelector('.noor-filter-toggle');
		var panel = document.getElementById('noor-filters');
		if (!toggle || !panel) return;
		toggle.addEventListener('click', function () {
			var open = panel.classList.toggle('is-open');
			toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
			toggle.textContent = open ? 'Masquer les filtres' : 'Filtrer les produits';
		});
	})();

	/* ---------- copy-link share (Instagram / TikTok) ---------- */
	document.querySelectorAll('.noor-copylink').forEach(function (btn) {
		btn.addEventListener('click', function () {
			navigator.clipboard.writeText(window.location.href).then(function () {
				var old = btn.textContent;
				btn.textContent = '✅ Lien copié !';
				setTimeout(function () { btn.textContent = old; }, 2000);
			});
		});
	});
})();
