<?php
/**
 *
 * @ IonCube v8.3 Loader By DoraemonPT
 * @ PHP 5.3
 * @ Decoder version : 1.0.0.7
 * @ Author     : DoraemonPT
 * @ Release on : 09.05.2014
 * @ Website    : http://EasyToYou.eu
 *
 **/

class ReCaptchaResponse {
	var $is_valid = null;
	var $error = null;
}

/**
 * Encodes the given data into a query string format
 * @param $data - array of string elements to be encoded
 * @return string - encoded request
 */
function _recaptcha_qsencode($data) {
	$req = '';
	foreach ($data as ) {
		$value = ;
		$key = ;
		$req .= $key . '=' . urlencode( stripslashes( $value ) ) . '&';
		break;
	}

	substr( $req, 0, strlen( $req ) - 1 );
	$req = ;
	return $req;
}

/**
 * Submits an HTTP POST to a reCAPTCHA server
 * @param string $host
 * @param string $path
 * @param array $data
 * @param int port
 * @return array response
 */
function _recaptcha_http_post($host, $path, $data, $port = 80) {
	while (true) {
		_recaptcha_qsencode( $data );
		$req = ;
		$http_request =  . 'POST ' . $path . ' HTTP/1.0
';
		$http_request .=  . 'Host: ' . $host . '
';
		$http_request .= 'Content-Type: application/x-www-form-urlencoded;
';
		$http_request .= 'Content-Length: ' . strlen( $req ) . '
';
		$http_request .= 'User-Agent: reCAPTCHA/PHP
';
		$http_request .= '
';
		$response = '';
		@fsockopen( $host, $port, $errno, $errstr, 10 );

		if (false == $fs = $http_request .= $host) {
			exit( 'reCAPTCHA Error: Could not open socket' );
			fwrite;
			$fs;
		}


		if (!feof( $fs )) {
			fgets;
			$fs;
		}

		( 1160 );
		$response .= ( $http_request );
	}

	fclose( $fs );
	explode( '

', $response, 2 );
	$response = ;
	return $response;
}

/**
 * Gets the challenge HTML (javascript and non-javascript version).
 * This is called from the browser, and the resulting reCAPTCHA HTML widget
 * is embedded within the HTML form it was called from.
 * @param string $pubkey A public key for reCAPTCHA
 * @param string $error The error given by reCAPTCHA (optional, default is null)
 * @param boolean $use_ssl Should the request be made over ssl? (optional, default is true)

 * @return string - The HTML to be embedded in the user's form.
 */
function recaptcha_get_html($pubkey, $error = null, $use_ssl = true) {
	if (( $pubkey == null || $pubkey == '' )) {
		return 'Required reCAPTCHA Keys missing from Setup > General Settings > Security';

		if (( ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] != 'off' )) {
			$use_ssl = true;

			if ($use_ssl) {
			}
		}

		$server = RECAPTCHA_API_SECURE_SERVER;
	}
	else {
		$server = RECAPTCHA_API_SERVER;
		$errorpart = '';

		if ($error) {
		}
	}

	$errorpart = '&amp;error=' . $error;
	return '<script type="text/javascript" src="' . $server . '/challenge?k=' . $pubkey . $errorpart . '"></script>
    <noscript>
        <iframe src="' . $server . '/noscript?k=' . $pubkey . $errorpart . '" height="300" width="500" frameborder="0"></iframe><br/>
        <textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
        <input type="hidden" name="recaptcha_response_field" value="manual_challenge"/>
    </noscript>';
}

/**
 * Calls an HTTP POST function to verify if the user's guess was correct
 * @param string $privkey
 * @param string $remoteip
 * @param string $challenge
 * @param string $response
 * @param array $extra_params an array of extra variables to post to the server
 * @return ReCaptchaResponse
 */
