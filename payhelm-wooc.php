<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.payhelm.com/
 * @since             1.0.0
 * @package           Payhelm_WooC
 *
 * @wordpress-plugin
 * Plugin Name:       Analyze Export WooCommerce Data Taxes by PayHelm
 * Plugin URI:        https://www.payhelm.com/
 * Description:       Instantly add advanced eCommerce analytics and reporting to your website with absolutely no coding or custom development needed.
 * Version:           1.0.7
 * Author:            PayHelm
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       payhelm-wooc
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PAYHELM_WOOC_VERSION', '1.0.7' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-payhelm-wooc-activator.php
 */
function activate_payhelm_wooc() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-payhelm-wooc-activator.php';
	Payhelm_WooC_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-payhelm-wooc-deactivator.php
 */
function deactivate_payhelm_wooc() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-payhelm-wooc-deactivator.php';
	Payhelm_WooC_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_payhelm_wooc' );
register_deactivation_hook( __FILE__, 'deactivate_payhelm_wooc' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-payhelm-wooc.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_payhelm_wooc() {

	$plugin = new Payhelm_WooC();
	$plugin->run();

}

// If WooCommerce does not exist, let the user know and do not run the plugin. Else run plugin.
function wooc_payhelm_init() {
	if (! class_exists('WooCommerce')) {
		function woocommerce_payhelm_missing_wc_notice() {
			/* translators: 1. URL link. */
			echo '<div class="error"><p><strong>' . sprintf( esc_html__( 'Payhelm requires WooCommerce to be installed and active. You can download %s here.' ), '<a href="https://woocommerce.com/" target="_blank">WooCommerce</a>' ) . '</strong></p></div>';
		}

		add_action('admin_notices', 'woocommerce_payhelm_missing_wc_notice');
	} else {

		run_payhelm_wooc();
	}
}

add_action('plugins_loaded', 'wooc_payhelm_init');

