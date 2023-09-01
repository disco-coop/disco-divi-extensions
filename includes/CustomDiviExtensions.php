<?php

class DISCO_CustomDiviExtensions extends DiviExtension {

	/**
	 * The gettext domain for the extension's translations.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $gettext_domain = 'disco-custom-divi-extensions';

	/**
	 * The extension's WP Plugin name.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $name = 'custom-divi-extensions';

	/**
	 * The extension's version
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $version = '1.0.0';

	/**
	 * DISCO_CustomDiviExtensions constructor.
	 *
	 * @param string $name
	 * @param array  $args
	 */
	public function __construct( $name = 'custom-divi-extensions', $args = array() ) {
		$this->plugin_dir     = plugin_dir_path( __FILE__ );
		$this->plugin_dir_url = plugin_dir_url( $this->plugin_dir );

		parent::__construct( $name, $args );
	}
}

new DISCO_CustomDiviExtensions;

// Add js utils
function asset_loader() {
	// Load js file
	wp_enqueue_script('index_js', plugin_dir_url(__FILE__) . 'utils/index.js',['jquery'],null);
	
	// Add siteConfig object to js
	wp_localize_script('index_js','siteConfig', array(
		'ajaxUrl' => admin_url('admin-ajax.php'),
		'ajax_nonce' => wp_create_nonce('load_more_post_nonce')
	));
}

add_action('wp_enqueue_scripts',__NAMESPACE__.'\\asset_loader');

add_action('wp_ajax_disco_hello_world','ajax_hello_world');
add_action('wp_ajax_nopriv_disco_hello_world','ajax_hello_world');

function ajax_hello_world() {
	echo 'Hello world';
	wp_die();
}