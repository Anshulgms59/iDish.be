<?php
defined('ABSPATH') or die("Cheating........Uh!!");
/**
 * File contains the functions necessary for Social Login functionality
 */

/**
 * Render Social Login icons HTML
 */
function the_champ_login_button($widget = false){
	if(!is_user_logged_in() && the_champ_social_login_enabled()){
		global $theChampLoginOptions;
		$html = '';
		$customInterface = apply_filters('the_champ_login_interface_filter', '', $theChampLoginOptions, $widget);
		if($customInterface != ''){
			$html = $customInterface;
		}elseif(isset($theChampLoginOptions['providers']) && is_array($theChampLoginOptions['providers']) && count($theChampLoginOptions['providers']) > 0){
			$html = the_champ_login_notifications($theChampLoginOptions);
			if(!$widget){
				$html .= '<div class="the_champ_outer_login_container">';
				if(isset($theChampLoginOptions['title']) && $theChampLoginOptions['title'] != ''){
					$html .= '<div class="the_champ_social_login_title">'. $theChampLoginOptions['title'] .'</div>';
				}
			}
			$html .= '<div class="the_champ_login_container">';
			$gdprOptIn = '';
			if(isset($theChampLoginOptions['gdpr_enable'])){
				$gdprOptIn = '<div class="heateor_ss_sl_optin_container"><label><input type="checkbox" class="heateor_ss_social_login_optin" value="1" />'. str_replace(array($theChampLoginOptions['ppu_placeholder'], $theChampLoginOptions['tc_placeholder']), array('<a href="'. $theChampLoginOptions['privacy_policy_url'] .'" target="_blank">'. $theChampLoginOptions['ppu_placeholder'] .'</a>', '<a href="'. $theChampLoginOptions['tc_url'] .'" target="_blank">'. $theChampLoginOptions['tc_placeholder'] .'</a>'), wp_strip_all_tags($theChampLoginOptions['privacy_policy_optin_text'])) .'</label></div>';
			}
			if(isset($theChampLoginOptions['gdpr_enable']) && $theChampLoginOptions['gdpr_placement'] == 'above'){
				$html .= $gdprOptIn;
			}
			$html .= '<ul class="the_champ_login_ul">';
			if(isset($theChampLoginOptions['providers']) && is_array($theChampLoginOptions['providers']) && count($theChampLoginOptions['providers']) > 0){
				foreach($theChampLoginOptions['providers'] as $provider){
					$html .= '<li><i ';
					// id
					if($provider == 'google'){
						$html .= 'id="theChamp'. ucfirst($provider) .'Button" ';
					}
					// class
					$html .= 'class="theChampLogin theChamp'. ucfirst($provider) .'Background theChamp'. ucfirst($provider) .'Login" ';
					$html .= 'alt="Login with ';
					$html .= ucfirst($provider);
					$html .= '" title="Login with ';
					$html .= ucfirst($provider);
					if(current_filter() == 'comment_form_top' || current_filter() == 'comment_form_must_log_in_after'){
						$html .= '" onclick="theChampCommentFormLogin = true; theChampInitiateLogin(this, \''. $provider .'\')" >';
					}else{
						$html .= '" onclick="theChampInitiateLogin(this, \''. $provider .'\')" >';
					}
					if($provider == 'facebook'){
						$html .= '<div class="theChampFacebookLogoContainer">';
					}
					$html .= '<ss style="display:block" class="theChampLoginSvg theChamp'. ucfirst($provider) .'LoginSvg"></ss>';
					if($provider == 'facebook'){
						$html .= '</div>';
					}
					$html .= '</i></li>';
				}
			}
			$html .= '</ul>';
			if(isset($theChampLoginOptions['gdpr_enable']) && $theChampLoginOptions['gdpr_placement'] == 'below'){
				$html .= '<div style="clear:both"></div>';
				$html .= $gdprOptIn;
			}
			$html .= '</div>';
			if(!$widget){
				$html .= '</div><div style="clear:both; margin-bottom: 6px"></div>';
			}
		}
		if(!$widget){
			global $heateorSsAllowedTags;
			echo wp_kses($html, $heateorSsAllowedTags);
		}else{
			return $html;
		}
	}
}

// enable FB login at login, register and comment form
if(isset($theChampLoginOptions['enableAtLogin']) && $theChampLoginOptions['enableAtLogin'] == 1){
	add_action('login_form', 'the_champ_login_button');
	add_action('bp_before_sidebar_login_form', 'the_champ_login_button');
}
if(isset($theChampLoginOptions['enableAtRegister']) && $theChampLoginOptions['enableAtRegister'] == 1){
	add_action('register_form', 'the_champ_login_button');
	add_action('after_signup_form', 'the_champ_login_button');
	add_action('bp_before_account_details_fields', 'the_champ_login_button'); 
}
if(isset($theChampLoginOptions['enableAtComment']) && $theChampLoginOptions['enableAtComment'] == 1){
	global $user_ID;
	if(get_option('comment_registration') && intval($user_ID) == 0){
		add_action('comment_form_must_log_in_after', 'the_champ_login_button'); 
	}else{
		add_action('comment_form_top', 'the_champ_login_button');
	}
}
if(isset($theChampLoginOptions['enable_before_wc'])){
	add_action('woocommerce_before_customer_login_form', 'the_champ_login_button');
}
if(isset($theChampLoginOptions['enable_after_wc'])){
	add_action('woocommerce_login_form', 'the_champ_login_button');
}
if(isset($theChampLoginOptions['enable_register_wc'])){
	add_action('woocommerce_register_form', 'the_champ_login_button');
}
if(isset($theChampLoginOptions['enable_wc_checkout']) && $theChampLoginOptions['enable_wc_checkout'] == 1){
	add_action('woocommerce_checkout_before_customer_details', 'the_champ_login_button');
	// for Astra theme
	add_action('astra_checkout_login_field_before', 'the_champ_login_button');
}

/**
 * Get url of the image after saving it locally 
 */
function heateor_ss_save_social_avatar($url = NULL, $name = NULL){
    $url = stripslashes($url);
    if(!filter_var($url, FILTER_VALIDATE_URL))
        return false;
    if(empty($name))
        $name = basename($url);
    $dir = wp_upload_dir();
    try{
        $image = wp_remote_get($url, array(
            'timeout' => 15
        ));
        if(!is_wp_error($image) && isset($image['response']['code']) && 200 === $image['response']['code']){
            $imageContent   = wp_remote_retrieve_body($image);
            $imageType      = isset($image['headers']) && isset($image['headers']['content-type']) ? $image['headers']['content-type'] : '';
            $imageTypeParts = array();
            $extension      = '';
            if($imageType){
                $imageTypeParts = explode('/', $imageType);
                $extension      = $imageTypeParts[1];
            }
            if(!is_string($imageContent) || empty($imageContent)){
                return false;
            }
            if(!is_dir($dir['basedir'] . '/heateor')){
	            wp_mkdir_p($dir['basedir'] . '/heateor');
	        }
            $save = file_put_contents($dir['basedir'] . '/heateor/' . $name . '.' . $extension, $imageContent);
            if(!$save){
                return false;
            }
            return $dir['baseurl'] .'/heateor/'. $name .'.'. $extension;
        }
        return false;
    }catch(Exception $e){
        return false;
    }
}

/**
 * Login user to Wordpress
 */
function the_champ_login_user($userId, $profileData = array(), $socialId = '', $update = false){
	$userApprovalStatus = get_user_meta($userId, 'pw_user_status', true);
	if($userApprovalStatus == 'denied' || $userApprovalStatus == 'pending'){
		return $userApprovalStatus;
	}
	$user = get_user_by('id', $userId);
	if($update && !get_user_meta($userId, 'thechamp_dontupdate_avatar', true)){
		if($profileData['provider'] == 'facebook'){
			$dir = wp_upload_dir();
		 	if(!file_exists($dir['basedir'] . '/heateor/' . $profileData['id'] . '.jpeg')){
		        update_user_meta($userId, 'thechamp_avatar', '');
		    }
		    if(!file_exists($dir['basedir'] . '/heateor/' . $profileData['id'] . '_large.jpeg')){
		        update_user_meta($userId, 'thechamp_large_avatar', '');
		    }
		}else{
			global $theChampLoginOptions;
			if(isset($profileData['avatar']) && $profileData['avatar'] != ''){
				if($profileData['provider'] == 'linkedin' || isset($theChampLoginOptions['save_avatar'])){
					$localAvatarUrl = heateor_ss_save_social_avatar($profileData['avatar'], $profileData['id']);
					if($localAvatarUrl){
						update_user_meta($userId, 'thechamp_avatar', $localAvatarUrl);
					}
				}else{
					update_user_meta($userId, 'thechamp_avatar', $profileData['avatar']);
				}
			}
			if(isset($profileData['large_avatar']) && $profileData['large_avatar'] != ''){
				if($profileData['provider'] == 'linkedin' || isset($theChampLoginOptions['save_avatar'])){
					$localLargeAvatarUrl = heateor_ss_save_social_avatar($profileData['large_avatar'], $profileData['id'] . '_large');
					if($localLargeAvatarUrl){
						update_user_meta($userId, 'thechamp_large_avatar', $localLargeAvatarUrl);
					}
				}else{
					update_user_meta($userId, 'thechamp_large_avatar', $profileData['large_avatar']);
				}
			}
		}
	}
	if($socialId != ''){
		update_user_meta($userId, 'thechamp_current_id', $socialId);
	}
	global $theChampIsBpActive;
	if(isset($theChampLoginOptions['gdpr_enable'])){
		update_user_meta($userId, 'thechamp_gdpr_consent', 'yes');
	}
	do_action('the_champ_login_user', $userId, $profileData, $socialId, $update);
	
	// register Buddypress activity
	if($theChampIsBpActive){
		$activityId = bp_activity_add(array(
			'id' => '',
			'action' => $user->user_login . ' used social login',
			'content' => '',
			'component' => 'heateor-social-login',
			'type' => 'Social Login',
			'primary_link' => '',
			'user_id' => $userId
		));
	}

	clean_user_cache($user->ID);
	wp_clear_auth_cookie();
	wp_set_current_user($userId, $user->user_login);
	wp_set_auth_cookie($userId, true);
	update_user_caches($user);

	do_action('wp_login', $user->user_login, $user);
}

