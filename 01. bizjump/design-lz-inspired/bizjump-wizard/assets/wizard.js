/**
 * BizJump Wizard — Frontend State Machine
 *
 * Manages the 6-step wizard state, conditional add-on logic,
 * price calculation, review builder, and AJAX cart submission.
 *
 * Depends on: BJW global (set by wp_localize_script in bizjump-wizard.php)
 *   BJW.ajaxUrl   — wp-admin/admin-ajax.php
 *   BJW.nonce     — security nonce
 *   BJW.stateFees — array of { slug, name, fee }
 *   BJW.plans     — array of plan objects
 *   BJW.addons    — array of addon objects
 *   BJW.currency  — currency symbol (e.g. '$')
 */

( function () {
    'use strict';

    /* ── State ──────────────────────────────────────────────── */
    const state = {
        step:     1,
        entity:   null,   // 'llc' | 'c_corp' | 's_corp' | 'non_profit'
        state:    null,   // e.g. 'TX'
        stateFee: 0,
        plan:     null,   // e.g. 'plan_premium'
        planPrice:0,
        addons:   [],     // array of addon keys selected
        details:  {},     // business details form values
    };

    /* ── DOM Refs ───────────────────────────────────────────── */
    const wizard       = document.getElementById( 'bj-wizard' );
    if ( ! wizard ) return; // shortcode not on this page

    const $ = ( sel, ctx = wizard ) => ctx.querySelector( sel );
    const $$ = ( sel, ctx = wizard ) => Array.from( ctx.querySelectorAll( sel ) );

    /* ── Helpers ────────────────────────────────────────────── */
    function fmt( amount ) {
        return '$' + Number( amount ).toFixed( 2 ).replace( /\B(?=(\d{3})+(?!\d))/g, ',' );
    }

    function showStep( num ) {
        $$( '.bj-step' ).forEach( el => {
            el.hidden = parseInt( el.dataset.step, 10 ) !== num;
        } );

        $$( '.bj-progress-step' ).forEach( el => {
            const n = parseInt( el.dataset.step, 10 );
            el.classList.toggle( 'is-active', n === num );
            el.classList.toggle( 'is-done',   n < num );
        } );

        state.step = num;
        wizard.scrollIntoView( { behavior: 'smooth', block: 'start' } );
    }

    /* ── Sidebar updater ────────────────────────────────────── */
    function updateSidebar() {
        const planData = BJW.plans.find( p => p.key === state.plan );

        $( '#bj-sum-entity' ).textContent = state.entity
            ? state.entity.replace( '_', '-' ).toUpperCase()
            : '—';

        $( '#bj-sum-state' ).textContent = state.state || '—';

        $( '#bj-sum-plan' ).textContent = planData
            ? planData.label
            : '—';

        // Build line items
        const linesEl = $( '#bj-summary-lines' );
        linesEl.innerHTML = '';

        if ( planData ) {
            const li = document.createElement( 'li' );
            li.innerHTML = `<span>${ planData.label }</span><span class="bj-line-price">${ fmt( state.planPrice ) }</span>`;
            linesEl.appendChild( li );
        }

        if ( state.stateFee > 0 ) {
            const li = document.createElement( 'li' );
            li.innerHTML = `<span>State Filing Fee</span><span class="bj-line-price">${ fmt( state.stateFee ) }</span>`;
            linesEl.appendChild( li );
        }

        state.addons.forEach( key => {
            const addon = BJW.addons.find( a => a.key === key );
            if ( ! addon ) return;
            const price = addon.subscription_price && ! addon.price
                ? `${ fmt( 0 ) } + ${ fmt( addon.subscription_price ) }/mo`
                : fmt( addon.price );
            const li = document.createElement( 'li' );
            li.innerHTML = `<span>${ addon.label }</span><span class="bj-line-price">${ price }</span>`;
            linesEl.appendChild( li );
        } );

        // Total (one-time items only for estimate)
        const addonTotal = state.addons.reduce( ( sum, key ) => {
            const a = BJW.addons.find( x => x.key === key );
            return a ? sum + parseFloat( a.price || 0 ) : sum;
        }, 0 );

        const total = state.planPrice + state.stateFee + addonTotal;
        $( '#bj-sum-total' ).textContent = fmt( total );
    }

    /* ═══════════════════════════════════════════════════════════
       STEP 1 — Entity Type
    ═══════════════════════════════════════════════════════════ */
    $$( '.bj-entity-card' ).forEach( card => {
        card.addEventListener( 'click', () => {
            $$( '.bj-entity-card' ).forEach( c => c.classList.remove( 'is-selected' ) );
            card.classList.add( 'is-selected' );
            card.querySelector( 'input[type="radio"]' ).checked = true;

            state.entity = card.dataset.entity;

            // Enable "Continue" button
            const nextBtn = $( '[data-step="1"] .bj-btn-next' );
            if ( nextBtn ) nextBtn.disabled = false;

            updateSidebar();
            applyAddonVisibility(); // pre-filter for when user reaches step 4
        } );
    } );

    /* ═══════════════════════════════════════════════════════════
       STEP 2 — State Selection
    ═══════════════════════════════════════════════════════════ */
    const stateSelect   = $( '#bj-state-select' );
    const stateFeeDisplay = $( '#bj-state-fee-display' );
    const stateFeeAmount  = $( '#bj-state-fee-amount' );

    function handleStateSelect( slug, fee ) {
        state.state   = slug;
        state.stateFee = parseFloat( fee );

        // Update UI
        $$( '.bj-state-quick' ).forEach( b => b.classList.toggle( 'is-active', b.dataset.slug === slug ) );
        stateSelect.value = slug;
        stateFeeAmount.textContent = fmt( fee );
        stateFeeDisplay.hidden = false;

        // Enable next
        const nextBtn = $( '[data-step="2"] .bj-btn-next' );
        if ( nextBtn ) nextBtn.disabled = false;

        updateSidebar();
    }

    stateSelect.addEventListener( 'change', () => {
        const opt = stateSelect.options[ stateSelect.selectedIndex ];
        if ( opt && opt.value ) {
            handleStateSelect( opt.value, opt.dataset.fee );
        } else {
            state.state = null;
            state.stateFee = 0;
            stateFeeDisplay.hidden = true;
            const nextBtn = $( '[data-step="2"] .bj-btn-next' );
            if ( nextBtn ) nextBtn.disabled = true;
            updateSidebar();
        }
    } );

    $$( '.bj-state-quick' ).forEach( btn => {
        btn.addEventListener( 'click', () => handleStateSelect( btn.dataset.slug, btn.dataset.fee ) );
    } );

    /* ═══════════════════════════════════════════════════════════
       STEP 3 — Plan Selection
    ═══════════════════════════════════════════════════════════ */
    $$( '.bj-btn-select-plan' ).forEach( btn => {
        btn.addEventListener( 'click', () => {
            const planKey = btn.dataset.plan;
            const planData = BJW.plans.find( p => p.key === planKey );
            if ( ! planData ) return;

            state.plan      = planKey;
            state.planPrice = parseFloat( planData.price );

            // Highlight selected card
            $$( '.bj-plan-card' ).forEach( c => c.classList.toggle( 'is-selected', c.dataset.plan === planKey ) );

            applyAddonVisibility();
            updateSidebar();
            showStep( 4 );
        } );
    } );

    /* ═══════════════════════════════════════════════════════════
       STEP 4 — Add-Ons (conditional visibility + auto-select)
    ═══════════════════════════════════════════════════════════ */
    function applyAddonVisibility() {
        if ( ! state.entity || ! state.plan ) return;

        const addonRows = $$( '.bj-addon-row' );
        state.addons = []; // rebuild from scratch

        addonRows.forEach( row => {
            const key        = row.dataset.addonKey;
            const entityTypes = JSON.parse( row.dataset.entityTypes || 'null' );
            const hidePlans   = JSON.parse( row.dataset.hidePlans  || '[]' );
            const autoPlans   = JSON.parse( row.dataset.autoPlans  || '[]' );
            const checkbox    = row.querySelector( '.bj-addon-check' );

            // Hide if entity type doesn't match
            if ( entityTypes !== null && ! entityTypes.includes( state.entity ) ) {
                row.hidden = true;
                checkbox.checked  = false;
                checkbox.disabled = false;
                return;
            }

            row.hidden = false;

            // Auto-select (included in plan) — check + disable
            if ( autoPlans.includes( state.plan ) ) {
                checkbox.checked  = true;
                checkbox.disabled = true;
                row.classList.add( 'is-included' );

                const priceEl = row.querySelector( '.bj-addon-price' );
                if ( priceEl ) priceEl.textContent = 'Included';

                state.addons.push( key );
                return;
            }

            // Hide if already included (plan covers it but don't auto-select)
            if ( hidePlans.includes( state.plan ) ) {
                row.hidden = true;
                checkbox.checked  = false;
                checkbox.disabled = false;
                return;
            }

            // Normal — restore
            row.classList.remove( 'is-included' );
            checkbox.disabled = false;
            if ( checkbox.checked ) {
                state.addons.push( key );
            }
        } );

        updateSidebar();
    }

    // Checkbox change handler
    $$( '.bj-addon-check' ).forEach( chk => {
        chk.addEventListener( 'change', () => {
            const row = chk.closest( '.bj-addon-row' );
            const key = row.dataset.addonKey;

            if ( chk.checked ) {
                if ( ! state.addons.includes( key ) ) state.addons.push( key );
            } else {
                state.addons = state.addons.filter( k => k !== key );
            }

            updateSidebar();
        } );
    } );

    /* ═══════════════════════════════════════════════════════════
       STEP 5 — Business Details Validation
    ═══════════════════════════════════════════════════════════ */
    const detailsNextBtn = $( '#bj-details-next' );

    function validateDetails() {
        const form    = $( '#bj-details-form' );
        const required = $$( '[required]', form );
        let valid = true;

        required.forEach( el => {
            const empty = el.value.trim() === '';
            el.classList.toggle( 'is-invalid', empty );
            if ( empty ) valid = false;
        } );

        // Basic email check
        const emailEl = $( '#bj-contact-email' );
        if ( emailEl && emailEl.value && ! /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test( emailEl.value ) ) {
            emailEl.classList.add( 'is-invalid' );
            valid = false;
        }

        return valid;
    }

    function collectDetails() {
        state.details = {
            business_name:    $( '#bj-business-name' )?.value.trim()   || '',
            designator:       $( '#bj-designator' )?.value             || '',
            business_address: $( '#bj-business-address' )?.value.trim() || '',
            contact_person:   $( '#bj-contact-person' )?.value.trim()  || '',
            contact_email:    $( '#bj-contact-email' )?.value.trim()   || '',
            contact_phone:    $( '#bj-contact-phone' )?.value.trim()   || '',
            sms_consent:      $( '#bj-sms-consent' )?.checked ? 1 : 0,
        };
    }

    if ( detailsNextBtn ) {
        detailsNextBtn.addEventListener( 'click', () => {
            if ( ! validateDetails() ) {
                return; // show inline errors, don't advance
            }
            collectDetails();
            buildReview();
            showStep( 6 );
        } );
    }

    // Clear invalid state on input
    $$( '#bj-details-form input, #bj-details-form select, #bj-details-form textarea' ).forEach( el => {
        el.addEventListener( 'input', () => el.classList.remove( 'is-invalid' ) );
    } );

    /* ═══════════════════════════════════════════════════════════
       STEP 6 — Review Builder
    ═══════════════════════════════════════════════════════════ */
    function buildReview() {
        const wrap    = $( '#bj-review-wrap' );
        const planData = BJW.plans.find( p => p.key === state.plan );
        const stateData = BJW.stateFees
            ? BJW.stateFees.find( s => s.slug === state.state )
            : null;

        const addonTotal = state.addons.reduce( ( sum, key ) => {
            const a = BJW.addons.find( x => x.key === key );
            return a ? sum + parseFloat( a.price || 0 ) : sum;
        }, 0 );

        const grandTotal = state.planPrice + state.stateFee + addonTotal;

        const entityLabel = {
            llc:       'LLC',
            c_corp:    'C-Corporation',
            s_corp:    'S-Corporation',
            non_profit:'Non-Profit',
        }[ state.entity ] || state.entity;

        let addonRows = '';
        state.addons.forEach( key => {
            const a = BJW.addons.find( x => x.key === key );
            if ( ! a ) return;
            const price = a.price > 0 ? fmt( a.price ) : 'Included';
            addonRows += `<div class="bj-review-row">
                <span class="bj-review-row-label">${ a.label }</span>
                <span class="bj-review-row-value">${ price }</span>
            </div>`;
        } );

        wrap.innerHTML = `
        <div class="bj-review-section">
            <div class="bj-review-section-title">Formation</div>
            <div class="bj-review-row">
                <span class="bj-review-row-label">Entity Type</span>
                <span class="bj-review-row-value">${ entityLabel }</span>
            </div>
            <div class="bj-review-row">
                <span class="bj-review-row-label">State</span>
                <span class="bj-review-row-value">${ stateData ? stateData.name : state.state }</span>
            </div>
        </div>

        <div class="bj-review-section">
            <div class="bj-review-section-title">Package</div>
            <div class="bj-review-row">
                <span class="bj-review-row-label">${ planData ? planData.label : state.plan }</span>
                <span class="bj-review-row-value">${ fmt( state.planPrice ) }</span>
            </div>
            <div class="bj-review-row">
                <span class="bj-review-row-label">State Filing Fee (${ stateData ? stateData.name : state.state })</span>
                <span class="bj-review-row-value">${ fmt( state.stateFee ) }</span>
            </div>
        </div>

        ${ addonRows.length ? `
        <div class="bj-review-section">
            <div class="bj-review-section-title">Add-Ons</div>
            ${ addonRows }
        </div>` : '' }

        <div class="bj-review-section">
            <div class="bj-review-section-title">Business Details</div>
            <div class="bj-review-row">
                <span class="bj-review-row-label">Business Name</span>
                <span class="bj-review-row-value">${ state.details.business_name } ${ state.details.designator }</span>
            </div>
            <div class="bj-review-row">
                <span class="bj-review-row-label">Contact</span>
                <span class="bj-review-row-value">${ state.details.contact_person }</span>
            </div>
            <div class="bj-review-row">
                <span class="bj-review-row-label">Email</span>
                <span class="bj-review-row-value">${ state.details.contact_email }</span>
            </div>
        </div>

        <hr class="bj-review-divider">

        <div class="bj-review-total-row">
            <span>Estimated Total</span>
            <span>${ fmt( grandTotal ) }</span>
        </div>
        `;
    }

    /* ═══════════════════════════════════════════════════════════
       AJAX — Submit to WooCommerce Cart
    ═══════════════════════════════════════════════════════════ */
    const checkoutBtn   = $( '#bj-checkout-btn' );
    const checkoutLoader = $( '#bj-checkout-loader' );
    const checkoutError  = $( '#bj-checkout-error' );
    const errorMsg       = $( '#bj-checkout-error-msg' );

    if ( checkoutBtn ) {
        checkoutBtn.addEventListener( 'click', async () => {
            // Show loader
            checkoutBtn.disabled = true;
            checkoutLoader.hidden = false;
            checkoutError.hidden  = true;

            const body = new URLSearchParams( {
                action:           'bj_create_order',
                nonce:            BJW.nonce,
                plan:             state.plan,
                state:            state.state,
                entity:           state.entity,
                business_name:    state.details.business_name    || '',
                designator:       state.details.designator       || '',
                business_address: state.details.business_address || '',
                contact_person:   state.details.contact_person   || '',
                contact_email:    state.details.contact_email    || '',
                contact_phone:    state.details.contact_phone    || '',
                sms_consent:      state.details.sms_consent      || 0,
            } );

            // Append addons[]
            state.addons.forEach( k => body.append( 'addons[]', k ) );

            try {
                const res  = await fetch( BJW.ajaxUrl, {
                    method:  'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body:    body.toString(),
                } );

                const json = await res.json();

                if ( json.success && json.data && json.data.redirect ) {
                    window.location.href = json.data.redirect;
                } else {
                    showError( json.data?.message || 'Something went wrong. Please try again.' );
                }
            } catch ( err ) {
                showError( 'Network error. Please check your connection and try again.' );
            }
        } );
    }

    function showError( msg ) {
        checkoutBtn.disabled     = false;
        checkoutLoader.hidden    = true;
        checkoutError.hidden     = false;
        errorMsg.textContent     = msg;
    }

    /* ═══════════════════════════════════════════════════════════
       Generic Next / Back Navigation
    ═══════════════════════════════════════════════════════════ */
    wizard.addEventListener( 'click', e => {
        const nextBtn = e.target.closest( '.bj-btn-next' );
        const backBtn = e.target.closest( '.bj-btn-back' );

        // Skip — step 5 has its own handler (validation)
        if ( nextBtn && ! nextBtn.disabled && nextBtn.id !== 'bj-details-next' ) {
            const next = parseInt( nextBtn.dataset.next, 10 );
            if ( next ) showStep( next );
        }

        if ( backBtn ) {
            const back = parseInt( backBtn.dataset.back, 10 );
            if ( back ) showStep( back );
        }
    } );

    /* ── Init ───────────────────────────────────────────────── */
    showStep( 1 );
    updateSidebar();

} )();
