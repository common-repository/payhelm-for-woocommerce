<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.payhelm.com/
 * @since      1.0.0
 *
 * @package    Payhelm_WooC
 * @subpackage Payhelm_WooC/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Payhelm_WooC
 * @subpackage Payhelm_WooC/includes
 */
class Payhelm_WooC_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		$private_key = wp_generate_password(32, false, false);
		update_option('paywoo_private_key', $private_key);
		$store_url = get_site_url();
		$admin_email = get_bloginfo('admin_email');
		$body = [
			'store_url' => $store_url,
			'private_key' => $private_key,
			'email' => $admin_email,
		];
		wp_remote_post('https://client.payhelm.com/auth/woocommerce/secure', [
			'body' => json_encode($body),
			'headers' => ['Content-Type' => 'application/json'],
			'method' => 'POST',
			'data_format' => 'body',
		]);
	}

}