/**
 * Create username
 */
function the_champ_create_username($profileData){
	global $theChampLoginOptions;
	$username = "";
	$firstName = "";
	$lastName = "";
	if(isset($theChampLoginOptions['username_email']) && isset($profileData['email']) && $profileData['email'] != ''){
		$username = $profileData['email'];
	}elseif(isset($theChampLoginOptions['email_username']) && isset($profileData['email']) && $profileData['email'] != ''){
		$tempUsername = explode('@', $profileData['email']);
		$username = $tempUsername[0];
	}elseif(!empty($profileData['username'])){
		$username = $profileData['username'];
	}
	if(!empty($profileData['first_name']) && !empty($profileData['last_name'])){
		$username = !$username ? $profileData['first_name'] . ' ' . $profileData['last_name'] : $username;
		$firstName = $profileData['first_name'];
		$lastName = $profileData['last_name'];
	}elseif(!empty($profileData['name'])){
		$username = !$username ? $profileData['name'] : $username;
		$nameParts = explode(' ', $profileData['name']);
		if(count($nameParts) > 1){
			$firstName = $nameParts[0];
			$lastName = $nameParts[1];
		}else{
			$firstName = $profileData['name'];
		}
	}elseif(!empty($profileData['username'])){
		$firstName = $profileData['username'];
	}elseif(isset($profileData['email']) && $profileData['email'] != ''){
		$tempUsername = explode('@', $profileData['email']);
		if(!$username){
			$username = $tempUsername[0];
		}
		$firstName = str_replace("_", " ", $tempUsername[0]);
	}else{
		$username = !$username ? $profileData['id'] : $username;
		$firstName = $profileData['id'];
	}
	return $username."|tc|".$firstName."|tc|".$lastName;
}

/**
 * Create user in Wordpress database.
 */
function the_champ_create_user($profileData, $verification = false){
	// create username, firstname and lastname
	$usernameFirstnameLastname = explode('|tc|', the_champ_create_username($profileData));
	$username = $usernameFirstnameLastname[0];
	$firstName = $usernameFirstnameLastname[1];
	$lastName = $usernameFirstnameLastname[2];
	// make username unique
	$nameexists = true;
	$index = 1;
	global $theChampLoginOptions;
	if ($theChampLoginOptions['username_separator'] == 'dash') {
		$separator = '-';
	}elseif($theChampLoginOptions['username_separator'] == 'underscore'){
		$separator = '_';
	}elseif($theChampLoginOptions['username_separator'] == 'dot'){
		$separator = '.';
	}elseif($theChampLoginOptions['username_separator'] == 'none'){
		$separator = '';
	}
	$username = str_replace(' ', $separator, $username);
	
	//cyrillic username
	$username = sanitize_user($username, true);
	if($username == '-'){
		$emailParts = explode('@', $profileData['email']);
		$username = $emailParts[0];
	}

	$userName = $username;
	while($nameexists == true){
		if(username_exists($userName) != 0){
			$index++;
			$userName = $username.$index;
		}else{
			$nameexists = false;
		}
	}
	$username = $userName;
	$password = wp_generate_password();
	
	$userdata = array(
		'user_login' => $username,
		'user_pass' => $password,
		'user_nicename' => sanitize_user($firstName, true),
		'user_email' => $profileData['email'],
		'display_name' => $firstName,
		'nickname' => $firstName,
		'first_name' => $firstName,
		'last_name' => $lastName,
		'description' => isset($profileData['bio']) && $profileData['bio'] != '' ? $profileData['bio'] : '',
		'user_url' => $profileData['provider'] != 'facebook' && isset($profileData['link']) && $profileData['link'] != '' ? $profileData['link'] : '',
		'role' => get_option('default_role')
	);
	if(heateor_ss_is_plugin_active('buddypress/bp-loader.php')){
		$userdata = array(
			'user_login' => $username,
			'user_pass' => $password,
			'user_nicename' => $username,
			'user_email' => $profileData['email'],
			'display_name' => $profileData['name'],
			'nickname' => $username,
			'first_name' => $firstName,
			'last_name' => $lastName,
			'description' => isset($profileData['bio']) && $profileData['bio'] != '' ? $profileData['bio'] : '',
			'user_url' => $profileData['provider'] != 'facebook' && isset($profileData['link']) && $profileData['link'] != '' ? $profileData['link'] : '',
			'role' => get_option('default_role')
		);
	}
	if(heateor_ss_is_plugin_active('theme-my-login/theme-my-login.php')){
		$tmlOptions = get_option('theme_my_login');
		$tmlLoginType = isset($tmlOptions['login_type']) ? $tmlOptions['login_type'] : '';
		if($tmlLoginType == 'email'){
			$userdata = array(
				'user_login' => $profileData['email'],
				'user_pass' => $password,
				'user_nicename' => $profileData['email'],
				'user_email' => $profileData['email'],
				'display_name' => $profileData['email'],
				'nickname' => $profileData['email'],
				'first_name' => $firstName,
				'last_name' => $lastName,
				'description' => isset($profileData['bio']) && $profileData['bio'] != '' ? $profileData['bio'] : '',
				'user_url' => $profileData['provider'] != 'facebook' && isset($profileData['link']) && $profileData['link'] != '' ? $profileData['link'] : '',
				'role' => get_option('default_role')
			);
		}
	}

	$userId = wp_insert_user($userdata);
	if(!is_wp_error($userId)){
		if(isset($profileData['id']) && $profileData['id'] != ''){
			update_user_meta($userId, 'thechamp_social_id', $profileData['id']);
		}
		if(isset($profileData['avatar']) && $profileData['avatar'] != ''){
			update_user_meta($userId, 'thechamp_avatar', $profileData['avatar']);
		}
		if(isset($profileData['large_avatar']) && $profileData['large_avatar'] != ''){
			update_user_meta($userId, 'thechamp_large_avatar', $profileData['large_avatar']);
		}
		if(!empty($profileData['provider'])){
			update_user_meta($userId, 'thechamp_provider', $profileData['provider']);
		}

		if(!isset($theChampLoginOptions['double_optin'])){
			// send notification email
			heateor_ss_new_user_notification($userId);
		}
		
		// insert Name in BP XProfile table
		global $theChampIsBpActive;
		if($theChampIsBpActive){
			xprofile_set_field_data('Name', $userId, $userdata['first_name'] . ' ' . $userdata['last_name']);
		}

		// hook - user successfully created
		do_action('the_champ_user_successfully_created', $userId, $userdata, $profileData);

		// double opt-in
		if(isset($theChampLoginOptions['double_optin'])){
			$verificationKey = $userId.time().mt_rand();
			update_user_meta($userId, 'thechamp_key', $verificationKey);
			update_user_meta($userId, 'thechamp_social_registration', 1);
			
			// send email
			$subject = "[".wp_specialchars_decode(trim(get_option('blogname')), ENT_QUOTES)."] " . __('Account Verification', 'super-socializer');
			$url = esc_url_raw(home_url())."?SuperSocializerKey=".$verificationKey;
			$message = __("Please click on the following link or paste it in browser to verify your account", 'super-socializer') . "\r\n" . $url;
			wp_mail($profileData['email'], $subject, $message);
			wp_redirect(esc_url(home_url()).'?SuperSocializerUnverified=1');
			die;
		}

		return $userId;
	}
	return false;
}

/**
 * Replace default avatar with social avatar
 */
