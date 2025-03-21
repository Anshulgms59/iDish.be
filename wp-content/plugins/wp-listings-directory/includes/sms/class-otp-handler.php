<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WP_Listings_Directory_SMS_Otp_Handler{

	protected static $_instance = null;
	protected static $ip_address, $geoData;

	public static function get_instance(){
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct(){
		self::$geoData 		= WP_Listings_Directory_SMS_Geolocation::get_data();
		self::$ip_address 	= self::$geoData['ip_address'];
		self::cleanup();
	}


	/**
	 * This will only send OTP SMS.
	 * @return OTP
	*/
	public static function onlySendOTPSMS( $phone_code, $phone_no ){
		$operator = wp_listings_directory_get_option( 'phone_approve_operator', 'twilio' );

		if ( $operator == 'aws' ) {
			$obj = WP_Listings_Directory_SMS_Aws::get_instance();
		} else {
			$obj = WP_Listings_Directory_SMS_Twilio::get_instance();
		}

		$otp =  self::generate_otp_digits();

		$smstext = self::getOTPSMSText( $otp );

		$otpSent = $obj->sendSMS( $phone_code.$phone_no, $smstext );
		//$otpSent = true;

		if( is_wp_error( $otpSent ) ){
			return $otpSent;
		}

		return $otp;
	}

	/**
	 * This will send OTP SMS & set data to current user ip address as well.
	 * @return OTP
	*/
	public static function sendOTPSMS( $phone_code, $phone_no ){

		$ok_to_send_otp = self::ok_to_send_otp( $phone_code, $phone_no );
		
		if( is_wp_error( $ok_to_send_otp ) ){
			return $ok_to_send_otp;
		}

		$phone_otp_data = self::get_otp_data();

		if( $phone_otp_data){
			$sent_times 	= (int) $phone_otp_data['sent_times'];
			$incorrect 		= $phone_otp_data['incorrect'];
		}else{
			$incorrect = $sent_times = 0;
		}

		$otp = self::onlySendOTPSMS( $phone_code, $phone_no );

		if( is_wp_error( $otp ) ){
			return $otp;
		}

		$sent_times++;

		$data = array(
			'phone_no' 		=> $phone_no,
			'phone_code' 	=> $phone_code,
			'otp' 			=> $otp,
			'created' 		=> strtotime('now'),
			'expiry' 		=> strtotime( wp_listings_directory_get_option('phone_approve_otp_expiry', 120). ' seconds' ),
			'incorrect' 	=> $incorrect,
			'sent_times'	=> $sent_times,
			'verified' 		=> false,
			'form_token' 	=> false,
		);

		self::set_otp_data( $data );

		return $otp;
	}

	/**
	 * Sends OTP to already assigned phone number in user's IP address
	*/
	public static function resendOTPSMS(){
		$phone_otp_data = self::get_otp_data();

		if( !$phone_otp_data  || !isset( $phone_otp_data[ 'phone_no' ] ) || !$phone_otp_data[ 'phone_no' ] || !isset( $phone_otp_data['phone_code'] ) ){
			return new Wp_Error( 'no-phone', __( "Phone Number not found", 'wp-listings-directory' ) );
		}
		$otp = self::sendOTPSMS( $phone_otp_data['phone_code'], $phone_otp_data['phone_no'] );
		return $otp;
	}


	public static function generate_otp_digits(){
		$digits = wp_listings_directory_get_option('phone_approve_otp_digits', 4) ? wp_listings_directory_get_option('phone_approve_otp_digits', 4) : 4;
		return rand( pow( 10, $digits - 1 ) , pow( 10, $digits ) - 1 );
	}


	public static function set_otp_data( $key, $value = '' ){

		$ip_address = self::$ip_address;
		$users 		= self::get_otp_users();

		if( !is_array( $users ) ){
			$users = array();
		}

		if( !isset( $users[ $ip_address ] ) ){
			$users[ $ip_address ] = array();
		}

		if( is_array( $key ) ){
			$users[ $ip_address ] = wp_parse_args(
				$key,
				$users[ $ip_address ]
			);
		}else{
			$users[ $ip_address ][ $key ] = $value;
		}

		$users[ $ip_address ][ 'last_updated' ] = time();

		update_option( 'wp_listings_directory_otp_users', $users );
	}


	public static function get_otp_users(){
		return (array) get_option( 'wp_listings_directory_otp_users' );
	}

	public static function get_otp_data(){
		$users = get_option( 'wp_listings_directory_otp_users' );
		if( is_array( $users ) && isset( $users[ self::$ip_address ] ) ){
			return $users[ self::$ip_address ]; 
		}
		return false;
	}


	public static function ok_to_send_otp( $phone_code = '', $phone_no = '' ){

		$data = self::get_otp_data();

		if( !is_array( $data ) || empty( $data ) ) return;

		$resend_limit 		= wp_listings_directory_get_option('phone_approve_resend_otp_limit');
		$incorrect_limit 	= wp_listings_directory_get_option('phone_approve_incorrect_otp_limit');
		$resend_wait_time 	= wp_listings_directory_get_option('phone_approve_resend_otp_wait_time');
		$ban_time 			= wp_listings_directory_get_option('phone_approve_ban_time');

		$time_passed = strtotime("now") - (int) $data['created'];

		if( $data['sent_times'] > $resend_limit ){
			$unban_time_left = $ban_time - $time_passed;
			if(  $unban_time_left < 0  ){
				self::set_otp_data( 'sent_times', 0 );
			}
			else{
				return new WP_Error( 'limit-reached', sprintf( __( 'OTP Limit reached. Please try again in %s.', 'wp-listings-directory' ), self::getTimeDuration( $unban_time_left) ) );
			}
		}

		if( $data['phone_no'] === $phone_no && $data['phone_code'] === $phone_code && $data['sent_times'] >= 1 &&  $resend_wait_time > $time_passed ){
			$unban_time_left = $resend_wait_time - $time_passed;
			return new WP_Error( 'resend-wait', sprintf( __( 'Please wait %s for a new OTP.', 'wp-listings-directory' ), self::getTimeDuration( $unban_time_left) ) );
		}


		if( $data['incorrect'] >= $incorrect_limit ){
			$unban_time_left = $ban_time - $time_passed;
			if( $unban_time_left < 0 ){
				self::set_otp_data( 'incorrect', 0 );
			}
			else{
				return new WP_Error( 'tries-exceeded', sprintf( __( 'Maximum number of tries exceeded. Please try again in %s.', 'wp-listings-directory' ), self::getTimeDuration( $unban_time_left) ) );
			}
		}


	}


	public static function getTimeDuration( $time ){
		return $time > 60 ? round($time/60). ' minutes' : $time. ' seconds';
	}


	public static function getOTPSMSText( $otp ){
		
		$sms_text = wp_listings_directory_get_option('phone_approve_sms_text');
		$placeholders = array(
			'[otp]'		=> $otp,
		);
		foreach ( $placeholders as $placeholder => $placeholder_value ) {
			$sms_text = str_replace( $placeholder , $placeholder_value , $sms_text );
		}

		$sms_text = apply_filters( 'wp_listings_directory_phone_sms_text',$sms_text );

		return $sms_text;
	}

	/**
	 * Removing users & doing the cleanup
	*/
	public static function cleanup(){

		$last_cleanup = (int) get_option( 'wp_listings_directory_last_cleanup', true );

		$now = time();

		//Check if cleanup was done 24 hours ago
		if( ( $now - $last_cleanup ) < ( apply_filters( 'wp_listings_directory_cleanup_last_done', 24 ) * 1 ) ){
			return;
		}

		$users = self::get_otp_users();

		if( empty( $users ) ) return;

		foreach ( $users as $ip_address => $user ) {
			//If user updated less than 10 mins ago, skip
			if( ( $now - $user[ 'last_updated' ] ) < 600 ) continue;
			unset( $users[ $ip_address ] ); // remove ip address
		}

		update_option( 'wp_listings_directory_otp_users', $users );
		update_option( 'wp_listings_directory_last_cleanup', $now );

	}
}

WP_Listings_Directory_SMS_Otp_Handler::get_instance();