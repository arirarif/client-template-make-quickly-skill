/* global svpiAdmin */
(function () {
	'use strict';

	const form       = document.getElementById( 'svpi-import-form' );
	if ( ! form ) return;

	const progWrap   = document.getElementById( 'svpi-progress-wrap' );
	const progBar    = document.getElementById( 'svpi-progress-bar' );
	const progTrack  = progBar ? progBar.parentElement : null;
	const progLabel  = document.getElementById( 'svpi-progress-label' );
	const progPct    = document.getElementById( 'svpi-progress-pct' );
	const progLog    = document.getElementById( 'svpi-progress-log' );
	const logSummary = document.getElementById( 'svpi-log-summary' );
	const resultsWrap = document.getElementById( 'svpi-results-wrap' );
	const swatchNote  = document.getElementById( 'svpi-swatch-note' );
	const submitBtn   = document.getElementById( 'svpi-submit-btn' );

	const icons = { product: '✅', update: '🔄', skip: '⏭', error: '❌', attr: '🏷', image: '🖼' };

	function setProgress( pct, label ) {
		const p = Math.min( 100, Math.max( 0, pct ) );
		progBar.style.width = p + '%';
		if ( progTrack ) progTrack.setAttribute( 'aria-valuenow', p );
		progLabel.textContent = label;
		progPct.textContent   = Math.round( p ) + '%';
	}

	function appendLog( entries ) {
		entries.forEach( function ( entry ) {
			const div       = document.createElement( 'div' );
			div.className   = 'svpi-log__line svpi-log__line--' + ( entry.type || 'info' );
			div.textContent = ( icons[ entry.type ] || '·' ) + ' ' + entry.message;
			progLog.appendChild( div );
		} );
		progLog.scrollTop = progLog.scrollHeight;
		if ( logSummary ) {
			logSummary.textContent = 'Import Log (' + progLog.children.length + ' entries)';
		}
	}

	function showError( msg ) {
		progLabel.textContent = '⛔ ' + msg;
		progPct.textContent   = '';
		progBar.classList.add( 'svpi-progress-bar--error' );
		submitBtn.disabled = false;
	}

	function renderResults( totals ) {
		const statMap = [
			{ key: 'created',    label: 'Products Created', cls: 'created' },
			{ key: 'updated',    label: 'Products Updated', cls: 'updated' },
			{ key: 'variations', label: 'Variations',       cls: 'variations' },
			{ key: 'images',     label: 'Images Uploaded',  cls: 'images' },
			{ key: 'skipped',    label: 'Skipped',          cls: 'skipped' },
			{ key: 'errors',     label: 'Errors',           cls: 'errors' },
		];
		let html = '<h2 style="margin-top:0;font-size:16px;margin-bottom:16px;">Import Results</h2>'
		         + '<div class="svpi-stats">';
		statMap.forEach( function ( s ) {
			html += '<div class="svpi-stat svpi-stat--' + s.cls + '">'
			      + '<span class="svpi-stat__num">' + ( totals[ s.key ] || 0 ) + '</span>'
			      + '<span class="svpi-stat__label">' + s.label + '</span>'
			      + '</div>';
		} );
		html += '</div>';
		resultsWrap.innerHTML     = html;
		resultsWrap.style.display = 'block';
		resultsWrap.scrollIntoView( { behavior: 'smooth', block: 'nearest' } );
	}

	form.addEventListener( 'submit', async function ( e ) {
		e.preventDefault();

		// Reset UI
		progLog.innerHTML = '';
		progBar.style.width = '0%';
		progBar.classList.remove( 'svpi-progress-bar--error', 'svpi-progress-bar--done', 'svpi-progress-bar--warn' );
		progWrap.style.display = 'block';
		if ( resultsWrap ) resultsWrap.style.display = 'none';
		if ( swatchNote )  swatchNote.style.display  = 'none';
		submitBtn.disabled = true;
		setProgress( 2, 'Uploading and parsing JSON…' );

		const options = {
			skipExisting:   !! ( form.querySelector( '[name="skip_existing"]' )   || {} ).checked,
			downloadImages: !! ( form.querySelector( '[name="download_images"]' ) || {} ).checked,
		};

		const totals = { created: 0, updated: 0, skipped: 0, errors: 0, variations: 0, images: 0 };

		// ── Step 1: Send file to init endpoint ─────────────────────────────────
		const initData = new FormData( form );
		initData.append( 'action', 'svpi_init_import' );

		let initJson;
		try {
			const r = await fetch( svpiAdmin.ajaxUrl, {
				method:      'POST',
				body:        initData,
				credentials: 'same-origin',
			} );
			initJson = await r.json();
		} catch ( err ) {
			showError( 'Network error during upload: ' + err.message );
			return;
		}

		if ( ! initJson.success ) {
			showError( initJson.data || 'Initialisation failed.' );
			return;
		}

		const { import_key, total, nonce } = initJson.data;
		setProgress( 5, 'Parsed ' + total + ' product' + ( total !== 1 ? 's' : '' ) + '. Starting import…' );

		// ── Step 2: Import one product at a time ───────────────────────────────
		for ( let i = 0; i < total; i++ ) {
			const pct = Math.round( 5 + ( ( ( i + 1 ) / total ) * 90 ) );
			setProgress( pct, 'Importing product ' + ( i + 1 ) + ' of ' + total + '…' );

			let batchJson;
			try {
				const body = new URLSearchParams( {
					action:          'svpi_import_batch',
					_wpnonce:        nonce,
					import_key:      import_key,
					index:           i,
					skip_existing:   options.skipExisting   ? '1' : '',
					download_images: options.downloadImages ? '1' : '',
				} );
				const r = await fetch( svpiAdmin.ajaxUrl, {
					method:      'POST',
					body:        body,
					credentials: 'same-origin',
					headers:     { 'Content-Type': 'application/x-www-form-urlencoded' },
				} );
				batchJson = await r.json();
			} catch ( err ) {
				showError( 'Network error on product ' + ( i + 1 ) + ': ' + err.message );
				return;
			}

			if ( ! batchJson.success ) {
				showError( ( batchJson.data || 'Batch error' ) + ' (product ' + ( i + 1 ) + ')' );
				return;
			}

			const { stats, log } = batchJson.data;
			totals.created    += stats.created    || 0;
			totals.updated    += stats.updated    || 0;
			totals.skipped    += stats.skipped    || 0;
			totals.errors     += stats.errors     || 0;
			totals.variations += stats.variations || 0;
			totals.images     += stats.images     || 0;

			if ( log && log.length ) appendLog( log );
		}

		// ── Done ───────────────────────────────────────────────────────────────
		const doneLabel = totals.created + ' created, '
		                + totals.updated + ' updated, '
		                + totals.skipped + ' skipped, '
		                + totals.errors  + ' errors.';
		setProgress( 100, '✅ Import complete — ' + doneLabel );
		progBar.classList.add( 'svpi-progress-bar--done' );
		if ( totals.errors > 0 ) progBar.classList.add( 'svpi-progress-bar--warn' );

		renderResults( totals );
		submitBtn.disabled = false;

		if ( ( totals.created > 0 || totals.updated > 0 ) && swatchNote ) {
			swatchNote.style.display = 'block';
		}
	} );
} )();