function the_champ_social_avatar($avatar, $avuser, $size, $default, $alt = ''){
	global $theChampLoginOptions;
	if(isset($theChampLoginOptions['enable']) && isset($theChampLoginOptions['avatar'])){
		global $pagenow;
		if(is_admin() && $pagenow == "options-discussion.php"){
			return $avatar;
		}
		if(isset($theChampLoginOptions['avatar_quality']) && $theChampLoginOptions['avatar_quality'] == 'better'){
			$avatarType = 'thechamp_large_avatar';
		}else{
			$avatarType = 'thechamp_avatar';
		}
		$userId = 0;
		if(is_numeric($avuser)){
			if($avuser > 0){
				$userId = $avuser;
			}
		}elseif(is_object($avuser)){
			if(property_exists($avuser, 'user_id') AND is_numeric($avuser->user_id)){
				$userId = $avuser->user_id;
			}
		}elseif(is_email($avuser)){
			$user = get_user_by('email', $avuser);
			$userId = isset($user->ID) ? $user->ID : 0;
		}
		if($userId > 0){
			if($avatarType == 'thechamp_large_avatar' && get_user_meta($userId, $avatarType, true) == ''){
				$avatarType = 'thechamp_avatar';
			}
			if(($userAvatar = get_user_meta($userId, $avatarType, true)) !== false && strlen(trim($userAvatar)) > 0){
				return '<img alt="' . esc_attr($alt) . '" src="' . $userAvatar . '" class="avatar avatar-' . $size . ' " height="' . $size . '" width="' . $size . '" style="height:'. $size .'px;width:'. $size .'px" />';
			}
		}
	}
	return $avatar;
}
add_filter('get_avatar', 'the_champ_social_avatar', 10, 5);
add_filter('bp_core_fetch_avatar', 'the_champ_buddypress_avatar', 10, 2);

/**
 * Replace default avatar url with the url of social avatar
 */
function heateor_ss_social_avatar_url($url, $idOrEmail, $args){
	global $theChampLoginOptions;
	if(isset($theChampLoginOptions['enable']) && isset($theChampLoginOptions['avatar'])){
		if(isset($theChampLoginOptions['avatar_quality']) && $theChampLoginOptions['avatar_quality'] == 'better'){
			$avatarType = 'thechamp_large_avatar';
		}else{
			$avatarType = 'thechamp_avatar';
		}
		$userId = 0;
		if(is_numeric($idOrEmail)){
			$user = get_userdata($idOrEmail);
			if($idOrEmail > 0){
				$userId = $idOrEmail;
			}
		}elseif(is_object($idOrEmail)){
			if(property_exists($idOrEmail, 'user_id') AND is_numeric($idOrEmail->user_id)){
				$userId = $idOrEmail->user_id;
			}
		}elseif(is_email($idOrEmail)){
			$user = get_user_by('email', $idOrEmail);
			$userId = isset($user->ID) ? $user->ID : 0;
		}

		if($avatarType == 'thechamp_large_avatar' && get_user_meta($userId, $avatarType, true) == ''){
			$avatarType = 'thechamp_avatar';
		}
		if(!empty($userId) && ($userAvatar = get_user_meta($userId, $avatarType, true)) !== false && strlen(trim($userAvatar)) > 0){
			return $userAvatar;
		}
	}
	return $url;
}
add_filter('get_avatar_url', 'heateor_ss_social_avatar_url', 10, 3);

/**
 * Enable social avatar in Buddypress
 */
function the_champ_buddypress_avatar($text, $args){
	global $theChampLoginOptions;
	if(isset($theChampLoginOptions['enable']) && isset($theChampLoginOptions['avatar'])){
		if(is_array($args)){
			if(!empty($args['object']) && strtolower($args['object']) == 'user'){
				if(!empty($args['item_id']) && is_numeric($args['item_id'])){
					if(($userData = get_userdata($args['item_id'])) !== false){
						if(isset($theChampLoginOptions['avatar_quality']) && $theChampLoginOptions['avatar_quality'] == 'better'){
							$avatarType = 'thechamp_large_avatar';
						}else{
							$avatarType = 'thechamp_avatar';
						}
						if($avatarType == 'thechamp_large_avatar' && get_user_meta($args['item_id'], $avatarType, true) == ''){
							$avatarType = 'thechamp_avatar';
						}
						$avatar = '';
						if(($userAvatar = get_user_meta($args['item_id'], $avatarType, true)) !== false && strlen(trim($userAvatar)) > 0){
							$avatar = $userAvatar;
						}
						if($avatar != ""){
								$imgAlt = (!empty($args['alt']) ? 'alt="'.esc_attr($args['alt']).'" ' : '');
								$imgAlt = sprintf($imgAlt, htmlspecialchars($userData->user_login));
								$imgClass = ('class="'.(!empty ($args['class']) ? ($args['class'].' ') : '').'avatar-social-login" ');
								$imgWidth = (!empty ($args['width']) ? 'width="'.$args['width'].'" ' : 'width="50"');
								$imgHeight = (!empty ($args['height']) ? 'height="'.$args['height'].'" ' : 'height="50"');
								$text = preg_replace('#<img[^>]+>#i', '<img src="'.$avatar.'" '.$imgAlt.$imgClass.$imgHeight.$imgWidth.' style="float:left; margin-right:10px" />', $text);
						}
					}
				}
			}
		}
	}
	return $text;
}

/**
 * Format social profile data
 */
