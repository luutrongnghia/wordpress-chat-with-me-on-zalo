<?php
/**
 * Handles logic for the admin settings page.
 *
 * @since 1.0.0
 */
final class CWMOZ {

	protected static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'cwmoz_init' ) );
	}

	/**
	 * Adds the admin menu
	 * the plugin's admin settings page.
	 *
	 * @since 1.0
	 * @return void
	 */
	public function cwmoz_init() {
		add_action( 'admin_menu', array( $this, 'menu' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_action( 'wp_footer', array( $this, 'frontend' ) );
		add_filter( 'plugin_action_links_' . CWMOZ_BASE_NAME, array( $this, 'add_action_links' ) );

		if ( isset( $_REQUEST['page'] ) && 'chat-with-me-on-zalo' == $_REQUEST['page'] ) {
			$this->save();
		}
	}

	/**
	 *  Frontend styles & scripts.
	 */
	public function enqueue_scripts() {
		$data = $this->default_data();

		if ( '2' == $data['style'] ) {
			wp_enqueue_style( 'cwmoz-style', CWMOZ_ASSETS_URL . 'css/style-2.css', array(), CWMOZ_VERSION );
		} else {
			wp_enqueue_style( 'cwmoz-style', CWMOZ_ASSETS_URL . 'css/style-1.css', array(), CWMOZ_VERSION );
		}
	}

	/**
	 * Admin frontend styles & scripts.
	 */
	public function admin_enqueue_scripts() {
		wp_enqueue_style( 'cwmoz-admin-style', CWMOZ_ASSETS_URL . 'css/admin.css', array(), CWMOZ_VERSION );
	}

	/**
	 * Register admin settings menu.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function menu() {
		if ( is_main_site() || ! is_multisite() ) {
			if ( current_user_can( 'manage_options' ) ) {

				$title    = esc_html__( 'CWMOZ Settings', 'chat-with-me-on-zalo' );
				$cap      = 'manage_options';
				$slug     = 'chat-with-me-on-zalo';
				$func     = array( $this, 'backend' );
				$icon     = CWMOZ_ASSETS_URL . 'images/zalo-icon.png';
				$position = 500;

				add_menu_page( $title, $title, $cap, $slug, $func, $icon, $position );
			}
		}
	}

	/**
	 * Get settings data.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function default_data() {
		$defaults = array(
			'phone'    => '0778991913',
			'margin'   => '',
			'position' => 'left',
			'style'    => '2',
		);

		$data = $this->cwmoz_admin_configuration( 'cwmoz_configurations', true );

		if ( ! is_array( $data ) || empty( $data ) ) {
			return $defaults;
		}

		if ( is_array( $data ) && ! empty( $data ) ) {
			return wp_parse_args( $data, $defaults );
		}
	}

	/**
	 * Renders the update message.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function message() {
		if ( ! empty( $_POST ) ) {
			echo '<div class="updated"><p>' . esc_html__( 'Settings updated!', 'chat-with-me-on-zalo' ) . '</p></div>';
		}
	}

	/**
	 * Admin html form setting.
	 *
	 * @return [type] [description]
	 */
	public function backend() {
		include CWMOZ_PATH . 'includes/backend.php';
	}

	/**
	 * Chat With Me On Zalo frontend.
	 * @return [type] [description]
	 */
	public function frontend() {
		$data = $this->default_data();

		$hotline = '';
		if ( ! empty( $data['phone'] ) ) {
			$hotline = $data['phone'];
		} else {
			return;
		}
		?>
		<div class="zalo-container <?php echo empty( $data['position'] ) ? 'left' : $data['position']; ?>"<?php echo empty( $data['margin'] ) ? '' : ' style="bottom:' . $data['margin'] . 'px;"'; ?>>
			<a id="zalo-btn" href="https://zalo.me/<?php echo $hotline; ?>" target="_blank" rel="noopener noreferrer nofollow">
				<?php if ( '2' == $data['style'] ) : ?>
				<div class="animated_zalo infinite zoomIn_zalo cwmoz-alo-circle"></div>
				<div class="animated_zalo infinite pulse_zalo cwmoz-alo-circle-fill"></div>
				<span><img src="<?php echo CWMOZ_ASSETS_URL . 'images/zalo-2.png'; ?>" alt="Chat With Me on Zalo"></span>
				<?php else : ?>
				<div class="zalo-ico zalo-has-notify">
					<div class="zalo-ico-main">
						<img src="<?php echo CWMOZ_ASSETS_URL . 'images/zalo-1.png'; ?>" alt="Chat With Me on Zalo" />
					</div>
					<em></em>
				</div>
				<?php endif; ?>
			</a>
		</div>
	<?php
	}

	/**
	 * Renders the action for a form.
	 *
	 * @since 1.0.0
	 * @param string $type The type of form being rendered.
	 * @return void
	 */
	public function form_action( $type = '' ) {
		return admin_url( '/admin.php?page=chat-with-me-on-zalo' . $type );
	}

	/**
	 * Returns an option from the database for
	 * the admin settings page.
	 *
	 * @since 1.0.0
	 * @param string $key The option key.
	 * @return mixed
	 */
	public function cwmoz_admin_configuration( $key, $network_override = true ) {
		if ( is_network_admin() ) {
			$value = get_site_option( $key );
		}
			elseif ( ! $network_override && is_multisite() ) {
				$value = get_site_option( $key );
			}
			elseif ( $network_override && is_multisite() ) {
				$value = get_option( $key );
				$value = ( false === $value || ( is_array( $value ) && in_array( 'disabled', $value ) ) ) ? get_site_option( $key ) : $value;
			}
			else {
			$value = get_option( $key );
		}

		return $value;
	}

	/**
	 * Saves settings.
	 *
	 * @since 1.0.0
	 * @access private
	 * @return void
	 */
	private function save() {
		if ( ! isset( $_POST['cwmoz-settings-nonce'] ) || ! wp_verify_nonce( $_POST['cwmoz-settings-nonce'], 'cwmoz-settings' ) ) {
			return;
		}

		$data = $this->default_data();

		$data['phone']    = isset( $_POST['cwmoz_configurations']['phone'] ) ? sanitize_text_field( $_POST['cwmoz_configurations']['phone'] ) : '';
		$data['margin']   = isset( $_POST['cwmoz_configurations']['margin'] ) ? sanitize_text_field( $_POST['cwmoz_configurations']['margin'] ) : '';
		$data['position'] = isset( $_POST['cwmoz_configurations']['position'] ) ? sanitize_text_field( $_POST['cwmoz_configurations']['position'] ) : 'left';
		$data['style']    = isset( $_POST['cwmoz_configurations']['style'] ) ? sanitize_text_field( $_POST['cwmoz_configurations']['style'] ) : '1';

		update_site_option( 'cwmoz_configurations', $data );
	}

	/**
	 * [add_action_links description]
	 * @param  [type] $links_array [description]
	 * @return [type]              [description]
	 */
	public function add_action_links( $links ) {
		$links[] = '<a href="' . admin_url( '/admin.php?page=chat-with-me-on-zalo' ) . '">' . esc_html__( 'Settings', 'chat-with-me-on-zalo' ) . '</a>';

		return array_merge( $links );
	}
}
