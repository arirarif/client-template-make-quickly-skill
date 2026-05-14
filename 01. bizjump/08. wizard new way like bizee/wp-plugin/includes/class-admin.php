<?php
/**
 * BizJump Wizard — Admin settings + submissions log.
 *
 * Adds a top-level "BizJump Wizard" menu in wp-admin with:
 *   - Submissions list (stored under wp_options key 'bjw_submissions')
 *   - Quick state-fee override (per-state overrides written to 'bjw_fee_overrides')
 *
 * @package BizJump_Wizard
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'BJW_Admin' ) ) :
class BJW_Admin {

    public static function register(): void {
        if ( ! is_admin() ) return;
        add_action( 'admin_menu', [ __CLASS__, 'add_menu' ] );
    }

    public static function add_menu(): void {
        $cap = 'manage_options';
        add_menu_page(
            __( 'BizJump Wizard', 'bizjump-wizard' ),
            __( 'BizJump Wizard', 'bizjump-wizard' ),
            $cap,
            'bizjump-wizard',
            [ __CLASS__, 'render_submissions' ],
            'dashicons-clipboard',
            58
        );
        add_submenu_page(
            'bizjump-wizard',
            __( 'Submissions', 'bizjump-wizard' ),
            __( 'Submissions', 'bizjump-wizard' ),
            $cap,
            'bizjump-wizard',
            [ __CLASS__, 'render_submissions' ]
        );
        add_submenu_page(
            'bizjump-wizard',
            __( 'State Fee Overrides', 'bizjump-wizard' ),
            __( 'State Fee Overrides', 'bizjump-wizard' ),
            $cap,
            'bizjump-wizard-fees',
            [ __CLASS__, 'render_fee_overrides' ]
        );
    }

    public static function render_submissions(): void {
        $log = (array) get_option( 'bjw_submissions', [] );
        $log = array_reverse( $log, true );
        ?>
        <div class="wrap">
          <h1><?php esc_html_e( 'BizJump Wizard — Submissions', 'bizjump-wizard' ); ?></h1>
          <p><?php esc_html_e( 'Most recent 200 wizard submissions. To download a full snapshot of one entry, click the row.', 'bizjump-wizard' ); ?></p>

          <?php if ( empty( $log ) ): ?>
            <p><em><?php esc_html_e( 'No submissions yet.', 'bizjump-wizard' ); ?></em></p>
          <?php else: ?>
            <table class="wp-list-table widefat fixed striped">
              <thead>
                <tr>
                  <th><?php esc_html_e( 'ID', 'bizjump-wizard' ); ?></th>
                  <th><?php esc_html_e( 'Created', 'bizjump-wizard' ); ?></th>
                  <th><?php esc_html_e( 'Name', 'bizjump-wizard' ); ?></th>
                  <th><?php esc_html_e( 'Email', 'bizjump-wizard' ); ?></th>
                  <th><?php esc_html_e( 'Business', 'bizjump-wizard' ); ?></th>
                  <th><?php esc_html_e( 'Entity', 'bizjump-wizard' ); ?></th>
                  <th><?php esc_html_e( 'State', 'bizjump-wizard' ); ?></th>
                  <th><?php esc_html_e( 'Plan', 'bizjump-wizard' ); ?></th>
                  <th><?php esc_html_e( 'State Fee', 'bizjump-wizard' ); ?></th>
                </tr>
              </thead>
              <tbody>
              <?php foreach ( $log as $row ): ?>
                <tr>
                  <td><code><?php echo esc_html( $row['id'] ?? '' ); ?></code></td>
                  <td><?php echo esc_html( $row['created']   ?? '' ); ?></td>
                  <td><?php echo esc_html( $row['name']      ?? '' ); ?></td>
                  <td><?php echo esc_html( $row['email']     ?? '' ); ?></td>
                  <td><?php echo esc_html( ( $row['biz_name'] ?? '' ) . ' ' . ( $row['designator'] ?? '' ) ); ?></td>
                  <td><?php echo esc_html( $row['entity']    ?? '' ); ?></td>
                  <td><?php echo esc_html( $row['state']     ?? '' ); ?></td>
                  <td><?php echo esc_html( $row['plan']      ?? '' ); ?></td>
                  <td>$<?php echo esc_html( number_format( (float) ( $row['state_fee'] ?? 0 ), 2 ) ); ?></td>
                </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
          <?php endif; ?>
        </div>
        <?php
    }

    public static function render_fee_overrides(): void {
        // Handle save
        if ( isset( $_POST['bjw_fee_save'] ) && check_admin_referer( 'bjw_fee_overrides' ) ) {
            $overrides = [];
            $posted = (array) ( $_POST['fee'] ?? [] );
            foreach ( $posted as $state_name => $row ) {
                $clean = [];
                foreach ( [ 'llc', 'corp', 'nonprofit', 'expedited' ] as $k ) {
                    if ( isset( $row[ $k ] ) && $row[ $k ] !== '' ) $clean[ $k ] = (float) $row[ $k ];
                }
                if ( ! empty( $clean ) ) $overrides[ sanitize_text_field( $state_name ) ] = $clean;
            }
            update_option( 'bjw_fee_overrides', $overrides );
            echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'State fee overrides saved.', 'bizjump-wizard' ) . '</p></div>';
        }

        $defaults  = BJW_State_Fees::all_fees();
        $overrides = (array) get_option( 'bjw_fee_overrides', [] );
        ?>
        <div class="wrap">
          <h1><?php esc_html_e( 'State Fee Overrides', 'bizjump-wizard' ); ?></h1>
          <p><?php esc_html_e( 'Override the default per-state filing fees from the xlsx. Leave a cell blank to use the default.', 'bizjump-wizard' ); ?></p>

          <form method="post">
            <?php wp_nonce_field( 'bjw_fee_overrides' ); ?>
            <table class="wp-list-table widefat fixed striped">
              <thead><tr><th>State</th><th>LLC</th><th>Corp</th><th>Nonprofit</th><th>Expedited</th></tr></thead>
              <tbody>
              <?php foreach ( $defaults as $state_name => $row ): ?>
                <?php $ov = $overrides[ $state_name ] ?? []; ?>
                <tr>
                  <td><strong><?php echo esc_html( $state_name ); ?></strong></td>
                  <?php foreach ( [ 'llc', 'corp', 'nonprofit', 'expedited' ] as $col ): ?>
                    <td>
                      <input type="number" step="0.01" min="0"
                             name="fee[<?php echo esc_attr( $state_name ); ?>][<?php echo esc_attr( $col ); ?>]"
                             value="<?php echo esc_attr( $ov[ $col ] ?? '' ); ?>"
                             placeholder="<?php echo esc_attr( $row[ $col ] ); ?>"
                             style="width:90px"/>
                    </td>
                  <?php endforeach; ?>
                </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
            <p><button type="submit" name="bjw_fee_save" class="button button-primary"><?php esc_html_e( 'Save Overrides', 'bizjump-wizard' ); ?></button></p>
          </form>
        </div>
        <?php
    }
}
endif;
