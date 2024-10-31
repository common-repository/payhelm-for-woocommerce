<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.payhelm.com/
 * @since      1.0.0
 *
 * @package    Payhelm_WooC
 * @subpackage Payhelm_WooC/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Payhelm_WooC
 * @subpackage Payhelm_WooC/admin
 */
class Payhelm_WooC_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $payhelm_wooc    The ID of this plugin.
	 */
	private $payhelm_wooc;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $payhelm_wooc       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $payhelm_wooc, $version ) {

		$this->payhelm_wooc = $payhelm_wooc;
		$this->version = $version;

	}

	/**
	 * Register any menu pages used for the plugin.
	 *
	 * @since    1.0.0
	 */
	public function payhelm_menu() {
		add_menu_page('PayHelm', 'PayHelm', 'manage_options', 'payhelm', array($this, 'payhelm_tab'), 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBzdGFuZGFsb25lPSJubyI/Pgo8IURPQ1RZUEUgc3ZnIFBVQkxJQyAiLS8vVzNDLy9EVEQgU1ZHIDIwMDEwOTA0Ly9FTiIKICJodHRwOi8vd3d3LnczLm9yZy9UUi8yMDAxL1JFQy1TVkctMjAwMTA5MDQvRFREL3N2ZzEwLmR0ZCI+CjxzdmcgdmVyc2lvbj0iMS4wIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciCiB3aWR0aD0iMzAwLjAwMDAwMHB0IiBoZWlnaHQ9IjMwMC4wMDAwMDBwdCIgdmlld0JveD0iMCAwIDMwMC4wMDAwMDAgMzAwLjAwMDAwMCIKIHByZXNlcnZlQXNwZWN0UmF0aW89InhNaWRZTWlkIG1lZXQiPgo8bWV0YWRhdGE+CkNyZWF0ZWQgYnkgcG90cmFjZSAxLjEwLCB3cml0dGVuIGJ5IFBldGVyIFNlbGluZ2VyIDIwMDEtMjAxMQo8L21ldGFkYXRhPgo8ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSgwLjAwMDAwMCwzMDAuMDAwMDAwKSBzY2FsZSgwLjEwMDAwMCwtMC4xMDAwMDApIgpmaWxsPSIjMDAwMDAwIiBzdHJva2U9Im5vbmUiPgo8cGF0aCBkPSJNODg0IDI4NTUgYy0xODcgLTg1IC0zMTMgLTE3NCAtNDY1IC0zMzIgLTIwMSAtMjA5IC0zMjMgLTQzOSAtMzkxCi03MzkgLTMwIC0xMzUgLTMzIC00MzIgLTUgLTU2OSA0MCAtMTk0IDExNyAtMzkxIDIwNiAtNTMwIDg5IC0xMzggMjM0IC0yOTUKMzcwIC0zOTkgbDU5IC00NiA2IDM4IGMzIDIwIDI4IDIxOSA1NiA0NDIgMjcgMjIzIDcyIDU4NyA5OSA4MTAgMjggMjIzIDY4CjU1NCA5MSA3MzUgMjIgMTgyIDQ0IDM2NCA1MCA0MDUgMTQgMTAwIDI4IDIyNCAyNiAyMjcgLTEgMSAtNDcgLTE4IC0xMDIgLTQyeiIvPgo8cGF0aCBkPSJNMTQyNiAyNjM0IGMtMTIgLTc1IC0xMTYgLTkzNCAtMTE2IC05NTUgbDAgLTIxIDIxOCA1IGMyMzIgNSAyODIgMTQKMzg5IDY0IDgwIDM4IDE2NiAxMjIgMjAzIDE5NiA0OSAxMDIgNjIgMTczIDU4IDMxNiAtMyAxMTkgLTUgMTMwIC0zNiAxOTMgLTUzCjEwOCAtMTQ5IDE3OCAtMjk0IDIxMyAtMzcgOSAtMTM2IDE4IC0yMzkgMjIgbC0xNzcgNiAtNiAtMzl6Ii8+CjxwYXRoIGQ9Ik0yNjM4IDI0MzggYzEwIC0zNyAxNSAtMTAzIDE2IC0yMjMgMSAtMTQ3IC0yIC0xODEgLTIyIC0yNTQgLTQxCi0xNTIgLTEwMiAtMjcwIC0xOTUgLTM4MCAtMTA2IC0xMjcgLTIzNiAtMjE0IC00MDMgLTI3MCAtMTQ5IC01MCAtMjM1IC02MAotNTE5IC02MSAtMTg4IC0xIC0yNTcgLTQgLTI2MCAtMTMgLTQgLTExIC0yNSAtMTgxIC0xMTAgLTg2OCAtMTkgLTE1NyAtMzUKLTI5NyAtMzUgLTMxMSAwIC0yMyA2IC0yNyA1OCAtMzggMzQgLTggMTUzIC0xNSAyOTYgLTE4IDI3OSAtNSAzNjUgNiA1NDEgNzAKMjI3IDgyIDM3MSAxNzQgNTUyIDM1MyAyMzggMjM2IDM2NSA0NzggNDI3IDgxNSAyOSAxNTYgMTcgNDQwIC0yNSA2MTAgLTUwCjIwNCAtMTgwIDQ2MCAtMzA4IDYwOCBsLTI4IDMzIDE1IC01M3oiLz4KPC9nPgo8L3N2Zz4K', 4);
		add_submenu_page('payhelm', 'Dashboard', 'Dashboard', 'manage_options', 'dashboard', array($this, 'dashboard_page'), 1);
		add_submenu_page('payhelm', 'Traffic', 'Traffic', 'manage_options', 'traffic', array($this, 'traffic_page'), 2);
		add_submenu_page('payhelm', 'Custom Reports', 'Custom Reports', 'manage_options', 'custom_reports', array($this, 'custom_reports_page'), 3);
		add_submenu_page('payhelm', 'My Plan', 'My Plan', 'manage_options', 'my_plan', array($this, 'my_plan_page'), 4);
		add_submenu_page('payhelm', 'Settings', 'Settings', 'manage_options', 'settings', array($this, 'settings_page'), 5);
		remove_submenu_page('payhelm', 'payhelm');
	}

	/**
	 * Renders what will be shown in the payhelm_menu. If user's first time using the plugin, it will request for permissions/read_write access for WooC.
	 *
	 * @since    1.0.0
	 */
	public function payhelm_tab( $page = 'channels' ) {

		$store_url = get_site_url();
		$private_key = get_option('paywoo_private_key');
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

		if ( is_user_logged_in() ) {
			$current_user = wp_get_current_user();
			$current_user_email = $current_user->user_email;
		} else {
			$current_user_email = get_bloginfo();
		}

		$store_url = get_site_url();
		$removeChar = ['https://', 'http://', '/'];
		$store_url_wo_https = str_replace($removeChar, '', get_site_url());
		$store_name = get_bloginfo('name');
		$admin_email = get_bloginfo('admin_email');
		$has_visited_channels = get_option('has_visited_channels');

		// $endpoint = '/wc-auth/v1/authorize';
		// $params = [
		// 	'app_name' => 'PayHelm',
		// 	'scope' => 'read_write',
		// 	'user_id' => $store_url,
		// 	'return_url' => "{$store_url}/wp-admin/admin.php?page=dashboard",
		// 	'callback_url' => "{$store_url}/wp-json/payhelm/v1/setkey",
		// ];
		// $query_string = http_build_query( $params );
		$arr = array('iframe' => array(
			'style'           => true,
			'src'             => true,
			'height'          => true,
			'width'           => true,
			'frameborder'     => true,
			'allowfullscreen' => true,
		));
		
		$version = '1.0.0';
		if ( defined( 'PAYHELM_WOOC_VERSION' ) ) {
			$version = PAYHELM_WOOC_VERSION;
		}
		$body = [
			'store_url' => $store_url,
			'private_key' => get_option('paywoo_private_key'),
			'version' => $version,
		];
		$response = wp_remote_post('https://client.payhelm.com/auth/woocommerce/authorize', [
			'body' => json_encode($body),
			'headers' => ['Content-Type' => 'application/json'],
			'method' => 'POST',
			'data_format' => 'body',
		]);
		$response_code = wp_remote_retrieve_response_code($response);
		if ($response_code !== 200) {
			$has_visited_channels = false;
			update_option('has_visited_channels', $has_visited_channels);
		} else {
			$has_visited_channels = true;
			update_option('has_visited_channels', $has_visited_channels);
		}

		if (!$has_visited_channels) {
			$page = 'onboard';

			$payload = array(
				'store_url' => esc_url($store_url_wo_https),
				'admin_email' => $admin_email,
				'private_key' => get_option('paywoo_private_key'),
				'page' => $page,
			);

			$json_payload = json_encode($payload);
			$encoded_payload = base64_encode($json_payload);

			$iframe_src = esc_url_raw("https://app.payhelm.com/{$page}/?channel=woocommerce&payload={$encoded_payload}");

			echo wp_kses("<iframe style='position:static; margin:0px; padding:0px; margin-top:-1px; margin-left:-20px; height: 95vh; width: 101.5%; overflow:hidden;' src={$iframe_src}></iframe>", $arr);
		} else {
			$payload = array(
				'store_url' => esc_url($store_url_wo_https),
				'admin_email' => $admin_email,
				'private_key' => get_option('paywoo_private_key'),
				'page' => $page,
			);

			$json_payload = json_encode($payload);
			$encoded_payload = base64_encode($json_payload);

			$iframe_src = esc_url_raw("https://app.payhelm.com/{$page}?channel=woocommerce&payload={$encoded_payload}");

			echo wp_kses("<iframe style='position:static; margin:0px; padding:0px; margin-top:-1px; margin-left:-20px; height: 95vh; width: 101.5%; overflow:hidden;' src={$iframe_src}></iframe>", $arr);
		}
	}

	/**
	 * Renders what will be shown in the Dashboard submenu tab.
	 *
	 * @since    1.0.0
	 */
	public function dashboard_page() {
		return call_user_func_array( array($this, 'payhelm_tab'), array('dashboard'));
	}


	/**
	 * Renders what will be shown in the Traffic submenu tab.
	 *
	 * @since    1.0.0
	 */
	public function traffic_page() {
		return call_user_func_array( array($this, 'payhelm_tab'), array('traffic'));
	}

	/**
	 * Renders what will be shown in the Custom Reports submenu tab.
	 *
	 * @since    1.0.0
	 */
	public function custom_reports_page() {
		return call_user_func_array( array($this, 'payhelm_tab'), array('custom'));
	}

	/**
	 * Renders what will be shown in the My Plan submenu tab.
	 *
	 * @since    1.0.0
	 */
	public function my_plan_page() {
		return call_user_func_array( array($this, 'payhelm_tab'), array('plan'));
	}

	/**
	 * Renders what will be shown in the Settings submenu tab.
	 *
	 * @since    1.0.0
	 */
	public function settings_page() {
		return call_user_func_array( array($this, 'payhelm_tab'), array('settings'));
	}
}
