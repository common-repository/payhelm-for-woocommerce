<?php
$url = "https://client.payhelm.com/uninstall/woocommerce";
/**
 * Fired when the plugin is uninstalled.
 *
 * @link       https://www.payhelm.com/
 * @since      1.0.0
 *
 * @package    Payhelm_WooC
 */




// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
	// when uninstalling remove cs, ck, user_id, key_permissions, key_id in wpdb
$options = array(
	'cs',
	'ck',
	'user_id',
	'key_permissions',
	'key_id',
	'has_visited_channels',
	'paywoo_private_key',
);

$consumer_key = get_option('ck');
$consumer_secret = get_option('cs');
$private_key = get_option('paywoo_private_key');
$store_url = get_site_url();
$removeChar = ['https://', 'http://', '/'];
$store_url_wo_https = str_replace($removeChar, '', get_site_url());

$payload = array(
	'store_url' => esc_url($store_url_wo_https),
	'encoded_ck' => base64_encode($consumer_key),
	'encoded_cs' => base64_encode($consumer_secret),
	'encoded_pk' => base64_encode($private_key),
);

$encodedPayload = base64_encode(json_encode($payload));

// Initialize cURL session
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url . '?payload=' . urlencode($encodedPayload));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute cURL request and capture response
$response = curl_exec($ch);

if (curl_errno($ch)) {
		error_log('cURL error: ' . curl_error($ch));
} else {
		error_log('cURL response: ' . $response);
}
// Close cURL session
curl_close($ch);

foreach ($options as $option) {
	if (get_option($option)) {
		delete_option($option);
	}
}