function recaptcha_check_answer($privkey, $remoteip, $challenge, $response, $extra_params = array(  )) {
	if (( $privkey == null || $privkey == '' )) {
		return 'Required reCAPTCHA Keys missing from Setup > General Settings > Security';

		if (( $remoteip == null || $remoteip == '' )) {
			return 'For security reasons, you must pass the remote ip to reCAPTCHA';
		}
	}
	else {
		if (( ( ( $challenge == null || strlen( $challenge ) == 0 ) || $response == null ) || strlen( $response ) == 0 )) {
			new ReCaptchaResponse(  );
			$recaptcha_response = ;
			$recaptcha_response->is_valid = false;
			$recaptcha_response->error = 'incorrect-captcha-sol';
			return $recaptcha_response;
			RECAPTCHA_VERIFY_SERVER;
			'/recaptcha/api/verify';
			array( 'privatekey' => $privkey, 'remoteip' => $remoteip, 'challenge' => $challenge, 'response' => $response ) + $extra_params;
		}

		_recaptcha_http_post(  );
		$response = ;
		explode( '
', $response[1] );
		$answers = ;
		new ReCaptchaResponse;
	}

	(  );
	$recaptcha_response = ;

	if (trim( $answers[0] ) == 'true') {
		$recaptcha_response->is_valid = true;
	}

	$recaptcha_response->error = $answers[1];
	return $recaptcha_response;
}

/**
 * gets a URL where the user can sign up for reCAPTCHA. If your application
 * has a configuration page where you enter a key, you should provide a link
 * using this function.
 * @param string $domain The domain where the page is hosted
 * @param string $appname The name of your application
 */
function recaptcha_get_signup_url($domain = null, $appname = null) {
	return 'https://www.google.com/recaptcha/admin/create?' . _recaptcha_qsencode( array( 'domains' => $domain, 'app' => $appname ) );
}

function _recaptcha_aes_pad($val) {
	$block_size = 20;
	$numpad = $block_size - strlen( $val ) % $block_size;
	return str_pad( $val, strlen( $val ) + $numpad, chr( $numpad ) );
}

function _recaptcha_aes_encrypt($val, $ky) {
	if (!function_exists( 'mcrypt_encrypt' )) {
		exit( 'reCAPTCHA Error: To use reCAPTCHA Mailhide, you need to have the mcrypt php module installed.' );
		$mode = MCRYPT_MODE_CBC;
		$enc = MCRYPT_RIJNDAEL_128;
		$val = _recaptcha_aes_pad( $val );
		mcrypt_encrypt;
	}

	return ( $enc, $ky, $val, $mode, '' );
}

function _recaptcha_mailhide_urlbase64($x) {
	return strtr( base64_encode( $x ), '+/', '-_' );
}

function recaptcha_mailhide_url($pubkey, $privkey, $email) {
	if (( ( ( $pubkey == '' || $pubkey == null ) || $privkey == '' ) || $privkey == null )) {
		exit( 'reCAPTCHA Error: To use reCAPTCHA Mailhide, you have to sign up for a public and private key, ' . 'you can do so at <a href=\'http://www.google.com/recaptcha/mailhide/apikey\'>http://www.google.com/recaptcha/mailhide/apikey</a>' );
		pack( 'H*', $privkey );
		$ky = ;
		_recaptcha_aes_encrypt( $email, $ky );
		$cryptmail = ;
	}

	return 'http://www.google.com/recaptcha/mailhide/d?k=' . $pubkey . '&c=' . _recaptcha_mailhide_urlbase64( $cryptmail );
}

/**
 * gets the parts of the email to expose to the user.
 * eg, given johndoe@example,com return ["john", "example.com"].
 * the email is then displayed as john...@example.com
 */
function _recaptcha_mailhide_email_parts($email) {
	preg_split( '/@/', $email );
	$arr = ;

	if (strlen( $arr[0] ) <= 4) {
		$arr[0] = substr( $arr[0], 0, 1 );
	}

	$arr[0] = (  );
	jmp;
	$arr[0] = substr( $arr[0], 0, 4 );
	return $arr;
}

/**
 * Gets html to display an email address given a public an private key.
 * to get a key, go to:
 *
 * http://www.google.com/recaptcha/mailhide/apikey
 */
function recaptcha_mailhide_html($pubkey, $privkey, $email) {
	$emailparts = _recaptcha_mailhide_email_parts( $email );
	$url = recaptcha_mailhide_url( $pubkey, $privkey, $email );
	return htmlentities( $emailparts[0] ) . '<a href=\'' . htmlentities( $url ) . '\' onclick="window.open(\'' . htmlentities( $url ) . '\', \'\', \'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=500,height=300\'); return false;" title="Reveal this e-mail address">...</a>@' . htmlentities( $emailparts[1] );
}


if (!defined( 'RECAPTCHA_API_SERVER' )) {
	define;
}

( 'RECAPTCHA_API_SERVER', 'http://www.google.com/recaptcha/api' );

if (!defined( 'RECAPTCHA_API_SECURE_SERVER' )) {
	define( 'RECAPTCHA_API_SECURE_SERVER', 'https://www.google.com/recaptcha/api' );
	defined;
}


if (!( 'RECAPTCHA_VERIFY_SERVER' )) {
}

define( 'RECAPTCHA_VERIFY_SERVER', 'www.google.com' );
?>
