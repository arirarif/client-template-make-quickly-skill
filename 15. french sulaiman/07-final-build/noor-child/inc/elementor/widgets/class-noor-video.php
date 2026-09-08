<?php
/**
 * Video section widget — dark espresso band with lazy-loaded embed.
 * Matches the "Nos créations en action" section of the home mockup.
 *
 * @package Noor_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Noor_Widget_Video extends \Elementor\Widget_Base {

	public function get_name() {
		return 'noor_video';
	}

	public function get_title() {
		return __( 'Noor — Section Vidéo', 'noor' );
	}

	public function get_icon() {
		return 'eicon-youtube';
	}

	public function get_categories() {
		return array( 'noor-festivities' );
	}

	public function get_keywords() {
		return array( 'noor', 'video', 'youtube', 'vimeo' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			array(
				'label' => __( 'Contenu', 'noor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'kicker',
			array(
				'label'   => __( 'Kicker', 'noor' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'En vidéo', 'noor' ),
			)
		);
		$this->add_control(
			'title',
			array(
				'label'   => __( 'Titre', 'noor' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Nos créations en action', 'noor' ),
			)
		);
		$this->add_control(
			'subtitle',
			array(
				'label'   => __( 'Sous-titre (vide = masqué)', 'noor' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => '',
			)
		);
		$this->add_control(
			'video_url',
			array(
				'label'       => __( 'URL vidéo (YouTube ou Vimeo)', 'noor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => '',
				'description' => __( 'Ex : https://www.youtube.com/watch?v=XXXX — chargée uniquement au clic (lazy-load).', 'noor' ),
			)
		);
		$this->add_control(
			'poster',
			array(
				'label'       => __( 'Image d’aperçu', 'noor' ),
				'type'        => \Elementor\Controls_Manager::MEDIA,
				'default'     => array( 'url' => get_stylesheet_directory_uri() . '/assets/img/video-poster.jpg' ),
				'description' => __( 'Affichée avant le clic — utilisez une photo de vos créations.', 'noor' ),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Build a privacy-friendly embed URL from a YouTube/Vimeo link.
	 *
	 * @param string $url Video page URL.
	 * @return string Embed URL, or '' if not recognized.
	 */
	private function embed_url( $url ) {
		if ( preg_match( '~(?:youtube\.com/watch\?v=|youtu\.be/)([\w-]{6,20})~', $url, $m ) ) {
			return 'https://www.youtube-nocookie.com/embed/' . $m[1] . '?autoplay=1';
		}
		if ( preg_match( '~vimeo\.com/(\d+)~', $url, $m ) ) {
			return 'https://player.vimeo.com/video/' . $m[1] . '?autoplay=1';
		}
		return '';
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$embed    = ! empty( $settings['video_url'] ) ? $this->embed_url( $settings['video_url'] ) : '';
		?>
		<section class="nfw-video">
			<div class="nfw-sechead nfw-sechead--dark">
				<?php if ( ! empty( $settings['kicker'] ) ) : ?><div class="nfw-sechead__kicker"><?php echo esc_html( $settings['kicker'] ); ?></div><?php endif; ?>
				<?php if ( ! empty( $settings['title'] ) ) : ?><h2 class="nfw-sechead__title"><?php echo esc_html( $settings['title'] ); ?></h2><?php endif; ?>
				<?php if ( ! empty( $settings['subtitle'] ) ) : ?><p class="nfw-sechead__sub"><?php echo esc_html( $settings['subtitle'] ); ?></p><?php endif; ?>
			</div>
			<div class="nfw-video__frame" <?php if ( $embed ) : ?>data-embed="<?php echo esc_url( $embed ); ?>"<?php endif; ?>>
				<?php if ( ! empty( $settings['poster']['url'] ) ) : ?>
					<img class="nfw-video__poster" src="<?php echo esc_url( $settings['poster']['url'] ); ?>" alt="" loading="lazy" />
				<?php endif; ?>
				<button type="button" class="nfw-video__play" aria-label="<?php esc_attr_e( 'Lire la vidéo', 'noor' ); ?>">▶</button>
			</div>
		</section>
		<script>
		(function(){
			document.querySelectorAll('.nfw-video__frame[data-embed]').forEach(function(frame){
				if (frame.dataset.noorBound) { return; }
				frame.dataset.noorBound = '1';
				frame.addEventListener('click', function(){
					var iframe = document.createElement('iframe');
					iframe.src = frame.dataset.embed;
					iframe.allow = 'autoplay; encrypted-media; picture-in-picture';
					iframe.allowFullscreen = true;
					iframe.className = 'nfw-video__iframe';
					frame.innerHTML = '';
					frame.appendChild(iframe);
				}, { once: true });
			});
		})();
		</script>
		<?php
	}
}
