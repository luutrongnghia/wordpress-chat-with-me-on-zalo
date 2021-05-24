<?php
/**
 * Plugin Name: Chat With Me on Zalo
 * Plugin URI: https://luutrongnghia.wordpress.com/2020/11/12/chat-with-me-on-zalo/
 * Description: Chat With Me on Zalo.
 * Version: 1.0
 * Author: Luu Trong Nghia
 * Author URI: https://haita.media/vi/thietke-phimquangcao.html
 *
 * @package Chat_With_Me_On_Zalo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'CWMOZ_VERSION', '1.0' );
define( 'CWMOZ_FILE', __FILE__ );
define( 'CWMOZ_NAME', basename( CWMOZ_FILE ) );
define( 'CWMOZ_BASE_NAME', plugin_basename( CWMOZ_FILE ) );
define( 'CWMOZ_PATH', plugin_dir_path( CWMOZ_FILE ) );
define( 'CWMOZ_URL', plugin_dir_url( CWMOZ_FILE ) );
define( 'CWMOZ_MODULES_PATH', CWMOZ_PATH . 'modules/' );
define( 'CWMOZ_ASSETS_URL', CWMOZ_URL . 'assets/' );

require_once CWMOZ_PATH . '/includes/class-chat-with-me-on-zalo.php';
CWMOZ::instance();