function the_champ_sanitize_profile_data($profileData, $provider){
	$temp = array();
	if($provider == 'facebook'){
		$temp['id'] = isset($profileData->id) ? sanitize_text_field($profileData->id) : '';
	 	$temp['email'] = isset($profileData->email) ? sanitize_email($profileData->email) : '';
		$temp['name'] = isset($profileData->name) ? $profileData->name : '';
		$temp['username'] = '';
		$temp['first_name'] = isset($profileData->first_name) ? $profileData->first_name : '';
		$temp['last_name'] = isset($profileData->last_name) ? $profileData->last_name : '';
		$temp['bio'] = '';
		$temp['link'] = '';
		$temp['avatar'] = plugins_url('../images/login/mystery-man-64.png', __FILE__);
		$temp['large_avatar'] = plugins_url('../images/login/mystery-man-256.png', __FILE__);
	}elseif($provider == 'twitter'){
		$temp['id'] = isset($profileData->id) ? sanitize_text_field($profileData->id) : '';
	 	$temp['email'] = isset($profileData->email) ? sanitize_email($profileData->email) : '';
		$temp['name'] = isset($profileData->name) ? $profileData->name : '';
		if(isset($profileData->screen_name)){
			$temp['username'] = $profileData->screen_name;
		}elseif(isset($profileData->username)){
			$temp['username'] = $profileData->username;
		}else{
			$temp['username'] = '';
		}
		$temp['first_name'] = '';
		$temp['last_name'] = '';
		$temp['bio'] = isset($profileData->description) ? sanitize_text_field($profileData->description) : '';
		$temp['link'] = isset($profileData->url) && heateor_ss_validate_url($profileData->url) ? trim($profileData->url) : '';
		$temp['avatar'] = isset($profileData->profile_image_url) && heateor_ss_validate_url($profileData->profile_image_url) !== false ? trim($profileData->profile_image_url) : '';
		$temp['large_avatar'] = $temp['avatar'] != '' ? str_replace('_normal', '', $temp['avatar']) : '';
	}elseif($provider == 'steam'){
		$temp['id'] = isset($profileData->steamid) ? sanitize_text_field($profileData->steamid) : '';
	 	$temp['email'] = '';
		$temp['name'] = isset($profileData->realname) ? $profileData->realname : '';
		$temp['username'] = isset($profileData->personaname) ? $profileData->personaname : '';
		$temp['first_name'] = '';
		$temp['last_name'] = '';
		$temp['bio'] = '';
		$temp['link'] = isset($profileData->profileurl) ? $profileData->profileurl : '';
		$temp['avatar'] = isset($profileData->avatarmedium) && heateor_ss_validate_url($profileData->avatarmedium) !== false ? $profileData->avatarmedium : '';
		$temp['large_avatar'] = isset($profileData->avatarfull) && heateor_ss_validate_url($profileData->avatarfull) !== false ? $profileData->avatarfull : '';
	}elseif($provider == 'linkedin'){
		if(is_object($profileData)){
			$temp['id']           = isset($profileData->sub) ? sanitize_text_field($profileData->sub) : '';
		    $temp['email']        = '';
		    if((isset($profileData->email_verified) && $profileData->email_verified == '1') || !isset($profileData->email_verified)){
		    	$temp['email']    = isset($profileData->email) ? sanitize_email($profileData->email) : '';
		    }
		    $temp['name']         = isset($profileData->name) ? $profileData->name : '';
		    $temp['username']     = '';
		    $temp['first_name']   = isset($profileData->given_name) ? $profileData->given_name : '';
		    $temp['last_name']    = isset($profileData->family_name) ? $profileData->family_name : '';
		    $temp['bio']          = '';
		    $temp['link']         = '';
		    $temp['large_avatar'] = isset($profileData->picture) && heateor_ss_validate_url($profileData->picture) !== false ? trim($profileData->picture) : '';
		    $temp['avatar']       = $temp['large_avatar'];
		}else{
			$temp['id'] = isset($profileData['id']) ? sanitize_text_field($profileData['id']) : '';
			$temp['email'] = isset($profileData['email']) ? sanitize_email($profileData['email']) : '';
			$temp['name'] = '';
			$temp['username'] = '';
			$temp['first_name'] = isset($profileData['firstName']) ? $profileData['firstName'] : '';
			$temp['last_name'] = isset($profileData['lastName']) ? $profileData['lastName'] : '';
			$temp['bio'] = '';
			$temp['link'] = '';
			$temp['avatar'] = isset($profileData['smallAvatar']) && heateor_ss_validate_url($profileData['smallAvatar']) !== false ? trim($profileData['smallAvatar']) : '';
			$temp['large_avatar'] = isset($profileData['largeAvatar']) && heateor_ss_validate_url($profileData['largeAvatar']) !== false ? trim($profileData['largeAvatar']) : '';
		}
	}elseif($provider == 'google'){
		$temp['id'] = isset($profileData->sub) ? sanitize_text_field($profileData->sub) : '';
		$temp['email'] = '';
		if((isset($profileData->email_verified) && $profileData->email_verified == 1) || !isset($profileData->email_verified)){
			$temp['email'] = isset($profileData->email) ? sanitize_email($profileData->email) : '';
		}
		$temp['name'] = isset($profileData->name) ? $profileData->name : '';
		$temp['username'] = '';
		$temp['first_name'] = isset($profileData->givenName) ? $profileData->givenName : '';
		$temp['last_name'] = isset($profileData->familyName) ? $profileData->familyName : '';
		$temp['bio'] = '';
		$temp['link'] = isset($profileData->link) && heateor_ss_validate_url(trim($profileData->link)) !== false ? trim($profileData->link) : '';
		$temp['large_avatar'] = isset($profileData->picture) && heateor_ss_validate_url($profileData->picture) !== false ? trim($profileData->picture) : '';
		$temp['avatar'] = $temp['large_avatar'] != '' ? $temp['large_avatar'] . '?sz=50' : '';
	}elseif($provider == 'youtube'){
		if(isset($profileData->items) && isset($profileData->items[0])){
			$tempProfileData = $profileData->items[0];
		}else{
			$tempProfileData = $profileData;
		}
		if(isset($tempProfileData->id)){
			$temp['id'] = sanitize_text_field($tempProfileData->id);
		}elseif(isset($tempProfileData->etag)){
			$temp['id'] = sanitize_text_field($tempProfileData->etag);
		}else{
			$temp['id'] = '';
		}
		$temp['email'] = '';
		if((isset($tempProfileData->email_verified) && $tempProfileData->email_verified == 'true') || !isset($tempProfileData->email_verified)){
			$temp['email'] = isset($tempProfileData->email) ? sanitize_email($tempProfileData->email) : '';
		}
		$temp['name'] = isset($tempProfileData->snippet) && isset($tempProfileData->snippet->title) ? $tempProfileData->snippet->title : '';
		$temp['username'] = '';
		$temp['first_name'] = '';
		$temp['last_name'] = '';
		$temp['bio'] = isset($tempProfileData->snippet) && isset($tempProfileData->snippet->description) ? $tempProfileData->snippet->description : '';
		$temp['link'] = '';
		$temp['large_avatar'] = isset($tempProfileData->snippet) && isset($tempProfileData->snippet->thumbnails) && isset($tempProfileData->snippet->thumbnails->medium) && isset($tempProfileData->snippet->thumbnails->medium->url) && heateor_ss_validate_url($tempProfileData->snippet->thumbnails->medium->url) !== false ? trim($tempProfileData->snippet->thumbnails->medium->url) : '';
		if(isset($tempProfileData->snippet) && isset($tempProfileData->snippet->thumbnails) && isset($tempProfileData->snippet->thumbnails->default) && isset($tempProfileData->snippet->thumbnails->default->url) && heateor_ss_validate_url($tempProfileData->snippet->thumbnails->default->url) !== false){
			$temp['avatar'] = trim($tempProfileData->snippet->thumbnails->default->url);
		}elseif(isset($tempProfileData->picture) && heateor_ss_validate_url($tempProfileData->picture)){
			$temp['avatar'] = trim($tempProfileData->picture);
		}else{
			$temp['avatar'] = '';
		}
	}elseif($provider == 'vkontakte'){
		$temp['id'] = isset($profileData['id']) ? sanitize_text_field($profileData['id']) : '';
		$temp['email'] = '';
		if(isset($profileData['verified']) && $profileData['verified'] == 1 && isset($profileData['email']) && $profileData['email'] != ''){
	    	$temp['email'] = sanitize_email($profileData['email']);
	    }
		$temp['name'] = '';
		$temp['username'] = isset($profileData['screen_name']) ? $profileData['screen_name'] : '';
		$temp['first_name'] = isset($profileData['first_name']) ? $profileData['first_name'] : '';
		$temp['last_name'] = isset($profileData['last_name']) ? $profileData['last_name'] : '';
		$temp['bio'] = '';
		$temp['link'] = $temp['id'] != '' ? 'https://vk.com/id' . $temp['id'] : '';
		$temp['avatar'] = isset($profileData['photo_rec']) && heateor_ss_validate_url($profileData['photo_rec']) !== false ? trim($profileData['photo_rec']) : '';
		$temp['large_avatar'] = isset($profileData['photo_big']) && heateor_ss_validate_url($profileData['photo_big']) !== false ? trim($profileData['photo_big']) : '';
	}elseif($provider == 'instagram'){
		$temp['id'] = isset($profileData->id) ? sanitize_text_field($profileData->id) : '';
		$temp['email'] = '';
		$temp['name'] = '';
		$temp['username'] = isset($profileData->username) ? $profileData->username : '';
		$temp['first_name'] = '';
		$temp['last_name'] = '';
		$temp['bio'] = '';
		$temp['link'] = '';
		$temp['avatar'] = '';
		$temp['large_avatar'] = '';
		$temp['ig_id'] = isset($profileData->ig_id) ? sanitize_text_field($profileData->ig_id) : '';
	}elseif($provider == 'mailru'){
		$temp['id'] = isset($profileData->id) ? sanitize_text_field($profileData->id) : '';
		$temp['email'] = isset($profileData->email) ? sanitize_email($profileData->email) : '';
		$temp['name'] = isset($profileData->name) ? $profileData->name : '';
		$temp['username'] =  '';
		$temp['first_name'] = isset($profileData->first_name) ? $profileData->first_name : '';
		$temp['last_name'] = isset($profileData->last_name) ? $profileData->last_name : '';
		$temp['bio'] = '';
		$temp['link'] = '';
		$temp['avatar'] = isset($profileData->image) && heateor_ss_validate_url($profileData->image) !== false ? trim($profileData->image) : '';
		$temp['large_avatar'] = '';
	}elseif($provider == 'line'){
		$temp['email'] = isset($profileData->email) && $profileData->email ? sanitize_email($profileData->email) : '';
		$temp['bio'] = '';
		$temp['username'] = '';
		$temp['link'] = '';
		$temp['avatar'] = isset($profileData->picture) && heateor_ss_validate_url($profileData->picture) !== false ? trim($profileData->picture) : '';
		$temp['name'] = $profileData->name;
		$temp['first_name'] = '';
		$temp['last_name'] = '';
		$temp['id'] = isset($profileData->sub) ? sanitize_text_field($profileData->sub) : '';
		$temp['large_avatar'] = isset($profileData->picture) && heateor_ss_validate_url($profileData->picture) !== false ? trim($profileData->picture) : '';
	}elseif($provider == 'microsoft'){
		$temp['email'] = isset($profileData->emails) && isset($profileData->emails->account) ? sanitize_email($profileData->emails->account) : '';
		$temp['bio'] = '';
		$temp['username'] = '';
		$temp['link'] = '';
		$temp['avatar'] = '';
		$temp['name'] =  isset($profileData->name) ? sanitize_text_field($profileData->name) : '';
		$temp['first_name'] = isset($profileData->first_name) ? sanitize_text_field($profileData->first_name) : '';
		$temp['last_name'] = isset($profileData->last_name) ? sanitize_text_field($profileData->last_name) : '';
		$temp['id'] = isset($profileData->id) ? sanitize_text_field($profileData->id) : '';
		$temp['large_avatar'] = '';
	}elseif($provider == 'wordpress'){
		$temp['email'] = '';
		if((isset($profileData->email_verified) && $profileData->email_verified == 1) || !isset($profileData->email_verified)){
			$temp['email'] = !empty($profileData->email) ? sanitize_email($profileData->email) : '';
		}
		$temp['bio'] = '';
		$temp['username'] = isset($profileData->username) ? sanitize_text_field($profileData->username) : '';
		$temp['link'] = isset($profileData->primary_blog_url) && heateor_ss_validate_url($profileData->primary_blog_url) !== false ? trim($profileData->primary_blog_url) : '';
		$temp['avatar'] = isset($profileData->avatar_URL) && heateor_ss_validate_url($profileData->avatar_URL) !== false ? trim($profileData->avatar_URL) : '';
		$temp['name'] = '';
		$temp['first_name'] = '';
		$temp['last_name'] = '';
		$temp['id'] = isset($profileData->ID) ? sanitize_text_field($profileData->ID) : '';
		$temp['large_avatar'] = '';
	}elseif($provider == 'yahoo'){
		$temp['email'] = '';
		if((isset($profileData->email_verified) && $profileData->email_verified == 1) || !isset($profileData->email_verified)){
			$temp['email'] = !empty($profileData->email) ? sanitize_email($profileData->email) : '';
		}
		$temp['bio'] = '';
		$temp['username'] = isset($profileData->nickname) ? sanitize_text_field($profileData->nickname) : '';
		$temp['link'] = '';
		$temp['name'] =  isset($profileData->name) ? sanitize_text_field($profileData->name) : '';
		$temp['first_name'] = isset($profileData->given_name) ? sanitize_text_field($profileData->given_name) : '';
		$temp['last_name'] = isset($profileData->family_name) ? sanitize_text_field($profileData->family_name) : '';
		$temp['id'] = isset($profileData->sub) ? sanitize_text_field($profileData->sub) : '';
		$temp['large_avatar'] = isset($profileData->profile_images->image192) && heateor_ss_validate_url($profileData->profile_images->image192) !== false ? trim($profileData->profile_images->image192) : '';
		$temp['avatar'] = isset($profileData->profile_images->image64) && heateor_ss_validate_url($profileData->profile_images->image64) !== false ? trim($profileData->profile_images->image64) : '';
	}elseif($provider == 'dribbble'){
		$temp['id'] = isset($profileData->id) ? sanitize_text_field($profileData->id) : '';
		$temp['email'] = '';
		$temp['name'] = isset($profileData->name) ? sanitize_text_field($profileData->name) : '';
		$temp['username'] = isset($profileData->login) ? sanitize_text_field($profileData->login) : '';
		$temp['first_name'] = '';
		$temp['last_name'] = '';
		$temp['bio'] = isset($profileData->bio) ? sanitize_text_field($profileData->bio) : '';
		$temp['link'] = isset($profileData->html_url) && heateor_ss_validate_url($profileData->html_url) !== false ? trim($profileData->html_url) : '';
		$temp['avatar'] = isset($profileData->avatar_url) && heateor_ss_validate_url($profileData->avatar_url) !== false ? trim($profileData->avatar_url) : '';
		$temp['large_avatar'] = '';
	}elseif($provider == 'github'){
		$temp['id'] = isset($profileData->id) ? sanitize_text_field($profileData->id) : '';
		$temp['email'] = isset($profileData->email) ? sanitize_email($profileData->email) : '';
		$temp['name'] = '';
		$temp['username'] = isset($profileData->login) ? sanitize_text_field($profileData->login) : '';
		$temp['first_name'] = '';
		$temp['last_name'] = '';
		$temp['bio'] = isset($profileData->bio) ? sanitize_text_field($profileData->bio) : '';
		$temp['link'] = isset($profileData->html_url) && heateor_ss_validate_url($profileData->html_url) !== false ? trim($profileData->html_url) : '';
		$temp['avatar'] = isset($profileData->avatar_url) && heateor_ss_validate_url($profileData->avatar_url) !== false ? trim($profileData->avatar_url) : '';
		$temp['large_avatar'] = '';
	}elseif($provider == 'spotify'){
		$temp['email'] = '';
		$temp['bio'] = '';
		$temp['username'] = isset($profileData->display_name) ? sanitize_text_field($profileData->display_name) : '';
		$temp['link'] = isset($profileData->external_urls) && isset($profileData->external_urls->spotify) && heateor_ss_validate_url($profileData->external_urls->spotify) !== false ? trim($profileData->external_urls->spotify) : '';
		$temp['avatar'] =  isset($profileData->images) && is_array($profileData->images) && isset($profileData->images[0]) && is_object($profileData->images[0]) && isset($profileData->images[0]->url) && heateor_ss_validate_url($profileData->images[0]->url) !== false ? trim($profileData->images[0]->url) : '';
		$temp['name'] = '';
		$temp['first_name'] = '';
		$temp['last_name'] = '';
		$temp['id'] = isset($profileData->id) ? sanitize_text_field($profileData->id) : '';
		$temp['large_avatar'] = '';
	}elseif($provider == 'kakao'){
		$temp['email'] = '';
		if(isset($profileData->kakao_account) && is_object($profileData->kakao_account) && $profileData->kakao_account->has_email == '1' && $profileData->kakao_account->is_email_valid == '1' && $profileData->kakao_account->is_email_verified == '1' && isset($profileData->kakao_account->email) && $profileData->kakao_account->email){
			$temp['email'] = sanitize_email($profileData->kakao_account->email);
		}
		$temp['bio'] = '';
		$temp['username'] = isset($profileData->properties) && isset($profileData->properties->nickname) && $profileData->properties->nickname ? sanitize_text_field($profileData->properties->nickname) : '';
		$temp['link'] = '';
		$temp['avatar'] = isset($profileData->properties) && isset($profileData->properties->thumbnail_image) && $profileData->properties->thumbnail_image && heateor_ss_validate_url($profileData->properties->thumbnail_image) !== false ? trim($profileData->properties->thumbnail_image) : '';
		$temp['name'] = '';
		$temp['first_name'] = '';
		$temp['last_name'] = '';
		$temp['id'] = isset($profileData->id) ? sanitize_text_field($profileData->id) : '';
		$temp['large_avatar'] = isset($profileData->properties) && isset($profileData->properties->profile_image) && $profileData->properties->profile_image && heateor_ss_validate_url($profileData->properties->profile_image) !== false ? trim($profileData->properties->profile_image) : '';
	}elseif($provider == 'twitch'){
	    $temp['email']        = isset($profileData->email) ? sanitize_email($profileData->email) : '';
	    $temp['bio']          = '';
	    $temp['username']     = isset($profileData->login) ? sanitize_text_field($profileData->login) : '';
	    $temp['link']         = $temp['username'] ? 'https://www.twitch.tv/' . $temp['username'] : '';
	    $temp['avatar']       = isset($profileData->profile_image_url) && heateor_ss_validate_url($profileData->profile_image_url) ? trim($profileData->profile_image_url) : '';
	    $temp['name']         = isset($profileData->display_name) ? sanitize_text_field($profileData->display_name) : '';
	    $temp['first_name']   = '';
	    $temp['last_name']    = '';
	    $temp['id']           = isset($profileData->id) ? sanitize_text_field($profileData->id) : '';
	    $temp['large_avatar'] = '';
	}elseif($provider == 'reddit'){
	    $temp['email']        = '';
	    $temp['bio']          = '';
	    $temp['username']     = isset($profileData->name) ? sanitize_text_field($profileData->name) : '';
	    $temp['link']         = '';
	    $temp['avatar']       = isset($profileData->icon_img) && heateor_ss_validate_url($profileData->icon_img) ? trim($profileData->icon_img) : '';
	    $temp['name']         = isset($profileData->name) ? sanitize_text_field($profileData->name) : '';
	    $temp['first_name']   = '';
	    $temp['last_name']    = '';
	    $temp['id']           = isset($profileData->id) ? sanitize_text_field($profileData->id) : '';
	    $temp['large_avatar'] = '';
	}elseif($provider == 'disqus'){
	    $temp['email']        = '';
	    $temp['bio']          = '';
	    $temp['username']     = '';
	    $temp['link']         = isset($profileData->response) && isset($profileData->response->profileUrl) && heateor_ss_validate_url($profileData->response->profileUrl) ? trim($profileData->response->profileUrl) : '';
	    $temp['avatar']       = isset($profileData->response) && isset($profileData->response->small) && isset($profileData->response->small->permalink) && heateor_ss_validate_url($profileData->response->small->permalink) ? trim($profileData->response->small->permalink) : '';
	    $temp['name']         = isset($profileData->response) && isset($profileData->response->name) ? sanitize_text_field($profileData->response->name) : '';
	    $temp['first_name']   = '';
	    $temp['last_name']    = '';
	    $temp['id']           = isset($profileData->response) && isset($profileData->response->id) ? sanitize_text_field($profileData->response->id) : '';
	    $temp['large_avatar'] = isset($profileData->response) && isset($profileData->response->large) && isset($profileData->response->large->permalink) && heateor_ss_validate_url($profileData->response->large->permalink) ? trim($profileData->response->large->permalink) : '';
	}elseif($provider == 'dropbox'){
	    $temp['email'] = '';
	    if(isset($profileData->email_verified) && $profileData->email_verified == 1 && !empty($profileData->email)){
	        $temp['email'] = sanitize_email($profileData->email);
	    }
	    $temp['bio']          = '';
	    $temp['username']     = isset($profileData->name) && isset($profileData->name->username) ? sanitize_text_field($profileData->name->username) : '';
	    $temp['link']         = '';
	    $temp['avatar']       = '';
	    $temp['name']         = isset($profileData->name) && isset($profileData->name->display_name) ? sanitize_text_field($profileData->name->display_name) : '';
	    $temp['first_name']   = isset($profileData->name) && isset($profileData->name->given_name) ? sanitize_text_field($profileData->name->given_name) : '';
	    $temp['last_name']    = isset($profileData->name) && isset($profileData->name->surname) ? sanitize_text_field($profileData->name->surname) : '';
	    $temp['id']           = isset($profileData->account_id) ? sanitize_text_field($profileData->account_id) : '';
	    $temp['large_avatar'] = '';
	}elseif($provider == 'foursquare'){
	    $temp['email'] = '';
	    if(isset($profileData->response) && isset($profileData->response->user) && isset($profileData->response->user->contact) && isset($profileData->response->user->contact->email) && isset($profileData->response->user->contact->verifiedPhone) && $profileData->response->user->contact->verifiedPhone == true){
	        $temp['email'] = sanitize_email($profileData->response->user->contact->email);
	    }
	    $temp['bio']          = '';
	    $temp['username']     = '';
	    $temp['link']         = isset($profileData->response) && isset($profileData->response->user) && isset($profileData->response->user->canonicalUrl) && heateor_ss_validate_url($profileData->response->user->canonicalUrl) ? trim($profileData->response->user->canonicalUrl) : '';
	    $temp['avatar']       = isset($profileData->response) && isset($profileData->response->user) && isset($profileData->response->user->photo) && isset($profileData->response->user->photo->prefix) && isset($profileData->response->user->photo->suffix) ? sanitize_text_field($profileData->response->user->photo->prefix) . "64x64" . sanitize_text_field($profileData->response->user->photo->suffix) : '';
	    $temp['name']         = '';
	    $temp['first_name']   = isset($profileData->response) && isset($profileData->response->user) && isset($profileData->response->user->firstName) ? $profileData->response->user->firstName : '';
	    $temp['last_name']    = isset($profileData->response) && isset($profileData->response->user) && isset($profileData->response->user->lastName) ? $profileData->response->user->lastName : '';
	    $temp['id']           = isset($profileData->response) && isset($profileData->response->user) && isset($profileData->response->user->id) ? sanitize_text_field($profileData->response->user->id) : '';
	    $temp['large_avatar'] = isset($profileData->response) && isset($profileData->response->user) && isset($profileData->response->user->photo) && isset($profileData->response->user->photo->prefix) && isset($profileData->response->user->photo->suffix) ? sanitize_text_field($profileData->response->user->photo->prefix) . "190x190" . sanitize_text_field($profileData->response->user->photo->suffix) : '';
	}elseif($provider == 'amazon'){
		$temp['id'] 			= isset($profileData->user_id) ? sanitize_text_field($profileData->user_id) : '';
		$temp['email'] 			= isset($profileData->email) ? sanitize_email($profileData->email) : '';
		$temp['name'] 			= isset($profileData->name) ? $profileData->name : '';
		$temp['username'] 		= '';
		$temp['first_name'] 	= '';
		$temp['last_name']  	= '';
		$temp['bio'] 			= '';
		$temp['link'] 			= '';
		$temp['avatar'] 		= '';
		$temp['large_avatar'] 	= '';
	}elseif($provider == 'stackoverflow'){
	    $temp['email'] 		  = '';
	    $temp['bio']          = '';
	    $temp['username']     = '';
	    $temp['link']         = isset($profileData->link) && heateor_ss_validate_url($profileData->link) ? trim($profileData->link) : '';
	    $temp['avatar']       = isset($profileData->profile_image) && heateor_ss_validate_url($profileData->profile_image) ? trim($profileData->profile_image) : '';
	    $temp['name']         = isset($profileData->display_name) ? $profileData->display_name : '';
	    $temp['first_name']   = '';
	    $temp['last_name']    = '';
	    $temp['id']           = isset($profileData->account_id) ? sanitize_text_field($profileData->account_id) : '';
	    $temp['large_avatar'] = '';
	}elseif($provider == 'yandex'){
	    $temp['email']        = isset($profileData->default_email) ? sanitize_email($profileData->default_email) : '';
	    $temp['bio']          = '';
	    $temp['username']     = '';
	    $temp['link']         = '';
	    $temp['avatar']       = 'https://avatars.mds.yandex.net/get-yapic/' . (isset($profileData->default_avatar_id) ? sanitize_text_field($profileData->default_avatar_id) : '') . '/islands-200';
	    $temp['name']         = isset($profileData->real_name) ? $profileData->real_name : '';
	    $temp['first_name']   = isset($profileData->first_name) ? $profileData->first_name : '';
	    $temp['last_name']    = isset($profileData->last_name) ? $profileData->last_name : '';
	    $temp['id']           = isset($profileData->id) ? sanitize_text_field($profileData->id) : '';
	    $temp['large_avatar'] =  '';
	}elseif($provider == 'odnoklassniki'){
	    $temp['email']        = isset($profileData->email) ? sanitize_email($profileData->email) : '';
	    $temp['bio']          = '';
	    $temp['username']     = '';
	    $temp['link']         = '';
	    $temp['avatar']       = isset($profileData->pic_1) && heateor_ss_validate_url($profileData->pic_1) ? trim($profileData->pic_1) : '';
	    $temp['name']         = isset($profileData->name) ? $profileData->name : '';
	    $temp['first_name']   = isset($profileData->first_name) ? $profileData->first_name : '';
	    $temp['last_name']    = isset($profileData->last_name) ? $profileData->last_name : '';
	    $temp['id']           = isset($profileData->uid) ? sanitize_text_field($profileData->uid) : '';
	    $temp['large_avatar'] = isset($profileData->pic_3) && heateor_ss_validate_url($profileData->pic_3) ? trim($profileData->pic_3) : '';
	}elseif($provider == 'discord'){
		$temp['id']           = isset($profileData->id) ? sanitize_text_field($profileData->id) : '';
		$temp['email']    = '';
	    if((isset($profileData->verified) && $profileData->verified == 'true') || !isset($profileData->verified)){
	        $temp['email']    = !empty($profileData->email) ? sanitize_email($profileData->email) : '';
	    }
	    $temp['bio']          = '';
	    $temp['username']     = isset($profileData->username) ? sanitize_text_field($profileData->username) : '';
	    $temp['link']         = '';
	    $temp['avatar']       = isset($profileData->avatar) ? "https://cdn.discordapp.com/avatars/". $temp['id'] ."/". sanitize_text_field($profileData->avatar) .".png" : '';
	    $temp['name']         = '';
	    $temp['first_name']   = '';
	    $temp['last_name']    = '';
	    $temp['large_avatar'] = '';
	}
	if($provider != 'steam'){
		$temp['avatar'] = str_replace('http://', '//', $temp['avatar']);
		$temp['large_avatar'] = str_replace('http://', '//', $temp['large_avatar']);
	}
	$temp = apply_filters('the_champ_hook_format_profile_data', $temp, $profileData, $provider);
	$temp['name'] = isset($temp['name'][0]) && ctype_upper($temp['name'][0]) ? ucfirst(sanitize_user($temp['name'], true)) : sanitize_user($temp['name'], true);
	$temp['username'] = isset($temp['username'][0]) && ctype_upper($temp['username'][0]) ? ucfirst(sanitize_user($temp['username'], true)) : sanitize_user($temp['username'], true);
	$temp['first_name'] = isset($temp['first_name'][0]) && ctype_upper($temp['first_name'][0]) ? ucfirst(sanitize_user($temp['first_name'], true)) : sanitize_user($temp['first_name'], true);
	$temp['last_name'] = isset($temp['last_name'][0]) && ctype_upper($temp['last_name'][0]) ? ucfirst(sanitize_user($temp['last_name'], true)) : sanitize_user($temp['last_name'], true);
	$temp['provider'] = $provider;
	return $temp;
}

