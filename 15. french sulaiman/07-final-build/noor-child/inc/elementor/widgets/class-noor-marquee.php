<?php
/**
 * Announcement marquee (ticker) widget — matches index.html top bar.
 *
 * @package Noor_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Noor_Widget_Marquee extends \Elementor\Widget_Base {

	public function get_name() {
		return 'noor_marquee';
	}

	public function get_title() {
		return __( 'Noor — Bandeau défilant', 'noor' );
	}

	public function get_icon() {
		return 'eicon-slider-push';
	}

	public function get_categories() {
		return array( 'noor-festivities' );
	}

	public function get_keywords() {
		return array( 'noor', 'marquee', 'ticker', 'announcement', 'bandeau' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_items',
			array(
				'label' => __( 'Messages', 'noor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'icon',
			array(
				'label'   => __( 'Emoji / icône', 'noor' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '🚚',
			)
		);
		$repeater->add_control(
			'text',
			array(
				'label'   => __( 'Texte', 'noor' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Livraison gratuite à La Réunion dès 50€', 'noor' ),
			)
		);

		$this->add_control(
			'items',
			array(
				'label'       => __( 'Messages', 'noor' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ text }}}',
				'default'     => array(
					array( 'icon' => '🚚', 'text' => __( 'Livraison gratuite à La Réunion dès 50€', 'noor' ) ),
					array( 'icon' => '✨', 'text' => __( 'Livraison France métropolitaine disponible', 'noor' ) ),
					array( 'icon' => '⭐', 'text' => __( '500+ célébrations illuminées', 'noor' ) ),
					array( 'icon' => '🎁', 'text' => __( '-25% sur les kits Eid cette semaine', 'noor' ) ),
				),
			)
		);

		$this->add_control(
			'speed',
			array(
				'label'   => __( 'Vitesse (secondes par boucle)', 'noor' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 32,
				'min'     => 5,
				'max'     => 120,
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			array(
				'label' => __( 'Style', 'noor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'bg_color',
			array(
				'label'     => __( 'Fond', 'noor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#7A3512',
				'selectors' => array( '{{WRAPPER}} .nfw-marquee' => 'background: {{VALUE}};' ),
			)
		);

		$this->add_control(
			'text_color',
			array(
				'label'     => __( 'Texte', 'noor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#EDE5DE',
				'selectors' => array( '{{WRAPPER}} .nfw-marquee__item' => 'color: {{VALUE}};' ),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$items    = $settings['items'];
		$speed    = max( 5, absint( $settings['speed'] ) );
		if ( empty( $items ) ) {
			return;
		}
		?>
		<div class="nfw-marquee">
			<div class="nfw-marquee__track" style="animation-duration: <?php echo esc_attr( $speed ); ?>s;">
				<?php for ( $g = 0; $g < 3; $g++ ) : // 3 groups → seamless loop. ?>
					<span class="nfw-marquee__group">
						<?php foreach ( $items as $item ) : ?>
							<span class="nfw-marquee__item"><span class="nfw-ico"><?php echo esc_html( $item['icon'] ); ?></span> <?php echo esc_html( $item['text'] ); ?></span>
						<?php endforeach; ?>
					</span>
				<?php endfor; ?>
			</div>
		</div>
		<?php
	}
}
