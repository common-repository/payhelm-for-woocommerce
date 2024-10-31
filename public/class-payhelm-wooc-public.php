<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.payhelm.com/
 * @since      1.0.0
 *
 * @package    Payhelm_WooC
 * @subpackage Payhelm_WooC/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Payhelm_WooC
 * @subpackage Payhelm_WooC/public
 */
class Payhelm_WooC_Public { 

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
	 * @param      string    $payhelm_wooc       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $payhelm_wooc, $version ) { 

		$this->payhelm_wooc = $payhelm_wooc;
		$this->version = $version;

	} 

	// public function post_request( $url, $body) { 

	// 	$options = [
	// 		'body'        => $body,
	// 		'headers'     => [
	// 			'Content-Type' => 'application/json',
	// 		],
	// 		'timeout'     => 300,
	// 		'data_format' => 'body',
	// 	];
			
	// 	$response = wp_remote_post( $url, $options);

	// 	if ( $err || !$response) { 
	// 		return false;
	// 	} else { 
	// 		return $response;
	// 	} 
	// } 

	// public function set_keys( WP_REST_Request $request) { 
	// 	$request_body = $request->get_json_params();
	// 	$request_body['admin_email'] = apply_filters( 'woocommerce_tracker_admin_email', get_option( 'admin_email' ) );

	// 	$url = 'https://client.payhelm.com/auth/woocommerce';
	// 	$json_body = json_encode($request_body);

	// 	$this->post_request( $url, $json_body);

	// 	if ($request_body['consumer_key'] && $request_body['consumer_secret']) { 
	// 	   update_option('ck', $request_body['consumer_key']);
	// 	   update_option('cs', $request_body['consumer_secret']);
	// 	   update_option('user_id', $request_body['user_id']);
	// 	   update_option('key_permissions', $request_body['key_permissions']);
	// 	   update_option('key_id', $request_body['key_id']);
	// 	   update_option('has_visited_channels', false);
	// 	   $response = new WP_REST_Response(array('message'=>'Successful'));
	// 	   $response->set_status(200);
	// 	   return $response;
	// 	} else { 
	// 		return new WP_Error( 'invalid_request', 'Something went wrong', array('status'=>403) );
	// 	} 
	// } 
	
	// public function payhelm_api() { 
	// 	register_rest_route('payhelm/v1', '/setkey', array(
	// 		'methods'=>'POST',
	// 		'callback'=>[$this,'set_keys'],
	// 	));
	// } 
	
	public function payhelm_pixel_script() { 
		$store_url = get_site_url();
		$removeChar = ['https://', 'http://', '/'];
		$store_url_wo_https = str_replace($removeChar, '', get_site_url() );

		wp_enqueue_script('payhelm_pixel', esc_url_raw("https://d99xz3flubf0x.cloudfront.net/js/payhelm.wooc.1.0.0.js?store=${store_url_wo_https}"), array(), '1.0.0' );
	} 

} 