/**
 * Check if user is an admin
 */
function heateor_ss_check_if_admin($userId){
	global $theChampLoginOptions;
	if(isset($theChampLoginOptions['disable_sl_admin'])){
		$user = get_userdata($userId);
		if(!empty($user) && is_array($user->roles)){
			if(in_array('administrator', $user->roles)){
				return true;
			}
		}
	}
	return false;
}

/**
 * User authentication after Social Login
 */
function the_champ_user_auth($profileData, $provider = 'facebook', $twitterRedirect = ''){
	global $theChampLoginOptions, $user_ID;
	// authenticate user
	// check if Social ID exists in database
	if($profileData['id'] == ''){
		return array('status' => false, 'message' => '');
	}
	
	$oldInstagramUsers = array();
	$oldInstagramUser = ($profileData['provider'] == 'instagram' && !empty($profileData['ig_id']));
	if($oldInstagramUser){
		$oldInstagramUsers = get_users('meta_key=thechamp_social_id&meta_value='.$profileData['ig_id']);
		$existingUser = $oldInstagramUsers;
	}
	if(($oldInstagramUser && count($oldInstagramUsers) == 0) || !$oldInstagramUser){
		$existingUsers = get_users('meta_key=thechamp_social_id&meta_value='.$profileData['id']);
		$existingUser = $existingUsers;
	}
	// login redirection url
	$loginUrl = '';
	if(isset($theChampLoginOptions['login_redirection']) && $theChampLoginOptions['login_redirection'] == 'bp_profile'){
		$loginUrl = 'bp';
	}
	if(count($existingUser) > 0){
		// user exists in the database
		if(isset($existingUser[0]->ID)){
			if(count($oldInstagramUsers) > 0){
				update_user_meta($existingUser[0]->ID, 'thechamp_social_id', $profileData['id']);
			}
			// check if account needs verification
			if(get_user_meta($existingUser[0]->ID, 'thechamp_key', true) != ''){
				if(!in_array($profileData['provider'], array('twitter', 'instagram', 'steam'))){
					if(is_user_logged_in()){
						wp_delete_user($existingUser[0]->ID);
						the_champ_link_account($socialId, $provider, $user_ID);
						return array('status' => true, 'message' => 'linked');
					}else{
						return array('status' => false, 'message' => 'unverified');
					}
				}
				if(is_user_logged_in()){
					wp_delete_user($existingUser[0]->ID);
					the_champ_link_account($profileData['id'], $profileData['provider'], $user_ID);
					the_champ_close_login_popup(admin_url() . '/profile.php');	//** may be BP profile/custom profile page/wp profile page
				}else{
					the_champ_close_login_popup(home_url().'?SuperSocializerUnverified=1');
				}
			}
			if(is_user_logged_in()){
				return array('status' => false, 'message' => 'not linked');
			}else{
				// return if social login is disabled for admin accounts
				if(heateor_ss_check_if_admin($existingUser[0]->ID)){
					return array('status' => false, 'message' => '');
				}
				// hook to update profile data
				do_action('the_champ_hook_update_profile_data', $existingUser[0]->ID, $profileData);
				// update Xprofile fields
				if(isset($theChampLoginOptions['xprofile_mapping']) && is_array($theChampLoginOptions['xprofile_mapping'])){
					foreach($theChampLoginOptions['xprofile_mapping'] as $key => $val){
						global $wpdb;
						$value = '';
						if(isset($profileData[$val])){
							$value = $profileData[$val];
						}
						if($value){
							$wpdb->update(
								$wpdb->prefix . 'bp_xprofile_data', 
								array(
									'value' => $value,
									'last_updated' => '',
								), 
								array(
									'field_id' => $wpdb->get_var($wpdb->prepare("SELECT id FROM " . $wpdb->prefix . "bp_xprofile_fields WHERE name = %s", $key)),
									'user_id' => $existingUser[0]->ID
								), 
								array(
									'%s',
									'%s' 
								),
								array(
									'%d',
									'%d' 
								)
							);
						}
					}
				}
				$error = the_champ_login_user($existingUser[0]->ID, $profileData, $profileData['id'], true);
				if(isset($error) && $error === 0){
					return array('status' => false, 'message' => 'inactive', 'url' => wp_login_url() . '?loggedout=true&hum=1');
				}elseif(isset($error) && ($error == 'pending' || $error == 'denied')){
					return array('status' => false, 'message' => 'inactive', 'url' => wp_login_url() . '?heateor_ua=' . $error);
				}elseif(get_user_meta($existingUser[0]->ID, 'thechamp_social_registration', true)){
					// if logging in first time after email verification
					delete_user_meta($existingUser[0]->ID, 'thechamp_social_registration');
					if(isset($theChampLoginOptions['register_redirection']) && $theChampLoginOptions['register_redirection'] == 'bp_profile'){
						return array('status' => true, 'message' => 'register', 'url' => bp_core_get_user_domain($existingUser[0]->ID));
					}else{
						return array('status' => true, 'message' => 'register');
					}
				}
				return array('status' => true, 'message' => '', 'url' => ($loginUrl == 'bp' ? bp_core_get_user_domain($existingUser[0]->ID) : ''));
			}
		}
	}else{
		// check if id in linked accounts
		global $wpdb;
		$existingInstagramUserId = '';
		if($oldInstagramUser){
			$existingInstagramUserId = $wpdb->get_var('SELECT user_id FROM ' . $wpdb->prefix . 'usermeta WHERE meta_key = "thechamp_linked_accounts" and meta_value LIKE "%'. $profileData['ig_id'] .'%"');
			$existingUserId = $existingInstagramUserId;
		}
		if(($oldInstagramUser && !$existingInstagramUserId) || !$oldInstagramUser){
			$existingSocialUserId = $wpdb->get_var('SELECT user_id FROM ' . $wpdb->prefix . 'usermeta WHERE meta_key = "thechamp_linked_accounts" and meta_value LIKE "%'. $profileData['id'] .'%"');
			$existingUserId = $existingSocialUserId;
		}
		if($existingUserId){
			if($existingInstagramUserId){
				$linkedAccounts = get_user_meta($existingUserId, 'thechamp_linked_accounts', true);
				$linkedAccounts = maybe_unserialize($linkedAccounts);
				$linkedAccounts['instagram'] = $profileData['id'];
				update_user_meta($existingUserId, 'thechamp_linked_accounts', maybe_serialize($linkedAccounts));
			}
			if(is_user_logged_in()){
				return array('status' => false, 'message' => 'not linked');
			}else{
				$error = the_champ_login_user($existingUserId, $profileData, $profileData['id'], true);
				if(isset($error) && $error === 0){
					return array('status' => false, 'message' => 'inactive', 'url' => wp_login_url() . '?loggedout=true&hum=1');
				}elseif(isset($error) && ($error == 'pending' || $error == 'denied')){
					return array('status' => false, 'message' => 'inactive', 'url' => wp_login_url() . '?heateor_ua=' . $error);
				}
				return array('status' => true, 'message' => '', 'url' => ($loginUrl == 'bp' ? bp_core_get_user_domain($existingUserId) : ''));
			}
		}
		// linking
		if(is_user_logged_in()){
			global $user_ID;
			$providerExists = $wpdb->get_var('SELECT user_id FROM ' . $wpdb->prefix . 'usermeta WHERE user_id = '. $user_ID .' and meta_key = "thechamp_linked_accounts" and meta_value LIKE "%'. $profileData['provider'] .'%"');
			if($providerExists){
				return array('status' => false, 'message' => 'provider exists');
			}else{
				the_champ_link_account($profileData['id'], $profileData['provider'], $user_ID);
				return array('status' => true, 'message' => 'linked');
			}
		}
		// if email is blank
		if(!isset($profileData['email']) || $profileData['email'] == ''){
			if(!isset($theChampLoginOptions['email_required']) || $theChampLoginOptions['email_required'] != 1){
				// generate dummy email
				$profileData['email'] = $profileData['id'].'@'.$provider.'.com';
			}else{
				// save temporary data
				if($twitterRedirect != ''){
					$profileData['twitter_redirect'] = $twitterRedirect;
				}
				$serializedProfileData = maybe_serialize($profileData);
				$uniqueId = mt_rand();
				update_user_meta($uniqueId, 'the_champ_temp_data', $serializedProfileData);
				the_champ_close_login_popup(home_url().'?SuperSocializerEmail=1&par='.$uniqueId);
			}
		}
		// check if email exists in the database
		if(isset($profileData['email']) && $userId = email_exists($profileData['email'])){
			// return if social login is disabled for admin accounts
			if(heateor_ss_check_if_admin($userId)){
				return array('status' => false, 'message' => '');
			}
			// email exists in WP DB
			$error = the_champ_login_user($userId, $profileData, isset($theChampLoginOptions['link_account']) ? $profileData['id'] : '', true);
			if(isset($error) && $error === 0){
				return array('status' => false, 'message' => 'inactive', 'url' => wp_login_url() . '?loggedout=true&hum=1');
			}elseif(isset($error) && ($error == 'pending' || $error == 'denied')){
				return array('status' => false, 'message' => 'inactive', 'url' => wp_login_url() . '?heateor_ua=' . $error);
			}
			if(isset($theChampLoginOptions['link_account'])){
				if(get_user_meta($userId, 'thechamp_social_id', true) == ''){
					update_user_meta($userId, 'thechamp_social_id', $profileData['id']);
					if(get_user_meta($userId, 'thechamp_provider', true) == ''){
						update_user_meta($userId, 'thechamp_provider', $profileData['provider']);
					}
				}else{
					the_champ_link_account($profileData['id'], $profileData['provider'], $userId);
				}
			}
			return array('status' => true, 'message' => '', 'url' => ($loginUrl == 'bp' ? bp_core_get_user_domain($userId) : ''));
		}
	}
	$customRedirection = apply_filters('the_champ_before_user_registration', '', $profileData);
	if($customRedirection){
		return $customRedirection;
	}
	do_action('the_champ_before_registration', $profileData);
	// register user
	$userId = the_champ_create_user($profileData);
	if($userId){
		$error = the_champ_login_user($userId, $profileData, $profileData['id'], false); 
		if(isset($error) && $error === 0){
			return array('status' => false, 'message' => 'inactive', 'url' => wp_login_url() . '?loggedout=true&hum=1');
		}elseif(isset($error) && ($error == 'pending' || $error == 'denied')){
			return array('status' => false, 'message' => 'inactive', 'url' => wp_login_url() . '?heateor_ua=' . $error);
		}elseif(isset($theChampLoginOptions['register_redirection']) && $theChampLoginOptions['register_redirection'] == 'bp_profile'){
			return array('status' => true, 'message' => 'register', 'url' => bp_core_get_user_domain($userId));
		}else{
			return array('status' => true, 'message' => 'register');
		}
	}
	return array('status' => false, 'message' => '');
}

