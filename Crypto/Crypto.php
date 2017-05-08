<?php

namespace Crypto;


class Crypto
{

	function __construct()
	{
	}

	/**
	 * Encrypt value to a cryptojs compatiable json encoding string
	 * @param $data
	 * @param $password
	 * @return string
	 */
	public function encrypt($data, $password){
		$salt = openssl_random_pseudo_bytes(8);
		$salted = '';
		$dx = '';

		while (strlen($salted) < 48) {
			$dx = md5($dx.$password.$salt, true);
			$salted .= $dx;
		}

		$key = substr($salted, 0, 32);
		$iv  = substr($salted, 32, 16);

//		$iv = openssl_random_pseudo_bytes(16);
//		$salt = openssl_random_pseudo_bytes(8);

		$encrypted_data = openssl_encrypt(json_encode($data), 'aes-256-cbc', $key, true, $iv);
		$formattedData = $this->cryptoJsFormatter($encrypted_data, $iv, $salt);

		return json_encode($formattedData);
	}

	/**
	 * Format for CryptoJS compatibility
	 * @param $encrypted_data
	 * @param $iv
	 * @param $salt
	 * @return array
	 */
	private function cryptoJsFormatter($encrypted_data, $iv, $salt) {
		return array(
			"ct" => base64_encode($encrypted_data),
			"iv" => bin2hex($iv),
			"s" => bin2hex($salt)
		);
	}
}