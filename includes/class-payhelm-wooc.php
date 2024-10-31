<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.payhelm.com/
 * @since      1.0.0
 *
 * @package    Payhelm_WooC
 * @subpackage Payhelm_WooC/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Payhelm_WooC
 * @subpackage Payhelm_WooC/includes
 */
class Payhelm_WooC {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @var      Payhelm_WooC_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $payhelm_wooc    The string used to uniquely identify this plugin.
	 */
	protected $payhelm_wooc;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PAYHELM_WOOC_VERSION' ) ) {
			$this->version = PAYHELM_WOOC_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->payhelm_wooc = 'payhelm-wooc';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Payhelm_WooC_Loader. Orchestrates the hooks of the plugin.
	 * - Payhelm_WooC_I18n. Defines internationalization functionality.
	 * - Payhelm_WooC_Admin. Defines all hooks for the admin area.
	 * - Payhelm_WooC_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-payhelm-wooc-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-payhelm-wooc-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-payhelm-wooc-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-payhelm-wooc-public.php';

		$this->loader = new Payhelm_WooC_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Payhelm_WooC_I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 */
	private function set_locale() {

		$plugin_i18n = new Payhelm_WooC_I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Payhelm_WooC_Admin( $this->get_payhelm_wooc(), $this->get_version() );

		$this->loader->add_action('admin_menu', $plugin_admin, 'payhelm_menu');
		
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 */
	private function define_public_hooks() {

		$plugin_public = new Payhelm_WooC_Public( $this->get_payhelm_wooc(), $this->get_version() );
		
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'payhelm_pixel_script');
		// $this->loader->add_action('rest_api_init', $plugin_public, 'payhelm_api');
		$this->loader->add_action('rest_api_init', $this, 'register_custom_api_hooks');

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_payhelm_wooc() {
		return $this->payhelm_wooc;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Payhelm_WooC_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Validate api calls.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function validate_request(WP_REST_Request $request) {
    $provided_key = $request->get_header('Authorization');
    $stored_key = get_option('paywoo_private_key');
    if (!$provided_key || !$stored_key) {
			return false;
    }
    return hash_equals($provided_key, $stored_key);
	}

	/**
	 * Register public facing api endpoints.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function register_custom_api_hooks() {
    register_rest_route('payhelm/v1', '/stripe/', array(
			'methods' => 'GET',
			'callback' => array($this, 'get_wcpay_account_data'),
			'permission_callback' => array($this, 'validate_request'),
    ));
	}

	/**
	 * Return the contents of the wcpay_account_data column data in the wp_options table.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_wcpay_account_data(WP_REST_Request $request) {
    global $wpdb;
    $query = $wpdb->prepare("SELECT option_value FROM {$wpdb->options} WHERE option_name = %s", 'wcpay_account_data');
    $result = $wpdb->get_var($query);
    if (!empty($result)) {
			$data = maybe_unserialize($result);
			if (isset($data['data']['live_publishable_key'])) {
				$response_data = array('live_publishable_key' => $data['data']['live_publishable_key']);
				return new WP_REST_Response($response_data, 200);
			} else {
				return new WP_REST_Response(array('message' => 'Live publishable key not found'), 404);
			}
    } else {
			return new WP_REST_Response(array('message' => 'No data found'), 404);
    }
	}

}