/**
 * Link Social Account
 */
function the_champ_link_account($socialId, $provider, $userId){
	$linkedAccounts = get_user_meta($userId, 'thechamp_linked_accounts', true);
	if($linkedAccounts){
		$linkedAccounts = maybe_unserialize($linkedAccounts);
	}else{
		$linkedAccounts = array();
	}
	$linkedAccounts[$provider] = $socialId;
	update_user_meta($userId, 'thechamp_linked_accounts', maybe_serialize($linkedAccounts));
}

/**
 * Ask email in a popup
 */
function the_champ_ask_email(){
	global $theChampLoginOptions;
	echo isset($theChampLoginOptions['email_popup_text']) && $theChampLoginOptions['email_popup_text'] != '' ? '<div style="margin-top: 5px">'.esc_html($theChampLoginOptions['email_popup_text']).'</div>' : ''; ?>
	<style type="text/css">
		div.tb-close-icon{ display: none }
	</style>
	<div id="the_champ_error" style="margin: 2px 0px;"></div>
	<div style="margin: 6px 0 15px 0;"><input placeholder="<?php _e('Email', 'super-socializer') ?>" type="text" id="the_champ_email" /></div>
	<div style="margin: 6px 0 15px 0;"><input placeholder="<?php _e('Confirm email', 'super-socializer') ?>" type="text" id="the_champ_confirm_email" /></div>
	<div>
		<button type="button" id="save" onclick="the_champ_save_email(this)"><?php _e('Save', 'super-socializer') ?></button>
		<button type="button" id="cancel" onclick="the_champ_save_email(this)"><?php _e('Cancel', 'super-socializer') ?></button>
	</div>
	<?php
	die;
}
add_action('wp_ajax_nopriv_the_champ_ask_email', 'the_champ_ask_email');

