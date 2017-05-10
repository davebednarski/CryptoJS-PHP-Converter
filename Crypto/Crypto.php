<?php

namespace Crypto;


class Crypto
{
	// cypher method
	const AES_256_CBC = 'aes-256-cbc';

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

		// pbkdf2 spec recommended salt minimum size is 64 bits.  Below is minimum.
		$salt = openssl_random_pseudo_bytes(8);

		// Initialization vector
		$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(self::AES_256_CBC));

		// This value is low and should be as high as possible without taking up too much server cycles.
		$iterations = 1000;

		// Generate a key "key stretching" that encrypt will be ok with based off your password.
		$key = hash_pbkdf2('sha512', $password, $salt, $iterations, 64);

		$encrypted_data = openssl_encrypt(json_encode($data), self::AES_256_CBC, hex2bin($key), OPENSSL_RAW_DATA, $iv);

		$formattedData = $this->cryptoJsFormatter($encrypted_data, $iv, $salt, $iterations);

		return json_encode($formattedData);
	}

	/**
	 * Format for CryptoJS compatibility
	 * @param $encrypted_data
	 * @param $iv
	 * @param $salt
	 * @param $iterations
	 * @return array
	 */
	private function cryptoJsFormatter($encrypted_data, $iv, $salt, $iterations) {
		return array(
			"cipherText" => base64_encode($encrypted_data),
			"iv" => bin2hex($iv),
			"salt" => bin2hex($salt),
			"iter" => base64_encode($iterations)
		);
	}
}