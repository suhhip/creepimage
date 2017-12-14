<?php
namespace App;

class DataEncrytion implements Interfaces\DataEncryption
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
     * {@inheritDoc}
     * @see \App\Interfaces\DataEncryption::setRawData()
     */
	public function setRawData($data)
	{
		$this->rawData = $data;
	}

    /**
     * {@inheritDoc}
     * @see \App\Interfaces\DataEncryption::setEncryptedData()
     */
	public function setEncryptedData($data)
	{
		$this->encryptedData = $data;
	}

    /**
     * {@inheritDoc}
     * @see \App\Interfaces\DataEncryption::getLength()
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
     * {@inheritDoc}
     * @see \App\Interfaces\DataEncryption::encrypt()
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
     * {@inheritDoc}
     * @see \App\Interfaces\DataEncryption::decrypt()
     */
	public function decrypt($password = '')
	{
	    if (empty($this->encryptedData)) {
	        return false;
        }

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
}