/**
 * Save email submitted in popup
 */
function the_champ_save_email(){
	if(isset($_POST['elemId'])){
		$elementId = sanitize_text_field($_POST['elemId']);
		if(isset($_POST['id']) && ($id = intval(trim($_POST['id']))) != ''){
			if($elementId == 'save'){
				global $theChampLoginOptions;
				$email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
				// validate email
				if(is_email($email) && !email_exists($email)){
					if(($tempData = get_user_meta($id, 'the_champ_temp_data', true)) != ''){
						delete_user_meta($id, 'the_champ_temp_data');
						// get temp data unserialized
						$tempData = maybe_unserialize($tempData);
						$tempData['email'] = $email;
						if(isset($theChampLoginOptions['email_verification']) && $theChampLoginOptions['email_verification'] == 1){
							$verify = true;
						}else{
							$verify = false;
						}
						$customRedirection = apply_filters('the_champ_before_user_registration', '', $tempData);
						if($customRedirection){
							the_champ_ajax_response($customRedirection);
						}
						do_action('the_champ_before_registration', $tempData);
						// create new user
						$userId = the_champ_create_user($tempData, $verify);
						if($userId && !$verify){
							// login user
							$tempData['askemail'] = 1;
							$error = the_champ_login_user($userId, $tempData, $tempData['id']);
							if(isset($error) && $error === 0){
								the_champ_ajax_response(array('status' => false, 'message' => 'inactive', 'url' => wp_login_url() . '?loggedout=true&hum=1'));
							}elseif(isset($error) && ($error == 'pending' || $error == 'denied')){
								the_champ_ajax_response(array('status' => false, 'message' => 'inactive', 'url' => wp_login_url() . '?heateor_ua=' . $error));
							}elseif(isset($theChampLoginOptions['register_redirection']) && $theChampLoginOptions['register_redirection'] == 'same' && isset($tempData['twitter_redirect'])){
								the_champ_ajax_response(array('status' => 1, 'message' => array('response' => 'success', 'url' => $tempData['twitter_redirect'])));
							}elseif(isset($theChampLoginOptions['register_redirection']) && $theChampLoginOptions['register_redirection'] == 'bp_profile'){
								the_champ_ajax_response(array('status' => 1, 'message' => array('response' => 'success', 'url' => bp_core_get_user_domain($userId))));
							}else{
								the_champ_ajax_response(array('status' => 1, 'message' => 'success'));
							}
						}elseif($userId && $verify){
							$verificationKey = $userId.time().mt_rand();
							update_user_meta($userId, 'thechamp_key', $verificationKey);
							update_user_meta($userId, 'thechamp_social_registration', 1);
							the_champ_send_verification_email($email, $verificationKey);
							the_champ_ajax_response(array('status' => 1, 'message' => 'verify'));
						}
					}
				}else{
					the_champ_ajax_response(array('status' => 0, 'message' => isset($theChampLoginOptions['email_error_message']) ? __($theChampLoginOptions['email_error_message'], 'super-socializer') : ''));
				}
			}
			// delete temporary data
			delete_user_meta($id, 'the_champ_temp_data');
			the_champ_ajax_response(array('status' => 1, 'message' => 'cancelled'));
		}
	}
	die;
}
add_action('wp_ajax_nopriv_the_champ_save_email', 'the_champ_save_email');

