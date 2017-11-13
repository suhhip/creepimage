<?php
namespace App;

class DataEncrytion
{
	/**
	 * @var string   Raw data
	 */
	private $rawData;

	/**
	 * @var string   Encrypted data
	 */
	private $encryptedData;

	/**
	 * Set raw data
	 *
	 * @param string $data   Raw data
	 *
	 * @return void
	 */
	public function setRawData($data)
	{
		$this->rawData = $data;

		return;
	}

	/**
	 * Set encrypted data
	 *
	 * @param string $data   Encrypted string
	 *
	 * @return void
	 */
	public function setEncryptedData($data)
	{
		$this->encryptedData = $data;

		return;
	}

	/**
	 * Calculate encrypted data length from the raw data
	 *
	 * @return integer
	 */
	public function getLength()
	{
		if (!$this->rawData) {
			return 0;
		}

		$length = strlen($this->rawData);

		$x = 16 + 32 + ceil(($length + 1) / 16) * 16;
		$x = $x * 8 / 6;
		$x = ceil($x / 8) * 8;

		return $x;
	}

	/**
	 * Calculate max raw data size when outbut size is limited
	 *
	 * @param integer $inBytes
	 *
	 * @return integer
	 */
	public static function calculateMaxLength($inBytes)
	{
		$x = floor($inBytes * 6 / 8);
		$x = $x - 16 - 32;

		if ($x < 0) {
			$x = 0;
		}

		return $x;
	}

	/**
	 * Encrypt method
	 *
	 * @param string $password   Password
	 *
	 * @return string   Coded string
	 */
	public function encrypt($password = '')
	{
		$ivlen   = openssl_cipher_iv_length($cipher = 'AES-128-CBC');
		$iv      = openssl_random_pseudo_bytes($ivlen);

		$cryptedRaw   = openssl_encrypt($this->rawData, $cipher, $password, $options = OPENSSL_RAW_DATA, $iv);
		$hmac         = hash_hmac('sha256', $cryptedRaw, $password, $as_binary = true);

		$this->encryptedData = base64_encode($iv . $hmac . $cryptedRaw);

		return $this->encryptedData;
	}

	/**
	 * Decrypt method
	 *
	 * @param string $password   Password
	 *
	 * @return boolean|string
	 */
	public function decrypt($password = '')
	{
		$c = base64_decode($this->encryptedData);

		$ivlen   = openssl_cipher_iv_length($cipher = 'AES-128-CBC');
		$iv      = substr($c, 0, $ivlen);
		$hmac    = substr($c, $ivlen, $sha2len = 32);

		$ciphertextRaw = substr($c, $ivlen + $sha2len);

		$calcmac = hash_hmac('sha256', $ciphertextRaw, $password, $as_binary = true);
		if (!@hash_equals($hmac, $calcmac)) {
			return false;
		}

		$this->rawData = openssl_decrypt($ciphertextRaw, $cipher, $password, $options = OPENSSL_RAW_DATA, $iv);

		return $this->rawData;
	}
}
