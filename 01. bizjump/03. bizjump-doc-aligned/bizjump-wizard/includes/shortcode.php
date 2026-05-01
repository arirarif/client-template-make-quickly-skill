<?php
/**
 * BizJump Wizard — Shortcode Renderer
 *
 * Outputs the full 6-step wizard HTML.
 * All steps are in the DOM; JS controls which step is visible.
 *
 * Usage: [bizjump_wizard]
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function bjw_render_wizard(): string {
    ob_start();
    ?>
    <div id="bj-wizard" class="bj-wizard-wrap" role="main">

        <!-- ── Progress Bar ──────────────────────────────────────────────── -->
        <div class="bj-progress" aria-label="Formation progress">
            <?php
            $steps = [
                1 => 'Entity',
                2 => 'State',
                3 => 'Plan',
                4 => 'Add-Ons',
                5 => 'Details',
                6 => 'Review',
            ];
            foreach ( $steps as $num => $label ) :
            ?>
            <div class="bj-progress-step <?php echo 1 === $num ? 'is-active' : ''; ?>" data-step="<?php echo esc_attr( $num ); ?>">
                <div class="bj-progress-dot"><span><?php echo esc_html( $num ); ?></span></div>
                <div class="bj-progress-label"><?php echo esc_html( $label ); ?></div>
            </div>
            <?php if ( $num < count( $steps ) ) : ?>
            <div class="bj-progress-line"></div>
            <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <!-- ── Wizard Layout ─────────────────────────────────────────────── -->
        <div class="bj-wizard-layout">

            <!-- Steps container -->
            <div class="bj-steps-container">

                <!-- ── Step 1: Entity Type ─────────────────────────────── -->
                <div class="bj-step" data-step="1">
                    <h2 class="bj-step-heading">What type of business are you forming?</h2>
                    <p class="bj-step-sub">Choose the structure that best fits your goals.</p>

                    <div class="bj-entity-grid">
                        <label class="bj-entity-card" data-entity="llc">
                            <input type="radio" name="bj_entity" value="llc" hidden>
                            <div class="bj-entity-icon">🏢</div>
                            <div class="bj-entity-name">LLC</div>
                            <div class="bj-entity-desc">Limited Liability Company — flexible, pass-through taxes, personal liability protection.</div>
                            <div class="bj-entity-popular">Most Popular</div>
                        </label>

                        <label class="bj-entity-card" data-entity="c_corp">
                            <input type="radio" name="bj_entity" value="c_corp" hidden>
                            <div class="bj-entity-icon">📈</div>
                            <div class="bj-entity-name">C-Corporation</div>
                            <div class="bj-entity-desc">Best for venture-backed startups seeking investors and issuing stock.</div>
                            <div class="bj-entity-popular"></div>
                        </label>

                        <label class="bj-entity-card" data-entity="s_corp">
                            <input type="radio" name="bj_entity" value="s_corp" hidden>
                            <div class="bj-entity-icon">💼</div>
                            <div class="bj-entity-name">S-Corporation</div>
                            <div class="bj-entity-desc">Pass-through taxation with corporate structure. Up to 100 shareholders.</div>
                            <div class="bj-entity-popular"></div>
                        </label>

                        <label class="bj-entity-card" data-entity="non_profit">
                            <input type="radio" name="bj_entity" value="non_profit" hidden>
                            <div class="bj-entity-icon">❤️</div>
                            <div class="bj-entity-name">Non-Profit</div>
                            <div class="bj-entity-desc">501(c)(3) eligible. Mission-driven organization with tax-exempt potential.</div>
                            <div class="bj-entity-popular"></div>
                        </label>
                    </div>

                    <div class="bj-step-footer">
                        <button type="button" class="bj-btn bj-btn-next" data-next="2" disabled>Continue →</button>
                    </div>
                </div>

                <!-- ── Step 2: State Selection ─────────────────────────── -->
                <div class="bj-step" data-step="2" hidden>
                    <h2 class="bj-step-heading">Where are you forming your business?</h2>
                    <p class="bj-step-sub">Select your state of formation. Filing fees vary by state.</p>

                    <div class="bj-state-selector-wrap">
                        <select id="bj-state-select" class="bj-state-select" aria-label="Select state">
                            <option value="">— Select a State —</option>
                            <?php foreach ( bjw_get_state_fees() as $s ) : ?>
                            <option value="<?php echo esc_attr( $s['slug'] ); ?>"
                                    data-fee="<?php echo esc_attr( $s['fee'] ); ?>">
                                <?php echo esc_html( $s['name'] ) . ' — $' . number_format( $s['fee'], 2 ); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>

                        <div class="bj-state-fee-display" id="bj-state-fee-display" hidden>
                            <div class="bj-fee-badge">
                                <span class="bj-fee-label">State Filing Fee</span>
                                <span class="bj-fee-amount" id="bj-state-fee-amount">$0.00</span>
                            </div>
                            <p class="bj-fee-note">This is a government fee paid directly to the state — not BizJump's service fee.</p>
                        </div>
                    </div>

                    <div class="bj-state-popular">
                        <p class="bj-popular-label">Popular states:</p>
                        <div class="bj-popular-btns">
                            <button type="button" class="bj-state-quick" data-slug="DE" data-fee="90.00">Delaware</button>
                            <button type="button" class="bj-state-quick" data-slug="WY" data-fee="100.00">Wyoming</button>
                            <button type="button" class="bj-state-quick" data-slug="FL" data-fee="125.00">Florida</button>
                            <button type="button" class="bj-state-quick" data-slug="TX" data-fee="300.00">Texas</button>
                            <button type="button" class="bj-state-quick" data-slug="CA" data-fee="70.00">California</button>
                            <button type="button" class="bj-state-quick" data-slug="NY" data-fee="200.00">New York</button>
                        </div>
                    </div>

                    <div class="bj-step-footer">
                        <button type="button" class="bj-btn bj-btn-back" data-back="1">← Back</button>
                        <button type="button" class="bj-btn bj-btn-next" data-next="3" disabled>Continue →</button>
                    </div>
                </div>

                <!-- ── Step 3: Plan Selection ───────────────────────────── -->
                <div class="bj-step" data-step="3" hidden>
                    <h2 class="bj-step-heading">Choose your formation package</h2>
                    <p class="bj-step-sub">All prices are one-time service fees. State filing fee is added at checkout.</p>

                    <div class="bj-plan-grid" id="bj-plan-grid">
                        <?php foreach ( bjw_get_plans() as $plan ) :
                            $is_popular = 'Most Popular' === ( $plan['badge'] ?? '' );
                        ?>
                        <div class="bj-plan-card <?php echo $is_popular ? 'is-popular' : ''; ?>" data-plan="<?php echo esc_attr( $plan['key'] ); ?>">
                            <?php if ( ! empty( $plan['badge'] ) ) : ?>
                            <div class="bj-plan-badge"><?php echo esc_html( $plan['badge'] ); ?></div>
                            <?php endif; ?>
                            <div class="bj-plan-name"><?php echo esc_html( $plan['label'] ); ?></div>
                            <div class="bj-plan-price">
                                <span class="bj-price-amount">$<?php echo esc_html( number_format( $plan['price'], 0 ) ); ?></span>
                                <?php if ( ! empty( $plan['subscription_price'] ) ) : ?>
                                <span class="bj-price-sub">+ $<?php echo esc_html( $plan['subscription_price'] ); ?>/mo</span>
                                <?php endif; ?>
                                <span class="bj-price-note">+ state fees</span>
                            </div>
                            <div class="bj-plan-desc"><?php echo esc_html( $plan['description'] ); ?></div>
                            <ul class="bj-plan-features">
                                <?php foreach ( $plan['features'] as $feature ) : ?>
                                <li class="bj-feature-yes"><?php echo esc_html( $feature ); ?></li>
                                <?php endforeach; ?>
                                <?php foreach ( $plan['not_included'] as $missing ) : ?>
                                <li class="bj-feature-no"><?php echo esc_html( $missing ); ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="bj-btn bj-btn-select-plan" data-plan="<?php echo esc_attr( $plan['key'] ); ?>">
                                <?php echo $is_popular ? 'Get Started' : 'Select'; ?>
                            </button>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="bj-step-footer bj-footer-back-only">
                        <button type="button" class="bj-btn bj-btn-back" data-back="2">← Back</button>
                    </div>
                </div>

                <!-- ── Step 4: Add-Ons ─────────────────────────────────── -->
                <div class="bj-step" data-step="4" hidden>
                    <h2 class="bj-step-heading">Customize your formation</h2>
                    <p class="bj-step-sub">Add services to your order. Some may already be included in your plan.</p>

                    <div class="bj-addons-list" id="bj-addons-list">
                        <?php foreach ( bjw_get_addons() as $addon ) : ?>
                        <div class="bj-addon-row"
                             data-addon-key="<?php echo esc_attr( $addon['key'] ); ?>"
                             data-price="<?php echo esc_attr( $addon['price'] ); ?>"
                             data-subscription="<?php echo $addon['subscription'] ? 'true' : 'false'; ?>"
                             data-entity-types="<?php echo esc_attr( wp_json_encode( $addon['entity_types'] ) ); ?>"
                             data-hide-plans="<?php echo esc_attr( wp_json_encode( $addon['hide_for_plans'] ) ); ?>"
                             data-auto-plans="<?php echo esc_attr( wp_json_encode( $addon['auto_select'] ) ); ?>">
                            <div class="bj-addon-toggle">
                                <input type="checkbox"
                                       id="addon_<?php echo esc_attr( $addon['key'] ); ?>"
                                       name="bj_addons[]"
                                       value="<?php echo esc_attr( $addon['key'] ); ?>"
                                       class="bj-addon-check">
                                <label for="addon_<?php echo esc_attr( $addon['key'] ); ?>" class="bj-addon-check-label"></label>
                            </div>
                            <div class="bj-addon-info">
                                <div class="bj-addon-name"><?php echo esc_html( $addon['label'] ); ?></div>
                                <div class="bj-addon-desc"><?php echo esc_html( $addon['description'] ); ?></div>
                            </div>
                            <div class="bj-addon-price">
                                <?php if ( $addon['price'] > 0 ) : ?>
                                +$<?php echo esc_html( number_format( $addon['price'], 0 ) ); ?>
                                <?php elseif ( ! empty( $addon['subscription_price'] ) ) : ?>
                                Free + $<?php echo esc_html( $addon['subscription_price'] ); ?>/mo
                                <?php else : ?>
                                Included
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="bj-step-footer">
                        <button type="button" class="bj-btn bj-btn-back" data-back="3">← Back</button>
                        <button type="button" class="bj-btn bj-btn-next" data-next="5">Continue →</button>
                    </div>
                </div>

                <!-- ── Step 5: Business Details ─────────────────────────── -->
                <div class="bj-step" data-step="5" hidden>
                    <h2 class="bj-step-heading">Tell us about your business</h2>
                    <p class="bj-step-sub">We need these details to file your formation documents.</p>

                    <form id="bj-details-form" class="bj-details-form" novalidate>
                        <div class="bj-form-row">
                            <div class="bj-field">
                                <label for="bj-business-name">Desired Business Name <span aria-hidden="true">*</span></label>
                                <input type="text" id="bj-business-name" name="business_name"
                                       placeholder="e.g. Acme Holdings" required autocomplete="organization">
                                <span class="bj-field-hint">We'll check name availability in your state.</span>
                            </div>
                            <div class="bj-field bj-field-sm">
                                <label for="bj-designator">Designator <span aria-hidden="true">*</span></label>
                                <select id="bj-designator" name="designator" required>
                                    <option value="">Select…</option>
                                    <option value="LLC">LLC</option>
                                    <option value="L.L.C.">L.L.C.</option>
                                    <option value="Inc.">Inc.</option>
                                    <option value="Corp.">Corp.</option>
                                    <option value="Incorporated">Incorporated</option>
                                </select>
                            </div>
                        </div>

                        <div class="bj-field">
                            <label for="bj-business-address">Business / Mailing Address <span aria-hidden="true">*</span></label>
                            <textarea id="bj-business-address" name="business_address" rows="3"
                                      placeholder="Street, City, State, ZIP" required></textarea>
                        </div>

                        <div class="bj-form-row">
                            <div class="bj-field">
                                <label for="bj-contact-person">Contact Person (Organizer) <span aria-hidden="true">*</span></label>
                                <input type="text" id="bj-contact-person" name="contact_person"
                                       placeholder="Full Name" required autocomplete="name">
                            </div>
                            <div class="bj-field">
                                <label for="bj-contact-email">Email Address <span aria-hidden="true">*</span></label>
                                <input type="email" id="bj-contact-email" name="contact_email"
                                       placeholder="you@example.com" required autocomplete="email">
                            </div>
                        </div>

                        <div class="bj-form-row">
                            <div class="bj-field">
                                <label for="bj-contact-phone">Phone Number <span aria-hidden="true">*</span></label>
                                <input type="tel" id="bj-contact-phone" name="contact_phone"
                                       placeholder="+1 (555) 000-0000" required autocomplete="tel">
                            </div>
                        </div>

                        <div class="bj-field bj-field-checkbox">
                            <input type="checkbox" id="bj-sms-consent" name="sms_consent" value="1">
                            <label for="bj-sms-consent">
                                I consent to receive SMS text message updates about my formation order.
                                <span class="bj-sms-note">Message &amp; data rates may apply. Reply STOP to opt out.</span>
                            </label>
                        </div>
                    </form>

                    <div class="bj-step-footer">
                        <button type="button" class="bj-btn bj-btn-back" data-back="4">← Back</button>
                        <button type="button" class="bj-btn bj-btn-next" id="bj-details-next" data-next="6">Continue →</button>
                    </div>
                </div>

                <!-- ── Step 6: Review & Checkout ────────────────────────── -->
                <div class="bj-step" data-step="6" hidden>
                    <h2 class="bj-step-heading">Review your order</h2>
                    <p class="bj-step-sub">Everything looks good? Proceed to secure checkout.</p>

                    <div class="bj-review-wrap" id="bj-review-wrap">
                        <!-- Populated by JS -->
                    </div>

                    <div class="bj-review-legal">
                        <p>By clicking "Proceed to Checkout" you agree to our
                           <a href="/terms-of-service/" target="_blank">Terms of Service</a> and
                           <a href="/privacy-policy/" target="_blank">Privacy Policy</a>.
                        </p>
                    </div>

                    <div class="bj-step-footer">
                        <button type="button" class="bj-btn bj-btn-back" data-back="5">← Back</button>
                        <button type="button" class="bj-btn bj-btn-checkout" id="bj-checkout-btn">
                            🔒 Proceed to Checkout
                        </button>
                    </div>

                    <div class="bj-checkout-loader" id="bj-checkout-loader" hidden>
                        <div class="bj-spinner"></div>
                        <p>Preparing your order…</p>
                    </div>

                    <div class="bj-checkout-error" id="bj-checkout-error" hidden role="alert">
                        <p id="bj-checkout-error-msg"></p>
                    </div>
                </div>

            </div><!-- /.bj-steps-container -->

            <!-- ── Sticky Order Summary Sidebar ──────────────────────── -->
            <aside class="bj-sidebar" id="bj-sidebar" aria-label="Order summary">
                <div class="bj-sidebar-inner">
                    <h3 class="bj-sidebar-title">Your Order</h3>

                    <div class="bj-sidebar-entity" id="bj-summary-entity">
                        <span class="bj-summary-label">Entity</span>
                        <span class="bj-summary-value" id="bj-sum-entity">—</span>
                    </div>

                    <div class="bj-sidebar-entity" id="bj-summary-state">
                        <span class="bj-summary-label">State</span>
                        <span class="bj-summary-value" id="bj-sum-state">—</span>
                    </div>

                    <div class="bj-sidebar-entity" id="bj-summary-plan">
                        <span class="bj-summary-label">Plan</span>
                        <span class="bj-summary-value" id="bj-sum-plan">—</span>
                    </div>

                    <div class="bj-sidebar-divider"></div>

                    <ul class="bj-summary-lines" id="bj-summary-lines">
                        <!-- Populated by JS as user progresses -->
                    </ul>

                    <div class="bj-sidebar-divider"></div>

                    <div class="bj-summary-total">
                        <span>Estimated Total</span>
                        <span id="bj-sum-total">$0.00</span>
                    </div>

                    <p class="bj-summary-note">Final total includes state filing fee.</p>

                    <div class="bj-trust-badges">
                        <div class="bj-trust-badge">🔒 SSL Secure</div>
                        <div class="bj-trust-badge">✅ Money-Back Guarantee</div>
                    </div>
                </div>
            </aside>

        </div><!-- /.bj-wizard-layout -->
    </div><!-- /#bj-wizard -->
    <?php
    return ob_get_clean();
}