/**
 * Send verification email to user.
 */
function the_champ_send_verification_email($receiverEmail, $verificationKey){
	$subject = "[".wp_specialchars_decode(trim(get_option('blogname')), ENT_QUOTES)."] " . __('Email Verification', 'super-socializer');
	$url = esc_url_raw(home_url())."?SuperSocializerKey=".$verificationKey;
	$message = __("Please click on the following link or paste it in browser to verify your email", 'super-socializer') . "\r\n" . $url;
	wp_mail($receiverEmail, $subject, $message);
}

/**
 * Prevent Social Login if registration is disabled
 */
function heateor_ss_disable_social_registration($profileData){
	global $theChampLoginOptions;
	if(isset($theChampLoginOptions['disable_reg'])){
		$redirectionUrl = home_url();
		if(isset($theChampLoginOptions['disable_reg_redirect']) && $theChampLoginOptions['disable_reg_redirect'] != ''){
			$redirectionUrl = $theChampLoginOptions['disable_reg_redirect'];
		}
		the_champ_close_login_popup($redirectionUrl);
	}
}
add_action('the_champ_before_registration', 'heateor_ss_disable_social_registration', 10, 1);

/**
 * Send new user notification email
 */
function heateor_ss_new_user_notification($userId){
	global $theChampLoginOptions;
	$notificationType = '';
	if(isset($theChampLoginOptions['password_email'])){
		$notificationType = 'both';
	}elseif(isset($theChampLoginOptions['new_user_admin_email'])){
		$notificationType = 'admin';
	}
	if($notificationType){
		if(class_exists('WC_Emails') && $notificationType == 'both'){
			$wc_emails = WC_Emails::instance();
			$wc_emails->customer_new_account($userId);
		}
		wp_new_user_notification($userId, null, $notificationType);
	}
}

/**
 * Show message after Social Login if approval pending
 */
function heateor_ss_custom_login_message($message){
	if(isset($_GET['heateor_ua'])){
    	if($_GET['heateor_ua'] == 'denied'){
            $message = __('<strong>ERROR</strong>: Your account has been denied access to this site.', 'new-user-approve');
            $message = apply_filters('new_user_approve_denied_error', $message);
        }
        if($_GET['heateor_ua'] == 'pending'){
            $message = __('<strong>ERROR</strong>: Your account is still pending approval.', 'new-user-approve');
            $message = apply_filters('new_user_approve_pending_error', $message);
        }
        return '<div id="login_error">' . $message . '</div>';
    }
    return $message;
}
add_filter('login_message', 'heateor_ss_custom_login_message'); 